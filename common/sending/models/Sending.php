<?php

namespace common\sending\models;

use common\sending\forms\SendingCreateForm;
use common\sending\forms\SendingEditForm;
use common\sending\models\queries\SendingQuery;
use Yii;

/**
 * This is the model class for table "sending".
 *
 * @property int $id
 * @property string $name
 * @property int $sending_category_id
 * @property int $template_id
 * @property int $status_id 0- не начиналась, 1- одобрена, 2- завершилась
 *
 * @property DictSendingTemplate $sendingCategory
 * @property DictSendingTemplate $template
 * @property SendingDeliveryStatus[] $sendingDeliveryStatuses
 */
class Sending extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return 'sending';
    }

    public static function create(SendingCreateForm $form) {
        $sending = new static();
        $sending->name = $form->name;
        $sending->status_id = $form->status_id;
        $sending->value = $form->value;
        $sending->sending_category_id = $form->sending_category_id;
        $sending->type_id = $form->type_id;
        $sending->user_id = $form->user_id;
        $sending->template_id = $form->template_id;
        $sending->poll_id = $form->poll_id;
        $sending->deadline = $form->deadline;
        $sending->kind_sending_id = $form->kind_sending_id;
        return $sending;
    }

    public function edit(SendingEditForm $form) {

        $this->name = $form->name;
        $this->status_id = $form->status_id;
        $this->value = $form->value;
        $this->sending_category_id = $form->sending_category_id;
        $this->type_id = $form->type_id;
        $this->user_id = $form->user_id;
        $this->template_id = $form->template_id;
        $this->poll_id = $form->poll_id;
        $this->deadline = $form->deadline;
        $this->kind_sending_id = $form->kind_sending_id;
    }
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Тема письма',
            'sending_category_id' => 'Категория пользователей',
            'template_id' => 'Шаблон письма',
            'status_id' => 'Статус рассылки',
            'deadline' => 'Директивный срок (дедлайн)',
        ];
    }

    public static function labels() {
        $sending = new static();
        return $sending->attributeLabels();
    }

    public static function find(): SendingQuery
    {
        return new SendingQuery(static::class);
    }

    public static function getLetter($sendingId, $userId,$hash, $type = null, $olimpicId = null )
    {

        $model = Sending::find()->andWhere(['id' => $sendingId])->one();

        $templateId = DictSendingTemplate::find()->andWhere(['id' => $model->template_id])->one();

        $profile = Profiles::find()->andWhere(['user_id' => $userId])->one();

//        $deliveryStatus = SendingDeliveryStatus::find()
//            ->andWhere(['user_id' => $userId])
//            ->andWhere(['sending_id' => $sendingId])->one();

        if ($templateId->base_type == Sending::USER_SEND_FOR_PERSONAL_TOUR_MEMBER && $olimpicId) {
            $invite = Invitation::find()
                ->andWhere(['user_id' => $userId])
                ->andWhere(['olimpic_id' => $olimpicId])
                ->one();
        }

        if ($model->type_id == CreateCategory::OLIMPIC) {
            $event = Olimpic::find()
                ->andWhere(['id' => $model->value])
                ->one();

            $reward = Diploma::find()
                ->andWhere(['user_id' => $userId])
                ->andWhere(['olimpic_id' => $event->id])
                ->one();

            if ($reward->reward_status_id ?? null) {
                switch ($reward->reward_status_id) {
                    case PersonalPresenceAttempt::FIRST_PLACE :
                        $userReward = '1-е место';
                        break;
                    case PersonalPresenceAttempt::SECOND_PLACE :
                        $userReward = '2-е место';
                        break;
                    case PersonalPresenceAttempt::THIRD_PLACE :
                        $userReward = '3-е место';
                        break;
                }
            }


        } //@TODO дописать для остальных мероприятий

        $labels = [
            '{имя отчество получателя}',
            '{название олимпиады в родительном падеже}',
            '{дата и время очного тура олимпиады}',
            '{адрес проведения очного тура}',
            '{Ф.И.О. председателя олимпиады}',
            '{1-е место, 2-е место, 3-е место}',
            '{ссылка на диплом}',
            '{ссылка на приглашение}',
        ];


        $replaceLabels = [
            $profile->patronymic ? $profile->first_name . ' ' . $profile->patronymic
                : $profile->first_name, // {имя отчество получателя}

            $event->genitive_name, // {название олимпиады в родительном падеже}

            DateTimeToChpu::getDateChpu($event->date_time_start_tour) //{дата и время очного тура олимпиады}
            . ' в '
            . DateTimeToChpu::getTimeChpu($event->date_time_start_tour),

            $event->address, // {адрес проведения очного тура}

            $event->chairman->last_name
            . ' '
            . mb_substr($event->chairman->first_name, 0, 1, 'utf-8')
            . '.'
            . mb_substr($event->chairman->patronymic, 0, 1, 'utf-8') . '.', // {Ф.И.О. председателя олимпиады}

            isset($userReward) ? $userReward : '', // {1-е место, 2-е место, 3-е место}
            isset($reward->id) ? 'https://sdo.mpgu.org/diploma/' . $reward->id . '/' . $hash : '',  // {ссылка на диплом}
            isset($invite->id) ? 'https://sdo.mpgu.org/print/invitation/' . $invite->id . '/' . $hash : '', // {ссылка на приглашение}

        ];

        if ($type == self::TYPE_TEXT) {
            $emailBodyHtml = str_replace($labels, $replaceLabels, $model->template->text);

        } else {
            $emailBodyHtml = str_replace($labels, $replaceLabels, $model->template->html);

        }

        return $emailBodyHtml;
    }
}
