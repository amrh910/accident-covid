<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class ApiController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    function getMapData()
    {
        
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://data.covid19india.org/state_district_wise.json',
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
        unset($response['State Unassigned']);

        $result = array();
        foreach($response as $resp)
        {
            $stat = array();
            $conf = 0;
            $deceased = 0;
            $recovered = 0;
            foreach($resp['districtData'] as $data)
            {
                $stat['confirmed']  = $conf + intval($data['confirmed']);
                $stat['deceased']  = $deceased + intval($data['deceased']);
                $stat['recovered'] = $recovered + intval($data['recovered']);
            }
            $result[$resp['statecode']] = $stat;
        }

        unset($response);
        
        return $result;
    }
    
    public function getCountry(Request $request)
    {
        $country = $request->input('country');
        $name = $request->input('name');
        
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://covid.mathdro.id/api/countries/'.$country,
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

        $res = array();
        $res['country'] = urldecode($name);
        $res['deaths'] = $response['deaths']['value'];
        $res['recovered'] = $response['recovered']['value'];
        $res['confirmed'] = $response['confirmed']['value'];
        unset($response);

        (new UserController)->setPreference($country, $name, Auth::id());
        
        return $res;
    }
}
