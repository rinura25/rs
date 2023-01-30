<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use App\Token;
use Illuminate\Http\Request;
use Carbon\Carbon;

class EncounterController extends Controller
{
    // public function index()
    // {
    //     $current_date_time = \Carbon\Carbon::now()->format('Y-m-d\TH:i:sP');
    //     dd($current_date_time);
    // }
    
    
    public function index_get(Request $request)
    {
        $nama_pasien = null;
        $nama_dokter = null;
        $tanggal = null;
        $nama_lokasi = null;
        if (isset($request->id)) {
            $id = $request->id;
            $request = $this->encounter_id($id);
            if ($request) {
                $request = (object)
                [
                    'nama_pasien' => $request['nama_pasien'],
                    'nama_dokter' => $request['nama_dokter'],
                    'tanggal' => $request['tanggal'],
                    'nama_lokasi' => $request['nama_lokasi'],
                ];

                return view('encounter')->with('request', $request);
            } else {
                return view('encounter', compact([
                    'encounter',
                ]));
            }
        }

        // dd($request);
        
        return view('encounter')->with('request', $request);
    }

    public function encounter_id($id)
    {
        $client = new Client();
        $token = Token::latest()->first()->access_token;
        $url = "https://api-satusehat-dev.dto.kemkes.go.id/fhir-r4/v1/Encounter/" . $id;
        $response = $client->request('GET', $url, [
            'headers' => [
                'Authorization' => 'Bearer ' . $token,
                'Accept' => 'application/json',
            ],
            // 'form_params' =>[
            //     'id' => 'abddd50b-b22f-4d68-a1c3-d2c29a27698b',
            // ],
            'allow_redirects' => true,
            'timeout' => 10,
        ]);
        $response = json_decode($response->getBody());

        //  encounter::create([
        //     'id' => $response->address[0]->resource->name[0]->text,
        //     'name' => $response->entry[0]->resource->name[0]->text,
        //     'city' => $response->entry[0]->resource->name[0]->text,
        //     'country' => $response->entry[0]->resource->name[0]->text,
        //  ]);

        $nama_pasien = $response->subject->display;
        $nama_dokter = $response->participant[0]->individual->display;
        $nama_lokasi = $response->location[0]->location->display;
        $tanggal     = $response->statusHistory[0]->period->start;
        // return ([
        //     'city' => $city,
        //     'id' => $id,
        //     'name' => $name,
        //     'country' => $country,
        // ]);
        return view('encounter', [
            'nama_pasien' => $nama_pasien,
            'nama_dokter' => $nama_dokter,
            'tanggal' => $tanggal,
            'nama_lokasi' => $nama_lokasi,
        ]);
    }
    public function index_create(Request $request)
    {
        return view('encounter_create')->with('request', $request);
    }
    public function create_encounter(Request $request)
    {
        $client = new Client();
        $token = Token::latest()->first()->access_token;
        $url =  "https://api-satusehat-dev.dto.kemkes.go.id/fhir-r4/v1/Encounter/";
        $date = Carbon::now('Asia/Jakarta');
        $timestamp = $date->format('Y-m-d\TH:i:sP');
        $body = [
            "resourceType" => "Encounter",
            "status" => "arrived",
            "class" => [
                "system" => "http://terminology.hl7.org/CodeSystem/v3-ActCode",
                "code" => "AMB",
                "display" => "ambulatory"
            ],
            "subject" => [
                "reference" => "Patient/" . $request->id_pasien,
                "display" => $request->nama_pasien
            ],
            "participant" => [
                [
                    "type" => [
                        [
                            "coding" => [
                                [
                                    "system" => "http://terminology.hl7.org/CodeSystem/v3-ParticipationType",
                                    "code" => "ATND",
                                    "display" => "attender"
                                ]
                            ]
                        ]
                    ],
                    "individual" => [
                        "reference" => "Practitioner/".$request->id_dokter,
                        "display" => $request->nama_dokter
                    ]
                ]
            ],
            "period" => [
                "start" => $timestamp
            ],
            "location" => [
                [
                    "location" => [
                        "reference" => "Location/".$request->id_lokasi,
                        "display" => $request->nama_lokasi
                    ]
                ]
            ],
            "statusHistory" => [
                [
                    "status" => "arrived",
                    "period" => [
                        "start" => $timestamp
                    ]
                ]
            ],
            "serviceProvider" => [
                "reference" => "Organization/10000004"
            ],
            "identifier" => [
                [
                    "system" => "http://sys-ids.kemkes.go.id/encounter/10000004",
                    "value" => "P20240001"
                ]
            ]
        ];
        // try{
        $response = $client->post($url, [
            'headers' => [
                'Authorization' => 'Bearer ' . $token,
                'Accept' => 'application/json'
            ],
            'body' => json_encode($body),
            'allow_redirects' => true,
            'timeout' => 20
        ]);
        $response = json_decode($response->getBody());
        $id_pasien   = $response->subject->reference;
        $nama_pasien = $response->subject->display;
        $id_dokter = $response->participant[0]->individual->display;
        $nama_dokter = $response->participant[0]->individual->reference;
        $id_lokasi = $response->location[0]->location->display;
        $nama_lokasi = $response->location[0]->location->reference;
        $arrival     = $response->statusHistory[0]->period->start;

        dd($id_pasien, $nama_pasien, $id_dokter, $nama_dokter, $id_lokasi, $nama_lokasi, $arrival); 
        return view('encounter_create')->with('response', $response);
        // } catch (\GuzzleHttp\Exception\RequestException $ex) {
        //   return $ex->getResponse()->getBody()->getContents();
        // }
    }
}
