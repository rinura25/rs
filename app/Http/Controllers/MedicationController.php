<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use App\Token;
use App\Medication;
use Illuminate\Http\Request;

class MedicationController extends Controller
{
    public function index(Request $request){

    $medication = null;
        if (isset($request->kfa_code)) {
            $kfa_code = $request->kfa_code;
            $request = $this->store($kfa_code);               
            return view('medication')->with('request', $request);
        }
        return view('medication')->with('request', $request);
        dd($request);
      }
    public function store($kfa_code)
    {
        $client = new Client();
        $url = "https://api-satusehat-dev.dto.kemkes.go.id/fhir-r4/v1/Medication";
        $token = Token::latest()->first()->access_token;
        $body = [
            "resourceType" => "Medication",
            "meta" => [
                "profile" => [
                    "https://fhir.kemkes.go.id/r4/StructureDefinition/Medication"
                ]
            ],
            "identifier" => [
                [
                    "system" => "http://sys-ids.kemkes.go.id/medication/10000004",
                    "use" => "official",
                    "value" => "123456789"
                ]
            ],
            "code" => [
                "coding" => [
                    [
                        "system" => "http://sys-ids.kemkes.go.id/kfa",
                        "code" => $kfa_code,
                        "display" => "Obat Anti Tuberculosis / Rifampicin 150 mg / Isoniazid 75 mg / Pyrazinamide 400 mg / Ethambutol 275 mg Kaplet Salut Selaput (KIMIA FARMA)"
                    ]
                ]
            ],
            "status" => "active",
            "manufacturer" => [
                "reference" => "Organization/900001"
            ],
            "form" => [
                "coding" => [
                    [
                        "system" => "https://terminology.kemkes.go.id/CodeSystem/medication-form",
                        "code" => "BS023",
                        "display" => "Kaplet Salut Selaput"
                    ]
                ]
            ],
            "ingredient" => [
                [
                    "itemCodeableConcept" => [
                        "coding" => [
                            [
                                "system" => "http://sys-ids.kemkes.go.id/kfa",
                                "code" => "91000330",
                                "display" => "Rifampin"
                            ]
                        ]
                    ],
                    "isActive" => true,
                    "strength" => [
                        "numerator" => [
                            "value" => 150,
                            "system" => "http://unitsofmeasure.org",
                            "code" => "mg"
                        ],
                        "denominator" => [
                            "value" => 1,
                            "system" => "http://terminology.hl7.org/CodeSystem/v3-orderableDrugForm",
                            "code" => "TAB"
                        ]
                    ]
                ],
                [
                    "itemCodeableConcept" => [
                        "coding" => [
                            [
                                "system" => "http://sys-ids.kemkes.go.id/kfa",
                                "code" => "91000328",
                                "display" => "Isoniazid"
                            ]
                        ]
                    ],
                    "isActive" => true,
                    "strength" => [
                        "numerator" => [
                            "value" => 75,
                            "system" => "http://unitsofmeasure.org",
                            "code" => "mg"
                        ],
                        "denominator" => [
                            "value" => 1,
                            "system" => "http://terminology.hl7.org/CodeSystem/v3-orderableDrugForm",
                            "code" => "TAB"
                        ]
                    ]
                ],
                [
                    "itemCodeableConcept" => [
                        "coding" => [
                            [
                                "system" => "http://sys-ids.kemkes.go.id/kfa",
                                "code" => "91000329",
                                "display" => "Pyrazinamide"
                            ]
                        ]
                    ],
                    "isActive" => true,
                    "strength" => [
                        "numerator" => [
                            "value" => 400,
                            "system" => "http://unitsofmeasure.org",
                            "code" => "mg"
                        ],
                        "denominator" => [
                            "value" => 1,
                            "system" => "http://terminology.hl7.org/CodeSystem/v3-orderableDrugForm",
                            "code" => "TAB"
                        ]
                    ]
                ],
                [
                    "itemCodeableConcept" => [
                        "coding" => [
                            [
                                "system" => "http://sys-ids.kemkes.go.id/kfa",
                                "code" => "91000288",
                                "display" => "Ethambutol"
                            ]
                        ]
                    ],
                    "isActive" => true,
                    "strength" => [
                        "numerator" => [
                            "value" => 275,
                            "system" => "http://unitsofmeasure.org",
                            "code" => "mg"
                        ],
                        "denominator" => [
                            "value" => 1,
                            "system" => "http://terminology.hl7.org/CodeSystem/v3-orderableDrugForm",
                            "code" => "TAB"
                        ]
                    ]
                ]
            ],
            "extension" => [
                [
                    "url" => "https://fhir.kemkes.go.id/r4/StructureDefinition/MedicationType",
                    "valueCodeableConcept" => [
                        "coding" => [
                            [
                                "system" => "https://terminology.kemkes.go.id/CodeSystem/medication-type",
                                "code" => "NC",
                                "display" => "Non-compound"
                            ]
                        ]
                    ]
                ]
            ]
        ];

        dd($body);
        // try {
        $response = $client->post($url, [
            'headers' => [
                'Authorization' => 'Bearer ' . $token,
                'Accept' => 'application/json'
            ],
            'body' =>json_encode($body),
            'allow_redirects' => true,
            'timeout' => 20
        ]);
        $response = json_encode($response->getBody());
        return view('medication')->with('response', $response);
        // } catch (\GuzzleHttp\Exception\RequestException $ex) {
        //   return $ex->getResponse()->getBody()->getContents();
        // }
    }
}
