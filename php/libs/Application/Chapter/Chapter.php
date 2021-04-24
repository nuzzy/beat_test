<?php

namespace App\Application\Chapter;

use App\Application\Date\DateInterval;

class Chapter
{
    protected int $silenceIndex;
    protected int $duration;
    protected DateInterval $offset;
    /**
     * @var Chapter[]
     */
    protected array $parts;

    /**
     * Chapter constructor.
     *
     * @param int          $silenceIndex
     * @param int          $duration
     * @param DateInterval $offset
     * @param Chapter[]        $parts
     */
    public function __construct(int $silenceIndex, int $duration, DateInterval $offset, array $parts)
    {
        $this->silenceIndex = $silenceIndex;
        $this->duration = $duration;
        $this->parts = $parts;
        $this->offset = $offset;
    }

    /**
     * @return int
     */
    public function getSilenceIndex(): int
    {
        return $this->silenceIndex;
    }

    /**
     * @return int
     */
    public function getDuration(): int
    {
        return $this->duration;
    }

    /**
     * @return DateInterval
     */
    public function getOffset(): DateInterval
    {
        return $this->offset;
    }

    /**
     * @return Chapter[]
     */
    public function getParts(): array
    {
        return $this->parts;
    }
}
