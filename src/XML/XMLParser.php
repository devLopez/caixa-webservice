<?php

namespace Boleto\Caixa\XML;

use Boleto\Caixa\Cobranca;
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
            'manutencaocobrancabancaria:'
        ], '', $xml);

        $parsed = new SimpleXMLElement($clean_xml);

        $dados  = $parsed->Body->SERVICO_SAIDA->DADOS;

        $codigoRetorno = $dados->CONTROLE_NEGOCIAL->COD_RETORNO;

        if ( $codigoRetorno == 1 ) {

            throw new Exception($dados->CONTROLE_NEGOCIAL->MENSAGENS->RETORNO);

        } else if ( $parsed->Body->SERVICO_SAIDA->COD_RETORNO == 'X5' ) {

            throw new Exception($dados->EXCECAO);

        } else {

            $barras         = (string) $dados->INCLUI_BOLETO->CODIGO_BARRAS;
            $linhaDigitavel = (string) $dados->INCLUI_BOLETO->LINHA_DIGITAVEL;
            $nossoNumero    = (string) $dados->INCLUI_BOLETO->NOSSO_NUMERO;
            $url            = (string) $dados->INCLUI_BOLETO->URL;

            return new Cobranca($barras, $linhaDigitavel, $nossoNumero, $url);
        }
    }
}