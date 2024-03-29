<?php

namespace App\Http\Controllers;

use App\Exports\LinksExport;
use App\Link;
use App\Visit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;

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

    public function month()
    {
        $data = [];
        $data['visits'] = [];
        $data['labels'] = [];
        $monthDays = Carbon::now()->daysInMonth;
        for ($i = 1; $i <= $monthDays; $i++) {
            $start = Carbon::create(Carbon::now()->year, Carbon::now()->month, $i, 0);
            $end = Carbon::create(Carbon::now()->year, Carbon::now()->month, $i + 1, 0);
            $data['labels'][] = $start->format('Y-m-d');
            $data['visits'][] = Visit::whereIn('link_id',Link::select('id')->where('user_id', auth()->user()->id)->get())->whereBetween('created_at', [$start, $end])->count();

        }
        return response()->json($data);
    }
}
