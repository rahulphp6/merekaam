<?php
$id = $_SESSION['id'] ?? null;

if (!$id) {
  mgs('Your Session is not Valid!', 0);
  exit;
}

if (isAdmin() && isset($_GET['pEid'])) {
  $id = $_GET['pEid'];
}

$user_id = isAdmin() && isset($_GET['user_id']) ? $_GET['user_id'] : ($user_row['user_id'] ?? null);

// Zoho API Refresh
if (isset($_GET['refresh'])) {
  $isUsers = getApiData('', "users/me");
  if (isset($isUsers->user)) {
    $user = $isUsers->user;
    $upuserAr = [
      "email" => $user->email,
      "name" => trim($user->name),
      "apiStatus" => $user->status,
      "store" => organizationId,
      "photo_url" => $user->photo_url,
      "is_employee" => $user->is_employee,
    ];
    $data = dbAction('users', 2, $upuserAr, 'user_id=' . $user->user_id);
    if ($data[0] == 1) {
      echo "<script>alert('User Updated Successfully!'); window.location.href='" . constant("BASE") . "?page=profile';</script>";
    } else {
      mgs($data[1], 0);
    }
  }
}

// Profile Info Update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['profleUpdate'])) {
  extract($_POST);
  $uname = !empty($UserName) ? $UserName : trim(str_replace(' ', '', $name)) . "-" . $user_id;
  $profileData = [
    "UserName" => $uname,
    "name" => $name,
    "LastName" => $LastName,
    "phone" => $phone,
    "email" => $email
  ];
  $data = dbAction('users', 2, $profileData, 'store=' . organizationId . ' AND id=' . (int) $id);
  $data[0] == 1 ? redirectTo('', 2, 'User Updated Successfully!') : mgs($data[1], 0);
}

// DP Update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['upDp'])) {
  if (!empty($_FILES['dpPic']['name'])) {
    $dpPic = ["profilePic" => imgUpload("dpPic", "teams-dp")];
    $dataUp = dbAction('users', 2, $dpPic, 'id=' . (int) $id);
    $dataUp[0] == 1 ? redirectTo('', 2, 'DP Updated Successfully!') : mgs($dataUp[1], 0);
  }
}

