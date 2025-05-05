<?php
session_start();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar Mahasiswa</title>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@500;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body {
            font-family: 'Quicksand', sans-serif;
            background: #e0e5ec;
            margin: 0;
            padding: 20px;
        }

        h2 {
            text-align: center;
            color: #2d3436;
            margin-bottom: 25px;
            font-size: 2.5rem;
            font-weight: 700;
        }

        .button-container {
            text-align: center;
            margin-bottom: 30px;
        }

        .button-container a {
            text-decoration: none;
            background: #00cec9;
            color: white;
            padding: 12px 24px;
            border-radius: 50px;
            font-size: 1rem;
            font-weight: bold;
            transition: all 0.3s ease;
            box-shadow: 4px 4px 10px #bebebe, -4px -4px 10px #ffffff;
        }

        .button-container a:hover {
            background: #00b894;
            box-shadow: inset 4px 4px 10px #bebebe, inset -4px -4px 10px #ffffff;
        }

        table {
            width: 90%;
            margin: 0 auto;
            border-collapse: collapse;
            background: #ecf0f3;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 10px 10px 30px #bebebe, -10px -10px 30px #ffffff;
        }

        th, td {
            padding: 15px;
            text-align: center;
            font-size: 1rem;
            color: #2d3436;
        }

        th {
            background: linear-gradient(145deg, #d1d9e6, #ffffff);
            font-size: 1.2rem;
            letter-spacing: 1px;
            text-transform: uppercase;
        }

        tr {
            transition: all 0.3s ease;
        }

        tr:hover {
            background-color: #dfe6e9;
        }

        .aksi a {
            padding: 8px 16px;
            margin: 2px;
            border-radius: 30px;
            font-size: 0.9rem;
            font-weight: bold;
            text-decoration: none;
            display: inline-block;
            transition: all 0.3s ease;
        }

        .edit {
            background: #6c5ce7;
            color: white;
            box-shadow: 2px 2px 6px #b8b9be, -2px -2px 6px #ffffff;
        }

        .edit:hover {
            background: #5e50e6;
            transform: scale(1.05);
        }

        .hapus {
            background: #d63031;
            color: white;
            box-shadow: 2px 2px 6px #b8b9be, -2px -2px 6px #ffffff;
        }

        .hapus:hover {
            background: #c0392b;
            transform: scale(1.05);
        }

        @media (max-width: 768px) {
            table, th, td {
                font-size: 0.9rem;
            }
            .button-container a {
                padding: 10px 20px;
            }
        }
    </style>
</head>

<body>

<h2>Daftar Mahasiswa</h2>

<div class="button-container">
    <a href="tambah.php">+ Tambah Data Mahasiswa</a>
</div>

<table>
    <tr>
        <th>No</th>
        <th>NPM</th>
        <th>Nama</th>
        <th>Program Studi</th>
        <th>Email</th>
        <th>Alamat</th>
        <th>Aksi</th>
    </tr>

    <?php
    include "koneksi.php";
    $query = mysqli_query($conn, "SELECT * FROM tbl_mahasiswa");
    $no = 1;

    while ($data = mysqli_fetch_array($query)) {
        echo "<tr>
                <td>$no</td>
                <td>{$data['npm']}</td>
                <td>{$data['nama']}</td>
                <td>{$data['prodi']}</td>
                <td>{$data['email']}</td>
                <td>{$data['alamat']}</td>
                <td class='aksi'>
                    <a class='edit' href='edit.php?npm={$data['npm']}'>Edit</a>
                    <a class='hapus' href='#' onclick=\"deleteConfirm('{$data['npm']}')\">Hapus</a>
                </td>
              </tr>";
        $no++;
    }
    ?>
</table>

<?php
// Tampilkan pesan jika ada session 'pesan'
if (isset($_SESSION['pesan'])) {
    echo "<script>
    Swal.fire({
        icon: '{$_SESSION['ikon']}',
        title: '{$_SESSION['pesan']}',
        showConfirmButton: false,
        timer: 2000
    });
    </script>";
    unset($_SESSION['pesan']);
    unset($_SESSION['ikon']);
}
?>

<script>
    // Konfirmasi SweetAlert untuk Hapus Data
    function deleteConfirm(npm) {
        Swal.fire({
            title: 'Yakin ingin menghapus data ini?',
            text: "Data yang dihapus tidak bisa dikembalikan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d63031',
            cancelButtonColor: '#6c5ce7',
            confirmButtonText: 'Hapus',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                // Jika mengonfirmasi, lakukan penghapusan
                window.location.href = 'hapus.php?npm=' + npm;
            }
        });
    }
</script>

</body>
</html>
