<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Student;
use App\Models\IEPGoal;
use App\Models\BehaviourRecord;
use App\Models\ProgressRecord;
use App\Models\Consultation;
use App\Models\IEPReview;
use App\Models\ConsentLetter;
use App\Models\Notification;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::create([
            'user_id' => 'ADMIN001',
            'name' => 'GPK PPKI SK Kuala Berang',
            'email' => 'admin@skkb.edu.my',
            'role' => 'school_admin',
            'password' => Hash::make('12345'),
        ]);

        $teacher = User::create([
            'user_id' => 'TEACHER001',
            'name' => 'Pn Azizah Binti Said',
            'email' => 'teacher@skkb.edu.my',
            'role' => 'teacher',
            'password' => Hash::make('12345'),
        ]);

        $counsellor = User::create([
            'user_id' => 'COUNSELLOR001',
            'name' => 'Pn Rohaya Binti Wahab',
            'email' => 'counsellor@skkb.edu.my',
            'role' => 'counsellor',
            'password' => Hash::make('12345'),
        ]);

        $parent = User::create([
            'user_id' => 'PARENT001',
            'name' => 'Sheikh Abdul Rahim',
            'email' => 'parent@example.com',
            'phone' => '011-0000000',
            'identification_card' => '800101-11-1234',
            'address' => 'Kuala Berang, Terengganu',
            'role' => 'parent',
            'password' => Hash::make('12345'),
        ]);

        $sysadmin = User::create([
            'user_id' => 'SYSADMIN001',
            'name' => 'System Administrator',
            'email' => 'sysadmin@skkb.edu.my',
            'role' => 'system_admin',
            'password' => Hash::make('12345'),
        ]);

        $students = [
            ['Sheikh Dinan', '2 Cemerlang', 'Completed'],
            ['Faris Sabry', '2 Bestari', 'Parent Consent'],
            ['Aisyah Farhana', '2 Dinamik', 'Counsellor Review'],
        ];

        foreach ($students as $index => $row) {
            $student = Student::create([
                'student_name' => $row[0],
                'student_ic' => '0' . ($index + 1) . '0101-11-1234',
                'class_name' => $row[1],
                'gender' => $index == 2 ? 'Female' : 'Male',
                'date_of_birth' => '2016-01-01',
                'category' => 'Masalah Pembelajaran',
                'programme_type' => 'Program Pendidikan Khas Integrasi',
                'diagnosis' => 'Kurang Upaya Intelektual',
                'existing_knowledge' => 'Can follow simple instructions with guidance.',
                'student_ability' => 'Able to communicate basic needs and participate in classroom activities.',
                'parent_name' => $index == 0 ? 'Sheikh Abdul Rahim' : 'Parent / Guardian',
                'parent_phone' => '011-0000000',
                'parent_email' => 'parent@example.com',
                'parent_user_id' => $index == 0 ? $parent->id : null,
                'teacher_id' => $teacher->id,
                'counsellor_id' => $counsellor->id,
                'status' => $row[2],
            ]);

            IEPGoal::create([
                'student_id' => $student->id,
                'curriculum_followed' => 'KSSRPK Tahun 3',
                'iep_focus' => 'Akademik',
                'main_challenges' => 'Low classroom participation and communication skills.',
                'long_term_goals' => 'Improve classroom participation and communication skills.',
                'short_term_goals' => 'Respond to simple questions and join structured activities.',
                'intervention_strategy' => 'Structured classroom activity with teacher support.',
                'achievement' => 'Improving gradually.',
                'start_date' => now()->startOfYear(),
                'review_date' => now()->addMonths(3),
                'status' => $row[2] === 'Completed' ? 'Completed' : 'In Progress',
            ]);

            BehaviourRecord::create([
                'student_id' => $student->id,
                'record_date' => now(),
                'behaviour_type' => 'Positive',
                'description' => 'Student participated in class activity.',
                'points' => 5,
                'recorded_by' => $teacher->id,
            ]);

            ProgressRecord::create([
                'student_id' => $student->id,
                'progress_date' => now(),
                'progress_status' => 'Good',
                'progress_notes' => 'Student shows improvement during classroom activity.',
                'positive_updates' => 15,
                'need_monitoring' => 4,
                'recorded_by' => $teacher->id,
            ]);

            Consultation::create([
                'student_id' => $student->id,
                'case_title' => 'Low Participation',
                'priority' => $index == 0 ? 'Medium' : 'High',
                'consultation_notes' => 'Counsellor will monitor and provide support plan.',
                'support_plan' => 'Behaviour and communication support activity.',
                'support_type' => 'Behaviour Support',
                'review_date' => now()->addMonth(),
                'recorded_by' => $counsellor->id,
                'status' => 'Pending',
            ]);

            IEPReview::create([
                'student_id' => $student->id,
                'review_date' => now(),
                'review_status' => $row[2] === 'Completed' ? 'Completed' : 'Scheduled',
                'review_notes' => 'IEP review scheduled for follow-up.',
                'next_review_date' => now()->addMonths(3),
                'reviewed_by' => $counsellor->id,
            ]);

            ConsentLetter::create([
                'student_id' => $student->id,
                'parent_name' => $student->parent_name,
                'parent_ic' => '800101-11-1234',
                'student_ic' => $student->student_ic,
                'consent_date' => now(),
                'agreement_text' => 'Parent agrees with the implementation of the Individual Education Plan.',
                'status' => 'Approved',
            ]);
        }

        Notification::create([
            'user_id' => $admin->id,
            'title' => 'Welcome',
            'message' => 'IEP Management System SKKB is ready to use.',
        ]);
    }
}
