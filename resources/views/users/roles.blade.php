@extends('layouts.app')

@section('content')
<div class="mockup-dashboard">
    @include('partials.mockup-header', ['title' => 'Roles'])

    <div class="mockup-panel">
        <h2>Permission Roles</h2>
        <table class="mockup-table">
            <thead>
                <tr>
                    <th>Roles</th>
                    <th>Access</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>School Administrator</td>
                    <td>Manage students, users, staff assignments and reports.</td>
                </tr>
                <tr>
                    <td>Teacher</td>
                    <td>Fill pre-meeting form, IEP form, intervention plan and progress forms.</td>
                </tr>
                <tr>
                    <td>Counsellor</td>
                    <td>Review student cases, add counselling notes and prepare support plan.</td>
                </tr>
                <tr>
                    <td>Parent / Guardian</td>
                    <td>View child IEP, progress summary, report and submit consent letter.</td>
                </tr>
                <tr>
                    <td>System Admin</td>
                    <td>Manage system users, roles, backup and EPKB system settings.</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection
