<?php

namespace App\Http\Controllers;

use App\Exports\LinksExport;
use App\Link;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $links = Link::ofUser(Auth::user()->id)->orderBy('created_at', 'desc')->paginate(config('7ul.per-page',10));
        return view('dashboard.index', ['links' => $links]);
    }

    public function export()
    {
        return Excel::download(new LinksExport(), date("Y-m-d'-").'links.xlsx');
    }
}
