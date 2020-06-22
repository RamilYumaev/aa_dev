<?php
/**
 * @author akiraz@bk.ru
 * @link https://github.com/akiraz2/yii2-ticket-support
 * @copyright 2018 akiraz2
 * @license MIT
 */

namespace modules\support\jobs;

use modules\support\Mailer;
use modules\support\models\Ticket;
use modules\support\traits\ModuleTrait;
use yii\base\BaseObject;

class FetchMailJob extends BaseObject implements \yii\queue\JobInterface
{
    use ModuleTrait;

    public function execute($queue)
    {
        $this->getModule()->fetchMail();
    }
}