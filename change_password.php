<?php
session_start();
require_once 'db.php';

if (!isset($_SESSION["user_id"])) {
    header("Location: index.html");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $user_id = $_SESSION["user_id"];
    $current_password = $_POST["current_password"];
    $new_password = $_POST["new_password"];
    $confirm_password = $_POST["confirm_password"];

    // التحقق من أن كلمة السر الجديدة متطابقة
    if ($new_password !== $confirm_password) {
        $error = "❌ كلمة السر الجديدة غير متطابقة.";
    } else {
        // جلب كلمة السر الحالية من قاعدة البيانات
        $stmt = $conn->prepare("SELECT password FROM users WHERE id = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $stmt->bind_result($hashed_password);
        $stmt->fetch();
        $stmt->close();

        // تحقق من كلمة السر الحالية
        if (!password_verify($current_password, $hashed_password)) {
            $error = "❌ كلمة السر الحالية غير صحيحة.";
        } else {
            // تحديث كلمة السر
            $new_hashed = password_hash($new_password, PASSWORD_DEFAULT);
            $update = $conn->prepare("UPDATE users SET password = ? WHERE id = ?");
            $update->bind_param("si", $new_hashed, $user_id);
            if ($update->execute()) {
                $success = "✅ تم تغيير كلمة السر بنجاح.";
            } else {
                $error = "❌ حدث خطأ أثناء التحديث.";
            }
            $update->close();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="ar">
<head>
  <meta charset="UTF-8">
  <title>تغيير كلمة السر</title>
  <link rel="stylesheet" href="profile.css">
</head>
<body>
  <div class="profile-page">
    <div class="card">
      <h2>تغيير كلمة السر 🔒</h2>
      <?php if (isset($error)): ?>
        <p style="color: red;"><?php echo $error; ?></p>
      <?php elseif (isset($success)): ?>
        <p style="color: green;"><?php echo $success; ?></p>
      <?php endif; ?>
      <form method="POST">
        <input type="password" name="current_password" placeholder="كلمة السر الحالية" required><br>
        <input type="password" name="new_password" placeholder="كلمة السر الجديدة" required><br>
        <input type="password" name="confirm_password" placeholder="تأكيد كلمة السر" required><br>
        <button type="submit" class="btn">تغيير</button>
      </form>
      <br>
      <a href="profile.php" class="btn green">🔙 الرجوع للملف الشخصي</a>
    </div>
  </div>
</body>
</html>
hgrdzjcbyukeulxt

<!DOCTYPE html>
<html lang="ar">
<head>
  <meta charset="UTF-8" />
  <title>تسجيل الدخول</title>
  <style>
    body { font-family: Arial, sans-serif; background: #222; color: #eee; display: flex; justify-content: center; align-items: center; height: 100vh; }
    form { background: #333; padding: 20px; border-radius: 8px; width: 300px; }
    input { width: 100%; padding: 8px; margin: 10px 0; border-radius: 5px; border: none; }
    button { width: 100%; padding: 10px; background: #7289da; border: none; color: white; font-weight: bold; border-radius: 5px; cursor: pointer; }
    .message { color: #f04747; margin-bottom: 10px; }
    .success { color: #43b581; margin-bottom: 10px; }
  </style>
</head>
<body>

<form method="POST" action="">
  <h2>تسجيل الدخول</h2>
  <?php if ($message): ?>
    <div class="message"> <?php echo $message; ?> </div>
  <?php endif; ?>
<!-- <input type="email" name="email" placeholder="البريد الإلكتروني" required /> -->
  <input type="password" name="password" placeholder="كلمة المرور" required />
  <button type="submit">دخول</button>
</form>

</body>
</html>


