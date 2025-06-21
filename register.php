<?php
require_once 'koneksi.php';

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = trim($_POST['nama']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $role = $_POST['role'];
    $jenjang = $_POST['jenjang'] ?? '';

    $allowed_roles = ['guru', 'siswa'];
    $allowed_jenjang = ['SMP', 'SMA'];

    // Validasi input
    if (empty($nama) || empty($email) || empty($password) || empty($role) || empty($jenjang)) {
        $error = "Semua field wajib diisi.";
    } elseif (!in_array($role, $allowed_roles)) {
        $error = "Role tidak valid.";
    } elseif (!in_array($jenjang, $allowed_jenjang)) {
        $error = "Jenjang tidak valid.";
    } else {
        // Cek email sudah digunakan atau belum
        $cek = $conn->prepare("SELECT id FROM users WHERE email = ?");
        $cek->bind_param("s", $email);
        $cek->execute();
        $cek->store_result();

        if ($cek->num_rows > 0) {
            $error = "Email sudah digunakan.";
        } else {
            // Simpan user
            $hashed = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("INSERT INTO users (nama, email, password, role, jenjang) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("sssss", $nama, $email, $hashed, $role, $jenjang);

            if ($stmt->execute()) {
                header("Location: login.php?daftar=berhasil");
                exit();
            } else {
                $error = "Gagal mendaftar. Silakan coba lagi.";
            }
            $stmt->close();
        }
        $cek->close();
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Registrasi - MaHa Cerdas</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="css/form.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
</head>
<body>

  <div class="form-container">
    <h2>Registrasi Akun</h2>

    <?php if (!empty($error)): ?>
      <div class="error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="POST" action="">
      <input type="text" name="nama" placeholder="Nama lengkap" required>
      <input type="email" name="email" placeholder="Email" required>
      <input type="password" name="password" placeholder="Password" required>

      <select name="role" required>
        <option value="">-- Pilih Peran --</option>
        <option value="siswa">Siswa</option>
        <option value="guru">Guru</option>
      </select>

      <select name="jenjang" required>
        <option value="">-- Pilih Jenjang --</option>
        <option value="SMP">SMP</option>
        <option value="SMA">SMA</option>
      </select>

      <button type="submit">Daftar</button>
    </form>

    <p>Sudah punya akun? <a href="login.php">Masuk di sini</a></p>
  </div>
</body>
</html>
