<?php

namespace App\Application\Writer;

use App\Application\Formatter\IFormatter;

class JsonScreenWriter implements IWriter {

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
        print $this->formatter->fromArray($data);
    }

}
