<?php

namespace TheFarrelHotel\Http\Controllers\App;

use Illuminate\Http\Request;
use TheFarrelHotel\Http\Controllers\AppController;
use TheFarrelHotel\Http\Models\Gallery;
use TheFarrelHotel\Http\Models\Kamar\Room;

use Illuminate\Support\Facades\Storage;

use DB, Form;

class HomeController extends AppController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        $data = Gallery::all();
        
        return view('home.index', compact('data'));
    }

    /**
     * Display an user's profile.
     *
     * @return \Illuminate\Http\Response
     */
    public function profile()
    {
    	$data['title'] = 'Profil';
        return view('home.profile', $data);
    }

    public function lock()
    {
        if(auth()->check()){
            session(['is_locked' => true]);
            return view('auth.lock');
        }
        return redirect('login');
    }

    public function unlock(Request $request)
    {
        if(!auth()->check())
            return redirect('login');

        if(\Hash::check($request->password, auth()->user()->password)){
            request()->session()->forget('is_locked');
            return redirect('home');
        }

        return redirect()->back()
            ->withInput()
            ->withErrors([
                'username' => 'Username atau password salah.',
            ]);
    }
}
