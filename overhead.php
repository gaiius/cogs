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
		<h3>Overhead</h3>
		<a href="overhead_tambah.php" class="btn btn-primary" >Tambah</a>
		<br/>
		<br/>
		<div style="width : 1000px:">
			<table class="table table-bordered table-striped table-hover table-sort">
				<thead>	<!-- kop table -->
					<tr>
						<th style="width: 100px;">Id Overhead</th>
						<th style="width: 250px;">Nama Overhead</th>
						<th style="width: 200px;">Biaya Overhead / Satuan</th>
						<th style="width: 200px;">Satuan Biaya</th>
						<th style="width: 200px;">Aksi</th>
						
					</tr>
				</thead>
				</tbody> <!-- isi table -->
				<?php
					$query = "select * from Overhead"; //ambil smua data table satuan
					$result = mysql_query($query); //eksekusi query
					while($row = mysql_fetch_array($result)) //loop setiap baris data
					{
				?>
					<tr>
						<td><?php echo $row["id_overhead"]; ?></td>
						<td><?php echo $row["nama_overhead"]; ?></td>
						<td><?php echo number_format($row["biaya_overhead"],2,",","."); ?></td>
						<td><?php echo $row["satuan_overhead"]; ?></td>
						
						<td>
							<a href="overhead_ubah.php?id_overhead=<?php echo $row["id_overhead"]; ?>" class="btn btn-info">Ubah</a> 
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