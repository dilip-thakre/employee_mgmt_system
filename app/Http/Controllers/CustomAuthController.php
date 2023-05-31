<?php
namespace App\Http\Controllers;
use Hash;
use Session;
use App\Models\User;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomAuthController extends Controller
{
    public function index()
    {
        return view('welcome');
    }  
      
    public function customLogin(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
            'type' => 'required',
        ]);
   
        $credentials = $request->only('email', 'password');
        if($request->type == 'admin')
        {
            if (Auth::attempt($credentials)) {
                return redirect()->intended('dashboard')
                            ->withSuccess('Signed in');
            }
        }else if($request->type == 'employee')
        {
            
            if (Auth::guard('employee')->attempt($credentials)) {
                return redirect()->intended('dashboard')
                            ->withSuccess('Signed in');
            }
        }

  
        return redirect("login")->withSuccess('Login details are not valid');
    }

    public function registration()
    {
        return view('admin.registration');
    }
      
    public function customRegistration(Request $request)
    {  
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);
           
        $data = $request->all();
        $check = $this->create($data);
         
        return redirect("layout.dashboard")->withSuccess('You have signed-in');
    }

    public function create(array $data)
    {
      return User::create([
        'name' => $data['name'],
        'email' => $data['email'],
        'password' => Hash::make($data['password'])
      ]);
    }    
    
    public function dashboard()
    {
        $employees = Employee::all();
        if(Auth::check()){
            return view('layout.dashboard',compact('employees'));
        }else if((Auth::guard('employee')->check()))
        {
            return view('layout.dashboard');
        }
  
        return redirect("login")->withSuccess('You are not allowed to access');
    }
    
    public function signOut() {
        \Illuminate\Support\Facades\Session::flush();
        Auth::logout();
  
        return Redirect('login');
    }
}