<?php

namespace common\moderation\widgets;

use modules\entrant\models\AisReturnData;
use yii\base\Widget;

class ExportDataWidget extends Widget
{
    public $model;
    public $sdoId;
    public $id;

    public function run()
    {
        $model = AisReturnData::findOne(['model' => $this->model, 'record_id_sdo' => $this->sdoId]);
        return $this->render('export/index', [
            'model' => $model,
            'id' => $this->id,
        ]);
    }
}
