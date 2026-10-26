<?php
// Include your db connection and functions
include '../core/config.php'; // Adjust path if needed

header('Content-Type: application/json');

// Check if pos_action is sent via AJAX
if (isset($_POST['pos_action'])) {

    $action = $_POST['pos_action'];

    // Common store assignment if available
    if (!isset($_POST['store']) && defined('organizationId')) {
        $_POST['store'] = organizationId;
    }

    switch ($action) {

        // 1. SAVE ENQUIRY
        case 'save_enquiry':
            unset($_POST['pos_action'], $_POST['action']);
            $result = secureDbAction('enquiries', 1, $_POST);

            if (isset($result['success']) && $result['success'] === true) {
                $enqNo = invoiceNo($result['insert_id'] ?? 'NA', 5, 'ENQ-');
                $resultUp = secureDbAction('enquiries', 2, ['enquiry_no' => $enqNo], "`id` = ?", [$result['insert_id']]);
                echo json_encode(['success' => true, 'message' => 'Enquiry Saved Successfully!', 'insert_id' => $result['insert_id'] ?? null]);
            } else {
                echo json_encode(['success' => false, 'message' => $result['error'] ?? 'Database insertion failed.']);
            }
            exit;

        // 2. CREATE JOB ORDER
        case 'create_job_order':
            unset($_POST['pos_action'], $_POST['action']);
            $result = secureDbAction('job_orders', 1, $_POST);

            if (isset($result['success']) && $result['success'] === true) {
                echo json_encode(['success' => true, 'message' => 'Job Order Created Successfully!', 'insert_id' => $result['insert_id'] ?? null]);
            } else {
                echo json_encode(['success' => false, 'message' => $result['error'] ?? 'Database insertion failed.']);
            }
            exit;
        // 3. CONVERT ENQUIRY TO JOB ORDER
        case 'convert_enquiry_to_quote':
            $enquiryId = $_POST['enquiry_id'] ?? 0;
            if (!$enquiryId) {
                echo json_encode(['success' => false, 'message' => 'Invalid Enquiry ID.']);
                exit;
            }
            // Insert Job Order
            $insertResult = secureDbAction('estimates', 1, [
                'enquiry_id' => $enquiryId,
                'store' => organizationId
            ]);

            if (isset($insertResult['success']) && $insertResult['success'] === true) {
                secureDbAction('enquiries', 2, ['status' => 'Converted'], "`id` = ? AND store=?", [$enquiryId, organizationId]);

                echo json_encode([
                    'success' => true,
                    'message' => "Converted to Job Order!",
                    'job_order_id' => $insertResult['insert_id']
                ]);
            } else {
                echo json_encode([
                    'success' => false,
                    'message' => 'Failed: ' . ($insertResult['error'] ?? 'Unknown error')
                ]);
            }
            exit;
        case 'convert_enquiry_to_job':
            $enquiryId = $_POST['estimate_id'] ?? 0;
            if (!$enquiryId) {
                echo json_encode(['success' => false, 'message' => 'Invalid quote ID.']);
                exit;
            }
            // Insert Job Order
            $insertResult = secureDbAction('projects', 1, [
                'estimate_id' => $enquiryId,
                'store' => organizationId
            ]);

            if (isset($insertResult['success']) && $insertResult['success'] === true) {
                secureDbAction('estimates', 2, ['apiStatus' => 'Converted'], "`estimate_id` = ? AND store=?", [$enquiryId, organizationId]);

                echo json_encode([
                    'success' => true,
                    'message' => "Converted to Job Order!",
                    'job_order_id' => $insertResult['insert_id']
                ]);
            } else {
                echo json_encode([
                    'success' => false,
                    'message' => 'Failed: ' . ($insertResult['error'] ?? 'Unknown error')
                ]);
            }
            exit;
        default:
            echo json_encode(['success' => false, 'message' => 'Invalid Action Provided.']);
            exit;
    }
}

echo json_encode(['success' => false, 'message' => 'Invalid Request Method']);
?>