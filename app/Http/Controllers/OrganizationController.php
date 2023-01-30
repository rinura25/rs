<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use App\Token;
use Illuminate\Http\Request;

class OrganizationController extends Controller
{
    public function index_get(Request $request)
    {
        $name = null;
        $id = null;
        $city = null;
        $country = null;
        if (isset($request->id)) {
            $id = $request->id;
            $request = $this->organization_id($id);
            if ($request) {
                $request = (object)
                [
                    'name' => $request['name'],
                    'id' => $request['id'],
                    'city' => $request['city'],
                    'country' => $request['country'],
                ];

                return view('organization')->with('request', $request);
            } else {
                return view('organization', compact([
                    'organization',
                ]));
            }
        }

        // dd($request);
        return view('organization')->with('request', $request);
    }

    public function organization_id($id)
    {
        $client = new Client();
        $token = Token::latest()->first()->access_token;
        $url = "https://api-satusehat-dev.dto.kemkes.go.id/fhir-r4/v1/Organization/" . $id;

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

        $city =  $response->address[0]->city;
        $id = $response->id;
        $name = $response->name;
        $country = $response->address[0]->country;

        // return ([
        //     'city' => $city,
        //     'id' => $id,
        //     'name' => $name,
        //     'country' => $country,
        // ]);
        return view('organization', [
            'city' => $city,
            'id' => $id,
            'name' => $name,
            'country' => $country,
        ]);
    }
    public function index_create(Request $request)
    {

        return view('organization_create')->with('request', $request);
    }
    public function create_organization(Request $request)
    {
        $client = new Client();
        $token = Token::latest()->first()->access_token;
        $url =  "https://api-satusehat-dev.dto.kemkes.go.id/fhir-r4/v1/Organization/";
        $body = [
            "resourceType" => "Organization",
            "active" => true,
            "identifier" => [
                [
                    "use" => "official",
                    "system" => "http://sys-ids.kemkes.go.id/organization/1000079374",
                    "value" => "Pos Imunisasi LUBUK BATANG"
                ]
            ],
            "type" => [
                [
                    "coding" => [
                        [
                            "system" => "http://terminology.hl7.org/CodeSystem/organization-type",
                            "code" => "dept",
                            "display" => "Hospital Department"
                        ]
                    ]
                ]
            ],
            "name" => $request->name,
            "telecom" => [
                [
                    "system" => "phone",
                    "value" => $request->phone,
                    "use" => "work"
                ],
                [
                    "system" => "email",
                    "value" => $request->email,
                    "use" => "work"
                ],
                [
                    "system" => "url",
                    "value" => "www.rs-satusehat@gmail.com",
                    "use" => "work"
                ]
            ],
            "address" => [
                [
                    "use" => "work",
                    "type" => "both",
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
                                    "valueCode" => "31",
                                ],
                                [
                                    "url" => "city",
                                    "valueCode" =>  "3171",
                                ],
                                [
                                    "url" => "district",
                                    "valueCode" =>  "317101",
                                ],
                                [
                                    "url" => "village",
                                    "valueCode" =>  "31710101",
                                ]
                            ]
                        ]
                    ]
                ]
            ],
            "partOf" => [
                "reference" => "Organization/10000004",
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

        $id_org =  $response->id;
        $name = $response->name;

        dd($id_org, $name);
        return view('organization_create')->with('response', $response);
    }
}
