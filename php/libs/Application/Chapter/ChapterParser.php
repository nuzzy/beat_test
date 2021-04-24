<?php

namespace App\Application\Chapter;

use App\Application\Date\DateInterval;

class ChapterParser
{
    protected int $chapterSilenceDuration;
    protected int $longChapterSilenceDuration;
    protected int $longChapterMaxDuration;

    /**
     * ChapterParser constructor.
     *
     * @param int $chapterSilenceDuration
     * @param int $longChapterSilenceDuration
     * @param int $longChapterMaxDuration
     */
    public function __construct(
        int $chapterSilenceDuration,
        int $longChapterSilenceDuration,
        int $longChapterMaxDuration
    ) {
        $this->chapterSilenceDuration = $chapterSilenceDuration;
        $this->longChapterSilenceDuration = $longChapterSilenceDuration;
        $this->longChapterMaxDuration = $longChapterMaxDuration;
    }

    public function parse(array $silencePeriods): array
    {
        $silenceDurations = $this->prepareSilencePeriods($silencePeriods);
        if (!count($silenceDurations)) {

            return [];
        }

        $chapters = $this->parseChapters(
            $silenceDurations,
            $this->chapterSilenceDuration,
            new DateInterval('PT0S'),
            $silenceDurations[count($silenceDurations) - 1]->getFrom()
        );

        $segmentsCollection = new SegmentsCollection($chapters);

        return $segmentsCollection->toArray();
    }

    /**
     * @param array $silencePeriods
     *
     * @return SilenceDuration[]
     */
    protected function prepareSilencePeriods(array $silencePeriods): array {

        $silenceDurations = [];
        foreach ($silencePeriods as $i => $silencePeriod) {
            $from = new DateInterval($silencePeriod['from']);
            $until = new DateInterval($silencePeriod['until']);

            $silenceDuration = $until->sub($from);

            $silenceDurations[$i] = new SilenceDuration($from, $until, $silenceDuration->getTotalMilliseconds());
        }

        return $silenceDurations;
    }

    /**
     * @param SilenceDuration[] $silenceDurations
     * @param int               $chapterSilenceDuration
     * @param DateInterval      $started
     * @param DateInterval      $ended
     * @param bool              $isChapter
     *
     * @return array
     */
    protected function parseChapters(
        array $silenceDurations,
        int $chapterSilenceDuration,
        DateInterval $started,
        DateInterval $ended,
        bool $isChapter = true
    ): array {
        $chapters = [];
        $chapterIndex = 0;
        foreach ($silenceDurations as $i => $silenceDuration) {

            if ($silenceDuration->getDuration() <= $chapterSilenceDuration) {
                continue;
            }

            $duration = $silenceDuration->getFrom()->getTotalMilliseconds() - $started->getTotalMilliseconds();
            if ($duration === 0) {

                continue;
            }

            $parts = [];
            if ($isChapter && ($duration > $this->longChapterMaxDuration)) {
                // Scan chapter and divide it into parts.

                // Get previous chapter's silence index.
                $silenceDurationIndex = isset($chapters[$chapterIndex - 1])
                    ? $chapters[$chapterIndex - 1]->getSilenceIndex()
                    : -1;

                $silenceDurationsParts = array_slice($silenceDurations, $silenceDurationIndex + 1, $i - $silenceDurationIndex - 1);

                $parts = $this->parseChapters(
                    $silenceDurationsParts,
                    $this->longChapterSilenceDuration,
                    $started,
                    $silenceDuration->getFrom(),
                    false
                );

            }

            $chapters[$chapterIndex] = new Chapter($i, $duration, $started, $parts);

            $started = $silenceDuration->getUntil();
            $chapterIndex++;

        }

        $duration = $ended->getTotalMilliseconds() - $started->getTotalMilliseconds();
        $chapters[$chapterIndex] = new Chapter(count($silenceDurations), $duration, $started, []);

        return $chapters;
    }

}
