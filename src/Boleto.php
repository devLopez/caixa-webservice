<?php

namespace Boleto\Caixa;

use Boleto\Caixa\Interfaces\BoletoInterface;
use Carbon\Carbon;
use Boleto\Caixa\Interfaces\AgenteInterface as Agente;
use InvalidArgumentException;

/**
 * Boleto
 *
 * @author  Matheus Lopes Santos <fale_com_lopez@hotmail.com>
 * @version 1.0.0
 * @since   17/09/2018
 * @package Boleto\Caixa
 */
class Boleto implements BoletoInterface
{
    /**
     * @var string
     */
    protected $convenio;

    /**
     * @var string
     */
    protected $nossoNumero;

    /**
     * @var Carbon
     */
    protected $dataVencimento;

    /**
     * @var string
     */
    protected $numeroDocumento;

    /**
     * @var float
     */
    protected $valor;

    /**
     * @var string
     */
    protected $tipoEspecie = '02';

    /**
     * @var string
     */
    protected $aceite = 'N';

    /**
     * @var Carbon
     */
    protected $dataEmissao;

    /**
     * @var string
     */
    protected $jurosMora;

    /**
     * @var float
     */
    protected $valorJuros = 0.00;

    /**
     * @var float
     */
    protected $abatimento = 0.00;

    /**
     * @var string
     */
    protected $aposVencimento;

    /**
     * @var int
     */
    protected $diasAposVencimento;

    /**
     * @var int
     */
    protected $codigoMoeda = 9;

    /**
     * @var Agente
     */
    protected $pagador;

    /**
     * @var array
     */
    protected $fichaCompensacao = [];

    /**
     * @var array
     */
    protected $reciboPagador = [];

    /**
     * @param   string  $convenio
     * @param   Agente  $pagador
     * @param   array  $opcoes
     */
    public function __construct($convenio, Agente $pagador, array $opcoes = [])
    {
        $this->setConvenio($convenio);
        $this->setPagador($pagador);
    }

    /**
     * @return  string
     */
    public function getConvenio()
    {
        return $this->convenio;
    }

    /**
     * @param   string  $convenio
     */
    public function setConvenio($convenio)
    {
        $this->convenio = $convenio;
    }

    /**
     * @return Agente
     */
    public function getPagador()
    {
        return $this->pagador;
    }

    /**
     * @param   Agente  $pagador
     */
    public function setPagador(Agente $pagador)
    {
        $this->pagador = $pagador;
    }

    /**
     * @return  string
     */
    public function getNossoNumero()
    {
        return $this->nossoNumero;
    }

    /**
     * @param   string  $nossoNumero
     */
    public function setNossoNumero($nossoNumero)
    {
        $this->nossoNumero = $nossoNumero;
    }

    /**
     * @return float
     */
    public function getValor()
    {
        return $this->valor;
    }

    /**
     * @param   float  $valor
     */
    public function setValor($valor)
    {
        $this->valor = $valor;
    }

    /**
     * @return string
     */
    public function getTipoEspecie()
    {
        return $this->tipoEspecie;
    }

    /**
     * @param   string  $tipoEspecie
     */
    public function setTipoEspecie($tipoEspecie)
    {
        $this->tipoEspecie = $tipoEspecie;
    }

    /**
     * @return string
     */
    public function getAceite()
    {
        return $this->aceite;
    }

    /**
     * @param   string  $aceite
     */
    public function setAceite($aceite)
    {
        $this->aceite = $aceite;
    }

    /**
     * @return Carbon
     */
    public function getDataEmissao()
    {
        return $this->dataEmissao;
    }

    /**
     * @param   Carbon  $dataEmissao
     */
    public function setDataEmissao(Carbon $dataEmissao)
    {
        $this->dataEmissao = $dataEmissao;
    }

    /**
     * @return string
     */
    public function getJurosMora()
    {
        return $this->jurosMora;
    }

    /**
     * @param   string  $jurosMora
     */
    public function setJurosMora($jurosMora)
    {
        $this->jurosMora = $jurosMora;
    }

    /**
     * @return float
     */
    public function getValorJuros()
    {
        return $this->valorJuros;
    }

    /**
     * @param float $valorJuros
     */
    public function setValorJuros($valorJuros)
    {
        $this->valorJuros = $valorJuros;
    }

    /**
     * @return float
     */
    public function getAbatimento()
    {
        return $this->abatimento;
    }

    /**
     * @param float $abatimento
     */
    public function setAbatimento($abatimento)
    {
        $this->abatimento = $abatimento;
    }

    /**
     * @return  string
     */
    public function getAposVencimento()
    {
        return $this->aposVencimento;
    }

    /**
     * @param   string  $aposVencimento
     */
    public function setAposVencimento($aposVencimento)
    {
        $this->aposVencimento = $aposVencimento;
    }

    /**
     * @return int
     */
    public function getDiasAposVencimento()
    {
        return $this->diasAposVencimento;
    }

    /**
     * @param   int  $diasAposVencimento
     */
    public function setDiasAposVencimento($diasAposVencimento)
    {
        $this->diasAposVencimento = $diasAposVencimento;
    }

    /**
     * @return array
     */
    public function getFichaCompensacao()
    {
        return $this->fichaCompensacao;
    }

    /**
     * @param   string  $mensagem
     */
    public function setFichaCompensacao($mensagem)
    {
        if ( strlen($mensagem) > 40 ) {
            throw new InvalidArgumentException('A mensagem deve ter no máximo 40 caracteres');
        }

        array_push($this->fichaCompensacao, $mensagem);
    }

    /**
     * @return  array
     */
    public function getReciboPagador()
    {
        return $this->reciboPagador;
    }

    /**
     * @param   string  $mensagem
     */
    public function setReciboPagador($mensagem)
    {
        if ( strlen($mensagem) > 40 ) {
            throw new InvalidArgumentException('A mensagem deve ter no máximo 40 caracteres');
        }

        array_push($this->reciboPagador, $mensagem);
    }

    /**
     * @return Carbon
     */
    public function getDataVencimento()
    {
        return $this->dataVencimento;
    }

    /**
     * @param   Carbon  $dataVencimento
     */
    public function setDataVencimento(Carbon $dataVencimento)
    {
        $this->dataVencimento = $dataVencimento;
    }

    /**
     * @return string
     */
    public function getNumeroDocumento()
    {
        return $this->numeroDocumento;
    }

    /**
     * @param string $numeroDocumento
     */
    public function setNumeroDocumento($numeroDocumento)
    {
        $this->numeroDocumento = $numeroDocumento;
    }

    /**
     * @return int
     */
    public function getCodigoMoeda()
    {
        return $this->codigoMoeda;
    }
}