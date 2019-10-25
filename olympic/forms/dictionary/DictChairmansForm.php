<?php


namespace olympic\forms\dictionary;


use olympic\models\dictionary\DictChairmans;
use yii\base\Model;

class DictChairmansForm extends Model
{
    public $last_name, $first_name, $patronymic, $position, $fileSignature;

    /**
     * {@inheritdoc}
     */
    public function __construct(DictChairmans $dictChairmans = null, $config = [])
    {
        if ($dictChairmans) {
            $this->last_name = $dictChairmans->last_name;
            $this->first_name = $dictChairmans->first_name;
            $this->patronymic = $dictChairmans->patronymic;
            $this->position = $dictChairmans->position;
        }
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