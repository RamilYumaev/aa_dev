<?php
namespace modules\entrant\widgets\other;

use modules\entrant\models\OtherDocument;
use modules\entrant\models\UserIndividualAchievements;
use yii\base\Widget;

class DocumentOtherFileWidget extends Widget
{
    public $userId;
    public $view = 'file';
    public $ia = false;
    public function run()
    {
        if(!$this->ia) {
            $model = OtherDocument::find()->where(['user_id'=>$this->userId])
                ->andWhere(['not in','id', UserIndividualAchievements::find()->user($this->userId)->select('document_id')->column()])
                ->all();
        } else {
            $model = OtherDocument::find()->where(['user_id'=>$this->userId])
            ->andWhere(['id'=> UserIndividualAchievements::find()->user($this->userId)->select('document_id')->column()])
            ->all();
        }
        return $this->render($this->view, [
            'others' => $model,
            'ia' => $this->ia,
        ]);
    }

}
