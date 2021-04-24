<?php

namespace App\Infrastructure;

class Arguments {

    /**
     * The path to an XML file with silence intervals.
     */
    public const ARG_INPUT_FILE = 'input';

    /**
     * The path to an output XML file with chapters information.
     */
    public const ARG_OUTPUT_FILE = 'output';

    /**
     * The silence duration which reliably indicates a chapter transition.
     * Value in microseconds.
     */
    public const ARG_CHAPTER_SILENCE_DURATION = 'chapter_silence_duration';

    /**
     * A silence duration which can be used to split a long chapter (always shorter
     * than the silence duration used to split chapters).
     * Value in microseconds.
     */
    public const ARG_LONG_CHAPTER_SILENCE_DURATION = 'long_chapter_silence_duration';

    /**
     * The maximum duration of a segment, after which the chapter will be broken up
     * into multiple segments.
     * Value in microseconds.
     */
    public const ARG_LONG_CHAPTER_MAX_DURATION = 'long_chapter_max_duration';

    /**
     * Parsed input arguments.
     *
     * @var array
     */
    protected array $args;

    /**
     * @param array $argv
     *
     * @throws InfrastructureException
     */
    public function __construct(array $argv)
    {
        parse_str(implode('&', array_slice($argv, 1)), $args);

        $this->validateInputArgs($args);

        $this->args = $args;
    }

    /**
     * Returns input file name.
     *
     * @return string
     */
    public function getInput(): string
    {
        return $this->args[self::ARG_INPUT_FILE];
    }

    /**
     * Returns chapter silence duration.
     *
     * @return float
     */
    public function getChapterSilenceDuration(): float
    {
        return (float)$this->args[self::ARG_CHAPTER_SILENCE_DURATION];
    }

    /**
     * Returns long chapter max duration.
     *
     * @return float
     */
    public function getLongChapterMaxDuration(): float
    {
        return (float)$this->args[self::ARG_LONG_CHAPTER_MAX_DURATION];
    }

    /**
     * Returns long chapter silence duration.
     *
     * @return float
     */
    public function getLongChapterSilenceDuration(): float
    {
        return (float)$this->args[self::ARG_LONG_CHAPTER_SILENCE_DURATION];
    }

    /**
     * Returns output file name if it is set.
     * Otherwise, returns null.
     *
     * @return string|null
     */
    public function getOutput(): ?string
    {
        return $this->args[self::ARG_OUTPUT_FILE] ?? null;
    }

    /**
     * @param array $args
     *
     * @throws InfrastructureException
     *
     * @return void
     */
    protected function validateInputArgs(array $args): void
    {
        if (!isset($args[self::ARG_INPUT_FILE])) {

            throw new InfrastructureException('Bad input file', InfrastructureErrors::ERROR_CODE_INPUT_FILE_ERROR);
        }

        if (!isset($args[self::ARG_CHAPTER_SILENCE_DURATION])) {

            throw new InfrastructureException('Bad silence duration for a chapter transition', InfrastructureErrors::ERROR_CODE_CHAPTER_SILENCE_DURATION_ERROR);
        }

        if (!isset($args[self::ARG_LONG_CHAPTER_MAX_DURATION])) {

            throw new InfrastructureException('Bad maximum duration of a segment to break up the chapter into multiple segments', InfrastructureErrors::ERROR_CODE_LONG_CHAPTER_MAX_DURATION_ERROR);
        }

        if (!isset($args[self::ARG_LONG_CHAPTER_SILENCE_DURATION])) {

            throw new InfrastructureException('Bad silence duration used to split a long chapter', InfrastructureErrors::ERROR_CODE_LONG_CHAPTER_SILENCE_DURATION_ERROR);
        }

        if ((float)$args[self::ARG_CHAPTER_SILENCE_DURATION] <= 500) {

            throw new InfrastructureException('Bad silence duration for a chapter transition, should be greater than 500 milliseconds', InfrastructureErrors::ERROR_CODE_CHAPTER_SILENCE_DURATION_ERROR);
        }

        if ((float)$args[self::ARG_LONG_CHAPTER_SILENCE_DURATION] < 500) {

            throw new InfrastructureException('Bad silence duration used to split a long chapter, should be greater than or equal to 500 milliseconds', InfrastructureErrors::ERROR_CODE_LONG_CHAPTER_SILENCE_DURATION_ERROR);
        }

        if ((float)$args[self::ARG_CHAPTER_SILENCE_DURATION] <= (float)$args[self::ARG_LONG_CHAPTER_SILENCE_DURATION]) {

            throw new InfrastructureException('Bad silence duration for a chapter transition, should be greater than the silence duration used to split a long chapter', InfrastructureErrors::ERROR_CODE_CHAPTER_SILENCE_DURATION_ERROR);
        }
    }

}
