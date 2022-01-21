<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pref;
use Auth;

class DefaultController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }
    
    function getWorld()
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://covid.mathdro.id/api',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        $response = json_decode($response, true);

        $world = array();
        $world['deaths'] = $response['deaths']['value'];
        $world['recovered'] = $response['recovered']['value'];
        $world['confirmed'] = $response['confirmed']['value'];
        unset($response);

        return $world;
    }

    function countryList()
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://covid.mathdro.id/api/countries',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        $response = json_decode($response, true);

        return $response['countries'];
    }
    
    public function index()
    {
        if(Auth::check())
        {
            $countries = $this->countryList();
            $world = $this->getWorld();

            $mapdata = (new ApiController)->getMapData();

            $user = Auth::id();
            $pref = Pref::where('user', $user)->first();

            if(isset($pref))
            {
                $dashboard = array();
                $myCountry = $pref->pref;
                $myCountry = json_decode($myCountry, true);
                
                foreach($myCountry as $key=>$country)
                {
                    $input = new Request();
                    $input->replace(['country' => $key, 'name' => $country]);
                    $result = (new ApiController)->getCountry($input);
                    $result['code'] = $key;
                    array_push($dashboard, $result);
                }
            }
            else
            {
                $dashboard = null;
            }
            
            
            return view('pages.dashboard', compact('countries', 'world', 'dashboard', 'mapdata'));
        }
        else
        {
            return view('pages.home');
        }
    }
}
