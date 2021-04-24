<?php

namespace App\Application\Writer;

interface IWriter {
    /**
     * @param mixed $output
     * @param array $data
     *
     * @return void
     */
    public function write($output, array $data): void;
}
