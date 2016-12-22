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
		<h3>Retur Pembelian</h3>
		<a href="retur_pembelian_tambah.php" class="btn btn-primary" >Tambah</a>
		<br/>
		<br/>
		<div style="width : 1000px:">
			<table class="table table-bordered table-striped table-hover table-sort">
				<thead>	<!-- kop table -->
					<tr>
						<th style="width: 100px;">Id Retur Pembelian</th>
						<th style="width: 250px;">Tanggal Retur Pembelian</th>
						<th style="width: 150px;">Id Pembelian</th>
						<th style="width: 150px;">Supplier</th>
						<th style="width: 100px;">Status Retur</th>
						<th style="width: 100px;">Penggantian</th>
						
					</tr>
				</thead>
				</tbody> <!-- isi table -->
				<?php
					$query = "select * from retur_pembelian
							inner join pembelian on retur_pembelian.id_pembelian=pembelian.id_pembelian
							inner join supplier on pembelian.id_supplier=supplier.id_supplier";
					$result = mysql_query($query); //eksekusi query
					while($row = mysql_fetch_array($result)) //loop setiap baris data
					{
				?>
					<tr>
						<td><?php echo $row["id_retur_pembelian"]; ?></td>
						<td><?php echo balikTanggal($row["tanggal_retur_pembelian"]); ?></td>
						<td><?php echo $row["id_pembelian"]; ?></td>
						<td><?php echo $row["nama_supplier"]; ?></td>
						<td><?php echo $row["status_retur"]; ?></td>
						<td>
						<?php
							if($row["status_retur"] == "Belum diganti")
							{
						?>
							<a href="retur_pembelian_pengembalian.php?id_retur_pembelian=<?php echo $row["id_retur_pembelian"]; ?>" class="btn btn-info" onclick="return confirm('Retur sudah diganti ?')">Penggantian</a> 
						<?php
							}
						?>
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