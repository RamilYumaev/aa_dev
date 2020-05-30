<?php
namespace common\auth\actions;
use common\auth\forms\SignupForm;
use common\auth\services\SignupService;
use common\helpers\FlashMessages;
use modules\dictionary\forms\JobEntrantAndProfileForm;
use modules\dictionary\forms\JobEntrantForm;
use modules\dictionary\models\JobEntrant;
use modules\dictionary\services\JobEntrantService;
use Yii;

class JobEntrantAction extends \yii\base\Action
{
    private $viewPath = "@common/auth/actions/views/job-entrant";
    private $service;

    public $role;

    public function __construct($id, $controller, JobEntrantService $service, $config = [])
    {
        parent::__construct($id, $controller, $config);
        $this->service = $service;

    }

    public function run()
    {
        $this->controller->viewPath = $this->viewPath;
        $this->controller->layout = "@frontend/views/layouts/loginRegister.php";

        if (Yii::$app->user->isGuest) {
            return $this->controller->goHome();
        }
        $model = JobEntrant::findOne(['user_id' => Yii::$app->user->identity->getId()]) ?? null;

        $form = new JobEntrantAndProfileForm($model);
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->createEntrantJob($form, $model);

                return $this->controller->goHome();
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }

        return $this->controller->render('index', [
            'model' => $form,
            'jobEntrant' => $model
        ]);
    }

}