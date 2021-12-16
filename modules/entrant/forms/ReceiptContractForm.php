<?php

namespace modules\entrant\forms;

use modules\entrant\components\MaxDateValidate;
use modules\entrant\helpers\DateFormatHelper;
use modules\entrant\models\File;
use modules\entrant\models\ReceiptContract;
use yii\base\Model;
use yii\db\BaseActiveRecord;
use yii\web\UploadedFile;

class ReceiptContractForm extends Model
{
    public $date, $bank, $pay_sum;

    public function __construct(BaseActiveRecord $receipt, $config = [])
    {
        $this->setAttributes($receipt->getAttributes(), false);
        $this->date = DateFormatHelper::formatView($receipt->date);
        parent::__construct($config);
    }

    /**
     * {@inheritdoc}
     */

    public function rules()
    {
        return [
            [['date'], MaxDateValidate::class],
            [['date'], 'date', 'format' => 'd.m.Y'],
            [['bank'], 'string', 'max'=>255],
            [['pay_sum'], 'number',  'min' => 1000.00,  'max' => 10000000.00,'numberPattern' => '/^[0-9]{1,12}(\.[0-9]{0,2})?$/',],
            [['date', 'bank', 'pay_sum'], 'required'],
        ];
    }

    /**
     * {@inheritdoc}
     */

    public function attributeLabels()
    {
       return [ 'bank' => 'Наименование отделения банка',
           'pay_sum' => "Сумма платежа",
           'date' => "Дата платежа"];
    }
}