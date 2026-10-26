<?php ob_start();
include_once "core/config.php";
if (!IsAdmin()) {
    redirectTo('login.php');
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Administrator</title>
    <?php include 'temp-parts/head.php'; ?>
</head>

<body>

    <?php include 'temp-parts/navbar.php'; ?>
    <main class="main-content">
        <?php include 'temp-parts/header.php'; ?>
        <?php
        $classPerPage = 'conatiner-fluid';
        $SeprateCss = ['contact', 'project'];
        if (in_array($page, $SeprateCss)) {
            // $classPerPage = 'p-0';
        }
        ?>
        <div class="<?php echo $classPerPage; ?> content-inner">
            <div id="posApiRes" class="debugApi"></div>
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
                // 2. Security Fix: Prevent Local File Inclusion (LFI) using basename()
                $safeModuleKey = basename(strtolower($ModuleKey));
                $targetFile = "pages/" . $safeModuleKey . ".php";

                // Check if file exists AND variables are set AND user has permission
                if (file_exists($targetFile) && !empty($isR) && isModCheck($ModuleKey)) {
                    include $targetFile;
                } else {
                    include 'users/404.php';}
            } else {
                // Default module
                include 'pages/dashboard.php';
            }
            ?>
        </div>
    </main>
    <div id="toastsContainerTopRight" class="toasts-top-right fixed"></div>
    <?php include 'temp-parts/footer.php'; ?>
    <?php ob_end_flush(); ?>
</body>

</html>