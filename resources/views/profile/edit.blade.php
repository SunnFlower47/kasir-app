@extends('layouts.admin')

@section('content')
    <div class="container py-5">
        <h2 class="mb-4 fw-bold text-dark">Your Profile</h2>

        {{-- Profile Information Card --}}
        <div class="card mb-4 shadow-sm">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Update Profile Information</h5>
                <small>Update your account's profile information and email address.</small>
            </div>
            <div class="card-body">
                @include('profile.partials.update-profile-information-form')
            </div>
        </div>

        {{-- Password Update Card --}}
        <div class="card mb-4 shadow-sm">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0">Update Password</h5>
                <small>Use a strong and unique password to protect your account.</small>
            </div>
            <div class="card-body">
                @include('profile.partials.update-password-form')
            </div>
        </div>

        {{-- Delete Account Card --}}
        <div class="card mb-4 shadow-sm border-danger">
            <div class="card-header bg-danger text-white">
                <h5 class="mb-0">Delete Account</h5>
                <small>This action is permanent and cannot be undone.</small>
            </div>
            <div class="card-body">
                @include('profile.partials.delete-user-form')
            </div>
        </div>
    </div>
@endsection
