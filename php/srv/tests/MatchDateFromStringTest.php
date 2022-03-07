<?php

namespace App\Tests;

use App\Service\DateTimeMatcher;
use PHPUnit\Framework\TestCase;

class MatchDateFromStringTest extends TestCase
{

    protected DateTimeMatcher $dateTimeMatcher;

    protected function setup(): void
    {
        $this->dateTimeMatcher = new DateTimeMatcher();
    }

    /**
     * @dataProvider provider
     */
    public function testMatchDateFromString($string, $expectedFrom, $expectedTo)
    {

        [$dateTimeFrom, $dateTimeTo] = $this->dateTimeMatcher->match($string);
        $this->assertEquals($expectedFrom, $dateTimeFrom->format('Y-m-d H:i'));
        $this->assertEquals($expectedTo, $dateTimeTo->format('Y-m-d H:i'));
    }

    public function provider()
    {
        return [
            ['El próximo día 21/05/2019 se celebrará desde las 14 a las 15:30 horas el congreso de …', '2019-05-21 14:00', '2019-05-21 15:30'],
            ['El próximo día 22-03-2017 se celebrará desde las 14:20 a las 15 horas el congreso de …', '2017-03-22 14:20', '2017-03-22 15:00'],
        ];
    }
}
