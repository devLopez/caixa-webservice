<?php

namespace Boleto\Caixa;

use Boleto\Caixa\Interfaces\AgenteInterface;
use InvalidArgumentException;
use JansenFelipe\Utils\Utils;

/**
 * Agente
 *
 * @author  Matheus Lopes Santos <fale_com_lopez@hotmail.com>
 * @version 1.0.0
 * @since   17/09/2018
 * @package Boleto\Caixa
 */
class Agente implements AgenteInterface
{
    /**
     * @var string
     */
    protected $nome;

    /**
     * @var string
     */
    protected $documento;

    /**
     * @var string
     */
    protected $logradouro;

    /**
     * @var string
     */
    protected $bairro;

    /**
     * @var string
     */
    protected $cidade;

    /**
     * @var string
     */
    protected $uf;

    /**
     * @var integer
     */
    protected $cep;

    /**
     * @param   string  $nome
     * @param   string  $documento
     * @param   string|null  $logradouro
     * @param   string|null  $bairro
     * @param   string|null  $cidade
     * @param   string|null  $uf
     * @param   string|null  $cep
     */
    public function __construct(
        $nome,
        $documento,
        $logradouro = null,
        $bairro = null,
        $cidade = null,
        $uf = null,
        $cep = null
    )
    {
        $this->setNome($nome);
        $this->setDocumento($documento);

        $this->setLogradouro($logradouro);
        $this->setBairro($bairro);
        $this->setCidade($cidade);
        $this->setUf($uf);
        $this->setCep($cep);
    }

    /**
     * @return string
     */
    public function getNome()
    {
        return $this->nome;
    }

    /**
     * @param   string  $nome
     * @throws  InvalidArgumentException
     */
    public function setNome($nome)
    {
        if ( strlen($nome) > 40 ) {
            throw new InvalidArgumentException('O nome deve possuir apenas 40 caracteres');
        }

        $this->nome = strtoupper(Utils::unaccents($nome));
    }

    /**
     * @return  string
     */
    public function getDocumento()
    {
        return $this->documento;
    }

    /**
     * @param   string  $documento
     * @throws  InvalidArgumentException
     */
    public function setDocumento($documento)
    {
        $documento = Utils::unmask($documento);

        if ( strlen($documento) == 11 ) {
            if ( ! Utils::isCpf($documento) ) {
                throw new InvalidArgumentException('CPF inválido');
            }
        } else if ( strlen($documento) == 14 ) {
            if ( ! Utils::isCnpj($documento) ) {
                throw new InvalidArgumentException('CNPJ inválido');
            }
        }

        if ( strlen($documento) > 14 ) {
            throw new InvalidArgumentException('O documento deve ter 14 caracteres');
        }

        $this->documento = $documento;
    }

    /**
     * @return mixed
     */
    public function getLogradouro()
    {
        return $this->logradouro;
    }

    /**
     * @param   string|null  $logradouro
     * @throws  InvalidArgumentException
     */
    public function setLogradouro($logradouro = null)
    {
        if ( $logradouro && strlen($logradouro) > 40 ) {
            throw new InvalidArgumentException('O logradouro deve ter no máximo 40 caracteres');
        }

        $this->logradouro = strtoupper(Utils::unaccents($logradouro));
    }

    /**
     * @return  string
     */
    public function getBairro()
    {
        return $this->bairro;
    }

    /**
     * @param   string|null  $bairro
     * @throws  InvalidArgumentException
     */
    public function setBairro($bairro = null)
    {
        if ( $bairro && strlen($bairro) > 15 ) {
            throw new InvalidArgumentException('O bairro deve ter no máximo 15 caracteres');
        }

        $this->bairro = strtoupper(Utils::unaccents($bairro));
    }

    /**
     * @return  string
     */
    public function getCidade()
    {
        return $this->cidade;
    }

    /**
     * @param   string|null  $cidade
     * @throws  InvalidArgumentException
     */
    public function setCidade($cidade = null)
    {
        if ( $cidade && strlen($cidade) > 15 ) {
            throw new InvalidArgumentException('A cidade deve ter no máximo 15 caracteres');
        }

        $this->cidade = strtoupper(Utils::unaccents($cidade));
    }

    /**
     * @return  string
     */
    public function getUf()
    {
        return $this->uf;
    }

    /**
     * @param   string|null  $uf
     * @throws  InvalidArgumentException
     */
    public function setUf($uf = null)
    {
        if ( $uf && strlen($uf) != 2 ) {
            throw new InvalidArgumentException('A UF deve ter 2 caracteres');
        }

        $this->uf = strtoupper(Utils::unaccents($uf));
    }

    /**
     * @return  integer
     */
    public function getCep()
    {
        return $this->cep;
    }

    /**
     * @param null $cep
     */
    public function setCep($cep = null)
    {
        if ( $cep && strlen($cep) != 8 ) {
            throw new InvalidArgumentException('O CEP deve possuir 8 caracteres');
        }

        $this->cep = (integer) Utils::unmask($cep);
    }
}