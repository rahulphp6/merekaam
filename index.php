<?php ob_start();
include_once "core/config.php";
if (!isUser()) {
    redirectTo('login.php');
    exit();
}
$pageName = $_GET['page'] ?? null;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php if (isset($_GET['page'])) {
        echo brand . ' | ' . @$_GET['page'];
    } else {
        echo brand;
    } ?></title>
    <?php include 'temp-parts/head.php'; ?>
</head>

<body>

    <?php include 'temp-parts/navbar.php'; ?>
    <main class="main-content">
        <?php include 'temp-parts/header.php'; ?>
        <div class="conatiner-fluid content-inner p-0">
            <div class="debugApi"></div>
            <?php
            // 1. Initialize variables to prevent PHP 8+ warnings
            $file = '';
            $line = 0;

            if (headers_sent($file, $line)) {
                echo "<div class='alert alert-warning m-3'>⚠️ Headers already sent in $file on line $line</div>";
            }

            // Maintenance mode
            // redirectTo('working.php', 2, 'Site is under maintenance. Please check back later.');
            
            if (!empty($ModuleKey)) {
                $safeModuleKey = basename(strtolower($ModuleKey));
                $targetFile = "users/" . $safeModuleKey . ".php";
                if (file_exists($targetFile) && !empty($isR) && isModCheck($ModuleKey)) {
                    include $targetFile;
                } else {
                    include 'users/404.php';
                }
            } else {
                // Default module
                include 'users/dashboard.php';
            }
            ?>
        </div>
    </main>
    <div id="toastsContainerTopRight" class="toasts-top-right fixed"></div>
    <?php include 'temp-parts/footer.php'; ?>
    <?php ob_end_flush(); ?>
</body>

</html>