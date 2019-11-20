<?php

namespace olympic\readRepositories;


use dictionary\helpers\TemplatesHelper;
use dictionary\repositories\TemplatesRepository;
use olympic\helpers\OlympicHelper;
use olympic\models\PersonalPresenceAttempt;
use olympic\repositories\OlimpicListRepository;
use testing\models\TestAttempt;
use yii\web\HttpException;

class PrintReadRepository
{
    private $templatesRepository;
    public $olimpicListRepository;


    public function __construct(TemplatesRepository $templatesRepository,
                                OlimpicListRepository $olimpicListRepository)
    {
        $this->templatesRepository = $templatesRepository;
        $this->olimpicListRepository = $olimpicListRepository;

    }

    public function getTemplatesAndOlympic($template_id, $olympic_id)
    {
        $template = $this->templatesRepository->get($template_id);
        $olympic = $this->olimpicListRepository->get($olympic_id);

        return str_replace(TemplatesHelper::templatesLabelOLympic(), $olympic->replaceLabelsFromTemplate(), $template->text);
    }

    public function  getResultOlympic($olympic_id, $numTour) {
        $olympic = $this->olimpicListRepository->get($olympic_id);
        if ($olympic ->current_status == OlympicHelper::REG_STATUS) {
            throw new HttpException('403', 'Результаты еще не опубликованы');
        } else {
            switch ($olympic->form_of_passage) {
                case OlympicHelper::OCHNAYA_FORMA :
                    $model = PersonalPresenceAttempt::find()->olympicAttempt($olympic);
                    break;
                case OlympicHelper::ZAOCHNAYA_FORMA :
                    $model = TestAttempt::find()->olympicAttempt($olympic);
                    break;
                case OlympicHelper::OCHNO_ZAOCHNAYA_FORMA :
                    if ($numTour == OlympicHelper::ZAOCH_FINISH && $olympic->current_status) {
                        $model = TestAttempt::find()->olympicAttempt($olympic);
                    } elseif ($numTour == OlympicHelper::OCH_FINISH && $olympic->current_status) {
                        $model = PersonalPresenceAttempt::find()->olympicAttempt($olympic);
                    } else {
                        throw new HttpException('403', 'Результаты еще не опубликованы');
                    }
                    break;
                default : {
                    throw new HttpException('403', 'Результаты еще не опубликованы');
                }
            }
        }
        return $model;
    }
}