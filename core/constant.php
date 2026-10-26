<?php
define('date', date("Y-m-d h:i:s"));
if (isset($_SESSION['contact_id'])) {
    $custid = $_SESSION['contact_id'];
    define("custid", $custid);
}
define('VERSION', 'V-1.0');
// include_once "email-template.php";
include mydir . "/rpfiles/rpAction.php";
$organizationId = "";
$store_name = "ZOHO CRM";
$store_theme = "";
$baseCr = "AED";

if (isset($_SESSION['role'])) {
    $role = intval($_SESSION['role']);

    if ($role < 5) {
        if (isset($_POST['orgSwitch']) && isset($_POST['id']) && is_numeric($_POST['id'])) {
            $storeId = intval($_POST['id']);

            // Set all stores to inactive
            dbAction("store", 2, ["status" => 0], "id != $storeId");

            // Activate selected store
            $stdbCheck = dbAction("store", 2, ["status" => 1], "id = $storeId");

            if (!$stdbCheck[0]) {
                mgs($stdbCheck[1], 0);
            }
        }

        $stdbCheck = dbAction("store", 4, "", "status=1");
        if ($stdbCheck && $stdbCheck->num_rows > 0) {
            $storeDb = $stdbCheck->fetch_object();
            $organizationId = $storeDb->store;
            $store_name = $storeDb->name;
            $store_theme = $storeDb->theme;
        } else {
            mgs("Store not found!", 0);
        }
    } elseif (!empty($_SESSION['store'])) {
        $storeCode = $_SESSION['store'];
        $stdbCheck = dbAction("store", 4, "", "store='$storeCode'");
        if ($stdbCheck && $stdbCheck->num_rows > 0) {
            $storeDb = $stdbCheck->fetch_object();
            $organizationId = $storeDb->store;
            $store_name = $storeDb->name ?? $store_name;
            $store_theme = $storeDb->theme ?? "";
        } else {
            $organizationId = $storeCode;
        }
    }

    define("organizationId", $organizationId);
    define("store", $store_name);
    define("store_theme", $store_theme);
    define("currency", 'AED');

    // Tax config
    $taxQ = dbAction("tax", 4, "", "store='$organizationId'");
    if ($taxQ && $taxQ->num_rows > 0) {
        $taxRow = $taxQ->fetch_object();
        define('vat_tax', $taxRow->vat_tax);
        define('tax_id', $taxRow->tax_id);
        define('zero_tax', $taxRow->zero_tax);
        define('zero_tax_id', $taxRow->zero_tax_id);
    } else {
        define('vat_tax', "");
        define('tax_id', "");
        define('zero_tax', "");
        define('zero_tax_id', "");
    }

    // Settings
    $setting_q = dbAction("setting", 4, "", "store='$organizationId'");
    if ($setting_q && $setting_q->num_rows > 0) {
        $getSet = $setting_q->fetch_object();
        error_reporting(E_ALL);
        ini_set('display_errors', $getSet->mode);
    }

    // User ID
    if (isset($_SESSION['id'])) {
        define("uid", intval($_SESSION['id']));
        define("user_id", isset($_SESSION['user_id']) ? intval($_SESSION['user_id']) : 0);
    }

    // Brand config
    $brandData = dbAction('configuration', 4);
    if ($brandData && $brandData->num_rows > 0) {
        $Brand = $brandData->fetch_assoc();
        define("isBrand", 1);
        define("email", $Brand['email']);
        define("phone", str_replace("+", "", $Brand['phone']));
        define("address", $Brand['address']);
        define("payment_mode", $Brand['payment_mode']);
        define("ret_des", $Brand['ret_des']);
        define("carrier", $Brand['carrier']);
    } else {
        define("isBrand", 0);
    }

    // Notifications
    $notisData = dbAction('smtp', 4, '', 'status=1');
    if ($notisData && $notisData->num_rows > 0) {
        $smsAR = $notisData->fetch_object();
        define("adminEmail", $smsAR->email);
        define("adminPhone", str_replace("+", "", $smsAR->phone));
        define("multi_ph", $smsAR->multi_ph);
    }
}
// get branch
// if (isUser() && !empty(isUser('location'))) {
//     define('user_branch', isUser('location'));
// } else {
//     define('user_branch', '');
// }
// include_once __DIR__ . "/functions.php";
// include_once "pos.php";
// include_once "reporting.php";
// include_once __DIR__ . "/api.php";
// include_once "media.php";
// echo '</div>';
