<?php


namespace common\components;


class JsonAjaxField
{

    public static function data(array $arrayKey, array $arrayAttributeName): array
    {
        $result = [];
        foreach ($arrayKey as $key) {

            $result[] = [
                'id' => $key,
                'text' => $arrayAttributeName[$key],
            ];
        }

        return $result;
    }

}