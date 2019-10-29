<?php


namespace dictionary\forms;


use dictionary\models\DictChairmans;
use yii\base\Model;

class DictChairmansCreateForm extends Model
{
    public $last_name, $first_name, $patronymic, $position, $fileSignature;

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
            ['fileSignature', 'file', 'extensions' => 'png', 'maxSize' => 10 * 1024 * 1024],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return DictChairmans::labels();
    }

}