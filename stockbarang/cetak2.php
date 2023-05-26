<!DOCTYPE html>
<html>
<head>
	<title>CETAK PRINT DATA</title>
</head>
<body>
 
	<center>
 
		<h2>BARANG KELUAR</h2>
 
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
                                                <th>Barang Keluar</th>
                                                <th>Penerima Barang</th>
                                                <th>Tanggal Pengambilan</th>
                                            </tr>
                                        </thead>
                                        <?php
                                    $ambilsemuadatastock = mysqli_query($conn, "SELECT t1.idmasuk, t3.idkeluar,DATE_FORMAT(t3.tanggalKeluar	, '%d %M %Y') AS formatted_enter, t1.keterangan,t1.qty,t3.keluar, t2.namaJenisBarang,t3.penerima, t1.idmasuk,t1.idbarang
                                    FROM masuk t1
                                    RIGHT JOIN barang_keluar t3 ON t1.idmasuk = t3.idmasuk
                                    LEFT JOIN jenis_barang t2 ON t1.idbarang = t2.idbarang");
                                    $i = 1;
                                    while ($data = mysqli_fetch_array($ambilsemuadatastock)) {
                                        $namabarang = $data['namaJenisBarang'];
                                        $deskripsi = $data['keterangan'];
                                        $stock = $data['qty'];
                                        $ndate = $data['formatted_enter'];
                                        $out = $data['keluar'];
                                        $ambil = $data['penerima'];
                                        $idb = $data['idmasuk'];
                                        $idbrg = $data['idbarang'];
                                        $idkel = $data['idkeluar'];
                                    ?>

                                        <tr>
                                            <td><?= $i++; ?></td>
                                            <td><?= $namabarang; ?></td>
                                            <td><?= $deskripsi; ?></td>
                                            <td><?= $stock; ?></td>
                                            <td><?= $out; ?></td>
                                            <td><?= $ambil; ?></td>
                                            <td><?= $ndate; ?></td>
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