<?php
// ini settings
ini_set("display_errors", 1);
ini_set("display_startup_errors", 1);

ini_set("memory_limit", "1024M");
ini_set('post_max_size', '20M');
ini_set('max_execution_time', 600);
ini_set('session.gc_maxlifetime', 24*60*40);

ob_start();
session_start();
error_reporting(E_ALL);
// error_reporting(0);

// Sever constants
define('SERVER', $_SERVER['SERVER_NAME']);
define ('PAGE', pathinfo(basename($_SERVER['PHP_SELF']), PATHINFO_FILENAME));
define('ROOT', $_SERVER['DOCUMENT_ROOT']);
define('SCHEME', $_SERVER['REQUEST_SCHEME']);
define('PORT', $_SERVER['SERVER_PORT']);
define('REQUEST_URI', $_SERVER['REQUEST_URI']);
define('SCRIPT_NAME', $_SERVER['SCRIPT_NAME']);

// SQL database parameters
if (SERVER != 'localhost' AND SERVER != '127.0.0.1' ) {
    define('BASE_PATH', '/gift/');
    define('DB_NAME', 'topupsocket_gifts');
    define('DB_USER', 'topupsocket_gifts');
    define('DB_PASSWORD', 'topupsocket_gifts');
    define('DB_HOST', 'localhost');
}else{
    define('BASE_PATH', '/float/');
    define('DB_NAME', 'floating');
    define('DB_USER', 'root');
    define('DB_PASSWORD', '');
    define('DB_HOST', 'localhost');
}

// Application constants
define('BASE_URL', SCHEME.'://'.SERVER.BASE_PATH);
define('MODEL_DIR', ROOT.BASE_PATH.'models/');
define('CONTROLLER_DIR', ROOT.BASE_PATH.'controllers/');
define('INCLUDES_DIR', ROOT.BASE_PATH.'includes/');
define('VENDOR_DIR', ROOT.BASE_PATH.'vendor/');
define('CLASS_DIR', ROOT.BASE_PATH.'classes/');
define('COMPONENT_DIR', ROOT.BASE_PATH.'components/');
define('CURRENCY', '&#8358;');

// Page name constant
$page = explode('.', PAGE);

// Requirements
// require_once(VENDOR_DIR.'autoload.php');
require_once('Database.php');

// Database Coonection
$dsn = "mysql:dbname=" . DB_NAME . ";host=" . DB_HOST . "";
$pdo = "";
try {
    $pdo = new PDO($dsn, DB_USER, DB_PASSWORD);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
$db = new Database($pdo);

// Includes
include_once MODEL_DIR.'Language.php';
$language = new Language();

// Initialize Models
include_once MODEL_DIR.'Utility.php';
$utility = new Utility($db);

include_once MODEL_DIR.'Settings.php';
$settings = new Settings($db);

include_once MODEL_DIR.'User.php';
$user = new User($db);

require_once MODEL_DIR.'Pages.php';
$pages = new Pages($db);

$allSettings = $settings->getAllSettings();
$siteInfo = json_decode($allSettings->siteInfo);

define("SITE_TITLE", $siteInfo->name);

// Page name constant
$page = explode('.', PAGE);
define('PAGE_NAME', $pages->getPage($page['0']) === false ? "" : $pages->getPage($page['0'])->title);
define('PAGE_SLUG', $pages->getPage($page['0']) === false ? "" : $pages->getPage($page['0'])->slug);
define('PAGE_ACCESS_TYPE', $pages->getPage($page['0']) === false ? "" : $pages->getPage($page['0'])->access_type);

// Default Time zone
date_default_timezone_set("Africa/Lagos");
