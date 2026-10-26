<?php
// Permission flags
$isR = $isW = $isE = $isD = 0;
// Page access check
if (!empty($_GET['page'])) {
    $ModuleKey = strtolower(trim($_GET['page']));
    $pageModeName = explode('-', $ModuleKey);
    $pageName = $pageModeName[0] ?? '';
    if (!empty($pageName)) {
        $checkPerm = isPermMode($role, $pageName);

        if (isSuper()) {
            $isR = $isW = $isE = $isD = 1;
        } elseif (!empty($checkPerm) && is_array($checkPerm)) {
            [$isR, $isW, $isE, $isD] = array_map('intval', array_pad($checkPerm, 4, 0));
        } else {
            //redirectTo(BASE_URL . 'login.php', 0, "Invalid page access: $pageName");
        }
    }
}

// UID validation
$uid = isset($_SESSION['id']) ? intval($_SESSION['id']) : 0;
if (!$uid) {
    //redirectTo(BASE_URL . 'login.php');
}
$data_user = secureDbAction('users', 4, [], 'id=?', [$uid]);
$user_row = $data_user['data'][0] ?? [];
// print_r($data_user);
$name = $user_row['name'];
// Profile image fallback
$getDp = "dist/img/user2-160x160.jpg";
if (isAdmin() && !empty($user_row['profilePic'])) {
    $getDp = $user_row['profilePic'];
} elseif (!isAdmin() && !empty($user_row['photo_url'])) {
    $getDp = $user_row['photo_url'];
}
?>
<!--Nav Start-->
<nav class="nav navbar navbar-expand-lg iq-navbar bg-whi">
    <div class="container-fluid navbar-inner">
        <div class="sidebar-toggle" data-toggle="sidebar" data-active="true">
            <i class="icon">
                <svg width="20px" class="icon-20" viewBox="0 0 24 24">
                    <path fill="currentColor"
                        d="M4,11V13H16L10.5,18.5L11.92,19.92L19.84,12L11.92,4.08L10.5,5.5L16,11H4Z" />
                </svg>
            </i>
        </div>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon">
                <span class="mt-2 navbar-toggler-bar bar1"></span>
                <span class="navbar-toggler-bar bar2"></span>
                <span class="navbar-toggler-bar bar3"></span>
            </span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">

            <!-- AJAX Loader & Debug Info -->
            <div class="before_ajx ms-auto me-3" style="display: none;">
                <div id="loader-4" class="spinner-border text-primary spinner-border-sm" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>
            <div class="debugapi"></div>

            <ul class="mb-2 navbar-nav ms-auto align-items-center navbar-list mb-lg-0">

                <!-- Notification Dropdown -->
                <li class="nav-item dropdown nf_holder">
                    <a href="#" class="nav-link" id="mail-drop" data-bs-toggle="dropdown" aria-haspopup="true"
                        aria-expanded="false">
                        <svg class="icon-24" width="24" viewBox="0 0 24 24" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path opacity="0.4"
                                d="M22 15.94C22 18.73 19.76 20.99 16.97 21H16.96H7.05C4.27 21 2 18.75 2 15.96V15.95C2 15.95 2.006 11.524 2.014 9.298C2.015 8.88 2.495 8.646 2.822 8.906C5.198 10.791 9.447 14.228 9.5 14.273C10.21 14.842 11.11 15.163 12.03 15.163C12.95 15.163 13.85 14.842 14.56 14.262C14.613 14.227 18.767 10.893 21.179 8.977C21.507 8.716 21.989 8.95 21.99 9.367C22 11.576 22 15.94 22 15.94Z"
                                fill="currentColor"></path>
                            <path
                                d="M21.4759 5.67351C20.6099 4.04151 18.9059 2.99951 17.0299 2.99951H7.04988C5.17388 2.99951 3.46988 4.04151 2.60388 5.67351C2.40988 6.03851 2.50188 6.49351 2.82488 6.75151L10.2499 12.6905C10.7699 13.1105 11.3999 13.3195 12.0299 13.3195C12.0339 13.3195 12.0369 13.3195 12.0399 13.3195C12.0429 13.3195 12.0469 13.3195 12.0499 13.3195C12.6799 13.3195 13.3099 13.1105 13.8299 12.6905L21.2549 6.75151C21.5779 6.49351 21.6699 6.03851 21.4759 5.67351Z"
                                fill="currentColor"></path>
                        </svg>
                        <span class="bg-primary count-mail"></span>
                    </a>
                    <div class="p-0 sub-drop dropdown-menu dropdown-menu-end" aria-labelledby="mail-drop">
                        <div class="m-0 shadow-none card">
                            <div class="py-3 card-header d-flex justify-content-between bg-primary">
                                <div class="header-title">
                                    <h5 class="mb-0 text-white">Notifications</h5>
                                </div>
                            </div>
                            <div class="p-0 card-body">
                                <!-- Dynamic notifications will be appended here via JS -->
                                <div class="text-center p-3 text-muted">No new notifications</div>
                            </div>
                        </div>
                    </div>
                </li>

                <!-- User Profile Dropdown -->
                <li class="nav-item dropdown">
                    <a class="py-0 nav-link d-flex align-items-center" href="#" id="navbarDropdown" role="button"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        <!-- Dynamic Profile Image -->
                        <img src="<?= htmlspecialchars($getDp) ?>" alt="User-Profile"
                            class="theme-color-default-img img-fluid  avatar-30 avatar-rounded"
                            style="object-fit: cover;">

                        <div class="caption ms-3 d-none d-md-block">
                            <!-- Dynamic User Name -->
                            <h6 class="mb-0 caption-title" style="font-size: 0.9rem;"><?= htmlspecialchars($name) ?>
                            </h6>
                            <!-- Dynamic Role/Status (Static for now, can be updated if role exists in DB) -->
                            <p class="mb-0 caption-sub-title text-muted" style="font-size: 0.75rem;">Admin User</p>
                        </div>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="?page=profile">Profile</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <!-- Dynamic Logout -->
                        <li><a class="dropdown-item text-danger" href="logout.php"><i class="fa fa-power-off me-2"></i>
                                Logout</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>
<!-- Nav Header Component End -->