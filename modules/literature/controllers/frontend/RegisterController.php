<?php
namespace modules\literature\controllers\frontend;

use common\auth\Identity;
use common\auth\models\User;
use common\helpers\FlashMessages;
use common\sending\traits\SelectionCommitteeMailTrait;
use dictionary\helpers\DictCountryHelper;
use dictionary\helpers\DictRegionHelper;
use modules\entrant\helpers\DateFormatHelper;
use modules\literature\forms\RegisterForm;
use modules\literature\forms\search\PersonsSearch;
use modules\literature\forms\SignupForm;
use modules\literature\models\LiteratureOlympic;
use modules\literature\models\PersonsLiterature;
use modules\literature\models\UserPersonsLiterature;
use olympic\forms\auth\ProfileCreateForm;
use olympic\forms\auth\UserCreateForm;
use olympic\helpers\auth\ProfileHelper;
use olympic\models\auth\Profiles;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use Yii;
use yii\web\UploadedFile;

class RegisterController extends Controller
{
    use SelectionCommitteeMailTrait;

    /**
     * @return string|\yii\web\Response
     * @throws \Exception
     */
    public function actionIndex()
    {
        if (!Yii::$app->user->isGuest) {
            $userId = Yii::$app->user->identity->getId();
            $model = new RegisterForm(User::findOne($userId));
        } else {
            $model = new RegisterForm();
        }
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            try {
                $user = $this->serviceUserProfile($model);
                if (!$model->ifUser) {
                    Yii::$app->session->setFlash('success', FlashMessages::get()["successRegistration"]);
                    Yii::$app->user->login(new Identity($user), 1);
                }
                return $this->redirect('step2');
            }catch (\DomainException $domainException) {
                Yii::$app->session->setFlash('danger', $domainException->getMessage());
            }
        }
        return $this->render('index', [
            'model' => $model,
            'step' => 1
        ]);
    }

    public function actionStep2() {
        if (Yii::$app->user->isGuest) {
            return $this->redirect('index');
        }
        $model = $this->getModel();
        if($model) {
            $model->birthday = DateFormatHelper::formatView($model->birthday);
            $model->date_issue = DateFormatHelper::formatView($model->date_issue);
        }else {
            $model = new LiteratureOlympic();
        }
        $model->setScenario(LiteratureOlympic::PERSON_DATA);
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $model->birthday = DateFormatHelper::formatRecord($model->birthday);
            $model->date_issue = DateFormatHelper::formatRecord($model->date_issue);
            $model->user_id = $this->getUserId();
            $photo = UploadedFile::getInstance($model, "photo");
            $model->photo = $photo;
            $file = UploadedFile::getInstance($model, "agree_file");
            $model->agree_file = $file;
            $model->save();
            return $this->redirect('step3');
        }
        return $this->render('step2', [ 'step' => 2, 'model' => $model]);
    }

    public function actionStep3() {
        if (Yii::$app->user->isGuest) {
            return $this->redirect('index');
        }
        $model = $this->getModel();
        if (!$model) {
            return $this->redirect('step2');
        }
        $model->setScenario(LiteratureOlympic::SCHOOL_DATA);
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $model->save();
            return $this->redirect('step4');
        }
        return $this->render('step3', [ 'step' => 3, 'model' => $model]);
    }

    public function actionStep4() {
        if (Yii::$app->user->isGuest) {
            return $this->redirect('index');
        }
        $model = $this->getModel();
        if (!$model) {
            return $this->redirect('step2');
        }
        $model->setScenario(LiteratureOlympic::ADDITIONAL_DATA);
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $model->save();
            return $this->redirect('step5');
        }
        return $this->render('step4', [ 'step' => 4, 'model' => $model]);
    }

    public function actionAddPerson($id) {
        if (Yii::$app->user->isGuest) {
            return $this->redirect('index');
        }
        $model = $this->getModel();
        if (!$model) {
            return $this->redirect('step2');
        }
        if(!UserPersonsLiterature::findOne(['persons_literature_id' => $id, 'user_id'=> $model->user_id]) && PersonsLiterature::findOne($id)) {
            $m = new UserPersonsLiterature();
            $m->user_id = $model->user_id;
            $m->persons_literature_id = $id;
            $m->save();
            Yii::$app->session->setFlash('success', "Успешно добавлено");
        }
        return $this->redirect(Yii::$app->request->referrer);
    }

    /**
     * @param $id
     * @return \yii\web\Response
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionDeletePerson($id) {
        if (Yii::$app->user->isGuest) {
            return $this->redirect('index');
        }
        $model = $this->getModel();
        if (!$model) {
            return $this->redirect('step2');
        }
        if(($m = UserPersonsLiterature::findOne(['persons_literature_id' => $id, 'user_id'=> $model->user_id])) && PersonsLiterature::findOne($id)) {
            $m->delete();
            Yii::$app->session->setFlash('success', "Успешно удалено");
        }
        return $this->redirect(Yii::$app->request->referrer);
    }

    public function actionStep6() {
        if (Yii::$app->user->isGuest) {
            return $this->redirect('index');
        }
        $model = $this->getModel();

        if (!$model) {
            return $this->redirect('step2');
        }

        if(!UserPersonsLiterature::findOne([ 'user_id'=> $model->user_id])) {
            Yii::$app->session->setFlash('warning', "Необходимо доабвить данные сопровождающего");
            return $this->redirect('step5');
        }
        if($model->region == 77) {
            Yii::$app->session->setFlash('success', "Спасибо за регистрацию");
            return $this->redirect(['default/index']);
        }
        $model->setScenario(LiteratureOlympic::ROUTE_DATA);
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $model->save();
            Yii::$app->session->setFlash('success', "Спасибо за регистрацию");
            return $this->redirect(['default/index']);
        }
        return $this->render('step6', [ 'step' => 6, 'model' => $model]);
    }

    public function actionStep5()
    {
        if (Yii::$app->user->isGuest) {
            return $this->redirect('index');
        }
        $olympic = $this->getModel();
        if (!$olympic) {
            return $this->redirect('step2');
        }
        $searchModel = new PersonsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->pagination->pageSize = 8;

        $provider = new ActiveDataProvider(['query' => UserPersonsLiterature::find()->andWhere(['user_id' => $olympic->user_id])]);

        $model = new PersonsLiterature();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $agreeFile = UploadedFile::getInstanceByName("agree_file");
            $model->agree_file = $agreeFile;
            $model->save();
            $m = new UserPersonsLiterature();
            $m->user_id = $olympic->user_id;
            $m->persons_literature_id = $model->id;
            $m->save();
            return $this->redirect(Yii::$app->request->referrer);
        }

        return $this->render('step5', ['step' => 5,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model' => $model,
            'provider' => $provider,
            'userId' => $olympic->user_id,
        ]);
    }

    protected function serviceUserProfile(RegisterForm $registerForm) {
        $transaction = \Yii::$app->db->beginTransaction();
        try {
            if(!$registerForm->ifUser) {
                $formUser = new UserCreateForm();
                $formUser->username = $registerForm->user->username;
                $formUser->email = $registerForm->user->email;
                $formUser->password = $registerForm->user->password;
                $user = User::create($formUser);
                $user->generateAuthKey();
                $user->generateEmailVerificationToken();
                $user->save();
                $userId = $user->id;
                $profile = Profiles::create($registerForm->profile, $userId);
                $profile->setRole(ProfileHelper::ROLE_STUDENT);
                $profile->save();
                $configTemplate =  ['html' => 'emailVerify-html', 'text' => 'emailVerify-text'];
                $configData = ['user' => $user];
                $this->sendEmail($user, $configTemplate, $configData, "Подтверждение почты!");
            } else {
                $user = User::findOne($this->getUserId());
                $user->username = $registerForm->user->username;
                $user->email = $registerForm->user->email;
                $user->save();
                $profile = Profiles::findOne(['user_id' => $user->id]);
                $profile->edit($registerForm->profile);
                $profile->save();
            }
            $transaction->commit();
            return $user;
        } catch (\Exception $e) {
            $transaction->rollBack();
            throw $e;
        }
    }

    protected function getUserId() {
        return Yii::$app->user->identity->getId();
    }

    public function getModel() {
        $model = LiteratureOlympic::findOne(['user_id'=> $this->getUserId()]);
        return $model;
    }
}
