<?php

namespace App\Http\Controllers\Admin;

use App\Exports\LinksExport;
use App\Link;
use App\Visit;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
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
        $this->middleware(['auth', 'admin']);
    }

    public function index()
    {
        $links = Link::orderBy('created_at', 'desc')->paginate(config('7ul.per-page',10));
        return view('admin.dashboard.index', ['links' => $links]);
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
            $data['visits'][] = Visit::whereBetween('created_at', [$start, $end])->count();

        }
        return response()->json($data);
    }
}
