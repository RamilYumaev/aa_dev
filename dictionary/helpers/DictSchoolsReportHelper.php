<?php
namespace dictionary\helpers;

use dictionary\models\DictSchoolsReport;
use yii\helpers\ArrayHelper;

class DictSchoolsReportHelper
{

    public static function schoolReportList(): array
    {
        return ArrayHelper::map(DictSchoolsReport::find()->asArray()->all(), "id", function (array $model) {
            return DictSchoolsHelper::schoolName($model['school_id']);
        });
    }

    public static function isSchoolReport($id, $school_id): ? DictSchoolsReport
    {
        return DictSchoolsReport::findOne(['id' => $id, 'school_id'=>$school_id]);
    }

    public static function schoolReportName($key): ?string
    {
        return ArrayHelper::getValue(self::schoolReportList(), $key);
    }
}