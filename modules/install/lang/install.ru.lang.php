<?php
/**
 * Russian Language File for the Install Module
 *
 * @package install
 * @version 0.7.0
 * @author Cotonti Translators Team
 * @copyright Copyright (c) Cotonti Team 2008-2010
 * @license BSD
 */

defined('SED_CODE') or die('Wrong URL.');

$L['Complete'] = 'Выполнено';
$L['Finish'] = 'Завершить';
$L['Install'] = 'Установить';
$L['Next'] = 'Далее';

$L['install_adminacc'] = 'Данные администратора';
$L['install_body_title'] = 'Установщик Cotonti';
$L['install_body_message1'] = 'Этот скрипт поможет вам осуществить первичную установку и настройку Cotonti. Вы должны создать пустую базу данных на вашем сервере, так как скрипт не сможет этого сделать самостоятельно.';
$L['install_body_message2'] = 'Рекомендуем создать в папке datas/ файл config.php и установить на него права CHMOD 666.';
$L['install_chmod_value'] = 'CHMOD {$chmod}';
$L['install_complete'] = 'Установка Cotonti успешно завершена!';
$L['install_complete_note'] = 'Удалите install.php и установите на datas/config.php права CHMOD 644. Это необходимо для повышения безопасности вашего сайта.';
$L['install_db'] = 'Настройки базы данных MySQL';
$L['install_db_host'] = 'Сервер СУБД';
$L['install_db_user'] = 'Пользователь';
$L['install_db_pass'] = 'Пароль';
$L['install_db_name'] = 'Имя базы данных';
$L['install_db_x'] = 'Префикс таблиц';
$L['install_dir_not_found'] = 'Дирректория установки не найдена';
$L['install_error_config'] = 'Не удаётся создать или отредактировать файл конфигурации. Скопируйте содержимое файла config-sample.php в config.php. Установите на файл config.php права CHMOD 777.';
$L['install_error_sql'] = 'Не удалось подключиться к базе MySQL. Проверьте настройки подключения.';
$L['install_error_sql_db'] = 'Не удалось выбрать базу MySQL. Проверьте настройки подключения.';
$L['install_error_sql_ext'] = 'Cotonti необходимо PHP-расширение mysql для работы';
$L['install_error_sql_script'] = 'Выполнение SQL-скрипта завершилось неудачно: {$msg}';
$L['install_error_sql_ver'] = 'Cotonti требуется версия MySQL 4.1.0 и выше. Ваша версия {$ver}';
$L['install_error_mainurl'] = 'Укажите основной URL вашего сайта';
$L['install_error_mbstring'] = 'Cotonti требуется для работы расширение PHP mbstring';
$L['install_error_missing_file'] = 'Отсутствует {$file}. Перезагрузите этот файл для продолжения установки.';
$L['install_error_php_ver'] = 'Cotonti требуется версия PHP 5.1.0 и выше. Ваша версия {$ver}';
$L['install_misc'] = 'Дополнительные настройки';
$L['install_misc_lng'] = 'Основной язык';
$L['install_misc_skin'] = 'Основная тема оформления';
$L['install_misc_url'] = 'Основной URL сайта (без слеша в конце)';
$L['install_permissions'] = 'Права на файлы и папки';
$L['install_recommends'] = 'Рекомендуется';
$L['install_requires'] = 'Требуется';
$L['install_retype_password'] = 'Повторите пароль';
$L['install_step'] = 'Шаг {$step} из {$total}';
$L['install_title'] = 'Установка Cotonti';
$L['install_update'] = 'Обновление Cotonti';
$L['install_update_config_error'] = 'Не удалось переписать datas/config.php';
$L['install_update_config_success'] = 'Успешное обновление datas/config.php';
$L['install_update_error'] = 'Обновление не удалось';
$L['install_update_nothing'] = 'Обновление не требуется';
$L['install_update_patch_applied'] = 'Установить патч {$f}: {$msg}';
$L['install_update_patch_error'] = 'Ошибка при установке патча {$f}: {$msg}';
$L['install_update_patches'] = 'Установленные патчи:';
$L['install_update_success'] = 'Успешное обновление до версии {$rev}';
$L['install_update_template_not_found'] = 'Update template file not found';
$L['install_upgrade_error'] = 'Неудачное обновление Cotonti до версии {$ver}';
$L['install_upgrade_success'] = 'Успешное обновление Cotonti до версии {$ver}';
$L['install_ver'] = 'Информация о сервере';
$L['install_ver_invalid'] = '{$ver} &mdash; неудачно!';
$L['install_ver_valid'] = '{$ver} &mdash; успешно!';
$L['install_view_site'] = 'Перейти к вашему сайту';
$L['install_writable'] = 'Доступно';

?>