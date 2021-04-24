<?php

namespace App\Application;

use App\Application\Chapter\ChapterParser;
use App\Application\Factory\ReaderFactory;
use App\Application\Factory\WriterFactory;
use App\Infrastructure\Arguments;

class Application {

    public function run(Arguments $args): void
    {
        $reader = ReaderFactory::createReader($args->getInput());
        $silencePeriods = $reader->read($args->getInput());

        // Chapters and parts analysis.
        $chapterParser = new ChapterParser(
            $args->getChapterSilenceDuration(),
            $args->getLongChapterSilenceDuration(),
            $args->getLongChapterMaxDuration()
        );

        $segments = $chapterParser->parse($silencePeriods);

        $writer = WriterFactory::createWriter($args->getOutput());
        $writer->write($args->getOutput(), $segments);

    }

}
