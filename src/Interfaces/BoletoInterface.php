<?php

namespace Boleto\Caixa\Interfaces;

use Carbon\Carbon;

/**
 * BoletoInterface
 *
 * @author  Matheus Lopes Santos <fale_com_lopez@hotmail.com>
 * @version 1.0.0
 * @since   17/09/2018
 * @package Boleto\Caixa\Interfaces
 */
interface BoletoInterface
{
    public function setConvenio($convenio);

    public function getConvenio();

    public function setCNPJBeneficiario($cnpj);

    public function getCNPJBeneficiario();

    public function setNossoNumero($nossoNumero);

    public function getNossoNumero();

    public function setDataVencimento(Carbon $dataVencimento);

    public function getDataVencimento();

    public function setNumeroDocumento($numeroDocumento);

    public function getNumeroDocumento();

    public function setValor($valor);

    public function getValor();

    public function setTipoEspecie($tipoEspecie);

    public function getTipoEspecie();

    public function setAceite($aceite);

    public function getAceite();

    public function setDataEmissao(Carbon $dataEmissao);

    public function getDataEmissao();

    public function setJurosMora($jurosMora);

    public function getJurosMora();

    public function setValorJuros($valorJuros);

    public function setAbatimento($abatimento);

    public function getAbatimento();

    public function setAposVencimento($aposVencimento);

    public function getAposVencimento();

    public function setDiasAposVencimento($diasAposVencimento);

    public function getDiasAposVencimento();

    public function getCodigoMoeda();

    public function setPagador(AgenteInterface $pagador);

    public function getPagador();

    public function setFichaCompensacao($mensagem);

    public function getFichaCompensacao();

    public function setReciboPagador($mensagem);

    public function getReciboPagador();

    public function geraHashAutenticacao();

    public function hasFichaCompensacao();

    public function hasReciboPagador();
}