<?php

namespace IsotopeKit\AuthAPI\Http\Controllers;

// use Log;
use Mail;
use Session;
use Config;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cookie;

use IsotopeKit\AuthAPI\Models\User;
use IsotopeKit\AuthAPI\Models\User_Role;
use IsotopeKit\AuthAPI\Models\Levels;


class AuthController extends Controller
{

	public function getLogin()
    {
        return view('authapi::login');
    }

    public function postLogin(Request $request)
    {
		// return $request->all();
		$login_type = "user";
		$login_url = "/login";

		if($request->has('login_type'))
		{
			$login_type = $request->input('login_type');
		}
		
		if($login_type == "user")
		{
			$login_url = "/login";
		}
		if($login_type == "admin")
		{
			$login_url = "/admin/login";
		}

        try{
            // validate
            $isValid =  Validator::make($request->all(), [
                'email'         => 'required|string|email|min:5|max:50',
                'password'      => 'required|string|min:6|max:20'
            ]);

            if($isValid->fails()){
                return redirect($login_url)->withErrors($isValid)->withInput();
            }
            else{
                
                if (Auth::attempt(['email' => $request->input('email'), 'password' => $request->input('password'), 'enabled' => true], true)) {
                // if (Auth::attempt(['email' => $request->input('email'), 'password' => $request->input('password')], true)) {
				
                    if(Auth::user()->isAdmin() === true)
                    {
                        return redirect()->intended('/admin/');
                    }
                    if(Auth::user()->isTeamOnly() === true)
                    {
                        return redirect()->intended('/team');
                    }
                    if(Auth::user()->isAgency() == true)
                    {
                        return redirect()->intended('/agency');
                    }
                    else {
                        return redirect()->intended('/user/dashboard');
                    }
                }
                else{
                    $messages = [
                        'general'	=>	'invalid username or password'
                    ];
					return redirect($login_url)->withErrors($messages)->withInput();
                }

            }
        }
        catch(\Exception $ex)
        {
            return redirect($login_url)->with('status.error', 'Something went wrong, try again later');
        }
    }

	public function postLogout(Request $request)
    {
        Session::flush();
        return redirect('/login');
    }

	public function getRegister()
    {
        $levels = Levels::where('id','!=',1)->get();
        return view('authapi::register')->with('plans', $levels);
    }

    public function postRegister(Request $request)
    {
        try{
            // validate
            $isValid =  Validator::make($request->all(), [
                'first_name'    =>  'required|string|min:3|max:10',
                'last_name'     =>  'required|string|min:3|max:10',
                'email'         =>  'required|string|email|min:5|max:50|unique:users',
                'password'      =>  'required|string|min:6|max:20',
                'plan_id'       =>  'required'
            ]);
            
            if($isValid->fails()){
                $messages = $isValid->messages();
                return redirect()->route('get_register_route')->withErrors($isValid)->withInput();
            }
            else{

				$random_text_generator = new \IsotopeKit\Utility\RandomTextGenerator();
				$random_token = $random_text_generator->get_random_value_in_string(20);

                // create account
                $user = User::create([
                    'first_name'    =>  $request->input('first_name'),
                    'last_name'     =>  $request->input('last_name'),
                    'email'         =>  $request->input('email'),
                    'password'      =>  bcrypt($request->input('password')),
                    'email_token'   =>  $random_token,
                    'enabled'       =>  true
                ]);

                $plan_id = json_encode($request->input('plan_id'));
                // save role
                $save_role = User_Role::create([
                    'user_id'	=>	$user->id,
                    'levels'    => '["1",'.$plan_id.']', // by default user with 'basic' plan
                ]);

                // send email
                // if($user)
                // {
                //     $data = [
                //         'email' =>  $request->input('email'),
                //         'name'  =>  $request->input('first_name'),
                //         'code'  =>  $random_token
                //     ];

                //     $emails_to = array(
                //         'email' => $request->input('email'),
                //         'name' => $request->input('first_name')
                //     );
                    
                //     Mail::send('emails.welcome', $data, function($message) use ($emails_to)
                //     {
                //         $message->to($emails_to['email'], $emails_to['name'])->subject('Welcome To MyBrand Bot');
                //     });
                // }

                $user = User::where('email', $request->input('email'))->first();
                if($user)
                {
                    Auth::loginUsingId($user->id);
                }

                // redirect to login page with message
                return redirect()->route('get_login_route')->with('status.success', 'Account Created, Please check email to activate account');
            }
        }
        catch(\Exception $ex)
        {
            // log error to database
            return redirect('/register')->with('status.error', 'Something went wrong, try again later');
        }
    }

	// test

	public function getInfo(Request $request)
	{
		return Auth::user();
	}

	public function getUserInfo(Request $request)
	{
		return Auth::user();
	}

}