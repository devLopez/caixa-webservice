<?php

namespace Boleto\Caixa;

use Boleto\Caixa\XML\XmlCreator;
use Boleto\Caixa\XML\XmlParser;
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
     * @var array
     */
    protected $requestData = [];

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
        $this->bootRequestData();
    }

    /**
     * @param $hash
     */
    public function setHashAutenticacao($hash)
    {
        $this->hashAutenticacao = $hash;
    }

    /**
     * @return  void
     */
    protected function bootRequestData()
    {
        $this->requestData = [
            'unidade'           => $this->unidade,
            'boleto'            => $this->boleto,
            'usuarioServico'    => $this->usuarioServico,
            'sistemaOrigem'     => $this->sistemaOrigem,
            'hash'              => $this->hashAutenticacao,
        ];
    }

    /**
     * @return  string
     * @throws  Exception
     */
    public function geraBoleto()
    {
        $operacao = 'INCLUI_BOLETO';

        $data = array_merge($this->requestData, [
            'pagador'   => $this->boleto->getPagador(),
            'operacao'  => $operacao
        ]);

        $xml = XmlCreator::create(__DIR__ . '/../resources/inclui_boleto.phtml', $data);

        return $this->performRequest($operacao, $xml);
    }

    /**
     * @return  string
     * @throws  Exception
     */
    public function consultaBoleto()
    {
        $operacao = 'CONSULTA_BOLETO';

        $data = array_merge($this->requestData, [
            'operacao'  => $operacao
        ]);

        $xml = XmlCreator::create(__DIR__ . '/../resources/consulta_boleto.phtml', $data);

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
        if ( $method == 'CONSULTA_BOLETO' ) {
            $url = 'https://barramento.caixa.gov.br/sibar/ConsultaCobrancaBancaria/Boleto';
        } else {
            $url = 'https://barramento.caixa.gov.br/sibar/ManutencaoCobrancaBancaria/Boleto/Externo';
        }

        $response = $this->client->post($url, [
            'body'  => $xml,
            'headers' => [
                'Content-Type'  => 'text/xml',
                'SOAPAction'    => $method // SOAP Method to post to
            ],
            'curl' => [
                CURLOPT_SSL_VERIFYPEER => false
            ]
        ]);

        $xml = $response->getBody()->getContents();

        return XmlParser::parseFromRetorno($xml);
    }
}