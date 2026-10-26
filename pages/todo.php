<!-- Main content -->
<div class="content py-3">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h3 class="card-title mb-0" id="crudTitle"><?php echo ucfirst($page); ?> Detail</h3>
                        <div class="btn-group ms-auto">
                            <button class="btn btn-primary btn-sm" data-bs-toggle="offcanvas"
                                data-bs-target="#crudCanvas" onclick="openModal()">
                                <i class="fa fa-plus"></i> Add
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div id="filterBar" class="mb-3 d-flex flex-wrap gap-2 sticky-top"></div>
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
<div class="offcanvas offcanvas-end" id="crudCanvas" tabindex="-1" aria-labelledby="crudCanvasLabel">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="crudCanvasLabel">Manage</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <form id="crudForm" class="offcanvas-body needs-validation" novalidate>
        <div id="formFields"></div>
        <div class="mt-4 d-flex justify-content-end gap-2">
            <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Save</button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="offcanvas">
                <i class="fa fa-share"></i> Cancel
            </button>
        </div>
    </form>
</div>
<script>
    window.crudConfig = {
        action: 'filter',
        table: 'todo',
        columns: ['name', 'description', 'date','store']
        // columns: ['name','email','phone','role', 'status', 'date']
    };
</script>