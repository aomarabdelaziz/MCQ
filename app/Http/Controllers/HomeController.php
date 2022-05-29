<?php

namespace App\Http\Controllers;

use App\DataTables\UserDatatable;
use Illuminate\Http\Request;

class HomeController extends Controller
{


    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(UserDatatable $datatable)
    {

        return $datatable->render('dashboard.users.index');
    }
}
