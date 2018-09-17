<?php

namespace Boleto\Caixa\Interfaces;

/**
 * AgenteInterface
 *
 * @author  Matheus Lopes Santos <fale_com_lopez@hotmail.com>
 * @version 1.0.0
 * @since   17/09/2018
 * @package Boleto\Caixa\Interfaces
 */
interface AgenteInterface
{
    public function setNome($nome);

    public function getNome();

    public function setDocumento($documento);

    public function getDocumento();

    public function setLogradouro($logradouro = null);

    public function getLogradouro();

    public function setBairro($bairro = null);

    public function getBairro();

    public function setCidade($cidade = null);

    public function getCidade();

    public function setUf($uf = null);

    public function getUf();

    public function setCep($cep = null);

    public function getCep();
}