<?php


namespace modules\entrant\controllers\backend;
use Codeception\Lib\Di;
use dictionary\helpers\DictCompetitiveGroupHelper;
use dictionary\models\DictCompetitiveGroup;
use modules\dictionary\helpers\JobEntrantHelper;
use modules\dictionary\models\JobEntrant;
use modules\entrant\helpers\CategoryStruct;
use modules\entrant\helpers\StatementHelper;
use modules\entrant\models\Anketa;
use modules\entrant\readRepositories\StatementCgReadRepository;
use modules\entrant\searches\StatementCgSearch;
use modules\entrant\services\StatementConsentCgService;
use yii\base\ExitException;
use yii\web\Controller;
use Yii;
use yii\web\NotFoundHttpException;

class ChartsController extends Controller
{
    private $service;

    public function __construct($id, $module, StatementConsentCgService $service, $config = [])
    {
        $this->service = $service;
        parent::__construct($id, $module, $config);
    }

    public function beforeAction($event)
    {
        if(!in_array($this->jobEntrant->category_id, JobEntrantHelper::listCategoriesZUK())) {
            Yii::$app->session->setFlash("warning", 'Страница недоступна');
            Yii::$app->getResponse()->redirect(['site/index']);
            try {
                Yii::$app->end();
            } catch (ExitException $e) {
            }
        }
        return true;
    }

    public function actionIndex()
    {
        return $this->render('index', [
            'cgs' => $this->findModelAll(),
        ]);
    }

    /* @return  JobEntrant*/
    protected function getJobEntrant() {
        return Yii::$app->user->identity->jobEntrant();
    }

    /**
     * @param integer $id
     * @return mixed

     */
    protected function findModelAll()
    {
        $query = DictCompetitiveGroup::find()
            ->finance(DictCompetitiveGroupHelper::FINANCING_TYPE_BUDGET)
            ->withoutForeignerCg()
            ->currentAutoYear();
        if($this->jobEntrant->isCategoryFOK()) {
            $query->faculty($this->jobEntrant->faculty_id)->eduLevel([
            DictCompetitiveGroupHelper::EDUCATION_LEVEL_BACHELOR,
                DictCompetitiveGroupHelper::EDUCATION_LEVEL_MAGISTER]);
        }
        if(in_array($this->jobEntrant->category_id,JobEntrantHelper::listCategoriesFilial())) {
            $query->faculty($this->jobEntrant->category_id);
        }
        $query->select(['speciality_id', 'edu_level', 'education_form_id', 'faculty_id', 'specialization_id'])
            ->groupBy(['speciality_id', 'edu_level', 'education_form_id', 'faculty_id', 'specialization_id']);
        return $query->all();
    }



}