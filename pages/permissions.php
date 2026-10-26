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
        </div>
    </div>
    <div class="card-body">
        <div class="btn-group d-none mb-3 sticky-top bg-white py-2" id="bulkmode">
            <button id="bulkDeleteBtn" class="btn btn-sm btn-danger" onclick="bulkDelete()">
                <i class="fa fa-trash"></i> Delete
            </button>
        </div>
        <div id="deptable" class="table-responsive"></div>
    </div>
</div>
<?php include_once 'temp-parts/canvas.php'; ?>
<script>
    window.crudConfig = {
        action: 'filter',
        table: 'permissions',
        columns: ['name', 'description', 'status'],
    };
</script>