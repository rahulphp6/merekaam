<div class="content">
    <div class="container-fluid">
        <?php
        $todoQ = dbAction('setting', 4, "","store=" . organizationId);
        if (isset($todoQ->num_rows)) {
            if ($todoQ->num_rows > 0) {
                $list = $todoQ->fetch_assoc();
                extract($list);
                if (isset($_POST['save_setting'])) {
                    $data = array_merge($_POST, ["store" => organizationId]);
                    unset($data['save_setting']);
                    $query = dbAction('setting', 2, $data, "store=" . organizationId, 1);
                    if ($query[0]) {
                        // mgs('Setting Saved!');
                        echo "<script>window.location.href=''</script>";
                    } else {
                        mgs($query[1], 0);
                    }
                }
            }

        ?>
            <div class="row">
                <div class="col-md-12">
                    <div class="card mycard">
                        <div class="card-header">
                            <h3 class="card-title">Settings</h3>
                            <div class="btn-group pull-right">
                            </div>
                        </div>
                        <form method="post" id="form">
                            <div class="card-body bg-white">
                                <table class="table table-striped table-valign-middle">
                                    <thead>
                                        <tr>
                                            <th>Setting</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $set = queryRun("SHOW COLUMNS FROM setting", 3);
                                        $idd = 0;
                                        foreach ($set as $row) {
                                            if ($idd > 0 && $row['Field'] != "store") {
                                                if ($list[$row['Field']] == 1) {
                                                    $enabled = "checked";
                                                    $icon = "unlock text-danger";
                                                } else {
                                                    $enabled = "";
                                                    $icon = "lock text-primary";
                                                }
                                        ?>
                                                <tr>
                                                    <td><i class="fa fa-<?php echo $icon; ?>"></i> <?php echo ucwords($row['Field']); ?></td>
                                                    <td><?php //echo $list[$row['Field']]; ?>
                                                        <div class="custom-control custom-switch custom-switch-on-success custom-switch-off-danger">
                                                            <input type="checkbox" value="1" name="<?php echo $row['Field']; ?>" class="custom-control-input" id="switch_<?php echo $idd; ?>" <?php echo $enabled; ?>>
                                                            <label class="custom-control-label" for="switch_<?php echo $idd; ?>"></label>
                                                        </div>
                                                    </td>
                                                </tr>
                                        <?php }
                                            $idd++;
                                        }

                                        ?>
                                    </tbody>
                                </table>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary btn-xs btn-sm" name="save_setting"><i class="fa fa-save"></i> Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- /.row -->
        <?php } ?>
    </div><!-- /.container-fluid -->
</div>
<script type="text/javascript">
    $(document).ready(function() {
        $("#form").on('submit', function() {
            // to each unchecked checkbox
            $(this).find('input[type=checkbox]:not(:checked)').prop('checked', true).val(0);
        })
    });
</script>