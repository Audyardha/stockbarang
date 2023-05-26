<!DOCTYPE html>
<html>
<head>
	<title>CETAK PRINT DATA</title>
</head>
<body>
 
	<center>
 
		<h2>DATA STOCK BARANG</h2>
 
	</center>
 
	<?php 
	include 'function.php';
	?>
 
    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0" border="1" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Nama Barang</th>
                                                <th>Deskripsi</th>
                                                <th>Stock</th>
                                                <th>Tanggal Masuk</th>
                                                <th>Tanggal Ubah Data</th>
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
                                            <?php
                                            };

                                            ?>
                                        </tbody>
                                    </table>
 
	<script>
		window.print();
	</script>
 
</body>
</html>