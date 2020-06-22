<?php
/**
 * @author akiraz@bk.ru
 * @link https://github.com/akiraz2/yii2-ticket-support
 * @copyright 2018 akiraz2
 * @license MIT
 */

namespace modules\support\traits;

use modules\support\ModuleFrontend;

trait ModuleTrait
{
    /**
     * @return ModuleFrontend
     */
    public function getModule()
    {
        return \Yii::$app->getModule('support');
    }
}
