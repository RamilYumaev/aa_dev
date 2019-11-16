<aside class="main-sidebar">

    <section class="sidebar">

        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <?// $directoryAsset ?><img src="/img/nophoto.png" class="img-circle" alt="User Image"/>
            </div>
            <div class="pull-left info">
                <p><?=\olympic\helpers\auth\ProfileHelper::profileShortName(Yii::$app->user->id)?></p>

<!--                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>-->
            </div>
        </div>

        <!-- search form -->
<!--        <form action="#" method="get" class="sidebar-form">-->
<!--            <div class="input-group">-->
<!--               <input type="text" name="q" class="form-control" placeholder="Поиск..."/>-->
<!--                <span class="input-group-btn">-->
<!--                <button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i>-->
<!--                </button>-->
<!--              </span>-->
<!--            </div>-->
<!--        </form>-->
        <!-- /.search form -->

        <?= dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu tree', 'data-widget' => 'tree'],
                'items' => require __DIR__ . '/_menu.php',
            ]
        ) ?>

    </section>

</aside>
