<?php
	require_once("connect.php");
	$namahalaman = "laporan";
	
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
		<h3>Laporan Stok Bahan Baku</h3>
		<button class="btn btn-primary no-print" onclick="window.print()">Cetak</button>
		<br/>
		<br/>
		<div >
			<table class="table table-bordered table-striped table-hover">
				<thead>	<!-- kop table -->
					<tr>
						<th style="width: 100px;">Id Bahan Baku</th>
						<th style="width: 250px;">Nama Bahan Baku</th>
						<th style="width: 100px;">Stok</th>
						<th style="width: 100px;">Satuan</th>
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