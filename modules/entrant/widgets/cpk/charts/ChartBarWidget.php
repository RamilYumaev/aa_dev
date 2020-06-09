<?php
namespace modules\entrant\widgets\cpk\charts;

use dictionary\helpers\DictCompetitiveGroupHelper;
use dictionary\models\DictCompetitiveGroup;
use modules\entrant\models\StatementCg;
use yii\base\Widget;

class ChartBarWidget extends Widget
{
    public $key;
    public $view = "charts\bar";
    /* @var $cg \dictionary\models\DictCompetitiveGroup */
    public $cg;

    public function run()
    {
        $query = DictCompetitiveGroup::find()
            ->currentYear('2019-2020')
            ->finance(DictCompetitiveGroupHelper::FINANCING_TYPE_BUDGET)
            ->eduLevel($this->cg->edu_level)
            ->speciality($this->cg->speciality_id)
            ->specialization($this->cg->specialization_id)
            ->faculty($this->cg->faculty_id)
            ->formEdu($this->cg->education_form_id);

        $kcp = clone $query;
        $ids  = clone $query;

        $zuk = StatementCg::find()->statementAcceptedStatus($ids->select('id')->column())->count();
        $zos = StatementCg::find()->statementConsentAcceptedStatus($ids->select('id')->column())->count();
        return $this->render($this->view, ['key'=> $this->key, 'cg'=> $this->cg,
            'kcp' => $kcp->sum('kcp'), 'zuk' => $zuk, 'zos' => $zos]);
    }

}
