<!-- Main content -->
<div class="card shadow-sm">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h3 class="card-title mb-0" id="crudTitle">Tasks Details</h3>
        <div class="btn-group ms-auto">
            <button class="btn btn-light btn-sm" data-bs-toggle="offcanvas" data-bs-target="#crudFilter">
                <i class="fa fa-sort"></i> Filters
            </button>
            <button class="btn btn-primary btn-sm" data-bs-toggle="offcanvas" data-bs-target="#crudCanvas"
                onclick="openModal()">
                <i class="fa fa-plus"></i> Add
            </button>
            <a class="btn btn-light btn-sm" href="?page=tasks-view">
                <i class="fa fa-tasks"></i> Kanban View
            </a>
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

<!-- Offcanvas Panel -->
<?php include_once 'temp-parts/canvas.php'; ?>
<script>
    window.crudConfig = {
        action: 'filter',
        table: 'tasks',
        columns: ['name', 'project_id', 'assigned_to', 'priority', 'task_status', 'progress', 'deadline', 'date']
    };
</script>