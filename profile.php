<?php
session_start();
require_once 'db.php'; // تأكد أن هذا الملف يحتوي على اتصال mysqli صالح

if (!isset($_SESSION['user_id'])) {
  header("Location: login.php");
  exit();
}

$user_id = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="ar">
<head>
  <meta charset="UTF-8" />
  <title>ملف المستخدم - <?php echo htmlspecialchars($user['username']); ?></title>
  <link rel="stylesheet" href="profile.css" />
</head>
<body>
  <div class="profile-wrapper">
    <div class="profile-card">
      <div class="profile-header">
        <img src="<?php echo $user['avatar'] ?: 'default-avatar.png'; ?>" class="avatar" />
        <h2><?php echo htmlspecialchars($user['username']); ?></h2>
        <p class="email"><?php echo htmlspecialchars($user['email']); ?></p>
      </div>
      <div class="profile-info">
        <p><strong>📍 الموقع:</strong> <?php echo htmlspecialchars($user['location']); ?></p>
        <p><strong>🎂 العمر:</strong> <?php echo (int)$user['age']; ?> سنة</p>
        <p><strong>🕒 تم الإنشاء:</strong> <?php echo date("Y-m-d", strtotime($user['created_at'])); ?></p>
      </div>
      <div class="profile-actions">
        <a href="change_password.php" class="btn blue">🔒 تغيير كلمة السر</a>
        <a href="logout.php" class="btn red">🚪 تسجيل الخروج</a>
      </div>
    </div>
  </div>
</body>
</html>


<!DOCTYPE html>
<html lang="ar">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>تسجيل الدخول</title>
  <link rel="stylesheet" href="style1.css"/>
  <!-- رابط Font Awesome في <head> -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />

  <style>
      
      /* رابط نسيت كلمة المرور */
.forgot-link {
  text-align: center;
  margin: -10px 0 20px 0;
  margin-top: 20px;
}

.forgot-link a {
  color: #25fc49;
  font-size: 15px;
  font-weight: 600;
  text-decoration: none;
  transition: 0.3s ease;
}

.forgot-link a:hover {
  color: #06911d;
  text-decoration: underline;
}

    .password-container {
      position: relative;
      width: 100%;
    }

    .password-container input {
      width: 100%;
      padding: 10px 40px 10px 10px; /* مساحة للأيقونة على اليمين */
      font-size: 16px;
    }

    .password-container #togglePassword {
      position: absolute;
      top: 45%;
      right: 10px; /* الأيقونة على اليمين */
      transform: translateY(-50%);
      cursor: pointer;
      color: #888;
    }

    .password-container #togglePassword:hover {
      color: #000;
    }
  </style>
</head>
<body>
  <div class="login-container">
    <h2>تسجيل الدخول</h2>
    <?php if ($message): ?>
      <p style="color: red;"><?php echo $message; ?></p>
    <?php endif; ?>
    <form action="login.php" method="POST">
      <input type="text" name="username" placeholder="اسم المستخدم" required />

      <div class="password-container">
        <input type="password" id="password" name="password" placeholder="كلمة المرور" required />
        <span id="togglePassword" role="button" tabindex="0" aria-label="إظهار أو إخفاء كلمة المرور" >
          <i class="fa-solid fa-eye"></i>
        </span>
      </div>

      <button type="submit">دخول</button>
    </form>

    <div class="forgot-link">
      <a href="change_password_request.php">نسيت كلمة المرور؟</a>
    </div>

    <div class="register-link">
      ليس لديك حساب؟ <a href="register.php">سجل الآن</a>
    </div>
  </div>

  <script>
    document.addEventListener("DOMContentLoaded", function () {
      const toggleBtn = document.getElementById("togglePassword");
      const passwordInput = document.getElementById("password");
      const icon = toggleBtn.querySelector("i");

      toggleBtn.addEventListener("click", function () {
        const isPassword = passwordInput.type === "password";
        passwordInput.type = isPassword ? "text" : "password";
        icon.classList.toggle("fa-eye");
        icon.classList.toggle("fa-eye-slash");
      });

      // دعم إمكانية استخدام الكيبورد (Enter أو Space) لزيادة الوصولية
      toggleBtn.addEventListener("keydown", function(e) {
        if (e.key === "Enter" || e.key === " " ) {
          e.preventDefault();
          toggleBtn.click();
        }
      });
    });
  </script>
</body>
</html>
