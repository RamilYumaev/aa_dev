<?php

namespace common\moderation\widgets;

use modules\entrant\models\DocumentEducation;
use yii\base\Widget;

class ExportEducationWidget extends Widget
{
    public $id;

    public function run()
    {
        $model = DocumentEducation::find()->andWhere(['school_id' => $this->id])->all();
        return $this->render('school/index', [
            'model' => $model
        ]);
    }
}
