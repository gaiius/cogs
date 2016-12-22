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
		<h3>Satuan</h3>
		<a href="satuan_tambah.php" class="btn btn-primary" >Tambah</a>
		<br/>
		<br/>
		<div  style="width: 800px;">
			<table class="table table-bordered table-striped table-hover table-sort">
				<thead>	<!-- kop table -->
					<tr>
						<th style="width: 200px;">Id Satuan</th>
						<th style="width: 400px;">Nama Satuan</th>
						<th style="width: 200px;">Aksi</th>
					</tr>
				</thead>
				</tbody> <!-- isi table -->
				<?php
					$query = "select * from satuan"; //ambil smua data table satuan
					$result = mysql_query($query); //eksekusi query
					while($row = mysql_fetch_array($result)) //loop setiap baris data
					{
				?>
					<tr>
						<td><?php echo $row["id_satuan"]; ?></td>
						<td><?php echo $row["nama_satuan"]; ?></td>
						<td>
							<a href="satuan_ubah.php?id_satuan=<?php echo $row["id_satuan"]; ?>" style="width:100px "  class="btn btn-info center-block">Ubah</a> 
					
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