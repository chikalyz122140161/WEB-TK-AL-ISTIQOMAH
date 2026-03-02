<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        return view('admin.dashboard');
    }
    // Tambahkan method CRUD siswa, user, backup, pendaftaran luar login
}
