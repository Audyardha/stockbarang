<?php
require 'function.php';
require 'cek.php';

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Stock Barang</title>
    <link href="css/styles.css" rel="stylesheet" />
    <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/js/all.min.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $("#select1").change(function() {
                var selectedOption = $(this).val();

                // Send selected option to PHP file
                $.ajax({
                    url: "function.php",
                    method: "POST",
                    data: {
                        option: selectedOption
                    },
                    success: function(data) {
                        $("#select2").html(data);
                    }
                });
            });
        });
    </script>
</head>

<body class="sb-nav-fixed">
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <a class="navbar-brand" href="index.php">Inventory Bengkel</a>
        <button class="btn btn-link btn-sm order-1 order-lg-0" id="sidebarToggle" href="#"><i class="fas fa-bars"></i></button>

    </nav>
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <div class="nav">
                        <a class="nav-link" href="index.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                            Stock Barang
                        </a>
                        <a class="nav-link" href="data.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                            Jenis Barang
                        </a>
                        <a class="nav-link" href="keluar.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                            Barang Keluar
                        </a>
                        <a class="nav-link" href="logout.php">
                            Logout
                        </a>
                    </div>
                </div>
            </nav>
        </div>
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid">
                    <h1 class="mt-4">Stock Barang</h1>
                    <div class="card mb-4">
                        <div class="card-header">
                            <!-- Button to Open the Modal -->
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
                                Tambah Barang
                            </button>
                        </div>

                        <a href="cetak.php" target="_blank">CETAK<a>
                            

                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Barang</th>
                                            <th>Deskripsi</th>
                                            <th>Stock</th>
                                            <th>Tanggal Masuk</th>
                                            <th>Tanggal Ubah Data</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <?php
                                    $ambilsemuadatastock = mysqli_query($conn, "SELECT t1.idmasuk, DATE_FORMAT(t1.tanggal, '%d %M %Y') AS formatted_enter, DATE_FORMAT(t1.ubah, '%d %M %Y') AS formatted_update, t1.keterangan,t1.qty, t2.namaJenisBarang, t2.idbarang
                                    FROM masuk t1
                                    INNER JOIN jenis_barang t2 ON t1.idbarang = t2.idbarang");
                                    $i = 1;
                                    while ($data = mysqli_fetch_array($ambilsemuadatastock)) {
                                        $namabarang = $data['namaJenisBarang'];
                                        $deskripsi = $data['keterangan'];
                                        $stock = $data['qty'];
                                        $ndate = $data['formatted_enter'];
                                        $udate = $data['formatted_update'];
                                        $idb = $data['idmasuk'];
                                        $idbrg = $data['idbarang'];
                                    ?>

                                        <tr>
                                            <td><?= $i++; ?></td>
                                            <td><?= $namabarang; ?></td>
                                            <td><?= $deskripsi; ?></td>
                                            <td><?= $stock; ?></td>
                                            <td><?= $ndate; ?></td>
                                            <td><?= $udate; ?></td>
                                            <td>
                                                <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#edit<?= $idb; ?>">
                                                    Edit
                                                </button>
                                                <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#delete<?= $idb; ?>">
                                                    Delete
                                                </button>
                                                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#ambil<?= $idb; ?>">
                                                    Barang Keluar
                                                </button>
                                            </td>
                                        </tr>

                                        <!-- Edit Modal -->
                                        <div class="modal fade" id="edit<?= $idb; ?>">
                                            <div class="modal-dialog">
                                                <div class="modal-content">

                                                    <!-- Modal Header -->
                                                    <div class="modal-header">
                                                        <h4 class="modal-title">Edit Barang</h4>
                                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                    </div>

                                                    <!-- Modal body -->
                                                    <form method="post">
                                                        <div class="modal-body">
                                                            Jenis Barang
                                                            <br>
                                                            <select name="barangnya" class="form-control">
                                                                <option value="<?= $idbrg; ?>"><?= $namabarang; ?></option>
                                                                <?php
                                                                $ambilsemuadatanya = mysqli_query($conn, "select * from jenis_barang");
                                                                while ($fetcharray = mysqli_fetch_array($ambilsemuadatanya)) {
                                                                    $namabarangnya = $fetcharray['namaJenisBarang'];
                                                                    $idbarangnya = $fetcharray['idbarang'];
                                                                ?>
                                                                    <option value="<?= $idbarangnya; ?>"><?= $namabarangnya; ?></option>
                                                                <?php
                                                                }
                                                                ?>
                                                            </select>
                                                            Keterangan
                                                            <br>
                                                            <input type="text" name="desc" size="20" value="<?= $deskripsi; ?>" maxlength="30" required /></td>
                                                            <br>
                                                            Stock
                                                            <br>
                                                            <input type="number" name="stock" size="20" value="<?= $stock; ?>" maxlength="30" required />
                                                            <input type="hidden" name="idb" value="<?= $idb; ?>">
                                                            <br>
                                                            <br>
                                                            <button type="submit" class="btn btn-primary" name="updatebarang">Submit</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Delete Modal -->
                                        <div class="modal fade" id="delete<?= $idb; ?>">
                                            <div class="modal-dialog">
                                                <div class="modal-content">

                                                    <!-- Modal Header -->
                                                    <div class="modal-header">
                                                        <h4 class="modal-title">Hapus barang?</h4>
                                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                    </div>

                                                    <!-- Modal body -->
                                                    <form method="post">
                                                        <div class="modal-body">
                                                            Apakah Anda yakin ingin menghapus <?= $namabarang; ?>?
                                                            <input type="hidden" name="idb" value="<?= $idb; ?>">
                                                            <br>
                                                            <br>
                                                            <button type="submit" class="btn btn-danger" name="hapusbarang">Hapus</button>
                                                        </div>
                                                    </form>

                                                </div>
                                            </div>
                                        </div>
                                        <!-- Pengambilan Barang Modal -->
                                        <div class="modal fade" id="ambil<?= $idb; ?>">
                                            <div class="modal-dialog">
                                                <div class="modal-content">

                                                    <!-- Modal Header -->
                                                    <div class="modal-header">
                                                        <h4 class="modal-title">Pengambilan Barang</h4>
                                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                    </div>

                                                    <!-- Modal body -->
                                                    <form method="post">
                                                        <div class="modal-body text-center">
                                                            Jenis Barang
                                                            <br>
                                                            <input type="text" name="desc" size="20" value="<?= $namabarang; ?>" maxlength="30" required disabled /></td>
                                                            <br>
                                                            <br>
                                                            Keterangan
                                                            <br>
                                                            <input type="text" name="desc" size="20" value="<?= $deskripsi; ?>" maxlength="30" required disabled /></td>
                                                            <br>
                                                            <br>
                                                            Stock
                                                            <br>
                                                            <input type="number" name="sisa" size="20" value="<?= $stock; ?>" maxlength="30" required disabled />
                                                            <br>
                                                            <br>
                                                            Nama Penerima
                                                            <br>
                                                            <input type="text" name="penerima" size="20" value="" maxlength="30" required />
                                                            <br>
                                                            Jumlah Yang Ingin Diambil
                                                            <br>
                                                            <input type="number" name="keluar" size="20" value="" maxlength="30" required />
                                                            <input type="hidden" name="idmasuk" value="<?= $idb; ?>"><input type="hidden" name="idbarang" value="<?= $idbrg; ?>">
                                                            <br>
                                                            <br>
                                                            <button type="submit" class="btn btn-primary" name="barangkeluar">Submit</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                            </div>
                        <?php
                                    };
                        ?>
                        </tbody>
                        </table>
                        </div>
                    </div>
                </div>
        </div>
        </main>
    </div>
    </div>
    <a href="cetak.php" target="_blank">CETAK</a>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="js/scripts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
    <script src="assets/demo/chart-area-demo.js"></script>
    <script src="assets/demo/chart-bar-demo.js"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
    <script src="assets/demo/datatables-demo.js"></script>
</body>

<!-- The Modal -->
<div class="modal fade" id="myModal">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Tambah Barang</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <form method="post">
                <div class="modal-body">
                    <table align="center" width="400px" padding="100px">
                        <tr height="25">
                            <td></td>
                            <td>Nama Barang</td>
                            <td><select name="barangnya" class="form-control">
                                    <?php
                                    $ambilsemuadatanya = mysqli_query($conn, "select * from jenis_barang");
                                    while ($fetcharray = mysqli_fetch_array($ambilsemuadatanya)) {
                                        $namabarangnya = $fetcharray['namaJenisBarang'];
                                        $idbarangnya = $fetcharray['idbarang'];
                                    ?>
                                        <option value="<?= $idbarangnya; ?>"><?= $namabarangnya; ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </td>
                        </tr>
                        <br>
                        <tr height="25">
                            <td></td>
                            <td>Stock</td>
                            <td><input type="number" name="stock" size="20" maxlength="30" required /></td>
                        </tr>
                        <br>
                        <br>
                        <tr height="25">
                            <td></td>
                            <td>Keterangan</td>
                            <td><input type="text" name="desc" size="20" maxlength="30" required /></td>
                        </tr>
                        <br>
                        <br>
                        <tr height="45">
                            <td></td>
                            <td></td>
                            <td><input type="submit" name="barangmasuk" /></td>
                        </tr>
                </div>
            </form>
        </div>
    </div>
</div>

</html>