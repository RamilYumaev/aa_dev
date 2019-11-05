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
        $olympTypeTemplates = OlimpiadsTypeTemplates::find();
        $olympTypeTemplatesSpecial = $olympTypeTemplates->templatesOlympicTypeAllSpecial($this->model->id);
        if ($olympTypeTemplatesSpecial) {
            $allTemplates = $olympTypeTemplatesSpecial;
        } else {
            $allTemplates = $olympTypeTemplates->templatesOlympicTypeAllNoSpecial($this->model->number_of_tours,
                $this->model->form_of_passage, $this->model->edu_level_olymp);
        }
        return $this->render($this->view, [
             'allTemplates' => $allTemplates,
              'model' => $this->model
        ]);
    }
}