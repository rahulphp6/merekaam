<?php
// 1. Secure Session Start
if (session_status() === PHP_SESSION_NONE) {
    // Optional but recommended: Set secure session parameters before starting
    ini_set('session.cookie_httponly', 1);
    ini_set('session.use_only_cookies', 1);
    session_start();
}

// Autoload dependencies
require __DIR__ . '/../vendor/autoload.php';
use Dotenv\Dotenv;

// 2. Secure Subdomain Detection (Prevent Host Injection)
$host = $_SERVER['HTTP_HOST'] ?? '';
$rawSubdomain = explode('.', $host)[0];
// Sanitize to only allow alphanumeric characters and hyphens
$subdomain = preg_replace('/[^a-zA-Z0-9-]/', '', $rawSubdomain);

if (empty($subdomain)) {
    die("❌ Invalid Host Configuration.");
}

// Load environment file based on subdomain
$envPath = realpath(__DIR__ . '/../');
$envFile = ".env.$subdomain";

if ($envPath && file_exists("$envPath/$envFile")) {
    $dotenv = Dotenv::createImmutable($envPath, $envFile);
    $dotenv->load();
} else {
    // Do not expose the exact path in production errors
    die("❌ Configuration missing for tenant.");
}

// Debug mode
define("DEBUG_MODE", filter_var($_ENV['DEBUG_MODE'] ?? false, FILTER_VALIDATE_BOOLEAN));
if (DEBUG_MODE) {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
} else {
    error_reporting(0);
    ini_set('display_errors', 0);
}

// Environment Detection (Explicit via .env, NOT IP based)
$isLocal = ($_ENV['APP_ENV'] ?? 'production') === 'local';

if ($isLocal) {
    define("BASE_URL", "http://localhost/merekaam/");
    ini_set('date.timezone', 'Asia/Kolkata');
} else {
    define("BASE_URL", $_ENV['BASE_URL'] ?? '');
    ini_set('date.timezone', 'Asia/Dubai');
}

// App constants
define("db", $_ENV['DB_NAME'] ?? 'pos');
define("brand", $_ENV['BRAND'] ?? 'POS');
define("common_db", $_ENV['COMMON_DB'] ?? db);
define("common_base", BASE_URL);
define("BASE", BASE_URL);

// 3. DB Connection (Optimized with Static Caching and Charset)
function OpenCon($dbname = null)
{
    static $connections = []; // Cache connections to prevent DB exhaustion

    $dbname = $dbname ?? db;

    // Return existing connection if already established for this dbname
    if (isset($connections[$dbname])) {
        return $connections[$dbname];
    }

    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT); // Enable exceptions
    try {
        $conn = new mysqli($_ENV['DB_HOST'], $_ENV['DB_USER'], $_ENV['DB_PASS'], $dbname);
        $conn->set_charset("utf8mb4"); // Critical for security and data integrity
        $connections[$dbname] = $conn;
        return $conn;
    } catch (mysqli_sql_exception $e) {
        // Log the actual error internally, but show generic error to user
        error_log("Database Connection Error: " . $e->getMessage());
        die("❌ System currently unavailable. Please try again later.");
    }
}

function CloseCon($conn)
{
    if ($conn instanceof mysqli) {
        $conn->close();
    }
}
if (isset($_SESSION['role'])) {
    $role = intval($_SESSION['role']);
}
// echo BASE_URL;
// Load shared constants
include "rpAction.php";
include "logistic-functions.php";
