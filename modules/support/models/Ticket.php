<?php
/**
 * @author akiraz@bk.ru
 * @link https://github.com/akiraz2/yii2-ticket-support
 * @copyright 2018 akiraz2
 * @license MIT
 */

namespace modules\support\models;

use common\auth\models\User;
use modules\support\Mailer;
use modules\support\traits\ModuleTrait;
use Hashids\Hashids;
use PhpImap\IncomingMail;
use Yii;

/**
 * This is the model class for Ticket.
 *
 * @property integer|\MongoDB\BSON\ObjectID|string $id
 * @property integer|\MongoDB\BSON\ObjectID|string $category_id
 * @property string $user_contact
 * @property string $user_name
 * @property string $title
 * @property string $hash_id
 * @property integer $status
 * @property integer $type_id
 * @property integer $priority
 * @property integer|\MongoDB\BSON\ObjectID|string $user_id
 * @property integer|\MongoDB\BSON\UTCDateTime $created_at
 * @property integer|\MongoDB\BSON\UTCDateTime $updated_at
 *
 * @property Content[] $contents
 * @property Category $category
 * @property User $user
 */
class Ticket extends TicketBase
{
    use ModuleTrait;

    const TYPE_SITE = 0;
    const TYPE_EMAIL = 10;
    const TYPE_TELEGRAM = 20;

    const PRIORITY_LOW = 0;
    const PRIORITY_MIDDLE = 10;
    const PRIORITY_HIGH = 20;

    const STATUS_OPEN = 0;
    const STATUS_WAITING = 10;
    const STATUS_CLOSED = 100;

    public $content;
    public $info;
    public $mail_id;
    public $fetch_date;

    /**
     * @return array
     */
    public function fields()
    {
        return [
            'hash_id',
            'category',
            'Type',
            'title',
            'status',
            'priority',
            'created_at' => function ($model) {
                return date("d.m.y H:i:s", $model->created_at);//$date->format('Y-m-d H:i:s');
            }
        ];
    }

    /**
     * get status text
     * @return string
     */
    public function getStatusText()
    {
        $status = $this->status;
        $list = self::getStatusOption();
        if (!is_null($status) && in_array($status, array_keys($list))) {
            return $list[$status];
        }
        return \modules\support\ModuleFrontend::t('support', 'Unknown');
    }

    /**
     * get status list
     * @param null $e
     * @return array
     */
    public static function getStatusOption($e = null)
    {
        $option = [
            self::STATUS_OPEN => \modules\support\ModuleFrontend::t('support', 'Open'),
            self::STATUS_WAITING => \modules\support\ModuleFrontend::t('support', 'Waiting'),
            self::STATUS_CLOSED => \modules\support\ModuleFrontend::t('support', 'Closed'),
        ];
        if (is_array($e)) {
            foreach ($e as $i) {
                unset($option[$i]);
            }
        }
        return $option;
    }

    /**
     * get status text
     * @return string
     */
    public function getStatusColorText()
    {
        $status = $this->status;
        $list = self::getStatusOption();

        switch ($status) {
            case self::STATUS_CLOSED:
                $color = 'danger';
                break;
            case self::STATUS_OPEN:
                $color = 'primary';
                break;
            case self::STATUS_WAITING:
                $color = 'warning';
                break;
            default:
                $color = 'default';
        }

        if (!is_null($status) && in_array($status, array_keys($list))) {
            return '<span class="label label-' . $color . '">' . $list[$status] . '</span>';
        }

        return '<span class="label label-' . $color . '">' . \modules\support\ModuleFrontend::t('support',
                'Unknown') . '</span>';
    }

    public static function getTypeList()
    {
        return [
            self::TYPE_SITE => \modules\support\ModuleFrontend::t('support', 'Site'),
            self::TYPE_EMAIL => \modules\support\ModuleFrontend::t('support', 'Email'),
            self::TYPE_TELEGRAM => \modules\support\ModuleFrontend::t('support', 'Telegram'),
        ];
    }

    public function getType()
    {
        return self::getTypeList()[$this->type_id];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['status'], 'default', 'value' => self::STATUS_OPEN],
            [['priority'], 'default', 'value' => self::PRIORITY_MIDDLE],
            [['type_id'], 'default', 'value' => self::TYPE_SITE],

            [['title',], 'required'],
            [['title'], 'string', 'max' => 255],

            [['status', 'priority'], 'number'],

