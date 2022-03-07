<?php

namespace App\Service;

use DateTime;
use Exception;

class DateTimeMatcher
{

    const REGEX_DATE = '/(\d{1,2}(?:\/|\-)\d{1,2}(?:\/|\-)\d{4})/';
    const REGEX_HOUR = '/desde las (\d{1,2}(?:\:\d{1,2})?) a las (\d{1,2}(?:\:\d{1,2})?)/';

    const DATETIME_FORMAT_SLASH = 'd/m/Y';
    const DATETIME_FORMAT_DASH = 'd-m-Y';

    const DATETIME_FORMATS = [
        'slash' => self::DATETIME_FORMAT_SLASH,
        'dash' => self::DATETIME_FORMAT_DASH,
    ];

    public function match(string $string): array
    {

        preg_match(self::REGEX_DATE, $string, $matches);

        if(!isset($matches)){
            throw new Exception(sprintf('Error DateTimeMatcher date on string "%s"', $string));
        }

        $format = strpos($matches[1], '/') ? 'slash' : 'dash';

        $dateTimeFrom = DateTime::createFromFormat(self::DATETIME_FORMATS[$format], $matches[1]);

        preg_match(self::REGEX_HOUR, $string, $matchesHour);

        [$hour, $min] = $this->getHourAndMinute($matchesHour[1]);
        $dateTimeFrom->setTime($hour, $min);
        
        $dateTimeTo = clone $dateTimeFrom;
        [$hour, $min] = $this->getHourAndMinute($matchesHour[2]);
        $dateTimeTo->setTime($hour, $min);

        return [$dateTimeFrom, $dateTimeTo];
    }

    protected function getHourAndMinute(string $string)
    {

        $hourMin = explode(':', $string);
        $hour = intval($hourMin[0] ?? 0);
        $min = intval($hourMin[1] ?? 0);

        return [$hour, $min];
    }
}
