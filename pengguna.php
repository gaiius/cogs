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
		<h3>Pengguna</h3>
		<a href="pengguna_tambah.php" class="btn btn-primary" >Tambah</a>
		<br/>
		<br/>
		<div style="width : 1000px:">
			<table class="table table-bordered table-striped table-hover table-sort">
				<thead>	<!-- kop table -->
					<tr>
						<th style="width: 100px;">Id Pengguna</th>
						<th style="width: 250px;">Nama Pengguna</th>
						<th style="width: 200px;">Jenis Pengguna	</th>
					
						
					</tr>
				</thead>
				</tbody> <!-- isi table -->
				<?php
					$query = "select * from pengguna"; //ambil smua data table satuan
					$result = mysql_query($query); //eksekusi query
					while($row = mysql_fetch_array($result)) //loop setiap baris data
					{
				?>
					<tr>
						<td><?php echo $row["id_pengguna"]; ?></td>
						<td><?php echo $row["nama_pengguna"]; ?></td>
						<td><?php echo $row["jenis_pengguna"]; ?></td>
						
						<td>
							<a href="pengguna_ubah.php?id_pengguna=<?php echo $row["id_pengguna"]; ?>" class="btn btn-info">Ubah</a> 
							<a href="pengguna_hapus.php?id_pengguna=<?php echo $row["id_pengguna"]; ?>" class="btn btn-danger" onclick="return confirm('Data dihapus ?')">Hapus</a>
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