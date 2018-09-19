<?php

use Boleto\Caixa\Agente;
use Boleto\Caixa\Interfaces\AgenteInterface;

class AgenteTest extends PHPUnit_Framework_TestCase
{
    public function testInstance()
    {
        $agente = new Agente('Matheus Lopes Santos', '123456787909');

        $this->assertInstanceOf(AgenteInterface::class, $agente);
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testExceptions()
    {
        $agente = new Agente('Matheus Lopes Santos', '123456787909');
        $agente->setLogradouro('Nome de logradouro muito grande mesmo, agora vai');
    }

    public function testGetters()
    {
        $agente = new Agente(
            'Matheus Lopes Santos',
            '123.456.789-09',
            'Rua Fafá de Belém, 756',
            'Vilage do Lago',
            'Montes Claros',
            'mg',
            '39400000'
        );

        $this->assertEquals('MATHEUS LOPES SANTOS', $agente->getNome());
        $this->assertEquals('12345678909', $agente->getDocumento());
        $this->assertEquals('RUA FAFA DE BELEM, 756', $agente->getLogradouro());
        $this->assertEquals('VILAGE DO LAGO', $agente->getBairro());
        $this->assertEquals('MONTES CLAROS', $agente->getCidade());
        $this->assertEquals('MG', $agente->getUf());
        $this->assertEquals(39400000, $agente->getCep());
    }
}
