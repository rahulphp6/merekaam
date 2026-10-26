<?php
include_once "../core/config.php";
header('Content-Type: application/json');

$email = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';
$mobile = trim($_POST['mobile'] ?? '');
$otp = trim($_POST['otp'] ?? '');

// 🔹 Email/Password Login
if ($email !== '' && $password !== '') {
    if (is_numeric($email) && $email > 12345) {
        $res = dbAction('customers', 4, [], "contact_id = '$email' AND status = 1");
    } else {
        $res = dbAction('users', 4, [], "email = '$email' AND role <= 5 AND status = 1");
    }

    $user = $res && is_object($res) ? $res->fetch_assoc() : null;
    // echo password_verify('admin@0101', $user_row['password']);
    if (!$user || !password_verify($password, $user['password'])) {
        $passCheck = password_hash($password, PASSWORD_DEFAULT);
        // echo json_encode(['success' => false, 'error' => $passCheck]);
        echo json_encode(['success' => false, 'error' => 'Invalid credentials']);
        exit;
    }
    $_SESSION['timein'] = time();
    $_SESSION['user_name'] = $user['UserName'] ?? '';
    $_SESSION['name'] = $user['name'] ?? '';
    $_SESSION['profile'] = $user['profilePic'] ?? '';
    $_SESSION['email'] = $user['email'];
    $_SESSION['id'] = $user['id'];
    $_SESSION['depid'] = $user['depid'] ?? '';
    $_SESSION['role'] = $user['role'];

    echo json_encode([
        'success' => true,
        'email' => $user['email'],
        'role' => $user['role'],
    ]);
    exit;
}

// 🔹 Mobile/OTP Login
if ($mobile !== '' && $otp !== '') {
    $check = dbAction('otp_sessions', 4, [], "mobile = '$mobile' AND otp = '$otp' AND expires_at >= '" . date('Y-m-d H:i:s') . "'");
    $otpRow = $check && is_object($check) ? $check->fetch_assoc() : null;

    if (!$otpRow) {
        echo json_encode(['success' => false, 'error' => 'Invalid or expired OTP']);
        exit;
    }

    dbAction('otp_sessions', 3, [], "mobile = '$mobile'");

    $res = dbAction('users', 4, [], "phone = '$mobile'");
    $user = $res && is_object($res) ? $res->fetch_assoc() : null;

    if (!$user) {
        echo json_encode(['success' => false, 'error' => 'User not found']);
        exit;
    }

    $_SESSION['timein'] = time();
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['phone'] = $mobile;
    $_SESSION['role'] = $user['role'];
    echo json_encode([
        'success' => true,
        'phone' => $mobile,
        'role' => $user['role']
    ]);
    exit;
}
// 🔹 Fallback
echo json_encode(['success' => false, 'error' => 'Missing credentials']);
exit;