<?php
namespace modules\superservice\components\data;
use modules\superservice\components\DataXml;

class OlympicProfileList extends DataXml
{
    public function getNameTitle(): string
    {
       return 'Профиль олимпиады';
    }
}