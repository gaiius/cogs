<?php
	require_once("connect.php");
	$namahalaman = "master";
	
	//jika belum login -> kembalikan ke halaman login
	if(!isset($_SESSION["hans_id_pengguna"]))
	{
		?><script>alert('Silahkan login dahulu');</script><?php
		?><script>document.location.href='index.php';</script><?php
		die(0);
	}
?>
<!doctype html>
<html lang="en">
<head>
	<?php include("head.php"); ?>
</head>
<body>
	
	<?php include("header.php"); ?>
	
	<!-- bagian isi -->
	<div class="content container-fluid">
		<h3>Bahan Baku</h3>
		<a href="bahan_baku_tambah.php" class="btn btn-primary" >Tambah</a>
		<br/>
		<br/>
		<div >
			<table class="table table-bordered table-striped table-hover table-sort">
				<thead>	<!-- kop table -->
					<tr>
						<th style="width: 100px;">Id Bahan Baku</th>
						<th style="width: 250px;">Nama Bahan Baku</th>
						<th style="width: 100px;">Stok</th>
						<th style="width: 100px;">Satuan Stok</th>
						<th style="width: 100px;">Satuan Beli</th>
						<th style="width: 100px;">Konversi</th>
						<th style="width: 120px;">Harga Beli</th>
						<th style="width: 120px;">Harga Average</th>
						<th style="width: 200px;">Aksi</th>
					</tr>
				</thead>
				</tbody> <!-- isi table -->
				<?php
					$query = "select * from bahan_baku"; //ambil smua data table satuan
					$result = mysql_query($query); //eksekusi query
					while($row = mysql_fetch_array($result)) //loop setiap baris data
					{
				?>
					<tr>
						<td><?php echo $row["id_bahan_baku"]; ?></td>
						<td><?php echo $row["nama_bahan_baku"]; ?></td>
						<td><?php echo $row["stok"]; ?></td>
						<td><?php echo $row["satuan_stok"]; ?></td>
						<td><?php echo $row["satuan_beli"]; ?></td>
						<td><?php echo $row["konversi"]; ?></td>
						<td style="text-align:right;"><?php echo number_format($row["harga_beli"],2,",","."); ?></td>
						<td style="text-align:right;"><?php echo number_format($row["harga_average"],2,",","."); ?></td>
						<td>
							<a href="bahan_baku_ubah.php?id_bahan_baku=<?php echo $row["id_bahan_baku"]; ?>" class="btn btn-info">Ubah</a> 
							<a href="bahan_baku_hapus.php?id_bahan_baku=<?php echo $row["id_bahan_baku"]; ?>" class="btn btn-danger 	">Hapus</a> 
						</td>
					</tr>
				<?php
					}
					
				?>
				</tbody>
				<tfoot>	<!-- bagian bawah table -->
				</tfoot>
			</table>
		</div>
	</div>
	<!-- akhir bagian isi -->
	

	<?php include("footer.php"); ?>

</body>
</html>