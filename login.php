<?php
session_start();
require_once 'koneksi.php'; // sambung ke DB 'mahacerdas'

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    if (empty($email) || empty($password)) {
        $error = "Email dan password wajib diisi.";
    } else {
        // Login Admin Manual
        if ($email === 'admin@maha.id' && $password === 'admin123') {
            $_SESSION['user_id'] = 0;
            $_SESSION['nama'] = 'Administrator';
            $_SESSION['role'] = 'admin';
            header("Location: Admin/dashboard_admin.php");
            exit();
        }

        // Login GURU / SISWA
        $stmt = $conn->prepare("SELECT * FROM users WHERE email = ? LIMIT 1");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && $result->num_rows === 1) {
            $user = $result->fetch_assoc();

            if ($user['role'] === 'admin') {
                $error = "Akun admin tidak bisa login melalui database.";
            } elseif (password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['nama'] = $user['nama'];
                $_SESSION['role'] = $user['role'];
                $_SESSION['jenjang'] = $user['jenjang'];

                // Redirect sesuai role
                switch ($user['role']) {
                    case 'guru':
                        header("Location: Guru/dashboard_guru.php");
                        break;
                    case 'siswa':
                        header("Location: Siswa/dashboard_siswa.php");
                        break;
                    default:
                        $error = "Role tidak dikenali.";
                }
                exit();
            } else {
                $error = "Password salah.";
            }
        } else {
            $error = "Email tidak ditemukan.";
        }

        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login - Maha Cerdas</title>
  <link rel="stylesheet" href="css/form.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
</head>
<body>

  <div class="form-container">
    <h2>Login Akun</h2>

    <?php if (!empty($error)): ?>
      <div class="error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form action="login.php" method="POST">
      <input type="email" name="email" placeholder="Email" required>
      <input type="password" name="password" placeholder="Password" required>
      <button type="submit">Masuk</button>
    </form>

    <p>Belum punya akun? <a href="register.php">Daftar di sini</a></p>
  </div>

</body>
</html>
