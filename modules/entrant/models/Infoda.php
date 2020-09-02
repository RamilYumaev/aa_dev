<?php

namespace modules\entrant\models;
use common\moderation\behaviors\ModerationBehavior;
use common\moderation\interfaces\YiiActiveRecordAndModeration;
use dictionary\helpers\DictCompetitiveGroupHelper;
use modules\dictionary\helpers\DictOrganizationsHelper;
use modules\dictionary\models\DictOrganizations;
use modules\entrant\behaviors\FileBehavior;
use modules\entrant\forms\AgreementForm;
use modules\entrant\helpers\AgreementHelper;
use modules\entrant\helpers\DateFormatHelper;
use modules\entrant\models\queries\AgreementQuery;
use olympic\models\auth\Profiles;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%infoda}}".
 *
 * @property integer $id
 * @property integer $incoming_id
 * @property string  $login
 * @property string  $pass
 **/

class Infoda extends ActiveRecord
{

    public static function tableName()
    {
        return '{{%infoda}}';
    }

}