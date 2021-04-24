<?php

namespace App\Application\Factory;

use App\Application\Reader\IReader;
use App\Application\Reader\XmlFileReader;

class ReaderFactory {
    public static function createReader(?string $filename): IReader
    {
        $formatter = FormatterFactory::createFormatter($filename);

        return new XmlFileReader($formatter);
    }
}
