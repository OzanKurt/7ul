<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Support\Str;
use Jenssegers\Agent\Agent;
use Illuminate\Support\Facades\Auth;
use App\Link;
use App\Visit;
use Illuminate\Http\Request;
use GeoIp2\Database\Reader;

class LinkController extends Controller
{
    public function shorten(Request $request)
    {
        $request->validate([
            'type'    => 'string|nullable',
            'url'     => 'url|required',
            'private' => 'boolean|nullable',
            'code'    => 'unique:links,code|nullable',
            'title'   => 'string|nullable',
            'body'    => 'string|nullable',
        ]);
        if (Auth::check()) {
            if($link = Link::ofUser(Auth::user()->id)->where('url',$request->url)->first()) {
                return redirect()->route('manage',[$link->code, $link->password]);
            } else {
                $link = new Link();
                $link->url = $request->url;
                $link->user_id = $request->user()->id;
                $link->ip = $request->ip();
                $link->password = Str::random(10);
                $link->domain = config('7ul.domain');
                if($request->code) {
                    $link->code = $request->code;
                }
                if($request->private) {
                    $link->private = $request->private;
                }
                if($request->type) {
                    $link->type = $request->type;
                }
                if($request->title) {
                    $link->title = $request->title;
                }
                if($request->body) {
                    $link->body = $request->body;
                }
                $link->save();

                if(!$request->code) {
                    $link->code = $link->encode(config('7ul.code-type'));
                    $link->save();
                }
                flash(__('Done!'))->success();
                return redirect()->route('manage',[$link->code, $link->password]);
            }
        } else {
            $link = new Link();
            $link->url = $request->url;
            $link->ip = $request->ip();
            $link->password = Str::random(10);
            $link->domain = config('7ul.domain');
            if($request->code) {
                $link->code = $request->code;
            }
            if($request->private) {
                $link->private = $request->private;
            }
            if($request->type) {
                $link->type = $request->type;
            }
            if($request->title) {
                $link->title = $request->title;
            }
            if($request->body) {
                $link->body = $request->body;
            }
            $link->save();

            if(!$request->code) {
                $link->code = $link->encode(config('7ul.code-type'));
                $link->save();
            }
            flash(__('Done!'))->success();
            return redirect()->route('manage',[$link->code, $link->password]);
        }

    }

    public function redirect($code)
    {
        if ($link = Link::whereCode($code)->first()) {
            $data = [];
            $agent = new Agent();
            $visit = new Visit();
            $country = $this->getCountry(request()->ip());
            $visit->link_id = $link->id;
            $visit->ip = request()->ip();
            $visit->device = $agent->device();
            $visit->country = $country['country'];
            $visit->country_code = $country['country_code'];
            $visit->platform = $agent->platform();
            $visit->platform_version = $agent->version($agent->platform());
            $visit->browser = $agent->browser();
            $visit->browser_version= $agent->version($agent->browser());
            if(isset($_SERVER['HTTP_REFERER'])) {
                $visit->referer = $_SERVER['HTTP_REFERER'];
            }
            $visit->data = $data;
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

    public function getCountry($ip)
    {
        try {
            $reader = new Reader(storage_path('geo/GeoLite2-Country.mmdb'));
            $record = $reader->country($ip);
            $country = $record->country->name;
            $country_code = $record->country->isoCode;
            return ['country' => $country, 'country_code' => $country_code];
        } catch (\Exception $e) {
            $country = __('Unknown');
            $country_code = __('Unknown');
            return ['country' => $country, 'country_code' => $country_code];
        }
    }

    public function lastLinks()
    {
        $links = Link::with(['visits'])->public()->latest()->limit(config('7ul.count-last-links', 5))->get();
        return response()->json($links,200);
    }

    public function statistics()
    {
        $statistics = [
           'total_links' =>  Link::count(),
           'total_users' =>  User::count(),
           'total_visits' =>  Visit::count(),
        ];
        return response()->json($statistics,200);
    }
}
