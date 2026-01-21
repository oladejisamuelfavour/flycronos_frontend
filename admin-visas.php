<?php
session_start();
if (empty($_SESSION['admin_logged_in'])) {
    header('Location: admin-login.php');
    exit;
}
require_once __DIR__ . '/db.php';

// simple search and pagination (optional)
$search = $_GET['q'] ?? '';
$sql = "SELECT * FROM visas ";
$params = [];
if ($search !== '') {
    $sql .= "WHERE first_name LIKE :q OR last_name LIKE :q OR email LIKE :q OR country LIKE :q ";
    $params[':q'] = "%$search%";
}
$sql .= "ORDER BY created_at DESC LIMIT 500"; // simple limit
$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$rows = $stmt->fetchAll();
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Admin — Visa Submissions</title>
  <style>
    body{font-family:Arial,Helvetica,sans-serif;padding:20px}
    table{border-collapse:collapse;width:100%}
    th,td{padding:8px;border:1px solid #ddd}
    th{background:#f4f4f4}
    .logout{float:right}
  </style>
</head>
<body>
  <a class="logout" href="admin-logout.php">Logout</a>
  <h2>Visa Submissions</h2>

  <form method="get" style="margin-bottom:12px">
    <input name="q" placeholder="Search name, email, country" value="<?php echo htmlspecialchars($search); ?>">
    <button>Search</button>
  </form>

  <table>
    <thead>
      <tr>
        <th>#</th>
        <th>Received</th>
        <th>Name</th>
        <th>Email</th>
        <th>Phone</th>
        <th>Country</th>
        <th>Visa Type</th>
        <th>Travel Date</th>
        <th>Message</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($rows as $r): ?>
        <tr>
          <td><?php echo htmlspecialchars($r['id']); ?></td>
          <td><?php echo htmlspecialchars($r['created_at']); ?></td>
          <td><?php echo htmlspecialchars($r['first_name'].' '.$r['last_name']); ?></td>
          <td><?php echo htmlspecialchars($r['email']); ?></td>
          <td><?php echo htmlspecialchars($r['phone']); ?></td>
          <td><?php echo htmlspecialchars($r['country']); ?></td>
          <td><?php echo htmlspecialchars($r['visa_type']); ?></td>
          <td><?php echo htmlspecialchars($r['travel_date']); ?></td>
          <td><?php echo nl2br(htmlspecialchars($r['message'])); ?></td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</body>
</html>
