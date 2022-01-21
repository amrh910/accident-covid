<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pref;
use Auth;

class UserController extends Controller
{
    function setPreference($country, $name, $id)
    {
        $user = Pref::where('user', $id)->first();
        if(!$user)
        {
            $mine = array();
            $mine[$country] = $name;
            $thisUser = new Pref;
            $thisUser->user = $id;
            $thisUser->pref = json_encode($mine);
            $thisUser->save();

            return true;
        }
        else
        {
            $mine = $user->pref;
            $mine = json_decode($mine, true);
            $mine[$country] = $name;
            $user->pref = $mine;
            $user->save();
            
            return true;
        }
    }

    public function removePreference(Request $request)
    {
        $id = Auth::id();
        $country = $request->input('country');
        $pref = Pref::where('user', $id)->first();
        $countries = json_decode($pref->pref, true);
        unset($countries[$country]);
        $pref->pref = $countries;
        $pref->save();

        return true;
    }
}
