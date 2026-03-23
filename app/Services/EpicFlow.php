<?php
namespace App\Services;

use App\Models\Settings\Integration;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class EpicFlow
{
    protected $client, $integration;

    public function __construct(){
        $this->integration = Integration::where('title', 'EpicFlow')->first();
        $this->client = new Client([
            'base_uri' =>  $this->integration->url,
            'headers' => [
                'Authorization' => 'Bearer ' . $this->integration->token,
                'Content-Type'  => 'application/json',
                'Accept'        => 'application/json',
            ],
        ]);
    }

    public function sendTemplateMessage($client_name, $product, $phone, $email)
    {
        // Tratamento simples para separar nome e sobrenome
        $nameParts = explode(' ', trim($client_name), 2);
        $firstName = $nameParts[0];
        $lastName  = $nameParts[1] ?? '';

        $payload = [
            'first_name'      => $firstName,
            'last_name'       => $lastName,
            'whatsapp_number' => '55' . preg_replace('/\D/', '', $phone),
            'email'           => $email,
            'template_id'     => '98c1ad59-528c-4c4c-a5ec-cf1c04a6faec',
            'template_variables' => [
                '1' => $firstName,
                '2' => $product,
                '3' => 'Marcele'
            ],
            'header_media_url' => 'https://ultralims.com.br/images/wpp.jpg'
        ];

        try {
            $response = $this->client->post('send-template', [
                'json' => $payload
            ]);

            Log::info('EpicFlow Send: ', json_decode($response->getBody(), true));
        } catch (\Exception $e) {
            Log::info('EpicFlow Error: ', [
                'error' => true,
                'message' => $e->getMessage()
            ]);
        }
    }
}