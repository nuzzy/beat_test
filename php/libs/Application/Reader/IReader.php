<?php

namespace App\Application\Reader;

interface IReader {
    /**
     * @param string $filename
     *
     * @return array
     */
    public function read(string $filename): array;
}
