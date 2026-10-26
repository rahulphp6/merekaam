<?php
$error_code = 400;
$error = "Page not found.";
if (isset($_GET['error'])) {
    $error = $_GET['error'];
    if ($error == 'permission') {
        $error_code = 401;
        $error = "Permission denied!";
    }
} ?>
<section class="content py-5">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-8 text-center">
                <!-- Error Code & Icon Container -->
                <div class="error-page p-4 bg-white shadow-sm rounded-4 border">
                    <div class="display-1 fw-bold text-danger mb-3">
                        <i class="fa fa-exclamation-triangle"></i> <?php echo $error_code ?? '404'; ?>
                    </div>

                    <div class="error-content">
                        <h3 class="h4 fw-bold text-dark mb-3">
                            Oops! <?php echo $error; ?>
                        </h3>
                        <p class="text-muted mb-4">
                            We could not find the page you were looking for.<br>
                            The asset you searched doesn't exist or is not available for you.<br>
                            Please try again with different data or check your URL!
                        </p>

                        <!-- Back / Action Button -->
                        <a href="index.php" class="btn btn-primary px-4 py-2 rounded-pill shadow-sm">
                            <i class="fa fa-home me-2"></i> Back to Dashboard
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>