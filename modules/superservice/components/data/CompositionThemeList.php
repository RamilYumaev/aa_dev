<?php
namespace modules\superservice\components\data;


use modules\superservice\components\DataXml;

class CompositionThemeList extends DataXml
{
    public function getNameTitle(): string
    {
       return 'Тема сочинения';
    }
}