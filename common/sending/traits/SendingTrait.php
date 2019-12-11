<?php


namespace common\sending\traits;


use common\sending\helpers\DictSendingTemplateHelper;
use common\sending\helpers\DictSendingUserCategoryHelper;
use common\sending\models\Sending;

trait SendingTrait
{
    public $name, $sending_category_id, $template_id, $status_id,
        $deadline, $kind_sending_id, $poll_id, $user_id, $type_id, $value;

    public function attributeLabels()
    {
        return Sending::labels();
    }

    public function sendingUserCategoryList()
    {
        return DictSendingUserCategoryHelper::categoryList();
    }

    public function sendingTemplateList()
    {
        return DictSendingTemplateHelper::templateList();
    }



}