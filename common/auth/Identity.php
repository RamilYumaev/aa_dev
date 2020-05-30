<?php

namespace common\auth;

use common\auth\models\User;
use dictionary\models\DictCompetitiveGroup;
use dictionary\models\DictDiscipline;
use dictionary\models\DisciplineCompetitiveGroup;
use modules\dictionary\forms\JobEntrantForm;
use modules\dictionary\models\JobEntrant;
use modules\entrant\helpers\CseSubjectHelper;
use modules\entrant\models\Anketa;
use modules\entrant\models\PassportData;
use olympic\readRepositories\UserOlympicReadRepository;
use olympic\readRepositories\UserReadRepository;
use yii\web\IdentityInterface;

class Identity implements IdentityInterface
{
    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public static function findIdentity($id)
    {
        $user = self::getRepository()->find($id);
        return $user ? new self($user) : null;
    }

    public function getId(): int
    {
        return $this->user->id;
    }

    public function getAisToken(): ?string
    {
        return $this->user->ais_token;
    }


    public function isUser(): int
    {
        return $this->user->id;
    }

    public function isUserOlympic()
    {
        $userOlimpic = $this->getOlympicRepository()->isEduYear($this->user->id);
        return $userOlimpic;
    }

    public function anketa()
    {
        return Anketa::find()->userAnketa($this->getId())->one();
    }

    public function jobEntrant()
    {
        return JobEntrant::findOne(['user_id'=> $this->getId()]);
    }

    public function eighteenYearsOld(): bool
    {
        $passport = PassportData::find()
            ->andWhere(['user_id'=>$this->getId()])
            ->andWhere(['main_status'=>true])
            ->one();

        if(!$passport){
            throw new \DomainException("Для выполнения данного действия необходимо ввести документ, 
            удостоверяющий личность");
        }

        return $passport->age() >= 18;
    }

    public function cseFilterCg(array $userSubjectArray): array
    {
        $cgArrayPriority1 = DisciplineCompetitiveGroup::find()
            ->select("competitive_group_id")
            ->andWhere(['in', 'discipline_id', $userSubjectArray])
            ->priorityOne()
            ->column();

        $cgArrayPriority2 = DisciplineCompetitiveGroup::find()
            ->select("competitive_group_id")
            ->andWhere(['in', 'discipline_id', $userSubjectArray])
            ->priorityTwo()
            ->column();

        $cgArrayPriority3 = DisciplineCompetitiveGroup::find()
            ->select("competitive_group_id")
            ->andWhere(['in', 'discipline_id', $userSubjectArray])
            ->priorityThree()
            ->column();


        $array1 = array_uintersect(array_values($cgArrayPriority3), array_values($cgArrayPriority2), "strcasecmp");

        return array_uintersect(array_values($cgArrayPriority1), $array1, "strcasecmp");

    }

    public function filtrationCgByCse()
    {
        $userId = $this->getId();
        $userArray = DictDiscipline::cseToDisciplineConverter(CseSubjectHelper::userSubjects($userId));
        $finalUserArrayCse = DictDiscipline::finalUserSubjectArray($userArray);
        $filteredCg = $this->cseFilterCg($finalUserArrayCse);
        return $filteredCg;
    }

    public function filtrationFacultyByCse()
    {
        $filteredCg = $this->filtrationCgByCse();
        return $this->cseFilterFaculty($filteredCg);
    }

    public function cseFilterFaculty($filteredCg)
    {
        $arrayModel = DictCompetitiveGroup::find()
            ->select("faculty_id")
            ->andWhere(['in', 'id', $filteredCg])
            ->currentAutoYear()
            ->column();

        return array_unique($arrayModel);
    }


    public function getUsername(): string
    {
        return $this->user->username;
    }

    public function getEmail()
    {
        return $this->user->email;
    }

    public function isActive()
    {
        return $this->user->status  == 10;
    }


    public function checkUserCredentials($username, $password): bool
    {
        if (!$user = self::getRepository()->findActiveByUsername($username)) {
            return false;
        }
        return $user->validatePassword($password);
    }

    public function getUserDetails($username): array
    {
        $user = self::getRepository()->findActiveByUsername($username);
        return ['user_id' => $user->id];
    }

    private static function getRepository(): UserReadRepository
    {
        return \Yii::$container->get(UserReadRepository::class);
    }

    private static function getOlympicRepository(): UserOlympicReadRepository
    {
        return \Yii::$container->get(UserOlympicReadRepository::class);
    }


    /**
     * Finds an identity by the given token.
     * @param mixed $token the token to be looked for
     * @param mixed $type the type of the token. The value of this parameter depends on the implementation.
     * For example, [[\yii\filters\auth\HttpBearerAuth]] will set this parameter to be `yii\filters\auth\HttpBearerAuth`.
     * @return IdentityInterface|null the identity object that matches the given token.
     * Null should be returned if such an identity cannot be found
     * or the identity is not in an active state (disabled, deleted, etc.)
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        // TODO: Implement findIdentityByAccessToken() method.
    }

    /**
     * Returns a key that can be used to check the validity of a given identity ID.
     *
     * The key should be unique for each individual user, and should be persistent
     * so that it can be used to check the validity of the user identity.
     *
     * The space of such keys should be big enough to defeat potential identity attacks.
     *
     * This is required if [[User::enableAutoLogin]] is enabled. The returned key will be stored on the
     * client side as a cookie and will be used to authenticate user even if PHP session has been expired.
     *
     * Make sure to invalidate earlier issued authKeys when you implement force user logout, password change and
     * other scenarios, that require forceful access revocation for old sessions.
     *
     * @return string a key that is used to check the validity of a given identity ID.
     * @see validateAuthKey()
     */
    public function getAuthKey()
    {
        // TODO: Implement getAuthKey() method.
    }

    /**
     * Validates the given auth key.
     *
     * This is required if [[User::enableAutoLogin]] is enabled.
     * @param string $authKey the given auth key
     * @return bool whether the given auth key is valid.
     * @see getAuthKey()
     */
    public function validateAuthKey($authKey)
    {
        // TODO: Implement validateAuthKey() method.
    }
}