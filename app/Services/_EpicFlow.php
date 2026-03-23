<?php
namespace App\Services;

use App\Models\Settings\Integration;
use GuzzleHttp\Client;

class EpicFlow
{
    protected $client, $integration;

    public function __construct(){
        $this->integration = Integration::where('title', 'EpicFlow')->first();
        $this->client = new Client([
            'base_uri' =>  $this->integration->url,
            'headers' => [
                'Authorization' => 'Bearer ' . $this->integration->token,
                'Content-Type' => 'application/json',
            ],
        ]);
    }

    public function sendTemplateMessage($client_name, $product, $phone, $email){
        $payload = [
            'phone' => '+55 '.$phone,
            'template' => [
                'name' => 'site',
                'language' => [
                    'code' => 'pt_br'
                ],
                'components' => [
                    [
                        'type' => 'header',
                        'parameters' => [
                            [
                                'type' => 'image',
                                'image' => [
                                    'link' => 'https://ultralims.com.br/images/wpp.jpg' // Substitua pela URL da imagem
                                ]
                            ]
                        ]
                    ],
                    [
                        'type' => 'body',
                        'parameters' => [
                            [
                                'type' => 'text',
                                'text' => $client_name
                            ],
                            [
                                'type' => 'text',
                                'text' => $product
                            ],
                            [
                                'type' => 'text',
                                'text' => 'Marcele'
                            ]
                        ]
                    ]
                ]
            ],
            'email' => $email
        ];

        $response = $this->client->post('api/send/template', [
            'json' => $payload // Use 'json' para que Guzzle envie os dados no formato JSON
        ]);

        return json_decode($response->getBody(), true);
    }
}
