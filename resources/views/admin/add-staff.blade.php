@extends('layouts.app')

@php
    $pageTitle = 'Add Staff';
    $pageIcon = 'bx-group';
@endphp

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Add Staff Member</h3>
                    <a href="{{ route('admin.staff.index') }}" class="btn btn-secondary float-right">Back to Staff List</a>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.staff.store') }}" method="POST">
                        @csrf
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered">
                                <thead class="table-dark">
                                    <tr>
                                        <th>Field</th>
                                        <th>Information</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><strong>Email</strong></td>
                                        <td>
                                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required>
                                            @error('email')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong>Password</strong></td>
                                        <td>
                                            <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" required>
                                            @error('password')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong>First Name</strong></td>
                                        <td>
                                            <input type="text" class="form-control @error('first_name') is-invalid @enderror" id="first_name" name="first_name" value="{{ old('first_name') }}" required>
                                            @error('first_name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong>Middle Name</strong></td>
                                        <td>
                                            <input type="text" class="form-control @error('middle_name') is-invalid @enderror" id="middle_name" name="middle_name" value="{{ old('middle_name') }}">
                                            @error('middle_name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong>Last Name</strong></td>
                                        <td>
                                            <input type="text" class="form-control @error('last_name') is-invalid @enderror" id="last_name" name="last_name" value="{{ old('last_name') }}" required>
                                            @error('last_name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong>Sex</strong></td>
                                        <td>
                                            <select class="form-control @error('sex') is-invalid @enderror" id="sex" name="sex">
                                                <option value="">Select Sex</option>
                                                <option value="Male" {{ old('sex') == 'Male' ? 'selected' : '' }}>Male</option>
                                                <option value="Female" {{ old('sex') == 'Female' ? 'selected' : '' }}>Female</option>
                                                <option value="Other" {{ old('sex') == 'Other' ? 'selected' : '' }}>Other</option>
                                            </select>
                                            @error('sex')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong>Birth Date</strong></td>
                                        <td>
                                            <input type="date" class="form-control @error('birth_date') is-invalid @enderror" id="birth_date" name="birth_date" value="{{ old('birth_date') }}">
                                            @error('birth_date')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong>Position</strong></td>
                                        <td>
                                            <select class="form-control @error('position') is-invalid @enderror" id="position" name="position" required>
                                                <option value="">Select Position</option>
                                                <option value="Health Worker" {{ old('position') == 'Health Worker' ? 'selected' : '' }}>Health Worker</option>
                                                <option value="Barangay Nurse" {{ old('position') == 'Barangay Nurse' ? 'selected' : '' }}>Barangay Nurse</option>
                                            </select>
                                            @error('position')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong>Contact Number</strong></td>
                                        <td>
                                            <input type="text" class="form-control @error('contact_number') is-invalid @enderror" id="contact_number" name="contact_number" value="{{ old('contact_number') }}">
                                            @error('contact_number')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong>Address</strong></td>
                                        <td>
                                            <textarea class="form-control @error('address') is-invalid @enderror" id="address" name="address" rows="3">{{ old('address') }}</textarea>
                                            @error('address')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" class="text-center">
                                            <button type="submit" class="btn btn-primary">Add Staff Member</button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
