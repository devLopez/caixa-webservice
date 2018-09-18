<?php

namespace Boleto\Caixa\XML;

use SimpleXMLElement;

class XMLParser
{
    public static function parseFromRetorno($xml)
    {
        $clean_xml  = str_ireplace([
            'SOAP-ENV:',
            'SOAP:',
            'soapenv:',
            'sibar_base:',
            'manutencaocobrancabancaria:'
        ], '', $xml);

        $parsed = new SimpleXMLElement($clean_xml);
//        $parsed = simplexml_load_string($clean_xml);

        return $parsed->Body->SERVICO_SAIDA->DADOS;
    }
}