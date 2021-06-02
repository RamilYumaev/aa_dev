<?php
return !Yii::$app->user->isGuest ? (
array_merge(
    (Yii::$app->user->can('manager') ?
        [['label' => 'Справочники', 'url' => '#',
            'items' => array_merge([
                ['label' => 'Шаблоны', 'url' => '/dictionary/templates'],
                ['label' => 'Председатели', 'url' => '/dictionary/dict-chairmans'],
                ['label' => 'Классы/курсы', 'url' => '/dictionary/dict-class'],
                ['label' => 'Сопоставление шаблонов', 'url' => '/dictionary/olimpiads-type-templates'],
                ['label' => 'Спец. виды олимпиад', 'url' => '/dictionary/dict-special-type-olimpic'],
                ['label' => 'Назначить главных', 'url' => '/dictionary/faculty/index'],
                ['label' => 'Институты/факультеты', 'url' => '/dictionary/faculty'],
                ['label' => 'Кафедры', 'url' => ['/dictionary-module/dict-cathedra']],
                ['label' => 'Ведущие мастер-классов', 'url' => '/dictionary/masters'],
                ['label' => 'Направления подготовки', 'url' => '/dictionary/dict-speciality'],
                ['label' => 'Образ. программы', 'url' => '/dictionary/dict-specialization'],
                ['label' => 'Вступительные испытания', 'url' => '/dictionary/dict-discipline'],
                ['label' => 'Конкурсные группы', 'url' => '/dictionary/dict-competitive-group'],
                ['label' => 'Классы/курсы', 'url' => '/dictionary/dict-class'],
                ['label' => 'Вебинары', 'url' => '/web-conference/index'],
                ['label' => 'Должности', 'url' => ['/dictionary-module/dict-post-education']],
                ['label' => 'Справочник ЕГЭ', 'url' => ['/dictionary-module/dict-cse-subject']],
                ['label' => 'Справочник ЦТ', 'url' => ['/dictionary-module/dict-ct-subject']],
                ['label' => 'Справочник ИД', 'url' => ['/dictionary-module/dict-individual-achievement']],
                ['label' => 'Справочник ПЭК', 'url' => ['/dictionary-module/dict-examiner']],
                ['label' => 'Сотрудники ЦПК', 'url' => ['/dictionary-module/job-entrant']],
                ['label' => 'Волонтеры', 'url' => ['/dictionary-module/volunteering']],
                ['label' => 'Настройки приема', 'url' => ['/dictionary-module/setting-entrant']],
                ['label' => 'Настройки КС', 'url' => ['/dictionary-module/setting-entrant/setting-competition-list-index']],
                ['label' => 'Реестр КС', 'url' => ['/dictionary-module/setting-entrant/register-competition-list-index']],
            ])]] : []),

//    (Yii::$app->user->can('manager') ?
//        [['label' => 'Рассылка', 'url' => '#',
//            'items' => array_merge([
//                ['label' => 'Шаблоны', 'url' => '/sending/template'],
//                ['label' => 'Модерация рассылки', 'url' => '/sending/send'],
//                ['label' => 'Опросы', 'url' => '/sending/polls/'],
//                ['label' => 'Варианты ответов', 'url' => '/sending/dict-poll-answer/'],
//            ])]] : []),


//    (Yii::$app->user->can('manager') ?
//        [['label' => 'Работа с сайтом', 'url' => '#',
//            'items' => array_merge([
//                ['label' => 'Код бакалавриата', 'url' => '/external/site-code-bak'],
//                ['label' => 'Код магистратуры', 'url' => '/external/site-code-mag'],
//
//                ['label' => 'Код калькулятора ЕГЭ', 'url' => '/external/site-code-cse'],
//
//            ])]] : []),

//    (Yii::$app->user->can('manager') ?
//        [['label' => 'Документы и ссылки', 'url' => '#',
//            'items' => array_merge([
//                ['label' => 'Категории', 'url' => '/doclinks/categories/index'],
//                ['label' => 'Добавить ссылки', 'url' => '/doclinks/links/index'],
//                ['label' => 'Добавить документы', 'url' => '/doclinks/documents/index'],
//            ])]] : []),


//    (Yii::$app->user->can('abitur_operator') ?
//        [['label' => 'Работа с абитуриентами', 'url' => '#',
//            'items' => array_merge([
//                ['label' => 'Абитуриенты', 'url' => '/faculty/index'],
//
//            ])]] : []),

    (Yii::$app->user->can('olymp_operator') ?
        [['label' => 'Олимпиады/конкурсы', 'url' => '#',
            'items' => array_merge([
                ['label' => 'Перечень ', 'url' => '/olympic/olympic'],
      //          ['label' => 'Группы вопросов', 'url' => '/testing/test-group'],
            ])]] : []),
    [['label' => 'Рассылки', 'url' => '#',
        'items' => array_merge([
            ['label' => 'Перечень рассылок ', 'url' => '/sending/sending'],
            ['label' => 'Перечень email ', 'url' => '/auth/setting-email'],
            ['label' => 'Шаблоны для рассылок ', 'url' => '/sending/dict-sending-template'],
            //          ['label' => 'Группы вопросов', 'url' => '/testing/test-group'],
        ])],
        ['label' => 'Техническая поддержка', 'url' => '#',
            'items' => array_merge([
                ['label' => 'Категории', 'url' => ['/support/category']],
                ['label' => 'Последние тикеты ', 'url' =>  ['/support/default']],
                //          ['label' => 'Группы вопросов', 'url' => '/testing/test-group'],
            ])]

    ],


    (Yii::$app->user->can('manager') ?
        [['label' => 'Дни открытых дверей', 'url' => '/dod/dod/',
    //        'items' => array_merge([['label' => 'Мастер-классы', 'url' => '/dictionary/master-class']]),
        ]] : []),


    Yii::$app->user->can('rbac') ?
        [['label' => 'Управление', 'url' => '#',
            'items' => array_merge([
                ['label' => 'Шаблоны', 'url' => '/admin/templates'],
                ['label' => 'Сопоставление шаблонов', 'url' => '/admin/olympiads-type-templates'],
                ['label' => 'Спец. виды олимпиад', 'url' => '/admin/dict-special-type-olimpic'],
                ['label' => 'Назначить главных', 'url' => '/faculty/admin/index'],
                ['label' => 'Пользователи', 'url' => '/rbac/user'],
                ['label' => 'Назначения', 'url' => '/rbac/assignment'],
                ['label' => 'Роли', 'url' => '/rbac/role'],
                ['label' => 'Разрешения', 'url' => '/rbac/permission'],
                ['label' => 'Маршруты', 'url' => '/rbac/route'],
                ['label' => 'Пользователи', 'url' => '/rbac/user'],
                ['label' => 'Правила', 'url' => '/rbac/rule'],
                ['label' => 'Меню', 'url' => '/rbac/menu'],
            ])]] : [],
    Yii::$app->user->can('moderation') ? [['label' => 'Модерация', 'url' => '/moderation',]] : [['label'=>'']],
    [['label' => 'Учебные организации', 'url' => '#',
        'items' => array_merge([
            ['label' => 'Список', 'url' => ['/dictionary-module/dict-schools']],
            ['label' => 'Для отчета', 'url' => ['/dictionary-module/dict-schools-report']],
        ])]],

    Yii::$app->user->can('dev') ?
        [['label' => 'Тестирование', 'url' => '#',
            'items' => array_merge([
                ['label' => 'Спр. подзадач', 'url' => ['/dictionary-module/dict-testing-entrant']],
                ['label' => 'Задачи', 'url' => ['/dictionary-module/testing-entrant']],
                ['label' => 'Кейсы', 'url' => ['/dictionary-module/testing-entrant/list-case']],
            ])]] :[],

    Yii::$app->user->can('dev_task') ?
    [['label' => 'УОПП', 'url' => '#',
        'items' => array_merge([
            ['label' => 'Спр. функций', 'url' => ['/management-admin/dict-task']],
            ['label' => 'Спр. должностей', 'url' => ['/management-admin/post-management']],
            ['label' => 'Отделы', 'url' => ['/management-admin/dict-department']],
            ['label' => 'Сопоставление', 'url' => ['/management-admin/post-rate-department']],
            ['label' => 'Категории док.', 'url' => ['/management-admin/category-document']],
            ['label' => 'Реестр док.', 'url' => ['/management-admin/registry-document']],
            ['label' => 'Графики работ', 'url' => ['/management-admin/schedule']],
            ['label' => 'Задачи', 'url' => ['/management-admin/default']],
        ])],
        ['label' => ' Календарь', 'url' => '#',
            'items' => array_merge([
                ['label' => 'Выходные дни', 'url' => ['/management-admin/date-feast']],
                ['label' => 'Перенесенные дни', 'url' => ['/management-admin/date-work']],
                ['label' => 'Отгулы', 'url' => ['/management-admin/date-off']],
            ])]
        ] :[]

)) : [];