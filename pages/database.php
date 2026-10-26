<?php
$result = null;
$error = null;
$conn = OpenCon();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $sql = $_POST['sql'] ?? '';
    if ($sql) {
        if ($conn->multi_query($sql)) {
            $result = $conn->store_result();
        } else {
            $error = $conn->error;
        }
    }
} ?>
<div class="container">
    <div class="card">
        <div class="card-body">
            <h2>SQL Query Runner</h2>
            <form method="post">
                <textarea name="sql" placeholder="Write your SQL query here..." class="form-control" row="6"
                    col="6"><?php echo $_POST['sql'] ?? '' ?></textarea><br>
                <button type="submit" class="btn btn-primary">Execute</button>
            </form>
        </div>
    </div>
    <div class="table-responsive">
        <?php if ($error): ?>
            <p class="error">Error: <?= $error ?></p>
        <?php elseif ($result): ?>
            <?php $fields = $result->fetch_fields(); ?>
            <table class="table" id="mytable">
                <thead>
                    <tr>
                        <?php foreach ($fields as $field): ?>
                            <th><?= $field->name?></th>
                        <?php endforeach; ?>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <?php foreach ($fields as $field): ?>
                                <td><?= $row[$field->name] ?></td>
                            <?php endforeach; ?>
                            <td><?= count($row) ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</div>