<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class RegisterController extends Controller
{
    public function index() {
        return view('registrasi.index', [
            'title' => 'Registrasi',
            'active' => 'registrasi'
        ]);
    }

    public function store(Request $request) {
        $validatedData = $request->validate([
        'username' => ['required', 'unique:users'],
        'password' => [
            'required',
            'confirmed',
            'min:8',
            'regex:/[A-Z]/',
            'regex:/[0-9]{3}/']
        ],
        [
            'username.required' => 'Username harus diisi!',
            'username.unique' => 'Username sudah digunakan!',
            'password.required' => 'Password harus diisi!',
            'password.min' => 'Password harus diisi minimal :min karakter',
            'password.regex:/[A-Z]/' => 'Password harus diisi minimal satu huruf kapital',
            'password.regex:/[0-9]{3}/' => 'Password harus diisi minimal tiga karakter angka'
        ]);

        User::create($validatedData);

    }
}
