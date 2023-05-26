<!DOCTYPE html>
<html>
<head>
	<title>CETAK PRINT DATA</title>
</head>
<body>
 
	<center>
 
		<h2>DATA JENIS BARANG</h2>
 
	</center>
 
	<?php 
	include 'function.php';
	?>
 
    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0" border="1" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Nama Jenis Barang</th>
                                            </tr>
                                        </thead>
                                        <?php
                                         $ambilsemuadatastock = mysqli_query($conn, "select * from jenis_barang ");
                                        $i = 1;
                                        while ($data = mysqli_fetch_array($ambilsemuadatastock)) {
                                        $idd = $data['idbarang'];
                                        $namadata = $data['namaJenisBarang'];
                                        ?>

                                        <tr>
                                            <td><?= $i++; ?></td>
                                            <td><?= $namadata; ?></td>
                                        </tr>

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