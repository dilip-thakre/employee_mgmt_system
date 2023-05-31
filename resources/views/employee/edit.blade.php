@extends('layout.dashboard')

@section('content'))
<div class="container">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header">Edit Employee</div>

                <div class="card-body">
                    <form action="{{ route('employees.update', ['id' => $employee->id]) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label for="name">Name:</label>
                            <input type="text" name="name" value="{{ $employee->name }}" class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="date_of_birth">Date of Birth:</label>
                            <input type="date" name="date_of_birth" value="{{ $employee->date_of_birth }}" class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="date_of_joining">Date of Joining:</label>
                            <input type="date" name="date_of_joining" value="{{ $employee->date_of_joining }}" class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="gender">Gender:</label>
                            <select name="gender" class="form-control">
                                <option value="male" @if ($employee->gender === 'male') selected @endif>Male</option>
                                <option value="female" @if ($employee->gender === 'female') selected @endif>Female</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="designation">Designation:</label>
                            <input type="text" name="designation" value="{{ $employee->designation }}" class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="manager">Manager:</label>
                            <input type="text" name="manager" value="{{ $employee->manager }}" class="form-control">
                        </div>

                        <button type="submit" class="btn btn-primary">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection