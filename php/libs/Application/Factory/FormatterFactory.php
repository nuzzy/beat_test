<?php

namespace App\Application\Factory;

use App\Application\Formatter\IFormatter;
use App\Application\Formatter\JsonFormatter;
use App\Application\Formatter\XmlFormatter;

class FormatterFactory {
    public static function createFormatter(?string $filename): IFormatter
    {
        if (!$filename) {
            return new JsonFormatter();
        }

        $path = pathinfo($filename);

        if (!isset($path['extension']) || $path['extension'] === 'xml') {
            return new XmlFormatter();
        }

        return new JsonFormatter();
    }
}
