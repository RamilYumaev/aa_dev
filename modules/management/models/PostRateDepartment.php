<?php

namespace modules\management\models;

use modules\management\forms\PostRateDepartmentForm;
use modules\management\models\queries\PostRateDepartmentQuery;
use modules\management\models\queries\ScheduleQuery;
use olympic\models\auth\Profiles;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%post_rate_department}}".
 *
 * @property integer $id
 * @property integer $dict_department_id
 * @property integer $post_management_id
 * @property integer $rate
 **/

class PostRateDepartment extends ActiveRecord
{
    const FULL_RATE_HALF_RATE = 60;
    const FULL_RATE_QUARTER_RATE = 50;
    const FULL_RATE = 39;
    const HALF_QUARTER_RATE = 30;
    const HALF_RATE = 20;
    const QUARTER_RATE = 10;
    const LUNCH_TIME = 2700;

    public static function tableName()
    {
        return '{{%post_rate_department}}';
    }

    public static function create(PostRateDepartmentForm $form)
    {
        $model = new static();
        $model->data($form);
        return $model;
    }

    public function data(PostRateDepartmentForm $form)
    {
        $this->rate = $form->rate;
        $this->dict_department_id = $form->dict_department_id;
        $this->post_management_id = $form->post_management_id;
    }

    public function getRateList() {
        return [
            self::FULL_RATE_HALF_RATE => '1,5 ставки',
            self::FULL_RATE_QUARTER_RATE => '1,25 ставки',
            self::FULL_RATE => 'Полная ставка',
            self::HALF_QUARTER_RATE => '0,75 ставки',
            self::HALF_RATE => '0,5 ставки',
            self::QUARTER_RATE => '0,25 ставки',
        ];
    }

    public function getRateName () {
        return $this->getRateList()[$this->rate];
    }

    public function getPostManagement() {
        return $this->hasOne(PostManagement::class, ['id' => 'post_management_id']);
    }

    public function getManagementUser() {
        return $this->hasMany(ManagementUser::class, ['post_rate_id' => 'id']);
    }

    public function getManagementTask() {
        return $this->hasMany(ManagementTask::class, ['post_rate_id' => 'id']);
    }

    public function getDictDepartment() {
        return $this->hasOne(DictDepartment::class, ['id' => 'dict_department_id']);
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ИД',
            'rate' => 'Рабочая ставка',
            'dict_department_id' => 'Отдел',
            'post_management_id' => "Должность",
        ];
    }

    public static function find(): PostRateDepartmentQuery
    {
        return new PostRateDepartmentQuery(static::class);
    }

    public function getManagementTasks() {
        return $this->hasMany(ManagementTask::class, ['post_rate_id' => 'id']);
    }
}