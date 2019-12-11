<?php
namespace common\sending\traits;

use common\sending\models\DictSendingUserCategory;

trait DictSendingUserCategoryTrait
{
    public $name;

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return DictSendingUserCategory::labels();
    }


}