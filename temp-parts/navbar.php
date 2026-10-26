<style>
    .sidebar .sidebar-header {
        background: #fff;
        justify-content: center !important;
    }
</style>
<aside class="sidebar sidebar-default sidebar-white sidebar-base zoho-sidebar navs-rounded-all ">
    <div class="sidebar-header d-flex align-items-center justify-content-start">
        <a href="?page=store" class="navbar-brand">
            <!--Logo start-->
            <div class="logo-main">
                <div class="logo-normal">
                    <img src="images/<?= htmlspecialchars(brand ?? 'pdc'); ?>.png" alt="Logo" class="img-fluid"
                        style="max-height: 55px;">
                </div>
                <div class="logo-mini">
                    <img src="images/<?= htmlspecialchars(brand ?? 'pdc'); ?>.png" alt="Logo" class="img-fluid"
                        style="max-height: 55px;">
                </div>
            </div>
            <!--logo End-->
        </a>
        <div class="sidebar-toggle" data-toggle="sidebar" data-active="true">
            <i class="icon">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M4.25 12.2744L19.25 12.2744" stroke="currentColor" stroke-width="1.5"
                        stroke-linecap="round" stroke-linejoin="round"></path>
                    <path d="M10.2998 18.2988L4.2498 12.2748L10.2998 6.24976" stroke="currentColor" stroke-width="1.5"
                        stroke-linecap="round" stroke-linejoin="round"></path>
                </svg>
            </i>
        </div>
    </div>
    <div class="sidebar-body pt-0 data-scrollbar">
        <div class="sidebar-list">
            <ul class="navbar-nav iq-main-menu" id="sidebar-menu">
                <!-- User Nav -->
                <?php
                $currentPage = $_GET['page'] ?? 'dashboard';
                $menus = ['menu' => [], 'parents' => []];
                $menu_user = ['menu' => [], 'parents' => []];

                $getMenus = secureDbAction('menu', 4, [], 'status=? ORDER BY sort ASC', [1]);

                if (!empty($getMenus['data'])) {
                    foreach ($getMenus['data'] as $menu) {
                        $menus['menu'][$menu['id']] = $menu;
                        $menus['parents'][$menu['parent']][] = $menu['id'];
                        if ($menu['is_active'] == 0) {
                            $menu_user['menu'][$menu['id']] = $menu;
                            $menu_user['parents'][$menu['parent']][] = $menu['id'];
                        }
                    }
                }

                echo logisticMenu(0, isAdmin() ? $menus : $menu_user, $currentPage);
                ?>
                <?php if (isAdmin() or isSuper()) { ?>

                    <!-- 1. Users Modules Section -->
                    <li>
                        <hr class="hr-horizontal mt-3 mb-3">
                    </li>
                    <li class="nav-item static-item">
                        <a class="nav-link static-item disabled" href="#" tabindex="-1">
                            <span class="default-icon">Users Modules</span>
                            <span class="mini-icon">-</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="collapse" href="#user-management" role="button"
                            aria-expanded="false" aria-controls="user-management">
                            <i class="icon"><i class="fa fa-user" style="font-size: 1.1rem;"></i></i>
                            <span class="item-name">User Management</span>
                            <i class="right-icon">
                                <svg class="icon-18" xmlns="http://www.w3.org/2000/svg" width="18" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5l7 7-7 7" />
                                </svg>
                            </i>
                        </a>
                        <ul class="sub-nav collapse" id="user-management" data-bs-parent="#sidebar-menu">
                            <li class="nav-item">
                                <a class="nav-link" href="admin.php?page=users">
                                    <i class="icon"><i class="fa fa-circle" style="font-size: 0.5rem;"></i></i>
                                    <span class="item-name">Users</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="admin.php?page=departments">
                                    <i class="icon"><i class="fa fa-circle" style="font-size: 0.5rem;"></i></i>
                                    <span class="item-name">Departments</span>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <!-- 2. Settings & Security Section -->
                    <li>
                        <hr class="hr-horizontal mt-3 mb-3">
                    </li>
                    <li class="nav-item static-item">
                        <a class="nav-link static-item disabled" href="#" tabindex="-1">
                            <span class="default-icon">Settings & Security</span>
                            <span class="mini-icon">-</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="collapse" href="#settings-collapse" role="button"
                            aria-expanded="false" aria-controls="settings-collapse">
                            <i class="icon"><i class="fa fa-cogs" style="font-size: 1.1rem;"></i></i>
                            <span class="item-name">Setting</span>
                            <i class="right-icon">
                                <svg class="icon-18" xmlns="http://www.w3.org/2000/svg" width="18" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5l7 7-7 7" />
                                </svg>
                            </i>
                        </a>
                        <ul class="sub-nav collapse" id="settings-collapse" data-bs-parent="#sidebar-menu">

                            <li class="nav-item">
                                <a class="nav-link" href="?page=configuration">
                                    <i class="icon"><i class="fa fa-circle" style="font-size: 0.5rem;"></i></i>
                                    <span class="item-name">General Setting</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo BASE; ?>admin.php?page=mail">
                                    <i class="icon"><i class="fa fa-circle" style="font-size: 0.5rem;"></i></i>
                                    <span class="item-name">Mail Setting</span>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <!-- 3. Role Management Section -->
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="collapse" href="#roles-collapse" role="button"
                            aria-expanded="false" aria-controls="roles-collapse">
                            <i class="icon"><i class="fa fa-user-secret" style="font-size: 1.1rem;"></i></i>
                            <span class="item-name">Role Management</span>
                            <i class="right-icon">
                                <svg class="icon-18" xmlns="http://www.w3.org/2000/svg" width="18" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5l7 7-7 7" />
                                </svg>
                            </i>
                        </a>
                        <ul class="sub-nav collapse" id="roles-collapse" data-bs-parent="#sidebar-menu">
                            <li class="nav-item">
                                <a class="nav-link" href="admin.php?page=roles">
                                    <i class="icon"><i class="fa fa-circle" style="font-size: 0.5rem;"></i></i>
                                    <span class="item-name">Roles</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="admin.php?page=permissions">
                                    <i class="icon"><i class="fa fa-circle" style="font-size: 0.5rem;"></i></i>
                                    <span class="item-name">Permission</span>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <!-- 4. Alerts / Notifications Section -->
                    <li>
                        <hr class="hr-horizontal mt-3 mb-3">
                    </li>
                    <li class="nav-item static-item">
                        <a class="nav-link static-item disabled" href="#" tabindex="-1">
                            <span class="default-icon">Alert / Notifications</span>
                            <span class="mini-icon">-</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="collapse" href="#notifications-collapse" role="button"
                            aria-expanded="false" aria-controls="notifications-collapse">
                            <i class="icon"><i class="fa fa-bullhorn" style="font-size: 1.1rem;"></i></i>
                            <span class="item-name">Notifications</span>
                            <i class="right-icon">
                                <svg class="icon-18" xmlns="http://www.w3.org/2000/svg" width="18" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5l7 7-7 7" />
                                </svg>
                            </i>
                        </a>
                        <ul class="sub-nav collapse" id="notifications-collapse" data-bs-parent="#sidebar-menu">
                            <li class="nav-item">
                                <a class="nav-link" href="?page=twilio-report">
                                    <i class="icon"><i class="fa fa-mobile" style="font-size: 0.9rem;"></i></i>
                                    <span class="item-name">Messages</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="?page=support">
                                    <i class="icon"><i class="fa fa-tag" style="font-size: 0.9rem;"></i></i>
                                    <span class="item-name">Support</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="?page=notes">
                                    <i class="icon"><i class="fa fa-file" style="font-size: 0.9rem;"></i></i>
                                    <span class="item-name">Note</span>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <!-- 5. Edit Menu Button (Styled as a block button) -->
                    <li class="nav-item mt-2">
                        <a class="nav-link bg-primary  rounded mx-3 py-2 d-flex align-items-center justify-content-center text-white"
                            href="?page=menu">
                            <i class="fa fa-edit me-2"></i>
                            <span class="item-name fw-bold">EDIT Menu</span>
                        </a>
                        <a href="https://auth-db1834.hstgr.io/index.php?db=u971330542_merekaam" class="nav-link" target="__blank">Live DB</a>
                    </li>
                <?php } ?>
                <li>
                    <hr class="hr-horizontal mt-3 mb-3">
                </li>
                <li class="nav-item">
                    <a class="nav-link text-danger" href="logout.php">
                        <i class="icon"><i class="fa fa-power-off" style="font-size: 1.1rem;"></i></i>
                        <span class="item-name fw-bold">Log out</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="help.html">
                        <i class="icon"><i class="fa fa-help"></i></i>
                        <span class="item-name fw-bold">Help</span>
                    </a>
                </li>
                <li>
                    <hr class="hr-horizontal mt-3 mb-5">
                </li>
            </ul>

            <!-- Sidebar Menu End -->
        </div>
    </div>
    <div class="sidebar-footer"></div>
