<?php

namespace Tests\Feature;

use App\Models\Student;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class RoleWorkflowTest extends TestCase
{
    use RefreshDatabase;

    public function test_valid_parent_can_register_and_is_linked_to_the_correct_student(): void
    {
        $student = Student::factory()->create([
            'student_name' => 'Aisyah Farhana',
            'student_ic' => '160101-11-1234',
            'parent_user_id' => null,
        ]);

        $response = $this->post(route('parent.register.store'), [
            'full_name' => 'Nur Aina Binti Ali',
            'identification_card' => '850101-11-1234',
            'phone' => '0123456789',
            'address' => 'Kuala Berang, Terengganu',
            'email' => 'aina@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'student_name' => 'Aisyah Farhana',
            'student_ic' => '160101-11-1234',
        ]);

        $response->assertRedirect(route('login'));
        $parent = User::where('email', 'aina@example.com')->firstOrFail();

        $this->assertSame('parent', $parent->role);
        $this->assertStringStartsWith('PARENT', $parent->user_id);
        $this->assertTrue(Hash::check('password123', $parent->password));
        $this->assertSame($parent->id, $student->fresh()->parent_user_id);
        $this->assertSame($parent->name, $student->fresh()->parent_name);
    }

    public function test_registration_fails_when_student_information_does_not_match(): void
    {
        Student::factory()->create([
            'student_name' => 'Correct Student',
            'student_ic' => '160101-11-1234',
        ]);

        $response = $this->from(route('parent.register'))->post(route('parent.register.store'), [
            'full_name' => 'Parent Name',
            'identification_card' => '850101-11-9999',
            'phone' => '0123456789',
            'address' => 'Kuala Berang',
            'email' => 'parent@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'student_name' => 'Wrong Student',
            'student_ic' => '160101-11-1234',
        ]);

        $response->assertRedirect(route('parent.register'));
        $response->assertSessionHasErrors('student_name');
        $this->assertDatabaseMissing('users', ['email' => 'parent@example.com']);
    }

    public function test_registration_fails_when_student_is_already_linked(): void
    {
        $existingParent = User::factory()->parent()->create();
        Student::factory()->create([
            'student_name' => 'Linked Student',
            'student_ic' => '160101-11-2222',
            'parent_user_id' => $existingParent->id,
        ]);

        $response = $this->from(route('parent.register'))->post(route('parent.register.store'), [
            'full_name' => 'Second Parent',
            'identification_card' => '850101-11-3333',
            'phone' => '0123456789',
            'address' => 'Kuala Berang',
            'email' => 'second@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'student_name' => 'Linked Student',
            'student_ic' => '160101-11-2222',
        ]);

        $response->assertSessionHasErrors('student_ic');
        $this->assertDatabaseMissing('users', ['email' => 'second@example.com']);
    }

    public function test_parent_can_log_in_using_email(): void
    {
        $parent = User::factory()->parent()->create([
            'email' => 'parent.login@example.com',
            'password' => Hash::make('password123'),
        ]);

        $response = $this->post(route('login.submit'), [
            'login' => 'parent.login@example.com',
            'password' => 'password123',
        ]);

        $response->assertRedirect(route('dashboard'));
        $this->assertAuthenticatedAs($parent);
    }

    public function test_parent_can_log_in_using_user_id(): void
    {
        $parent = User::factory()->parent()->create([
            'user_id' => 'PARENT0099',
            'password' => Hash::make('password123'),
        ]);

        $response = $this->post(route('login.submit'), [
            'login' => 'PARENT0099',
            'password' => 'password123',
        ]);

        $response->assertRedirect(route('dashboard'));
        $this->assertAuthenticatedAs($parent);
    }

    public function test_parent_can_only_view_their_own_child(): void
    {
        $parent = User::factory()->parent()->create();
        $otherParent = User::factory()->parent()->create();
        $ownChild = Student::factory()->create(['parent_user_id' => $parent->id]);
        $otherChild = Student::factory()->create(['parent_user_id' => $otherParent->id]);

        $this->actingAs($parent)
            ->get(route('parent.students.show', $ownChild))
            ->assertOk();

        $this->actingAs($parent)
            ->get(route('parent.students.show', $otherChild))
            ->assertForbidden();
    }

    public function test_teacher_only_sees_students_assigned_to_them(): void
    {
        $teacher = User::factory()->teacher()->create();
        $otherTeacher = User::factory()->teacher()->create();
        $assigned = Student::factory()->create(['teacher_id' => $teacher->id, 'student_name' => 'Assigned Student']);
        Student::factory()->create(['teacher_id' => $otherTeacher->id, 'student_name' => 'Other Student']);

        $response = $this->actingAs($teacher)->get(route('teacher.students.index'));

        $response->assertOk();
        $response->assertSee('Assigned Student');
        $response->assertDontSee('Other Student');
        $this->assertSame($teacher->id, $assigned->teacher_id);
    }

    public function test_teacher_cannot_open_an_unassigned_student(): void
    {
        $teacher = User::factory()->teacher()->create();
        $otherTeacher = User::factory()->teacher()->create();
        $student = Student::factory()->create(['teacher_id' => $otherTeacher->id]);

        $this->actingAs($teacher)
            ->get(route('teacher.students.show', $student))
            ->assertForbidden();
    }

    public function test_school_administrator_can_assign_a_teacher_to_a_student(): void
    {
        $admin = User::factory()->schoolAdmin()->create();
        $teacher = User::factory()->teacher()->create();
        $counsellor = User::factory()->counsellor()->create();
        $parent = User::factory()->parent()->create([
            'name' => 'Assigned Parent',
            'phone' => '0199999999',
            'email' => 'assigned.parent@example.com',
        ]);
        $student = Student::factory()->create();

        $response = $this->actingAs($admin)->post(route('assign.staff.store'), [
            'student_id' => $student->id,
            'teacher_id' => $teacher->id,
            'counsellor_id' => $counsellor->id,
            'parent_user_id' => $parent->id,
            'review_frequency' => 'Monthly',
            'assignment_notes' => 'Monthly monitoring.',
        ]);

        $response->assertRedirect(route('assign.staff', ['student_id' => $student->id]));
        $student->refresh();
        $this->assertSame($teacher->id, $student->teacher_id);
        $this->assertSame($counsellor->id, $student->counsellor_id);
        $this->assertSame($parent->id, $student->parent_user_id);
        $this->assertSame('Assigned Parent', $student->parent_name);
    }

    public function test_parent_cannot_access_assign_staff_page(): void
    {
        $parent = User::factory()->parent()->create();

        $this->actingAs($parent)
            ->get(route('assign.staff'))
            ->assertForbidden();
    }

    public function test_teacher_cannot_access_manage_users_page(): void
    {
        $teacher = User::factory()->teacher()->create();

        $this->actingAs($teacher)
            ->get(route('users.index'))
            ->assertForbidden();
    }

    public function test_teacher_cannot_record_progress_for_an_unassigned_student(): void
    {
        $teacher = User::factory()->teacher()->create();
        $otherTeacher = User::factory()->teacher()->create();
        $student = Student::factory()->create(['teacher_id' => $otherTeacher->id]);

        $this->actingAs($teacher)
            ->post(route('progress.store'), [
                'student_id' => $student->id,
                'progress_date' => now()->format('Y-m-d'),
                'progress_status' => 'Improving',
                'progress_notes' => 'Unauthorized record attempt.',
                'positive_updates' => 1,
                'need_monitoring' => 0,
            ])
            ->assertForbidden();

        $this->assertDatabaseMissing('progress_records', [
            'student_id' => $student->id,
            'progress_notes' => 'Unauthorized record attempt.',
        ]);
    }

    public function test_reward_points_are_calculated_automatically_from_selected_rule(): void
    {
        $teacher = User::factory()->teacher()->create();
        $student = Student::factory()->create(['teacher_id' => $teacher->id]);

        $response = $this->actingAs($teacher)->post(route('behaviours.store'), [
            'student_id' => $student->id,
            'record_date' => now()->format('Y-m-d'),
            'reward_rule' => 'completed_goal',
            'description' => 'Student completed the assigned learning goal.',
            'behaviour_type' => 'Negative',
            'points' => 999,
        ]);

        $response->assertRedirect(route('behaviours.index'));
        $this->assertDatabaseHas('behaviour_records', [
            'student_id' => $student->id,
            'reward_rule' => 'completed_goal',
            'behaviour_type' => 'Positive',
            'points' => 10,
        ]);
    }

    public function test_negative_reward_rule_automatically_applies_point_deduction(): void
    {
        $teacher = User::factory()->teacher()->create();
        $student = Student::factory()->create(['teacher_id' => $teacher->id]);

        $this->actingAs($teacher)->post(route('behaviours.store'), [
            'student_id' => $student->id,
            'record_date' => now()->format('Y-m-d'),
            'reward_rule' => 'aggressive_behaviour',
            'description' => 'Student displayed aggressive behaviour during class.',
        ])->assertRedirect(route('behaviours.index'));

        $this->assertDatabaseHas('behaviour_records', [
            'student_id' => $student->id,
            'reward_rule' => 'aggressive_behaviour',
            'behaviour_type' => 'Negative',
            'points' => -10,
        ]);
    }

    public function test_invalid_reward_rule_is_rejected(): void
    {
        $teacher = User::factory()->teacher()->create();
        $student = Student::factory()->create(['teacher_id' => $teacher->id]);

        $response = $this->from(route('behaviours.create'))
            ->actingAs($teacher)
            ->post(route('behaviours.store'), [
                'student_id' => $student->id,
                'record_date' => now()->format('Y-m-d'),
                'reward_rule' => 'manual_100_points',
                'description' => 'Attempt to submit an invalid reward rule.',
            ]);

        $response->assertRedirect(route('behaviours.create'));
        $response->assertSessionHasErrors('reward_rule');
        $this->assertDatabaseMissing('behaviour_records', [
            'student_id' => $student->id,
            'description' => 'Attempt to submit an invalid reward rule.',
        ]);
    }

    public function test_parent_reward_summary_only_displays_their_own_child(): void
    {
        $parent = User::factory()->parent()->create();
        $otherParent = User::factory()->parent()->create();
        $ownChild = Student::factory()->create([
            'parent_user_id' => $parent->id,
            'student_name' => 'Own Reward Child',
        ]);
        $otherChild = Student::factory()->create([
            'parent_user_id' => $otherParent->id,
            'student_name' => 'Other Reward Child',
        ]);

        $ownChild->behaviours()->create([
            'record_date' => now(),
            'behaviour_type' => 'Positive',
            'reward_rule' => 'helped_others',
            'description' => 'Helped a classmate.',
            'points' => 5,
        ]);

        $otherChild->behaviours()->create([
            'record_date' => now(),
            'behaviour_type' => 'Positive',
            'reward_rule' => 'completed_goal',
            'description' => 'Completed a goal.',
            'points' => 10,
        ]);

        $response = $this->actingAs($parent)->get(route('rewards.index'));

        $response->assertOk();
        $response->assertSee('Own Reward Child');
        $response->assertDontSee('Other Reward Child');
    }

}
