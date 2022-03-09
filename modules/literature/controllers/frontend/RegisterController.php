<?php
namespace modules\literature\controllers\frontend;

use common\auth\models\User;
use common\helpers\FlashMessages;
use common\sending\traits\SelectionCommitteeMailTrait;
use modules\entrant\helpers\DateFormatHelper;
use modules\literature\forms\RegisterGuestForm;
use modules\literature\forms\SignupForm;
use modules\literature\models\LiteratureOlympic;
use modules\literature\models\PersonsLiterature;
use modules\literature\models\UserPersonsLiterature;
use Mpdf\Tag\Li;
use olympic\forms\auth\ProfileCreateForm;
use olympic\forms\auth\UserCreateForm;
use olympic\helpers\auth\ProfileHelper;
use olympic\models\auth\Profiles;
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
            if(LiteratureOlympic::findOne(['user_id'=> $userId])) {
                Yii::$app->session->setFlash('warning', "Вы уже зарегистрировались");
                return $this->redirect(['default/index']);
            }
            $model = new RegisterGuestForm(false);
            if (($model->load(Yii::$app->request->post()) && $model->validate())) {
                $this->service($model->olympic, $model->person, null, null, $userId);
                Yii::$app->session->setFlash('success', FlashMessages::get()["successRegistration"]);
                return $this->redirect(['default/index']);
            } else {
                return $this->render('index', [
                    'model' => $model,
                ]);
            }
        } else {
            $model = new RegisterGuestForm(true);
            if ($model->load(Yii::$app->request->post()) && $model->validate()) {
                $this->service($model->olympic, $model->person, $model->profile, $model->user, null);
                Yii::$app->session->setFlash('success', FlashMessages::get()["successRegistration"]);
                return $this->redirect(['default/index']);
            } else {
                return $this->render('index_guest', [
                    'model' => $model,
                ]);
            }
        }
    }

    public function actionSuccess()
    {
        return $this->render('success');
    }

    protected function service(LiteratureOlympic $model,
                               PersonsLiterature $personsLiterature,
                               ProfileCreateForm $profileCreateForm = null,
                               SignupForm $signupForm = null,
                               $userId = null) {
        $transaction = \Yii::$app->db->beginTransaction();
        try {
            $user = $userId;
            if($signupForm) {
                $formUser = new UserCreateForm();
                $formUser->username = $signupForm->email;
                $formUser->email = $signupForm->email;
                $formUser->password = $signupForm->password;

                $user = User::create($formUser);
                $user->generateAuthKey();
                $user->generateEmailVerificationToken();
                $user->save();
                $userId = $user->id;
            }
            if ($profileCreateForm) {
                $profileCreateForm->region_id = $model->region;
                $profile = Profiles::create($profileCreateForm, $userId);
                $profile->setRole(ProfileHelper::ROLE_STUDENT);
                $profile->save();
            }

            $personsLiterature->agree_file = UploadedFile::getInstance($personsLiterature, 'agree_file');
            $personsLiterature->date_issue = DateFormatHelper::formatRecord($personsLiterature->date_issue);
            $personsLiterature->save();

            $m = new UserPersonsLiterature();
            $m->user_id = $userId;
            $m->persons_literature_id = $personsLiterature->id;
            $m->save();

            $photo = UploadedFile::getInstance($model, "photo");

            $agreeFile = UploadedFile::getInstance($model, "agree_file");

            $model->photo = $photo;
            $model->agree_file = $agreeFile;
            $model->user_id = $userId;
            $model->birthday = DateFormatHelper::formatRecord($model->birthday);
            $model->date_issue = DateFormatHelper::formatRecord($model->date_issue);
            $model->save();

            $transaction->commit();
            if($profileCreateForm) {
                $configTemplate =  ['html' => 'emailVerify-html', 'text' => 'emailVerify-text'];
                $configData = ['user' => $user];
                $this->sendEmail($user, $configTemplate, $configData, "Подтверждение почты!");
            }
            return $userId;
        } catch (\Exception $e) {
            $transaction->rollBack();
            throw $e;
        }
    }
}
