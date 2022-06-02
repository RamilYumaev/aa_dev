<?php
namespace modules\superservice\components\data;


use modules\superservice\components\DataXml;

class OlympicDiplomaTypes extends DataXml
{
    public function nameFileXml()
    {
        return 'OlympicDiplomaTypeList';
    }

    public function getNameTitle(): string
    {
       return 'Типы диплома олимпиады';
    }
}