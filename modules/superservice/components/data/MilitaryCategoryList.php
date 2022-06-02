<?php
namespace modules\superservice\components\data;


use modules\superservice\components\DataXml;

class MilitaryCategoryList extends DataXml
{
    public function getNameTitle(): string
    {
       return 'Категория военнослужащего';
    }
}