@extends('layouts.app')

@section('content')
<div class="mockup-dashboard">
    @include('partials.mockup-header', ['title' => 'Support Plan'])

    <div class="mockup-panel">
        <h2>Support Plan</h2>
        <form method="GET" action="{{ route('reviews.index') }}">
            <div class="form-grid">
                <div>
                    <label>Select Student</label>
                    <select class="select">
                        @foreach($students as $student)
                            <option>{{ $student->student_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label>Support Type</label>
                    <select class="select">
                        <option>Behaviour Support</option>
                        <option>Communication Support</option>
                        <option>Academic Support</option>
                    </select>
                </div>
                <div class="full">
                    <label>Recommend Support Plan</label>
                    <textarea placeholder="Write recommended support plan"></textarea>
                </div>
            </div>
            <div class="actions">
                <button class="btn" type="submit">Save Support Plan</button>
            </div>
        </form>
    </div>
</div>
@endsection
