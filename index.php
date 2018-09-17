<?php

require_once './vendor/autoload.php';

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

$xml = file_get_contents(__DIR__ . '/xml/boleto.xml');

$client = new Client();

try {
    $response = $client->post('https://barramento.caixa.gov.br/sibar/ManutencaoCobrancaBancaria/Boleto/Externo', [
        'body'    => $xml,
        'headers' => [
            'Content-Type'  => 'text/xml',
            'SOAPAction'    => 'INCLUI_BOLETO' // SOAP Method to post to
        ],
        'curl' => [
            CURLOPT_SSL_VERIFYPEER => false
        ]
    ]);

    echo "<pre>";
    print_r($response->getBody()->getContents());
    die();

} catch (RequestException $e) {

    //echo "<pre>";
    //print_r($e->getResponse()->getBody()->getContents());
    //die();

    echo $e->getMessage();

} catch (Exception $e) {
    echo $e->getMessage();
}
