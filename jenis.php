<?php
$conn = mysqli_connect("localhost", "root", "", "perpus");

// Hapus Data
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    mysqli_query($conn, "delete from jenis_buku where kode_jenis = '$id'");
    header("location:jenis.php");
}

// Simpan/Update Data
if (isset($_POST['submit'])) {
    $kode = $_POST['kode'];
    $nama = $_POST['nama'];
    $ket = $_POST['ket'];

    $cek = mysqli_query($conn, "select * from jenis_buku where kode_jenis='$kode'");
    if (mysqli_num_rows($cek) > 0) {
        mysqli_query($conn, "update jenis_buku set nama_jenis='$nama', keterangan_jenis='$ket' where kode_jenis='$kode'");
    } else {
        mysqli_query($conn, "insert into jenis_buku values ('$kode', '$nama', '$ket')");
    }
    header("location:jenis.php");
}

$edit = null;
if (isset($_GET['edit'])) {
    $res = mysqli_query($conn, "select * from jenis_buku where kode_jenis='" . $_GET['edit'] . "'");
    $edit = mysqli_fetch_array($res);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jenis Buku</title>
</head>

<body>
    <center>
        <h3>Manajemen Jenis Buku</h3>
        <form method="post">
            <table border="0">
                <tr>
                    <td>Kode Jenis</td>
                    <td>:</td>
                    <td><input type="text" name="kode" value="<?php echo $edit['kode_jenis'] ?? ''; ?>" required></td>
                </tr>
                <tr>
                    <td>Nama Jenis</td>
                    <td>:</td>
                    <td><input type="text" name="nama" value="<?php echo $edit['nama_jenis'] ?? ''; ?>" required></td>
                </tr>
                <tr>
                    <td>Keterangan</td>
                    <td>:</td>
                    <td><input type="text" name="ket" value="<?php echo $edit['keterangan_jenis'] ?? ''; ?>"></td>
                </tr>
                <tr>
                    <td colspan="3" align="center">
                        <button type="submit" name="submit">Simpan Data</button>
                    </td>
                </tr>
            </table>
            <table border="1" width="50%">
                <tr>
                    <td align="center" width="20%"><b>Kode Jenis</b></td>
                    <td align="center" width="30%"><b>Nama Jenis</b></td>
                    <td align="center" width="30%"><b>Keterangan</b></td>
                    <td align="center" width="20%"><b>Aksi</b></td>
                </tr>
                <?php
                $res = mysqli_query($conn, "select * from jenis_buku");
                while ($row = mysqli_fetch_array($res)) {
                    echo "<tr>";
                    echo "<td>" . $row['kode_jenis'] . "</td>";
                    echo "<td>" . $row['nama_jenis'] . "</td>";
                    echo "<td>" . $row['keterangan_jenis'] . "</td>";
                    echo "<td><a href='?edit=" . $row['kode_jenis'] . "'>Edit</a> | <a href='?hapus=" . $row['kode_jenis'] . "' onclick=\"return confirm('Yakin ingin menghapus data ini?')\">Hapus</a></td>";
                    echo "</tr>";
                }
                ?>
            </table>
            <button type="button" onclick="window.location.href='buku.php'">Kembali</button>
        </form>
    </center>
</body>

</html>