<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-light navbar-expand-lg mb-5" style="background-color: #e3f2fd;">
        <div class="container">
            <a class="navbar-brand mr-auto" href="#">Employee Management System</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    @if(!(Auth::guard('employee')->check()) && Auth::guest())
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.login') }}">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('register-user') }}">Register</a>
                    </li>
                    @else
                    @if (Auth::check())
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('upload.employees') }}">Upload Employee</a>
                    </li>                        
                    @endif

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('signout') }}">Logout</a>
                    </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>
    @yield('content')
    @if (isset($employees))
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                @if(session('success'))
                <div class="alert alert-success">
                {{ session('success') }}
                </div>
                @endif
                <form action="{{ route('employees.search') }}" method="GET" class="mb-3">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control" placeholder="Search">
                        <button type="submit" class="btn btn-primary">Search</button>
                    </div>
                </form>
                <a href="{{ route('employees.download') }}" class="btn btn-primary">Download Employees</a>

                <!-- Employee List -->
                <table class="table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Profile Pic</th>
                            <th>Date of Birth</th>
                            <th>Date of Joining</th>
                            <th>Gender</th>
                            <th>Designation</th>
                            <th>Manager</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($employees as $employee)
                            <tr>
                                <td>{{ $employee->name }}</td>
                                @if (!empty($employee->employee_picture))
                                <td><img src="{{ asset('employee_pictures/' . $employee->employee_picture) }}" alt="Employee Picture" class="rounded-circle" style="height:50px;width:50px"></td>                
                                @else
                                <td><svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" fill="currentColor" class="bi bi-person" viewBox="0 0 16 16">
                                    <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6Zm2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0Zm4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4Zm-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664h10Z"/>
                                  </svg></td>
                                @endif
                                <td>{{ $employee->date_of_birth }}</td>
                                <td>{{ $employee->date_of_joining }}</td>
                                <td>{{ $employee->gender }}</td>
                                <td>{{ $employee->designation }}</td>
                                <td>{{ $employee->manager }}</td>
                                <td>
                                    <a href="{{ route('employees.edit', ['id' => $employee->id]) }}" class="btn btn-primary">Edit</a>
                                    <form action="{{ route('employees.delete', ['id' => $employee->id]) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @endif

</body>
</html>