<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use App\Token;


class TokenController extends Controller
{

    public function get_token()
    {
        $AUTH = 'https://api-satusehat-dev.dto.kemkes.go.id/oauth2/v1/accesstoken?grant_type=client_credentials';
        $client = new Client();
        $data = [
            'client_id' => env('CLIENT_ID'),
            'client_secret' => env('CLIENT_SECRET')
        ];
        $response = $client->request('POST', $AUTH, [
            'form_params' => $data,
            'allow_redirects' => true,
            'timeout' => 20
        ]);
        $response = json_decode($response->getBody());

        Token::create([
            'access_token' => $response->access_token,
            'application_name'=> $response->application_name,
            'organization_name'=> $response->organization_name,
            'token_type'=> $response->token_type,
            'issued_at'=> $response->issued_at,
        ]);
        $access_token =  $response->access_token;
        return view('status', [
            'access_token' => $access_token,
        ]);
    }
}
