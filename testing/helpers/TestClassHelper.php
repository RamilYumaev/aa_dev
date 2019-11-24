<?php

namespace testing\helpers;

use dictionary\helpers\DictClassHelper;
use testing\models\TestClass;

class TestClassHelper
{
    public static function testClassList($id) {
        return TestClass::find()->select('class_id')->andWhere(['test_id'=> $id])->column();
    }

    public static function TestClassString($id) {
        $classesTest = DictClassHelper::dictClassAll(self::testClassList($id));
        $typeClassTest = DictClassHelper::dictClassTypeAll(self::testClassList($id));

        $result = "";
        foreach ($typeClassTest as $type) {
            foreach($classesTest as $class) {
                if ($class['type'] == $type) {
                    $result .= $class['name']. ", ";
                }
            }
            $result = rtrim($result, ", "). " ";
            $result .= DictClassHelper::typeManyName($type).", ";
        }

        return rtrim ($result, ", ");
    }
}