<?php

date_default_timezone_set('America/Fortaleza');
setlocale(LC_TIME, 'pt_BR', 'pt_BR.UTF8', 'portuguese');
ini_set('display_errors', 0);
error_reporting(E_ALL);
//CONSTANTES
define('DAILY_TIME', 60 * 60 * 7.2);

//PASTAS
define('MODEL_PATH', realpath(dirname(__FILE__) . '/../models'));
define('VIEW_PATH', realpath(dirname(__FILE__) . '/../views'));
define('CONTROLLER_PATH', realpath(dirname(__FILE__) . '/../controllers'));
define('TEMPLATE_PATH', realpath(dirname(__FILE__) . '/../views/template'));
define('EXCEPTION_PATH', realpath(dirname(__FILE__) . '/../exceptions'));

//ARQUIVOS
require_once(realpath( dirname(__FILE__) . '/database.php'));
require_once(realpath( dirname(__FILE__) . '/loader.php'));
require_once(realpath( dirname(__FILE__) . '/session.php'));
require_once(realpath( dirname(__FILE__) . '/data_utils.php'));
require_once(realpath( dirname(__FILE__) . '/utils.php'));
require_once( realpath(MODEL_PATH. '/Model.php'));
require_once( realpath(MODEL_PATH. '/User.php'));
require_once( realpath(MODEL_PATH. '/WorkingHours.php'));
require_once( realpath(EXCEPTION_PATH. '/AppException.php'));
require_once( realpath(EXCEPTION_PATH. '/ValidateException.php'));
require_once( realpath(TEMPLATE_PATH. '/messages.php'));