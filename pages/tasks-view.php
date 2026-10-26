<?php
// SecureDbAction ka use karke tasks fetch karein
$taskResult = secureDbAction('tasks', 4, ['columns' => '*']);
$tasks = [
    'todo' => [],
    'in_progress' => [],
    'testing' => [],
    'completed' => []
];

if ($taskResult['success'] && !empty($taskResult['data'])) {
    foreach ($taskResult['data'] as $task) {
        // Aapke table mein column ka naam 'task_status' hai
        $status = $task['task_status'] ?? 'todo';
        if (array_key_exists($status, $tasks)) {
            $tasks[$status][] = $task;
        }
    }
}
?>

<div class="container-fluid py-3">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="h5 mb-0 fw-bold text-dark">Task Kanban Board</h2>
        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addTaskModal">
            <i class="fa fa-plus"></i> Add Task
        </button>
    </div>

    <!-- Kanban Board Grid -->
    <div class="row flex-row flex-nowrap overflow-auto pb-3 g-3">
        
        <?php 
        $columns = [
            'todo' => ['title' => 'To Do', 'bg' => 'secondary'],
            'in_progress' => ['title' => 'In Progress', 'bg' => 'primary'],
            'testing' => ['title' => 'Testing', 'bg' => 'warning text-dark'],
            'completed' => ['title' => 'Completed', 'bg' => 'success']
        ];

        foreach($columns as $col_key => $col_info):
            $col_tasks = $tasks[$col_key];
            $count = count($col_tasks);
        ?>
        <div class="col-12 col-md-3" style="min-width: 260px;">
            <div class="card bg-light border-0 shadow-sm h-100">
                <div class="card-header bg-white border-bottom py-2 d-flex justify-content-between align-items-center">
                    <span class="fw-semibold text-secondary small"><?php echo $col_info['title']; ?></span>
                    <span class="badge bg-<?php echo $col_info['bg']; ?> rounded-pill"><?php echo $count; ?></span>
                </div>
                <div class="card-body task-list p-2" id="<?php echo $col_key; ?>-list" data-status="<?php echo $col_key; ?>" style="min-height: 400px;">
                    
                    <?php if($count > 0): ?>
                        <?php foreach($col_tasks as $task): ?>
                        <div class="card task-card mb-2 border shadow-sm" draggable="true" data-id="<?php echo $task['id']; ?>">
                            <div class="card-body p-2_5">
                                <div class="d-flex justify-content-between align-items-start mb-1">
                                    <!-- Aapke table ka column 'name' hai -->
                                    <h6 class="card-title fw-bold text-dark mb-0 fs-6"><?php echo htmlspecialchars($task['name'] ?? 'Untitled'); ?></h6>
                                    <span class="badge bg-light text-muted border" style="font-size: 0.65rem;">#<?php echo $task['id']; ?></span>
                                </div>
                                <p class="card-text text-muted small mb-2" style="font-size: 0.8rem;">
                                    Assigned: <?php echo !empty($task['assigned_to']) ? $task['assigned_to'] : 'Unassigned'; ?>
                                </p>
                                <div class="d-flex justify-content-between align-items-center text-muted" style="font-size: 0.75rem;">
                                    <span><i class="fa fa-calendar"></i> <?php echo $task['deadline'] ?? 'No Date'; ?></span>
                                    <span class="badge bg-secondary text-white" style="font-size: 0.65rem;"><?php echo $task['priority'] ?? 'medium'; ?></span>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    <?php endif; ?>

                </div>
            </div>
        </div>
        <?php endforeach; ?>

    </div>
</div>

<!-- Custom Styling -->
<style>
.overflow-auto::-webkit-scrollbar { height: 6px; }
.overflow-auto::-webkit-scrollbar-thumb { background: #ccc; border-radius: 4px; }
.task-card { cursor: grab; transition: opacity 0.2s ease; }
.task-card:active { cursor: grabbing; }
.task-card.dragging { opacity: 0.4; background: #e9ecef; }
</style>

<!-- Drag and Drop & AJAX Handler -->
<script>
document.addEventListener("DOMContentLoaded", () => {
    const cards = document.querySelectorAll(".task-card");
    const lists = document.querySelectorAll(".task-list");

    cards.forEach(card => {
        card.addEventListener("dragstart", () => card.classList.add("dragging"));
        card.addEventListener("dragend", () => {
            card.classList.remove("dragging");
            updateTaskStatusBackend();
        });
    });

    lists.forEach(list => {
        list.addEventListener("dragover", e => {
            e.preventDefault();
            const draggingCard = document.querySelector(".dragging");
            list.appendChild(draggingCard);
        });
    });
});

function updateTaskStatusBackend() {
    const boardData = [];
    document.querySelectorAll(".task-list").forEach(list => {
        const status = list.getAttribute("data-status");
        list.querySelectorAll(".task-card").forEach(card => {
            boardData.push({
                id: card.getAttribute("data-id"),
                task_status: status // Database column name match kiya gaya hai
            });
        });
    });

    fetch('update-task-status.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(boardData)
    })
    .then(response => response.json())
    .then(data => {
        if(data.success) {
            console.log('Task status updated successfully');
        }
    }).catch(err => console.error('AJAX Error:', err));
}
</script>