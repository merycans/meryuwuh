<?php
session_start();
if (isset($_GET['npm'])) {
    include "koneksi.php";
    $npm = $_GET['npm'];

    // jalankan query hapus
    $hapus = mysqli_query($conn, "DELETE FROM tbl_mahasiswa WHERE npm='$npm'");

    if ($hapus) {
        // Jika berhasil dihapus
        $_SESSION['pesan'] = 'Data berhasil dihapus';
        $_SESSION['ikon'] = 'success';
    } else {
        // Jika gagal menghapus
        $_SESSION['pesan'] = 'Data gagal dihapus';
        $_SESSION['ikon'] = 'error';
    }

    // Menampilkan SweetAlert setelah query
    echo "
        <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
        <script>
            Swal.fire({
                icon: '".$_SESSION['ikon']."',
                title: '".$_SESSION['pesan']."',
                showConfirmButton: false,
                timer: 1500
            }).then(function() {
                window.location.href = 'index.php';  // Redirect ke halaman index.php setelah beberapa detik
            });
        </script>
    ";

    // Menghapus session setelah ditampilkan untuk menghindari tampil berulang kali
    unset($_SESSION['pesan']);
    unset($_SESSION['ikon']);
    exit;
} else {
    // Menampilkan SweetAlert jika NPM tidak ditemukan
    echo "
        <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
        <script>
            Swal.fire({
                icon: 'warning',
                title: 'NPM tidak ditemukan',
                showConfirmButton: false,
                timer: 1500
            }).then(function() {
                window.location.href = 'index.php';  // Kembali ke index.php setelah beberapa detik
            });
        </script>
    ";
    exit;
}
?>
