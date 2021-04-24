<?php

namespace App\Application\Writer;

use App\Application\Formatter\IFormatter;

class JsonFileWriter implements IWriter {

    protected IFormatter $formatter;

    /**
     * JsonFileWriter constructor.
     *
     * @param IFormatter $formatter
     */
    public function __construct(IFormatter $formatter)
    {
        $this->formatter = $formatter;
    }

    public function write($output, array $data): void
    {
        file_put_contents($output, $this->formatter->fromArray($data));
    }

}
