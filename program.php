<?php
// Konfigurasi koneksi database
$host = 'localhost';
$user = 'root';
$pass = '';
$dbname = 'universitas';

// Membuat koneksi ke database
$conn = mysqli_connect($host, $user, $pass, $dbname);

// Memeriksa koneksi
if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

echo "Koneksi berhasil<br><br>";

// 1. Update alamat mahasiswa dengan NIM '123456' menjadi 'Jl. Raya No.5'.
$nim = '123456';
$alamat_baru = 'Jl. Raya No.5';

$sql = "UPDATE Mahasiswa SET Alamat = '$alamat_baru' WHERE NIM = '$nim'";
if (mysqli_query($conn, $sql)) {
    echo "Alamat mahasiswa dengan NIM $nim berhasil diupdate menjadi $alamat_baru.<br><br>";
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn) . "<br><br>";
}

// 2. Tampilkan NIM, nama, dan jurusan dari mahasiswa yang memiliki jurusan 'Teknik Informatika',
//    serta tampilkan juga nama dosen pembimbingnya.
$jurusan = 'Teknik Informatika';

$sql = "SELECT m.NIM, m.Nama, m.Jurusan, mk.Dosen_Pengajar AS Dosen_Pembimbing 
        FROM Mahasiswa m
        JOIN Mata_Kuliah mk ON m.NIM = mk.NIM
        WHERE m.Jurusan = '$jurusan'";

$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    echo "Mahasiswa dengan jurusan $jurusan:<br>";
    while ($row = mysqli_fetch_assoc($result)) {
        echo "NIM: " . $row['NIM'] . ", Nama: " . $row['Nama'] . ", Jurusan: " . $row['Jurusan'] . ", Dosen Pembimbing: " . $row['Dosen_Pembimbing'] . "<br>";
    }
} else {
    echo "Tidak ada data mahasiswa dengan jurusan $jurusan.<br>";
}

echo "<br>";

// 3. Tampilkan 5 nama mahasiswa dengan umur tertua.
$sql = "SELECT Nama FROM Mahasiswa ORDER BY Umur DESC LIMIT 5";
$result = mysqli_query($conn, $sql);

echo "5 Mahasiswa Tertua:<br>";
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        echo $row['Nama'] . "<br>";
    }
} else {
    echo "Tidak ada data mahasiswa.<br>";
}

echo "<br>";

// 4. Tampilkan nama mahasiswa, mata kuliah yang diambil, dan nilai yang diperoleh untuk setiap mata kuliah. 
//    Hanya tampilkan data mahasiswa yang memiliki nilai lebih bagus dari 70.
$nilai_min = 70;

$sql = "SELECT m.Nama, mk.Mata_Kuliah, mk.Nilai  
        FROM Mahasiswa m
        JOIN Mata_Kuliah mk ON m.NIM = mk.NIM
        WHERE mk.Nilai > $nilai_min";
        
$result = mysqli_query($conn, $sql);

echo "Mahasiswa dengan Nilai > $nilai_min:<br>";
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        echo "Nama: " . $row['Nama'] . ", Mata Kuliah: " . $row['Mata_Kuliah'] . ", Nilai: " . $row['Nilai'] . "<br>";
    }
} else {
    echo "Tidak ada data mahasiswa dengan nilai lebih dari $nilai_min.<br>";
}

// Menutup koneksi
mysqli_close($conn);
?>