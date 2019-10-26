<?php


namespace olympic\helpers;


class PersonalPresenceAttemptHelper
{
    /**
     * {@inheritdoc}
     */

    const PRESENCE = 1;
    const NON_APPREARANCE = 0;
    const NOMINATION = 0;
    const FIRST_PLACE = 1;
    const SECOND_PLACE = 2;
    const THIRD_PLACE = 3;


    public static function nameOfPlaces()
    {
        return [
            self::NOMINATION => 'Победитель в номинации',
            self::FIRST_PLACE => 'Победитель',
            self::SECOND_PLACE => 'Призер II степени',
            self::THIRD_PLACE => 'Призер III степени',
        ];
    }

    public static function nameOfPlacesForCert()
    {
        return [
            self::NOMINATION => 'победителем в номинации',
            self::FIRST_PLACE => 'победителем',
            self::SECOND_PLACE => 'призером II степени',
            self::THIRD_PLACE => 'призером III степени',
        ];
    }

}