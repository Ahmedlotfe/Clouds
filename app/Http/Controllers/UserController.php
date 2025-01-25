<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Yajra\DataTables\DataTables;
use Barryvdh\DomPDF\PDF as DomPDF; // Import the DomPDF class directly
class UserController extends Controller
{
    public function index()
    {
        return view('users.index');
    }

}
