<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use App\Token;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    public function index_get(Request $request)
    {
        $id = null;
        $description = null;
        $line = null;
        $name = null;
        if (isset($request->id)) {
            $id = $request->id;
            $request = $this->location_id($id);
            if ($request) {
                $request = (object)
                [
                    'name' => $request['name'],
                    'id' => $request->id,
                    'description' => $request['description'],
                    'line' => $request['line'],
                ];

                return view('location')->with('request', $request);
            } else {
                return view('location', compact([
                    'location',
                ]));
            }
            
        }

        // dd($request);
        return view('location')->with('request', $request);
    }

    public function location_id($id)
    {
        $client = new Client();
        $token = Token::latest()->first()->access_token;
        $url = "https://api-satusehat-dev.dto.kemkes.go.id/fhir-r4/v1/Location/" . $id;

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

        //  Organization::create([
        //     'id' => $response->address[0]->resource->name[0]->text,
        //     'name' => $response->entry[0]->resource->name[0]->text,
        //     'city' => $response->entry[0]->resource->name[0]->text,
        //     'country' => $response->entry[0]->resource->name[0]->text,
        //  ]);

        $line =  $response->address->line[0];
        $description = $response->description;
        $name = $response->name;
        // dd($name, $description, $line,$id);
        // return ([
        //     'city' => $city,
        //     'id' => $id,
        //     'name' => $name,
        //     'country' => $country,
        // ]);
        return view('location', [
            'name' => $name,
            'description' => $description,
            'line' => $line,
            'id' => $id,
        ]);
    }
    public function index_create(Request $request)
    {
        return view('location_create')->with('request', $request);
    }
    public function create_location(Request $request)
    {
        $client = new Client();
        $token = Token::latest()->first()->access_token;
        $url =  "https://api-satusehat-dev.dto.kemkes.go.id/fhir-r4/v1/Location/";
        $body =  [
            "resourceType" => "Location",
            "identifier" => [
                [
                    "system" => "http://sys-ids.kemkes.go.id/location/1000001",
                    "value" => "G-2-R-1A"
                ]
            ],
            "status" => "active",
            "name" => $request->name,
            "description" => $request->description,
            "mode" => "instance",
            "telecom" => [
                [
                    "system" => "phone",
                    "value" => $request->phone,
                    "use" => "work"
                ],
                [
                    "system" => "email",
                    "value" => $request->email
                ],
            ],
            "address" => [
                "use" => "work",
                "line" => [
                    $request->line
                ],
                "city" => $request->city,
                "postalCode" => $request->postalCode,
                "country" => "ID",
                "extension" => [
                    [
                        "url" => "https://fhir.kemkes.go.id/r4/StructureDefinition/administrativeCode",
                        "extension" => [
                            [
                                "url" => "province",
                                "valueCode" => "10"
                            ],
                            [
                                "url" => "city",
                                "valueCode" => "1010"
                            ],
                            [
                                "url" => "district",
                                "valueCode" => "1010101"
                            ],
                            [
                                "url" => "village",
                                "valueCode" => "1010101101"
                            ],
                            [
                                "url" => "rt",
                                "valueCode" => "1"
                            ],
                            [
                                "url" => "rw",
                                "valueCode" => "2"
                            ]
                        ]
                    ]
                ]
            ],
            "physicalType" => [
                "coding" => [
                    [
                        "system" => "http://terminology.hl7.org/CodeSystem/location-physical-type",
                        "code" => "ro",
                        "display" => "room"
                    ]
                ]
            ],
            "position" => [
                "longitude" => -6.2311542627577,
                "latitude" => 106.83239885394,
                "altitude" => 0
            ],
            "managingOrganization" => [
                "reference" => "Organization/10000004"
            ]
        ];

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

        $city =  $response->address->city;
        $country =  $response->address->country;
        $line =  $response->address->line;
        $postalCode =  $response->address->postalCode;
        $description = $response->description;
        $name = $response->name;
        $id = $response->id;
        // dd($name, $description, $line, $city,$postalCode, $country,$id);
        // return view('location')->with('response', $response);
    }
}
