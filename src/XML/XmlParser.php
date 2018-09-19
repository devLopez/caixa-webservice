<?php

namespace Boleto\Caixa\XML;

use Boleto\Caixa\Retorno\Cobranca;
use Exception;
use SimpleXMLElement;

/**
 * XmlParser
 *
 * @author  Matheus Lopes Santos <fale_com_lopez@hotmail.com>
 * @version 1.1.0
 * @since   19/09/2018
 * @package Boleto\Caixa\XML
 */
class XmlParser
{
    /**
     * @param   string  $xml
     * @return  Cobranca
     * @throws  Exception
     */
    public static function parseFromRetorno($xml)
    {
        $clean_xml  = str_ireplace([
            'SOAP-ENV:',
            'SOAP:',
            'soapenv:',
            'sibar_base:',
            'manutencaocobrancabancaria:',
            'consultacobrancabancaria:'
        ], '', $xml);

        $parsed = new SimpleXMLElement($clean_xml);

        if ( $parsed->Body->SERVICO_SAIDA->COD_RETORNO == 'X5' ) {
            throw new Exception($parsed->Body->SERVICO_SAIDA->DADOS->EXCECAO);
        }

        $dados      = $parsed->Body->SERVICO_SAIDA->DADOS;
        $retorno    = $dados->CONTROLE_NEGOCIAL->COD_RETORNO;

        if ( $retorno == 1 ) {

            throw new Exception($dados->CONTROLE_NEGOCIAL->MENSAGENS->RETORNO);

        } else {

            $barras         = (string) $dados->INCLUI_BOLETO->CODIGO_BARRAS;
            $linhaDigitavel = (string) $dados->INCLUI_BOLETO->LINHA_DIGITAVEL;
            $nossoNumero    = (string) $dados->INCLUI_BOLETO->NOSSO_NUMERO;
            $url            = (string) $dados->INCLUI_BOLETO->URL;

            return new Cobranca($barras, $linhaDigitavel, $nossoNumero, $url);
        }
    }
}