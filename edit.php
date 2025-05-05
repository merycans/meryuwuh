<?php
session_start();
include "koneksi.php";

if (isset($_GET['npm'])) {
    $npm = $_GET['npm'];
    $query = mysqli_query($conn, "SELECT * FROM tbl_mahasiswa WHERE npm='$npm'");
    $data = mysqli_fetch_assoc($query);
    if (!$data) {
        $_SESSION['pesan'] = 'Data tidak ditemukan';
        $_SESSION['ikon'] = 'error';
        header("Location: index.php");
        exit;
    }
} else {
    $_SESSION['pesan'] = 'NPM tidak ditemukan';
    $_SESSION['ikon'] = 'error';
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Data Mahasiswa</title>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@500;700&display=swap" rel="stylesheet">
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
            margin-bottom: 20px;
            font-weight: 700;
        }

        table {
            width: 100%;
        }

        td {
            padding: 10px 0;
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
            transition: 0.3s ease;
        }

        input[type="submit"]:hover {
            background: #00b894;
            transform: scale(1.03);
        }

        .back-link {
            display: block;
            margin-top: 20px;
            text-align: center;
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
    <h3>Edit Data Mahasiswa</h3>

    <form action="" method="post">
        <table>
            <tr>
                <td><label for="npm">NPM</label></td>
                <td><input type="text" name="npm" value="<?= $data['npm'] ?>" readonly></td>
            </tr>
            <tr>
                <td><label for="nama">Nama</label></td>
                <td><input type="text" name="nama" value="<?= $data['nama'] ?>" required></td>
            </tr>
            <tr>
                <td><label for="prodi">Program Studi</label></td>
                <td>
                    <select name="prodi" required>
                        <option value="">--Pilih Prodi--</option>
                        <?php
                        $prodi_list = ["Pendidikan Informatika", "Teknologi Informasi", "Sistem Informasi", "Teknik Komputer", "Teknik Informatika"];
                        foreach ($prodi_list as $p) {
                            $selected = ($p == $data['prodi']) ? "selected" : "";
                            echo "<option value='$p' $selected>$p</option>";
                        }
                        ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td><label for="email">Email</label></td>
                <td><input type="email" name="email" value="<?= $data['email'] ?>"></td>
            </tr>
            <tr>
                <td><label for="alamat">Alamat</label></td>
                <td><textarea name="alamat" rows="3"><?= $data['alamat'] ?></textarea></td>
            </tr>
        </table>
        <input type="submit" name="update" value="Update Data">
    </form>

    <a class="back-link" href="index.php">← Kembali ke Daftar Mahasiswa</a>
</div>

<?php
if (isset($_POST['update'])) {
    $nama = $_POST['nama'];
    $prodi = $_POST['prodi'];
    $email = $_POST['email'];
    $alamat = $_POST['alamat'];

    $update = mysqli_query($conn, "UPDATE tbl_mahasiswa SET 
        nama='$nama',
        prodi='$prodi',
        email='$email',
        alamat='$alamat' 
        WHERE npm='$npm'");

    if ($update) {
        $_SESSION['pesan'] = 'Data berhasil diperbarui';
        $_SESSION['ikon'] = 'success';
    } else {
        $_SESSION['pesan'] = 'Data gagal diperbarui';
        $_SESSION['ikon'] = 'error';
    }

    echo "<script>window.location.href='index.php';</script>";
}
?>

</body>
</html>
