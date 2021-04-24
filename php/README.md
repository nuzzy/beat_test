# PHP App For Segments Parsing

This application (script and libraries) provides ability to parse input silence interval into chapters and parts (segments).

## Formats

Input format: XML file (ISO 8601).

Output format: JSON file or JSON string printed into the console screen.

## Script parameters

* `input` - path to the XML file (`.xml`).
* `output` - path to the JSON file (`.json`). Not required. If skipped, the output will be printed into the console screen.
* `chapter_silence_duration` - silence duration for a chapter transition. In milliseconds. Should be greater than 500 milliseconds.
* `long_chapter_silence_duration` - silence duration used to split a long chapter. In milliseconds. Should be greater than or equal to 500 milliseconds. Should be lower than `chapter_silence_duration` value.
* `long_chapter_max_duration` - maximum duration of a segment to break up the chapter into multiple segments. In milliseconds.

### Run script using a console command

```
php silence.php input="../silence-files/silence1.xml" output="../silence-files/out1.json" chapter_silence_duration=3000 long_chapter_max_duration=4000000 long_chapter_silence_duration=1500

php silence.php input="../silence-files/silence2.xml" output="../silence-files/out2.json" chapter_silence_duration=3000 long_chapter_max_duration=3000000 long_chapter_silence_duration=1000

php silence.php input="../silence-files/silence3.xml" output="../silence-files/out3.json" chapter_silence_duration=3000 long_chapter_max_duration=1800000 long_chapter_silence_duration=500

```
