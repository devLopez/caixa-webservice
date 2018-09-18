<?php

namespace Boleto\Caixa;

use Boleto\Caixa\Interfaces\BoletoInterface;
use Carbon\Carbon;
use Boleto\Caixa\Interfaces\AgenteInterface as Agente;
use InvalidArgumentException;
use JansenFelipe\Utils\Utils;

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
    protected $cnpjBeneficiario;

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
     * @var string|null
     */
    protected $aposVencimento = null;

    /**
     * @var int|null
     */
    protected $diasAposVencimento = null;

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
     * @param   string  $cnpjBeneficiario
     * @param   Agente  $pagador
     * @param   array  $opcoes
     */
    public function __construct($convenio, $cnpjBeneficiario, Agente $pagador, array $opcoes = [])
    {
        $this->setConvenio($convenio);
        $this->setPagador($pagador);
        $this->setCNPJBeneficiario($cnpjBeneficiario);

        if ( count($opcoes) > 0 ) {
            $this->bootOpcoes($opcoes);
        }
    }

    /**
     * @param   array  $opcoes
     */
    private function bootOpcoes(array $opcoes)
    {
        foreach ( $opcoes as $metodo => $valor ) {
            $metodo = 'set' . ucwords($metodo);

            if ( method_exists($this, $metodo) ) {
                $this->$metodo($valor);
            }
        }
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
        $this->convenio = str_pad($convenio, 7, 0, STR_PAD_LEFT);
    }

    /**
     * @param   string  $cnpj
     */
    public function setCNPJBeneficiario($cnpj)
    {
        $cnpj = Utils::unmask($cnpj);

        if ( strlen($cnpj) == 14 ) {
            if ( ! Utils::isCnpj($cnpj) ) {
                throw new InvalidArgumentException('O CNPJ do beneficiário é inválido');
            }
        } else if ( strlen($cnpj) == 11 ) {
            if ( ! Utils::isCpf($cnpj) ) {
                throw new InvalidArgumentException('O CPF do beneficiário é inválido');
            }
        }

        $this->cnpjBeneficiario = $cnpj;
    }

    /**
     * @return string
     */
    public function getCNPJBeneficiario()
    {
        return $this->cnpjBeneficiario;
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
        return number_format($this->valor, 2, '.', '');
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
        return number_format($this->valorJuros, 2, '.', '');
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
        return number_format($this->abatimento, 2, '.', '');
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
    public function setAposVencimento($aposVencimento = null)
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
    public function setDiasAposVencimento($diasAposVencimento = null)
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
        if ( is_array($mensagem) ) {
            foreach ($mensagem as $item) {
                $this->setFichaCompensacao($item);
            }
        } else {
            if ( strlen($mensagem) > 40 ) {
                throw new InvalidArgumentException('A mensagem deve ter no máximo 40 caracteres');
            }

            array_push($this->fichaCompensacao, $mensagem);
        }
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
        if ( is_array($mensagem) ) {
            foreach ($mensagem as $item) {
                $this->setReciboPagador($item);
            }
        } else {
            if ( strlen($mensagem) > 40 ) {
                throw new InvalidArgumentException('A mensagem deve ter no máximo 40 caracteres');
            }

            array_push($this->reciboPagador, $mensagem);
        }
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

    /**
     * @return  string
     */
    public function geraHashAutenticacao()
    {
        $valor = number_format($this->valor, 2, '', '');

        $convenio       = $this->convenio;
        $nossoNumero    = $this->nossoNumero;
        $dataVencimento = $this->dataVencimento->format('dmY');
        $valor          = str_pad($valor, 15, 0, 0);//sprintf('%015d', preg_replace('/[^0-9]/', '', $this->valor));
        $cnpj           = sprintf('%014d', $this->cnpjBeneficiario);

        $raw = preg_replace('/[^A-Za-z0-9]/', '',$convenio . $nossoNumero . $dataVencimento . $valor . $cnpj);

        return base64_encode(hash('sha256', $raw, true));
    }

    /**
     * @return  bool
     */
    public function hasFichaCompensacao()
    {
        return ( count($this->fichaCompensacao) > 0 ) ? true : false;
    }

    /**
     * @return  bool
     */
    public function hasReciboPagador()
    {
        return ( count($this->reciboPagador) > 0 ) ? true : false;
    }
}