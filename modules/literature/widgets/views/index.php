
<?php if($model):?>
<div class="container">
    <div class="row mb-30">
        <div class="col-md-12">
            <h4><?= \yii\helpers\Html::a('Заключительный этап всероссийской олимпиады школьников по литературе в городе Москве в 2022 году',['/literature/register'])?></h4>
        </div>
        <?php if($model->is_success): ?>
        <div class="col-md-12">
            <h4>29  марта 2022 года</h4>
            <p>Позади второй тур олимпиады и мы рады предложить тебе <a href="https://docs.google.com/forms/d/e/1FAIpQLSc5orEZT4GFP9wXARqqbfURvT6dThwMLwP0SYRAnoxtQVoMFw/viewform"><b>творческие мастер-классы от МПГУ.</b></a>
            </p>
            <h4>31 марта 2022 года</h4>
            <p>Все испытания пройдены. Есть время и только ты решаешь, чем заполнить его: саморазвитием, творчеством, общением.
                <a href="https://docs.google.com/forms/d/e/1FAIpQLSdftfoCRuX0ClYOIvbUwW9cnZf94hSmzXUpRUzmpsO7VCTjkA/viewform"><b>Выбирай!</b></a>
            </p>
        </div>
        <?php endif;?>
    </div>
</div>
<?php endif; ?>