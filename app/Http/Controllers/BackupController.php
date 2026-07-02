<?php

namespace App\Http\Controllers;

use App\Models\BackupLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Throwable;

class BackupController extends Controller
{
    public function index()
    {
        $backups = BackupLog::latest('backup_date')->get();

        return view('backup.index', compact('backups'));
    }

    public function store(Request $request)
    {
        $tables = [
            'users',
            'students',
            'iep_goals',
            'behaviour_records',
            'progress_records',
            'consultations',
            'iep_reviews',
            'consent_letters',
            'notifications',
            'backup_logs',
        ];

        try {
            $payload = [
                'application' => config('app.name'),
                'created_at' => now()->toIso8601String(),
                'database_connection' => config('database.default'),
                'tables' => [],
            ];

            foreach ($tables as $table) {
                if (Schema::hasTable($table)) {
                    $payload['tables'][$table] = DB::table($table)->get()->all();
                }
            }

            $filename = 'backups/iep_skkb_' . now()->format('Ymd_His') . '.json';

            Storage::disk('local')->put(
                $filename,
                json_encode($payload, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)
            );

            BackupLog::create([
                'backup_date' => now(),
                'backup_name' => basename($filename),
                'performed_by' => auth()->id(),
                'notes' => __('messages.backup_created_successfully'),
            ]);

            return back()->with('success', __('messages.backup_created_successfully'));
        } catch (Throwable $exception) {
            report($exception);

            return back()->withErrors([
                'backup' => __('messages.backup_failed'),
            ]);
        }
    }
}
