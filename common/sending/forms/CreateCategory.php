<?php

namespace common\sending\forms;

use yii\base\Model;
use Yii;

class CreateCategory extends Model
{
    public $categoryName;
    public $userId;

    const OLIMPIC = 1;
    const DOD = 2;
    const US = 3;

    public function save($type, $value, $theme, $templateId)
    {
        $tempType = DictSendingTemplate::find()->andWhere(['id' => $templateId])->one();


        $transaction = Yii::$app->db->beginTransaction();
        try {
            $categoRyModel = new DictSendingUserCategory();
            $categoRyModel->name = $this->categoryName;
            if (!$categoRyModel->save()) {
                throw new \Exception('Ошибка в коде не удалось создать категорию. ' .
                    print_r($categoRyModel->errors, true));
            }


            if ($type == self::OLIMPIC) {

                $allTest = Test::find()->select('id')->andWhere(['olimpic_id' => $value])->column();
                $olimpic = Olimpic::find()->andWhere(['id' => $value])->one();

                switch ($olimpic->form_of_passage) {

                    case Olimpic::OCHNO_ZAOCHNAYA_FORMA :
                        if ($tempType->base_type == Sending::USER_SEND_FOR_PERSONAL_TOUR_MEMBER) {
                            $userCategory = Profiles::find()
                                ->joinWith('user')
                                ->joinWith('testAttempt')
                                ->andWhere(['in', 'test_id', $allTest])
                                ->andWhere(['status_id' => TestAttempt::MEMBER])
                                ->all();
                        } elseif
                        ($tempType->base_type == Sending::USER_SEND_FOR_WINNER) {
                            $userCategory = PersonalPresenceAttempt::find()
                                ->andWhere(['olimpic_id' => $value])
                                ->andWhere(['is not', 'reward_status', null])
                                ->all();
                        }
                        break;

                    case Olimpic::OCHNAYA_FORMA :
                        if ($tempType->base_type == Sending::USER_SEND_FOR_PERSONAL_TOUR_MEMBER) {
                            $userCategory = UserOlimpiads::find()->andWhere(['olimpic_id' => $value])->all();
                        } elseif ($tempType->base_type == Sending::USER_SEND_FOR_WINNER) {
                            $userCategory = PersonalPresenceAttempt::find()
                                ->andWhere(['olimpic_id' => $value])
                                ->andWhere(['is not', 'reward_status', null])
                                ->all();
                        }
                }


                foreach ($userCategory as $user) {


                    $modelUserCategory = new SendingUserCategory();
                    $modelUserCategory->category_id = $categoRyModel->id;
                    $modelUserCategory->user_id = $user->user_id;
                    if (!$modelUserCategory->save()) {
                        throw new \Exception('Ошибка в коде не удалось создать запись соответствия пользоватея с категорией. ' .
                            print_r($modelUserCategory->errors, true));


                    }

                    if ($olimpic->form_of_passage !== Olimpic::ZAOCHNAYA_FORMA && !Invitation::find()
                            ->andWhere(['user_id' => $user->user_id])
                            ->andWhere(['olimpic_id' => $value])->exists()) {
                        $invite = new Invitation();
                        $invite->user_id = $user->user_id;
                        $invite->olimpic_id = $value;

                        if (!$invite->save()) {
                            throw new \Exception('Ошибка при создании приглашения. ' . print_r($invite->errors, true));
                        }

                    }
                }


            }

            $newSendingTask = new Sending();
            $newSendingTask->name = $theme;
            $newSendingTask->sending_category_id = $categoRyModel->id;
            $newSendingTask->template_id = $templateId;
            $newSendingTask->user_id = Yii::$app->user->id;
            $newSendingTask->status_id = Sending::WEITING_MODERATION;
            $newSendingTask->deadline = \date('Y-m-d H:i:s', time() + 3600 * 24);
            $newSendingTask->type_id = $type;
            $newSendingTask->value = $value;
            if (!$newSendingTask->save()) {
                throw new \Exception('Ошибка при создании рассылки. ' . print_r($newSendingTask->errors, true));
            }

        } catch (\Exception $e) {
            $transaction->rollBack();
            throw $e;
        }
        $transaction->commit();
        return true;

    }


}