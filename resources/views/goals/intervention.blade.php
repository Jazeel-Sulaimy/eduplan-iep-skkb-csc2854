@extends('layouts.app')

@section('content')
<div class="mockup-dashboard">
    @include('partials.mockup-header', ['title' => 'Intervention Plan'])

    <div class="mockup-panel">
        <h2>Intervention Plan</h2>
        <form method="GET" action="{{ route('progress.create') }}">
            <div class="form-grid">
                <div>
                    <label>Intervention Number</label>
                    <select class="select">
                        <option>Intervention 1</option>
                        <option>Intervention 2</option>
                        <option>Intervention 3</option>
                    </select>
                </div>
                <div>
                    <label>Evaluation Method</label>
                    <select class="select">
                        <option>Observation</option>
                        <option>Checklist</option>
                        <option>Teacher Review</option>
                    </select>
                </div>
                <div class="full">
                    <label>Activity</label>
                    <textarea placeholder="Write intervention activity"></textarea>
                </div>
                <div class="full">
                    <label>Material / Tools</label>
                    <textarea placeholder="Write material or tools needed"></textarea>
                </div>
                <div class="full">
                    <label>Evaluation Notes</label>
                    <textarea placeholder="Write evaluation notes"></textarea>
                </div>
            </div>
            <div class="actions">
                <button class="btn" type="submit">Save Intervention</button>
            </div>
        </form>
    </div>
</div>
@endsection
