<?php

namespace App\Application\Reader;

use App\Application\Formatter\IFormatter;

class XmlFileReader implements IReader {

    protected IFormatter $formatter;

    /**
     * XmlFileReader constructor.
     *
     * @param IFormatter $formatter
     */
    public function __construct(IFormatter $formatter)
    {
        $this->formatter = $formatter;
    }

    public function read(string $filename): array
    {
        $fileContents = file_get_contents($filename);

        return $this->formatter->toArray($fileContents);
    }
}
