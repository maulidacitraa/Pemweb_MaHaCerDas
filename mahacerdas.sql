CREATE DATABASE IF NOT EXISTS mahacerdas;
USE mahacerdas;

CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nama VARCHAR(100),
  email VARCHAR(100) UNIQUE,
  password VARCHAR(255),
  role ENUM('siswa','guru','admin'),
  jenjang ENUM('SMP', 'SMA'),
  validasi BOOLEAN DEFAULT 0,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Password hash acak
INSERT INTO users (nama, email, password, role, validasi) VALUES
('Guru SMA', 'gurusma@maha.id', '$2y$10$examplegurupasswordhash', 'guru', 1),
('Guru SMP', 'gurusmp@maha.id', '$2y$10$examplegurupasswordhash', 'guru', 1);

CREATE TABLE materi (
  id INT AUTO_INCREMENT PRIMARY KEY,
  judul VARCHAR(255) NOT NULL,
  deskripsi TEXT,
  file VARCHAR(255) NOT NULL,
  mapel VARCHAR(100),
  jenjang ENUM('SMP', 'SMA'),
  id_guru INT NOT NULL,
  tanggal_upload DATETIME DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (id_guru) REFERENCES users(id)
);

CREATE TABLE mapel (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nama_mapel VARCHAR(100),
  jenjang ENUM('SMP', 'SMA')
);

INSERT INTO mapel (nama_mapel, jenjang) VALUES
('Matematika', 'SMP'),
('Bahasa Indonesia', 'SMA');

CREATE TABLE aktivitas (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user VARCHAR(100),
  aktivitas TEXT,
  role ENUM('siswa', 'guru'),
  waktu TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE soal (
  id INT AUTO_INCREMENT PRIMARY KEY,
  jenjang ENUM('SMP','SMA') NOT NULL,
  mapel VARCHAR(100) NOT NULL,
  pertanyaan TEXT NOT NULL,
  pilihan_a TEXT NOT NULL,
  pilihan_b TEXT NOT NULL,
  pilihan_c TEXT NOT NULL,
  pilihan_d TEXT NOT NULL,
  jawaban CHAR(1) NOT NULL,         
  id_guru INT,                      
  tanggal_upload TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE jawaban_siswa (
  id INT AUTO_INCREMENT PRIMARY KEY,
  id_siswa INT NOT NULL,
  id_soal INT NOT NULL,
  jawaban CHAR(1) NOT NULL,
  benar BOOLEAN,
  FOREIGN KEY (id_siswa) REFERENCES users(id) ON DELETE CASCADE,
  FOREIGN KEY (id_soal) REFERENCES soal(id) ON DELETE CASCADE
);

CREATE TABLE hasil_latihan (
  id INT AUTO_INCREMENT PRIMARY KEY,
  id_siswa INT NOT NULL,
  mapel VARCHAR(100) NOT NULL,
  jenjang ENUM('SMP','SMA') NOT NULL,
  jumlah_soal INT NOT NULL,
  benar INT NOT NULL,
  salah INT NOT NULL,
  nilai INT NOT NULL,
  tanggal DATETIME DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (id_siswa) REFERENCES users(id) ON DELETE CASCADE
);
