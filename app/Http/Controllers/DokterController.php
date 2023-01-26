<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use App\Token;
use App\Dokter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class DokterController extends Controller
{

    public function index(Request $request)
    {
        $dokter = null;
        if (isset($request->id)) {
            $id = $request->id;
            $request = $this->practitioner_id($id);
            if ($request) {
                $request = (object) 
                ['namaDokter' => $request['namaDokter'],
                 'gender' => $request['gender'],
                 'alamat'  => $request ['alamat' ],
                ];

                
                return view('dokter')->with('request', $request);
            } else {
                return view('dokter', compact([
                    'dokter',
                ]));
            } 
        }
        
        // dd($request);
        return view('dokter')->with('request', $request);
    }

    public function practitioner_id($id)
    {
        $client = new Client();
        $token = Token::latest()->first()->access_token;
        $url = "https://api-satusehat-dev.dto.kemkes.go.id/fhir-r4/v1/Practitioner/" . $id;

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

        //  Patient::create([
        //     'name' => $response->entry[0]->resource->name[0]->text,
        //     'gender'=> $response->entry[0]->resource->gender,
        //     'deceasedBoolean' => $response->entry[0]->resource->deceasedBoolean,
        //  ]);

        
        $namaDokter =  $response->name[0]->text;
        $gender = $response->gender;
        $alamat = $response->address[0]->line[0];
        // dd($alamat);

        return ([
            'namaDokter' => $namaDokter,
            'gender' => $gender,
            'alamat' => $alamat
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
    $dokter = null;
    if (isset($request->id)) {
        $id = $request->id;
        $request = $this->patient_nik($id);
        if ($request) {
            $json = json_encode($request);
            $object = json_decode($json);

            return view('greetings', ['request' => $request, 'object' => $object]);
        } else {
            return view('dokter', compact([
                'dokter',
            ]));
        } 
    }
    return view('caridokter');
}

}
