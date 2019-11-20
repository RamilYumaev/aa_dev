<?php
namespace frontend\widgets\olympictemplates;

use dictionary\models\OlimpiadsTypeTemplates;
use yii\base\Widget;

class OlympicTemplatesWidget extends Widget
{
    public $model;
    /**
     * @var string
     */
    public $view = 'olympic-template/index';
    /**
     * @return string
     */
    public function run()
    {
        if ($this->olympicTypeTemplatesSpecial()->exists()) {
            $allTemplates = $this->olympicTypeTemplatesSpecial();
        } else {
            $allTemplates = $this->olympicTypeTemplatesNoSpecial();
        }
        return $this->render($this->view, [
             'allTemplates' => $allTemplates->all(),
              'model' => $this->model
        ]);
    }

    private function olympicTypeTemplatesNoSpecial() {
        return OlimpiadsTypeTemplates::find()->templatesOlympicTypeAllNoSpecial($this->model->number_of_tours,
            $this->model->form_of_passage, $this->model->edu_level_olymp, $this->model->year);
    }

    private function olympicTypeTemplatesSpecial() {
        return OlimpiadsTypeTemplates::find()->templatesOlympicTypeAllSpecial($this->model->id, $this->model->year);
    }
}