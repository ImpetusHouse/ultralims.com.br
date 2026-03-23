<?php

namespace App\Jobs;

use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SendCrmContact implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $clientName;
    protected $clientEmail;
    protected $clientPhone;
    protected $clientPosition;
    protected $companyName;
    protected $product;
    protected $note;

    // Token e URL base da API (substituir por variáveis de ambiente em um ambiente real)
    private const API_TOKEN = 'aizen_oGBXTwgLYpmspRMbclKPtfiaXWnLotdUSvkhEtoZVBmnboZwYkCHhxmiUVEcvJvt'; // Token do CompaniesAndContactsCommand e DealsCommand
    private const BASE_URL = 'https://fine-bat-727.convex.site/api/v1';

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($clientName, $clientEmail, $clientPhone, $clientPosition, $companyName, $product, $note)
    {
        $this->clientName = $clientName;
        $this->clientEmail = $clientEmail;
        $this->clientPhone = $this->formatPhone($clientPhone); // Formata o telefone
        $this->clientPosition = $clientPosition;
        $this->companyName = $companyName;
        $this->product = $product;
        $this->note = $note;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            // 1. Criar Empresa (Organization)
            $companyId = $this->createCompany();

            if (!$companyId) {
                Log::error('Falha ao criar Empresa. Abortando job.');
                return;
            }

            // 2. Criar Contato (Contact)
            $contactId = $this->createContact($companyId);

            if (!$contactId) {
                Log::error('Falha ao criar Contato. Abortando job.');
                return;
            }

            // 3. Criar Negócio (Deal)
            $dealId = $this->createDeal($companyId, $contactId);

            if ($dealId) {
                Log::info("Empresa #{$companyId}, Contato #{$contactId} e Negócio #{$dealId} criados com sucesso!");
            } else {
                Log::error('Falha ao criar Negócio.');
            }

        } catch (Exception $e) {
            Log::error('Falha geral no SendCrmContact: ' . $e->getMessage());
        }
    }

    /**
     * Cria a empresa (organization) e retorna o ID.
     *
     * @return string|null
     */
    private function createCompany(): ?string
    {
        $payload = [
            'legalName' => $this->companyName,
            'tradeName' => $this->companyName,
            //'registrationId' => null, // Não temos CNPJ/CPF no job original
            'status' => 'Lead',
            //'address' => null, // Não temos endereço no job original
            'contactEmail' => $this->clientEmail,
            'contactPhone' => $this->clientPhone,
            'visibility' => 'All',
        ];

        $response = Http::withToken(self::API_TOKEN)
            ->post(self::BASE_URL . '/companies', $payload);

        if ($response->successful()) {
            $data = $response->json();
            return $data['data']['id'] ?? null;
        }

        Log::error('Erro ao criar empresa: ', $response->json());
        return null;
    }

    /**
     * Cria o contato e retorna o ID.
     *
     * @param string $companyId
     * @return string|null
     */
    private function createContact(string $companyId): ?string
    {
        $payload = [
            'name' => $this->clientName,
            'companyId' => $companyId,
            'position' => $this->clientPosition,
            'contactEmails' => [
                ['email' => $this->clientEmail, 'type' => 'work']
            ],
            'contactPhones' => [
                ['phone' => $this->clientPhone, 'type' => 'mobile']
            ],
            'visibility' => 'All',
        ];

        $response = Http::withToken(self::API_TOKEN)
            ->post(self::BASE_URL . '/contacts', $payload);

        if ($response->successful()) {
            $data = $response->json();
            return $data['data']['id'] ?? null;
        }

        Log::error('Erro ao criar contato: ', $response->json());
        return null;
    }

    /**
     * Cria o negócio (deal) e retorna o ID.
     *
     * @param string $companyId
     * @param string $contactId
     * @return string|null
     */
    private function createDeal(string $companyId, string $contactId): ?string
    {
        $products = [];
        if (!empty($this->product)) {
            $products[] = [
                'name' => $this->product,
                //'quantity' => 1,
                //'price' => 0.00,
                'isRecurring' => false
            ];
        }

        $payload = [
            'name' => $this->product ?? $this->companyName,
            'companyId' => $companyId,
            'contactId' => $contactId,
            'salesFunnelId' => 'm5778vegffntre8dwrcbk5hkkx7t21yx',
            'salesFunnelStageId' => 'm179kpjsb2zj283vy4zras3dpn7t3e3h', // Não temos essa informação, mantendo o fluxo básico
            'sourceChannel' => 'Site', // Baseado no job original 'website'
            'products' => $products,
            'services' => [],
            'visibility' => 'All',
            // O campo 'note' do job original pode ser usado para adicionar uma observação
            'observations' => $this->note,
        ];

        $response = Http::withToken(self::API_TOKEN)
            ->post(self::BASE_URL . '/deals', $payload);

        if ($response->successful()) {
            $data = $response->json();
            return $data['data']['dealId'] ?? null;
        }

        Log::error('Erro ao criar negócio: ', $response->json());
        return null;
    }

    /**
     * Formata um número de telefone para o padrão +55 (DD) NNNNN-NNNN (exemplo).
     *
     * @param string|null $phone
     * @return string|null
     */
    private function formatPhone(?string $phone): ?string
    {
        if (empty($phone)) {
            return null;
        }
        $phone = preg_replace("/[^0-9]/", "", $phone);

        // Adiciona o código do país se não estiver presente e for um número brasileiro
        if (strlen($phone) >= 10 && strlen($phone) <= 11 && substr($phone, 0, 2) !== '55') {
            $phone = '55' . $phone;
        }

        // Simplesmente retorna o número formatado com o prefixo +
        if (strlen($phone) >= 12 && substr($phone, 0, 2) === '55') {
            return '+' . $phone;
        }

        return $phone; // Retorna o número original se não puder ser formatado
    }
}