<?php

namespace TheFarrelHotel\Http\Controllers;

use Illuminate\Http\Request;
use TheFarrelHotel\Http\Models\Pengaturan\Menu;

class AppController extends Controller
{
    protected $user;
    protected $menus;
    protected $title;
	
	/**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            // jika berhasil login buat variabel user
            $this->user = auth()->user();

            // generate menu
            $this->menus = Menu::getMenus($this->user->level_id);

            // ambil judul dari path yang dituju
            if(!$request->ajax())
                $this->title = Menu::getTitle($request->path());

            view()->share([
                'user' => $this->user,
                'menus' => $this->menus,
                'title' => $this->title
            ]);
             
            // mengecek apakah permission user yang login sesuai
            // jika tidak, redirect ke halaman sebelumnya dan munculkan pesan error
            if(!$request->ajax() && !Menu::isValid($request->path(), $this->user->level_id))
            {
                notify()->flash('Error!', 'error', [
                    'text' => 'Anda tidak memiliki hak akses ke link tersebut',
                ]);
                return redirect(url()->previous());
            }

            $response = $next($request);

            if(session('is_locked') && $request->path() != "home/lock")
                $response = redirect('home/lock');

            //lanjutkan ke request selanjutnya
            return $response;
        });
    }
}
