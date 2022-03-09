<?php
namespace modules\literature\controllers\api;

use common\auth\models\User;
use common\sending\traits\SelectionCommitteeMailTrait;
use dictionary\helpers\DictCountryHelper;
use dictionary\models\Region;
use modules\literature\forms\PhoneEmailForm;
use modules\literature\models\LiteratureOlympic;
use modules\literature\models\PersonsLiterature;
use modules\literature\models\UserPersonsLiterature;
use olympic\forms\auth\ProfileCreateForm;
use olympic\forms\auth\UserCreateForm;
use olympic\helpers\auth\ProfileHelper;
use olympic\models\auth\Profiles;
use Yii;
use yii\data\ActiveDataProvider;
use yii\helpers\Json;
use yii\rest\Controller;
use yii\web\UploadedFile;
use function GuzzleHttp\Promise\all;

class RegisterController extends Controller
{
    use SelectionCommitteeMailTrait;

    public $enableCsrfValidation = false;

    public function actions()
    {
        return [
            'options' => [
                'class' => 'yii\rest\OptionsAction',
            ],
        ];
    }

    public static function allowedDomains() {
        return [
            '*',
            'https://api.sdotest.mpgu.org/*',
        ];
    }


    public function behaviors()
    {
        $behaviors = parent::behaviors();

        unset($behaviors['authenticator']);

        // add CORS filter
        $behaviors['corsFilter'] = [
            'class' => \yii\filters\Cors::class,
            'cors' => [
                // restrict access to
                'Origin' => self::allowedDomains(),
                // Allow only POST and PUT methods
                'Access-Control-Request-Method' => ['GET', 'PUT'],
                'Access-Control-Request-Headers' => ['*'],
                'Access-Control-Allow-Credentials' => null,
                'Access-Control-Max-Age' => 86400,
            ],
        ];
        return $behaviors;
    }

    /**
     * @return array
     * @throws \yii\db\Exception
     * @throws \Exception
     */
    public function actionIndex()
    {
        $json = $this->getJson();
        $data = Json::decode($json);

        $transaction = \Yii::$app->db->beginTransaction();
        try {
            $formUser = new UserCreateForm();
            $formUser->username = $data['user']['email'];
            $formUser->email = $data['user']['email'];
            $formUser->password = $data['user']['password'];

            if (!$formUser->validate()) {

                $error = Json::encode($formUser->errors);
                return ['error_message' => $error];
            }

            $user = User::create($formUser);
            $user->generateAuthKey();
            $user->generateEmailVerificationToken();
            $user->save();

            $formProfile = new ProfileCreateForm();
            $formProfile->last_name = $data['user']['surname'];
            $formProfile->first_name = $data['user']['name'];
            $formProfile->patronymic = $data['user']['patronymic'];
            $formProfile->gender = $data['user']['sex'];
            $formProfile->phone = $data['user']['phone'];
            $formProfile->country_id = DictCountryHelper::RUSSIA;
            $formProfile->region_id = $data['address']['region'];

            if (!$formProfile->validate()) {
                $error = Json::encode($formProfile->errors);
                return ['error_message' => $error];
            }

            $profile = Profiles::create($formProfile, $user->id);
            $profile->setRole(ProfileHelper::ROLE_STUDENT);
            $profile->save();

            $olympic = new LiteratureOlympic();
            $olympic->user_id = $user->id;
            $olympic->birthday = $data['user']['birthday'];
            $olympic->type = $data['document']['type'];
            $olympic->series = $data['document']['series'];
            $olympic->number = $data['document']['number'];
            $olympic->date_issue = $data['document']['date_issue'];
            $olympic->authority = $data['document']['authority'];
            $olympic->region =  $data['address']['region'];
            $olympic->zone =  $data['address']['zone'];
            $olympic->city =  $data['address']['city'];

            $olympic->full_name = $data['school']['full_name'];
            $olympic->short_name = $data['school']['short_name'];
            $olympic->status_olympic = $data['school']['status_olympic'];
            $olympic->mark_olympic = $data['school']['mark_olympic'];
            $olympic->grade_number = $data['school']['grade_number'];
            $olympic->grade_letter = $data['school']['grade_letter'];
            $olympic->grade_performs = $data['school']['grade_performs'];
            $olympic->fio_teacher = $data['school']['fio_teacher'];
            $olympic->place_work = $data['school']['place_work'];
            $olympic->post = $data['school']['post'];
            $olympic->academic_degree = $data['school']['academic_degree'];
            $olympic->size = $data['additional']['size'];
            $olympic->is_allergy = $data['additional']['is_allergy'];
            $olympic->note_allergy = $data['additional']['note_allergy'];
            $olympic->is_voz = $data['additional']['is_voz'];
            $olympic->is_need_conditions = $data['additional']['is_need_conditions'];
            $olympic->note_conditions = $data['additional']['note_conditions'];
            $olympic->note_special = $data['additional']['note_special'];
            $olympic->date_arrival = $data['route']['date_arrival'];
            $olympic->type_transport_arrival = $data['route']['type_transport_arrival'];
            $olympic->place_arrival = $data['route']['place_arrival'];
            $olympic->number_arrival = $data['route']['number_arrival'];
            $olympic->date_departure = $data['route']['date_departure'];
            $olympic->type_transport_departure = $data['route']['type_transport_departure'];
            $olympic->place_departure = $data['route']['place_departure'];
            $olympic->number_departure= $data['route']['number_departure'];
            $olympic->hash = Yii::$app->security->generateRandomString();

            if (!$olympic->save()) {
                $error = Json::encode($olympic->errors);
                return ['error_message' => $error];
            }

            if ($data['accompanying_persons']['list']) {
                foreach ($data['accompanying_persons']['list'] as $list) {
                    $model = new UserPersonsLiterature();
                    $model->user_id = $user->id;
                    $model->persons_literature_id = $list;
                    if (!$model->save()) {
                        $error = Json::encode($model->errors);
                        return ['error_message' => $error];
                    }
                }
            }
            $transaction->commit();
            $configTemplate =  ['html' => 'api/emailVerify-html', 'text' => 'api/emailVerify-text'];
            $configData = ['user' => $user];
            $this->sendEmail($user, $configTemplate, $configData, "Подтверждение почты!");
            return ['success_message' => 'Успешно отправлено! Потвердите почту.', 'hash' => $olympic->hash];
        } catch (\Exception $e) {
            $transaction->rollBack();
            throw $e;
        }
    }

