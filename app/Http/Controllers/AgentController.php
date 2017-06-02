<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use View;
use Sentinel;
use App\User;
use App\UserMeta;
use App\Suburbs;
use Carbon\Carbon;
use Hash;
use App\Agents;
use App\Reviews;
use App\Property;
use Response;
use Image;
use App\Services\AgentService;

class AgentController extends Controller
{
    public function dashboard()
    {
        $id = Sentinel::getUser()->id;
        $data = app(AgentService::class)->getData($id);
        $data['isOwner'] = true;
        return View::make('dashboard/agent/profile')->with('meta', $data['meta'])->with('dp', $data['dp'])->with('cp', $data['cp'])->with('data', $data);
    }

    public function edit()
    {
        $user_id =  Agents::where('agent_id', '=', Sentinel::getUser()->id)->first()->agency_id;

        $meta = UserMeta::where('user_id', $user_id)->get();
        $data = array();
        $data['summary'] = '';
        $data['profile-photo'] = 'assets/default.png';
        $data['cover-photo'] = 'assets/default_cover_photo.jpg';

        foreach ($meta as $key) {
            $data[$key->meta_name] = $key->meta_value;
        }


        return View::make('dashboard/agent/edit')->with('data', $data);
    }

    public function updateProfile(Request $request)
    {

        if(Sentinel::check()) {
            $routeId = $request->route('id') ? $request->route('id') : Sentinel::getUser()->id;
            $user_id =  Agents::where('agent_id', '=', $routeId)->first()->agency_id;

            $meta_name = array('cover-photo', 'profile-photo', 'agency-name', 'trading-name', 'principal-name', 'business-address', 'website', 'phone', 'abn', 'base-commission', 'marketing-budget', 'sales-type', 'summary');

            foreach ($meta_name as $meta) {


                if ($request->hasFile($meta)) {
                    $localpath = 'user/user-'.$user_id.'/uploads';
                    $filename = 'img'.rand().'-'.Carbon::now()->format('YmdHis').'.'.$request->file($meta)->getClientOriginalExtension();
                    $path = $request->file($meta)->move(public_path($localpath), $filename);
                    $value = $localpath.'/'.$filename;
                    Image::make($value)->orientate()->save($value);
                } else {
                    $value = $request->input($meta);
                }

                if($value !== null){
                    UserMeta::updateOrCreate(
                        ['user_id' => $user_id, 'meta_name' => $meta],
                        ['user_id' => $user_id, 'meta_name' => $meta, 'meta_value' => $value]
                    );
                }

            }

            return redirect(env('APP_URL').'/dashboard/agent/profile');

        } else {
            return redirect('');
        }
    }

    public function settings()
    {

        $meta = UserMeta::where('user_id', Sentinel::getUser()->id)->get();
        $agents = DB::table('users')
            ->join('agents', function ($join) {
                $join->on('users.id', '=', 'agents.agent_id')
                    ->where('agents.agency_id', '=', Sentinel::getUser()->id);
            })
            ->get();
        $data = array();


        foreach ($meta as $key) {
            $data[$key->meta_name] = $key->meta_value;
        }

        $data['name'] = Sentinel::getUser()->name;
        $data['email'] = Sentinel::getUser()->email;
        $data['password'] = Sentinel::getUser()->password;

        return View::make('dashboard/agent/settings')->with('data', $data)->with('agents', $agents);
    }

    public function updateSettings(Request $request)
    {
        if(Sentinel::check())
        {
            $id = Sentinel::getUser()->id;

            if($request->input('password') == ''){
                User::updateOrCreate(
                    ['id' => $id],
                    ['id' => $id, 'email' => $request->input('email'), 'name' => $request->input('name')]);
            } else {
                $password = Hash::make($request->input('password'));
                User::updateOrCreate(
                    ['id' => $id],
                    ['id' => $id, 'email' => $request->input('email'), 'name' => $request->input('name'), 'password' => $password]);
            }
            return redirect()->back();
        } else {
            return redirect(env('APP_URL'));
        }

    }

    public function helpful(Request $request){
        $review = Reviews::where('id', '=', $request->input('id'))->get();

        $data['count'] = $review[0]['helpful'] + 1;

        Reviews::where('id', '=', $request->input('id'))->update(['helpful' => $data['count']]);

        return Response::json($data, 200);
    }
}
