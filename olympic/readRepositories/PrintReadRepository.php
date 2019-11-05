<?php

namespace olympic\readRepositories;


use dictionary\helpers\TemplatesHelper;
use dictionary\repositories\TemplatesRepository;
use olympic\repositories\OlimpicListRepository;

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
}