CREATE DATABASE IF NOT EXISTS mahacerdas;
USE mahacerdas;

CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nama VARCHAR(100),
  email VARCHAR(100) UNIQUE,
  password VARCHAR(255),
  role ENUM('siswa','guru','admin'),
  validasi BOOLEAN DEFAULT 0
);

-- Password hash acak, bisa diganti hasil password_hash()
INSERT INTO users (nama, email, password, role, validasi) VALUES
('Admin Utama', 'admin@maha.id', '$2y$10$exampleadminpasswordhash', 'admin', 1),
('Guru Matematika', 'guru@maha.id', '$2y$10$examplegurupasswordhash', 'guru', 1),
('Siswa Cerdas', 'siswa@maha.id', '$2y$10$examplesiswapasswordhash', 'siswa', 1);

CREATE TABLE materi (
  id INT AUTO_INCREMENT PRIMARY KEY,
  judul VARCHAR(255),
  deskripsi TEXT,
  file VARCHAR(255)
);

INSERT INTO materi (judul, deskripsi, file) VALUES
('Pengantar Matematika', 'Dasar-dasar pelajaran untuk siswa SMP', 'pengantar_mtk.pdf');

CREATE TABLE soal (
  id INT AUTO_INCREMENT PRIMARY KEY,
  pertanyaan TEXT,
  opsi_a VARCHAR(255),
  opsi_b VARCHAR(255),
  opsi_c VARCHAR(255),
  opsi_d VARCHAR(255),
  jawaban CHAR(1)
);

INSERT INTO soal (pertanyaan, opsi_a, opsi_b, opsi_c, opsi_d, jawaban) VALUES
('Berapa hasil dari 2 + 2?', '3', '4', '5', '6', 'B');

CREATE TABLE video (
  id INT AUTO_INCREMENT PRIMARY KEY,
  judul VARCHAR(255),
  link TEXT
);

INSERT INTO video (judul, link) VALUES
('Matematika Kelas 7', 'https://www.youtube.com/embed/dQw4w9WgXcQ');

CREATE TABLE hasil (
  id INT AUTO_INCREMENT PRIMARY KEY,
  siswa VARCHAR(100),
  soal TEXT,
  jawaban VARCHAR(10),
  nilai INT
);

CREATE TABLE mapel (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nama_mapel VARCHAR(100),
  jenjang ENUM('SD', 'SMP', 'SMA')
);

INSERT INTO mapel (nama_mapel, jenjang) VALUES
('Matematika', 'SMP'),
('Bahasa Indonesia', 'SMA');

CREATE TABLE aktivitas (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user VARCHAR(100),
  aktivitas TEXT,
  waktu TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO aktivitas (user, aktivitas) VALUES
('Guru Matematika', 'Mengupload soal');
