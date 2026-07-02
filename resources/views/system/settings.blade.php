@extends('layouts.app')

@section('content')
<div class="mockup-dashboard">
    @include('partials.mockup-header', ['title' => 'EPKB System'])

    <div class="mockup-panel">
        <h2>System Settings</h2>
        <form method="GET" action="{{ route('system.settings') }}">
            <div class="form-grid">
                <div>
                    <label>System Name</label>
                    <input class="input" type="text" value="IEP Management system">
                </div>
                <div>
                    <label>Academic Year</label>
                    <input class="input" type="text" value="2026">
                </div>
                <div>
                    <label>School Name</label>
                    <input class="input" type="text" value="SK Kuala Berang">
                </div>
                <div>
                    <label>Default Report Format</label>
                    <select class="select">
                        <option>PDF</option>
                        <option>Print View</option>
                    </select>
                </div>
            </div>
            <div class="actions">
                <button class="btn" type="submit">Save Settings</button>
                <button class="btn btn-light" type="reset">Reset</button>
            </div>
        </form>
    </div>
</div>
@endsection
