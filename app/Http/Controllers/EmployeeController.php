<?php
namespace App\Http\Controllers;
use League\Csv\Reader;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\EmployeesExport;

class EmployeeController extends Controller
{
    public function index()
    {
        $employees = Employee::all();
        if(Auth::check()){
            return view('layout.dashboard',compact('employees'));
        }else if((Auth::guard('employee')->check()))
        {
            return view('layout.dashboard');
        }
    }
    public function search(Request $request)
    {
        $search = $request->input('search');
        $employees = Employee::where('name', 'LIKE', "%$search%")
            ->orWhere('designation', 'LIKE', "%$search%")
            ->get();
        return view('layout.dashboard', compact('employees'));
    }
    public function showRegistrationForm()
    {
        return view('admin.registration');
    }

    public function register(Request $request)
    {
        // Validate the form data
        $validatedData = $request->validate([
            'name' => 'required|string',
            'date_of_birth' => 'required|date',
            'date_of_joining' => 'required|date',
            'gender' => 'required|string',
            'designation' => 'required|string',
            'manager' => 'required|string',
            'employee_picture' => 'image|nullable',
            'password' => 'required|string|min:8',
            'email' => 'required|string|email|unique:employees',
        ]);

        // Create a new Employee instance
        $employee = new Employee();
        $employee->name = $validatedData['name'];
        $employee->date_of_birth = $validatedData['date_of_birth'];
        $employee->date_of_joining = $validatedData['date_of_joining'];
        $employee->gender = $validatedData['gender'];
        $employee->designation = $validatedData['designation'];
        $employee->manager = $validatedData['manager'];
        $employee->password = bcrypt($validatedData['password']);
        $employee->email = $validatedData['email'];

        // Handle employee picture upload
        if ($request->hasFile('employee_picture')) {
            $picture = $request->file('employee_picture');
            $pictureName = time() . '.' . $picture->getClientOriginalExtension();
            $picture->move(public_path('employee_pictures'), $pictureName);
            $employee->employee_picture = $pictureName;
        }

        // Save the employee to the database
        $employee->save();

        // Redirect or display a success message
        // return redirect()->back()->with('success', 'Employee registered successfully!');
        return view('layout.dashboard');
    }

    public function upload_employee()
    {
        if(Auth::check())
        {
            return view('employee.upload');
        }else
        {
            return view('layout.dashboard');
        }

    }
    public function upload_employee_data(Request $request)
    {
        $file = $request->file('file');
        $extension = $file->getClientOriginalExtension();

        if ($extension === 'csv') {
            $this->processCSV($file);
        } elseif ($extension === 'xls' || $extension === 'xlsx') {
            $this->processExcel($file);
        } else {
            return back()->with('error', 'Invalid file format.');
        }

        return back()->with('success', 'Users uploaded successfully.');
    }

    private function processCSV($file)
    {
        $csv = Reader::createFromPath($file->getPathname(), 'r');
        // $csv->setHeaderOffset(0); // Assuming CSV has headers
        foreach ($csv as $record) {
            $employee = new Employee();
            $employee->name = $record[0];
            $employee->date_of_birth = Carbon::createFromFormat('m/d/Y', $record[1])->format('Y-m-d');
            $employee->date_of_joining = Carbon::createFromFormat('m/d/Y', $record[2])->format('Y-m-d');
            $employee->gender = $record[3];
            $employee->designation = $record[4];
            $employee->manager = $record[5];
            $employee->employee_picture = $record[6];
            $employee->password = !empty($record[7]) ? bcrypt($record[7]) :  bcrypt('12345678');
            $employee->email = $record[8];
            $employee->save();
        }
    }

    private function processExcel($file)
    {
        $data = Excel::toCollection(null, $file);

        foreach ($data->first() as $row) {
            dd($row);

            // Process each row and create users
            // $row['column_name'] contains the data for each column
        }
    }

    public function edit($id)
    {
        $employee = Employee::find($id);
        return view('employee.edit', compact('employee'));
    }

    public function update(Request $request, $id)
    {
        // Validate the form data
        $validatedData = $request->validate([
            'name' => 'required',
            'date_of_birth' => 'required|date',
            'date_of_joining' => 'required|date',
            'gender' => 'required',
            'designation' => 'required',
            'manager' => 'required',
        ]);
    
        // Find the employee by ID
        $employee = Employee::find($id);
    
        // Update the employee data based on the form inputs
        $employee->name = $request->input('name');
        $employee->date_of_birth = $request->input('date_of_birth');
        $employee->date_of_joining = $request->input('date_of_joining');
        $employee->gender = $request->input('gender');
        $employee->designation = $request->input('designation');
        $employee->manager = $request->input('manager');
    
        // Save the updated employee
        $employee->save();
    
        $employees = Employee::all();
        return view('layout.dashboard',compact('employees'))->with('success', 'Employee updated successfully.');
    }

        public function delete($id)
        {
            // Find the employee by ID
            $employee = Employee::find($id);
        
            // Check if the employee exists
            if (!$employee) {
                return redirect()->route('employees.index')->with('error', 'Employee not found.');
            }
        
            // Delete the employee
            $employee->delete();
        
            $employees = Employee::all();
            return view('layout.dashboard',compact('employees'))->with('success', 'Employee deleted successfully.');
        }

        public function download(Request $request)
        {
            // Retrieve all employees
            $employees = Employee::all();

            // Generate Excel file using EmployeesExport class
            return Excel::download(new EmployeesExport($employees), 'employees.xlsx');
        }

}

