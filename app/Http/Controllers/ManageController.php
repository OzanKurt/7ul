<?php

namespace App\Http\Controllers;

use App\Exports\VisitsExport;
use App\Link;
use App\Visit;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ManageController extends Controller
{
    public function index($code, $password)
    {
        if ($link = Link::whereCode($code)->first()) {
            if($link->password == $password) {
                $visits = Visit::ofLink($link->id)->orderBy('created_at', 'desc')->paginate(config('7ul.per-page',10));
                return view('manage.index', ['link'=>$link, 'visits' => $visits]);
            } else {
                return redirect()->route('home');
            }
        } else {
            return redirect()->route('home');
        }
    }

    public function export($code, $password)
    {
        if ($link = Link::whereCode($code)->first()) {
            if($link->password == $password) {
                return Excel::download(new VisitsExport($link), date("Y-m-d'-").$link->id.'-visits.xlsx');
            } else {
                return redirect()->route('home');
            }
        } else {
            return redirect()->route('home');
        }
    }

    public function visit($id, $code, $password)
    {
        if ($link = Link::whereCode($code)->first()) {
            if($link->password == $password) {
                $visit = Visit::with('link')->findOrFail($id);
                return view('manage.visit', ['visit' => $visit]);
            } else {
                return redirect()->route('home');
            }
        } else {
            return redirect()->route('home');
        }
    }

    public function title($code, $password)
    {
        if ($link = Link::whereCode($code)->first()) {
            if($link->password == $password) {
                $str = file_get_contents($link->url);
                if(strlen($str)>0){
                    $str = trim(preg_replace('/\s+/', ' ', $str));
                    preg_match("/\<title\>(.*)\<\/title\>/i",$str,$title);
                    return $title[1];
                } else {
                    return __('No Title');
                }
            } else {
                return redirect()->route('home');
            }
        } else {
            return redirect()->route('home');
        }
    }

    public function update()
    {

    }
}
