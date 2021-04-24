<?php

namespace App\Application\Chapter;

class SegmentsCollection
{
    /**
     * @var Segment[]
     */
    protected array $segments = [];

    /**
     * Initialize the segments collection using chapters collection.
     *
     * @param array $chapters
     */
    public function __construct(array $chapters)
    {
        foreach ($chapters as $i => $chapter) {
            if ($chapter->getParts() === []) {

                $this->add(new Segment($i + 1, $chapter->getOffset()));
                continue;
            }

            foreach ($chapter->getParts() as $j => $part) {
                $this->add(new Segment($i + 1, $part->getOffset(), $j + 1));
            }
        }
    }

    /**
     * Adds a new segment into the collection.
     *
     * @param Segment $segment
     *
     * @return void
     */
    public function add(Segment $segment): void
    {
        $this->segments[] = $segment;
    }

    /**
     * Returns the collection as array.
     *
     * @return array[]
     */
    public function toArray(): array
    {
        $segmentsArray = [];

        foreach ($this->segments as $segment) {
            $segmentsArray[] = $segment->toArray();
        }

        return ['segments' => $segmentsArray];
    }
}
