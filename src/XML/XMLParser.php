<?php

namespace Boleto\Caixa\XML;

use Exception;
use SimpleXMLElement;

/**
 * XMLParser
 *
 * @author  Matheus Lopes Santos <fale_com_lopez@hotmail.com>
 * @version 1.0.0
 * @since   18/09/2018
 * @package Boleto\Caixa\XML
 */
class XMLParser
{
    /**
     * @param   string  $xml
     * @return  \stdClass
     * @throws  Exception
     */
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

        $dados = $parsed->Body->SERVICO_SAIDA->DADOS;

        if ( $dados->CONTROLE_NEGOCIAL->COD_RETORNO == 1 ) {
            throw new Exception($dados->CONTROLE_NEGOCIAL->MENSAGENS->RETORNO);
        } else {
            $boleto = new \stdClass();

            $boleto->codigoBarras   = $dados->INCLUI_BOLETO->CODIGO_BARRAS[0];
            $boleto->linhaDigitavel = $dados->INCLUI_BOLETO->LINHA_DIGITAVEL[0];
            $boleto->nossoNumero    = $dados->INCLUI_BOLETO->NOSSO_NUMERO[0];
            $boleto->urlBoleto      = $dados->INCLUI_BOLETO->URL[0];

            return $boleto;
        }
    }
}