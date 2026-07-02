<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Support\StudentAccess;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ReportController extends Controller
{
    public function index()
    {
        $students = StudentAccess::queryFor(auth()->user())
            ->orderBy('student_name')
            ->get();

        return view('reports.index', compact('students'));
    }

    public function print(Request $request)
    {
        $request->validate(['student_id' => ['required', 'exists:students,id']]);

        $student = Student::with([
            'teacher',
            'counsellor',
            'goals',
            'progressRecords',
            'behaviours',
            'consultations',
            'reviews',
            'consents',
        ])->findOrFail($request->student_id);

        StudentAccess::authorizeView(auth()->user(), $student);

        return view('reports.print', compact('student'));
    }

    public function consentPdf(Request $request)
    {
        $request->validate(['student_id' => ['required', 'exists:students,id']]);

        $student = Student::with('consents')->findOrFail($request->student_id);
        StudentAccess::authorizeView(auth()->user(), $student);
        $consent = $student->consents()->latest()->first();

        $lines = [
            __('messages.system_title'),
            'Sekolah Kebangsaan Kuala Berang',
            '',
            __('messages.implementation_iep'),
            '',
            __('messages.consent_statement_1'),
            __('messages.consent_statement_2'),
            '',
            __('messages.student_name') . ': ' . ($student->student_name ?? '-'),
            __('messages.class') . ': ' . ($student->class_name ?? '-'),
            __('messages.student_identification_card_number') . ': ' . ($consent->student_ic ?? $student->student_ic ?? '-'),
            __('messages.parent_guardian_full_name') . ': ' . ($consent->parent_name ?? $student->parent_name ?? '-'),
            __('messages.identification_card_number') . ': ' . ($consent->parent_ic ?? '-'),
            __('messages.consent_date') . ': ' . ($consent->consent_date ?? now()->format('Y-m-d')),
            __('messages.status') . ': ' . ($consent->status ?? __('messages.approved')),
            '',
            __('messages.agreement_text') . ':',
            $consent->agreement_text ?? 'I agree with the implementation of the Individual Education Plan as planned by the school.',
            '',
            '_______________________________',
            __('messages.parent_guardian'),
        ];

        $pdf = $this->createSimplePdf($lines);
        $filename = 'consent_letter_' . Str::slug($student->student_name) . '.pdf';

        return response($pdf, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . $filename . '"',
        ]);
    }

    private function createSimplePdf(array $lines): string
    {
        $stream = "q\nBT\n";
        $y = 790;

        foreach ($lines as $index => $line) {
            $font = $index === 0 || $line === __('messages.implementation_iep') ? '/F2 16 Tf' : '/F1 11 Tf';
            $x = $index === 0 ? 90 : 55;

            if ($line === '') {
                $y -= 16;
                continue;
            }

            foreach ($this->wrapPdfLine($line, 82) as $wrapped) {
                $stream .= $font . "\n1 0 0 1 {$x} {$y} Tm\n(" . $this->escapePdfText($wrapped) . ") Tj\n";
                $y -= 17;
            }

            if ($index === 0 || $line === __('messages.implementation_iep')) {
                $y -= 8;
            }
        }

        $stream .= "ET\nQ\n";

        $objects = [
            '<< /Type /Catalog /Pages 2 0 R >>',
            '<< /Type /Pages /Kids [3 0 R] /Count 1 >>',
            '<< /Type /Page /Parent 2 0 R /MediaBox [0 0 595 842] /Resources << /Font << /F1 4 0 R /F2 5 0 R >> >> /Contents 6 0 R >>',
            '<< /Type /Font /Subtype /Type1 /BaseFont /Helvetica >>',
            '<< /Type /Font /Subtype /Type1 /BaseFont /Helvetica-Bold >>',
            '<< /Length ' . strlen($stream) . ">>\nstream\n" . $stream . "endstream",
        ];

        $pdf = "%PDF-1.4\n";
        $offsets = [0];

        foreach ($objects as $i => $object) {
            $offsets[] = strlen($pdf);
            $pdf .= ($i + 1) . " 0 obj\n" . $object . "\nendobj\n";
        }

        $xref = strlen($pdf);
        $pdf .= "xref\n0 " . (count($objects) + 1) . "\n";
        $pdf .= "0000000000 65535 f \n";

        for ($i = 1; $i <= count($objects); $i++) {
            $pdf .= str_pad((string) $offsets[$i], 10, '0', STR_PAD_LEFT) . " 00000 n \n";
        }

        $pdf .= "trailer\n<< /Size " . (count($objects) + 1) . " /Root 1 0 R >>\nstartxref\n" . $xref . "\n%%EOF";

        return $pdf;
    }

    private function wrapPdfLine(string $line, int $width): array
    {
        $line = preg_replace('/[^\x20-\x7E]/', '', $line);
        $words = explode(' ', $line);
        $rows = [];
        $current = '';

        foreach ($words as $word) {
            if (strlen($current . ' ' . $word) > $width) {
                $rows[] = trim($current);
                $current = $word;
            } else {
                $current .= ' ' . $word;
            }
        }

        if (trim($current) !== '') {
            $rows[] = trim($current);
        }

        return $rows ?: [''];
    }

    private function escapePdfText(string $text): string
    {
        return str_replace(['\\', '(', ')'], ['\\\\', '\\(', '\\)'], $text);
    }
}
