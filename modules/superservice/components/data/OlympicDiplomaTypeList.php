<?php
namespace modules\superservice\components\data;


use modules\superservice\components\DataXml;

class OlympicDiplomaTypeList extends DataXml
{
    public function getNameTitle(): string
    {
       return 'Типы диплома олимпиады';
    }
}