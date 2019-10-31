<?php
return !Yii::$app->user->isGuest ? (
array_merge(
    (Yii::$app->user->can('manager') ?
        [['label' => 'Справочники', 'url' => '#',
            'items' => array_merge([
                ['label' => 'Шаблоны', 'url' => '/admin/templates'],
                ['label' => 'Председатели', 'url' => '/faculty/dict-chairmans'],
                ['label' => 'Классы/курсы', 'url' => '/faculty/dict-class'],
                ['label' => 'Сопоставление шаблонов с олимпиадами', 'url' => '/admin/olimpiads-type-templates'],
                ['label'=> 'Специальные виды олимпиад', 'url'=> '/admin/dict-special-type-olimpic'],
                ['label'=> 'Назначить главных по факультетам', 'url'=> '/faculty/admin/index'],
                ['label' => 'Институты/факультеты', 'url' => '/manager/dict-faculty'],
                ['label' => 'Дни открытых дверей', 'url' => '/manager/dod'],
                ['label' => 'Ведущие мастер-классов', 'url' => '/manager/masters'],
                ['label' => 'Мастер-классы', 'url' => '/manager/master-class'],
                ['label' => 'Направления подготовки', 'url' => '/manager/dict-speciality'],
                ['label' => 'Образовательные программы', 'url' => '/manager/dict-specialization'],
                ['label' => 'Вступительные испытания', 'url' => '/manager/dict-discipline'],
                ['label' => 'Конкурсные группы', 'url' => '/manager/dict-competitive-group'],
                ['label' => 'Классы/курсы', 'url' => '/faculty/dict-class'],
                ['label' => 'Председатели', 'url' => '/faculty/dict-chairmans'],


            ])]] : []),

    (Yii::$app->user->can('manager') ?
        [['label' => 'Рассылка', 'url' => '#',
            'items' => array_merge([
                ['label' => 'Шаблоны', 'url' => '/sending/template'],
                ['label' => 'Модерация рассылки', 'url' => '/sending/send'],
                ['label'=> 'Опросы', 'url'=> '/sending/polls/'],
                ['label'=> 'Варианты ответов на опросы', 'url'=> '/sending/dict-poll-answer/'],
            ])]] : []),


    (Yii::$app->user->can('manager') ?
        [['label' => 'Работа с сайтом', 'url' => '#',
            'items' => array_merge([
                ['label' => 'Код бакалавриата', 'url' => '/external/site-code-bak'],
                ['label' => 'Код магистратуры', 'url' => '/external/site-code-mag'],

                ['label' => 'Код калькулятора ЕГЭ', 'url' => '/external/site-code-cse'],

            ])]] : []),

    (Yii::$app->user->can('manager') ?
        [['label' => 'Документы и ссылки', 'url' => '#',
            'items' => array_merge([
                ['label' => 'Категории', 'url' => '/doclinks/categories/index'],
                ['label' => 'Добавить ссылки', 'url' => '/doclinks/links/index'],
                ['label' => 'Добавить документы', 'url' => '/doclinks/documents/index'],
            ])]] : []),


//    (Yii::$app->user->can('abitur_operator') ?
//        [['label' => 'Работа с абитуриентами', 'url' => '#',
//            'items' => array_merge([
//                ['label' => 'Абитуриенты', 'url' => '/faculty/index'],
//
//            ])]] : []),

    (Yii::$app->user->can('olymp_operator') ?
        [['label' => 'Олимпиады/конкурсы', 'url' => '#',
            'items' => array_merge([
                ['label' => 'Перечень олимпиад/конкурсов', 'url' => '/faculty/olimpic'],
                ['label' => 'Группы вопросов для тестов заочного тура', 'url' => '/test/question-group'],
            ])]] : []),


    Yii::$app->user->can('rbac') ?
        [['label' => 'Управление', 'url' => '#',
            'items' => array_merge([
                ['label' => 'Шаблоны', 'url' => '/admin/templates'],
                ['label' => 'Сопоставление шаблонов с олимпиадами', 'url' => '/admin/olimpiads-type-templates'],
                ['label'=> 'Специальные виды олимпиад', 'url'=> '/admin/dict-special-type-olimpic'],
                ['label'=> 'Назначить главных по факультетам', 'url'=> '/faculty/admin/index'],
                ['label' => 'Пользователи', 'url' => '/rbac/user'],
                ['label' => 'Назначения', 'url' => '/rbac/assignment'],
                ['label' => 'Роли', 'url' => '/rbac/role'],
                ['label' => 'Разрешения', 'url' => '/rbac/permission'],
                ['label' => 'Маршруты', 'url' => '/rbac/route'],
                ['label' => 'Пользователи', 'url' => '/rbac/user'],
                ['label' => 'Правила', 'url' => '/rbac/rule'],
                ['label' => 'Меню', 'url' => '/rbac/menu'],

            ])]] : []

)) : [];