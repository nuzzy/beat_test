<?php

namespace App\Application\Chapter;

use App\Application\Date\DateInterval;

class Segment
{
    protected int $chapterNumber;
    protected DateInterval $offset;
    protected ?int $partNumber;

    /**
     * Segment constructor.
     *
     * @param int          $chapterNumber
     * @param DateInterval $offset
     * @param int|null     $partNumber
     */
    public function __construct(
        int $chapterNumber,
        DateInterval $offset,
        ?int $partNumber = null
    ) {
        $this->chapterNumber = $chapterNumber;
        $this->offset = $offset;
        $this->partNumber = $partNumber;
    }

    public function toArray(): array
    {
        return [
            'title' => $this->getTitle(),
            'offset' => $this->offset->toString(),
        ];
    }

    protected function getTitle(): string
    {
        if (is_null($this->partNumber)) {

            return sprintf('Chapter %d', $this->chapterNumber);
        }

        return sprintf('Chapter %d, part %d', $this->chapterNumber, $this->partNumber);
    }
}
