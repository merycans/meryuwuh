<?php
session_start();
include "koneksi.php";

// cek apakah tombol submit sudah ditekan
if (isset($_POST['submit'])) {
    // ambil data dari form
    $npm = $_POST['npm'];
    $nama = $_POST['nama'];
    $prodi = $_POST['prodi'];
    $email = $_POST['email'];
    $alamat = $_POST['alamat'];

    // cek jika ada field yang hanya berisi spasi
    if (trim($npm) == "" || trim($nama) == "" || trim($prodi) == "" || trim($email) == "" || trim($alamat) == "") {
        $_SESSION['pesan'] = 'Data belum lengkap! Pastikan semua data terisi dengan benar.';
        $_SESSION['ikon'] = 'warning';
        header("Location: tambah.php");
        exit;
    }

    // query insert data jika semua data valid
    $hasil = mysqli_query($conn, "INSERT INTO tbl_mahasiswa (npm, nama, prodi, email, alamat) 
                                  VALUES ('$npm', '$nama', '$prodi', '$email', '$alamat')");

    if ($hasil) {
        $_SESSION['pesan'] = 'Data berhasil disimpan';
        $_SESSION['ikon'] = 'success';
    } else {
        $_SESSION['pesan'] = 'Data gagal disimpan';
        $_SESSION['ikon'] = 'error';
    }

    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Data Mahasiswa</title>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@500;700&display=swap" rel="stylesheet">
    <!-- Link SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body {
            font-family: 'Quicksand', sans-serif;
            background: linear-gradient(135deg, #dff9fb, #f9f7f7);
            margin: 0;
            padding: 20px;
        }

        .form-container {
            width: 420px;
            margin: 40px auto;
            padding: 30px;
            background: #ecf0f3;
            border-radius: 20px;
            box-shadow: 10px 10px 20px #bebebe, -10px -10px 20px #ffffff;
        }

        h3 {
            text-align: center;
            color: #2c3e50;
            margin-bottom: 10px;
            font-weight: 700;
        }

        p {
            text-align: center;
            color: #636e72;
            margin-bottom: 20px;
            font-size: 0.95rem;
        }

        form {
            width: 100%;
        }

        table {
            width: 100%;
        }

        td {
            padding: 10px 0;
        }

        label {
            font-size: 0.95rem;
            font-weight: 600;
            color: #2c3e50;
        }

        input[type="text"],
        input[type="email"],
        textarea,
        select {
            width: 100%;
            padding: 10px 14px;
            margin-top: 4px;
            border: none;
            border-radius: 10px;
            background: #f0f0f0;
            box-shadow: inset 3px 3px 6px #d1d9e6, inset -3px -3px 6px #ffffff;
            font-size: 0.95rem;
        }

        input[type="submit"] {
            width: 100%;
            background: #00cec9;
            color: white;
            border: none;
            padding: 12px;
            border-radius: 50px;
            font-size: 1rem;
            font-weight: bold;
            margin-top: 20px;
            cursor: pointer;
            box-shadow: 4px 4px 10px #bebebe, -4px -4px 10px #ffffff;
            transition: all 0.3s ease;
        }

        input[type="submit"]:hover {
            background: #00b894;
            transform: scale(1.03);
        }

        .back-link {
            display: block;
            text-align: center;
            margin-top: 20px;
            text-decoration: none;
            font-size: 0.95rem;
            color: #0984e3;
            font-weight: bold;
        }

        .back-link:hover {
            color: #0077b6;
        }

        @media (max-width: 500px) {
            .form-container {
                width: 90%;
                padding: 20px;
            }
        }
    </style>
</head>

<body>

<div class="form-container">
    <h3>Tambah Data Mahasiswa</h3>
    <p>Silakan isi form berikut dengan data lengkap mahasiswa:</p>

    <form action="" method="post" id="addForm">
        <table>
            <tr>
                <td><label for="npm">NPM:</label></td>
                <td><input type="text" name="npm" id="npm" maxlength="12" required></td>
            </tr>
            <tr>
                <td><label for="nama">Nama:</label></td>
                <td><input type="text" name="nama" id="nama" required></td>
            </tr>
            <tr>
                <td><label for="prodi">Program Studi:</label></td>
                <td>
                    <select name="prodi" id="prodi" required>
                        <option value="">--Pilih Prodi--</option>
                        <option value="Pendidikan Informatika">Pendidikan Informatika</option>
                        <option value="Teknologi Informasi">Teknologi Informasi</option>
                        <option value="Sistem Informasi">Sistem Informasi</option>
                        <option value="Teknik Komputer">Teknik Komputer</option>
                        <option value="Teknik Informatika">Teknik Informatika</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td><label for="email">Email:</label></td>
                <td><input type="email" name="email" id="email" required></td>
            </tr>
            <tr>
                <td><label for="alamat">Alamat:</label></td>
                <td><textarea name="alamat" id="alamat" rows="3" required></textarea></td>
            </tr>
            <tr>
                <td colspan="2" align="center">
                    <input type="submit" name="submit" value="Simpan Data">
                </td>
            </tr>
        </table>
    </form>

    <a class="back-link" href="index.php">← Kembali ke Daftar Mahasiswa</a>
</div>

<script>
    document.getElementById('addForm').onsubmit = function(event) {
        var npm = document.getElementById('npm').value.trim();
        var nama = document.getElementById('nama').value.trim();
        var prodi = document.getElementById('prodi').value.trim();
        var email = document.getElementById('email').value.trim();
        var alamat = document.getElementById('alamat').value.trim();

        if (!npm || !nama || !prodi || !email || !alamat) {
            event.preventDefault(); // Mencegah form untuk disubmit
            Swal.fire({
                title: 'Peringatan!',
                text: 'Data belum lengkap! Pastikan semua data terisi dengan benar!.',
                icon: 'warning',
                confirmButtonText: 'OK'
            });
        }
    }
</script>

</body>
</html>
