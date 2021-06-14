<?php


namespace modules\entrant\helpers;

use dictionary\helpers\DictCompetitiveGroupHelper;
use dictionary\models\DictCompetitiveGroup;
use modules\dictionary\models\SettingEntrant;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use modules\entrant\models\UserCg;
use yii\helpers\Url;

class UserCgHelper
{
    public static function link($id, $financingTypeId,  $cathedra_id = null)
    {
        return self::getLinkBase(
            self::findUserCg($id) ? "glyphicon-minus" : "glyphicon-plus",
            $id,
            self::findUserCg($id) ? "/abiturient/applications/remove-cg"
                : "/abiturient/applications/save-cg",
            self::buttonName($financingTypeId),  $cathedra_id);
    }


    private static function buttonArray()
    {
        return [
            DictCompetitiveGroupHelper::FINANCING_TYPE_BUDGET => "btn-success",
            DictCompetitiveGroupHelper::FINANCING_TYPE_CONTRACT => "btn-warning",

        ];
    }

    private static function buttonName($key)
    {
        return ArrayHelper::getValue(self::buttonArray(), $key);
    }

    private static function getLinkBase($typeIcon, $id, $url, $typeButton, $cathedra_id = null)
    {
        return Html::a(Html::tag('span', '', ['class' => 'glyphicon ' . $typeIcon]),
            [$url, 'id' => $id, 'cathedra_id' => $cathedra_id],
            ['data-pjax' => '#get-bachelor',
                'class' => 'btn ' . $typeButton,
            ]);
    }

    public static function findUserCg($id)
    {
        return UserCg::find()->findUserAndCg($id)->exists();
    }

    public static function findUser($user_id)
    {
        return UserCg::find()->where(['user_id'=>$user_id])->exists();
    }

    public static function cgUserColumn($userId)
    {
       $cgs = [];
       foreach (UserCg::find()->andWhere(['user_id' => $userId])->all() as $userCg)  {
           /** @var DictCompetitiveGroup $cg */
           $cg = $userCg->cg;
           if(!SettingEntrant::find()->isOpenZUK($cg)) {
               continue;
           }
           $cgs[] =$userCg->cg_id;
       }
       return $cgs;
    }

    public static function userMedicine($user_id) {
        foreach (UserCg::find()->where(['user_id'=>$user_id])->all() as $cg)
        {   /* @var $cg UserCg */
            if ($cg->isMedicine()) {
                $bool = true;
                break;
            }
        }
        return $bool ?? false;
    }

    public static function userIsBudgetAndBachelor($user_id) {
        foreach (UserCg::find()->where(['user_id'=>$user_id])->all() as $cg)
        {   /* @var $cg UserCg */
            if ($cg->isBudgetAndBachelor()) {
                $bool = true;
                break;
            }
        }
        return $bool ?? false;
    }

    public static function userIsBudgetBachMagGrad($user_id) {
        foreach (UserCg::find()->where(['user_id'=>$user_id])->all() as $cg)
        {   /* @var $cg UserCg */
            if ($cg->isBudgetBachMagGrad()) {
                $bool = true;
                break;
            }
        }
        return $bool ?? false;
    }



    public static function trColor(DictCompetitiveGroup $cgContract): String
    {


        $budgetCg = DictCompetitiveGroup::find()->findBudgetAnalog($cgContract)->one();

        $userWarning = UserCg::find()->findUserAndCg($cgContract->id)->exists();

        if($cgContract->isGovLineCg() && $userWarning)
        {
            return " class=\"success\" ";
        }

        if ($budgetCg !== null) {

            $userSuccess = UserCg::find()->findUserAndCg($budgetCg->id)->exists();

            if ($userWarning && $userSuccess) {
                return " class=\"info\" ";
            }

            if ($userSuccess) {
                return " class=\"success\" ";
            }
        }
        if ($userWarning) {
            return " class=\"warning\" ";
        }

        return "";

    }

    public static function specialColor(Int $cgId): String
    {
        if (UserCg::find()->findUserAndCg($cgId)->exists()) {
            return " class=\"success\" ";
        }

        return "";
    }

}