            [
                ['category_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => Category::className(),
                'targetAttribute' => ['category_id' => Yii::$app->getModule('support')->isMongoDb() ? '_id' : 'id']
            ],
            [
                ['user_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => $this->getModule()->userModel,
                'targetAttribute' => ['user_id' => $this->getModule()->userPK]
            ],

            /* custom */
            [['content'], 'required', 'on' => ['create']],
            [['user_contact', 'user_name'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => \modules\support\ModuleFrontend::t('support', 'ID'),
            'category_id' => \modules\support\ModuleFrontend::t('support', 'Category'),
            'title' => \modules\support\ModuleFrontend::t('support', 'Title'),
            'content' => \modules\support\ModuleFrontend::t('support', 'Content'),
            'status' => \modules\support\ModuleFrontend::t('support', 'Status'),
            'user_id' => \modules\support\ModuleFrontend::t('support', 'Created By'),
            'created_at' => \modules\support\ModuleFrontend::t('support', 'Created At'),
            'updated_at' => \modules\support\ModuleFrontend::t('support', 'Updated At'),
        ];
    }

    /**
     * @return \yii\db\ActiveQueryInterface
     */
    public function getContents()
    {
        if (is_a($this, '\yii\mongodb\ActiveRecord')) {
            return $this->hasMany(Content::className(), ['id_ticket' => '_id']);
        } else {
            return $this->hasMany(Content::className(), ['id_ticket' => 'id']);
        }
    }

    /**
     * @return \yii\db\ActiveQueryInterface
     */
    public function getCategory()
    {
        if (is_a($this, '\yii\mongodb\ActiveRecord')) {
            return $this->hasOne(Category::className(), ['_id' => 'category_id']);
        } else {
            return $this->hasOne(Category::className(), ['id' => 'category_id']);
        }
    }

    /**
     * @return \yii\db\ActiveQueryInterface
     */
    public function getUser()
    {
        return $this->hasOne($this->getModule()->userModel, [$this->getModule()->userPK => 'user_id']);
    }

    /**
     * @inheritdoc
     * @param bool $insert
     * @return bool
     */
    public function beforeSave($insert)
    {
        if ($insert) {
            $this->hash_id = uniqid();
            if ($this->type_id == self::TYPE_SITE) {
                $this->user_id = Yii::$app->user->id;
                $this->user_name = Yii::$app->user->identity->getUsername();
                $this->user_contact = Yii::$app->user->identity->getEmail();
            }
            if ($this->type_id == self::TYPE_EMAIL) {
                if (($userModel = User::findOne(['email'=> $this->user_contact])) !== null) {
                    $this->user_id = $userModel->id;
                }
            }
        }
        return parent::beforeSave($insert);
    }

    /**
     * @inheritdoc
     * @param bool $insert
     * @param array $changedAttributes
     */
    public function afterSave($insert, $changedAttributes)
    {
        if ($insert) {
            if( is_callable($this->getModule()->hashGenerator))
            {
                $hash_id = call_user_func($this->getModule()->hashGenerator, $this);
            }
            else{
                $hash_ids = new Hashids(Yii::$app->name, 10);
                $hash_id = $hash_ids->encode($this->id); //
            }
            $this->updateAttributes(['hash_id' => $hash_id]);

            $ticketContent = new Content();
            $ticketContent->id_ticket = $this->id;
            $ticketContent->content = $this->content;
            $ticketContent->info = $this->info;
            $ticketContent->user_id = $this->user_id;
            $ticketContent->mail_id = $this->mail_id;
            $ticketContent->fetch_date = $this->fetch_date;
            if ($ticketContent->save()) {
                // notify support by email, has deleted
            }
        }
        parent::afterSave($insert, $changedAttributes); // TODO: Change the autogenerated stub
    }

    /**
     * get ticket url
     * @param bool $absolute
     * @return
     * @throws \yii\base\InvalidConfigException
     */
    public function getUrl($absolute = false)
    {
        $act = 'createUrl';
        if ($absolute) {
            $act = 'createAbsoluteUrl';
        }
        return \Yii::$app->get($this->getModule()->urlManagerFrontend)->$act([
            'support/ticket/view',
            'id' => (string)$this->hash_id
        ]);
    }

    /**
     * system closes ticket
     */
    public function close()
    {
        if ($this->status != Ticket::STATUS_CLOSED) {
            $post = new Content();
            $post->id_ticket = $this->id;
            $post->user_id = null;
            $post->content = \modules\support\ModuleFrontend::t('support',/**/
                'Ticket was closed automatically due to inactivity.');
            if ($post->save()) {
                $this->status = Ticket::STATUS_CLOSED;
                $this->save();
            }
        }
    }

    /**
     * @inheritdoc
     * @return bool
     */
    public function beforeDelete()
    {
        foreach ($this->contents as $content) {
            $content->delete();
        }
        return parent::beforeDelete(); // TODO: Change the autogenerated stub
    }

    protected function getMailer()
    {
        return \Yii::$container->get(Mailer::className());
    }

    public function loadFromEmail(IncomingMail $mail)
    {
        $this->type_id = self::TYPE_EMAIL;
        $this->title = $mail->subject;
        $this->user_name = $mail->fromName;
        $this->user_contact = $mail->fromAddress;
        $this->content = $mail->textHtml ?? $mail->textPlain;
        $this->info = ($mail->headersRaw);
        $this->mail_id = $mail->id;
        $this->fetch_date = $mail->date;
    }

    public function getNameEmail()
    {
        return $this->user_name . ' (' . $this->user_contact . ')';
    }

    public function isEmail()
    {
        return $this->type_id == self::TYPE_EMAIL;
    }
}
