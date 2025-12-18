                                                                          <--TUGAS BESAR PEMROGRAMAN WEB-->


QUERY MYSQL yan di pakai sebagai berikut

CREATE DATABASE data_tubes;

CREATE TABLE data_masuk ( id INT AUTO_INCREMENT PRIMARY KEY, nama VARCHAR(100) NOT NULL, email VARCHAR(100) NOT NULL , password VARCHAR(255) NOT NULL, created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP );

<--query role admin dan user-->
ALTER TABLE data_masuk
ADD role ENUM('admin','user') NOT NULL DEFAULT 'user';

<--query untuk admin-->
INSERT INTO data_masuk (nama, email, password, role)
VALUES ('Admin', 'admin@finwise.com', 'HASH_PASSWORD', 'admin'); 

yang dimasukin di layar nanti 
email/username   : admin
password         : admin123

<--query user sementara-->
INSERT INTO data_masuk (nama, email, password)
VALUES ('Budi', 'budi@email.com', 'HASH_PASSWORD');

yang dimasukin di layar nanti 
email/username   : budi
password         : budi123

CREATE TABLE aset (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL,
  nama_aset VARCHAR(100) NOT NULL,
  jenis_aset ENUM('investasi','properti','kendaraan','lainnya') NOT NULL,
  nilai INT NOT NULL,
  tanggal_perolehan DATE DEFAULT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (user_id) REFERENCES data_masuk(id)
);

CREATE TABLE saving_goals (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL,
  nama_target VARCHAR(100) NOT NULL,
  target_nominal INT NOT NULL,
  saldo_sekarang INT DEFAULT 0,
  tanggal_target DATE NOT NULL,
  status ENUM('aktif','tercapai') DEFAULT 'aktif',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (user_id) REFERENCES data_masuk(id)
);

CREATE TABLE tagihan (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    nama_tagihan VARCHAR(100) NOT NULL,
    jumlah INT NOT NULL,
    kategori VARCHAR(50) NOT NULL,
    frekuensi ENUM('bulanan','tahunan') NOT NULL,
    tanggal_jatuh_tempo DATE NOT NULL,
    status ENUM('belum','lunas') DEFAULT 'belum',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES data_masuk(id)
);

CREATE TABLE transaksi (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL,
  jenis ENUM('pemasukan','pengeluaran') NOT NULL,
  kategori VARCHAR(50) NOT NULL,
  jumlah INT NOT NULL,
  keterangan VARCHAR(255),
  tanggal DATE NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (user_id) REFERENCES data_masuk(id)
);
