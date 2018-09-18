<?php

namespace Boleto\Caixa;

/**
 * Cobranca
 *
 * @author  Matheus Lopes Santos <fale_com_lopez@hotmail.com>
 * @version 1.0.0
 * @since   18/09/2018
 * @package Boleto\Caixa
 */
class Cobranca
{
    /**
     * @var  string
     */
    protected $codigoBarras;

    /**
     * @var  string
     */
    protected $linhaDigitavel;

    /**
     * @var  string
     */
    protected $nossoNumero;

    /**
     * @var  string
     */
    protected $urlBoleto;

    /**
     * @param   string  $codigoBarras
     * @param   string  $linhaDigitavel
     * @param   string  $nossoNumero
     * @param   string  $urlBoleto
     */
    public function __construct($codigoBarras, $linhaDigitavel, $nossoNumero, $urlBoleto)
    {
        $this->codigoBarras     = $codigoBarras;
        $this->linhaDigitavel   = $linhaDigitavel;
        $this->nossoNumero      = $nossoNumero;
        $this->urlBoleto        = $urlBoleto;
    }

    /**
     * @return  string
     */
    public function getCodigoBarras()
    {
        return $this->codigoBarras;
    }

    /**
     * @return  string
     */
    public function getLinhaDigitavel()
    {
        return $this->linhaDigitavel;
    }

    /**
     * @return  string
     */
    public function getNossoNumero()
    {
        return $this->nossoNumero;
    }

    /**
     * @return  string
     */
    public function getUrlBoleto()
    {
        return $this->urlBoleto;
    }
}