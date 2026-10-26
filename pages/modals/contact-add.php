<div class="modal fade modal-right" id="add_customer_modal" tabindex="-1" aria-labelledby="addCustomerLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Header -->
            <div class="modal-header">
                <h5 class="modal-title" id="addCustomerLabel">
                    <i class="bi bi-person-plus"></i> Add Customer
                </h5>
                <button type="button" class="btn-close btn-close-white" data-dismiss="modal"
                    aria-label="Close"></button>
            </div>

            <!-- Form -->
            <form method="post" class="register_form needs-validation dynamic_form" data-form="register_form" novalidate
                autocomplete="off">
                <div class="modal-body">
                    <div class="posApiRes mb-2"></div>
                    <input type="hidden" name="create_cust" value="1">

                    <!-- Customer Type -->
                    <div class="form-floating mb-3">
                        <select class="form-select" name="contact_type" id="contact_type" required>
                            <option value="">Select</option>
                            <option value="individual" selected>Individual</option>
                            <option value="business">Business</option>
                        </select>
                        <label for="contact_type">Customer Type *</label>
                        <div class="invalid-feedback">Please select a customer type.</div>
                    </div>

                    <!-- Salutation + First Name -->
                    <div class="row g-2 mb-3">
                        <div class="col-md-4">
                            <div class="form-floating">
                                <select class="form-select" name="salutation" id="salutation" required>
                                    <option value="">Select</option>
                                    <option selected>Mr.</option>
                                    <option>Dr.</option>
                                    <option>Mrs.</option>
                                    <option>Miss.</option>
                                    <option>Ms.</option>
                                </select>
                                <label for="salutation">Salutation *</label>
                                <div class="invalid-feedback">Please choose a salutation.</div>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="form-floating">
                                <input type="text" class="form-control" name="fname" id="fname" placeholder=" " required
                                    minlength="2">
                                <label for="fname">First Name *</label>
                                <div class="invalid-feedback">First name must be at least 2 characters.</div>
                            </div>
                        </div>
                    </div>

                    <!-- Last Name -->
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" name="lname" id="lname" placeholder=" ">
                        <label for="lname">Last Name</label>
                    </div>

                    <!-- Email -->
                    <div class="form-floating mb-3">
                        <input type="email" class="form-control" name="email" id="email" placeholder=" " required>
                        <label for="email">Email ID *</label>
                        <div class="invalid-feedback">Please enter a valid email address.</div>
                    </div>

                    <!-- Mobile -->
                    <div class="form-floating mb-3">
                        <input type="tel" class="form-control" name="mobile" id="mobile" placeholder=" "
                            pattern="[0-9]{10}" required>
                        <label for="mobile">Mobile No *</label>
                        <div class="invalid-feedback">Please enter a valid 10-digit mobile number.</div>
                    </div>
                    <!-- Company ID -->
                    <div class="form-floating mb-3">
                        <input type="number" class="form-control" name="cf_emirates_id_number"
                            id="cf_emirates_id_number" placeholder="123..">
                        <label for="cf_emirates_id_number">Emirates ID*</label>
                    </div>
                </div>

                <!-- Footer -->
                <div class="modal-footer bg-light">
                    <button type="submit" class="btn btn-primary" id="cust_add_action">
                        <i class="bi bi-check-circle"></i> Add
                    </button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        <i class="bi bi-x-circle"></i> Close
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        $(document).on('submit', '.register_form', function (e) {
            e.preventDefault();
            const $form = $(this);
            const formData = $form.serialize();
            $('.before_bo').show();
            $('.add_cust')
                .html('<i class="fa fa-refresh fa-spin fa-fw"></i><span class="sr-only">Loading...</span>')
                .prop('disabled', true);

            $.post('model/ajax/pos-actions.php', formData, function (res) {
                $('.before_bo').hide();
                $('.add_cust').html('Add').prop('disabled', false);
                try {
                    const data = $.parseJSON(res);

                    if (data.run === 1) {
                        boom(data.mgs);
                        $('#posCustnv, #repairCust').html(data.options);
                        $('.add_cust')
                            .html('Added')
                            .removeClass('btn-primary')
                            .addClass('btn-success');
                        boom(data.mgs || 'Customer Added.', 'success', true);
                        $('#cust_add_action').prop('disabled', true);
                        $('#add_customer_modal').modal('hide'); // ✅ hide only on success
                    } else {
                        boom(data.mgs || 'Registration failed.', 'error', true);
                    }
                } catch {
                    $('#posApiRes').html(res);
                }
            });
        });
    });
</script>