<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Date of Birth</th>
            <th>Date of Joining</th>
            <th>Gender</th>
            <th>Designation</th>
            <th>Manager</th>
            <th>Employee Picture</th>
            <th>Email</th>
            <th>Created At</th>
            <th>Updated At</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($employees as $employee)
            <tr>
                <td>{{ $employee->id }}</td>
                <td>{{ $employee->name }}</td>
                <td>{{ $employee->date_of_birth }}</td>
                <td>{{ $employee->date_of_joining }}</td>
                <td>{{ $employee->gender }}</td>
                <td>{{ $employee->designation }}</td>
                <td>{{ $employee->manager }}</td>
                <td>{{ $employee->employee_picture }}</td>
                <td>{{ $employee->email }}</td>
                <td>{{ $employee->created_at }}</td>
                <td>{{ $employee->updated_at }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