// Password Update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['password']) && isset($_POST['uid'])) {
  $security_id = isUser() ? $user_id : $_POST['uid'];
  $data = ['password' => password_hash($_POST['password'], PASSWORD_DEFAULT)];
  $update = secureDbAction('users', 2, $data, 'id = ?', [$security_id]);
  $update['success'] ? redirectTo('', 2, 'Password updated successfully!') : redirectTo('', 2, $update['error'], 'error');
}
function imgUpload($fileName = "", $folder = "")
{

  $fileData = $_FILES[$fileName];

  if (isset($fileData)) {

    if (!empty($fileData["name"])) {

      $allowedExts = array("jpg", "jpeg", "png");
      // $allowedExts = array("jpg", "jpeg", "png","pdf","doc","docx","","xls");
      $nameOfimg = str_replace(" ", "-", $fileData["name"]);

      $tmp = $fileData["tmp_name"];

      $orginal = $fileData["name"];



      $type = strtolower($orginal);

      $type = str_replace(" ", "-", $type);

      $extArray = explode(".", $type);

      $extension = $extArray[1];

      $name = $extArray[0] . "." . $extension;



      $target_dir = "upload/" . $folder . "/" . $extArray[0] . "/";

      if (!file_exists($target_dir)) {
        mkdir($target_dir, 0777, true);
      }
      $target_file = $target_dir . $name;

      if (in_array($extension, $allowedExts)) {

        $fileC = trim($target_file);

        move_uploaded_file($tmp, $target_file);

        return $fileC;
      }
    }
  }
}
$usersDb = secureDbAction('users', 4, []);
if (!isAdmin()) {
  $usersDb = secureDbAction('users', 4, [], 'id=?', [$uid]);
}
?>
<div class="p-4">
  <div class="row g-4">

    <!-- Left Sidebar -->
    <div class="col-lg-4">

      <!-- Dynamic Target/Goals Card (From original code) -->
      <div class="card adv-card mb-4">
        <div class="col-12 profile-avatar-wrapper d-flex flex-column align-items-center">
          <div class="position-relative d-inline-block">
            <img src="<?php echo !empty($getDp) ? $getDp : 'images/default-avatar.png'; ?>" alt="Profile Picture"
              class="profile-avatar">

            <?php if (isAdmin()): ?>
              <button type="button" class="btn btnsm" data-bs-toggle="modal" data-bs-target="#module_pop"
                title="Change Picture">
                <i class="fa fa-camera"></i>
              </button>
            <?php endif; ?>
          </div>

          <h3 class="fw-bold mt-3 mb-0"><?php echo ucfirst($user_row['name'] ?? 'User'); ?></h3>
          <p class="text-muted fw-medium mb-2">
            <?php echo !empty($user_row['depid']) ? ucfirst(getName('departments', $user_row['depid'])) : "Department: NA"; ?>
          </p>

          <!-- Quick Actions -->
          <div class="d-flex gap-2 mt-2">
            <?php if (!isAdmin()): ?>
              <a href="https://accounts.zoho.com/home#profile/personal" target="_blank"
                class="btn btn-light px-4 rounded-pill border shadow-sm">
                <i class="fa fa-cogs me-2"></i>Change DP via Zoho
              </a>
            <?php endif; ?>
          </div>
        </div>
      </div>

      <!-- Dynamic Contact Details -->
      <div class="card adv-card mb-4">
        <div class="card-body">
          <h6 class="fw-bold text-uppercase text-muted mb-3">Contact Details</h6>
          <ul class="list-unstyled info-list m-0">
            <li>
              <span class="text-muted"><i class="fa fa-envelope me-2"></i>Email</span>
              <span class="fw-medium text-truncate" style="max-width: 150px;"
                title="<?php echo htmlspecialchars($user_row['email'] ?? 'N/A'); ?>">
                <?php echo htmlspecialchars($user_row['email'] ?? 'N/A'); ?>
              </span>
            </li>
            <li>
              <span class="text-muted"><i class="fa fa-phone me-2"></i>Phone</span>
              <span class="fw-medium"><?php echo htmlspecialchars($user_row['phone'] ?? 'N/A'); ?></span>
            </li>
            <li>
              <span class="text-muted"><i class="fa fa-user me-2"></i>Username</span>
              <span class="fw-medium"><?php echo htmlspecialchars($user_row['UserName'] ?? 'N/A'); ?></span>
            </li>
          </ul>
        </div>
      </div>
    </div>

    <!-- Right Tabs -->
    <div class="col-lg-8">
      <div class="card adv-card h-100">
        <div class="card-header bg-white border-bottom-0 pt-4 pb-0 px-4">
          <ul class="nav nav-tabs profile-tabs" id="profileTabs" role="tablist">
            <li class="nav-item" role="presentation">
              <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#edit-profile" type="button"
                role="tab" aria-controls="edit-profile" aria-selected="true">
                <i class="fa fa-user-edit me-2"></i>Edit Profile
              </button>
            </li>
            <li class="nav-item" role="presentation">
              <button class="nav-link" data-bs-toggle="tab" data-bs-target="#security" type="button" role="tab"
                aria-controls="security" aria-selected="false">
                <i class="fa fa-shield-alt me-2"></i>Security
              </button>
            </li>
            <li class="nav-item" role="presentation">
              <button class="nav-link" data-bs-toggle="tab" data-bs-target="#activity" type="button" role="tab"
                aria-controls="activity" aria-selected="false">
                <i class="fa fa-history me-2"></i>Activity
              </button>
            </li>
          </ul>
        </div>

        <div class="card-body p-4">
          <div class="tab-content" id="profileTabsContent">

            <!-- Tab 1: Edit Profile -->
            <div class="tab-pane fade show active" id="edit-profile" role="tabpanel">
              <form method="post">
                <div class="row g-3">
                  <div class="col-md-6">
                    <label class="form-label text-muted small fw-bold">First Name</label>
                    <input type="text" name="name" class="form-control form-control-lg bg-light border-0"
                      value="<?php echo htmlspecialchars($user_row['name'] ?? ''); ?>">
                  </div>
                  <div class="col-md-6">
                    <label class="form-label text-muted small fw-bold">Last Name</label>
                    <input type="text" name="LastName" class="form-control form-control-lg bg-light border-0"
                      value="<?php echo htmlspecialchars($user_row['LastName'] ?? ''); ?>">
                  </div>
                  <div class="col-md-6">
                    <label class="form-label text-muted small fw-bold">Username</label>
                    <input type="text" name="UserName" class="form-control form-control-lg bg-light border-0"
                      value="<?php echo htmlspecialchars($user_row['UserName'] ?? ''); ?>">
                  </div>
                  <div class="col-md-6">
                    <label class="form-label text-muted small fw-bold">Phone Number</label>
                    <input type="text" name="phone" class="form-control form-control-lg bg-light border-0"
                      value="<?php echo htmlspecialchars($user_row['phone'] ?? ''); ?>">
                  </div>
                  <div class="col-md-12"><label class="form-label text-muted small fw-bold">Email</label>
                    <input type="email" name="email" class="form-control form-control-lg  bg-light border-0"
                      value="<?php echo htmlspecialchars($user_row['email'] ?? ''); ?>" <?php echo !isAdmin() ? "disabled" : ""; ?>>
                  </div>
                  <div class="col-12 mt-4 d-flex gap-2">
                    <input type="submit" name="profleUpdate" class="btn btn-primary px-4 shadow-sm"
                      value="Save Changes">
                    <?php if (!isAdmin()): ?>
                      <a href="?page=profile&refresh=1" class="btn btn-success px-4 shadow-sm"><i
                          class="fa fa-sync me-2"></i>Sync Zoho</a>
                    <?php endif; ?>
                  </div>
                </div>
              </form>
            </div>

            <div class="tab-pane fade" id="security" role="tabpanel">
              <form method="post">
                <div class="row g-3">
                  <div class="col-12 mb-3">
                    <label class="form-label text-muted small fw-bold">Select User (Admin Only)</label>
                    <select name="uid" class="form-control form-control-lg bg-light border-0 select2">
                      <?php
                      foreach ($usersDb['data'] ?? [] as $u) {
                        echo '<option value="' . (int) $u['id'] . '">' . htmlspecialchars($u['name']) . '</option>';
                      }
                      ?>
                    </select>
                  </div>
                  <div class="col-md-12">
                    <label class="form-label text-muted small fw-bold">New Password</label>
                    <div class="input-group">
                      <input type="password" name="password" id="password"
                        class="form-control form-control-lg bg-light border-0" placeholder="Enter new password"
                        required>
                      <button class="btn btn-light border-0 bg-light px-3" type="button" id="togglePassword">
                        <i class="fa fa-eye text-muted"></i>
                      </button>
                    </div>
                  </div>
                  <div class="col-12 mt-4">
                    <button type="submit" class="btn btn-danger px-4 shadow-sm"><i class="fa fa-lock me-2"></i>Update
                      Password</button>
                  </div>
                </div>
              </form>
            </div>

            <!-- Tab 3: Activity / Tasks -->
            <div class="tab-pane fade" id="activity" role="tabpanel">
              <div class="text-center py-5 text-muted">
                <i class="fa fa-inbox fa-3x mb-3 text-light"></i>
                <h5>No recent activity found.</h5>
                <p class="small">Your tasks and assigned projects will appear here.</p>
              </div>
            </div>

          </div>
        </div>
      </div>
    </div>

  </div>
