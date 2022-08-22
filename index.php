<?php
//create database connection using config file
include_once("config.php");

$nama       = "";
$email      = "";
$NIM        = "";
$tlp        = "";
$alamat     = "";
$sukses     = "";
$error      = "";


if (isset($_GET['op'])) {
    $op = $_GET['op'];
} else {
    $op = "";
}

if ($op == 'delete') { //delete data
    $id     = $_GET['id'];
    $sql1   = "DELETE FROM mahasiswa where id = '$id'";
    $q1     = mysqli_query($connection, $sql1);
    if ($q1) {
        $sukses = 'Berhasil hapus data';
    } else {
        $error  = 'Gagal melakukan hapus data';
    }
}

if ($op == 'edit') {
    $id     = $_GET['id'];
    $sql1   = "SELECT * FROM mahasiswa where id = '$id'";
    $q1     = mysqli_query($connection, $sql1);
    $r1     = mysqli_fetch_array($q1);
    $nama   = $r1['nama'];
    $email  = $r1['email'];
    $NIM    = $r1['NIM'];
    $tlp    = $r1['tlp'];
    $alamat = $r1['alamat'];

    if ($NIM == '') {
        $error = "Data tidak ditemukan";
    }
}


//create database
if (isset($_POST['simpan'])) {
    $nama   = $_POST['nama'];
    $email  = $_POST['email'];
    $NIM    = $_POST['NIM'];
    $tlp    = $_POST['tlp'];
    $alamat = $_POST['alamat'];

    if ($nama && $email && $NIM && $tlp && $alamat) {
        if ($op == 'edit') { //update data
            $sql1   = "UPDATE mahasiswa SET nama ='$nama', email = '$email', NIM = '$NIM', tlp = '$tlp', alamat = '$alamat' WHERE id = '$id'";
            $q1     = mysqli_query($connection, $sql1);
            if ($q1) {
                $sukses = 'Data berhasil diupdate';
            } else {
                $error = 'Data Gagal diupdate';
            }
        } else {
            // insert user data  
            $sqli1  = "INSERT INTO mahasiswa (nama, email, NIM, tlp, alamat) values('$nama', '$email', '$NIM', '$tlp', '$alamat')";
            $q1     = mysqli_query($connection, $sqli1);
            //validate input
            if ($q1) {
                $sukses = "Berhasil memasukan data baru";
            } else {
                $error = "Gagal memasukkan data";
            }
        }
    } else {
        $error = "silahkan masukkan semua data dahulu!";
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data mahasiswa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="mx-auto">
        <!-- input data -->
        <div class="card">
            <h5 class="card-header">Create | Edit Data</h5>
            <div class="card-body">
                <?php
                if ($error) {
                ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo $error ?>
                    </div>
                <?php
                    header("refresh:.5;url=index.php");
                }
                ?>
                <?php
                if ($sukses) {
                ?>
                    <div class="alert alert-success" role="alert">
                        <?php echo $sukses ?>
                    </div>
                <?php
                    header("refresh:.5;url=index.php");
                }
                ?>
                <form action="" method="POST">
                    <div class="mb-3 row">
                        <label for="nama" class="col-sm-2 col-form-label">Nama</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="nama" name="nama" value="<?php echo $nama ?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="email" class="col-sm-2 col-form-label">Email</label>
                        <div class="col-sm-10">
                            <input type="email" class="form-control" id="email" name="email" value="<?php echo $email ?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="NIM" class="col-sm-2 col-form-label">NIM</label>
                        <div class="col-sm-10">
                            <input type="number" class="form-control" id="NIM" name="NIM" value="<?php echo $NIM ?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="tlp" class="col-sm-2 col-form-label">Telephone</label>
                        <div class="col-sm-10">
                            <input type="tel" pattern="[0-9]{4}-[0-9]{4}-[0-9]{4}" placeholder="1234-5678-9012" class="form-control" id="tlp" name="tlp" value="<?php echo $tlp ?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="alamat" class="col-sm-2 col-form-label">Alamat</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="alamat" name="alamat" value="<?php echo $alamat ?>">
                        </div>
                    </div>
                    <div class="col-12">
                        <input type="submit" name="simpan" value="Simpan Data" class="btn btn-primary">
                    </div>
                </form>
            </div>
        </div>

        <!-- output data -->
        <div class="card">
            <h5 class="card-header">Data Mahasiswa</h5>
            <div class="card-body">
                <form action="" method="POST">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">No</th>
                                <th scope="col-12">Nama</th>
                                <th scope="col">Email</th>
                                <th scope="col">NIM</th>
                                <th scope="col">Telephone</th>
                                <th scope="col">Alamat</th>
                                <th scope="col">Aksi</th>
                            </tr>
                        <tbody>
                            <?php
                            $sql2   = "SELECT * FROM mahasiswa order by id desc";
                            $q2     = mysqli_query($connection, $sql2);
                            $urut   = 1;
                            while ($r2 = mysqli_fetch_array($q2)) {
                                $id     = $r2['id'];
                                $nama   = $r2['nama'];
                                $email  = $r2['email'];
                                $NIM    = $r2['NIM'];
                                $tlp    = $r2['tlp'];
                                $alamat = $r2['alamat'];

                            ?>
                                <tr>
                                    <th scope="row"><?php echo $urut++ ?></th>
                                    <td scope="row"><?php echo $nama ?></td>
                                    <td scope="row"><?php echo $email ?></td>
                                    <td scope="row"><?php echo $NIM ?></td>
                                    <td scope="row"><?php echo $tlp ?></td>
                                    <td scope="row"><?php echo $alamat ?></td>
                                    <td scope="row">
                                        <a href="index.php?op=edit&id=<?php echo $id ?>"><button type="button" class="btn btn-warning mb-2" style="width: 80px ; ">Edit</button></a>
                                        <a href="index.php?op=delete&id=<?php echo $id ?>" onclick="return confirm('Yakin ingin hapus data?')"><button type="button" class="btn btn-danger" style="width: 80px;">Delete</button></a>
                                    </td>
                                </tr>
                            <?php


                            }
                            ?>
                        </tbody>
                        </thead>
                    </table>
                </form>
            </div>
        </div>
    </div>
</body>

</html>