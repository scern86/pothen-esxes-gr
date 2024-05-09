<?php

namespace PothenEsxes;

class ReplyDate
{
    /**
     * @param \DateTime|null $dateTime last holiday
     * @return \DateTime next business day, 17:00 in ISO 8601
     */
    public static function getNextBusinessDate(?\DateTime $dateTime=null): \DateTime
    {
        if (is_null($dateTime)) {
            $dateTime = new \DateTime();
        }
        $dayOfWeek = $dateTime->format('N');
        switch ($dayOfWeek) {
            case 5: // Friday
                $dateTime->modify('+3 days');
                break;
            case 6: // Saturday
                $dateTime->modify('+2 days');
                break;
            default: // Other days
                $dateTime->modify('+1 day');
                break;
        }
        $dateTime->setTime(17, 0);
        return $dateTime;/*->format('Y-m-d\TH:i:s\Z'));*/
    }
}