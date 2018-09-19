<?php

use Boleto\Caixa\Agente;
use Boleto\Caixa\Boleto;
use Boleto\Caixa\Retorno\Cobranca;
use Boleto\Caixa\WebService;
use Carbon\Carbon;
use GuzzleHttp\Client;
use PHPUnit\Framework\TestCase;

class WebServiceTest extends TestCase
{
    public function testInclusaoBoleto()
    {
//        $convenio   = getenv('CONVENIO');
//        $cnpj       = getenv('CNPJ');
//        $unidade    = getenv('UNIDADE');
//
//        $data = [
//            'nossoNumero'           => '14000000000000009',
//            'dataVencimento'        => Carbon::now('America/Sao_Paulo')->addDays(3),
//            'numeroDocumento'       => 'CCHP001',
//            'valor'                 => 60.00,
//            'dataEmissao'           => Carbon::today('America/Sao_Paulo'),
//            'aposVencimento'        => \Boleto\Caixa\Constants\PosVencimento::DEVOLVER,
//            'jurosMora'             => \Boleto\Caixa\Constants\Juros::ISENTO,
//            'fichaCompensacao'      => ['NAO RECEBER APOS O VENCIMENTO'],
//            'reciboPagador'         => ['Concurso público', 'Cargo: Analista de Sistemas']
//        ];
//
//        $agente = new Agente('Matheus Lopes Santos', '12345678909');
//        $boleto = new Boleto($convenio, $cnpj, $agente, $data);
//
//        $client = new Client();
//
//        $webService = new WebService($unidade, $client, $boleto);
//
//        $cobranca = $webService->geraBoleto();
//
//        $this->assertInstanceOf(Cobranca::class, $cobranca);
    }

    public function testConsultaBoleto()
    {
        $convenio   = getenv('CONVENIO');
        $cnpj       = getenv('CNPJ');
        $unidade    = getenv('UNIDADE');

        $data = [
            'nossoNumero'       => '14000000000000009',
            'dataVencimento'    => Carbon::now('America/Sao_Paulo')->addDays(3),
            'valor'             => 60.00,
        ];

        $agente = new Agente('Matheus Lopes Santos', '12345678909');
        $boleto = new Boleto($convenio, $cnpj, $agente, $data);

        $client = new Client();

        $webService = new WebService($unidade, $client, $boleto);

        echo "<pre>";
        print_r($webService->consultaBoleto());
        die();
    }
}
