<?php
session_start();
require_once 'koneksi.php'; // pastikan file ini nyambung ke DB 'mahacerdas'

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    if (empty($email) || empty($password)) {
        $error = "Email dan password wajib diisi.";
    } else {
        $stmt = $conn->prepare("SELECT * FROM users WHERE email = ? AND validasi = 1 LIMIT 1");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && $result->num_rows === 1) {
            $user = $result->fetch_assoc();

            if (password_verify($password, $user['password'])) {
                $_SESSION['nama'] = $user['nama'];
                $_SESSION['role'] = $user['role'];

                // Redirect berdasarkan role
                switch ($user['role']) {
                    case 'admin':
                        header("Location: Admin/dashboard_admin.php");
                        break;
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
            $error = "Email tidak ditemukan atau belum divalidasi.";
        }

        $stmt->close();
    }
}
?>
