<?php

namespace App\Application\Chapter;

use App\Application\Date\DateInterval;

class SilenceDuration
{
    protected DateInterval $from;
    protected DateInterval $until;
    protected float $duration;

    /**
     * SilenceDuration constructor.
     *
     * @param DateInterval $from
     * @param DateInterval $until
     * @param float        $duration
     */
    public function __construct(
        DateInterval $from,
        DateInterval $until,
        float $duration
    ) {
        $this->from = $from;
        $this->until = $until;
        $this->duration = $duration;
    }

    /**
     * @return DateInterval
     */
    public function getFrom(): DateInterval
    {
        return $this->from;
    }

    /**
     * @return DateInterval
     */
    public function getUntil(): DateInterval
    {
        return $this->until;
    }

    /**
     * @return float
     */
    public function getDuration(): float
    {
        return $this->duration;
    }

}
