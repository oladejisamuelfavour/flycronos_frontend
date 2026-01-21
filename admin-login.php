<?php
session_start();

// change to the admin username you want
$ADMIN_USER = 'admin';
// set the password hash for the admin (generate via password_hash and paste here)
// Example: password_hash('YourStrongP@ss', PASSWORD_DEFAULT)
$ADMIN_HASH = '$2y$10$EXAMPLE_HASH_REPLACE_ME_WITH_REAL'; // <-- replace

if (isset($_POST['username'], $_POST['password'])) {
    $u = $_POST['username'];
    $p = $_POST['password'];

    if ($u === $ADMIN_USER && password_verify($p, $ADMIN_HASH)) {
        $_SESSION['admin_logged_in'] = true;
        header('Location: admin-visas.php');
        exit;
    } else {
        $error = "Invalid credentials.";
    }
}
?>
<!doctype html>
<html>
<head><meta charset="utf-8"><title>Admin Login</title></head>
<body>
  <h2>Admin Login</h2>
  <?php if (!empty($error)) echo "<div style='color:red'>{$error}</div>"; ?>
  <form method="post">
    <label>Username <input name="username"></label><br><br>
    <label>Password <input name="password" type="password"></label><br><br>
    <button type="submit">Login</button>
  </form>
</body>
</html>