    /**
     * @return array
     * @throws \yii\base\InvalidConfigException
     */
    public function actionAddPerson()
    {
        $agreeFile = UploadedFile::getInstanceByName("agree_file");
        if (empty($agreeFile)){
            return ['error_message' => "Не загружен файл обработки персональных данных"];
        }
        $model = new PersonsLiterature();
        $model->load(Yii::$app->request->getBodyParams(),'');
        $model->agree_file = $agreeFile;
        if (!$model->save()) {
            $error = Json::encode($model->errors);
            return ['error_message' => $error];
        }
        return ['success_message' => 'Успешно добалено'];
    }

    /**
     * @return array
     * @throws \yii\base\InvalidConfigException
     */

    public function actionPersons() {
        $query = PersonsLiterature::find()->select(['id','fio', 'post']);
        $data = Yii::$app->request->getBodyParams();
        if(key_exists('fio', $data)) {
            $query->andFilterWhere(['like', 'fio', $data['fio']]);
        }
        if(key_exists('phone', $data)) {
            $query->andFilterWhere(['like', 'phone', $data['phone']]);
        }

        if(key_exists('email', $data)) {
            $query->andFilterWhere(['like', 'email', $data['email']]);
        }

        $provider = new ActiveDataProvider([
            'query' => $query
        ]);

        if(key_exists('page', $data)) {
             $provider->pagination->page = $data['page'] - 1;
        }

        return ["totalCount" => $provider->totalCount, 'data' =>$provider];
    }

    public function actionSendFile($hash)
    {
        $model = LiteratureOlympic::findOne(['hash' => $hash]);
        if(!$model) {
            return ['error_message' => "Запись не найдена"];
        }

        $photo = UploadedFile::getInstanceByName("photo");
        if (empty($photo)){
            return ['error_message' => "Не загружен файл фото"];
        }

        $agreeFile = UploadedFile::getInstanceByName("agree_file");
        if (empty($agreeFile)){
            return ['error_message' => "Не загружен файл обработки персональных данных"];
        }

        $model->photo = $photo;
        $model->agree_file = $agreeFile;
        $model->save();

        return ['success_message' => 'Успешно добалены файлы'];
    }

    public function actionRegions() {
        return Region::find()->select(['name','id'])->indexBy('id')->column();
    }

    public function actionExistsEmail() {
        $model = new PhoneEmailForm();
        $model->setScenario(PhoneEmailForm::EMAIL);
        $model->load(Yii::$app->request->getBodyParams(),'');
        if (!$model->validate()) {
            $error = Json::encode($model->errors);
            return ['error_message' => $error];
        }
        return ['success_message' => 'Ok'];
    }

    public function actionExistsPhone() {
        $model = new PhoneEmailForm();
        $model->setScenario(PhoneEmailForm::PHONE);
        $model->load(Yii::$app->request->getBodyParams(),'');
        if (!$model->validate()) {
            $error = Json::encode($model->errors);
            return ['error_message' => $error];
        }
        return ['success_message' => 'Ok'];
    }

    public function verbs()
    {
        return [
            'index' => ["POST"],
            'regions' => ["GET"],
            'exists-email' => ["POST"],
            'exists-phone' => ["POST"],
            'add-person' => ["POST"],
            'send-file' => ["POST"],
            'persons' => ["GET"],
        ];
    }

    private function getJson()
    {
        try {
            $json = file_get_contents('php://input');
        } catch (\Exception $e) {
            \Yii::error($e->getMessage());
            return ['message' => $e->getMessage()];
        }
        return $json;
    }
}
