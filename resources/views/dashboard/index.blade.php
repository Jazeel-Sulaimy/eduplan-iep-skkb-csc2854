@extends('layouts.app')
@section('content')
<h1 class="page-title">Dashboard</h1>
<div class="cards">
    <div class="card"><h3>Total Students</h3><div class="num">{{ $studentCount }}</div></div>
    <div class="card"><h3>IEP Goals</h3><div class="num">{{ $goalCount }}</div></div>
    <div class="card"><h3>Reward Points</h3><div class="num">{{ $totalPoints }}</div></div>
    <div class="card"><h3>IEP Reviews</h3><div class="num">{{ $reviewCount }}</div></div>
</div>
<div class="card">
    <h2>Recent Behaviour Records</h2>
    <table class="table"><tr><th>Date</th><th>Student</th><th>Type</th><th>Points</th><th>Description</th></tr>
    @forelse($recentBehaviours as $b)<tr><td>{{ $b->behaviour_date }}</td><td>{{ $b->student->student_name }}</td><td>{{ $b->behaviour_type }}</td><td>{{ $b->points }}</td><td>{{ $b->description }}</td></tr>@empty<tr><td colspan="5">No record yet.</td></tr>@endforelse
    </table>
</div>
@endsection
