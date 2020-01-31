<?php
/* @var $this yii\web\View */
/* @var $model olympic\forms\auth\SchooLUserCreateForm */
use olympic\helpers\auth\ProfileHelper;
\common\user\assets\UpdateSchoolAsset::register($this);
?>
<?php if ($model->schoolUser->role == ProfileHelper::ROLE_STUDENT) :?>
    <?php $this->title = "Учебные организации. Редактирование." ?>
    <?= $this->render('_frontend', ['model'=> $model])?>
<?php else:?>
    <?php $this->title = "Данные об работодателе. Редактирование." ?>
    <?= $this->render('_teacher', ['model'=> $model])?>
<?php endif;?>
