<?php

namespace App\Application\Factory;

use App\Application\Writer\IWriter;
use App\Application\Writer\JsonFileWriter;
use App\Application\Writer\JsonScreenWriter;

class WriterFactory {
    public static function createWriter(?string $filename): IWriter
    {
        $formatter = FormatterFactory::createFormatter($filename);

        if ($filename) {
            return new JsonFileWriter($formatter);
        }

        return new JsonScreenWriter($formatter);
    }
}
