-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Хост: mysql
-- Время создания: Апр 27 2021 г., 12:48
-- Версия сервера: 5.7.22
-- Версия PHP: 7.4.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `db`
--

-- --------------------------------------------------------

--
-- Структура таблицы `2020_dict_incoming_competitive_group`
--

CREATE TABLE `2020_dict_incoming_competitive_group` (
  `ais_cg` int(11) DEFAULT NULL,
  `incoming_id` int(11) DEFAULT NULL,
  `order_name` varchar(5) DEFAULT NULL,
  `order_date` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `additional_information`
--

CREATE TABLE `additional_information` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `resource_id` int(11) NOT NULL,
  `voz_id` int(11) NOT NULL DEFAULT '0' COMMENT 'ВОЗ',
  `hostel_id` varchar(1) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Общежитие?',
  `chernobyl_status_id` int(11) DEFAULT '0' COMMENT 'Чернобыль',
  `mpgu_training_status_id` int(11) DEFAULT '0' COMMENT 'Курсы МПГУ',
  `mark_spo` float DEFAULT NULL COMMENT 'Средний балл аттестата',
  `exam_check` int(11) DEFAULT '0' COMMENT 'Согласие экзамена'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `address`
--

CREATE TABLE `address` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `country_id` int(11) NOT NULL COMMENT 'Страна',
  `type` int(11) NOT NULL COMMENT '1 - фактический, 2 - постоянная, 3 - временная',
  `postcode` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Индекс',
  `region` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Регион',
  `district` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Район',
  `city` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Город',
  `village` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Посёлок',
  `street` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Улица',
  `house` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Дом',
  `housing` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Корпус',
  `building` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Строение',
  `flat` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Квартира'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `agreement`
--

CREATE TABLE `agreement` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `organization_id` int(11) NOT NULL COMMENT 'Организация',
  `number` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Номер',
  `date` date DEFAULT NULL COMMENT 'От',
  `year` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Год',
  `status_id` int(11) DEFAULT '0',
  `message` text COLLATE utf8_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `ais_cg`
--

CREATE TABLE `ais_cg` (
  `id` int(11) NOT NULL,
  `faculty_id` int(11) NOT NULL,
  `specialty_id` int(11) NOT NULL,
  `specialization_id` int(11) DEFAULT NULL,
  `education_form_id` int(11) NOT NULL,
  `financing_type_id` int(11) NOT NULL,
  `kcp` int(11) NOT NULL,
  `competition_count` int(11) DEFAULT NULL,
  `competition_mark` int(11) DEFAULT NULL,
  `course` int(11) NOT NULL,
  `contract_only_status` int(11) DEFAULT NULL,
  `is_new_status` int(11) DEFAULT NULL,
  `enquiry_086_u_status` int(11) DEFAULT NULL,
  `special_right_id` int(11) DEFAULT NULL,
  `site_url` text,
  `year` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `ais_return_data`
--

CREATE TABLE `ais_return_data` (
  `id` int(11) NOT NULL,
  `created_id` int(11) NOT NULL,
  `incoming_id` int(11) NOT NULL,
  `model` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `model_type` int(11) DEFAULT NULL,
  `record_id_sdo` int(11) NOT NULL,
  `record_id_ais` int(11) NOT NULL,
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `ais_transfer_order`
--

CREATE TABLE `ais_transfer_order` (
  `id` int(11) NOT NULL,
  `ais_cg` int(11) DEFAULT NULL,
  `incoming_id` int(11) DEFAULT NULL,
  `order_name` varchar(5) DEFAULT NULL,
  `order_date` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `ais_transfer_order_`
--

CREATE TABLE `ais_transfer_order_` (
  `id` int(11) NOT NULL,
  `ais_cg` int(11) NOT NULL,
  `incoming_id` int(11) NOT NULL,
  `order_name` varchar(255) NOT NULL,
  `order_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `ais_transfer_order_last`
--

CREATE TABLE `ais_transfer_order_last` (
  `id` int(11) NOT NULL,
  `ais_cg` int(11) DEFAULT NULL,
  `incoming_id` int(11) DEFAULT NULL,
  `order_name` varchar(5) DEFAULT NULL,
  `order_date` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `ais_transfer_order__`
--

CREATE TABLE `ais_transfer_order__` (
  `id` int(11) NOT NULL,
  `ais_cg` int(11) NOT NULL,
  `incoming_id` int(11) NOT NULL,
  `order_name` varchar(7) NOT NULL,
  `order_date` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `anketa`
--

CREATE TABLE `anketa` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `citizenship_id` int(11) DEFAULT NULL COMMENT 'Гражданство',
  `edu_finish_year` int(11) DEFAULT NULL COMMENT 'Год окончания учебной организации',
  `current_edu_level` int(11) DEFAULT NULL COMMENT 'Текущий уроверь образования абитуриента',
  `category_id` int(11) DEFAULT NULL COMMENT 'Категория абитуриента',
  `university_choice` int(11) DEFAULT NULL COMMENT 'Выбор между головным вузом и филалами',
  `province_of_china` varchar(25) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Провинция Китая',
  `personal_student_number` varchar(25) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Персональный номер абитуриента по гослинии',
  `is_foreigner_edu_organization` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `answer`
--

CREATE TABLE `answer` (
  `id` int(11) NOT NULL,
  `quest_id` int(11) NOT NULL,
  `type` int(11) DEFAULT NULL,
  `name` text COLLATE utf8_unicode_ci,
  `is_correct` int(11) NOT NULL DEFAULT '0',
  `answer_match` text COLLATE utf8_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `answer_cloze`
--

CREATE TABLE `answer_cloze` (
  `id` int(11) NOT NULL,
  `quest_prop_id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `is_correct` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `auth`
--

CREATE TABLE `auth` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `source` varchar(255) NOT NULL,
  `source_id` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `auth_assignment`
--

CREATE TABLE `auth_assignment` (
  `item_name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `auth_assignment`
--

INSERT INTO `auth_assignment` (`item_name`, `user_id`, `created_at`) VALUES
('call-center', '1', 1539536315),
('dev', '1', 1539536315),
('dev_task', '1', 0),
('facultyOperator', '1', 1541777220),
('facultyOperator', '1', 1542021520),
('manager', '1', 1539536317),
('moderation', '1', 1592914201),
('olimpic_operator', '1', 1548069334),
('rbac', '1', 1539536319);

-- --------------------------------------------------------

--
-- Структура таблицы `auth_item`
--

CREATE TABLE `auth_item` (
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `type` smallint(6) NOT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `rule_name` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `data` blob,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `auth_item`
--

INSERT INTO `auth_item` (`name`, `type`, `description`, `rule_name`, `data`, `created_at`, `updated_at`) VALUES
('/*', 2, NULL, NULL, NULL, 1539178898, 1539178898),
('/doclinks/*', 2, NULL, NULL, NULL, 1545734879, 1545734879),
('/elfinder/*', 2, NULL, NULL, NULL, 1545209983, 1545209983),
('/faculty/admin/*', 2, NULL, NULL, NULL, 1541776101, 1541776101),
('/faculty/default/*', 2, NULL, NULL, NULL, 1541776116, 1541776116),
('/faculty/dict-chairmans/*', 2, NULL, NULL, NULL, 1541970104, 1541970104),
('/faculty/dict-class/*', 2, NULL, NULL, NULL, 1541970092, 1541970092),
('/faculty/olimpic/*', 2, NULL, NULL, NULL, 1541970079, 1541970079),
('/faculty/result/*', 2, NULL, NULL, NULL, 1550153119, 1550153119),
('/faculty/result/add-final-mark', 2, NULL, NULL, NULL, 1550153119, 1550153119),
('/faculty/result/auto-minus-distans-mark', 2, NULL, NULL, NULL, 1550475917, 1550475917),
('/faculty/result/auto-plus-distans-mark', 2, NULL, NULL, NULL, 1550475917, 1550475917),
('/faculty/result/delete-final-mark', 2, NULL, NULL, NULL, 1550153119, 1550153119),
('/faculty/result/first-place', 2, NULL, NULL, NULL, 1550153119, 1550153119),
('/faculty/result/personal-presence-attempt', 2, NULL, NULL, NULL, 1550153119, 1550153119),
('/faculty/result/publish-result', 2, NULL, NULL, NULL, 1550153119, 1550153119),
('/faculty/result/remove-place', 2, NULL, NULL, NULL, 1550153119, 1550153119),
('/faculty/result/second-place', 2, NULL, NULL, NULL, 1550153119, 1550153119),
('/faculty/result/set-persence-status', 2, NULL, NULL, NULL, 1550153119, 1550153119),
('/faculty/result/third-place', 2, NULL, NULL, NULL, 1550153119, 1550153119),
('/gii/*', 2, NULL, NULL, NULL, 1539189791, 1539189791),
('/manager/*', 2, NULL, NULL, NULL, 1539248284, 1539248284),
('/rbac/*', 2, NULL, NULL, NULL, 1539248297, 1539248297),
('/site/lottery', 2, NULL, NULL, NULL, 1540151639, 1540151639),
('/test/*', 2, NULL, NULL, NULL, 1549613229, 1549613229),
('/test/attempt/*', 2, NULL, NULL, NULL, 1549613225, 1549613225),
('/test/attempt/add-mark', 2, NULL, NULL, NULL, 1550475925, 1550475925),
('/test/attempt/add-personal-tour-came-handle', 2, NULL, NULL, NULL, 1550475925, 1550475925),
('/test/attempt/all-attempts', 2, NULL, NULL, NULL, 1550475925, 1550475925),
('/test/attempt/delete-all-members-personal-tour', 2, NULL, NULL, NULL, 1550475925, 1550475925),
('/test/attempt/delete-personal-tour-came-handle', 2, NULL, NULL, NULL, 1550475925, 1550475925),
('/test/attempt/delete-place', 2, NULL, NULL, NULL, 1550475925, 1550475925),
('/test/attempt/end', 2, NULL, NULL, NULL, 1550475925, 1550475925),
('/test/attempt/finish-distance-tour', 2, NULL, NULL, NULL, 1550475925, 1550475925),
('/test/attempt/process', 2, NULL, NULL, NULL, 1550475925, 1550475925),
('/test/attempt/result', 2, NULL, NULL, NULL, 1550475917, 1550475917),
('/test/attempt/start', 2, NULL, NULL, NULL, 1550475925, 1550475925),
('/test/question-group/*', 2, NULL, NULL, NULL, 1551251628, 1551251628),
('/test/question-group/create', 2, NULL, NULL, NULL, 1551251628, 1551251628),
('/test/question-group/delete', 2, NULL, NULL, NULL, 1551251628, 1551251628),
('/test/question-group/index', 2, NULL, NULL, NULL, 1551251628, 1551251628),
('/test/question-group/update', 2, NULL, NULL, NULL, 1551251628, 1551251628),
('/test/question/*', 2, NULL, NULL, NULL, 1551251628, 1551251628),
('/test/question/create', 2, NULL, NULL, NULL, 1551251628, 1551251628),
('/test/question/delete', 2, NULL, NULL, NULL, 1551251628, 1551251628),
('/test/question/index', 2, NULL, NULL, NULL, 1551251628, 1551251628),
('/test/question/update', 2, NULL, NULL, NULL, 1551251628, 1551251628),
('abitur_operator', 2, 'меню и таблица абитуриентов для ФОК', NULL, NULL, 1541776184, 1541776184),
('admin_faculty', 2, 'Администратор ФОК', NULL, NULL, 1541776219, 1541776219),
('adminFaculty', 1, NULL, NULL, NULL, 1541776245, 1541776245),
('call-center', 2, 'Оператор call-центра', NULL, NULL, 1549613229, 1549613229),
('count_mc', 2, 'выводить количество зарегистрированных на мастер-класс и ДОД', NULL, NULL, 1539786792, 1539788675),
('detailed-type', 2, 'Доступ к развёрнутому ответ', NULL, NULL, NULL, NULL),
('dev', 1, 'Роль разработчика', NULL, NULL, 1539248396, 1539248396),
('dev_permission', 2, 'Уровень разработчика', NULL, NULL, 1539178921, 1539248363),
('dev_task', 1, 'Задачи', NULL, NULL, NULL, NULL),
('entrant', 1, 'ФОК', NULL, NULL, NULL, NULL),
('facultyOperator', 1, 'оператор отборочной комиссии', NULL, NULL, 1541776283, 1541776283),
('manager', 1, 'роль менеджера системы', NULL, NULL, 1539248444, 1539248444),
('manager_permission', 2, 'Менеджер', NULL, NULL, 1539248335, 1539248370),
('moderation', 1, 'Модерация', NULL, NULL, NULL, NULL),
('month-receipt', 2, 'по месяцам', NULL, NULL, 1539248313, 1539248378),
('olimpic_operator', 1, NULL, NULL, NULL, 1547454874, 1547543910),
('olymp_operator', 2, 'оператор олимпиад', NULL, NULL, 1541970167, 1541970167),
('olympic_teacher', 2, 'Учитель, преподаватель', NULL, NULL, NULL, NULL),
('perMonth', 2, 'по месяцам (вторая защита)', NULL, NULL, NULL, NULL),
('proctor', 2, 'проктор', NULL, NULL, 1539248313, 1539248378),
('proctor-admin', 2, NULL, NULL, NULL, NULL, NULL),
('rbac', 1, 'Роль администратора системы', NULL, NULL, 1539248418, 1539248687),
('rbac_permission', 2, 'администратор', NULL, NULL, 1539248313, 1539248378),
('volunteering', 1, NULL, NULL, NULL, NULL, NULL),
('work', 1, 'УОПП', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `auth_item_child`
--

CREATE TABLE `auth_item_child` (
  `parent` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `child` varchar(64) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `auth_item_child`
--

INSERT INTO `auth_item_child` (`parent`, `child`) VALUES
('dev_permission', '/*'),
('manager_permission', '/doclinks/*'),
('olymp_operator', '/elfinder/*'),
('admin_faculty', '/faculty/admin/*'),
('abitur_operator', '/faculty/default/*'),
('admin_faculty', '/faculty/default/*'),
('olymp_operator', '/faculty/dict-chairmans/*'),
('olymp_operator', '/faculty/dict-class/*'),
('olymp_operator', '/faculty/olimpic/*'),
('olymp_operator', '/faculty/result/*'),
('olymp_operator', '/faculty/result/add-final-mark'),
('olymp_operator', '/faculty/result/auto-minus-distans-mark'),
('olymp_operator', '/faculty/result/auto-plus-distans-mark'),
('olymp_operator', '/faculty/result/delete-final-mark'),
('olymp_operator', '/faculty/result/first-place'),
('olymp_operator', '/faculty/result/personal-presence-attempt'),
('olymp_operator', '/faculty/result/publish-result'),
('olymp_operator', '/faculty/result/remove-place'),
('olymp_operator', '/faculty/result/second-place'),
('olymp_operator', '/faculty/result/set-persence-status'),
('olymp_operator', '/faculty/result/third-place'),
('dev_permission', '/gii/*'),
('manager_permission', '/manager/*'),
('rbac_permission', '/rbac/*'),
('count_mc', '/site/lottery'),
('olymp_operator', '/test/attempt/*'),
('olymp_operator', '/test/attempt/add-mark'),
('olymp_operator', '/test/attempt/add-personal-tour-came-handle'),
('olymp_operator', '/test/attempt/all-attempts'),
('olymp_operator', '/test/attempt/delete-all-members-personal-tour'),
('olymp_operator', '/test/attempt/delete-personal-tour-came-handle'),
('olymp_operator', '/test/attempt/delete-place'),
('olymp_operator', '/test/attempt/end'),
('olymp_operator', '/test/attempt/finish-distance-tour'),
('olymp_operator', '/test/attempt/process'),
('olymp_operator', '/test/attempt/result'),
('olymp_operator', '/test/attempt/start'),
('olymp_operator', '/test/question-group/*'),
('olymp_operator', '/test/question-group/create'),
('olymp_operator', '/test/question-group/delete'),
('olymp_operator', '/test/question-group/index'),
('olymp_operator', '/test/question-group/update'),
('olymp_operator', '/test/question/*'),
('olymp_operator', '/test/question/create'),
('olymp_operator', '/test/question/delete'),
('olymp_operator', '/test/question/index'),
('olymp_operator', '/test/question/update'),
('facultyOperator', 'abitur_operator'),
('adminFaculty', 'admin_faculty'),
('dev', 'adminFaculty'),
('adminFaculty', 'count_mc'),
('manager', 'count_mc'),
('olimpic_operator', 'count_mc'),
('dev', 'dev_permission'),
('dev', 'facultyOperator'),
('manager', 'manager_permission'),
('adminFaculty', 'olymp_operator'),
('olimpic_operator', 'olymp_operator'),
('rbac', 'rbac_permission');

-- --------------------------------------------------------

--
-- Структура таблицы `auth_rule`
--

CREATE TABLE `auth_rule` (
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `data` blob,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `category_document`
--

CREATE TABLE `category_document` (
  `id` int(11) NOT NULL,
  `name` text COLLATE utf8_unicode_ci NOT NULL COMMENT 'Наименование'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `cathedra_cg`
--

CREATE TABLE `cathedra_cg` (
  `cathedra_id` smallint(6) NOT NULL,
  `cg_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `cg_exam_ais`
--

CREATE TABLE `cg_exam_ais` (
  `id` int(11) NOT NULL,
  `competitive_group_id` int(11) NOT NULL COMMENT 'Конкурсная группа АИС',
  `entrance_examination_id` int(11) NOT NULL COMMENT 'Экзамен',
  `priority` int(11) DEFAULT NULL COMMENT 'Составная дисциплина',
  `year` int(11) DEFAULT NULL COMMENT 'Год'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `class_and_olympic`
--

CREATE TABLE `class_and_olympic` (
  `class_id` int(11) NOT NULL,
  `olympic_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `comment_task`
--

CREATE TABLE `comment_task` (
  `id` int(11) NOT NULL,
  `task_id` int(11) DEFAULT NULL,
  `text` text COLLATE utf8_unicode_ci,
  `created_by` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `composite_discipline`
--

CREATE TABLE `composite_discipline` (
  `discipline_id` int(11) NOT NULL,
  `discipline_select_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `cse_subject_result`
--

CREATE TABLE `cse_subject_result` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `result` text COLLATE utf8_unicode_ci COMMENT 'Результаты EГЭ',
  `year` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Год сдачи ЕГЭ'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `cse_vi_select`
--

CREATE TABLE `cse_vi_select` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `result_cse` text COLLATE utf8_unicode_ci COMMENT 'Результаты EГЭ',
  `vi` text COLLATE utf8_unicode_ci COMMENT 'Вступительные испытания'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `date_dod`
--

CREATE TABLE `date_dod` (
  `id` int(11) NOT NULL,
  `date_time` datetime NOT NULL,
  `broadcast_link` text,
  `dod_id` int(11) NOT NULL,
  `text` text,
  `type` int(11) NOT NULL DEFAULT '1' COMMENT '	1-очный тип; 2-очный тип с прямой трансляцией; 3-вебинар; 4-дистанционный тип; 5-гибридный тип (очный и дистанционный); 6-дистанционный для учебных организаций.'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `date_feast`
--

CREATE TABLE `date_feast` (
  `id` int(11) NOT NULL,
  `date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `date_off`
--

CREATE TABLE `date_off` (
  `id` int(11) NOT NULL,
  `schedule_id` int(11) NOT NULL,
  `date` date DEFAULT NULL,
  `isAllowed` tinyint(1) DEFAULT '0',
  `note` text COLLATE utf8_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `date_work`
--

CREATE TABLE `date_work` (
  `holiday` date DEFAULT NULL,
  `workday` date DEFAULT NULL,
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `declination_fio`
--

CREATE TABLE `declination_fio` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `nominative` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `genitive` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `dative` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `accusative` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ablative` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `prepositional` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `declination_fio`
--

INSERT INTO `declination_fio` (`id`, `user_id`, `nominative`, `genitive`, `dative`, `accusative`, `ablative`, `prepositional`) VALUES
(1, 1, 'Рутов Рут Рутович', 'Рутова Рута Рутовича', 'Рутову Руту Рутовичу', 'Рутова Рута Рутовича', 'Рутовым Рутом Рутовичем', 'Рутове Руте Рутовиче');

-- --------------------------------------------------------

--
-- Структура таблицы `dict_category`
--

CREATE TABLE `dict_category` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `foreigner_status` int(11) DEFAULT NULL COMMENT 'Иностранные граждане'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `dict_category_doc`
--

CREATE TABLE `dict_category_doc` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `type_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `dict_cathedra`
--

CREATE TABLE `dict_cathedra` (
  `id` smallint(6) NOT NULL COMMENT 'ID',
  `name` varchar(255) NOT NULL DEFAULT '' COMMENT 'Название'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Справочник Кафедры';

-- --------------------------------------------------------

--
-- Структура таблицы `dict_chairmans`
--

CREATE TABLE `dict_chairmans` (
  `id` int(11) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `patronymic` varchar(255) NOT NULL,
  `position` varchar(255) NOT NULL,
  `photo` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `dict_class`
--

CREATE TABLE `dict_class` (
  `id` int(11) NOT NULL,
  `name` varchar(56) NOT NULL,
  `type` int(11) NOT NULL COMMENT 'Школа/СПО/ВУЗ',
  `sort_id` int(11) DEFAULT NULL COMMENT 'Сортировка'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `dict_competitive_group`
--

CREATE TABLE `dict_competitive_group` (
  `id` int(11) NOT NULL,
  `speciality_id` int(11) NOT NULL,
  `specialization_id` int(11) NOT NULL,
  `education_form_id` int(11) NOT NULL,
  `education_duration` float NOT NULL,
  `financing_type_id` int(11) NOT NULL,
  `faculty_id` int(11) NOT NULL,
  `edu_level` int(11) DEFAULT NULL,
  `kcp` int(11) NOT NULL,
  `special_right_id` int(11) DEFAULT NULL,
  `competition_count` float DEFAULT NULL,
  `passing_score` int(11) DEFAULT NULL COMMENT 'проходной балл',
  `link` varchar(255) DEFAULT NULL,
  `is_new_program` int(11) NOT NULL,
  `only_pay_status` int(11) NOT NULL,
  `year` varchar(255) NOT NULL DEFAULT '2018-2019',
  `education_year_cost` decimal(9,2) DEFAULT NULL,
  `enquiry_086_u_status` tinyint(1) DEFAULT '0',
  `spo_class` tinyint(4) DEFAULT NULL,
  `discount` decimal(3,1) DEFAULT '0.0',
  `ais_id` int(11) DEFAULT NULL,
  `foreigner_status` int(11) DEFAULT NULL,
  `only_spo` int(11) DEFAULT '0' COMMENT 'только для выпускников колледжей',
  `tpgu_status` int(11) DEFAULT '0',
  `additional_set_status` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `dict_country`
--

CREATE TABLE `dict_country` (
  `id` int(11) NOT NULL COMMENT 'ID',
  `name` varchar(255) NOT NULL COMMENT 'Название страны',
  `cis` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Страна СНГ',
  `far_abroad` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Дальнее зарубежье'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Словарь Страны';

--
-- Дамп данных таблицы `dict_country`
--

INSERT INTO `dict_country` (`id`, `name`, `cis`, `far_abroad`) VALUES
(1, 'Азербайджан', 1, 0),
(2, 'Украина', 1, 0),
(3, 'Ирак', 0, 0),
(4, 'Армения', 1, 0),
(5, 'Туркмения', 0, 0),
(6, 'Монголия', 0, 0),
(7, 'Узбекистан', 1, 0),
(8, 'Молдова, Республика', 1, 0),
(9, 'Абхазия', 0, 0),
(10, 'Сербия', 0, 0),
(11, 'Сирийская Арабская Республика', 0, 0),
(12, 'Мозамбик', 0, 0),
(13, 'Китай', 0, 0),
(14, 'Корея, Республика', 0, 0),
(15, 'Турция', 0, 0),
(16, 'Латвия', 0, 0),
(17, 'Грузия', 0, 0),
(18, 'Оман', 0, 0),
(19, 'Литва', 0, 0),
(20, 'Япония', 0, 0),
(21, 'Германия', 0, 0),
(22, 'Вьетнам', 0, 0),
(23, 'Словакия', 0, 0),
(24, 'Эстония', 0, 0),
(25, 'Израиль', 0, 0),
(26, 'Польша', 0, 0),
(28, 'Словения', 0, 0),
(29, 'Казахстан', 1, 0),
(30, 'Таджикистан', 1, 0),
(31, 'Саудовская Аравия', 0, 0),
(32, 'Мали', 0, 0),
(33, 'Перу', 0, 0),
(34, 'Йемен', 0, 0),
(35, 'Киргизия', 1, 0),
(36, 'Мексика', 0, 0),
(37, 'Италия', 0, 0),
(38, 'Южная Осетия', 0, 0),
(39, 'Камерун', 0, 0),
(40, 'Финляндия', 0, 0),
(41, 'Таиланд', 0, 0),
(42, 'Индонезия', 0, 0),
(43, 'Иран, Исламская Республика', 0, 0),
(44, 'Бангладеш', 0, 0),
(45, 'Мадагаскар', 0, 0),
(46, 'Российская Федерация', 1, 0),
(47, 'Греция', 0, 0),
(48, 'Кипр', 0, 0),
(49, 'Беларусь', 1, 0),
(50, 'Непал', 0, 0),
(51, 'Колумбия', 0, 0),
(52, 'Шри-Ланка', 0, 0),
(53, 'Пакистан', 0, 0),
(54, 'Болгария', 0, 0),
(55, 'Афганистан', 0, 0),
(56, 'Египет', 0, 0),
(57, 'Гана', 0, 0),
(58, 'Экваториальная Гвинея', 0, 0),
(59, 'Бельгия', 0, 0),
(60, 'Джибути', 0, 0),
(61, 'Аргентина', 0, 0),
(62, 'Бразилия', 0, 0),
(63, 'Конго', 0, 0),
(64, 'Палестина', 0, 0),
(65, 'Доминиканская Республика', 0, 0),
(66, 'Лесото', 0, 0),
(67, 'Филиппины', 0, 0),
(68, 'Чад', 0, 0),
(69, 'Кот Д`Ивуар', 0, 0),
(70, 'Куба', 0, 0),
(71, 'Македония', 0, 0),
(72, 'Эквадор', 0, 0),
(73, 'Австралия', 0, 0),
(74, 'Австрия', 0, 0),
(75, 'Албания', 0, 0),
(76, 'Алжир', 0, 0),
(77, 'Американское Самоа', 0, 0),
(78, 'Ангилья', 0, 0),
(79, 'Ангола', 0, 0),
(80, 'Андорра', 0, 0),
(81, 'Антигуа и Барбуда', 0, 0),
(82, 'Аруба', 0, 0),
(83, 'Багамы', 0, 0),
(84, 'Ямайка', 0, 0),
(85, 'Эфиопия', 0, 0),
(86, 'Швеция', 0, 0),
(87, 'Черногория', 0, 0),
(88, 'Чили', 0, 0),
(89, 'Уганда', 0, 0),
(91, 'Тунис', 0, 0),
(92, 'Того', 0, 0),
(93, 'Судан', 0, 0),
(94, 'Тайвань (Китай)', 0, 0),
(95, 'Сомали', 0, 0),
(96, 'Соединенные Штаты', 0, 0),
(97, 'Сенегал', 0, 0),
(98, 'Румыния', 0, 0),
(99, 'Руанда', 0, 0),
(100, 'Франция', 0, 0),
(101, 'Токелау', 0, 0),
(102, 'Тонга', 0, 0),
(103, 'Португалия', 0, 0),
(104, 'Эландские острова', 0, 0),
(105, 'Эритрея', 0, 0),
(106, 'Южная Африка', 0, 0),
(107, 'Швейцария', 0, 0),
(108, 'Хорватия', 0, 0),
(109, 'Уругвай', 0, 0),
(110, 'Фарерские острова', 0, 0),
(111, 'Чешская Республика', 0, 0),
(112, 'Французская Полинезия', 0, 0),
(113, 'Шпицберген И Ян Майен', 0, 0),
(114, 'Тувалу', 0, 0),
(115, 'Тринидад и Тобаго', 0, 0),
(116, 'Суринам', 0, 0),
(117, 'Сейшелы', 0, 0),
(118, 'Питкерн', 0, 0),
(119, 'Пуэрто-Рико', 0, 0),
(120, 'Парагвай', 0, 0),
(121, 'Панама', 0, 0),
(122, 'Палау', 0, 0),
(123, 'Сен-Мартен', 0, 0),
(124, 'Сингапур', 0, 0),
(125, 'Свазиленд', 0, 0),
(126, 'Реюньон', 0, 0),
(127, 'Норвегия', 0, 0),
(128, 'Нигер', 0, 0),
(129, 'Мьянма', 0, 0),
(130, 'Монако', 0, 0),
(131, 'Барбадос', 0, 0),
(132, 'Бермуды', 0, 0),
(133, 'Белиз', 0, 0),
(134, 'Новая Каледония', 0, 0),
(135, 'Новая Зеландия', 0, 0),
(136, 'Никарагуа', 0, 0),
(137, 'Нидерланды', 0, 0),
(138, 'Нидерландские Антилы', 0, 0),
(139, 'Нигерия', 0, 0),
(140, 'Науру', 0, 0),
(141, 'Южная Джорджия и Южные Сандвичевы Острова', 0, 0),
(142, 'Французская Гвиана', 0, 0),
(143, 'Французские Южные территории', 0, 0),
(144, 'Фолклендские острова (Мальвинские)', 0, 0),
(145, 'Центрально-африканская Республика', 0, 0),
(146, 'Танзания, Объединенная Республика', 0, 0),
(147, 'Сьерра-Леоне', 0, 0),
(148, 'Соломоновы Острова', 0, 0),
(149, 'Соединенное Королевство', 0, 0),
(150, 'Коста-Рика', 0, 0),
(151, 'Кения', 0, 0),
(152, 'Катар', 0, 0),
(153, 'Канада', 0, 0),
(154, 'Камбоджа', 0, 0),
(155, 'Испания', 0, 0),
(156, 'Исландия', 0, 0),
(157, 'Ирландия', 0, 0),
(158, 'Иордания', 0, 0),
(159, 'Индия', 0, 0),
(160, 'Зимбабве', 0, 0),
(161, 'Западная Сахара', 0, 0),
(162, 'Замбия', 0, 0),
(163, 'Доминика', 0, 0),
(164, 'Дания', 0, 0),
(165, 'Гуам', 0, 0),
(166, 'Намибия', 0, 0),
(167, 'Мальта', 0, 0),
(168, 'Марокко', 0, 0),
(169, 'Мальдивы', 0, 0),
(170, 'Мартиника', 0, 0),
(171, 'Малави', 0, 0),
(172, 'Папуа-Новая Гвинея', 0, 0),
(173, 'Сан-Марино', 0, 0),
(174, 'Сан-Томе и Принсипи', 0, 0),
(175, 'Сен-Бартелеми', 0, 0),
(176, 'Сент-Винсент и Гренадины', 0, 0),
(177, 'Сент-Люсия', 0, 0),
(178, 'Сент-Пьер и Микелон', 0, 0),
(179, 'Остров Норфолк', 0, 0),
(180, 'Остров Буве', 0, 0),
(181, 'Остров Мэн', 0, 0),
(182, 'Острова Кайман', 0, 0),
(183, 'Острова Кука', 0, 0),
(184, 'Остров Рождества', 0, 0),
(185, 'Остров Херд и острова Макдональд', 0, 0),
(186, 'Острова Теркс и Кайкос', 0, 0),
(187, 'Малайзия', 0, 0),
(188, 'Майотта', 0, 0),
(189, 'Мавритания', 0, 0),
(190, 'Маврикий', 0, 0),
(191, 'Люксембург', 0, 0),
(192, 'Лихтенштейн', 0, 0),
(193, 'Ливан', 0, 0),
(194, 'Либерия', 0, 0),
(195, 'Кувейт', 0, 0),
(196, 'Корея, Народно-Демократическая Республика', 0, 0),
(197, 'Кокосовые (Килинг) Острова', 0, 0),
(198, 'Кабо-Верде', 0, 0),
(199, 'Джерси', 0, 0),
(200, 'Гренландия', 0, 0),
(201, 'Гренада', 0, 0),
(202, 'Гондурас', 0, 0),
(203, 'Гибралтар', 0, 0),
(204, 'Гернси', 0, 0),
(205, 'Гваделупа', 0, 0),
(206, 'Гватемала', 0, 0),
(207, 'Гвинея', 0, 0),
(208, 'Гвинея-Бисау', 0, 0),
(209, 'Бенин', 0, 0),
(210, 'Боливия', 0, 0),
(211, 'Ботсвана', 0, 0),
(212, 'Босния и Герцоговина', 0, 0),
(213, 'Британская Территория в Индийском Океане', 0, 0),
(214, 'Бруней-Даруссалам', 0, 0),
(215, 'Буркина-Фасо', 0, 0),
(216, 'Бурунди', 0, 0),
(217, 'Бутан', 0, 0),
(218, 'Вануату', 0, 0),
(219, 'Венгрия', 0, 0),
(220, 'Объединенные Арабские Эмираты', 0, 0),
(221, 'Северные Марианские Острова', 0, 0),
(222, 'Папский Престол (Государство-город Ватикан)', 0, 0),
(223, 'Монтсеррат', 0, 0),
(224, 'Маршалловы Острова', 0, 0),
(226, 'Микронезия, Федеративные Штаты', 0, 0),
(227, 'Малые Тихоокеанские отдаленные острова Соединенных Штатов', 0, 0),
(228, 'Лаосская Народно-Демократическая Республика', 0, 0),
(229, 'Ливийская Арабская Джамахирия', 0, 0),
(230, 'Венесуэла', 0, 0),
(231, 'Виргинские Острова, Британские', 0, 0),
(232, 'Виргинские Острова, США', 0, 0),
(233, 'Габон', 0, 0),
(234, 'Гаити', 0, 0),
(235, 'Гайана', 0, 0),
(236, 'Гамбия', 0, 0),
(237, 'Конго, Демократическая Республика', 0, 0),
(238, 'Сент-Китс и Невис', 0, 0),
(240, 'Коморские острова', 0, 0);

-- --------------------------------------------------------

--
-- Структура таблицы `dict_cse_subject`
--

CREATE TABLE `dict_cse_subject` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Наименование',
  `min_mark` int(11) DEFAULT NULL COMMENT 'Минимальный балл для поступления',
  `composite_discipline_status` int(11) DEFAULT '0' COMMENT 'Составная дисциплина',
  `cse_status` int(11) DEFAULT '0' COMMENT 'Предмет ЕГЭ',
  `ais_id` int(11) DEFAULT NULL COMMENT 'Id АИС ВУЗ'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `dict_ct_subject`
--

CREATE TABLE `dict_ct_subject` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Наименование',
  `min_mark` int(11) DEFAULT NULL COMMENT 'Минимальный балл для поступления',
  `composite_discipline_status` int(11) DEFAULT '0' COMMENT 'Составная дисциплина',
  `cse_status` int(11) DEFAULT '0' COMMENT 'Предмет ЕГЭ',
  `ais_id` int(11) DEFAULT NULL COMMENT 'Id АИС ВУЗ'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `dict_department`
--

CREATE TABLE `dict_department` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `name_short` varchar(255) COLLATE utf8_unicode_ci DEFAULT '',
  `name_genitive` varchar(255) COLLATE utf8_unicode_ci DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `dict_discipline`
--

CREATE TABLE `dict_discipline` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `links` varchar(255) NOT NULL,
  `cse_subject_id` int(11) DEFAULT NULL,
  `ais_id` int(11) DEFAULT NULL,
  `composite_discipline` int(11) DEFAULT NULL COMMENT 'Составная дисциплина',
  `dvi` int(11) DEFAULT NULL COMMENT 'Дополнительное вступительное испытание',
  `is_och` int(11) DEFAULT '0',
  `ct_subject_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `dict_examiner`
--

CREATE TABLE `dict_examiner` (
  `id` int(11) NOT NULL,
  `fio` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `dict_faculty`
--

CREATE TABLE `dict_faculty` (
  `id` int(11) NOT NULL,
  `full_name` text NOT NULL,
  `filial` int(11) DEFAULT '0',
  `ais_id` int(11) DEFAULT NULL,
  `short` varchar(255) DEFAULT NULL,
  `genitive_name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `dict_foreign_language`
--

CREATE TABLE `dict_foreign_language` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Наименование'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `dict_incoming_document_type`
--

CREATE TABLE `dict_incoming_document_type` (
  `id` tinyint(4) NOT NULL COMMENT 'ID',
  `name` varchar(255) NOT NULL COMMENT 'Название',
  `type_id` tinyint(4) DEFAULT NULL COMMENT 'Тип'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Абитуриент Справочник Типы документов';

-- --------------------------------------------------------

--
-- Структура таблицы `dict_individual_achievement`
--

CREATE TABLE `dict_individual_achievement` (
  `id` smallint(6) NOT NULL COMMENT 'ID',
  `name` varchar(255) NOT NULL COMMENT 'Полное описание ИД',
  `name_short` varchar(255) NOT NULL COMMENT 'Краткое описание ИД',
  `mark` tinyint(3) UNSIGNED NOT NULL COMMENT 'Максимальный балл',
  `category_id` tinyint(3) UNSIGNED NOT NULL COMMENT 'Категория',
  `year` varchar(9) NOT NULL DEFAULT '2019-2020'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Абитуриент Справочник Индивидуальные достижения';

-- --------------------------------------------------------

--
-- Структура таблицы `dict_individual_achievement_cg`
--

CREATE TABLE `dict_individual_achievement_cg` (
  `individual_achievement_id` smallint(6) NOT NULL,
  `competitive_group_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `dict_individual_achievement_document`
--

CREATE TABLE `dict_individual_achievement_document` (
  `individual_achievement_id` smallint(6) NOT NULL,
  `document_type_id` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `dict_organizations`
--

CREATE TABLE `dict_organizations` (
  `id` int(11) NOT NULL,
  `name` text COLLATE utf8_unicode_ci NOT NULL COMMENT 'Наименование организации',
  `ais_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `dict_poll_answers`
--

CREATE TABLE `dict_poll_answers` (
  `id` int(11) NOT NULL,
  `name` varchar(25) NOT NULL,
  `text_addition` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `dict_post_education`
--

CREATE TABLE `dict_post_education` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Наименование'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `dict_region`
--

CREATE TABLE `dict_region` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

--
-- Дамп данных таблицы `dict_region`
--

INSERT INTO `dict_region` (`id`, `name`) VALUES
(1, 'Республика Адыгея (Адыгея)'),
(2, 'Республика Башкортостан'),
(3, 'Республика Бурятия'),
(4, 'Республика Алтай'),
(5, 'Республика Дагестан'),
(6, 'Республика Ингушетия'),
(7, 'Кабардино-Балкарская Республика'),
(8, 'Республика Калмыкия'),
(9, 'Карачаево-Черкесская Республика'),
(10, 'Республика Карелия'),
(11, 'Республика Коми'),
(12, 'Республика Марий Эл'),
(13, 'Республика Мордовия'),
(14, 'Республика Саха (Якутия)'),
(15, 'Республика Северная Осетия - Алания'),
(16, 'Республика Татарстан (Татарстан)'),
(17, 'Республика Тыва'),
(18, 'Удмуртская Республика'),
(19, 'Республика Хакасия'),
(20, 'Чеченская Республика'),
(21, 'Чувашская Республика - Чувашия'),
(22, 'Алтайский край'),
(23, 'Краснодарский край'),
(24, 'Красноярский край'),
(25, 'Приморский край'),
(26, 'Ставропольский край'),
(27, 'Хабаровский край'),
(28, 'Амурская область'),
(29, 'Архангельская область'),
(30, 'Астраханская область'),
(31, 'Белгородская область'),
(32, 'Брянская область'),
(33, 'Владимирская область'),
(34, 'Волгоградская область'),
(35, 'Вологодская область'),
(36, 'Воронежская область'),
(37, 'Ивановская область'),
(38, 'Иркутская область'),
(39, 'Калининградская область'),
(40, 'Калужская область'),
(41, 'Камчатский край'),
(42, 'Кемеровская область'),
(43, 'Кировская область'),
(44, 'Костромская область'),
(45, 'Курганская область'),
(46, 'Курская область'),
(47, 'Ленинградская область'),
(48, 'Липецкая область'),
(49, 'Магаданская область'),
(50, 'Московская область'),
(51, 'Мурманская область'),
(52, 'Нижегородская область'),
(53, 'Новгородская область'),
(54, 'Новосибирская область'),
(55, 'Омская область'),
(56, 'Оренбургская область'),
(57, 'Орловская область'),
(58, 'Пензенская область'),
(59, 'Пермский край'),
(60, 'Псковская область'),
(61, 'Ростовская область'),
(62, 'Рязанская область'),
(63, 'Самарская область'),
(64, 'Саратовская область'),
(65, 'Сахалинская область'),
(66, 'Свердловская область'),
(67, 'Смоленская область'),
(68, 'Тамбовская область'),
(69, 'Тверская область'),
(70, 'Томская область'),
(71, 'Тульская область'),
(72, 'Тюменская область'),
(73, 'Ульяновская область'),
(74, 'Челябинская область'),
(75, 'Забайкальский край'),
(76, 'Ярославская область'),
(77, 'г. Москва'),
(78, 'г. Санкт-Петербург'),
(79, 'Еврейская автономная область'),
(80, 'Ненецкий автономный округ'),
(81, 'Ханты-Мансийский автономный округ - Югра'),
(82, 'Чукотский автономный округ'),
(83, 'Ямало-Ненецкий автономный округ'),
(84, 'Республика Крым'),
(85, 'г. Севастополь'),
(86, 'Иные территории, включая город и космодром Байконур');

-- --------------------------------------------------------

--
-- Структура таблицы `dict_schools`
--

CREATE TABLE `dict_schools` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `country_id` int(11) NOT NULL,
  `region_id` int(11) DEFAULT NULL,
  `dict_school_report_id` int(11) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT '0',
  `email` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `dict_schools_pre_moderation`
--

CREATE TABLE `dict_schools_pre_moderation` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `country_id` int(11) NOT NULL,
  `region_id` int(11) DEFAULT NULL,
  `dict_school_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `dict_schools_report`
--

CREATE TABLE `dict_schools_report` (
  `id` int(11) NOT NULL,
  `school_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `dict_sending_template`
--

CREATE TABLE `dict_sending_template` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `html` text NOT NULL,
  `text` text NOT NULL,
  `user_id` int(11) NOT NULL,
  `base_type` int(11) DEFAULT NULL,
  `check_status` int(11) NOT NULL DEFAULT '0',
  `type` int(11) NOT NULL DEFAULT '1' COMMENT '1 - олимпиада, 2 - ДОД, 3 - мастер-классы',
  `type_sending` int(11) DEFAULT NULL COMMENT '1 - приглашение, 2 - дипломы, 3 - приглашение после заочного тура'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `dict_sending_user_category`
--

CREATE TABLE `dict_sending_user_category` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Структура таблицы `dict_speciality`
--

CREATE TABLE `dict_speciality` (
  `id` int(11) NOT NULL,
  `code` varchar(8) NOT NULL,
  `name` varchar(255) NOT NULL,
  `ais_id` int(11) DEFAULT NULL,
  `short` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `dict_specialization`
--

CREATE TABLE `dict_specialization` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `speciality_id` int(11) NOT NULL,
  `ais_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `dict_special_type_olimpic`
--

CREATE TABLE `dict_special_type_olimpic` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `dict_task`
--

CREATE TABLE `dict_task` (
  `id` int(11) NOT NULL,
  `color` varchar(7) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT '',
  `description` text COLLATE utf8_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `diploma`
--

CREATE TABLE `diploma` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `olimpic_id` int(11) NOT NULL,
  `reward_status_id` int(11) DEFAULT NULL,
  `nomination_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `discipline_competitive_group`
--

CREATE TABLE `discipline_competitive_group` (
  `discipline_id` int(11) NOT NULL,
  `competitive_group_id` int(11) NOT NULL,
  `priority` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `discipline_user`
--

CREATE TABLE `discipline_user` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `type` int(11) DEFAULT NULL COMMENT 'Тип',
  `discipline_id` int(11) NOT NULL,
  `discipline_select_id` int(11) NOT NULL,
  `mark` int(11) DEFAULT '0',
  `year` varchar(4) COLLATE utf8_unicode_ci NOT NULL,
  `status_cse` int(11) DEFAULT '0' COMMENT 'Статус ЕГЭ'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `documents`
--

CREATE TABLE `documents` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL,
  `extentions` varchar(10) NOT NULL,
  `category_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `document_education`
--

CREATE TABLE `document_education` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `school_id` int(11) NOT NULL COMMENT 'Учебное заведение',
  `type` tinyint(4) DEFAULT NULL COMMENT 'Тип документа',
  `series` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Серия',
  `number` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Номер',
  `date` date DEFAULT NULL COMMENT 'От',
  `year` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Год окончания',
  `original` int(11) DEFAULT NULL COMMENT 'Оригинал',
  `surname` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Фамилия',
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Имя',
  `patronymic` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Отчество',
  `without_appendix` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `document_task`
--

CREATE TABLE `document_task` (
  `document_registry_id` int(11) NOT NULL,
  `task_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `dod`
--

CREATE TABLE `dod` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL,
  `description` text NOT NULL,
  `type` int(11) NOT NULL,
  `faculty_id` int(11) DEFAULT NULL,
  `edu_level` int(11) DEFAULT NULL,
  `aud_number` varchar(32) DEFAULT NULL,
  `address` text NOT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `photo_report` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `entrance_statistics`
--

CREATE TABLE `entrance_statistics` (
  `id` int(11) NOT NULL COMMENT 'id',
  `year` int(11) NOT NULL COMMENT 'год приема',
  `faculty_id` int(11) DEFAULT NULL COMMENT 'институт/факультет',
  `speciality_id` int(11) DEFAULT NULL COMMENT 'направление подготовки',
  `specialzation_id` varchar(255) DEFAULT NULL COMMENT 'профиль/маг. программа/ООП',
  `edu_form` int(11) DEFAULT NULL COMMENT 'форма обучения',
  `financing_type_id` int(11) DEFAULT NULL COMMENT 'вид финансирования',
  `cg_id` varchar(255) DEFAULT NULL COMMENT 'конкурсная группа',
  `type_of_competition` int(11) DEFAULT NULL COMMENT 'тип конкурса (обычный, квота, целевик, БВИ)',
  `edu_level` int(11) DEFAULT NULL COMMENT 'уровень образования',
  `kind_of_entrance` int(11) DEFAULT NULL COMMENT 'вид поступления (ЕГЭ, ВИ, ЕГЭ + ВИ)',
  `Individual_ball_sum` int(11) DEFAULT NULL COMMENT 'сумма баллов за индивидуальные достижения',
  `average_ball_cse` float DEFAULT NULL COMMENT 'средний балл ЕГЭ',
  `average_ball_cse_art_prof` float DEFAULT NULL COMMENT 'средний балл ЕГЭ + доп. ВИ',
  `sum_of_ball` int(11) DEFAULT NULL COMMENT 'сумма баллов',
  `base_education` int(11) DEFAULT NULL COMMENT 'базовое образование',
  `school_name` varchar(255) DEFAULT NULL COMMENT 'название ОО',
  `region_of_registration_id` int(11) DEFAULT NULL COMMENT 'регион постоянной регистрации',
  `regiorn_of_actual_id` int(11) DEFAULT NULL COMMENT 'регион фактического проживания',
  `citizen_id` int(11) DEFAULT NULL COMMENT 'гражданство',
  `cpk_or_ums` int(11) DEFAULT NULL COMMENT 'способ поступления ЦПК/УМС',
  `compatriot_status` int(11) DEFAULT NULL COMMENT 'cоотечественник'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `exam`
--

CREATE TABLE `exam` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `discipline_id` int(11) NOT NULL,
  `date_start` date NOT NULL,
  `date_end` date NOT NULL,
  `time_start` time NOT NULL,
  `time_end` time NOT NULL,
  `time_exam` int(11) NOT NULL,
  `date_start_reserve` date DEFAULT NULL,
  `date_end_reserve` date DEFAULT NULL,
  `time_start_reserve` time DEFAULT NULL,
  `time_end_reserve` time DEFAULT NULL,
  `src_bb` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `examiner_discipline`
--

CREATE TABLE `examiner_discipline` (
  `examiner_id` int(11) NOT NULL,
  `discipline_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `exam_answer`
--

CREATE TABLE `exam_answer` (
  `id` int(11) NOT NULL,
  `question_id` int(11) NOT NULL,
  `name` text COLLATE utf8_unicode_ci,
  `is_correct` int(11) DEFAULT '0',
  `answer_match` text COLLATE utf8_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `exam_answer_nested`
--

CREATE TABLE `exam_answer_nested` (
  `id` int(11) NOT NULL,
  `question_nested_id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `is_correct` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `exam_attempt`
--

CREATE TABLE `exam_attempt` (
  `id` int(11) NOT NULL,
  `exam_id` int(11) NOT NULL,
  `test_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `start` datetime NOT NULL,
  `end` datetime DEFAULT NULL,
  `mark` decimal(4,1) DEFAULT NULL,
  `status` int(11) DEFAULT '0',
  `type` int(11) DEFAULT '0',
  `pause_minute` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `exam_question`
--

CREATE TABLE `exam_question` (
  `id` int(11) NOT NULL,
  `question_group_id` int(11) DEFAULT NULL,
  `discipline_id` int(11) NOT NULL,
  `type_id` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `text` text COLLATE utf8_unicode_ci NOT NULL,
  `file_type_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `exam_question_group`
--

CREATE TABLE `exam_question_group` (
  `id` int(11) NOT NULL,
  `discipline_id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `exam_question_in_test`
--

CREATE TABLE `exam_question_in_test` (
  `id` int(11) NOT NULL,
  `test_id` int(11) NOT NULL,
  `question_group_id` int(11) DEFAULT NULL,
  `question_id` int(11) DEFAULT NULL,
  `mark` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `exam_question_nested`
--

CREATE TABLE `exam_question_nested` (
  `id` int(11) NOT NULL,
  `question_id` int(11) NOT NULL,
  `type` int(11) DEFAULT NULL,
  `name` text COLLATE utf8_unicode_ci,
  `is_start` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `exam_result`
--

CREATE TABLE `exam_result` (
  `attempt_id` int(11) NOT NULL,
  `question_id` int(11) NOT NULL,
  `updated` timestamp NULL DEFAULT NULL,
  `result` text COLLATE utf8_unicode_ci,
  `mark` int(11) DEFAULT NULL,
  `tq_id` int(11) NOT NULL,
  `priority` int(11) DEFAULT '0',
  `note` text COLLATE utf8_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `exam_statement`
--

CREATE TABLE `exam_statement` (
  `id` int(11) NOT NULL,
  `exam_id` int(11) NOT NULL,
  `entrant_user_id` int(11) NOT NULL,
  `proctor_user_id` int(11) DEFAULT NULL,
  `src_bbb` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` int(11) DEFAULT '0',
  `date` date DEFAULT NULL,
  `message` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `type` int(11) DEFAULT '0',
  `time` varchar(5) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `exam_test`
--

CREATE TABLE `exam_test` (
  `id` int(11) NOT NULL,
  `exam_id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `introduction` text COLLATE utf8_unicode_ci,
  `final_review` text COLLATE utf8_unicode_ci,
  `status` int(11) DEFAULT '0',
  `random_order` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `exam_violation`
--

CREATE TABLE `exam_violation` (
  `id` int(11) NOT NULL,
  `exam_statement_id` int(11) NOT NULL,
  `datetime` datetime DEFAULT NULL,
  `message` text COLLATE utf8_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `files`
--

CREATE TABLE `files` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `model` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Модель',
  `file_name_user` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Файл',
  `file_name_base` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Файл',
  `record_id` int(11) NOT NULL COMMENT 'Значение',
  `position` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  `status` int(11) DEFAULT '0',
  `message` text COLLATE utf8_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `fio_latin`
--

CREATE TABLE `fio_latin` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `surname` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Фамилия',
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Имя',
  `patronymic` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Отчество'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `history_task`
--

CREATE TABLE `history_task` (
  `id` int(11) NOT NULL,
  `task_id` int(11) DEFAULT NULL,
  `before` json DEFAULT NULL,
  `after` json DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `infoda`
--

CREATE TABLE `infoda` (
  `id` int(11) NOT NULL,
  `incoming_id` int(11) DEFAULT NULL,
  `login` varchar(20) DEFAULT NULL,
  `pass` varchar(8) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `infoda_`
--

CREATE TABLE `infoda_` (
  `id` int(11) NOT NULL,
  `incoming_id` varchar(9) DEFAULT NULL,
  `login` varchar(20) DEFAULT NULL,
  `pass` varchar(8) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `insurance_certificate_user`
--

CREATE TABLE `insurance_certificate_user` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `number` varchar(14) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `invitation`
--

CREATE TABLE `invitation` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `olimpic_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `job_entrant`
--

CREATE TABLE `job_entrant` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `faculty_id` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT '0',
  `email_id` int(11) DEFAULT NULL,
  `examiner_id` int(11) DEFAULT NULL,
  `right_full` int(11) DEFAULT '1',
  `post` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `kladr_doma`
--

CREATE TABLE `kladr_doma` (
  `NAME` varchar(128) NOT NULL,
  `KORP` varchar(0) NOT NULL,
  `SOCR` varchar(6) NOT NULL,
  `CODE` varchar(19) NOT NULL,
  `INDEX` varchar(6) NOT NULL,
  `GNINMB` varchar(4) NOT NULL,
  `UNO` varchar(4) NOT NULL,
  `OCATD` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `kladr_kladr`
--

CREATE TABLE `kladr_kladr` (
  `NAME` varchar(128) NOT NULL,
  `SOCR` varchar(20) NOT NULL,
  `CODE` varchar(13) NOT NULL,
  `INDEX` varchar(6) NOT NULL,
  `GNINMB` varchar(4) NOT NULL,
  `UNO` varchar(4) NOT NULL,
  `OCATD` varchar(11) NOT NULL,
  `STATUS` varchar(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `kladr_street`
--

CREATE TABLE `kladr_street` (
  `NAME` varchar(128) NOT NULL,
  `SOCR` varchar(19) NOT NULL,
  `CODE` varchar(17) NOT NULL,
  `INDEX` varchar(6) NOT NULL,
  `GNINMB` varchar(4) NOT NULL,
  `UNO` varchar(4) NOT NULL,
  `OCATD` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `language`
--

CREATE TABLE `language` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `language_id` int(11) NOT NULL COMMENT 'Иностранный язык'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `legal_entity`
--

CREATE TABLE `legal_entity` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `postcode` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `address_postcode` text COLLATE utf8_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `bik` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `ogrn` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `inn` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `fio` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `position` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `footing` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `requisites` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `p_c` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `k_c` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `region` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Регион',
  `district` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Район',
  `city` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Город',
  `village` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Посёлок',
  `street` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Улица',
  `house` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Дом',
  `housing` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Корпус',
  `building` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Строение',
  `flat` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Квартира',
  `surname` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Фамилия',
  `first_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Имя',
  `patronymic` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Отчество',
  `bank` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Отделение банка'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `links`
--

CREATE TABLE `links` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL,
  `href` text NOT NULL,
  `category_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `management_task`
--

CREATE TABLE `management_task` (
  `post_rate_id` int(11) NOT NULL,
  `dict_task_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `management_user`
--

CREATE TABLE `management_user` (
  `post_rate_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `is_assistant` tinyint(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `masters`
--

CREATE TABLE `masters` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL,
  `status` text NOT NULL,
  `faculty_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `master_class`
--

CREATE TABLE `master_class` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL,
  `master_id` int(11) NOT NULL,
  `aud_number` varchar(32) NOT NULL,
  `time_start` datetime NOT NULL,
  `time_finish` datetime NOT NULL,
  `dod_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `menu`
--

CREATE TABLE `menu` (
  `id` int(11) NOT NULL,
  `name` varchar(128) NOT NULL,
  `parent` int(11) DEFAULT NULL,
  `route` varchar(255) DEFAULT NULL,
  `order` int(11) DEFAULT NULL,
  `data` blob
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `migration`
--

CREATE TABLE `migration` (
  `version` varchar(180) NOT NULL,
  `apply_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `migration`
--

INSERT INTO `migration` (`version`, `apply_time`) VALUES
('m130524_201442_init', 1583675866),
('m161014_074944_moderation', 1583675866),
('m161014_074944_update_moderation', 1583675866),
('m190124_110200_add_verification_token_column_to_user_table', 1583675866),
('m190124_110201_add_photo_column_to_dict_chairmans_table', 1583675866),
('m190124_110202_table_olympic_list', 1583675866),
('m190124_110203_table_olympic_update_column_status', 1583675866),
('m190124_110204_table_olympic_drop_column', 1583675866),
('m190124_110205_add_dateup_and_columns_to_user_school_table', 1583676081),
('m190124_110206_drop_dateup_and_columns_to_user_school_table', 1583676083),
('m190124_110207_add_eduyear_columns_to_user_school_table', 1583675866),
('m190124_110208_alter_column_to_year_olympic_list_table', 1583676101),
('m190124_110209_drop_and_add_column_to_year_olympic_list_table', 1583676102),
('m190124_110210_add_id_columns_to_user_school_table', 1583675866),
('m190124_110211_drop_and_add_column_to_year_olympic_list_table', 1583676131),
('m190124_110212_key_drop_in_table_olympic_nomination', 1583675866),
('m190124_110213_key_drop_in_table_special_type_olimpic', 1583675866),
('m190124_110214_add_id_columns_to_user_olympiads', 1583675866),
('m190124_110215_add_id_columns_to_user_olympiads', 1583675866),
('m190124_110216_add_column_year_to_test_group_question_table', 1583675866),
('m190124_110216_add_year_columns_to_competitive_group', 1583675866),
('m190124_110217_key_drop_in_table_test', 1583675866),
('m190124_110217_update_edu_year_in_table_user_school', 1583676250),
('m190124_110218_add_id_columns_to_test_group', 1583676251),
('m190124_110218_add_range_column_to_table_olympiads_type_templates', 1583675866),
('m190124_110218_add_year_columns_to_table_olympiads_type_templates', 1583675866),
('m190124_110219_add_table_test_and_questions', 1583675866),
('m190124_110219_add_year_columns_to_table_templates', 1583675866),
('m190124_110220_add_column_test_id_table_test_and_questions', 1583675866),
('m190124_110220_add_id_columns_to_olympic_type_templates_table', 1583675866),
('m190124_110221_alter_mark_to_test_questions_table', 1583676361),
('m190124_110222_alter_options_to_test_questions_table', 1583676361),
('m190124_110223_add_table_answer', 1583675866),
('m190124_110224_add_column_answer_match_table_answer', 1583675866),
('m190124_110225_add_table_question_proposition', 1583675866),
('m190124_110225_after_column_type_table_question_proposition', 1583676414),
('m190124_110226_add_table_answer_cloze', 1583675866),
('m190124_110227_add_mark_in_table_taq', 1583675866),
('m190124_110228_add_column_olympic_in_table_question', 1583675866),
('m190124_110229_after_columns_answer_match_and_name_in_table_answer', 1583676481),
('m190124_110230_update_questions_olympic', 1583676482),
('m190124_110232_alter_column_in_table_taq', 1583676482),
('m190124_110233_add_columns_in_test_result', 1583675866),
('m190124_110234_update_column_result_in_test_result', 1583676502),
('m190124_110238_key_drop_in_table_diploma', 1583675866),
('m190124_110238_key_drop_in_table_presence_att', 1583675866),
('m190124_110239_setting_mail', 1583675866),
('m190124_110242_add_columns_delivery_status_sending', 1583675866),
('m190124_110242_add_columns_settintg_email', 1583675866),
('m190124_110242_after_columns_delivery_status_sending', 1583676599),
('m190124_110242_alter_columns_sending', 1583675866),
('m190124_110242_alter_columns_sending_template', 1583675866),
('m190124_110244_alter_columns_delivery_status_sending', 1583675866),
('m190124_110250_add_table_web_conference', 1583675866),
('m190124_110265_add_columns_status_test_attempt', 1583675866),
('m190124_110275_add_columns_dict_faculty', 1583675866),
('m190124_110275_add_columns_in_table_dict_school', 1583675866),
('m190124_110275_add_columns_in_table_user_olympic', 1583676711),
('m190124_110275_add_data_in_table_auth_item', 1583675866),
('m190124_110275_add_role_column_in_table_profile', 1583675866),
('m190124_110277_add_columns_in_table_dict_school', 1583676742),
('m190124_110277_add_columns_in_table_moderation', 1583675866),
('m190124_110444_add_dict_schools_report_table', 1583675866),
('m190124_110444_add_teacher_class_user_table', 1583675866),
('m190124_110444_add_user_teacher_job_table', 1583675866),
('m190124_110446_add_and_drop_columns_in_table_dict_school', 1583675866),
('m190124_110447_add_hash_column_in_user_teacher_job_table', 1583675866),
('m190124_110488_add_columns_in_table_dict_school', 1583676841),
('m190124_110566_add_and_drop_columns_in_table_dict_school_report', 1583675866),
('m190124_111222_add_columns_dict_faculty', 1592349035),
('m190124_111222_add_columns_speciality', 1592349035),
('m190124_119999_add_declination_fio', 1583675866),
('m190124_144584_drop_columns_in_table_user_olympic', 1583676880),
('m191206_164533_moving_calculate_field', 1583675866),
('m191207_135028_add__manager_id_into_olimpic', 1583675866),
('m191208_000001_add_column_in_table_profile', 1583675866),
('m191208_000002_add_address', 1583676932),
('m191208_000003_add_columns_in_table_test', 1583675866),
('m191208_000004_add_passport_data', 1583676932),
('m191208_000005_add_document_education', 1583676932),
('m191208_000006_add_column_in_dod_date', 1592349037),
('m191208_000007_add_column_in_dod_date', 1592349510),
('m191208_000008_add_column_in_user_dod', 1592349501),
('m191208_000008_add_role_entrant', 1592349609),
('m191208_000009_add_column_in_dictionary_discipline', 1592349510),
('m191208_000010_add_column_in_dict_class', 1592349649),
('m191208_000015_add_columns_user_token_ais', 1592349821),
('m191208_000016_add_columns_discipline', 1595324031),
('m191208_000018_add_column_olympic', 1605113518),
('m191208_000019_add_column_olympic', 1605113518),
('m191208_000020_drop_column_olympic', 1605113518),
('m191208_000021_add_column_olympic', 1618230586),
('m191208_000022_add_column_olympic', 1618230586),
('m191208_000023_add_column_olympic', 1618230586),
('m191208_000024_add_columns_user_token', 1618326623),
('modules\\dictionary\\migrations\\m191208_000015_add_ais_id_into_dict_cse', 1592349776),
('modules\\dictionary\\migrations\\m191208_000015_add_table_dict_post_education', 1592349775),
('modules\\dictionary\\migrations\\m191208_000017_add_table_dict_foreign_language', 1592349775),
('modules\\dictionary\\migrations\\m191208_000019_add_table_dict_cse_subject', 1592349777),
('modules\\dictionary\\migrations\\m191208_000020_add_field_into_cg', 1592350020),
('modules\\dictionary\\migrations\\m191208_000021_add_cg_exam_ais', 1592350020),
('modules\\dictionary\\migrations\\m191208_000022_add_field_into_cg_exam', 1592349776),
('modules\\dictionary\\migrations\\m191208_000023_add_field_foreigner_status', 1592350048),
('modules\\dictionary\\migrations\\m191208_000024_add_dict_individual_achievement_document', 1592349770),
('modules\\dictionary\\migrations\\m191208_000025_add_dict_individual_achievement_cg', 1592350192),
('modules\\dictionary\\migrations\\m191208_000026_add_cathedra_cg', 1592349779),
('modules\\dictionary\\migrations\\m191208_000027_add_table_job_entrant', 1592350265),
('modules\\dictionary\\migrations\\m191208_000037_add_columns_job_entrant', 1592510655),
('modules\\dictionary\\migrations\\m191208_000038_add_table_examiner', 1594885910),
('modules\\dictionary\\migrations\\m191208_000039_add_table_examiner_discipline', 1594885911),
('modules\\dictionary\\migrations\\m191208_000040_add_columns_job_entrant', 1594885911),
('modules\\dictionary\\migrations\\m191208_000041_add_columns_job_entrant', 1597018169),
('modules\\dictionary\\migrations\\m191208_000042_add_columns_job_entrant', 1614096155),
('modules\\dictionary\\migrations\\m191208_000043_add_table_volunteering', 1614446578),
('modules\\dictionary\\migrations\\m191208_000044_add_columns_volunteering', 1615050308),
('modules\\dictionary\\migrations\\m191208_000045_add_table_setting_entrant', 1618230632),
('modules\\dictionary\\migrations\\m191208_000045_copy_table_dict_cse_subject', 1618231106),
('modules\\dictionary\\migrations\\m191208_000046_add_column_setting_entrant', 1618231107),
('modules\\dictionary\\migrations\\m191208_000046_add_column_table_dict_discipline', 1618231107),
('modules\\dictionary\\migrations\\m191208_000046_add_table_composite_discipline', 1618231107),
('modules\\dictionary\\migrations\\m191208_000049_add_column_setting_entrant', 1618231107),
('modules\\dictionary\\migrations\\m191208_000050_add_column_setting_entrant', 1618231107),
('modules\\dictionary\\migrations\\m191208_000051_add_table_setting_competition_list', 1618231107),
('modules\\dictionary\\migrations\\m191208_000052_rename_column_setting_competition_list', 1618231107),
('modules\\dictionary\\migrations\\m191208_000053_crop_column_setting_competition_list', 1618231107),
('modules\\dictionary\\migrations\\m200331_104158_table_dict_organization', 1592350265),
('modules\\dictionary\\migrations\\m200331_104159_add_colums_dict_organization', 1592350265),
('modules\\dictionary\\migrations\\m200331_104159_add_composite_dict_discipline', 1592350265),
('modules\\dictionary\\migrations\\m200331_104159_add_dvi_dict_discipline', 1592350265),
('modules\\dictionary\\migrations\\m200332_104159_add_only_spo_dict_competitive', 1593453166),
('modules\\entrant\\migrations\\m191208_000002_add_address', 1592349035),
('modules\\entrant\\migrations\\m191208_000004_add_passport_data', 1592349036),
('modules\\entrant\\migrations\\m191208_000005_add_document_education', 1592349511),
('modules\\entrant\\migrations\\m191208_000008_add_other_document', 1592349610),
('modules\\entrant\\migrations\\m191208_000009_add_anketa', 1592349649),
('modules\\entrant\\migrations\\m191208_000010_add_dict_category', 1592349649),
('modules\\entrant\\migrations\\m191208_000010_add_language', 1592349640),
('modules\\entrant\\migrations\\m191208_000011_add_cse_subject_result', 1592349774),
('modules\\entrant\\migrations\\m191208_000012_add_submitted_documents', 1592349774),
('modules\\entrant\\migrations\\m191208_000013_add_ecp', 1592349777),
('modules\\entrant\\migrations\\m191208_000014_add_rename_ecp', 1592349770),
('modules\\entrant\\migrations\\m191208_000015_add_column_document_education', 1592350535),
('modules\\entrant\\migrations\\m191208_000016_add_rename_table_ecp', 1592349779),
('modules\\entrant\\migrations\\m191208_000017_add_columns_other_document', 1592350561),
('modules\\entrant\\migrations\\m191208_000017_add_user_id', 1592350561),
('modules\\entrant\\migrations\\m191208_000018_update_date_other_document', 1592350561),
('modules\\entrant\\migrations\\m191208_000019_add_columns_document_education', 1592350561),
('modules\\entrant\\migrations\\m191208_000019_add_column_user_cg', 1592350561),
('modules\\entrant\\migrations\\m191208_000020_drop_column_other_document', 1592350561),
('modules\\entrant\\migrations\\m191208_000021_drop_column_user_cg', 1592350561),
('modules\\entrant\\migrations\\m191208_000022_add_agreement', 1592350562),
('modules\\entrant\\migrations\\m191208_000023_add_columns_passport_data', 1592350562),
('modules\\entrant\\migrations\\m191208_000024_add_columns_other_document', 1592350562),
('modules\\entrant\\migrations\\m191208_000025_add_columns_submitted_documents', 1592350562),
('modules\\entrant\\migrations\\m191208_000026_add_cse_vi_select', 1592350562),
('modules\\entrant\\migrations\\m191208_000027_add_statement', 1592350562),
('modules\\entrant\\migrations\\m191208_000028_rename_columns_special_right', 1592350562),
('modules\\entrant\\migrations\\m191208_000029_add_additional_information', 1592350562),
('modules\\entrant\\migrations\\m191208_000030_add_preemptive_right', 1592350562),
('modules\\entrant\\migrations\\m191208_000031_add_columns_statement', 1592350562),
('modules\\entrant\\migrations\\m191208_000031_add_univer_choice', 1592350562),
('modules\\entrant\\migrations\\m191208_000032_add_statement_cg', 1592350563),
('modules\\entrant\\migrations\\m191208_000033_add_column_files', 1592350563),
('modules\\entrant\\migrations\\m191208_000034_add_column_files', 1592350560),
('modules\\entrant\\migrations\\m191208_000034_add_column_provinces_num', 1592350688),
('modules\\entrant\\migrations\\m191208_000035_add_columns_statement', 1592350688),
('modules\\entrant\\migrations\\m191208_000037_add_fio_latin', 1592350688),
('modules\\entrant\\migrations\\m191208_000038_add_statementIA', 1592350688),
('modules\\entrant\\migrations\\m191208_000039_add_statement_ia', 1592350688),
('modules\\entrant\\migrations\\m191208_000040_add_statement_consent_cg', 1592350688),
('modules\\entrant\\migrations\\m191208_000041_add_statement_consent_pd', 1592350688),
('modules\\entrant\\migrations\\m191208_000042_add_column_files', 1592350680),
('modules\\entrant\\migrations\\m191208_000043_add_columns_statement_consent_cg', 1592350713),
('modules\\entrant\\migrations\\m191208_000044_add_columns_statement_consent_pd', 1592350713),
('modules\\entrant\\migrations\\m191208_000045_add_columns_statement', 1592350713),
('modules\\entrant\\migrations\\m191208_000046_add_columns_statement_ia', 1592350713),
('modules\\entrant\\migrations\\m191208_000047_add_columns_other_document', 1592350713),
('modules\\entrant\\migrations\\m191208_000048_add_columns_information', 1592350713),
('modules\\entrant\\migrations\\m191208_000049_add_user_ais_return_data', 1592350713),
('modules\\entrant\\migrations\\m191208_000050_add_columns_user_cg', 1592350714),
('modules\\entrant\\migrations\\m191208_000051_add_columns_statement_cg', 1592350714),
('modules\\entrant\\migrations\\m191208_000052_add_columns_information', 1592350714),
('modules\\entrant\\migrations\\m191208_000053_add_statement_rejection', 1592350714),
('modules\\entrant\\migrations\\m191208_000054_add_user_ais', 1592350714),
('modules\\entrant\\migrations\\m191208_000055_add_statement_rejection_cg_consent', 1592350714),
('modules\\entrant\\migrations\\m191208_000056_add_columns_statement_cg', 1592350714),
('modules\\entrant\\migrations\\m191208_000057_add_columns_statement_rejection', 1592350714),
('modules\\entrant\\migrations\\m191208_000057_add_legal_entity', 1592350714),
('modules\\entrant\\migrations\\m191208_000057_add_personal_entity', 1592350714),
('modules\\entrant\\migrations\\m191208_000057_add_receipt', 1594328586),
('modules\\entrant\\migrations\\m191208_000057_add_statement_agreement_contract_cg_consent', 1592350714),
('modules\\entrant\\migrations\\m191208_000058_add_columns_legal_entity', 1592350714),
('modules\\entrant\\migrations\\m191208_000059_add_columns_statement', 1592350715),
('modules\\entrant\\migrations\\m191208_000060_add_columns_statement_agreement_contract_cg_consent', 1592350715),
('modules\\entrant\\migrations\\m191208_000062_add_columns_statement_rejection', 1592350715),
('modules\\entrant\\migrations\\m191208_000062_add_statement_rejection_cg', 1592350715),
('modules\\entrant\\migrations\\m191208_000063_add_columns_statement_rejection_consent', 1592350715),
('modules\\entrant\\migrations\\m191208_000064_add_columns_LegalEntity', 1592350715),
('modules\\entrant\\migrations\\m191208_000064_add_columns_statement_rejection_consent', 1592350715),
('modules\\entrant\\migrations\\m191208_000065_add_columns_ia', 1592350715),
('modules\\entrant\\migrations\\m191208_000065_add_statement_rejection_cg', 1592350715),
('modules\\entrant\\migrations\\m191208_000066_add_statement_rejection', 1592350715),
('modules\\entrant\\migrations\\m191208_000068_add_columns_agreement', 1592350715),
('modules\\entrant\\migrations\\m191208_000069_add_columns_Anketa', 1592350715),
('modules\\entrant\\migrations\\m191208_000070_add_columns_statement_agreement', 1594328586),
('modules\\entrant\\migrations\\m191208_000075_add_column_rec', 1594328586),
('modules\\entrant\\migrations\\m191208_000075_add_preemptive_right', 1594328586),
('modules\\entrant\\migrations\\m191208_000077_add_statement_rejection', 1592350715),
('modules\\entrant\\migrations\\m191208_000077_add_statement_rejection_cg', 1592350715),
('modules\\entrant\\migrations\\m191208_000077_add_statement_rejection_consent', 1592350715),
('modules\\entrant\\migrations\\m191208_000077_altre_column', 1592677436),
('modules\\entrant\\migrations\\m191208_000078_add_columns_legal_entity', 1594328586),
('modules\\entrant\\migrations\\m191208_000078_add_columns_personal_entity', 1594328587),
('modules\\entrant\\migrations\\m191208_000079_add_columns_legal_entity', 1594328587),
('modules\\entrant\\migrations\\m191208_000079_add_columns_personal_entity', 1594328587),
('modules\\entrant\\migrations\\m191208_000080_add_columns_personal_entity', 1594328587),
('modules\\entrant\\migrations\\m191208_000080_add_columns_statement_agreement', 1594328587),
('modules\\entrant\\migrations\\m191208_000081_add_columns_personal_entity', 1594328587),
('modules\\entrant\\migrations\\m191208_000082_add_columns_receipt', 1594328587),
('modules\\entrant\\migrations\\m191208_000083_add_columns_dict_competitive', 1594328587),
('modules\\entrant\\migrations\\m191208_000083_add_columns_statement_agreement', 1594328587),
('modules\\entrant\\migrations\\m191208_000084_add_columns_receipt', 1594328587),
('modules\\entrant\\migrations\\m191208_000087_add_columns_other_document', 1594328587),
('modules\\entrant\\migrations\\m191208_000088_add_columns_information', 1595575096),
('modules\\entrant\\migrations\\m191208_000088_add_columns_without_appendix', 1595198057),
('modules\\entrant\\migrations\\m191208_000100_add_statement_rejection_cg', 1598269067),
('modules\\entrant\\migrations\\m191208_000101_add_columns_statement_rejection_cg', 1598307140),
('modules\\entrant\\migrations\\m191208_000102_rename_univer_choice', 1618230601),
('modules\\entrant\\migrations\\m191208_000103_add_table_discipline_user', 1618230601),
('modules\\entrant\\migrations\\m191208_000104_add_table_insurance_certificate', 1618230601),
('modules\\exam\\migrations\\m191333_000001_add_exam', 1594885918),
('modules\\exam\\migrations\\m191333_000002_add_exam_question_group', 1594885918),
('modules\\exam\\migrations\\m191333_000003_add_exam_question', 1594885918),
('modules\\exam\\migrations\\m191333_000004_add_exam_answer', 1594885918),
('modules\\exam\\migrations\\m191333_000005_add_exam_question_nested', 1594885919),
('modules\\exam\\migrations\\m191333_000006_add_exam_answer_nested', 1594885919),
('modules\\exam\\migrations\\m191333_000007_add_exam_test', 1594885919),
('modules\\exam\\migrations\\m191333_000008_add_exam_question_in_test', 1594885919),
('modules\\exam\\migrations\\m191333_000009_add_exam_attempt', 1594885919),
('modules\\exam\\migrations\\m191333_000010_add_exam_result', 1594885919),
('modules\\exam\\migrations\\m191333_000011_alter_column_exam', 1594885920),
('modules\\exam\\migrations\\m191333_000012_alter_columns_exam_question_group', 1594885920),
('modules\\exam\\migrations\\m191333_000013_alter_columns_exam_question', 1594885920),
('modules\\exam\\migrations\\m191333_000014_add_exam_result', 1594885920),
('modules\\exam\\migrations\\m191333_000015_add_exam_statement', 1595575097),
('modules\\exam\\migrations\\m191333_000016_add_columns_statement', 1595575097),
('modules\\exam\\migrations\\m191333_000017_add_columns_attempt', 1595575097),
('modules\\exam\\migrations\\m191333_000018_add_exam_violation', 1595575097),
('modules\\exam\\migrations\\m191333_000019_add_columns_attempt', 1595575097),
('modules\\exam\\migrations\\m191333_000020_add_columns_statement', 1596310795),
('modules\\exam\\migrations\\m191333_000021_add_columns_exam', 1599421174),
('modules\\exam\\migrations\\m191334_000019_add_colums_result', 1595575097),
('modules\\management\\migrations\\m191208_001222_add_table_schedule', 1613549220),
('modules\\management\\migrations\\m191208_001223_add_columns_schedule', 1613549221),
('modules\\management\\migrations\\m191208_001224_add_table_dict_task', 1613549221),
('modules\\management\\migrations\\m191208_001225_add_columns_dict_task', 1613549221),
('modules\\management\\migrations\\m191208_001226_add_table_task', 1613549221),
('modules\\management\\migrations\\m191208_001227_add_columns_task', 1613549221),
('modules\\management\\migrations\\m191208_001228_rename_add_columns_schedule', 1613549221),
('modules\\management\\migrations\\m191208_001229_add_table_post_management', 1613549221),
('modules\\management\\migrations\\m191208_001230_add_post_manager_task', 1613549222),
('modules\\management\\migrations\\m191208_001231_add_post_manager_user', 1613549222),
('modules\\management\\migrations\\m191208_001232_create_table_history_task', 1613549222),
('modules\\management\\migrations\\m191208_001233_add_columns_task', 1613549222),
('modules\\management\\migrations\\m191208_001234_add_table_dict_department', 1613549222),
('modules\\management\\migrations\\m191208_001235_drop_columns_schedule', 1613549222),
('modules\\management\\migrations\\m191208_001236_add_table_post_rate_department', 1613549222),
('modules\\management\\migrations\\m191208_001237_drop_post_manager_task', 1613549223),
('modules\\management\\migrations\\m191208_001238_drop_post_manager_user', 1613549223),
('modules\\management\\migrations\\m191208_001239_add_table_comment_task', 1613549223),
('modules\\management\\migrations\\m191208_001240_add_columns_schedule', 1613549223),
('modules\\management\\migrations\\m191208_001241_rename_column_schedule', 1613549223),
('modules\\management\\migrations\\m191208_001242_add_column_dict_department', 1613549223),
('modules\\management\\migrations\\m191208_001243_add_column_dict_department', 1613558795),
('modules\\management\\migrations\\m191208_001244_add_columns_dict_task', 1613558796),
('modules\\management\\migrations\\m191208_001245_add_columns_dict_task', 1613558796),
('modules\\management\\migrations\\m191208_001246_add_column_post_management', 1613559560),
('modules\\management\\migrations\\m191208_001247_add_table_day_off', 1614336297),
('modules\\management\\migrations\\m191208_001248_add_table_date_work', 1614336297),
('modules\\management\\migrations\\m191208_001249_add_column_date_work', 1614336297),
('modules\\management\\migrations\\m191208_001250_add_table_feast_date', 1614336297),
('modules\\management\\migrations\\m191208_001251_add_columns_dict_task', 1614676252),
('modules\\management\\migrations\\m191208_001252_drop_columns_dict_task', 1614676252),
('modules\\management\\migrations\\m191208_001253_add_columns_post_rate_department', 1614676252),
('modules\\management\\migrations\\m191208_001254_add_columns_management_user', 1615391619),
('modules\\management\\migrations\\m191208_001255_add_primary_management_user', 1615391619),
('modules\\management\\migrations\\m191208_001256_add_table_category_document', 1615822467),
('modules\\management\\migrations\\m191208_001257_add_table_registry_document', 1615822467),
('modules\\management\\migrations\\m191208_001258_add_column_registry_document', 1616082758),
('modules\\management\\migrations\\m191208_001259_add_table_task_document', 1616082758),
('modules\\management\\migrations\\m191208_001260_add_columns_registry_document', 1616082758),
('modules\\management\\migrations\\m191208_001261_add_primary_key_task_document', 1616082758),
('modules\\support\\migrations\\m180925_080718_init', 1594328586),
('yii\\queue\\db\\migrations\\M161119140200Queue', 1615391619),
('yii\\queue\\db\\migrations\\M170307170300Later', 1615391619),
('yii\\queue\\db\\migrations\\M170509001400Retry', 1615391619),
('yii\\queue\\db\\migrations\\M170601155600Priority', 1615391619);

-- --------------------------------------------------------

--
-- Структура таблицы `moderation`
--

CREATE TABLE `moderation` (
  `id` int(11) NOT NULL,
  `model` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `record_id` int(11) DEFAULT NULL,
  `action` smallint(6) DEFAULT NULL,
  `before` longtext COLLATE utf8_unicode_ci,
  `after` longtext COLLATE utf8_unicode_ci,
  `message` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `moderated_by` int(11) DEFAULT NULL,
  `status` smallint(6) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `olimpiads_type_templates`
--

CREATE TABLE `olimpiads_type_templates` (
  `id` int(11) NOT NULL,
  `number_of_tours` int(11) NOT NULL COMMENT 'количество туров',
  `form_of_passage` int(11) NOT NULL COMMENT 'Форма проведения',
  `edu_level_olimp` int(11) NOT NULL COMMENT 'Уровень олимпиады',
  `template_id` int(11) NOT NULL COMMENT 'шаблон',
  `special_type` int(11) DEFAULT NULL,
  `year` varchar(255) NOT NULL DEFAULT '2018-2019',
  `range` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Структура таблицы `olimpic`
--

CREATE TABLE `olimpic` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL COMMENT 'Полное название мероприятия',
  `type_of_calculate_sum` int(11) DEFAULT NULL COMMENT 'Тип расчета итогового балла, 1- подсчет баллов осуществляется отдельно по турам, 2 - в последнем туре подводятся итоги всех туров.',
  `status` smallint(6) DEFAULT '0',
  `managerId` int(11) DEFAULT NULL COMMENT 'отвественный за олимпиаду'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `olimpic_cg`
--

CREATE TABLE `olimpic_cg` (
  `olimpic_id` int(11) NOT NULL,
  `competitive_group_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `olimpic_list`
--

CREATE TABLE `olimpic_list` (
  `id` smallint(6) NOT NULL,
  `name` varchar(255) NOT NULL COMMENT 'Полное название мероприятия',
  `content` text,
  `promotion_text` text,
  `link` text,
  `genitive_name` varchar(255) NOT NULL,
  `list_position` int(11) DEFAULT NULL,
  `faculty_id` int(11) DEFAULT NULL,
  `prefilling` int(11) NOT NULL DEFAULT '0',
  `event_type` int(11) DEFAULT NULL COMMENT 'Выбор вида мероприятия',
  `only_mpgu_students` int(11) NOT NULL DEFAULT '0',
  `chairman_id` int(11) DEFAULT NULL COMMENT 'Председатель',
  `number_of_tours` int(11) DEFAULT NULL COMMENT 'Количество туров',
  `form_of_passage` int(11) DEFAULT NULL COMMENT 'Форма проведения',
  `edu_level_olymp` int(11) DEFAULT NULL COMMENT 'Уровень проведения олимпиад',
  `date_time_start_reg` datetime DEFAULT NULL COMMENT 'дата и время начала регистрации',
  `date_time_finish_reg` datetime DEFAULT NULL COMMENT 'дата и время окончания регистрации',
  `time_of_distants_tour` int(11) DEFAULT NULL COMMENT 'Продолжительность выполнения заданий заочного (дистанционного) тура',
  `date_time_start_tour` datetime DEFAULT NULL COMMENT 'Дата и время проведения очного тура',
  `address` text COMMENT 'Адрес проведения очного тура',
  `time_of_tour` int(11) DEFAULT NULL COMMENT 'Продолжительность очного тура в минутах',
  `required_documents` text,
  `requiment_to_work_of_distance_tour` text COMMENT 'Требование к выполнению работ заочного (дистанционного) тура (только если он был заявлен)',
  `requiment_to_work` text COMMENT 'Требование к выполнению работ очного тура',
  `criteria_for_evaluating_dt` text COMMENT 'Критерии оценивания работ заочного (дистанционного) тура',
  `criteria_for_evaluating` text COMMENT 'Требование к выполнению работ очного тура',
  `showing_works_and_appeal` int(11) DEFAULT NULL COMMENT 'Показ работ и апелляция (Предусмотрены / не предусмотрены)',
  `time_of_distants_tour_type` int(11) DEFAULT NULL,
  `type_of_calculate_sum` int(11) DEFAULT NULL COMMENT 'Тип расчета итогового балла, 1- подсчет баллов осуществляется отдельно по турам, 2 - в последнем туре подводятся итоги всех туров.',
  `auto_sum` int(11) DEFAULT NULL COMMENT 'Автоматическое суммирование баллов с заочным туром',
  `current_status` int(11) NOT NULL DEFAULT '0',
  `olimpic_id` int(11) NOT NULL,
  `certificate_id` int(11) DEFAULT NULL,
  `year` varchar(255) NOT NULL DEFAULT '2018-2019',
  `percent_to_calculate` int(11) DEFAULT '0' COMMENT 'Процент участников для перехода в следующий тур',
  `cg_no_visible` int(11) DEFAULT '0',
  `is_volunteering` tinyint(1) DEFAULT '0',
  `disabled_a` tinyint(1) DEFAULT '0',
  `is_remote` tinyint(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `olimpic_nomination`
--

CREATE TABLE `olimpic_nomination` (
  `id` int(11) NOT NULL,
  `olimpic_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `olimpic_old`
--

CREATE TABLE `olimpic_old` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL COMMENT 'Полное название мероприятия',
  `content` text,
  `promotion_text` text,
  `link` text,
  `genitive_name` varchar(255) NOT NULL,
  `list_position` int(11) DEFAULT NULL,
  `faculty_id` int(11) DEFAULT NULL,
  `prefilling` int(11) NOT NULL DEFAULT '0',
  `event_type` int(11) DEFAULT NULL COMMENT 'Выбор вида мероприятия',
  `only_mpgu_students` int(11) NOT NULL DEFAULT '0',
  `chairman_id` int(11) DEFAULT NULL COMMENT 'Председатель',
  `number_of_tours` int(11) DEFAULT NULL COMMENT 'Количество туров',
  `form_of_passage` int(11) DEFAULT NULL COMMENT 'Форма проведения',
  `edu_level_olymp` int(11) DEFAULT NULL COMMENT 'Уровень проведения олимпиад',
  `date_time_start_reg` datetime DEFAULT NULL COMMENT 'дата и время начала регистрации',
  `date_time_finish_reg` datetime DEFAULT NULL COMMENT 'дата и время окончания регистрации',
  `time_of_distants_tour` int(11) DEFAULT NULL COMMENT 'Продолжительность выполнения заданий заочного (дистанционного) тура',
  `date_time_start_tour` datetime DEFAULT NULL COMMENT 'Дата и время проведения очного тура',
  `address` text COMMENT 'Адрес проведения очного тура',
  `time_of_tour` int(11) DEFAULT NULL COMMENT 'Продолжительность очного тура в минутах',
  `required_documents` text,
  `requiment_to_work_of_distance_tour` text COMMENT 'Требование к выполнению работ заочного (дистанционного) тура (только если он был заявлен)',
  `requiment_to_work` text COMMENT 'Требование к выполнению работ очного тура',
  `criteria_for_evaluating_dt` text COMMENT 'Критерии оценивания работ заочного (дистанционного) тура',
  `criteria_for_evaluating` text COMMENT 'Требование к выполнению работ очного тура',
  `showing_works_and_appeal` int(11) DEFAULT NULL COMMENT 'Показ работ и апелляция (Предусмотрены / не предусмотрены)',
  `time_of_distants_tour_type` int(11) DEFAULT NULL,
  `type_of_calculate_sum` int(11) DEFAULT NULL COMMENT 'Тип расчета итогового балла, 1- подсчет баллов осуществляется отдельно по турам, 2 - в последнем туре подводятся итоги всех туров.',
  `auto_sum` int(11) DEFAULT NULL COMMENT 'Автоматическое суммирование баллов с заочным туром',
  `status` int(11) NOT NULL DEFAULT '0',
  `certificate_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `other_document`
--

CREATE TABLE `other_document` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `type` tinyint(4) DEFAULT NULL COMMENT 'Тип документа',
  `series` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Серия',
  `number` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Номер',
  `date` date DEFAULT NULL COMMENT 'От',
  `authority` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Кем выдан',
  `amount` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Количество',
  `exemption_id` int(11) DEFAULT NULL COMMENT 'Категория льготы',
  `note` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Примечание',
  `type_note` int(11) DEFAULT NULL COMMENT 'Тип примечание',
  `without` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `passport_data`
--

CREATE TABLE `passport_data` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `nationality` int(11) NOT NULL COMMENT 'Гражданство',
  `type` tinyint(4) DEFAULT NULL COMMENT 'Тип документа',
  `series` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Серия',
  `number` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Номер',
  `date_of_birth` date DEFAULT NULL COMMENT 'Дата рождения',
  `place_of_birth` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Место рождения',
  `date_of_issue` date DEFAULT NULL COMMENT 'Дата выдачи',
  `authority` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Кем выдан',
  `division_code` varchar(7) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Код подразделения',
  `main_status` int(11) DEFAULT '0' COMMENT 'Основной документ'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `personal_entity`
--

CREATE TABLE `personal_entity` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `postcode` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `series` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Серия',
  `number` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Номер',
  `date_of_issue` date DEFAULT NULL COMMENT 'Дата выдачи',
  `authority` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Кем выдан',
  `phone` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `region` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Регион',
  `district` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Район',
  `city` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Город',
  `village` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Посёлок',
  `street` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Улица',
  `house` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Дом',
  `housing` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Корпус',
  `building` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Строение',
  `flat` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Квартира',
  `surname` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Фамилия',
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Имя',
  `patronymic` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Отчество',
  `division_code` varchar(7) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Код подразделения'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `personal_presence_attempt`
--

CREATE TABLE `personal_presence_attempt` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `olimpic_id` int(11) NOT NULL,
  `mark` decimal(4,1) DEFAULT NULL,
  `presence_status` int(11) DEFAULT NULL,
  `reward_status` int(11) DEFAULT NULL,
  `nomination` int(11) DEFAULT NULL,
  `nomination_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Структура таблицы `polls`
--

CREATE TABLE `polls` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `poll_poll_answer`
--

CREATE TABLE `poll_poll_answer` (
  `poll_id` int(11) NOT NULL,
  `poll_answer_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `post_management`
--

CREATE TABLE `post_management` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `name_short` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `is_director` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `name_genitive` varchar(255) COLLATE utf8_unicode_ci DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `post_rate_department`
--

CREATE TABLE `post_rate_department` (
  `id` int(11) NOT NULL,
  `dict_department_id` int(11) DEFAULT NULL,
  `post_management_id` int(11) NOT NULL,
  `rate` int(11) NOT NULL,
  `template_file` varchar(255) COLLATE utf8_unicode_ci DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `preemptive_right`
--

CREATE TABLE `preemptive_right` (
  `other_id` int(11) NOT NULL,
  `type_id` int(11) NOT NULL,
  `statue_id` int(11) DEFAULT NULL,
  `message` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `profiles`
--

CREATE TABLE `profiles` (
  `id` int(11) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `patronymic` varchar(255) NOT NULL,
  `phone` varchar(25) NOT NULL,
  `country_id` int(11) DEFAULT NULL,
  `region_id` int(11) DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `role` int(11) DEFAULT '0',
  `gender` int(11) DEFAULT NULL COMMENT '1-мужской, 2-женский'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `profiles`
--

INSERT INTO `profiles` (`id`, `last_name`, `first_name`, `patronymic`, `phone`, `country_id`, `region_id`, `user_id`, `role`, `gender`) VALUES
(1, 'Рутов', 'Рут', 'Рутович', '+79670262728', 46, 77, 1, 0, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `question_proposition`
--

CREATE TABLE `question_proposition` (
  `id` int(11) NOT NULL,
  `quest_id` int(11) NOT NULL,
  `type` int(11) DEFAULT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `is_start` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `queue`
--

CREATE TABLE `queue` (
  `id` int(11) NOT NULL,
  `channel` varchar(255) NOT NULL,
  `job` blob NOT NULL,
  `pushed_at` int(11) NOT NULL,
  `ttr` int(11) NOT NULL,
  `delay` int(11) NOT NULL DEFAULT '0',
  `priority` int(10) UNSIGNED NOT NULL DEFAULT '1024',
  `reserved_at` int(11) DEFAULT NULL,
  `attempt` int(11) DEFAULT NULL,
  `done_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `receipt_contract`
--

CREATE TABLE `receipt_contract` (
  `id` int(11) NOT NULL,
  `contract_cg_id` int(11) NOT NULL,
  `period` int(11) NOT NULL,
  `count_pages` int(11) DEFAULT '0',
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  `bank` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `pay_sum` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `date` date DEFAULT NULL,
  `status_id` int(11) DEFAULT '0',
  `message` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `registry_document`
--

CREATE TABLE `registry_document` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `category_document_id` int(11) NOT NULL,
  `link` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `file` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `access` int(11) DEFAULT '1',
  `user_id` int(11) DEFAULT NULL,
  `dict_department_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `schedule`
--

CREATE TABLE `schedule` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `monday_even` varchar(11) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `monday_odd` varchar(11) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `tuesday_even` varchar(11) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `tuesday_odd` varchar(11) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `wednesday_even` varchar(11) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `wednesday_odd` varchar(11) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `thursday_even` varchar(11) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `thursday_odd` varchar(11) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `friday_even` varchar(11) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `friday_odd` varchar(11) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `saturday_even` varchar(11) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `saturday_odd` varchar(11) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `sunday_even` varchar(11) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `sunday_odd` varchar(11) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `vacation` tinyint(1) DEFAULT NULL,
  `isBlocked` tinyint(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `sending`
--

CREATE TABLE `sending` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `sending_category_id` int(11) DEFAULT NULL,
  `template_id` int(11) DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `status_id` int(11) NOT NULL COMMENT '0- не начиналась, 1- одобрена, 2- завершилась',
  `deadline` datetime NOT NULL COMMENT 'Директивный срок задачи',
  `type_id` int(11) DEFAULT NULL COMMENT '1 - олимпиада, 2 - ДОД, 3 - мастер-классы',
  `value` int(11) DEFAULT NULL COMMENT ' id события',
  `kind_sending_id` int(11) NOT NULL DEFAULT '1',
  `poll_id` int(11) DEFAULT NULL,
  `type_sending` int(11) DEFAULT NULL COMMENT '1 - приглашение, 2 - дипломы	'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `sending_delivery_status`
--

CREATE TABLE `sending_delivery_status` (
  `id` int(11) NOT NULL,
  `delivery_date_time` datetime DEFAULT NULL,
  `hash` varchar(255) NOT NULL,
  `sending_id` int(11) DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `status_id` int(11) NOT NULL COMMENT '1 - ожидание ответа, 2 - прочитано',
  `poll_answer_id` int(11) DEFAULT NULL,
  `poll_text` text,
  `date_time_poll_answer` datetime DEFAULT NULL,
  `type` int(11) NOT NULL DEFAULT '1' COMMENT '1 - олимпиада, 2 - ДОД, 3 - мастер-классы',
  `value` int(11) DEFAULT NULL,
  `type_sending` int(11) DEFAULT NULL COMMENT '1 - приглашение, 2 - дипломы	',
  `from_email` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `sending_user_category`
--

CREATE TABLE `sending_user_category` (
  `category_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Структура таблицы `setting_competition_list`
--

CREATE TABLE `setting_competition_list` (
  `se_id` int(11) NOT NULL,
  `date_start` date NOT NULL,
  `date_end` date NOT NULL,
  `time_start` time NOT NULL,
  `time_end` time NOT NULL,
  `time_start_week` time NOT NULL,
  `time_end_week` time NOT NULL,
  `interval` int(11) NOT NULL,
  `date_ignore` json DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `setting_email`
--

CREATE TABLE `setting_email` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `host` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `username` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `port` varchar(5) COLLATE utf8_unicode_ci NOT NULL,
  `encryption` varchar(3) COLLATE utf8_unicode_ci NOT NULL,
  `status` int(11) NOT NULL DEFAULT '0' COMMENT '0 - не проверена , 1 - проверена'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `setting_entrant`
--

CREATE TABLE `setting_entrant` (
  `id` int(11) NOT NULL,
  `type` int(11) DEFAULT NULL,
  `datetime_start` datetime NOT NULL,
  `datetime_end` datetime NOT NULL,
  `faculty_id` int(11) DEFAULT NULL,
  `edu_level` smallint(6) NOT NULL,
  `form_edu` smallint(6) NOT NULL,
  `finance_edu` smallint(6) NOT NULL,
  `special_right` smallint(6) DEFAULT NULL,
  `note` text COLLATE utf8_unicode_ci NOT NULL,
  `is_vi` tinyint(1) DEFAULT NULL,
  `foreign_status` tinyint(1) DEFAULT NULL,
  `tpgu_status` tinyint(1) DEFAULT NULL,
  `cse_as_vi` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `special_type_olimpic`
--

CREATE TABLE `special_type_olimpic` (
  `id` int(11) NOT NULL,
  `olimpic_id` int(11) NOT NULL,
  `special_type_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `statement`
--

CREATE TABLE `statement` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `faculty_id` int(11) NOT NULL,
  `speciality_id` int(11) NOT NULL,
  `edu_level` int(11) NOT NULL,
  `special_right` int(11) DEFAULT NULL,
  `counter` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `count_pages` int(11) DEFAULT '0' COMMENT 'количество страниц',
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  `message` text COLLATE utf8_unicode_ci,
  `form_category` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `statement_agreement_contract_cg`
--

CREATE TABLE `statement_agreement_contract_cg` (
  `id` int(11) NOT NULL,
  `statement_cg` int(11) NOT NULL,
  `status_id` int(11) DEFAULT NULL,
  `count_pages` int(11) DEFAULT '0',
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  `type` int(11) DEFAULT NULL,
  `record_id` int(11) DEFAULT NULL,
  `number` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `pdf_file` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `is_month` int(11) DEFAULT '0',
  `message` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `statement_cg`
--

CREATE TABLE `statement_cg` (
  `id` int(11) NOT NULL,
  `statement_id` int(11) NOT NULL,
  `cg_id` int(11) NOT NULL,
  `status_id` int(11) DEFAULT NULL,
  `cathedra_id` smallint(6) DEFAULT NULL,
  `count_pages` int(11) DEFAULT '0' COMMENT 'количество страниц'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `statement_consent_cg`
--

CREATE TABLE `statement_consent_cg` (
  `id` int(11) NOT NULL,
  `statement_cg_id` int(11) NOT NULL,
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `count_pages` int(11) DEFAULT '0' COMMENT 'количество страниц'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `statement_consent_personal_data`
--

CREATE TABLE `statement_consent_personal_data` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  `count_pages` int(11) DEFAULT '0' COMMENT 'количество страниц'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `statement_ia`
--

CREATE TABLE `statement_ia` (
  `id` int(11) NOT NULL,
  `statement_individual_id` int(11) NOT NULL,
  `individual_id` smallint(6) NOT NULL,
  `status_id` int(11) DEFAULT NULL,
  `message` text COLLATE utf8_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `statement_individual_achievements`
--

CREATE TABLE `statement_individual_achievements` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `edu_level` int(11) NOT NULL,
  `count_pages` int(11) DEFAULT '0' COMMENT 'количество страниц',
  `counter` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  `message` text COLLATE utf8_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `statement_rejection`
--

CREATE TABLE `statement_rejection` (
  `id` int(11) NOT NULL,
  `statement_id` int(11) NOT NULL,
  `status_id` int(11) DEFAULT '0',
  `count_pages` int(11) DEFAULT '0' COMMENT 'количество страниц',
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  `message` text COLLATE utf8_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `statement_rejection_cg`
--

CREATE TABLE `statement_rejection_cg` (
  `id` int(11) NOT NULL,
  `statement_cg` int(11) NOT NULL,
  `status_id` int(11) DEFAULT '0',
  `count_pages` int(11) DEFAULT '0',
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  `message` text COLLATE utf8_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `statement_rejection_cg_consent`
--

CREATE TABLE `statement_rejection_cg_consent` (
  `id` int(11) NOT NULL,
  `statement_cg_consent_id` int(11) NOT NULL,
  `status_id` int(11) DEFAULT '0',
  `count_pages` int(11) DEFAULT '0',
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  `message` text COLLATE utf8_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `statement_rejection_record`
--

CREATE TABLE `statement_rejection_record` (
  `id` int(11) NOT NULL,
  `cg_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `status` int(11) DEFAULT '0',
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  `count_pages` int(11) DEFAULT '0',
  `order_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `order_date` date NOT NULL,
  `pdf_file` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `submitted_documents`
--

CREATE TABLE `submitted_documents` (
  `user_id` int(11) NOT NULL,
  `type` int(11) DEFAULT NULL COMMENT 'Способ подачи',
  `date` date DEFAULT NULL COMMENT 'Дата',
  `status` int(11) NOT NULL COMMENT 'Статус'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `support_category`
--

CREATE TABLE `support_category` (
  `id` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` tinyint(4) NOT NULL,
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `support_ticket_content`
--

CREATE TABLE `support_ticket_content` (
  `id` int(11) NOT NULL,
  `id_ticket` int(11) NOT NULL,
  `content` text COLLATE utf8_unicode_ci NOT NULL,
  `info` text COLLATE utf8_unicode_ci,
  `mail_id` text COLLATE utf8_unicode_ci,
  `fetch_date` text COLLATE utf8_unicode_ci,
  `user_id` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `support_ticket_head`
--

CREATE TABLE `support_ticket_head` (
  `id` int(11) NOT NULL,
  `hash_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `type_id` tinyint(4) NOT NULL,
  `user_contact` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `user_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` tinyint(4) NOT NULL,
  `priority` tinyint(4) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `task`
--

CREATE TABLE `task` (
  `id` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `text` text COLLATE utf8_unicode_ci,
  `dict_task_id` int(11) NOT NULL,
  `director_user_id` int(11) NOT NULL,
  `responsible_user_id` int(11) NOT NULL,
  `position` int(11) NOT NULL DEFAULT '0',
  `date_begin` date NOT NULL,
  `date_end` datetime NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  `note` varchar(255) COLLATE utf8_unicode_ci DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `teacher_user_class`
--

CREATE TABLE `teacher_user_class` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `id_olympic_user` int(11) NOT NULL,
  `status` smallint(6) NOT NULL DEFAULT '0',
  `hash` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `templates`
--

CREATE TABLE `templates` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `type_id` int(11) NOT NULL,
  `text` text NOT NULL,
  `name_for_user` varchar(255) DEFAULT NULL,
  `year` varchar(255) NOT NULL DEFAULT '2018-2019'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `test`
--

CREATE TABLE `test` (
  `id` int(10) UNSIGNED NOT NULL COMMENT 'ID',
  `olimpic_id` int(11) NOT NULL COMMENT 'Олимпиада',
  `introduction` text NOT NULL COMMENT 'Вступление',
  `final_review` text NOT NULL COMMENT 'Итоговый отзыв',
  `type_calculate_id` int(11) DEFAULT NULL,
  `calculate_value` int(11) DEFAULT NULL,
  `without_category` int(11) DEFAULT NULL,
  `status` int(11) NOT NULL,
  `random_order` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Тест для Олимпиады' ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Структура таблицы `test_and_questions`
--

CREATE TABLE `test_and_questions` (
  `id` int(11) NOT NULL,
  `test_group_id` int(11) DEFAULT NULL,
  `question_id` int(11) DEFAULT NULL,
  `test_id` int(11) NOT NULL,
  `mark` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `test_attempt`
--

CREATE TABLE `test_attempt` (
  `id` int(10) UNSIGNED NOT NULL COMMENT 'ID',
  `user_id` int(11) NOT NULL COMMENT 'Пользователь',
  `start` datetime NOT NULL COMMENT 'Начало',
  `end` datetime DEFAULT NULL COMMENT 'Окончание',
  `test_id` int(10) UNSIGNED NOT NULL COMMENT 'Тест',
  `mark` decimal(4,1) DEFAULT NULL,
  `reward_status` int(11) DEFAULT NULL COMMENT 'результат попытки. 4 - участник следующего тура или просто учатник, 3- третье место, 2 - второе место, 1 - победитель, 5 победитель в номинации',
  `nomination_id` int(11) DEFAULT NULL,
  `automatic_status_id` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Прохождение теста (попытки)' ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Структура таблицы `test_class`
--

CREATE TABLE `test_class` (
  `test_id` int(10) UNSIGNED NOT NULL COMMENT 'Тест',
  `class_id` int(11) NOT NULL COMMENT 'Класс'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Классы для теста' ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Структура таблицы `test_group`
--

CREATE TABLE `test_group` (
  `test_id` int(10) UNSIGNED NOT NULL COMMENT 'Тест',
  `question_group_id` int(10) UNSIGNED NOT NULL COMMENT 'Группа вопросов'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Группы вопросов для конкретного теста';

-- --------------------------------------------------------

--
-- Структура таблицы `test_question`
--

CREATE TABLE `test_question` (
  `id` int(10) UNSIGNED NOT NULL COMMENT 'ID',
  `group_id` int(10) UNSIGNED DEFAULT NULL COMMENT 'Группа вопросов',
  `type_id` tinyint(3) UNSIGNED NOT NULL COMMENT 'Тип вопроса',
  `title` varchar(255) NOT NULL COMMENT 'Заголовок',
  `text` text NOT NULL COMMENT 'Вопрос',
  `mark` int(10) UNSIGNED DEFAULT NULL COMMENT 'Сумма первичных баллов',
  `options` text COMMENT 'Варианты',
  `file_type_id` tinyint(3) UNSIGNED DEFAULT NULL COMMENT 'Загружаемый тип файла',
  `test_id` int(11) DEFAULT NULL,
  `olympic_id` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Вопросы';

-- --------------------------------------------------------

--
-- Структура таблицы `test_question_group`
--

CREATE TABLE `test_question_group` (
  `id` int(10) UNSIGNED NOT NULL COMMENT 'ID',
  `olimpic_id` int(11) NOT NULL COMMENT 'Олимпиада',
  `name` varchar(255) NOT NULL COMMENT 'Имя',
  `year` varchar(255) NOT NULL DEFAULT '2018-2019'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Категории (группы) вопросов' ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Структура таблицы `test_result`
--

CREATE TABLE `test_result` (
  `attempt_id` int(10) UNSIGNED NOT NULL COMMENT 'Попытка',
  `question_id` int(10) UNSIGNED NOT NULL COMMENT 'Вопрос',
  `updated` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP COMMENT 'Обновление',
  `result` text COMMENT 'Результат',
  `mark` int(10) UNSIGNED DEFAULT NULL COMMENT 'Оценка',
  `priority` int(11) NOT NULL DEFAULT '0',
  `tq_id` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Тест Результаты';

-- --------------------------------------------------------

--
-- Структура таблицы `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `auth_key` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `password_hash` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password_reset_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `verification_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` smallint(6) NOT NULL DEFAULT '10',
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  `github` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `rememberMeDuration` int(11) DEFAULT NULL,
  `ais_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `user`
--

INSERT INTO `user` (`id`, `username`, `auth_key`, `password_hash`, `password_reset_token`, `email`, `verification_token`, `status`, `created_at`, `updated_at`, `github`, `rememberMeDuration`, `ais_token`) VALUES
(1, 'root', 'ZIDFFqOAkkx2jG3-_ZXw6vwuC5Gc9Hm9', '$2y$13$sdL4h37NCjqo5nhHfsCSzeLWx4VYc7BdjuAKBImPvipyYrK9FBnom', NULL, 'root@root.ru', '50yRGLzP4ne8LoM_-d_v-2HF_KK4JSyU_1619527227', 10, 1619527227, 1619527227, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `user-individual-achievements`
--

CREATE TABLE `user-individual-achievements` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL COMMENT 'ID пользователя',
  `individual_id` smallint(6) NOT NULL COMMENT 'ID индивидуального достижения',
  `document_id` int(11) NOT NULL COMMENT 'ID документа'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `user_ais`
--

CREATE TABLE `user_ais` (
  `user_id` int(11) NOT NULL,
  `incoming_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `user_cg`
--

CREATE TABLE `user_cg` (
  `user_id` int(11) NOT NULL,
  `cg_id` int(11) NOT NULL,
  `cathedra_id` smallint(6) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `user_dod`
--

CREATE TABLE `user_dod` (
  `user_id` int(11) NOT NULL,
  `dod_id` int(11) NOT NULL,
  `school_id` int(11) DEFAULT NULL,
  `status_edu` int(11) DEFAULT NULL,
  `count` int(11) DEFAULT NULL,
  `form_of_participation` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `user_faculty`
--

CREATE TABLE `user_faculty` (
  `user_id` int(11) NOT NULL,
  `faculty_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `user_firebase_token`
--

CREATE TABLE `user_firebase_token` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `user_master_class`
--

CREATE TABLE `user_master_class` (
  `user_id` int(11) NOT NULL,
  `master_class_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `user_olimpiads`
--

CREATE TABLE `user_olimpiads` (
  `id` int(11) NOT NULL,
  `olympiads_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `user_school`
--

CREATE TABLE `user_school` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `school_id` int(11) DEFAULT NULL,
  `class_id` int(11) NOT NULL,
  `edu_year` varchar(255) NOT NULL DEFAULT '2018/2019'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `user_sdo_token`
--

CREATE TABLE `user_sdo_token` (
  `user_id` int(11) NOT NULL,
  `token` varchar(32) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `user_teacher_job`
--

CREATE TABLE `user_teacher_job` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `school_id` int(11) NOT NULL,
  `status` smallint(6) NOT NULL DEFAULT '0',
  `hash` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `volunteering`
--

CREATE TABLE `volunteering` (
  `id` int(11) NOT NULL,
  `job_entrant_id` int(11) NOT NULL,
  `faculty_id` int(11) DEFAULT NULL,
  `form_edu` smallint(6) NOT NULL,
  `course_edu` int(11) NOT NULL,
  `number_edu` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `finance_edu` smallint(6) NOT NULL,
  `experience` tinyint(1) DEFAULT NULL,
  `clothes_type` smallint(6) NOT NULL,
  `clothes_size` varchar(5) COLLATE utf8_unicode_ci NOT NULL,
  `desire_work` json DEFAULT NULL,
  `link_vk` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `note` text COLLATE utf8_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `web_conference`
--

CREATE TABLE `web_conference` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `link` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `additional_information`
--
ALTER TABLE `additional_information`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx-additional_information-user` (`user_id`);

--
-- Индексы таблицы `address`
--
ALTER TABLE `address`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx-address-user` (`user_id`),
  ADD KEY `idx-address-country_id` (`country_id`);

--
-- Индексы таблицы `agreement`
--
ALTER TABLE `agreement`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx-agreement-user` (`user_id`),
  ADD KEY `idx-agreement-organization_id` (`organization_id`);

--
-- Индексы таблицы `ais_cg`
--
ALTER TABLE `ais_cg`
  ADD UNIQUE KEY `id` (`id`,`faculty_id`,`specialty_id`,`specialization_id`,`education_form_id`,`financing_type_id`,`special_right_id`,`year`) USING BTREE;

--
-- Индексы таблицы `ais_return_data`
--
ALTER TABLE `ais_return_data`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx-return_data-created_id` (`created_id`);

--
-- Индексы таблицы `ais_transfer_order`
--
ALTER TABLE `ais_transfer_order`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `ais_transfer_order_`
--
ALTER TABLE `ais_transfer_order_`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `ais_transfer_order_last`
--
ALTER TABLE `ais_transfer_order_last`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `ais_transfer_order__`
--
ALTER TABLE `ais_transfer_order__`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `anketa`
--
ALTER TABLE `anketa`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx-anketa-user` (`user_id`),
  ADD KEY `idx-passport-citizenship` (`citizenship_id`);

--
-- Индексы таблицы `answer`
--
ALTER TABLE `answer`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `answer_cloze`
--
ALTER TABLE `answer_cloze`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `auth`
--
ALTER TABLE `auth`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Индексы таблицы `auth_assignment`
--
ALTER TABLE `auth_assignment`
  ADD PRIMARY KEY (`item_name`,`user_id`,`created_at`);

--
-- Индексы таблицы `auth_item`
--
ALTER TABLE `auth_item`
  ADD PRIMARY KEY (`name`),
  ADD KEY `rule_name` (`rule_name`),
  ADD KEY `idx-auth_item-type` (`type`);

--
-- Индексы таблицы `auth_item_child`
--
ALTER TABLE `auth_item_child`
  ADD PRIMARY KEY (`parent`,`child`),
  ADD KEY `child` (`child`);

--
-- Индексы таблицы `auth_rule`
--
ALTER TABLE `auth_rule`
  ADD PRIMARY KEY (`name`);

--
-- Индексы таблицы `category_document`
--
ALTER TABLE `category_document`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `cathedra_cg`
--
ALTER TABLE `cathedra_cg`
  ADD UNIQUE KEY `idx-cathedra_cg-cat-cg` (`cathedra_id`,`cg_id`);

--
-- Индексы таблицы `cg_exam_ais`
--
ALTER TABLE `cg_exam_ais`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `class_and_olympic`
--
ALTER TABLE `class_and_olympic`
  ADD PRIMARY KEY (`class_id`,`olympic_id`),
  ADD KEY `olympic_id` (`olympic_id`);

--
-- Индексы таблицы `comment_task`
--
ALTER TABLE `comment_task`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx-comment_task-task_id` (`task_id`),
  ADD KEY `idx-comment_task-created_by` (`created_by`);

--
-- Индексы таблицы `composite_discipline`
--
ALTER TABLE `composite_discipline`
  ADD PRIMARY KEY (`discipline_id`,`discipline_select_id`),
  ADD KEY `idx-composite_discipline-discipline_select_id` (`discipline_select_id`),
  ADD KEY `idx-composite_discipline-discipline_id` (`discipline_id`);

--
-- Индексы таблицы `cse_subject_result`
--
ALTER TABLE `cse_subject_result`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx-cse_subject_result-user` (`user_id`);

--
-- Индексы таблицы `cse_vi_select`
--
ALTER TABLE `cse_vi_select`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx-cse_vi_select-user` (`user_id`);

--
-- Индексы таблицы `date_dod`
--
ALTER TABLE `date_dod`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `date_time` (`date_time`,`dod_id`);

--
-- Индексы таблицы `date_feast`
--
ALTER TABLE `date_feast`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `date_off`
--
ALTER TABLE `date_off`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx-date_off-schedule_id` (`schedule_id`);

--
-- Индексы таблицы `date_work`
--
ALTER TABLE `date_work`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `declination_fio`
--
ALTER TABLE `declination_fio`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx-declination_fio-user` (`user_id`);

--
-- Индексы таблицы `dict_category`
--
ALTER TABLE `dict_category`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx-dict-category-name` (`name`);

--
-- Индексы таблицы `dict_category_doc`
--
ALTER TABLE `dict_category_doc`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `dict_cathedra`
--
ALTER TABLE `dict_cathedra`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `dict_chairmans`
--
ALTER TABLE `dict_chairmans`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `dict_class`
--
ALTER TABLE `dict_class`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`,`type`);

--
-- Индексы таблицы `dict_competitive_group`
--
ALTER TABLE `dict_competitive_group`
  ADD PRIMARY KEY (`id`),
  ADD KEY `faculty_id` (`faculty_id`),
  ADD KEY `speciality_id` (`speciality_id`),
  ADD KEY `specialization_id` (`specialization_id`);

--
-- Индексы таблицы `dict_country`
--
ALTER TABLE `dict_country`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `dict_cse_subject`
--
ALTER TABLE `dict_cse_subject`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `dict_ct_subject`
--
ALTER TABLE `dict_ct_subject`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `dict_department`
--
ALTER TABLE `dict_department`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `dict_discipline`
--
ALTER TABLE `dict_discipline`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `ais_id` (`ais_id`);

--
-- Индексы таблицы `dict_examiner`
--
ALTER TABLE `dict_examiner`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `dict_faculty`
--
ALTER TABLE `dict_faculty`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `dict_foreign_language`
--
ALTER TABLE `dict_foreign_language`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `dict_incoming_document_type`
--
ALTER TABLE `dict_incoming_document_type`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `dict_individual_achievement`
--
ALTER TABLE `dict_individual_achievement`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `dict_individual_achievement_cg`
--
ALTER TABLE `dict_individual_achievement_cg`
  ADD PRIMARY KEY (`individual_achievement_id`,`competitive_group_id`),
  ADD KEY `idx-dia_cg-individual_achievement_id` (`individual_achievement_id`),
  ADD KEY `idx-dia_cg-competitive_group_id` (`competitive_group_id`);

--
-- Индексы таблицы `dict_individual_achievement_document`
--
ALTER TABLE `dict_individual_achievement_document`
  ADD PRIMARY KEY (`individual_achievement_id`,`document_type_id`),
  ADD KEY `idx-diad-individual_achievement_id` (`individual_achievement_id`);

--
-- Индексы таблицы `dict_organizations`
--
ALTER TABLE `dict_organizations`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `dict_poll_answers`
--
ALTER TABLE `dict_poll_answers`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `dict_post_education`
--
ALTER TABLE `dict_post_education`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `dict_region`
--
ALTER TABLE `dict_region`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `dict_schools`
--
ALTER TABLE `dict_schools`
  ADD PRIMARY KEY (`id`),
  ADD KEY `dict_educational_organizations_ibfk_1` (`region_id`),
  ADD KEY `country_id` (`country_id`),
  ADD KEY `idx-dict_school_report_id` (`dict_school_report_id`);

--
-- Индексы таблицы `dict_schools_pre_moderation`
--
ALTER TABLE `dict_schools_pre_moderation`
  ADD PRIMARY KEY (`id`),
  ADD KEY `dict_educational_organizations_ibfk_1` (`region_id`),
  ADD KEY `dict_school_id` (`dict_school_id`);

--
-- Индексы таблицы `dict_schools_report`
--
ALTER TABLE `dict_schools_report`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx-school_id_report` (`school_id`);

--
-- Индексы таблицы `dict_sending_template`
--
ALTER TABLE `dict_sending_template`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Индексы таблицы `dict_sending_user_category`
--
ALTER TABLE `dict_sending_user_category`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `dict_speciality`
--
ALTER TABLE `dict_speciality`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `code` (`code`);

--
-- Индексы таблицы `dict_specialization`
--
ALTER TABLE `dict_specialization`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `dict_special_type_olimpic`
--
ALTER TABLE `dict_special_type_olimpic`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `dict_task`
--
ALTER TABLE `dict_task`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `diploma`
--
ALTER TABLE `diploma`
  ADD PRIMARY KEY (`id`),
  ADD KEY `olimpic_id` (`olimpic_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Индексы таблицы `discipline_competitive_group`
--
ALTER TABLE `discipline_competitive_group`
  ADD PRIMARY KEY (`discipline_id`,`competitive_group_id`);

--
-- Индексы таблицы `discipline_user`
--
ALTER TABLE `discipline_user`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx-discipline_user-user_id` (`user_id`),
  ADD KEY `idx-discipline_user-discipline_select_id` (`discipline_select_id`),
  ADD KEY `idx-discipline_user-discipline_id` (`discipline_id`);

--
-- Индексы таблицы `documents`
--
ALTER TABLE `documents`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `document_education`
--
ALTER TABLE `document_education`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx-document-education-user` (`user_id`),
  ADD KEY `idx-document-education-school_id` (`school_id`),
  ADD KEY `idx-document-education-type` (`type`);

--
-- Индексы таблицы `document_task`
--
ALTER TABLE `document_task`
  ADD PRIMARY KEY (`document_registry_id`,`task_id`),
  ADD KEY `idx-document_task-document_registry_id` (`document_registry_id`),
  ADD KEY `idx-document_task-task_id` (`task_id`);

--
-- Индексы таблицы `dod`
--
ALTER TABLE `dod`
  ADD PRIMARY KEY (`id`),
  ADD KEY `faculty_id` (`faculty_id`);

--
-- Индексы таблицы `entrance_statistics`
--
ALTER TABLE `entrance_statistics`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `exam`
--
ALTER TABLE `exam`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx-exam-user` (`user_id`),
  ADD KEY `idx-exam-discipline_id` (`discipline_id`);

--
-- Индексы таблицы `examiner_discipline`
--
ALTER TABLE `examiner_discipline`
  ADD PRIMARY KEY (`discipline_id`),
  ADD KEY `idx-examiner_discipline-examiner_id` (`examiner_id`),
  ADD KEY `idx-examiner_discipline-discipline_id` (`discipline_id`);

--
-- Индексы таблицы `exam_answer`
--
ALTER TABLE `exam_answer`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx-exam_answer-question_id` (`question_id`);

--
-- Индексы таблицы `exam_answer_nested`
--
ALTER TABLE `exam_answer_nested`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx-exam_answer_nested-question_nested_id` (`question_nested_id`);

--
-- Индексы таблицы `exam_attempt`
--
ALTER TABLE `exam_attempt`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx-exam_attempt-exam_id` (`exam_id`),
  ADD KEY `idx-exam_attempt-user` (`user_id`),
  ADD KEY `idx-exam_attempt-test_id` (`test_id`);

--
-- Индексы таблицы `exam_question`
--
ALTER TABLE `exam_question`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx-exam_question-question_group_id` (`question_group_id`),
  ADD KEY `idx-exam_question-discipline_id` (`discipline_id`);

--
-- Индексы таблицы `exam_question_group`
--
ALTER TABLE `exam_question_group`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx-exam_question_group-discipline_id` (`discipline_id`);

--
-- Индексы таблицы `exam_question_in_test`
--
ALTER TABLE `exam_question_in_test`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx-exam_question_in_test-exam_id` (`test_id`),
  ADD KEY `idx-exam_question_in_test-question_group_id` (`question_group_id`),
  ADD KEY `idx-exam_question_in_test-question_id` (`question_id`);

--
-- Индексы таблицы `exam_question_nested`
--
ALTER TABLE `exam_question_nested`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx-exam_question_nested-question_id` (`question_id`);

--
-- Индексы таблицы `exam_result`
--
ALTER TABLE `exam_result`
  ADD PRIMARY KEY (`attempt_id`,`question_id`),
  ADD KEY `idx-exam_result-attempt_id` (`attempt_id`),
  ADD KEY `idx-exam_result-question_id` (`question_id`),
  ADD KEY `idx-exam_result-tq_id` (`tq_id`);

--
-- Индексы таблицы `exam_statement`
--
ALTER TABLE `exam_statement`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx-exam_statement-exam_id` (`exam_id`),
  ADD KEY `idx-exam_statement-entrant_user_id` (`entrant_user_id`),
  ADD KEY `idx-exam_statement-proctor_user_id` (`proctor_user_id`);

--
-- Индексы таблицы `exam_test`
--
ALTER TABLE `exam_test`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx-exam_test-exam_id` (`exam_id`);

--
-- Индексы таблицы `exam_violation`
--
ALTER TABLE `exam_violation`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx-exam_violation-exam_statement_id` (`exam_statement_id`);

--
-- Индексы таблицы `files`
--
ALTER TABLE `files`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx-ecp-user` (`user_id`);

--
-- Индексы таблицы `fio_latin`
--
ALTER TABLE `fio_latin`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx-fio_latin-user` (`user_id`);

--
-- Индексы таблицы `history_task`
--
ALTER TABLE `history_task`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx-history_task-task_id` (`task_id`),
  ADD KEY `idx-history_task-created_by` (`created_by`);

--
-- Индексы таблицы `infoda`
--
ALTER TABLE `infoda`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `infoda_`
--
ALTER TABLE `infoda_`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `insurance_certificate_user`
--
ALTER TABLE `insurance_certificate_user`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx-insurance_certificate_user-user_id` (`user_id`);

--
-- Индексы таблицы `invitation`
--
ALTER TABLE `invitation`
  ADD PRIMARY KEY (`id`),
  ADD KEY `olimpic_id` (`olimpic_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Индексы таблицы `job_entrant`
--
ALTER TABLE `job_entrant`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx-job_entrant-user` (`user_id`),
  ADD KEY `idx-job_entrant-faculty` (`faculty_id`),
  ADD KEY `idx-job_entrant-email_id` (`email_id`),
  ADD KEY `idx-job_entrant-examiner_id` (`examiner_id`);

--
-- Индексы таблицы `language`
--
ALTER TABLE `language`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx-language-user` (`user_id`),
  ADD KEY `idx-language-language_id` (`language_id`);

--
-- Индексы таблицы `legal_entity`
--
ALTER TABLE `legal_entity`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx-legal_entity-user_id` (`user_id`);

--
-- Индексы таблицы `links`
--
ALTER TABLE `links`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `management_task`
--
ALTER TABLE `management_task`
  ADD KEY `idx-management_task-post_rate_id` (`post_rate_id`),
  ADD KEY `idx-management_task-dict_task_id` (`dict_task_id`);

--
-- Индексы таблицы `management_user`
--
ALTER TABLE `management_user`
  ADD PRIMARY KEY (`user_id`,`post_rate_id`),
  ADD KEY `idx-management_user-post_rate_id` (`post_rate_id`),
  ADD KEY `idx-management_user-user_id` (`user_id`);

--
-- Индексы таблицы `masters`
--
ALTER TABLE `masters`
  ADD PRIMARY KEY (`id`),
  ADD KEY `faculty_id` (`faculty_id`);

--
-- Индексы таблицы `master_class`
--
ALTER TABLE `master_class`
  ADD PRIMARY KEY (`id`),
  ADD KEY `master_id` (`master_id`),
  ADD KEY `dod_id` (`dod_id`);

--
-- Индексы таблицы `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`id`),
  ADD KEY `parent` (`parent`);

--
-- Индексы таблицы `migration`
--
ALTER TABLE `migration`
  ADD PRIMARY KEY (`version`);

--
-- Индексы таблицы `moderation`
--
ALTER TABLE `moderation`
  ADD PRIMARY KEY (`id`),
  ADD KEY `created_by` (`created_by`);

--
-- Индексы таблицы `olimpiads_type_templates`
--
ALTER TABLE `olimpiads_type_templates`
  ADD PRIMARY KEY (`id`),
  ADD KEY `template_id` (`template_id`),
  ADD KEY `olimpiads_type_templates_ibfk_1` (`special_type`);

--
-- Индексы таблицы `olimpic`
--
ALTER TABLE `olimpic`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `olimpic_cg`
--
ALTER TABLE `olimpic_cg`
  ADD PRIMARY KEY (`olimpic_id`,`competitive_group_id`),
  ADD KEY `olimpic_cg_ibfk_1` (`competitive_group_id`);

--
-- Индексы таблицы `olimpic_list`
--
ALTER TABLE `olimpic_list`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `olimpic_nomination`
--
ALTER TABLE `olimpic_nomination`
  ADD PRIMARY KEY (`id`),
  ADD KEY `olimpic_nomination_ibfk_1` (`olimpic_id`);

--
-- Индексы таблицы `olimpic_old`
--
ALTER TABLE `olimpic_old`
  ADD PRIMARY KEY (`id`),
  ADD KEY `chairman_id` (`chairman_id`);

--
-- Индексы таблицы `other_document`
--
ALTER TABLE `other_document`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx-other_document-user` (`user_id`),
  ADD KEY `idx-other_document-type` (`type`);

--
-- Индексы таблицы `passport_data`
--
ALTER TABLE `passport_data`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx-passport-user` (`user_id`),
  ADD KEY `idx-passport-nationality` (`nationality`),
  ADD KEY `idx-passport-type` (`type`);

--
-- Индексы таблицы `personal_entity`
--
ALTER TABLE `personal_entity`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx-personal_entity-user_id` (`user_id`);

--
-- Индексы таблицы `personal_presence_attempt`
--
ALTER TABLE `personal_presence_attempt`
  ADD PRIMARY KEY (`id`),
  ADD KEY `olimpic_id` (`olimpic_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `nomination_id` (`nomination_id`);

--
-- Индексы таблицы `polls`
--
ALTER TABLE `polls`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `poll_poll_answer`
--
ALTER TABLE `poll_poll_answer`
  ADD PRIMARY KEY (`poll_id`,`poll_answer_id`),
  ADD KEY `poll_answer_id` (`poll_answer_id`);

--
-- Индексы таблицы `post_management`
--
ALTER TABLE `post_management`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `post_rate_department`
--
ALTER TABLE `post_rate_department`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx-post_rate_department-post_management_id` (`post_management_id`),
  ADD KEY `idx-post_rate_department-dict_department_id` (`dict_department_id`);

--
-- Индексы таблицы `preemptive_right`
--
ALTER TABLE `preemptive_right`
  ADD UNIQUE KEY `idx-preemptive_right-other_id-type_id` (`other_id`,`type_id`);

--
-- Индексы таблицы `profiles`
--
ALTER TABLE `profiles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `profiles_ibfk_1` (`user_id`),
  ADD KEY `country_id` (`country_id`);

--
-- Индексы таблицы `question_proposition`
--
ALTER TABLE `question_proposition`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `queue`
--
ALTER TABLE `queue`
  ADD PRIMARY KEY (`id`),
  ADD KEY `channel` (`channel`),
  ADD KEY `reserved_at` (`reserved_at`),
  ADD KEY `priority` (`priority`);

--
-- Индексы таблицы `receipt_contract`
--
ALTER TABLE `receipt_contract`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx-receipt_contract-contract_cg_id` (`contract_cg_id`);

--
-- Индексы таблицы `registry_document`
--
ALTER TABLE `registry_document`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx-registry-document-category_document_id` (`category_document_id`),
  ADD KEY `idx-registry_document-user_id` (`user_id`),
  ADD KEY `idx-registry_document-dict_department_id` (`dict_department_id`);

--
-- Индексы таблицы `schedule`
--
ALTER TABLE `schedule`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `idx-schedule-user` (`user_id`);

--
-- Индексы таблицы `sending`
--
ALTER TABLE `sending`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sending_category_id` (`sending_category_id`),
  ADD KEY `template_id` (`template_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Индексы таблицы `sending_delivery_status`
--
ALTER TABLE `sending_delivery_status`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `sending_user_category`
--
ALTER TABLE `sending_user_category`
  ADD PRIMARY KEY (`category_id`,`user_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Индексы таблицы `setting_competition_list`
--
ALTER TABLE `setting_competition_list`
  ADD PRIMARY KEY (`se_id`),
  ADD KEY `idx-setting_competition_list-se_id` (`se_id`);

--
-- Индексы таблицы `setting_email`
--
ALTER TABLE `setting_email`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `setting_entrant`
--
ALTER TABLE `setting_entrant`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `special_type_olimpic`
--
ALTER TABLE `special_type_olimpic`
  ADD PRIMARY KEY (`id`),
  ADD KEY `special_type_olimpic_ibfk_1` (`olimpic_id`),
  ADD KEY `special_type_id` (`special_type_id`);

--
-- Индексы таблицы `statement`
--
ALTER TABLE `statement`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx-statement-user` (`user_id`),
  ADD KEY `idx-statement-faculty_id` (`faculty_id`),
  ADD KEY `idx-statement-speciality_id` (`speciality_id`);

--
-- Индексы таблицы `statement_agreement_contract_cg`
--
ALTER TABLE `statement_agreement_contract_cg`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx-statement_agreement_contract_cg-statement_cg` (`statement_cg`);

--
-- Индексы таблицы `statement_cg`
--
ALTER TABLE `statement_cg`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx-statement_cg-statement_id` (`statement_id`),
  ADD KEY `idx-statement_cg-cg_id` (`cg_id`),
  ADD KEY `idx-statemnet_cg-cathedra_id` (`cathedra_id`);

--
-- Индексы таблицы `statement_consent_cg`
--
ALTER TABLE `statement_consent_cg`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx-statement_consent-statement_cg_id` (`statement_cg_id`);

--
-- Индексы таблицы `statement_consent_personal_data`
--
ALTER TABLE `statement_consent_personal_data`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx-statement_consent_pd-user` (`user_id`);

--
-- Индексы таблицы `statement_ia`
--
ALTER TABLE `statement_ia`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx-statement_ia-statement_individual_id` (`statement_individual_id`),
  ADD KEY `idx-statement_ia-individual_id` (`individual_id`);

--
-- Индексы таблицы `statement_individual_achievements`
--
ALTER TABLE `statement_individual_achievements`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx-statement_individual-user` (`user_id`);

--
-- Индексы таблицы `statement_rejection`
--
ALTER TABLE `statement_rejection`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx-statement_rejection-statement_id` (`statement_id`);

--
-- Индексы таблицы `statement_rejection_cg`
--
ALTER TABLE `statement_rejection_cg`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx-statement_rejection_cg-statement_cg` (`statement_cg`);

--
-- Индексы таблицы `statement_rejection_cg_consent`
--
ALTER TABLE `statement_rejection_cg_consent`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx-statement_rejection-consent-statement_id` (`statement_cg_consent_id`);

--
-- Индексы таблицы `statement_rejection_record`
--
ALTER TABLE `statement_rejection_record`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx-statement_rr-user` (`user_id`),
  ADD KEY `idx-statement_rr-cg_id` (`cg_id`);

--
-- Индексы таблицы `submitted_documents`
--
ALTER TABLE `submitted_documents`
  ADD UNIQUE KEY `user_id` (`user_id`),
  ADD KEY `idx-submitted_documents-user` (`user_id`);

--
-- Индексы таблицы `support_category`
--
ALTER TABLE `support_category`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `support_ticket_content`
--
ALTER TABLE `support_ticket_content`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_support_ticket_content_id-support_ticket_head_id` (`id_ticket`),
  ADD KEY `fk_support_ticket_content_user_id-user_id` (`user_id`);

--
-- Индексы таблицы `support_ticket_head`
--
ALTER TABLE `support_ticket_head`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `hash_id` (`hash_id`),
  ADD KEY `fk_support_ticket_head_user_id-user_id` (`user_id`),
  ADD KEY `fk_support_ticket_head_category-support_category_id` (`category_id`);

--
-- Индексы таблицы `task`
--
ALTER TABLE `task`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx-task-user` (`director_user_id`),
  ADD KEY `idx-task-dict_task_id` (`dict_task_id`),
  ADD KEY `idx-task-responsible_user` (`responsible_user_id`);

--
-- Индексы таблицы `teacher_user_class`
--
ALTER TABLE `teacher_user_class`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idxx-user` (`user_id`),
  ADD KEY `idxx-id_olympic_user` (`id_olympic_user`);

--
-- Индексы таблицы `templates`
--
ALTER TABLE `templates`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `test`
--
ALTER TABLE `test`
  ADD PRIMARY KEY (`id`),
  ADD KEY `olimpic_id` (`olimpic_id`);

--
-- Индексы таблицы `test_and_questions`
--
ALTER TABLE `test_and_questions`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `test_attempt`
--
ALTER TABLE `test_attempt`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_test` (`user_id`,`test_id`) USING BTREE,
  ADD KEY `test_id` (`test_id`),
  ADD KEY `nomination_id` (`nomination_id`);

--
-- Индексы таблицы `test_class`
--
ALTER TABLE `test_class`
  ADD PRIMARY KEY (`test_id`,`class_id`),
  ADD KEY `class_id` (`class_id`);

--
-- Индексы таблицы `test_group`
--
ALTER TABLE `test_group`
  ADD PRIMARY KEY (`test_id`,`question_group_id`),
  ADD KEY `test_group_ibfk_1` (`question_group_id`);

--
-- Индексы таблицы `test_question`
--
ALTER TABLE `test_question`
  ADD PRIMARY KEY (`id`),
  ADD KEY `group_id` (`group_id`);

--
-- Индексы таблицы `test_question_group`
--
ALTER TABLE `test_question_group`
  ADD PRIMARY KEY (`id`),
  ADD KEY `olimpic_id` (`olimpic_id`);

--
-- Индексы таблицы `test_result`
--
ALTER TABLE `test_result`
  ADD PRIMARY KEY (`attempt_id`,`question_id`),
  ADD KEY `test_result_ibfk_2` (`question_id`);

--
-- Индексы таблицы `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `password_reset_token` (`password_reset_token`),
  ADD UNIQUE KEY `email_confirm_token` (`verification_token`),
  ADD UNIQUE KEY `ais_token` (`ais_token`);

--
-- Индексы таблицы `user-individual-achievements`
--
ALTER TABLE `user-individual-achievements`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx-user_id` (`user_id`),
  ADD KEY `idx-individual_id` (`individual_id`),
  ADD KEY `fk-documents-key` (`document_id`);

--
-- Индексы таблицы `user_ais`
--
ALTER TABLE `user_ais`
  ADD UNIQUE KEY `idx-user_ais-user_id-incoming` (`user_id`,`incoming_id`);

--
-- Индексы таблицы `user_cg`
--
ALTER TABLE `user_cg`
  ADD PRIMARY KEY (`user_id`,`cg_id`),
  ADD KEY `cg_id` (`cg_id`),
  ADD KEY `idx-user_cg-cathedra_id` (`cathedra_id`);

--
-- Индексы таблицы `user_dod`
--
ALTER TABLE `user_dod`
  ADD PRIMARY KEY (`user_id`,`dod_id`),
  ADD KEY `dod_id` (`dod_id`),
  ADD KEY `school_id` (`school_id`),
  ADD KEY `status_edu` (`status_edu`);

--
-- Индексы таблицы `user_faculty`
--
ALTER TABLE `user_faculty`
  ADD PRIMARY KEY (`user_id`);

--
-- Индексы таблицы `user_firebase_token`
--
ALTER TABLE `user_firebase_token`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx-user_firebase_token` (`user_id`);

--
-- Индексы таблицы `user_master_class`
--
ALTER TABLE `user_master_class`
  ADD PRIMARY KEY (`user_id`,`master_class_id`),
  ADD KEY `master_class_id` (`master_class_id`);

--
-- Индексы таблицы `user_olimpiads`
--
ALTER TABLE `user_olimpiads`
  ADD PRIMARY KEY (`id`),
  ADD KEY `olympiads_id` (`olympiads_id`);

--
-- Индексы таблицы `user_school`
--
ALTER TABLE `user_school`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_id` (`user_id`,`school_id`,`class_id`,`edu_year`) USING BTREE,
  ADD KEY `class_id` (`class_id`),
  ADD KEY `user_school_ibfk_1` (`school_id`);

--
-- Индексы таблицы `user_sdo_token`
--
ALTER TABLE `user_sdo_token`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `user_id` (`user_id`),
  ADD KEY `idx-user_sdo_token` (`user_id`);

--
-- Индексы таблицы `user_teacher_job`
--
ALTER TABLE `user_teacher_job`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx-user` (`user_id`),
  ADD KEY `idx-school_id` (`school_id`);

--
-- Индексы таблицы `volunteering`
--
ALTER TABLE `volunteering`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx-volunteering-faculty` (`faculty_id`),
  ADD KEY `idx-volunteering-course_edu` (`course_edu`),
  ADD KEY `idx-volunteering-job_entrant_id` (`job_entrant_id`);

--
-- Индексы таблицы `web_conference`
--
ALTER TABLE `web_conference`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `additional_information`
--
ALTER TABLE `additional_information`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `address`
--
ALTER TABLE `address`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `agreement`
--
ALTER TABLE `agreement`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `ais_return_data`
--
ALTER TABLE `ais_return_data`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `ais_transfer_order`
--
ALTER TABLE `ais_transfer_order`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `ais_transfer_order_`
--
ALTER TABLE `ais_transfer_order_`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `ais_transfer_order_last`
--
ALTER TABLE `ais_transfer_order_last`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `ais_transfer_order__`
--
ALTER TABLE `ais_transfer_order__`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `anketa`
--
ALTER TABLE `anketa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `answer`
--
ALTER TABLE `answer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `answer_cloze`
--
ALTER TABLE `answer_cloze`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `auth`
--
ALTER TABLE `auth`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `category_document`
--
ALTER TABLE `category_document`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `cg_exam_ais`
--
ALTER TABLE `cg_exam_ais`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `comment_task`
--
ALTER TABLE `comment_task`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `cse_subject_result`
--
ALTER TABLE `cse_subject_result`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `cse_vi_select`
--
ALTER TABLE `cse_vi_select`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `date_dod`
--
ALTER TABLE `date_dod`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `date_feast`
--
ALTER TABLE `date_feast`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `date_off`
--
ALTER TABLE `date_off`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `date_work`
--
ALTER TABLE `date_work`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `declination_fio`
--
ALTER TABLE `declination_fio`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `dict_category`
--
ALTER TABLE `dict_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `dict_category_doc`
--
ALTER TABLE `dict_category_doc`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `dict_cathedra`
--
ALTER TABLE `dict_cathedra`
  MODIFY `id` smallint(6) NOT NULL AUTO_INCREMENT COMMENT 'ID';

--
-- AUTO_INCREMENT для таблицы `dict_chairmans`
--
ALTER TABLE `dict_chairmans`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `dict_class`
--
ALTER TABLE `dict_class`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `dict_competitive_group`
--
ALTER TABLE `dict_competitive_group`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `dict_country`
--
ALTER TABLE `dict_country`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID', AUTO_INCREMENT=241;

--
-- AUTO_INCREMENT для таблицы `dict_cse_subject`
--
ALTER TABLE `dict_cse_subject`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `dict_ct_subject`
--
ALTER TABLE `dict_ct_subject`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `dict_department`
--
ALTER TABLE `dict_department`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `dict_discipline`
--
ALTER TABLE `dict_discipline`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `dict_examiner`
--
ALTER TABLE `dict_examiner`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `dict_faculty`
--
ALTER TABLE `dict_faculty`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `dict_foreign_language`
--
ALTER TABLE `dict_foreign_language`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `dict_incoming_document_type`
--
ALTER TABLE `dict_incoming_document_type`
  MODIFY `id` tinyint(4) NOT NULL AUTO_INCREMENT COMMENT 'ID';

--
-- AUTO_INCREMENT для таблицы `dict_individual_achievement`
--
ALTER TABLE `dict_individual_achievement`
  MODIFY `id` smallint(6) NOT NULL AUTO_INCREMENT COMMENT 'ID';

--
-- AUTO_INCREMENT для таблицы `dict_organizations`
--
ALTER TABLE `dict_organizations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `dict_poll_answers`
--
ALTER TABLE `dict_poll_answers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `dict_post_education`
--
ALTER TABLE `dict_post_education`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `dict_region`
--
ALTER TABLE `dict_region`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=87;

--
-- AUTO_INCREMENT для таблицы `dict_schools`
--
ALTER TABLE `dict_schools`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `dict_schools_pre_moderation`
--
ALTER TABLE `dict_schools_pre_moderation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `dict_schools_report`
--
ALTER TABLE `dict_schools_report`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `dict_sending_template`
--
ALTER TABLE `dict_sending_template`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `dict_sending_user_category`
--
ALTER TABLE `dict_sending_user_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `dict_speciality`
--
ALTER TABLE `dict_speciality`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `dict_specialization`
--
ALTER TABLE `dict_specialization`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `dict_special_type_olimpic`
--
ALTER TABLE `dict_special_type_olimpic`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `dict_task`
--
ALTER TABLE `dict_task`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `diploma`
--
ALTER TABLE `diploma`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `discipline_user`
--
ALTER TABLE `discipline_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `documents`
--
ALTER TABLE `documents`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `document_education`
--
ALTER TABLE `document_education`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `dod`
--
ALTER TABLE `dod`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `entrance_statistics`
--
ALTER TABLE `entrance_statistics`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id';

--
-- AUTO_INCREMENT для таблицы `exam`
--
ALTER TABLE `exam`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `exam_answer`
--
ALTER TABLE `exam_answer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `exam_answer_nested`
--
ALTER TABLE `exam_answer_nested`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `exam_attempt`
--
ALTER TABLE `exam_attempt`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `exam_question`
--
ALTER TABLE `exam_question`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `exam_question_group`
--
ALTER TABLE `exam_question_group`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `exam_question_in_test`
--
ALTER TABLE `exam_question_in_test`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `exam_question_nested`
--
ALTER TABLE `exam_question_nested`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `exam_statement`
--
ALTER TABLE `exam_statement`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `exam_test`
--
ALTER TABLE `exam_test`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `exam_violation`
--
ALTER TABLE `exam_violation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `files`
--
ALTER TABLE `files`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `fio_latin`
--
ALTER TABLE `fio_latin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `history_task`
--
ALTER TABLE `history_task`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `infoda`
--
ALTER TABLE `infoda`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `infoda_`
--
ALTER TABLE `infoda_`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `insurance_certificate_user`
--
ALTER TABLE `insurance_certificate_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `invitation`
--
ALTER TABLE `invitation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `job_entrant`
--
ALTER TABLE `job_entrant`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `language`
--
ALTER TABLE `language`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `legal_entity`
--
ALTER TABLE `legal_entity`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `links`
--
ALTER TABLE `links`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `masters`
--
ALTER TABLE `masters`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `master_class`
--
ALTER TABLE `master_class`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `menu`
--
ALTER TABLE `menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `moderation`
--
ALTER TABLE `moderation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `olimpiads_type_templates`
--
ALTER TABLE `olimpiads_type_templates`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `olimpic`
--
ALTER TABLE `olimpic`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `olimpic_list`
--
ALTER TABLE `olimpic_list`
  MODIFY `id` smallint(6) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `olimpic_nomination`
--
ALTER TABLE `olimpic_nomination`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `olimpic_old`
--
ALTER TABLE `olimpic_old`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `other_document`
--
ALTER TABLE `other_document`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `passport_data`
--
ALTER TABLE `passport_data`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `personal_entity`
--
ALTER TABLE `personal_entity`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `personal_presence_attempt`
--
ALTER TABLE `personal_presence_attempt`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `polls`
--
ALTER TABLE `polls`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `post_management`
--
ALTER TABLE `post_management`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `post_rate_department`
--
ALTER TABLE `post_rate_department`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `profiles`
--
ALTER TABLE `profiles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `question_proposition`
--
ALTER TABLE `question_proposition`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `queue`
--
ALTER TABLE `queue`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `receipt_contract`
--
ALTER TABLE `receipt_contract`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `registry_document`
--
ALTER TABLE `registry_document`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `schedule`
--
ALTER TABLE `schedule`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `sending`
--
ALTER TABLE `sending`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `sending_delivery_status`
--
ALTER TABLE `sending_delivery_status`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `setting_email`
--
ALTER TABLE `setting_email`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `setting_entrant`
--
ALTER TABLE `setting_entrant`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `special_type_olimpic`
--
ALTER TABLE `special_type_olimpic`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `statement`
--
ALTER TABLE `statement`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `statement_agreement_contract_cg`
--
ALTER TABLE `statement_agreement_contract_cg`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `statement_cg`
--
ALTER TABLE `statement_cg`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `statement_consent_cg`
--
ALTER TABLE `statement_consent_cg`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `statement_consent_personal_data`
--
ALTER TABLE `statement_consent_personal_data`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `statement_ia`
--
ALTER TABLE `statement_ia`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `statement_individual_achievements`
--
ALTER TABLE `statement_individual_achievements`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `statement_rejection`
--
ALTER TABLE `statement_rejection`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `statement_rejection_cg`
--
ALTER TABLE `statement_rejection_cg`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `statement_rejection_cg_consent`
--
ALTER TABLE `statement_rejection_cg_consent`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `statement_rejection_record`
--
ALTER TABLE `statement_rejection_record`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `support_category`
--
ALTER TABLE `support_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `support_ticket_content`
--
ALTER TABLE `support_ticket_content`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `support_ticket_head`
--
ALTER TABLE `support_ticket_head`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `task`
--
ALTER TABLE `task`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `teacher_user_class`
--
ALTER TABLE `teacher_user_class`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `templates`
--
ALTER TABLE `templates`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `test`
--
ALTER TABLE `test`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'ID';

--
-- AUTO_INCREMENT для таблицы `test_and_questions`
--
ALTER TABLE `test_and_questions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `test_attempt`
--
ALTER TABLE `test_attempt`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'ID';

--
-- AUTO_INCREMENT для таблицы `test_question`
--
ALTER TABLE `test_question`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'ID';

--
-- AUTO_INCREMENT для таблицы `test_question_group`
--
ALTER TABLE `test_question_group`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'ID';

--
-- AUTO_INCREMENT для таблицы `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `user-individual-achievements`
--
ALTER TABLE `user-individual-achievements`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `user_firebase_token`
--
ALTER TABLE `user_firebase_token`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `user_olimpiads`
--
ALTER TABLE `user_olimpiads`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `user_school`
--
ALTER TABLE `user_school`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `user_teacher_job`
--
ALTER TABLE `user_teacher_job`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `volunteering`
--
ALTER TABLE `volunteering`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `web_conference`
--
ALTER TABLE `web_conference`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `additional_information`
--
ALTER TABLE `additional_information`
  ADD CONSTRAINT `fk-idx-additional_information-user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `address`
--
ALTER TABLE `address`
  ADD CONSTRAINT `fk-idx-address-country_id` FOREIGN KEY (`country_id`) REFERENCES `dict_country` (`id`),
  ADD CONSTRAINT `fk-idx-address-user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `agreement`
--
ALTER TABLE `agreement`
  ADD CONSTRAINT `fk-idx-agreement-organization_id` FOREIGN KEY (`organization_id`) REFERENCES `dict_organizations` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk-idx-agreement-user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `ais_return_data`
--
ALTER TABLE `ais_return_data`
  ADD CONSTRAINT `fk-idx-return_data-created_id` FOREIGN KEY (`created_id`) REFERENCES `user` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `anketa`
--
ALTER TABLE `anketa`
  ADD CONSTRAINT `fk-idx-anketa-user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk-idx-passport-citizenship` FOREIGN KEY (`citizenship_id`) REFERENCES `dict_country` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `auth`
--
ALTER TABLE `auth`
  ADD CONSTRAINT `auth_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `auth_item`
--
ALTER TABLE `auth_item`
  ADD CONSTRAINT `auth_item_ibfk_1` FOREIGN KEY (`rule_name`) REFERENCES `auth_rule` (`name`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `auth_item_child`
--
ALTER TABLE `auth_item_child`
  ADD CONSTRAINT `auth_item_child_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `auth_item_child_ibfk_2` FOREIGN KEY (`child`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `comment_task`
--
ALTER TABLE `comment_task`
  ADD CONSTRAINT `fk-comment_task-created_by` FOREIGN KEY (`created_by`) REFERENCES `user` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk-idx-comment_task-task_id` FOREIGN KEY (`task_id`) REFERENCES `task` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `composite_discipline`
--
ALTER TABLE `composite_discipline`
  ADD CONSTRAINT `fk-idx-composite_discipline-discipline_id` FOREIGN KEY (`discipline_id`) REFERENCES `dict_discipline` (`id`),
  ADD CONSTRAINT `fk-idx-composite_discipline-discipline_select_id` FOREIGN KEY (`discipline_select_id`) REFERENCES `dict_discipline` (`id`);

--
-- Ограничения внешнего ключа таблицы `cse_subject_result`
--
ALTER TABLE `cse_subject_result`
  ADD CONSTRAINT `fk-cse_subject_result-user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `cse_vi_select`
--
ALTER TABLE `cse_vi_select`
  ADD CONSTRAINT `fk-cse_vi_select-user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `date_off`
--
ALTER TABLE `date_off`
  ADD CONSTRAINT `fk-idx-date_off-schedule_id` FOREIGN KEY (`schedule_id`) REFERENCES `schedule` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `declination_fio`
--
ALTER TABLE `declination_fio`
  ADD CONSTRAINT `fk-idx-declination_fio-user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `dict_competitive_group`
--
ALTER TABLE `dict_competitive_group`
  ADD CONSTRAINT `dict_competitive_group_ibfk_1` FOREIGN KEY (`faculty_id`) REFERENCES `dict_faculty` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `dict_competitive_group_ibfk_2` FOREIGN KEY (`speciality_id`) REFERENCES `dict_speciality` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `dict_competitive_group_ibfk_3` FOREIGN KEY (`specialization_id`) REFERENCES `dict_specialization` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `dict_individual_achievement_cg`
--
ALTER TABLE `dict_individual_achievement_cg`
  ADD CONSTRAINT `fk-idx-dia_cg-competitive_group_id` FOREIGN KEY (`competitive_group_id`) REFERENCES `dict_competitive_group` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk-idx-dia_cg-individual_achievement_id` FOREIGN KEY (`individual_achievement_id`) REFERENCES `dict_individual_achievement` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `dict_schools`
--
ALTER TABLE `dict_schools`
  ADD CONSTRAINT `dict_schools_ibfk_1` FOREIGN KEY (`country_id`) REFERENCES `dict_country` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `dict_schools_ibfk_2` FOREIGN KEY (`region_id`) REFERENCES `dict_region` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk-idx-dict_school_report_id` FOREIGN KEY (`dict_school_report_id`) REFERENCES `dict_schools_report` (`id`);

--
-- Ограничения внешнего ключа таблицы `dict_schools_pre_moderation`
--
ALTER TABLE `dict_schools_pre_moderation`
  ADD CONSTRAINT `dict_schools_pre_moderation_ibfk_1` FOREIGN KEY (`dict_school_id`) REFERENCES `dict_schools` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `dict_schools_report`
--
ALTER TABLE `dict_schools_report`
  ADD CONSTRAINT `fk-idx-school_id_report` FOREIGN KEY (`school_id`) REFERENCES `dict_schools` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `dict_sending_template`
--
ALTER TABLE `dict_sending_template`
  ADD CONSTRAINT `dict_sending_template_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `discipline_user`
--
ALTER TABLE `discipline_user`
  ADD CONSTRAINT `fk-discipline_user-user_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk-idx-discipline_user-discipline_id` FOREIGN KEY (`discipline_id`) REFERENCES `dict_discipline` (`id`),
  ADD CONSTRAINT `fk-idx-discipline_user-discipline_select_id` FOREIGN KEY (`discipline_select_id`) REFERENCES `dict_discipline` (`id`);

--
-- Ограничения внешнего ключа таблицы `document_education`
--
ALTER TABLE `document_education`
  ADD CONSTRAINT `fk-idx-document-education-school_id` FOREIGN KEY (`school_id`) REFERENCES `dict_schools` (`id`),
  ADD CONSTRAINT `fk-idx-document-education-type` FOREIGN KEY (`type`) REFERENCES `dict_incoming_document_type` (`id`),
  ADD CONSTRAINT `fk-idx-document-education-user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `document_task`
--
ALTER TABLE `document_task`
  ADD CONSTRAINT `fk-document_task-task_id` FOREIGN KEY (`task_id`) REFERENCES `task` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk-idx-document_task-document_registry_id` FOREIGN KEY (`document_registry_id`) REFERENCES `registry_document` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `dod`
--
ALTER TABLE `dod`
  ADD CONSTRAINT `dod_ibfk_1` FOREIGN KEY (`faculty_id`) REFERENCES `dict_faculty` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `exam`
--
ALTER TABLE `exam`
  ADD CONSTRAINT `fk-idx-exam-discipline_id` FOREIGN KEY (`discipline_id`) REFERENCES `dict_discipline` (`id`),
  ADD CONSTRAINT `fk-idx-exam-user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `examiner_discipline`
--
ALTER TABLE `examiner_discipline`
  ADD CONSTRAINT `fk-examiner_discipline-discipline_id` FOREIGN KEY (`discipline_id`) REFERENCES `dict_discipline` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk-idx-examiner_discipline-examiner_id` FOREIGN KEY (`examiner_id`) REFERENCES `dict_examiner` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `exam_answer`
--
ALTER TABLE `exam_answer`
  ADD CONSTRAINT `fk-exam_answer-question_id` FOREIGN KEY (`question_id`) REFERENCES `exam_question` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `exam_answer_nested`
--
ALTER TABLE `exam_answer_nested`
  ADD CONSTRAINT `fk-exam_answer_nested-question_nested_id` FOREIGN KEY (`question_nested_id`) REFERENCES `exam_question_nested` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `exam_attempt`
--
ALTER TABLE `exam_attempt`
  ADD CONSTRAINT `fk-exam_attempt-exam_id` FOREIGN KEY (`exam_id`) REFERENCES `exam` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk-exam_attempt-test_id` FOREIGN KEY (`test_id`) REFERENCES `exam_test` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk-idx-exam_attempt-user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `exam_question`
--
ALTER TABLE `exam_question`
  ADD CONSTRAINT `fk-exam_question-question_group_id` FOREIGN KEY (`question_group_id`) REFERENCES `exam_question_group` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk-idx-exam_question-discipline_id` FOREIGN KEY (`discipline_id`) REFERENCES `dict_discipline` (`id`);

--
-- Ограничения внешнего ключа таблицы `exam_question_group`
--
ALTER TABLE `exam_question_group`
  ADD CONSTRAINT `fk-idx-exam_question_group-discipline_id` FOREIGN KEY (`discipline_id`) REFERENCES `dict_discipline` (`id`);

--
-- Ограничения внешнего ключа таблицы `exam_question_in_test`
--
ALTER TABLE `exam_question_in_test`
  ADD CONSTRAINT `fk-exam_question_in_test-exam_id` FOREIGN KEY (`test_id`) REFERENCES `exam_test` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk-exam_question_in_test-question_group_id` FOREIGN KEY (`question_group_id`) REFERENCES `exam_question_group` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk-exam_question_in_test-question_id` FOREIGN KEY (`question_id`) REFERENCES `exam_question` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `exam_question_nested`
--
ALTER TABLE `exam_question_nested`
  ADD CONSTRAINT `fk-exam_question_nested-question_id` FOREIGN KEY (`question_id`) REFERENCES `exam_question` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `exam_result`
--
ALTER TABLE `exam_result`
  ADD CONSTRAINT `fk-exam_result-attempt_id` FOREIGN KEY (`attempt_id`) REFERENCES `exam_attempt` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk-exam_result-question_id` FOREIGN KEY (`question_id`) REFERENCES `exam_question` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk-exam_result-tq_id` FOREIGN KEY (`tq_id`) REFERENCES `exam_question_in_test` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `exam_statement`
--
ALTER TABLE `exam_statement`
  ADD CONSTRAINT `fk-exam_statement-exam_id` FOREIGN KEY (`exam_id`) REFERENCES `exam` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk-idx-exam_statement-entrant_user_id` FOREIGN KEY (`entrant_user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk-idx-exam_statement-proctor_user_id` FOREIGN KEY (`proctor_user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `exam_test`
--
ALTER TABLE `exam_test`
  ADD CONSTRAINT `fk-exam_test-exam_id` FOREIGN KEY (`exam_id`) REFERENCES `exam` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `exam_violation`
--
ALTER TABLE `exam_violation`
  ADD CONSTRAINT `fk-exam_violation-exam_statement_id` FOREIGN KEY (`exam_statement_id`) REFERENCES `exam_statement` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `files`
--
ALTER TABLE `files`
  ADD CONSTRAINT `fk-ecp-user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `fio_latin`
--
ALTER TABLE `fio_latin`
  ADD CONSTRAINT `fk-idx-fio_latin-user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `history_task`
--
ALTER TABLE `history_task`
  ADD CONSTRAINT `fk-history_task-created_by` FOREIGN KEY (`created_by`) REFERENCES `user` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk-idx-history_task-task_id` FOREIGN KEY (`task_id`) REFERENCES `task` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `insurance_certificate_user`
--
ALTER TABLE `insurance_certificate_user`
  ADD CONSTRAINT `fk-insurance_certificate_user-user_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `invitation`
--
ALTER TABLE `invitation`
  ADD CONSTRAINT `invitation_ibfk_1` FOREIGN KEY (`olimpic_id`) REFERENCES `olimpic_old` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `invitation_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `job_entrant`
--
ALTER TABLE `job_entrant`
  ADD CONSTRAINT `fk-job_entrant-email_id` FOREIGN KEY (`email_id`) REFERENCES `setting_email` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk-job_entrant-examiner_id` FOREIGN KEY (`examiner_id`) REFERENCES `dict_examiner` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk-job_entrant-faculty` FOREIGN KEY (`faculty_id`) REFERENCES `dict_faculty` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk-job_entrant-user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `language`
--
ALTER TABLE `language`
  ADD CONSTRAINT `fk-idx-language-user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `legal_entity`
--
ALTER TABLE `legal_entity`
  ADD CONSTRAINT `fk-legal_entity-user_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `management_task`
--
ALTER TABLE `management_task`
  ADD CONSTRAINT `fk-idx-management_task-post_rate_id` FOREIGN KEY (`post_rate_id`) REFERENCES `post_rate_department` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk-management_task-dict_task_id` FOREIGN KEY (`dict_task_id`) REFERENCES `dict_task` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `management_user`
--
ALTER TABLE `management_user`
  ADD CONSTRAINT `fk-idx-management_user-post_rate_id` FOREIGN KEY (`post_rate_id`) REFERENCES `post_rate_department` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk-management_user-user_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `masters`
--
ALTER TABLE `masters`
  ADD CONSTRAINT `masters_ibfk_1` FOREIGN KEY (`faculty_id`) REFERENCES `dict_faculty` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `master_class`
--
ALTER TABLE `master_class`
  ADD CONSTRAINT `master_class_ibfk_1` FOREIGN KEY (`master_id`) REFERENCES `masters` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `master_class_ibfk_2` FOREIGN KEY (`dod_id`) REFERENCES `dod` (`id`);

--
-- Ограничения внешнего ключа таблицы `menu`
--
ALTER TABLE `menu`
  ADD CONSTRAINT `menu_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `menu` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `olimpiads_type_templates`
--
ALTER TABLE `olimpiads_type_templates`
  ADD CONSTRAINT `olimpiads_type_templates_ibfk_1` FOREIGN KEY (`special_type`) REFERENCES `dict_special_type_olimpic` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `olimpiads_type_templates_ibfk_2` FOREIGN KEY (`template_id`) REFERENCES `templates` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `olimpic_cg`
--
ALTER TABLE `olimpic_cg`
  ADD CONSTRAINT `olimpic_cg_ibfk_1` FOREIGN KEY (`competitive_group_id`) REFERENCES `dict_competitive_group` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `olimpic_old`
--
ALTER TABLE `olimpic_old`
  ADD CONSTRAINT `olimpic_old_ibfk_1` FOREIGN KEY (`chairman_id`) REFERENCES `dict_chairmans` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `other_document`
--
ALTER TABLE `other_document`
  ADD CONSTRAINT `fk-idx-other_document-type` FOREIGN KEY (`type`) REFERENCES `dict_incoming_document_type` (`id`),
  ADD CONSTRAINT `fk-idx-other_document-user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `passport_data`
--
ALTER TABLE `passport_data`
  ADD CONSTRAINT `fk-idx-passport-nationality` FOREIGN KEY (`nationality`) REFERENCES `dict_country` (`id`),
  ADD CONSTRAINT `fk-idx-passport-user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `personal_entity`
--
ALTER TABLE `personal_entity`
  ADD CONSTRAINT `fk-personal_entity-user_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `personal_presence_attempt`
--
ALTER TABLE `personal_presence_attempt`
  ADD CONSTRAINT `personal_presence_attempt_ibfk_1` FOREIGN KEY (`nomination_id`) REFERENCES `olimpic_nomination` (`id`);

--
-- Ограничения внешнего ключа таблицы `poll_poll_answer`
--
ALTER TABLE `poll_poll_answer`
  ADD CONSTRAINT `poll_poll_answer_ibfk_1` FOREIGN KEY (`poll_answer_id`) REFERENCES `dict_poll_answers` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `poll_poll_answer_ibfk_2` FOREIGN KEY (`poll_id`) REFERENCES `polls` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `post_rate_department`
--
ALTER TABLE `post_rate_department`
  ADD CONSTRAINT `fk-idx-post_rate_department-post_management_id` FOREIGN KEY (`post_management_id`) REFERENCES `post_management` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk-post_rate_department-dict_department_id` FOREIGN KEY (`dict_department_id`) REFERENCES `dict_department` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `preemptive_right`
--
ALTER TABLE `preemptive_right`
  ADD CONSTRAINT `fk-idx-preemptive_right-other_id` FOREIGN KEY (`other_id`) REFERENCES `other_document` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `profiles`
--
ALTER TABLE `profiles`
  ADD CONSTRAINT `profiles_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `receipt_contract`
--
ALTER TABLE `receipt_contract`
  ADD CONSTRAINT `fk-receipt_contract-contract_cg_id` FOREIGN KEY (`contract_cg_id`) REFERENCES `statement_agreement_contract_cg` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `registry_document`
--
ALTER TABLE `registry_document`
  ADD CONSTRAINT `fk-idx-egistry-document-category_document_id` FOREIGN KEY (`category_document_id`) REFERENCES `category_document` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk-idx-registry_document-user_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk-registry_document-dict_department_id` FOREIGN KEY (`dict_department_id`) REFERENCES `dict_department` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `schedule`
--
ALTER TABLE `schedule`
  ADD CONSTRAINT `fk-idx-schedule-user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `sending`
--
ALTER TABLE `sending`
  ADD CONSTRAINT `sending_ibfk_2` FOREIGN KEY (`template_id`) REFERENCES `dict_sending_template` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `sending_ibfk_3` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `sending_ibfk_4` FOREIGN KEY (`sending_category_id`) REFERENCES `dict_sending_user_category` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `sending_user_category`
--
ALTER TABLE `sending_user_category`
  ADD CONSTRAINT `sending_user_category_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `sending_user_category_ibfk_3` FOREIGN KEY (`category_id`) REFERENCES `dict_sending_user_category` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `setting_competition_list`
--
ALTER TABLE `setting_competition_list`
  ADD CONSTRAINT `fk-idx-setting_competition_list-se_id` FOREIGN KEY (`se_id`) REFERENCES `setting_entrant` (`id`);

--
-- Ограничения внешнего ключа таблицы `special_type_olimpic`
--
ALTER TABLE `special_type_olimpic`
  ADD CONSTRAINT `special_type_olimpic_ibfk_2` FOREIGN KEY (`special_type_id`) REFERENCES `dict_special_type_olimpic` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `statement`
--
ALTER TABLE `statement`
  ADD CONSTRAINT `fk-statement-faculty_id` FOREIGN KEY (`faculty_id`) REFERENCES `dict_faculty` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk-statement-speciality_id` FOREIGN KEY (`speciality_id`) REFERENCES `dict_speciality` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk-statement-user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `statement_agreement_contract_cg`
--
ALTER TABLE `statement_agreement_contract_cg`
  ADD CONSTRAINT `fk-statement_agreement_contract_cg-statement_cg` FOREIGN KEY (`statement_cg`) REFERENCES `statement_cg` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `statement_cg`
--
ALTER TABLE `statement_cg`
  ADD CONSTRAINT `fk-idx-statement_cg-cathedra_id` FOREIGN KEY (`cathedra_id`) REFERENCES `dict_cathedra` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk-idx-statement_cg-cg_id` FOREIGN KEY (`cg_id`) REFERENCES `dict_competitive_group` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk-idx-statement_cg-statement_id` FOREIGN KEY (`statement_id`) REFERENCES `statement` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `statement_consent_cg`
--
ALTER TABLE `statement_consent_cg`
  ADD CONSTRAINT `fk-statement_consent-statement_cg_id` FOREIGN KEY (`statement_cg_id`) REFERENCES `statement_cg` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `statement_consent_personal_data`
--
ALTER TABLE `statement_consent_personal_data`
  ADD CONSTRAINT `fk-statement_consent_pf-user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `statement_ia`
--
ALTER TABLE `statement_ia`
  ADD CONSTRAINT `fk-idx-statement_ia-individual_id` FOREIGN KEY (`individual_id`) REFERENCES `dict_individual_achievement` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk-idx-statement_ia-statement_individual_id` FOREIGN KEY (`statement_individual_id`) REFERENCES `statement_individual_achievements` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `statement_individual_achievements`
--
ALTER TABLE `statement_individual_achievements`
  ADD CONSTRAINT `fk-statement_individual-user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `statement_rejection`
--
ALTER TABLE `statement_rejection`
  ADD CONSTRAINT `fk-idx-statement_rejection-statement_id` FOREIGN KEY (`statement_id`) REFERENCES `statement` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `statement_rejection_cg`
--
ALTER TABLE `statement_rejection_cg`
  ADD CONSTRAINT `fk-statement_rejection_cg-statement_cg` FOREIGN KEY (`statement_cg`) REFERENCES `statement_cg` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `statement_rejection_cg_consent`
--
ALTER TABLE `statement_rejection_cg_consent`
  ADD CONSTRAINT `fk-idx-statement_rejection-consent-statement_id` FOREIGN KEY (`statement_cg_consent_id`) REFERENCES `statement_consent_cg` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `statement_rejection_record`
--
ALTER TABLE `statement_rejection_record`
  ADD CONSTRAINT `fk-idx-statement_rr-cg_id` FOREIGN KEY (`cg_id`) REFERENCES `dict_competitive_group` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk-statement_rr-user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `submitted_documents`
--
ALTER TABLE `submitted_documents`
  ADD CONSTRAINT `fk-submitted_documents-user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `support_ticket_content`
--
ALTER TABLE `support_ticket_content`
  ADD CONSTRAINT `fk_support_ticket_content_id-support_ticket_head_id` FOREIGN KEY (`id_ticket`) REFERENCES `support_ticket_head` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_support_ticket_content_user_id-user_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `support_ticket_head`
--
ALTER TABLE `support_ticket_head`
  ADD CONSTRAINT `fk_support_ticket_head_category-support_category_id` FOREIGN KEY (`category_id`) REFERENCES `support_category` (`id`),
  ADD CONSTRAINT `fk_support_ticket_head_user_id-user_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `task`
--
ALTER TABLE `task`
  ADD CONSTRAINT `fk-idx-responsible_user` FOREIGN KEY (`responsible_user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk-idx-task-dict_task_id` FOREIGN KEY (`dict_task_id`) REFERENCES `dict_task` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk-idx-task-user` FOREIGN KEY (`director_user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `teacher_user_class`
--
ALTER TABLE `teacher_user_class`
  ADD CONSTRAINT `fk-idxx-id_olympic_user` FOREIGN KEY (`id_olympic_user`) REFERENCES `user_olimpiads` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk-idxx-user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `test_attempt`
--
ALTER TABLE `test_attempt`
  ADD CONSTRAINT `test_attempt_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `test_attempt_ibfk_2` FOREIGN KEY (`test_id`) REFERENCES `test` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `test_attempt_ibfk_3` FOREIGN KEY (`nomination_id`) REFERENCES `olimpic_nomination` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `test_class`
--
ALTER TABLE `test_class`
  ADD CONSTRAINT `test_class_ibfk_1` FOREIGN KEY (`test_id`) REFERENCES `test` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `test_class_ibfk_2` FOREIGN KEY (`class_id`) REFERENCES `dict_class` (`id`);

--
-- Ограничения внешнего ключа таблицы `test_group`
--
ALTER TABLE `test_group`
  ADD CONSTRAINT `test_group_ibfk_1` FOREIGN KEY (`question_group_id`) REFERENCES `test_question_group` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `test_group_ibfk_2` FOREIGN KEY (`test_id`) REFERENCES `test` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `test_question`
--
ALTER TABLE `test_question`
  ADD CONSTRAINT `test_question_ibfk_1` FOREIGN KEY (`group_id`) REFERENCES `test_question_group` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `test_result`
--
ALTER TABLE `test_result`
  ADD CONSTRAINT `test_result_ibfk_1` FOREIGN KEY (`attempt_id`) REFERENCES `test_attempt` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `test_result_ibfk_2` FOREIGN KEY (`question_id`) REFERENCES `test_question` (`id`);

--
-- Ограничения внешнего ключа таблицы `user-individual-achievements`
--
ALTER TABLE `user-individual-achievements`
  ADD CONSTRAINT `fk-documents-key` FOREIGN KEY (`document_id`) REFERENCES `other_document` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk-individual-key` FOREIGN KEY (`individual_id`) REFERENCES `dict_individual_achievement` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk-user_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `user_ais`
--
ALTER TABLE `user_ais`
  ADD CONSTRAINT `fk-idx-user_ais-user_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `user_cg`
--
ALTER TABLE `user_cg`
  ADD CONSTRAINT `fk-idx-user_cg-cathedra_id` FOREIGN KEY (`cathedra_id`) REFERENCES `dict_cathedra` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_cg_ibfk_1` FOREIGN KEY (`cg_id`) REFERENCES `dict_competitive_group` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_cg_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `user_dod`
--
ALTER TABLE `user_dod`
  ADD CONSTRAINT `user_dod_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `user_dod_ibfk_3` FOREIGN KEY (`school_id`) REFERENCES `dict_schools` (`id`),
  ADD CONSTRAINT `user_dod_ibfk_4` FOREIGN KEY (`status_edu`) REFERENCES `dict_post_education` (`id`);

--
-- Ограничения внешнего ключа таблицы `user_firebase_token`
--
ALTER TABLE `user_firebase_token`
  ADD CONSTRAINT `fk-idx-user_firebase_token` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `user_master_class`
--
ALTER TABLE `user_master_class`
  ADD CONSTRAINT `user_master_class_ibfk_1` FOREIGN KEY (`master_class_id`) REFERENCES `master_class` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_master_class_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Ограничения внешнего ключа таблицы `user_school`
--
ALTER TABLE `user_school`
  ADD CONSTRAINT `user_school_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_school_ibfk_3` FOREIGN KEY (`class_id`) REFERENCES `dict_class` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `user_sdo_token`
--
ALTER TABLE `user_sdo_token`
  ADD CONSTRAINT `fk-idx-user_sdo_token` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `user_teacher_job`
--
ALTER TABLE `user_teacher_job`
  ADD CONSTRAINT `fk-idx-school_id` FOREIGN KEY (`school_id`) REFERENCES `dict_schools` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk-idx-user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `volunteering`
--
ALTER TABLE `volunteering`
  ADD CONSTRAINT `fk-volunteering-course_edu` FOREIGN KEY (`course_edu`) REFERENCES `dict_class` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk-volunteering-faculty` FOREIGN KEY (`faculty_id`) REFERENCES `dict_faculty` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk-volunteering-job_entrant_id` FOREIGN KEY (`job_entrant_id`) REFERENCES `job_entrant` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
