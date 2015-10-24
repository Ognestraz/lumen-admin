<?php namespace Admin\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;

class MainController extends AdminController
{
    public function logout()
    {
        Auth::logout();
        return redirect('admin');
    }         

    public function login()
    {
        if (Input::has('name') && Input::has('password')) {

            if (Auth::attempt(['email' => Input::get('name'), 'password' => Input::get('password')], Input::get('remember'))) {

                return redirect('admin');

            }               

        }

        return view('admin::login');
    }         

    public function index()
    {
        if (Auth::check()) {

            switch (Auth::user()->role_id) {

                case 1: return view('admin::index');
                case 2: return redirect('/');
                case 3: return redirect('/');
                default: return $this->login();

            }

            return $this->login();

        }

        return $this->login();
    }
}
