<?php
$host = 'localhost';
$port = '5432';
$dbname = 'db_surat';
$user = 'postgres';
$password = 'root';

$conn_string = "host={$host} port={$port} dbname={$dbname} user={$user} password={$password}";

echo "Mencoba koneksi ke PostgreSQL...\n";

// Menggunakan @ untuk menekan warning default agar kita bisa tangani errornya sendiri
$dbconn = @pg_connect($conn_string);

if ($dbconn) {
    echo "Koneksi BERHASIL! PHP bisa terhubung ke PostgreSQL.\n";
} else {
    echo "Koneksi GAGAL! Masalahnya ada di antara PHP dan PostgreSQL.\n";
    $error = pg_last_error(); // Mengambil pesan error terakhir dari PostgreSQL
    echo "Pesan Error: " . $error . "\n";
}
?>