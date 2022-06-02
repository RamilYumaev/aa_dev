<?php
namespace modules\superservice\components\data;
use modules\superservice\components\DataXml;

class OlympicsProfilesList extends DataXml
{
    public function nameFileXml()
    {
        return 'OlympicProfileList';
        var_dump('выаыв');
    }

    public function getNameTitle(): string
    {
       return 'Профиль олимпиады';
    }
}