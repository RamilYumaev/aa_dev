
      

            <?= dmstr\widgets\SmallBox::widget([
            "color" => \dmstr\components\AdminLTE::BG_RED,
              "header" => $noend,
                "icon" => "warning",
                "text" => "Незакрытые экзамены",
                'linkRoute' => ['examen/noend',],
            ]); ?>


      <?=
       dmstr\widgets\InfoBox::widget(
            [
                "color" => \dmstr\components\AdminLTE::BG_LIGHT_BLUE,
                "icon" => "mobile",
                "text" => "Баланс",
                "number" => $balance ." <i class='fa fa-ruble'></i>",

            ]
        )
        ?>