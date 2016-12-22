<?php
	require_once("connect.php");
	$namahalaman = "produksi";
	
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
		<h3>Produksi Roti</h3>
		<a href="produksi_tambah.php" class="btn btn-primary" >Tambah</a>
		<br/>
		<br/>
		<div style="width : 1000px:">
			<table class="table table-bordered table-striped table-hover table-sort">
				<thead>	<!-- kop table -->
					<tr>
						<th style="width: 100px;">Id Produksi</th>
						<th style="width: 250px;">Tanggal</th>
						<th style="width: 100px;">Roti</th>
						<th style="width: 250px;">Jumlah Produksi</th>
						<th style="width: 150px;">Bahan Baku</th>
						<th style="width: 150px;">Overhead</th>
						<th style="width: 150px;">Total HPP</th>
						<th style="width: 150px;">HPP / Roti</th>
						<th style="width: 250px;">Aksi</th>
					</tr>
				</thead>
				</tbody> <!-- isi table -->
				<?php
					$query = "select * from produksi
								inner join detail_produksi on produksi.id_produksi=detail_produksi.id_produksi
								inner join roti on detail_produksi.id_roti=roti.id_roti"; //ambil smua data table satuan
					$result = mysql_query($query); //eksekusi query
					while($row = mysql_fetch_array($result)) //loop setiap baris data
					{
				?>
					<tr>
						<td><?php echo $row["id_produksi"]; ?></td>
						<td><?php echo balikTanggal($row["tanggal_produksi"]); ?></td>
						<td><?php echo $row["nama_roti"]; ?></td>
						<td style="text-align:right;"><?php echo number_format($row["jumlah"],0,",","."); ?></td>
						<td style="text-align:right;"><?php echo number_format($row["total_bahan_baku"],2,",","."); ?></td>
						<td style="text-align:right;"><?php echo number_format($row["total_overhead"],2,",","."); ?></td>
						<td style="text-align:right;"><?php echo number_format($row["total_hpp"],2,",","."); ?></td>
						<td style="text-align:right;"><?php echo number_format($row["total_hpp"]/$row["jumlah"],2,",","."); ?></td>
						<td>
							<a href="produksi_detail.php?id_produksi=<?php echo $row["id_produksi"]; ?>" class="btn btn-info">Detail</a>
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