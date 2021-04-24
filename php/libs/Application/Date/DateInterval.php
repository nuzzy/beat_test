<?php

namespace App\Application\Date;

use DateInterval as StandardDateInterval;
use DateTime;

class DateInterval extends StandardDateInterval
{
    protected const PARSE_DURATION_PATTERN = '/PT((?P<hours>\d*[.,]?\d*)H)?((?P<minutes>\d*[.,]?\d*)M)?((?P<seconds>\d*[.,]?\d*)S)?/';

    protected const MILLISECONDS = 1000;

    protected float $totalMilliseconds;

    /**
     * DatePeriod constructor.
     *
     * @param string $duration
     */
    public function __construct(string $duration)
    {
        preg_match(self::PARSE_DURATION_PATTERN, $duration, $interval, PREG_UNMATCHED_AS_NULL);

        $this->s = $interval['seconds'] ?? 0;
        $this->i = $interval['minutes'] ?? 0;
        $this->h = $interval['hours'] ?? 0;

        $this->totalMilliseconds = (
                $this->s
                + $this->i * 60
                + $this->h * 3600
            ) * self::MILLISECONDS;

        $totalSeconds = floor($this->totalMilliseconds / self::MILLISECONDS);

        // Prepare microseconds.
        $this->f = $microseconds = (
            $this->totalMilliseconds -
            $totalSeconds * self::MILLISECONDS
        ) / self::MILLISECONDS;

        parent::__construct(sprintf('PT%dS', $totalSeconds));
        $this->f += $microseconds;

        $this->recalculate();

    }

    /**
     * @return float|int
     */
    public function getTotalMilliseconds(): float
    {
        return $this->totalMilliseconds;
    }

    /**
     * @param DateInterval $datePeriod
     *
     * @return DateInterval
     */
    public function sub(DateInterval $datePeriod): DateInterval
    {
        $millisecondsDiff = $this->getTotalMilliseconds() - $datePeriod->getTotalMilliseconds();

        return new DateInterval(sprintf('PT%fS', $millisecondsDiff / self::MILLISECONDS));
    }

    /**
     * Recalculate to have the correct seconds, minutes and hours instead of overflown ones.
     *
     * @throws \Exception
     * @return $this
     */
    public function recalculate(): self
    {
        $from = new DateTime;
        $to = clone $from;
        $to = $to->add($this);
        $diff = $from->diff($to);
        foreach ($diff as $k => $v) {
            $this->$k = $v;
        }

        return $this;
    }

    /**
     * Returns string representation of the current date interval object.
     * Applies custom output formatting for microseconds milliseconds.
     *
     * @return string
     */
    public function toString(): string
    {
        $duration = ($this->h > 0 ? $this->format('%hH') : '')
            . ($this->i > 0 ? $this->format('%iM') : '')
            . ($this->s > 0 ? $this->format(
                $this->f > 0 ? sprintf('%%s.%dS', $this->f * self::MILLISECONDS)
                    : '%sS'
            ) : '');

        $duration = $duration ?: '0S';

        return 'PT' . $duration;
    }

}
