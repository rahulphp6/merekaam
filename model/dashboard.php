<?php
include_once "../core/config.php";
header('Content-Type: application/json');

try {
    $filter = $_GET['filter'] ?? 'custom';
    $from = $_GET['from'] ?? null;
    $to = $_GET['to'] ?? null;

    // Helpers
    function fetchRow($sql)
    {
        $result = queryRun($sql, 3);
        return $result ? mysqli_fetch_assoc($result) : [];
    }
    
    function fetchAll($sql)
    {
        $result = queryRun($sql, 3);
        $rows = [];
        if ($result) {
            while ($row = mysqli_fetch_assoc($result)) {
                $rows[] = $row;
            }
        }
        return $rows;
    }

    // === Dynamic Date Range Generation based on Filter ===
    $dateConditionPay = "";
    $dateConditionGeneral = "";

    if ($filter === 'custom') {
        if (!empty($from) && !empty($to)) {
            // Agar user ne custom from aur to date di hai
            $dateConditionPay = "DATE(p.paid_date) BETWEEN '$from' AND '$to'";
            $dateConditionGeneral = "DATE(date) BETWEEN '$from' AND '$to'";
        } else {
            // Default Custom fallback: 1st of current month to today
            $dateConditionPay = "DATE(p.paid_date) BETWEEN DATE_FORMAT(CURDATE(), '%Y-%m-01') AND CURDATE()";
            $dateConditionGeneral = "DATE(date) BETWEEN DATE_FORMAT(CURDATE(), '%Y-%m-01') AND CURDATE()";
        }
    } elseif ($filter === 'week') {
        // Current Week
        $dateConditionPay = "YEARWEEK(p.paid_date, 1) = YEARWEEK(CURDATE(), 1)";
        $dateConditionGeneral = "YEARWEEK(date, 1) = YEARWEEK(CURDATE(), 1)";
    } elseif ($filter === 'month') {
        // Full Current Month
        $dateConditionPay = "MONTH(p.paid_date) = MONTH(CURDATE()) AND YEAR(p.paid_date) = YEAR(CURDATE())";
        $dateConditionGeneral = "MONTH(date) = MONTH(CURDATE()) AND YEAR(date) = YEAR(CURDATE())";
    } elseif ($filter === 'year') {
        // Full Current Year
        $dateConditionPay = "YEAR(p.paid_date) = YEAR(CURDATE())";
        $dateConditionGeneral = "YEAR(date) = YEAR(CURDATE())";
    } else {
        // Absolute Fallback
        $dateConditionPay = "DATE(p.paid_date) BETWEEN DATE_FORMAT(CURDATE(), '%Y-%m-01') AND CURDATE()";
        $dateConditionGeneral = "DATE(date) BETWEEN DATE_FORMAT(CURDATE(), '%Y-%m-01') AND CURDATE()";
    }

    // === Tasks + Payments join ===
    $payTasksQ = "SELECT pr.id as project_id, t.id as task_id, p.id as payment_id, pr.name as project_name, t.name as task_name, p.installment_no, p.amount, p.paid_date, p.paid_status, p.notes, p.date 
                  FROM payments p 
                  LEFT JOIN projects pr ON pr.id = p.project_id 
                  LEFT JOIN tasks t ON t.id = p.task_id 
                  WHERE p.paid_status = 'paid' AND $dateConditionPay";
    $taskPayments = fetchAll($payTasksQ);

    // === Overall summaries ===
    $sales = fetchRow("SELECT SUM(amount) as total_sales FROM payments WHERE $dateConditionGeneral");
    $profit = fetchRow("SELECT SUM(CASE WHEN paid_status='paid' THEN amount ELSE 0 END) as total_profit FROM payments WHERE $dateConditionGeneral");
    $cost = fetchRow("SELECT SUM(amount) as total_cost FROM projects WHERE $dateConditionGeneral");
    $revenue = fetchRow("SELECT SUM(amount) as total_revenue FROM payments WHERE $dateConditionGeneral");
    $netInc = fetchRow("SELECT SUM(amount) - SUM(CASE WHEN paid_status='overdue' THEN amount ELSE 0 END) as net_income FROM payments WHERE $dateConditionGeneral");

    $projects = fetchRow("SELECT COUNT(*) as total_projects FROM projects WHERE $dateConditionGeneral");

    $tasksSummary = fetchRow("SELECT COUNT(*) as total_tasks, SUM(CASE WHEN task_status='completed' THEN 1 ELSE 0 END) as completed_tasks FROM tasks WHERE $dateConditionGeneral");
    $totalTasks = $tasksSummary['total_tasks'] ?? 0;
    $doneTasks = $tasksSummary['completed_tasks'] ?? 0;
    $progress = $totalTasks > 0 ? round(($doneTasks / $totalTasks) * 100, 2) : 0;

    $bugs = fetchRow("SELECT COUNT(*) as total_bugs, SUM(CASE WHEN status='open' THEN 1 ELSE 0 END) as open_bugs, SUM(CASE WHEN status='fixed' THEN 1 ELSE 0 END) as fixed_bugs FROM bugs WHERE $dateConditionGeneral");

    echo json_encode([
        'success' => true,
        'filter' => $filter,
        'data' => [
            'sales' => "₹" . ($sales['total_sales'] ?? 0),
            'profit' => "₹" . ($profit['total_profit'] ?? 0),
            'cost' => "₹" . ($cost['total_cost'] ?? 0),
            'revenue' => "₹" . ($revenue['total_revenue'] ?? 0),
            'net_income' => "₹" . ($netInc['net_income'] ?? 0),
            'projects' => $projects['total_projects'] ?? 0,
            'tasks_summary' => [
                'tasks' => $totalTasks,
                'tasks_done' => $doneTasks,
                'progress' => $progress
            ],
            'bugs' => $bugs['total_bugs'] ?? 0,
            'bugs_open' => $bugs['open_bugs'] ?? 0,
            'bugs_fixed' => $bugs['fixed_bugs'] ?? 0,
            'task_payments' => $taskPayments
        ]
    ]);
} catch (Throwable $e) {
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
?>