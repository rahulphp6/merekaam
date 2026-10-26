<?php
// Include your db connection and functions
include '../core/config.php';

header('Content-Type: application/json');

// Error reporting band rakho taaki output clean JSON rahe
error_reporting(0);
ini_set('display_errors', 0);

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['pos_action'])) {

    $action = $_POST['pos_action'];

    switch ($action) {

        // 1. Fetch Contact Persons based on Customer ID
        case 'get_contacts':
            $customerId = $_POST['customer_id'] ?? 0;

            if (!$customerId) {
                echo json_encode([]);
                exit;
            }

            // Using secureDbAction with SELECT (action 4)
            $where = "`customer_id` = ?";
            $params = [$customerId];
            $dataOptions = ['columns' => 'id, contact_name', 'orderBy' => 'contact_name ASC'];

            // Assuming your table name is 'customer_contacts' or 'contacts' (adjust if table name differs)
            $result = secureDbAction('contacts', 4, $dataOptions, $where, $params);

            if (isset($result['success']) && $result['success'] === true) {
                echo json_encode($result['data']);
            } else {
                echo json_encode([]);
            }
            exit;

        // Aap yahan aage aur bhi GET actions add kar sakte hain
        default:
            echo json_encode(['success' => false, 'message' => 'Invalid Action']);
            exit;
    }
}
echo json_encode(['success' => false, 'message' => 'Invalid Request Method']);
exit;
?>