<?php


namespace dictionary\forms;


use dictionary\models\DictChairmans;
use yii\base\Model;
use yii\web\UploadedFile;

class DictChairmansCreateForm extends Model
{
    public $last_name, $first_name, $patronymic, $position, $photo;

    /**
     * {@inheritdoc}
     */
    public function __construct($config = [])
    {
        parent::__construct($config);
    }


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['last_name', 'first_name', 'patronymic', 'position'], 'required'],
            [['first_name', 'patronymic', 'last_name', 'position'], 'string', 'max' => 255],
            ['last_name', 'unique', 'targetClass' => DictChairmans::class, 'targetAttribute' => ['last_name', 'first_name', 'patronymic', 'position']],
            ['photo', 'file', 'extensions' => 'png', 'maxSize' => 10 * 1024 * 1024],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return DictChairmans::labels();
    }

    public function beforeValidate(): bool
    {
        if (parent::beforeValidate()) {
            $this->photo = UploadedFile::getInstance($this, 'photo');
            return true;
        }
        return false;
    }

}