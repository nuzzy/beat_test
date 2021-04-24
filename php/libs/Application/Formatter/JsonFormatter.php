<?php

namespace App\Application\Formatter;

class JsonFormatter implements IFormatter {
    public function fromArray(array $data)
    {
        return json_encode($data, JSON_THROW_ON_ERROR);
    }

    public function toArray($data): array
    {
        return json_decode($data, true, 512, JSON_THROW_ON_ERROR);
    }
}
