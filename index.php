<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>MaHa cerdAs - Belajar Jadi Mudah</title>
  <link rel="stylesheet" href="css/style.css" />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
</head>
<body>
<?php
  session_start();
?>
  <!-- Header -->
  <header class="header">
    <div class="container header-content">
      <h1 class="logo">MaHa cerdAs</h1>
      <nav class="nav-links">
        <?php if (isset($_SESSION['username'])): ?>
          <span>Halo, <?= htmlspecialchars($_SESSION['username']) ?></span>
          <a href="logout.php" class="btn-login">Logout</a>
        <?php else: ?>
          <a href="login.php" class="btn-login">Masuk</a>
        <?php endif; ?>
      </nav>
    </div>
  </header>

  <!-- Hero Section -->
  <section class="hero">
    <div class="container hero-content">
      <div class="hero-text">
        <h2>Dari Rumah ke Masa Depan, Belajar Bersama MaHa cerdAs</h2>
        <p>Platform digital pembelajaran interaktif dengan materi dan latihan soal.</p>
      </div>
      <div class="hero-image">
        <img src="Assets/homepage1.jpeg" alt="Ilustrasi Pembelajaran Digital" />
      </div>
    </div>
  </section>

  <!-- (4) Fitur Utama -->
  <section class="features">
    <div class="features-grid">
      <a href="#materi" class="feature-card">
        <img src="Assets/pict1.jpeg" alt="Materi Interaktif" />
        <h4>Materi Interaktif</h4>
        <p>Belajar dengan materi yang disesuaikan dengan jenjang pendidikan.</p>
      </a>
      <a href="#latihan" class="feature-card">
        <img src="Assets/pict2.jpeg" alt="Latihan Soal" />
        <h4>Latihan Soal</h4>
        <p>Uji kemampuan dengan soal-soal adaptif dan pembahasan lengkap.</p>
      </a>
    </div>
  </section>

  <!-- (5) Testimoni Pengguna -->
  <section class="testimonials">
    <h2>Apa Kata Mereka?</h2>
    <div class="testimonial-grid">
      <div class="testimonial-card">
        <p>"Belajar jadi lebih seru! Materinya jelas dan gampang dipahami, cocok buat belajar mandiri."</p>
        <h4>Amalia</h4>
      </div>
      <div class="testimonial-card">
        <p>"Latihan soal adaptifnya bantu banget buat persiapan ujian. Bisa tahu kelemahanku di mana."</p>
        <h4>Hilya</h4>
      </div>
      <div class="testimonial-card">
        <p>"Materinya lengkap dan latihan soalnya bikin aku lebih percaya diri belajar di rumah."</p>
        <h4>Maulida</h4>
      </div>
    </div>
  </section>

  <!-- (6) Footer -->
  <footer class="footer-full">
    <div class="container footer-container">
      <div class="footer-col">
        <h2 class="footer-logo">MaHa cerdAs</h2>
      </div>

      <div class="footer-col">
        <h4>Untuk Siswa</h4>
        <ul>
          <li><a href="#">Materi SMP</a></li>
          <li><a href="#">Materi SMA</a></li>
        </ul>
        <h4>Untuk Guru</h4>
        <ul>
          <li><a href="#">Platform Guru</a></li>
        </ul>
      </div>

      <div class="footer-col">
        <h4>Tentang Kami</h4>
        <ul>
          <li><a href="#">Tentang MaHa</a></li>
          <li><a href="#">Karier</a></li>
          <li><a href="#">Blog Edukasi</a></li>
          <li><a href="#">Media</a></li>
        </ul>
      </div>

      <div class="footer-col">
        <h4>PT MaHa cerdAs Indonesia</h4>
        <p>Jl. Merdeka Raya Indonesia<br></p>
        <p>📞 0811 9999 0000 <strong>(Office)</strong></p>
        <p>✉️ info@mahacerdas.id</p>
        <h5>Customer Service</h5>
        <p>💬 0812 3456 7890</p>
      </div>
    </div>

    <div class="footer-copyright">
      <p>&copy; 2025 MaHa cerdAs. All right reserved.</p>
    </div>
  </footer>
</body>
</html>
