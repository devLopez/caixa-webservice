<?php

use Boleto\Caixa\Agente;
use Boleto\Caixa\Boleto;
use Boleto\Caixa\WebService;
use Carbon\Carbon;
use GuzzleHttp\Client;
use PHPUnit\Framework\TestCase;

class WebServiceTest extends TestCase
{
    public function testInclusaoBoleto()
    {
        $convenio   = getenv('CONVENIO');
        $cnpj       = getenv('CNPJ');
        $unidade    = getenv('UNIDADE');

        $data = [
            'nossoNumero'           => '14000000000000001',
            'dataVencimento'        => Carbon::now()->addDays(3),
            'numeroDocumento'       => 'CCHP001',
            'valor'                 => 60.00,
            'dataEmissao'           => Carbon::today(),
            'jurosMora'             => \Boleto\Caixa\Constants\Juros::ISENTO,
            'aposVencimento'        => \Boleto\Caixa\Constants\PosVencimento::DEVOLVER,
            'diasAposVencimento'    => 999,
            'fichaCompensacao'      => ['NAO RECEBER APOS O VENCIMENTO'],
            'reciboPagador'         => ['NAO RECEBER APOS O VENCIMENTO']
        ];

        $agente = new Agente('Matheus Lopes Santos', '12345678909');
        $boleto = new Boleto($convenio, $cnpj, $agente, $data);

        $client = new Client();

        $webService = new WebService($unidade, $client, $boleto);
        echo "<pre>";
        print_r($webService->geraBoleto());
        die();
    }
}
