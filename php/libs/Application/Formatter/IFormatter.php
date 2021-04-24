<?php

namespace App\Application\Formatter;

interface IFormatter {
    /**
     * Returns given array as data in the current format.
     *
     * @param array $data
     *
     * @return mixed
     */
    public function fromArray(array $data);

    /**
     * Returns given data in the current format as an array.
     *
     * @param $data
     *
     * @return array
     */
    public function toArray($data): array;
}
