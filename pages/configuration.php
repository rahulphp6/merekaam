<?php
if (isset($_POST['taxConfig'])) {
  $taxupAr = array("store" => organizationId, "vat_tax" => $_POST['vat_tax'], "tax_id" => $_POST['tax_id']);
  // print_r($_POST);
  $taxinsert = dbAction("tax", 1, $taxupAr);
  if (!$taxinsert[0]) {
    $taxupSt = dbAction('tax', 2, $taxupAr, "store='" . organizationId . "'");
    if ($taxupSt[0] == 1) {
      echo "<script>window.location.href=''</script>";
    } else {
      mgs($taxupSt[0], 1);
    }
  }
}
if (isset($_POST['zeroTaxConfig'])) {
  $taxupAr = array("zero_tax" => $_POST['zero_tax'], "zero_tax_id" => $_POST['zero_tax_id']);
  // print_r($_POST);
  $taxupSt = dbAction('tax', 2, $taxupAr, "store='" . organizationId . "'");
  if ($taxupSt[0] == 1) {
    echo "<script>window.location.href=''</script>";
  } else {
    mgs($taxupSt[0], 1);
  }
}
if (!empty($_POST['genConfig'])) {
  $idd = $id = $_POST['idd'] ?? '';

  if (empty($idd)) {
    mgs("Missing record ID for update", 0);
    return;
  }

  // Normalize chat flag
  $_POST['chat'] = !empty($_POST['chat']) ? 1 : 0;

  // Remove non‑DB fields
  unset($_POST['genConfig'], $_POST['idd'], $_POST['vat_tax'], $_POST['zero_tax']);

  // Run update
  $configQuery = dbAction('configuration', 2, $_POST, "id={$idd}");

  if (!empty($configQuery[0]) && $configQuery[0] == 1) {
    mgs("Configuration Updated Successfully", 1);
  } else {
    mgs($configQuery[1] ?? "Update failed", 0);
  }
}
?>

<form method="post" enctype="multipart/form-data" class="full_width">
  <div class="card">
    <div class="card-header">
      <h3 class="card-title">Configuration</h3>
    </div>
    <div class="card-body">
      <div class="row">
        <div class="col-md-6">
          <div class="form-group form-group-icon-left">
            <label>Business Name</label>
            <div class="input-group mb-3">
              <div class="input-group-prepend">
                <span class="input-group-text"><i class="fa fa-user input-icon"></i></span>
              </div>
              <input type="hidden" value="<?php echo $Brand['id'] ?? ''; ?>" name="idd" />
              <input class="form-control" name="brand" value="<?php if (isBrand) {
                echo $Brand['brand'];
              } ?>" type="text" required />
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group form-group-icon-left">
            <label>Short Name</label>
            <div class="input-group mb-3">
              <div class="input-group-prepend">
                <span class="input-group-text"><i class="fa fa-user input-icon"></i></span>
              </div>
              <input class="form-control" name="short" value="<?php if (isBrand) {
                echo $Brand['short'];
              } ?>" type="text" required />
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group form-group-icon-left">
            <label>E-mail</label>

            <div class="input-group mb-3">
              <div class="input-group-prepend">
                <span class="input-group-text"><i class="fa fa-envelope input-icon"></i></span>
              </div>
              <input class="form-control" name="email" value="<?php if (isBrand) {
                echo $Brand['email'];
              } ?>" type="email" />
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group form-group-icon-left">
            <label>Phone Number</label>
            <div class="input-group mb-3">
              <div class="input-group-prepend">
                <span class="input-group-text"><i class="fa fa-phone input-icon"></i></span>
              </div>
              <input class="form-control" name="phone" value="<?php if (isBrand) {
                echo $Brand['phone'];
              } ?>" type="text" />
            </div>

          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group form-group-icon-left">
            <label>Tax Charge </label>
            <button type="button" class="btn btn-default btn-xs pull-right taxConfig" data-toggle="modal"
              data-target="#module_pop" id="taxConfig"><i class="fa fa-edit"></i> Configure</button>
            <div class="input-group mb-3">
              <div class="input-group-prepend">
                <span class="input-group-text"><i class="fa fa-money input-icon"></i></span>
              </div>
              <input class="form-control" disabled name="vat_tax" value="<?php echo vat_tax . "-" . tax_id; ?>"
                type="text" placeholder="Tax-10" />
            </div>

          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group form-group-icon-left">
            <label>Zero Rate Tax </label>
            <button type="button" class="btn btn-default btn-xs pull-right taxConfig" data-toggle="modal"
              data-target="#zeroTaxModel" id="zeroTaxConfig"><i class="fa fa-edit"></i>
              Configure</button>
            <div class="input-group mb-3">
              <div class="input-group-prepend">
                <span class="input-group-text"><i class="fa fa-money input-icon"></i></span>
              </div>
              <input class="form-control" disabled name="zero_tax" value="<?php echo zero_tax . "-" . zero_tax_id; ?>"
                type="text" />
            </div>

          </div>

        </div>
      </div>
      <div class="col-md-12">
        <div class="form-group">
          <label>Payments Mode</label>
          <button type="button" class="btn btn-info btn-xs pull-right paymentModes" id="paymentModes"><i
              class="fa fa-refresh"></i>
            Fetch</button>
          <textarea class="form-control textarea_payment_mode" name="payment_mode"><?php if (isBrand) {
            echo $Brand['payment_mode'];
          } ?></textarea>
        </div>
        <div class="form-group">
          <label>Carrier</label>
          <!-- <button type="button" class="btn btn-info btn-xs pull-right carrier" id="carrier"><i
              class="fa fa-refresh"></i>
            Fetch</button> -->
          <textarea class="form-control textarea_carrier" name="carrier"><?php if (isBrand) {
            echo $Brand['carrier'];
          } ?></textarea>
        </div>
        <div class="form-group">
          <label>Ret# Descriptions</label>
          <textarea class="form-control" name="ret_des"><?php if (isBrand) {
            echo $Brand['ret_des'];
          } ?></textarea>
        </div>
        <div class="form-group">
          <label>Address</label>
          <input type="text" class="form-control" name="address" value="<?php if (isBrand) {
            echo $Brand['address'];
          } ?>">
        </div>
        <div class="form-group">
          <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
            <input type="checkbox" class="custom-control-input" id="chat" name="chat" <?php if (!empty($chat) and $chat == 1) {
              echo 'checked';
            } ?>>
            <label class="custom-control-label" for="chat"> Chat Support</label>
          </div>
        </div>
      </div>
    </div>
    <div class="card-footer">
      <input type="submit" name="genConfig" value="Update Config" class="btn btn-primary">
    </div>
