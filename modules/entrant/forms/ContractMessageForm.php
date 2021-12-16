<?php
namespace modules\entrant\forms;

use modules\entrant\models\StatementAgreementContractCg;
use modules\entrant\models\StatementIa;
use yii\base\Model;
use yii\db\BaseActiveRecord;

class ContractMessageForm extends Model
{

    public $message;

    public function __construct(BaseActiveRecord $file, $config = [])
    {
        $this->setAttributes($file->getAttributes(), false);
        parent::__construct($config);
    }

    /**
     * {@inheritdoc}
     */

    public function rules()
    {
        return [
            ['message', 'string', 'max'=>255],
            ['message', 'required'],
        ];
    }

    /**
     * {@inheritdoc}
     */

    public function attributeLabels()
    {
        return [ 'message'=> 'Сообщение'];
    }

}