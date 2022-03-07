<?php

namespace App\Tests;

use DateTime;
use Exception;
use PHPUnit\Framework\TestCase;

class MatchDateFromStringTest extends TestCase
{

    const DATETIME_FORMAT_SLASH = 'd/m/Y';
    const DATETIME_FORMAT_DASH = 'dd-mm-yyyy';

    /**
     * @dataProvider provider
     */
    public function testMatchDateFromString($string, $expectedFrom, $expectedTo)
    {
        $regexDateTime = '/(\d{1,2}(?:\/|\-)\d{1,2}(?:\/|\-)\d{4})/';
        $regexHour = '/desde las (\d{1,2}(?:\:\d{1,2})?) a las (\d{1,2}(?:\:\d{1,2})?)/';

        preg_match($regexDateTime, $string, $matches);

        $dateTimeFrom = null;
        if (isset($matches[1])) {
            $dateTimeFrom = DateTime::createFromFormat(self::DATETIME_FORMAT_SLASH, $matches[1]);

            preg_match($regexHour, $string, $matchesHour);

            print_r($matchesHour);
            $fromHour = '';
            $fromMin = '';
            if (isset($matchesHour[1])) {
                $hourMinuteFrom = explode(':', $matchesHour[1] ?? '');
                $fromHour = (int) $hourMinuteFrom[0] ?? null;
                $fromMin = intval($hourMinuteFrom[1] ?? 0);
            }
            $dateTimeFrom->setTime($fromHour, $fromMin);

            $dateTimeTo = clone $dateTimeFrom;
            if (isset($matchesHour[2])) {
                $hourMinuteTo = explode(':', $matchesHour[2] ?? '');
                $toHour = (int) $hourMinuteTo[0] ?? null;
                $toMin = intval($hourMinuteTo[1] ?? 0);
            }
            $dateTimeTo->setTime($toHour, $toMin);


            $this->assertEquals($expectedFrom, $dateTimeFrom->format('Y-m-d H:i'));
            $this->assertEquals($expectedTo, $dateTimeTo->format('Y-m-d H:i'));
        }
    }


    public function provider()
    {
        return [
            ['El próximo día 21/05/2019 se celebrará desde las 14 a las 15:30 horas el congreso de …', '2019-05-21 14:00', '2019-05-21 15:30']
        ];
    }
}
