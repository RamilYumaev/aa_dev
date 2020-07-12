<?php

namespace modules\entrant\forms;

use modules\entrant\components\MaxDateValidate;
use modules\entrant\helpers\DateFormatHelper;
use modules\entrant\models\File;
use modules\entrant\models\ReceiptContract;
use yii\base\Model;
use yii\web\UploadedFile;

class ReceiptContractForm extends Model
{
    public $date, $bank, $pay_sum;

    public function __construct(ReceiptContract $receipt, $config = [])
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
            [['pay_sum'], 'number',  'min' => 1.0, 'max'=>1000000.0],
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