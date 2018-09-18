<?php

namespace Boleto\Caixa\XML;

class XmlCreator
{
    public static function create($xml, array $data)
    {
        ob_start();

        extract($data);

        include $xml;

        return ob_get_clean();
    }
}