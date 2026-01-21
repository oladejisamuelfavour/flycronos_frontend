<?php
// process-visa.php
header('Content-Type: application/json; charset=utf-8');

// allow only POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed']);
    exit;
}

// simple helper
function clean($s) {
    return trim($s);
}

// fetch POST safely
$country = clean($_POST['country'] ?? '');
$visa_type = clean($_POST['visa_type'] ?? '');
$first_name = clean($_POST['first_name'] ?? '');
$last_name = clean($_POST['last_name'] ?? '');
$email = clean($_POST['email'] ?? '');
$phone = clean($_POST['phone'] ?? '');
$nationality = clean($_POST['nationality'] ?? '');
$travel_date = clean($_POST['travel_date'] ?? '');
$has_passport = clean($_POST['has_passport'] ?? '');
$message = clean($_POST['message'] ?? '');
$consent = isset($_POST['consent']) ? true : false;
$ip = $_SERVER['REMOTE_ADDR'] ?? '';

// basic server-side validation
$errors = [];
if (!$country) $errors[] = 'Country is required';
if (!$visa_type) $errors[] = 'Visa type is required';
if (!$first_name) $errors[] = 'First name is required';
if (!$email || !filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'Valid email required';
if (!$consent) $errors[] = 'You must accept the terms to proceed';

if (!empty($errors)) {
    echo json_encode(['success' => false, 'message' => implode('. ', $errors)]);
    exit;
}

// optional: validate travel_date format (YYYY-MM-DD)
if ($travel_date !== '') {
    $d = DateTime::createFromFormat('Y-m-d', $travel_date);
    if (!$d) {
        echo json_encode(['success' => false, 'message' => 'Invalid travel date format.']);
        exit;
    }
}

// store to DB
require_once __DIR__ . '/db.php'; // provides $pdo (PDO instance)

try {
    $stmt = $pdo->prepare("INSERT INTO visas (country, visa_type, first_name, last_name, email, phone, nationality, travel_date, has_passport, message, ip_address)
                           VALUES (:country, :visa_type, :first_name, :last_name, :email, :phone, :nationality, :travel_date, :has_passport, :message, :ip)");
    $stmt->execute([
        ':country' => $country,
        ':visa_type' => $visa_type,
        ':first_name' => $first_name,
        ':last_name' => $last_name,
        ':email' => $email,
        ':phone' => $phone,
        ':nationality' => $nationality,
        ':travel_date' => $travel_date ?: null,
        ':has_passport' => in_array($has_passport, ['yes','no']) ? $has_passport : 'unknown',
        ':message' => $message,
        ':ip' => $ip
    ]);
    $insertId = $pdo->lastInsertId();
} catch (Exception $e) {
    // log $e->getMessage() to server logs in real application
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Failed to save submission.']);
    exit;
}

// send notification email to admin (simple example)
// set this to your admin email:
$adminEmail = 'you@yourdomain.com';
$subject = "New Visa Request — FlyCronos (#$insertId)";
$body = "A new visa request was received:\n\n";
$body .= "Country: $country\nVisa Type: $visa_type\nName: $first_name $last_name\nEmail: $email\nPhone: $phone\nNationality: $nationality\nTravel Date: $travel_date\nHas Passport: $has_passport\nMessage: $message\nIP: $ip\n\n--\nFlyCronos Website";

$headers = "From: no-reply@yourdomain.com\r\nReply-To: $email\r\n";

// Attempt to send. On many hosts mail() works; on others you must use SMTP via PHPMailer.
@mail($adminEmail, $subject, $body, $headers);

// success response
echo json_encode(['success' => true, 'message' => 'Request submitted successfully. Our team will contact you shortly.']);
exit;
