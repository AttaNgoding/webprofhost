<?php
$conn = mysqli_connect("localhost", "root", "", "perpus");
// Hapus Data
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    mysqli_query($conn, "delete from buku where kode_buku = '$id'");
    header("location:buku.php");
}

// Simpan/Update Data
if (isset($_POST['submit'])) {
    $kb = $_POST['kode_buku'];
    $nb = $_POST['nama_buku'];
    $jb = $_POST['kode_jenis'];
    $cek = mysqli_query($conn, "select * from buku where kode_buku='$kb'");
    if (mysqli_num_rows($cek) > 0) {
        mysqli_query($conn, "update buku set nama_buku='$nb', kode_jenis='$jb' where kode_buku='$kb'");
    } else {
        mysqli_query($conn, "insert into buku values ('$kb', '$nb', '$jb')");
    }
    header("location:buku.php");
}

$edit = null;
if (isset($_GET['edit'])) {
    $res = mysqli_query($conn, "select * from buku where kode_buku='" . $_GET['edit'] . "'");
    $edit = mysqli_fetch_array($res);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Buku</title>
</head>

<body>
    <center>
        <h3>Manajemen Data Buku</h3>
        <form method="post">
            <table border="0">
                <tr>buku
                    <td>Kode Buku</td>
                    <td>:</td>
                    <td><input type="text" name="kode_buku" value="<?php echo $edit['kode_buku'] ?? ''; ?>" required></td>
                </tr>
                <tr>
                    <td>Nama Buku</td>
                    <td>:</td>
                    <td><input type="text" name="nama_buku" value="<?php echo $edit['nama_buku'] ?? ''; ?>" required></td>
                </tr>
                <tr>
                    <td>Jenis Buku</td>
                    <td>:</td>
                    <td>
                        <select name="kode_jenis" required>
                            <option value="">Pilih Jenis Buku</option>
                            <?php
                            $res = mysqli_query($conn, "select * from jenis_buku");
                            while ($row = mysqli_fetch_array($res)) {
                                $selected = ($edit['kode_jenis'] == $row['kode_jenis']) ? "selected" : "";
                                echo "<option value='$row[kode_jenis]' $selected>$row[nama_jenis]</option>";
                            }
                            ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td colspan="3" align="center">
                        <button type="submit" name="submit">Simpan Data</button>
                    </td>
                </tr>
            </table>
        </form>

        <hr>
        <h3>Data Buku</h3>
        <table border="1" width="50%">
            <tr>
                <td align="center" width="20%"><b>Kode Buku</b></td>
                <td align="center" width="30%"><b>Nama Buku</b></td>
                <td align="center" width="20%"><b>Jenis Buku</b></td>
                <td align="center" width="30%"><b>Aksi</b></td>
            </tr>
            <?php
            $sql = "select * from buku join jenis_buku on buku.kode_jenis = jenis_buku.kode_jenis";
            $retval = mysqli_query($conn, $sql);
            while ($row = mysqli_fetch_array($retval)) {
                echo "<tr>";
                echo "<td>$row[kode_buku]</td>";
                echo "<td>$row[nama_buku]</td>";
                echo "<td>$row[nama_jenis]</td>";
                echo "<td><a href='?edit=$row[kode_buku]'>Edit</a> | 
                        <a href='?hapus=$row[kode_buku]' onclick=\"return confirm('Yakin ingin menghapus data ini?')\">Hapus</a></td>";
                echo "</tr>";
            }
            ?>
        </table>
    </center>
</body>

</html>