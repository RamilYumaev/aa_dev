<?php

use backend\widgets\adminlte\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel dictionary\forms\search\DictSchoolsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $school_id integer */

?>
<div class="alert alert-success alert-dismissible fade in" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">×</span>
    </button>
    <strong></strong>
</div>
<div class="box">
    <div class="box-body">
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                ['class' => \yii\grid\SerialColumn::class],
                'name',
                ['class' => 'yii\grid\CheckboxColumn',
                    'multiple' => false,
                    'checkboxOptions' => function ($model, $key, $index, $column) use($school_id) {
                      return ['onchange' =>
                         '$.post("/dictionary/dict-schools/select-school?id='.$model->id.'&school_id='.$school_id.'", 
                         function(data) { if(data=="Добавлен!") {
                     $(".alert").attr("class", "alert alert-success alert-dismissible fade in");
                  }
                  else {
                     $(".alert").attr("class", "alert alert-warning alert-dismissible fade in");
                  }
                  $(".alert").fadeIn(); 
                  $("div.alert strong").html(data);
                   })'];}
                ],
            ]
        ]); ?>
    </div>
</div>
<?php
$script = <<< JS
jQuery('.alert').hide();
JS;
$this->registerJs($script, yii\web\View::POS_READY);
?>


