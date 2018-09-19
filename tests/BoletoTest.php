<?php

use Boleto\Caixa\Agente;
use Boleto\Caixa\Boleto;
use Boleto\Caixa\Interfaces\BoletoInterface;
use Carbon\Carbon;

class BoletoTest extends PHPUnit_Framework_TestCase
{
    public function testBoleto()
    {
        $convenio   = getenv('CONVENIO');
        $cnpj       = getenv('CNPJ');

        $agente = new Agente('Matheus Lopes Santos', '12345678909');
        $boleto = new Boleto($convenio, $cnpj, $agente);

        $this->assertInstanceOf(BoletoInterface::class, $boleto);
    }

    public function testBoletoData()
    {
        $convenio   = getenv('CONVENIO');
        $cnpj       = getenv('CNPJ');

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

        $this->assertEquals($data['nossoNumero'], $boleto->getNossoNumero());
        $this->assertInstanceOf(Carbon::class, $boleto->getDataVencimento());
        $this->assertEquals($data['numeroDocumento'], $boleto->getNumeroDocumento());
        $this->assertEquals($data['valor'], $boleto->getValor());
        $this->assertInstanceOf(Carbon::class, $boleto->getDataEmissao());
        $this->assertEquals(\Boleto\Caixa\Constants\Juros::ISENTO, $boleto->getJurosMora());
        $this->assertEquals(\Boleto\Caixa\Constants\PosVencimento::DEVOLVER, $boleto->getAposVencimento());
        $this->assertEquals($data['diasAposVencimento'], $boleto->getDiasAposVencimento());
        $this->assertInternalType('array', $boleto->getFichaCompensacao());
        $this->assertInternalType('array', $boleto->getReciboPagador());
    }
}
