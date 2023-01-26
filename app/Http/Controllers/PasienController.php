<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use App\Token;
use App\Patient;
use Illuminate\Http\Request;

class PasienController extends Controller
{
    public function index(Request $request)
    {
        $patient = null;
        if (isset($request->nik)) {
            $nik = $request->nik;
            $request = $this->patient_nik($nik);
            if ($request) {
                $request = (object) 
                ['namaPasien' => $request['namaPasien'],
                 'gender' => $request['gender'],
                 'bahasa' => $request ['bahasa'],
                ];

                
                return view('pasien')->with('request', $request);
            } else {
                return view('pasien', compact([
                    'patient',
                ]));
            } 
        }
        
        // dd($request);
        return view('pasien')->with('request', $request);
    }

    public function patient_nik($nik)
    {
        $client = new Client();
        $token = Token::latest()->first()->access_token;
        $url = "https://api-satusehat-dev.dto.kemkes.go.id/fhir-r4/v1/Patient?identifier=https://fhir.kemkes.go.id/id/nik|" . $nik;

        $response = $client->request('GET', $url, [
            'headers' => [
                'Authorization' => 'Bearer ' . $token,
                'Accept' => 'application/json',
            ],
            'allow_redirects' => true,
            'timeout' => 10,
        ]);
        $response = json_decode($response->getBody());
        // return $response;

         Patient::create([
            'name' => $response->entry[0]->resource->name[0]->text,
            'gender'=> $response->entry[0]->resource->gender,
            'bahasa' => $response->entry[0]->resource->communication[0]->language->text,
         ]);


        $namaPasien =  $response->entry[0]->resource->name[0]->text;
        $gender = $response->entry[0]->resource->gender;
        $bahasa = $response->entry[0]->resource->communication[0]->language->text;

        return ([
            'namaPasien' => $namaPasien,
            'gender' => $gender,
            'bahasa' => $bahasa
        ]);
        // return view('pasien', [
        //     'namaPasien' => $namaPasien,
        //     'gender' => $gender,
        //     'bahasa' => $bahasa,
        // ]);

        // $entry = $response->entry[0];
        // $resource = $entry->resource;
        // dd($resource->communication[0]->text);

    }
    public function cari(Request $request)
{
    $patient = null;
    if (isset($request->nik)) {
        $nik = $request->nik;
        $request = $this->patient_nik($nik);
        if ($request) {
            $json = json_encode($request);
            $object = json_decode($json);

            return view('greetings', ['request' => $request, 'object' => $object]);
        } else {
            return view('pasien', compact([
                'patient',
            ]));
        } 
    }
    return view('caripasien');
}
}
