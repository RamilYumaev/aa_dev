<?php
namespace dictionary\helpers;

use dictionary\models\DictSchoolsReport;
use yii\helpers\ArrayHelper;

class DictSchoolsReportHelper
{
    public static function schoolReportList(): array
    {
        return DictSchoolsReport::find()->joinWith('school')->select(['dict_schools.name',"dict_schools_report.id" ])->indexBy('dict_schools_report.id')->column();
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