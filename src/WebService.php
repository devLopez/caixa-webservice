<?php

namespace Boleto\Caixa;

use Boleto\Caixa\XML\XmlCreator;
use Boleto\Caixa\XML\XMLParser;
use Exception;
use GuzzleHttp\Client;
use Boleto\Caixa\Interfaces\BoletoInterface as Boleto;

/**
 * WebService
 *
 * @author  Matheus Lopes Santos <fale_com_lopez@hotmail.com>
 * @version 1.0.0
 * @since   18/09/2018
 * @package Boleto\Caixa
 */
class WebService
{
    /**
     * @var Boleto
     */
    protected $boleto;

    /**
     * @var Client
     */
    protected $client;

    /**
     * @var string
     */
    protected $hashAutenticacao;

    /**
     * @var string|int
     */
    protected $unidade;

    /**
     * @var string
     */
    protected $usuarioServico = 'SGCBS02P';

    /**
     * @var string
     */
    protected $sistemaOrigem = 'SIGCB';

    /**
     * @param   string|int  $unidade
     * @param   Client  $client
     * @param   Boleto  $boleto
     */
    public function __construct($unidade, Client $client, Boleto $boleto)
    {
        $this->unidade  = $unidade;

        $this->client   = $client;
        $this->boleto   = $boleto;

        $this->setHashAutenticacao($boleto->geraHashAutenticacao());
    }

    /**
     * @param $hash
     */
    public function setHashAutenticacao($hash)
    {
        $this->hashAutenticacao = $hash;
    }

    /**
     * @return  string
     * @throws  Exception
     */
    public function geraBoleto()
    {
        $operacao = 'INCLUI_BOLETO';

        $data = [
            'unidade'           => $this->unidade,
            'boleto'            => $this->boleto,
            'pagador'           => $this->boleto->getPagador(),
            'usuarioServico'    => $this->usuarioServico,
            'sistemaOrigem'     => $this->sistemaOrigem,
            'hash'              => $this->hashAutenticacao,
            'operacao'          => $operacao
        ];

        $xml = XmlCreator::create(__DIR__ . '/../resources/incluiBoleto.phtml', $data);

        return $this->performRequest($operacao, $xml);
    }

    /**
     * @param   string  $method
     * @param   string  $xml
     * @return  string
     * @throws  Exception
     */
    private function performRequest($method, $xml)
    {
        $response = $this->client->post('https://barramento.caixa.gov.br/sibar/ManutencaoCobrancaBancaria/Boleto/Externo', [
            'body'  => $xml,
            'headers' => [
                'Content-Type'  => 'text/xml',
                'SOAPAction'    => $method // SOAP Method to post to
            ],
            'curl' => [
                CURLOPT_SSL_VERIFYPEER => false
            ]
        ]);

        $xml    = $response->getBody()->getContents();
        $data   = XMLParser::parseFromRetorno($xml);

        if ( $data->CONTROLE_NEGOCIAL->COD_RETORNO == 1 ) {
            throw new Exception($data->CONTROLE_NEGOCIAL->MENSAGENS->RETORNO);
        } else {
            $boleto = new \stdClass();

            $boleto->codigoBarras   = $data->INCLUI_BOLETO->CODIGO_BARRAS;
            $boleto->linhaDigitavel = $data->INCLUI_BOLETO->LINHA_DIGITAVEL;
            $boleto->nossoNumero    = $data->INCLUI_BOLETO->NOSSO_NUMERO;
            $boleto->urlBoleto      = $data->INCLUI_BOLETO->URL;

            return $boleto;
        }
    }
}