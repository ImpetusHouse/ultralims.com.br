<?php
// app/Services/OpenAIService.php
namespace App\Services;

use App\Models\Settings\Integration;
use GuzzleHttp\Client;

class OpenAIService
{
    protected $client, $integration;

    public function __construct(){
        $this->integration = Integration::where('title', 'OpenAI')->first();
        $this->client = new Client([
            'base_uri' => 'https://api.openai.com/v1/',
            'headers' => [
                'Authorization' => 'Bearer ' . $this->integration->key,
                'Content-Type' => 'application/json',
            ],
        ]);
    }

    public function getResponse($prompt){
        $response = $this->client->post('chat/completions', [
            'json' => [
                'model' => $this->integration->model,
                'messages' => [
                    ['role' => 'system', 'content' => 'Você é um assistente útil.'],
                    ['role' => 'user', 'content' => $prompt],
                ],
                'temperature' => floatval($this->integration->temperature),
            ],
        ]);

        return json_decode($response->getBody(), true)['choices'][0]['message']['content'];
    }

    public function generateImage($prompt, $size = '1024x1024'){
        $response = $this->client->post('images/generations', [
            'json' => [
                'prompt' => $prompt,
                'size' => $size,
            ],
        ]);

        return json_decode($response->getBody(), true)['data'][0]['url'];
    }
}
