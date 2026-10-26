<?php
// Assigning Roles
if (isset($_POST['assignRole'])) {
  $roleUpAr = array("role" => $_POST['roleid']);
  // $roleUpAr=array_merge($_POST,$roleUpAr);
  // unset($roleUpAr['assignRole']);
  $dataRole = dbAction('users', 2, $roleUpAr, 'id=' . $_POST['userid']);
  if ($dataRole[0] == 1) {
    mgs('Role Assigned Successfully');
  } else {
    mgs($dataRole[1], 0);
  }
}
// permissions
if (isset($_POST['addPerm'])) {
  $dataPermission = dbAction('permissions', 1);
  if ($dataPermission[0] == 1) {
    mgs('Permission Create Successfully');
  } else {
    mgs($dataPermission[1], 0);
  }
}
?>
<!-- Main content -->
<div class="content py-3">
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">
        <div class="card shadow-sm">
          <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title mb-0" id="crudTitle"><?php echo ucfirst($page); ?> Detail</h3>
            <div class="btn-group ms-auto">
              <button class="btn btn-primary btn-sm" data-bs-toggle="offcanvas" data-bs-target="#crudFilter">
                <i class="fa fa-sort"></i> Filters
              </button>
              <button class="btn btn-primary btn-sm" data-bs-toggle="offcanvas" data-bs-target="#crudCanvas"
                onclick="openModal()">
                <i class="fa fa-plus"></i> Add
              </button>
              <!-- <button type="button" class="btn btn-warning btn-xs" data-toggle="modal" data-target="#addPermission"><i
                  class="fa fa-plus"></i> Permission</button> -->
              <button type="button" class="btn btn-danger btn-xs" data-bs-toggle="offcanvas"
                data-bs-target="#assignRole"><i class="fa fa-exchange"></i> Assing Role</button>
            </div>
          </div>
          <div class="card-body">
            <div class="btn-group d-none mb-3 sticky-top bg-white py-2" id="bulkmode">
              <button id="bulkDeleteBtn" class="btn btn-sm btn-danger" onclick="bulkDelete()">
                <i class="fa fa-trash"></i> Delete
              </button>
              <button id="bulkBlockBtn" class="btn btn-sm btn-warning" onclick="bulkToggleStatus(0)">
                <i class="fa fa-ban"></i> Block
              </button>
              <button id="bulkUnblockBtn" class="btn btn-sm btn-success" onclick="bulkToggleStatus(1)">
                <i class="fa fa-circle"></i> Unblock
              </button>
            </div>
            <div id="deptable" class="table-responsive"></div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Offcanvas Panel -->
<?php include_once 'temp-parts/canvas.php'; ?>
<div class="offcanvas offcanvas-end" id="assignRole" tabindex="-1" aria-labelledby="assignRoleLabel">
  <div class="offcanvas-header">
    <h5 class="offcanvas-title" id="assignRoleLabel">Assign Role</h5>
    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
  </div>
  <form method="post" class="offcanvas-body needs-validation" enctype="multipart/form-data">
    <?php
    renderDropdown('roleId', 'roles', 'Select User');
    ?>
    <div class="mt-4 d-flex justify-content-end gap-2">
      <button type="submit" class="btn btn-primary" name="assignRole"><i class="fa fa-save"></i> Assign</button>
      <button type="button" class="btn btn-secondary" data-bs-dismiss="offcanvas">
        <i class="fa fa-share"></i> Cancel
      </button>
    </div>
  </form>
</div>
<div class="modal fade in" id="addPermission">
  <form method="post" enctype="multipart/form-data">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4>Add Permission</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">x</button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-md-12">
              <div class="form-group form-group-icon-left">
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fa fa-tasks input-icon"></i></span>
                  </div>
                  <input class="form-control" name="name" placeholder="Module Name" type="text" required />
                </div>
              </div>
            </div>
            <div class="col-md-12">
              <div class="form-group form-group-icon-left">
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fa fa-file input-icon"></i></span>
                  </div>
                  <textarea class="form-control" name="description"></textarea>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <input type="submit" name="addPerm" class="btn btn-primary" value="Add Permission">
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </form>
</div>
<script>
  // Re-init Select2 when offcanvas is shown
  document.getElementById('assignRole').addEventListener('shown.bs.offcanvas', function () {
    posSelect("userid", "Select a user", "assignRole");
    posSelect("roleid", "Select a role", "assignRole");
  });
  window.crudConfig = {
    action: 'filter',
    table: 'roles',
    columns: ['name', 'description']
  };
</script>