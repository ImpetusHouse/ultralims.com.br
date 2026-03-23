<?php

namespace App\Console\Commands\UltraLims;

use Illuminate\Console\Command;
use Goutte\Client;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ScrapeInmetroLaboratories extends Command
{
    protected $signature = 'scrape:inmetro';
    protected $description = 'Scrape laboratory links from Inmetro website and generate an Excel report';

    public function handle()
    {
        $client = new Client();
        $baseUrl = 'http://www.inmetro.gov.br/laboratorios/rble/lista_laboratorios.asp?sigLab=CRL&ordem=&tituloLab=&uf=&pais=&descr_escopo=&classe_ensaio=&area_atividade=&ind_tipo_busca=&pagina=';

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Laboratórios');

        // Definindo os títulos das colunas
        $headers = [
            'Número da Acreditação',
            'Data da Acreditação',
            'ACREDITAÇÃO VIGENTE',
            'Razão Social',
            'Laboratório',
            'Endereço',
            'Bairro',
            'Cidade',
            'CEP',
            'UF',
            'País',
            'Telefone',
            'Fax',
            'Gerente Técnico',
            'Email'
        ];

        // Escrevendo os títulos no Excel
        $column = 'A';
        foreach ($headers as $header) {
            $sheet->setCellValue($column . '1', $header);
            $column++;
        }

        $rowIndex = 2; // Linha de início dos dados

        for ($i = 1; $i <= 68; $i++) {
            $url = $baseUrl . $i;
            $crawler = $client->request('GET', $url);

            $crawler->filter('td.tabelaLinha1px a.menuHP')->each(function ($node) use ($client, &$sheet, &$rowIndex) {
                $labLink = 'http://www.inmetro.gov.br/laboratorios/rble/' . $node->attr('href');
                $labDetails = $this->getLaboratoryDetails($client, $labLink);

                // Escrevendo os detalhes do laboratório no Excel
                $column = 'A';
                foreach ($labDetails as $value) {
                    $sheet->setCellValue($column . $rowIndex, $value);
                    $column++;
                }
                $rowIndex++;
            });
        }

        // Salvando o arquivo Excel
        $writer = new Xlsx($spreadsheet);
        $writer->save('inmetro_laboratorios.xlsx');

        $this->info('Excel file "inmetro_laboratorios.xlsx" created successfully.');

        return 0;
    }

    private function getLaboratoryDetails($client, $url)
    {
        $crawler = $client->request('GET', $url);

        $details = [];
        $fields = [
            'Número da Acreditação',
            'Data da Acreditação',
            'ACREDITAÇÃO VIGENTE',
            'Razão Social',
            'Laboratório',
            'Endereço',
            'Bairro',
            'Cidade',
            'CEP',
            'UF',
            'País',
            'Telefone',
            'Fax',
            'Gerente Técnico',
            'Email'
        ];

        foreach ($fields as $field) {
            $value = $crawler->filterXPath("//td[contains(text(), '$field')]/following-sibling::td")->text(null, false);
            $details[] = trim($value);
        }

        return $details;
    }
}
