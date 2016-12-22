<?php
	require_once("connect.php");
	
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
		<h3>Roti</h3>
		<a href="roti_tambah.php" class="btn btn-primary" >Tambah</a>
		<br/>
		<br/>
		<div style="width : 1000px:">
			<table class="table table-bordered table-striped table-hover table-sort">
				<thead>	<!-- kop table -->
					<tr>
						<th style="width: 100px;">Id Roti</th>
						<th style="width: 250px;">Nama Roti</th>
						<th style="width: 100px;">Harga Jual</th>
						<th style="width: 100px;">Stok</th>
						<th style="width: 200px;">Total</th>
						<th style="width: 250px;">Aksi</th>
					</tr>
				</thead>
				</tbody> <!-- isi table -->
				<?php
					$query = "select * from roti"; //ambil smua data table satuan
					$result = mysql_query($query); //eksekusi query
					while($row = mysql_fetch_array($result)) //loop setiap baris data
					{
				?>
					<tr>
						<td><?php echo $row["id_roti"]; ?></td>
						<td><?php echo $row["nama_roti"]; ?></td>
						<td><?php echo $row["harga_jual"]; ?></td>
						<td><?php echo $row["stok"]; ?></td>
						<td style="text-align:right;"><?php echo number_format($row['harga_jual'] * $row['stok'],2,",","."); ?></td>
						<td>
							<a href="resep_roti.php?id_roti=<?php echo $row["id_roti"]; ?>" class="btn btn-success">Resep Roti</a> 
							<a href="roti_ubah.php?id_roti=<?php echo $row["id_roti"]; ?>" class="btn btn-info">Ubah</a> 
							<a href="roti_hapus.php?id_roti=<?php echo $row["id_roti"]; ?>" class="btn btn-danger" onclick="return confirm('Data dihapus ?')">Hapus</a>
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