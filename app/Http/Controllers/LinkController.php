<?php

namespace App\Http\Controllers;

use Jenssegers\Agent\Agent;
use App\Link;
use App\Visit;
use Illuminate\Http\Request;

class LinkController extends Controller
{
    public function shorten(Request $request)
    {

    }

    public function manage($code, $password)
    {
        if ($link = Link::whereCode($code)->first()) {
            if($link->password == $password) {
                echo "OK";
            } else {
                echo "ddd";
            }
        } else {
            return redirect()->route('home');
        }
    }

    public function redirect($code)
    {

        if ($link = Link::whereCode($code)->first()) {
            $data = [];
            $data['HTTP_USER_AGENT'] = $_SERVER['HTTP_USER_AGENT'];
            if(isset($_SERVER['HTTP_REFERER'])) {
                $data['HTTP_REFERER'] = $_SERVER['HTTP_REFERER'];
            }
            $geo = unserialize(file_get_contents('http://www.geoplugin.net/php.gp?ip='.request()->ip()));

            $agent = new Agent();
            $visit = new Visit();
            $visit->link_id = $link->id;
            $visit->ip = request()->ip();
            $visit->device = $agent->device();
            $visit->country = $geo['geoplugin_countryName'];
            $visit->country_code = $geo['geoplugin_countryCode'];
            $visit->platform = $agent->platform();
            $visit->platform_version = $agent->version($agent->platform());
            $visit->browser = $agent->browser();
            $visit->browser_version= $agent->version($agent->browser());
            $visit->data = $data;
            $visit->geo = $geo;
            $visit->save();

            if($link->type == 'redirect') {
                return redirect($link->url);
            } else if($link->type == 'page') {

            } else if($link->type == 'iframe') {

            }
        } else {
            return redirect()->route('home');
        }
    }
}
