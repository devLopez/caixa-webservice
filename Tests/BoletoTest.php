<?php

use Boleto\Caixa\Agente;
use Boleto\Caixa\Boleto;
use Boleto\Caixa\Interfaces\BoletoInterface;
use PHPUnit\Framework\TestCase;

class BoletoTest extends TestCase
{
    public function testBoleto()
    {
        $agente = new Agente('Matheus Lopes Santos', '12345678909');
        $boleto = new Boleto('0914212', $agente);

        $this->assertInstanceOf(BoletoInterface::class, $boleto);
    }
}
