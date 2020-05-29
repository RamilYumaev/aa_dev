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


    public static function dataSwitcher(array $array): array
    {
        $result = [];
        foreach ($array as $key => $item) {
            $result[] = [
                'id' => $key,
                'text' => $item,
            ];
        }
        return $result;
    }

}