</form>
<div class="modal fade in" id="module_pop">
  <form method="post">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4>Edit Tax</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">x</button>
        </div>
        <div class="modal-body">
          <div id="taxStatus"></div>
          <div class="form-group form-group-icon-left">
            <label>TAX</label>
            <div class="input-group mb-3">
              <div class="input-group-prepend">
                <span class="input-group-text"><i class="fa fa-money input-icon"></i></span>
              </div>
              <select class="form-control VatLoadAPi taxLoadAPi" name="tax_id" id="taxLoadAPi">
              </select>
              <input type="text" name="vat_tax" class="vat_name" value="">
            </div>

          </div>
        </div>
        <div class="modal-footer">
          <input type="submit" value="Update" class="btn btn-primary" name="taxConfig">
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </form>
</div>
<div class="modal fade in" id="zeroTaxModel">
  <form method="post">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4>Edit Zero Tax</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">x</button>
        </div>
        <div class="modal-body">
          <div class="form-group form-group-icon-left">
            <label>TAX</label>
            <div class="input-group mb-3">
              <div class="input-group-prepend">
                <span class="input-group-text"><i class="fa fa-money input-icon"></i></span>
              </div>

              <select class="form-control taxLoadAPi" name="zero_tax_id" id="zeroTaxLoadAPi">
              </select>
              <input type="text" name="zero_tax" id="tax_name" value="">
            </div>

          </div>
        </div>
        <div class="modal-footer">
          <input type="submit" value="Update" class="btn btn-primary" name="zeroTaxConfig">
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </form>
</div>
<script>

  $(document).ready(function () {
    $("#paymentModes").on("click", function () {
      const $btn = $(this);
      $btn.prop("disabled", true).html('<i class="fa fa-spinner fa-spin"></i> Loading...');

      $.ajax({
        url: "model/get-data.php",
        type: "POST",
        data: { action: "paymentmodes" },
        success: function (response) {
          try {
            const data = JSON.parse(response);
            if (data.code === 0 && data.names) {
              $(".textarea_payment_mode").val(data.names.join(", "));
              boom("Payment modes fetched successfully!", "success");
            } else {
              boom("Error: " + (data.message || "Unable to fetch payment modes"), "error");
            }
          } catch (err) {
            boom("Invalid response format", "error");
            console.error("Invalid JSON:", response);
          }
        },
        error: function (xhr) {
          boom("AJAX error: " + xhr.statusText, "error");
        },
        complete: function () {
          $btn.prop("disabled", false).html('<i class="fa fa-refresh"></i> Fetch');
        }
      });
    });
    // lefted because of carrier api issue you can continue after find endpoint of api
    $("#carrier").on("click", function () {
      const $btn = $(this);
      $btn.prop("disabled", true).html('<i class="fa fa-spinner fa-spin"></i> Loading...');

      $.ajax({
        url: "model/get-data.php",
        type: "POST",
        data: { action: "carrier" },
        success: function (response) {
          try {
            const data = JSON.parse(response);
            if (data.code === 0 && data.names) {
              $(".textarea_carrier").val(data.names.join(", "));
              boom("Payment modes fetched successfully!", "success");
            } else {
              boom("Error: " + (data.message || "Unable to fetch payment modes"), "error");
            }
          } catch (err) {
            boom("Invalid response format", "error");
            console.error("Invalid JSON:", response);
          }
        },
        error: function (xhr) {
          boom("AJAX error: " + xhr.statusText, "error");
        },
        complete: function () {
          $btn.prop("disabled", false).html('<i class="fa fa-refresh"></i> Fetch');
        }
      });
    });
    // fetch tax options when tax config button is clicked
    $(".taxConfig").click(function () {
      $.ajax({
        url: 'model/ajax/search-item.php',
        type: 'post',
        data: {
          fetchTax: true
        },
        beforeSend: function () {
          $('.taxLoadAPi').html('<option>Loading....</option>');
        },
        success: function (response) {
          $('.taxLoadAPi').html(response);
        }
      });
    });
  });
</script>
<script>
  // $(".vat_name").val($('.VatLoadAPi option:selected').text());
  $('.VatLoadAPi').on('change', function () {
    $(".vat_name").val($(this).find("option:selected").text());
  });
  // zero rate
  // $(".tax_name").val($('.taxLoadAPi option:selected').text());
  $('.taxLoadAPi').on('change', function () {
    $("#tax_name").val($(this).find("option:selected").text());
  });
</script>