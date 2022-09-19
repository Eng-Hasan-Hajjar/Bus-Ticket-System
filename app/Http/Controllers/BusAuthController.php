<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use DB;
use App\Notifications\VerifyRegistration;

class BusAuthController extends Controller
{
    public function showRegistrationForm()
    {
    	return view('registration');
    }

    public function register(Request $request)
    {
    	$this->registration_validation($request);
        // User::create($request->all());

        $user = User::create([
            'fname' => $request->fname,
            'lname' => $request->lname,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'provider' => 'native',
            'provider_id' => 0,
            'remember_token' => str_random(40)
        ]);

        $user->notify(new VerifyRegistration($user));
        
    	return redirect('/')->with('Status', 'Please check your email to verify first then login.');
    }

    public function verify($token)
    {
        $user = User::where('remember_token', $token)->first();
        if ( ! is_null($user) ) {
            $user->verified = 1;
            $user->remember_token = null;
            $user->save();
            session()->flash('msg', 'User verified successfully. Now you can login with your email and password.');
        } else {
            session()->flash('err-msg', 'Sorry! your token is not matched!');
        }
        return redirect('login-form');
    }

    public function registration_validation($request)
    {
        $rules = [
            'fname' => 'required|max:50',
            'lname' => 'required|max:50',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed|max:200'
        ];

        $customMessages = [
            'fname.required' => 'First name cannot be blank!',
            'lname.required' => 'Last name cannot be blank!',
            'email.required' => 'Email cannot be blank!'
        ];

        return $this->validate($request, $rules, $customMessages);
    }

    public function showLoginForm()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $this->login_validation($request);

        $credentials = [
            'email' => $request['email'],
            'password' => $request['password']
        ];

        if ( auth()->attempt($credentials) ) {
            $user_info = auth()->user();
            $first_name = $user_info->fname;
            $status = 'Welcome Customer';
            $data = ['fname' => $first_name, 'Status' => $status];
            return redirect()->to('customer-welcome')->with($data);
        }
        
        return back()->withErrors(['messages' => 'Invalid email or password.']);
        
    }

    public function login_validation($request)
    {
        $rules = [
            'email' => 'required|email',
            'password' => 'required'
        ];

        return $this->validate($request, $rules);
    }

    public function logout()
    {
        auth()->logout();
        return redirect()->to('login-form');
    }

    // Admin login logout

    public function showAdminLoginForm()
    {
        return view('admin.admin-login');
    }

    public function adminLogin(Request $request)
    {
        $email      = $request->get('email');
        $password   = $request->get('password');
        $credentials = [
            'email' => $email,
            'password' => $password
        ];

        if ( auth()->attempt($credentials) ) {
            $user_info  = DB::table('users')
                        ->where('email', $email)
                        ->get();
            if ( $user_info[0]->admin == 1 ) {
                return redirect()->to('admin/dashboard');
            }
        }

        return redirect()->to('admin/login');
    }

    public function adminLogout()
    {
        auth()->logout();
        return redirect()->to('admin/login');
    }
}
