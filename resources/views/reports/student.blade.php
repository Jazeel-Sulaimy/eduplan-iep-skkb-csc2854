@extends('layouts.app')
@section('content')
<div class="print-header">
    <h2>SK Kuala Berang</h2>
    <h3>Individual Education Plan Report</h3>
</div>
<h1 class="page-title">IEP Report: {{ $student->student_name }}</h1>
<button class="btn no-print" onclick="window.print()">Print / Save as PDF</button>
<br><br>
<div class="card">
    <h2>Student Information</h2>
    <p><b>Name:</b> {{ $student->student_name }}</p>
    <p><b>Class:</b> {{ $student->class_name }}</p>
    <p><b>Parent:</b> {{ $student->parent_name }} / {{ $student->parent_phone }}</p>
    <p><b>Teacher:</b> {{ $student->teacher->name ?? '-' }}</p>
    <p><b>Counsellor:</b> {{ $student->counsellor->name ?? '-' }}</p>
    <p><b>Diagnosis / Need:</b> {{ $student->diagnosis }}</p>
</div>
<div class="card">
    <h2>IEP Goals</h2>
    <table class="table">
        <tr>
            <th>Goal</th>
            <th>Description</th>
            <th>Status</th>
        </tr>
        @foreach($student->goals as $g)
        <tr>
            <td>{{ $g->goal_title }}</td>
            <td>{{ $g->goal_description }}</td>
            <td>{{ $g->status }}</td>
        </tr>
        @endforeach
    </table>
</div>
<div class="card">
    <h2>Behaviour and Reward Points</h2>
    <p><b>Total Points:</b> {{ $student->behaviours->sum('points') }}</p>
    <table class="table">
        <tr>
            <th>Date</th>
            <th>Behaviour Action</th>
            <th>Type</th>
            <th>Description</th>
            <th>Points</th>
        </tr>
        @foreach($student->behaviours as $b)
        <tr>
            <td>{{ optional($b->record_date)->format('d/m/Y') }}</td>
            <td>{{ $b->rewardLabel() }}</td>
            <td>{{ $b->behaviourTypeLabel() }}</td>
            <td>{{ $b->description }}</td>
            <td>{{ $b->signedPoints() }}</td>
        </tr>
        @endforeach
    </table>
</div>
<div class="card">
    <h2>Progress Records</h2>
    <table class="table">
        <tr>
            <th>Date</th>
            <th>Academic</th>
            <th>Behaviour</th>
            <th>Comment</th>
        </tr>
        @foreach($student->progressRecords as $p)
        <tr>
            <td>{{ $p->progress_date }}</td>
            <td>{{ $p->academic_progress }}</td>
            <td>{{ $p->behaviour_progress }}</td>
            <td>{{ $p->teacher_comment }}</td>
        </tr>
        @endforeach
    </table>


<div class="card"><h2>Consultation and Reviews</h2><table class="table"><tr><th>Type</th><th>Date</th><th>Notes</th></tr>@foreach($student->consultations as $c)<tr><td>Consultation</td><td>{{ $c->consultation_date }}</td><td>{{ $c->case_notes }}</td></tr>@endforeach @foreach($student->reviews as $r)<tr><td>Review</td><td>{{ $r->review_date }}</td><td>{{ $r->review_notes }} Next: {{ $r->next_review_date }}</td></tr>@endforeach</table></div>
@endsection