</div>

<div class="modal fade" id="module_pop" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <form method="post" enctype="multipart/form-data" class="w-100">
      <style>
        /* Optional: Adds a smooth transition when hovering over the upload area */
        .upload-drop-zone {
          transition: all 0.3s ease-in-out;
        }

        .upload-drop-zone:hover {
          background-color: #eef3fc !important;
          border-color: #0d6efd !important;
        }
      </style>

      <div class="modal-content border-0 shadow-lg overflow-hidden" style="border-radius: 16px;">

        <!-- Fancy Header: Colored background with white text -->
        <div class="modal-header bg-primary text-white border-0 px-4 py-3">
          <h5 class="modal-title fw-bold">
            <i class="fa fa-camera-retro me-2"></i>Update Profile Picture
          </h5>
          <button type="button" class="btn-close btn-close-white shadow-none" data-bs-dismiss="modal"
            aria-label="Close"></button>
        </div>

        <!-- Modal Body -->
        <div class="modal-body p-4 p-md-5">

          <!-- Modern "Dropzone" File Input -->
          <div
            class="position-relative border border-2 border-primary rounded-4 p-5 text-center bg-light upload-drop-zone"
            style="border-style: dashed !important;">

            <!-- Invisible input covering the whole dashed box -->
            <input type="file" class="position-absolute top-0 start-0 w-100 h-100 opacity-0" name="dpPic"
              id="dpPicInput" accept="image/*" style="cursor: pointer; z-index: 2;" required>

            <!-- Visual Elements -->
            <div class="mb-3">
              <div
                class="d-inline-flex align-items-center justify-content-center bg-white text-primary rounded-circle shadow-sm"
                style="width: 65px; height: 65px;">
                <i class="fa fa-cloud-upload-alt fs-2"></i>
              </div>
            </div>
            <h6 class="fw-bold text-dark mb-1">Click to browse or drag image here</h6>
            <p class="small text-muted mb-0">Supports JPG, PNG, or GIF</p>

          </div>

          <!-- Enhanced Info Alert -->
          <div
            class="mt-4 d-flex align-items-start bg-primary bg-opacity-10 p-3 rounded-3 border border-primary border-opacity-25">
            <i class="fa fa-info-circle text-primary fs-5 me-3 mt-1"></i>
            <p class="small text-dark mb-0">
              For the best display results, please upload a square image (e.g., <strong>400x400</strong> px).
            </p>
          </div>

        </div>

        <!-- Modal Footer -->
        <div class="modal-footer border-0 px-4 pb-4 pt-0 d-flex justify-content-between">
          <button type="button" class="btn btn-light btn-lg rounded-pill px-4 fw-medium text-muted shadow-sm"
            data-bs-dismiss="modal">
            Cancel
          </button>
          <button type="submit" name="upDp" class="btn btn-primary btn-lg rounded-pill px-5 fw-bold shadow-sm">
            <i class="fa fa-upload me-2"></i>Upload Image
          </button>
        </div>

      </div>
    </form>
  </div>
</div>

<script>
  document.getElementById('dpPicInput').addEventListener('change', function (e) {
    if (e.target.files.length > 0) {
      const fileName = e.target.files[0].name;
      const textElement = this.nextElementSibling.nextElementSibling;
      textElement.innerHTML = `<span class="text-primary">Selected: ${fileName}</span>`;
    }
  });
  // Password visibility toggle
  document.getElementById('togglePassword').addEventListener('click', function () {
    const input = document.getElementById('password');
    const icon = this.querySelector('i');
    const isVisible = input.type === 'text';
    input.type = isVisible ? 'password' : 'text';
    icon.className = isVisible ? 'fa fa-eye text-muted' : 'fa fa-eye-slash text-muted';
  });

  // File input label update
  if (document.querySelector('.custom-file-input')) {
    document.querySelector('.custom-file-input').addEventListener('change', function (e) {
      var fileName = e.target.files[0].name;
      var nextSibling = e.target.nextElementSibling;
      nextSibling.innerText = fileName;
    });
  }
</script>