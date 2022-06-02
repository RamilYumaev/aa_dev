<?php
namespace modules\superservice\components\data;


use modules\superservice\components\DataXml;

class AppealStatusList extends DataXml
{
    public function getNameTitle(): string
    {
       return 'Статус апелляции';
    }
}