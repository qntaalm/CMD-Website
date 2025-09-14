<!DOCTYPE html>
<html lang="ar">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>تسجيل حساب جديد</title>
  <link rel="stylesheet" href="style1.css" />
</head>
<body>
    <?php
include "db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST["username"]);
    $email = trim($_POST["email"]);
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT);

    // تحقق من عدم وجود نفس المستخدم أو الإيميل
    $check = $conn->prepare("SELECT id FROM users WHERE username = ? OR email = ?");
    $check->bind_param("ss", $username, $email);
    $check->execute();
    $check->store_result();

    if ($check->num_rows > 0) {
        echo "⚠️ اسم المستخدم أو الإيميل مستخدم بالفعل!";
    } else {
        $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $username, $email, $password);

        if ($stmt->execute()) {
            echo "✅ تم التسجيل بنجاح! <a href='index.html'>اذهب لتسجيل الدخول</a>";
        } else {
            echo "❌ حدث خطأ أثناء التسجيل!";
        }
        $stmt->close();
    }
    $check->close();
    $conn->close();
} else {
    echo "❌ الطلب غير صالح.";
}
?>
</body>
</html>