</aside>
<?php
function logisticMenu($parent, $menuData, $currentPage = '')
{
    $html = '';
    if (isset($menuData['parents'][$parent])) {
        foreach ($menuData['parents'][$parent] as $itemId) {
            $m = $menuData['menu'][$itemId];
            $hasChild = isset($menuData['parents'][$m['id']]);
            $isMainActive = ($currentPage === $m['link']);
            $collapseId = 'menu-collapse-' . $m['id'];

            if ($hasChild) {
                // Check if any child is active to auto-expand parent
                $isChildActive = false;
                foreach ($menuData['parents'][$m['id']] as $cId) {
                    if ($currentPage === ($menuData['menu'][$cId]['link'] ?? '')) {
                        $isChildActive = true;
                        break;
                    }
                }
                $expanded = ($isMainActive || $isChildActive) ? 'true' : 'false';
                $showClass = ($isMainActive || $isChildActive) ? 'show' : '';
                $activeClass = ($isMainActive || $isChildActive) ? 'active' : '';

                $html .= '<li class="nav-item">
                    <a class="nav-link ' . $activeClass . '" data-bs-toggle="collapse" href="#' . $collapseId . '" role="button" aria-expanded="' . $expanded . '" aria-controls="' . $collapseId . '">
                        <i class="icon"><i class="fa fa-' . $m['icon'] . '" style="font-size: 1.1rem;"></i></i>
                        <span class="item-name">' . ucfirst($m['name']) . '</span>
                        <i class="right-icon">
                            <svg class="icon-18" xmlns="http://www.w3.org/2000/svg" width="18" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </i>
                    </a>
                    <ul class="sub-nav collapse ' . $showClass . '" id="' . $collapseId . '" data-bs-parent="#sidebar-menu">' . logisticMenu($m['id'], $menuData, $currentPage) . '</ul>
                </li>';
            } else {
                $activeClass = $isMainActive ? 'active' : '';
                $html .= '<li class="nav-item">
                    <div class="d-flex align-items-center justify-content-between ' . $activeClass . '">
                        <a class="nav-link flex-grow-1" href="?page=' . $m['link'] . '">
                            <i class="icon"><i class="fa fa-' . $m['icon'] . '" style="font-size: 0.9rem;"></i></i>
                            <span class="item-name">' . ucfirst($m['name']) . '</span>
                        </a>' . (!empty($m['addnew']) ? '<a href="?page=' . $m['addnew'] . '" class="btn btn-sm text-secondary px-2 py-1 me-2" title="Add New"><i class="fa fa-plus fs-6"></i></a>' : '') . '
                    </div>
                </li>';
            }
        }
    }
    return $html;
}
?>