<?php
if (isset($_GET['rId'])) {
  $rId = intval($_GET['rId']);

  if (isset($_POST['upPerm'])) {
    // Ensure permId is set and is an array
    if (isset($_POST['permId']) && is_array($_POST['permId'])) {
      for ($i = 0; $i < count($_POST['permId']); $i++) {
        $permId = intval($_POST['permId'][$i]);

        // Safely capture checkbox values (default to 0 if unchecked)
        $isRead = isset($_POST['read'][$i]) ? 1 : 0;
        $isWrite = isset($_POST['write'][$i]) ? 1 : 0;
        $isEdit = isset($_POST['edit'][$i]) ? 1 : 0;
        $isDelete = isset($_POST['delete'][$i]) ? 1 : 0;

        $checkData = dbAction('permission_role', 4, '', 'role_id=' . $rId . ' AND permission_id=' . $permId);

        $formData = array(
          'role_id' => $rId,
          'permission_id' => $permId,
          'isRead' => $isRead,
          'isWrite' => $isWrite,
          'isEdit' => $isEdit,
          'isDelete' => $isDelete
        );

        if ($checkData->num_rows > 0) {
          $permUpdate = dbAction('permission_role', 2, $formData, 'role_id=' . $rId . ' AND permission_id=' . $permId);
          if ($permUpdate[0] != 1) {
            mgs($permUpdate[1], 0);
            break;
          }
        } else {
          $permInsert = dbAction('permission_role', 1, $formData);
          if ($permInsert[0] != 1) {
            mgs($permInsert[1], 0);
            break;
          }
        }
      }
      // Redirect once after looping through all updates/inserts
      echo "<script>window.location.href=''</script>";
      exit;
    }
  }
}

// FETCH ALL ASSIGNED PERMISSIONS FOR THIS ROLE ONCE (Solves N+1 Query Problem)
$assignedPerms = [];
if (isset($rId)) {
  $assignedQuery = dbAction('permission_role', 4, '', 'role_id=' . $rId);
  if ($assignedQuery && $assignedQuery->num_rows > 0) {
    while ($row = mysqli_fetch_assoc($assignedQuery)) {
      $assignedPerms[$row['permission_id']] = $row;
    }
  }
}
?>

<form method="post" id="form">
  <div class="card">
    <div class="card-header p-4">
      <h3 class="card-title float-start"><i class="fa fa-lock"></i> Permissions Status</h3>
      <div class="card-tools float-end">
        <div class="icheck-secondary d-inline">
          <input type="checkbox" class="selectall" id="selctAll">
          <label for="selctAll"></label>
        </div>
        <button type="submit" name="upPerm" class="btn btn-xs btn-warning"><i class="fa fa-save"></i> Update</button>
        <a href="javascript:history.back()" class="btn btn-xs btn-default">Cancel</a>
        <a href="?page=permissions" class="btn btn-primary btn-xs"><i class="fa fa-edit"></i> Module Management</a>
      </div>
    </div>

    <div class="card-body table-responsive">
      <table class="table table-hover table-no-border table-striped table-sm">
        <thead>
          <tr>
            <th style="width: 70px;">#</th>
            <th>Name</th>
            <th class="text-center text-white bg-info" style="width: 70px;">isRead <input type="checkbox" id="isRead" /></th>
            <th class="text-center text-white bg-primary" style="width: 70px;">isCreate <input type="checkbox" id="isWrite" /></th>
            <th class="text-center text-white bg-warning" style="width: 70px;">isEdit <input type="checkbox" id="isEdit" /></th>
            <th class="text-center text-white bg-danger" style="width: 70px;">isDelete <input type="checkbox" id="isDelete" /></th>
          </tr>
        </thead>
        <tbody>
          <?php
          $permissions = dbAction('permissions', 4);
          if ($permissions && $permissions->num_rows > 0) {
            $idkey = 0;
            foreach ($permissions as $permRol) {
              $permId = $permRol['id'];
              $idGen = $permRol['name'] . '_' . $idkey++;

              // Get assigned values from our pre-fetched array (Defaults to 0 if not set)
              $pData = isset($assignedPerms[$permId]) ? $assignedPerms[$permId] : [];
              $isReadChecked = !empty($pData['isRead']) ? 'checked' : '';
              $isWriteChecked = !empty($pData['isWrite']) ? 'checked' : '';
              $isEditChecked = !empty($pData['isEdit']) ? 'checked' : '';
              $isDeleteChecked = !empty($pData['isDelete']) ? 'checked' : '';
              ?>
              <tr>
                <td><?php echo $permId; ?><input type="hidden" name="permId[]" value="<?php echo $permId; ?>"></td>
                <td><?php echo ucfirst($permRol['name']); ?></td>

                <!-- Read -->
                <td class="text-center border-info" style="border:none;border-left:1px solid">
                  <div class="icheck-info d-inline">
                    <input type="checkbox" name="read[]" class="individual isRead" value="1" <?php echo $isReadChecked; ?>
                      id="read<?php echo $idGen . "_1"; ?>">
                    <label for="read<?php echo $idGen . "_1"; ?>"></label>
                  </div>
                </td>

                <!-- Write / Create -->
                <td class="text-center border-primary" style="border:none;border-left:1px solid">
                  <div class="icheck-primary d-inline">
                    <input type="checkbox" name="write[]" class="individual isWrite" value="1" <?php echo $isWriteChecked; ?> id="write<?php echo $idGen . "_2"; ?>">
                    <label for="write<?php echo $idGen . "_2"; ?>"></label>
                  </div>
                </td>

                <!-- Edit -->
                <td class="text-center border-warning" style="border:none;border-left:1px solid">
                  <div class="icheck-warning d-inline">
                    <input type="checkbox" name="edit[]" class="individual isEdit" value="1" <?php echo $isEditChecked; ?>
                      id="edit<?php echo $idGen . "_3"; ?>">
                    <label for="edit<?php echo $idGen . "_3"; ?>"></label>
                  </div>
                </td>

                <!-- Delete -->
                <td class="text-center border-danger" style="border:none;border-left:1px solid">
                  <div class="icheck-danger d-inline">
                    <input type="checkbox" name="delete[]" class="individual isDelete" value="1" <?php echo $isDeleteChecked; ?> id="delete<?php echo $idGen . "_4"; ?>">
                    <label for="delete<?php echo $idGen . "_4"; ?>"></label>
                  </div>
                </td>
              </tr>
              <?php
            }
          }
          ?>
        </tbody>
      </table>
    </div>
    <div class="card-footer text-right">
      <button type="submit" name="upPerm" class="btn btn-warning"><i class="fa fa-save"></i> Update
        Permission</button>
      <a href="javascript:history.back()" class="btn btn-default">Cancel</a>
    </div>
  </div>
</form>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script type="text/javascript">
  // Removed the submit event hack that forces checkboxes to checked/0, 
  // as PHP now safely handles missing array indices via isset() checks.

  $(".selectall").click(function () {
    $(".individual").prop("checked", $(this).prop("checked"));
  });
  $("#isRead").click(function () {
    $(".isRead").prop("checked", $(this).prop("checked"));
  });
  $("#isWrite").click(function () {
    $(".isWrite").prop("checked", $(this).prop("checked"));
  });
  $("#isEdit").click(function () {
    $(".isEdit").prop("checked", $(this).prop("checked"));
  });
  $("#isDelete").click(function () {
    $(".isDelete").prop("checked", $(this).prop("checked"));
  });
</script>