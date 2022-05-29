<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Creator;
use App\Notifications\VerifyEmailQueuedNotification;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;


class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
        $this->middleware('guest:creators');
    }


    public function register(Request $request)
    {



        $validation = $request->validate(
            [
                'name' => ['required', 'string', 'max:255' , 'unique:users,name' , 'unique:creators,name'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users' , 'unique:creators'],
                'password' => ['required', 'string', 'min:8', 'confirmed'],
                'registeration_type' => ['required', 'string'],


            ]);

        $userType = $request->registeration_type == 0 ? 'users' : 'creator';

        if($userType == 'users')
        {

            return $this->submitUserRegisteration($request);
        }

        return $this->submitCreatorRegisteration($request);

    }

    private function submitUserRegisteration($data)
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        $user->notify(new VerifyEmailQueuedNotification());



        return redirect()->route('login')->with('success' , 'The registration process has been succeeded you may log in now');

    }
    private function submitCreatorRegisteration($data)
    {
        $creator = Creator::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
        $creator->notify(new VerifyEmailQueuedNotification());



        return redirect()->route('login')->with('success' , 'The registration process has been succeeded you may log in now');

    }
}
