<?php

namespace App\Http\Controllers\API\V1;


use App\Link;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Validator;
use App\Http\Controllers\Controller;
use Reshadman\BijectiveShortener\BijectiveShortener;

class LinkController extends Controller
{
    public function shorten(Request $request)
    {
        $validator  = Validator::make($request->all(),[
            'type'    => 'string|nullable',
            'url'     => 'url|required',
            'private' => 'boolean|nullable',
            'code'    => 'unique:links,code|nullable',
            'title'   => 'string|nullable',
            'body'    => 'string|nullable',
        ]);

        if ($validator->fails()) {
            return response()->json(['code' => 0, 'errors' => $validator->messages()], 200);
        } else {
            if($link = Link::ofUser($request->user()->id)->where('url',$request->url)->first()) {
                return response()->json(['code' => 1, 'link' => ['password' => $link->password, 'short_url' => $link->domain . $link->code  ,'new' => 'no']], 200);
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
                return response()->json(['code' => 1, 'link' => ['password' => $link->password, 'short_url' => $link->domain . $link->code ,'new' => 'yes']], 200);
            }
        }
    }
}
