<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

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
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        $user_data = array_except($data, ['avatar', 'address', 'phone', 'is_whatsapp']);

        $user = User::create($user_data);

        if (filled($data['avatar'])) {
            $file = \Request::file('avatar');
            $file->storeAs('images/avatars', $user->user_id . '.' . $file->extension());
            $user->avatar = \Storage::url('images/avatars/' . $user->user_id . '.' . $file->extension());
            $user->save();
        }

        if (filled($data['address'])) {
            $user->address()->create($data['address']);
            $user->save();
        }

        if (filled($data['phone'])) {
            $user->phone()->create([
                'area_code' => substr($data['phone'], 0, 2),
                'phone' => substr($data['phone'], 2),
                'is_whatsapp' => $data['is_whatsapp']
            ]);
            $user->save();
        }

        return $user;
    }

    /**
     * The user has been registered.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return mixed
     */
    protected function registered(Request $request, User $user)
    {
        return response()->json(['success' => true]);
    }
}
