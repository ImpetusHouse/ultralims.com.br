<?php

namespace App\Services;
use GuzzleHttp\Client;

class Jira{

    protected $url, $token;

    public function __construct($url, $token){
        $this->url = $url;
        $this->token = $token;
    }

    public function createIssue($description){
        $client = new Client();

        $response = $client->post($this->url.'/rest/api/3/issue?startAt=0&maxResults=100', [
            'headers' => [
                'Authorization' => 'Basic '.$this->token, // Coloque o token de autorização correto aqui
                'Content-Type' => 'application/json',
            ],
            'json' => [
                'fields' => [
                    'summary' => '[Site] Teste',
                    'description' => [
                        'content' => [
                            [
                                'content' => [
                                    [
                                        'text' => $description,
                                        'type' => 'text'
                                    ]
                                ],
                                'type' => 'paragraph'
                            ]
                        ],
                        'type' => 'doc',
                        'version' => 1
                    ],
                    'project' => [
                        'id' => '10017',
                        'key' => 'EDS'
                    ],
                    'assignee' => null,
                    'issuetype' => [
                        'self' => $this->url.'/rest/api/2/issuetype/10005',
                        'id' => '10005'
                    ]
                ],
                'update' => new \stdClass(),
            ],
        ]);

        $data = json_decode($response->getBody(), true);

        return response()->json($data);
    }
}
