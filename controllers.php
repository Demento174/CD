<?php

if((float) phpversion()<7.4)
{
    $current_version = phpversion();
    wp_die("min version php 7.4, current version $current_version");
}
/**
 * Автозагрузчик классов
 */
require_once (get_template_directory().'/autoload.php');

/**
 * Подключение модулей Composer
 */
require_once (get_template_directory().'/vendor/autoload.php');


/**
 * Стандартные настройки шаблона
 */
new Controllers\TemplateSetup\TemplateSetup();


/**
 * Настройки шаблонизатора TWIG
 */
new Controllers\TwigSettings\TwigSettings();


/**
 * Надстройка над плагином Advanced Custom field
 */
new Controllers\ACF\ACFController();

/**
 * Подключение стилей и скриптов
 */
new Controllers\ScriptsAndStyles\RegisterScriptsAndStyle();

/***
 * Отключение стандартного поля ввода контента
 */
//new Controllers\DisableContentEditor\DisableContentEditorController();


/**
 * Контроллер для ajax запросов
 */
new Controllers\SimpleAJAX\IndexSimpleAjax();


/**
 * Отключение пунктов меню
 */
new Controllers\DisableAdminMenu\DisableAdminMenuController();

/**
 * Кастомные типы записей
 */
new Controllers\CPT\CustomPostTypeController();


/**
 * Кастомные таксономии
 */
new Controllers\CPT\CustomTaxonomyController();

/**
 * Класс для дебага
 */
new Controllers\Debugger\Debugger();

/**
 * Класс для кастомизации Административной части
 */

\Controllers\CustomAdminPanelStyle::login_head(
    [get_bloginfo( 'template_directory' ) . '/public/css/admin.css'],
    null
);

/**
 * Импорт товаров со сторонних сайтов
 */
//new \Controllers\Import\Init();

/**
 * Надстройка над классом вывода ошибок, необходим функция debug()
 */
new \Controllers\Debugger();

/**
 * Регистрация виджетов
 */
//$widgets =  new \Controllers\Widgets\Widgets(get_template_directory().'/Views/blocks');
//
//$widgets->handler_acfRegisterBlock();
//$widgets->disable_default_blocks();
