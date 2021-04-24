<?php

namespace App\Application\Formatter;

use App\Application\ApplicationErrors;
use App\Application\ApplicationException;
use SimpleXMLElement;

class XmlFormatter implements IFormatter {
    public function fromArray(array $data)
    {
        /**
         * @TODO: Implement this method.
         */
        throw new \Exception('Not implemented yet');
    }

    public function toArray($data): array
    {
        /** @var SimpleXMLElement|false $xml */
        $xml = simplexml_load_string($data);
        if ($xml === false) {
            throw new ApplicationException(
                'Error on parsing XML data',
                ApplicationErrors::ERROR_CODE_PARSE_XML_DATA_ERROR
            );
        }

        $parsedData = [];
        /** @var SimpleXMLElement $element */
        foreach ($xml->silence as $element) {

            $attributes = [];
            foreach ($element->attributes() as $key => $value) {
                $attributes[$key] = (string)$value;
            }

            $parsedData[] = $attributes;
        }

        return $parsedData;
    }
}
