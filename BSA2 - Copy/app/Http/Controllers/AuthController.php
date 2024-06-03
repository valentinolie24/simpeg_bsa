<?php

namespace App\Http\Controllers;

use App\Http\Request\LoginRequest;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;


class AuthController extends Controller
{
    // Method untuk menampilkan halaman registrasi
    public function registerView()
    {
        return view('register.main', [
            'layout' => 'register'
        ]);
         // Sesuaikan dengan nama file view registrasi Anda
        
    }

    // Method untuk menangani proses registrasi pengguna baru
    public function register(Request $request)
    {
        // dd($request);
        // Validasi data yang diterima dari form registrasi
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'noWA' => 'required',
            'password' => 'required|min:8|confirmed'
        ],[
            'name.required' => 'Nama harus diisi',
            'name.string' => 'Nama harus berupa huruf',
            'name.max' => 'Nama tidak boleh melebihi 255 kata',
            'email.required' => 'Email harus diisi',
            'email.email' => 'Email tidak valid',
            'email.unique' => 'Email sudah terdaftar',
            'password.required' => 'Password harus diisi',
            'noWA.required' => 'Nomor WhatsApp harus diisi',
            'password.min' => 'Password harus minimal 8 karakter',
            'name.confirmed' => 'Password harus sama',
        ]);

        // Buat pengguna baru berdasarkan data yang diterima
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'noWA' => $request->noWA,
            'password' => Hash::make($request->password),
            
        ]);

        // Redirect ke halaman login atau halaman lain setelah pendaftaran berhasil
        return redirect()->route('login')->with('success', 'Pendaftaran berhasil! Silakan login.');
    }
    

    /**
     * Show specified view.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function loginView()
    {
        return view('login.main', [
            'layout' => 'login'
        ]);
    }

    /**
     * Authenticate login user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function login(LoginRequest $request)
    {
        if (!\Auth::attempt([
            'email' => $request->email,
            'password' => $request->password
        ])) {
            throw new \Exception('Wrong email or password.');
        }
    }

    /**
     * Logout user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function logout()
    {
        \Auth::logout();
        return redirect('login');
    }
}
