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
		<h3>Pembayaran Hutang</h3>
		<br/>
		<div style="width : 1000px:">
			<h4>Pembelian Belum Lunas</h4>
			<table class="table table-bordered table-striped table-hover table-sort">
				<thead>	<!-- kop table -->
					<tr>
						<th style="width: 100px;">Id Pembelian</th>
						<th style="width: 100px;">Id Pemesanan</th>
						<th style="width: 250px;">Tanggal</th>
						<th style="width: 150px;">Supplier</th>
						<th style="width: 100px;">Total</th>
						<th style="width: 100px;">Jenis Pembayaran</th>
						<th style="width: 100px;">Sudah Dibayar</th>
						<th style="width: 100px;">Sisa</th>
						<th style="width: 100px;">Tanggal Jatuh Tempo</th>
						<th style="width: 250px;">Aksi</th>
					</tr>
				</thead>
				</tbody> <!-- isi table -->
				<?php
					$query = "select * from pembelian inner join supplier on pembelian.id_supplier=supplier.id_supplier where jenis_pembayaran='Kredit' and total > dibayar"; //ambil smua data table satuan
					$result = mysql_query($query); //eksekusi query
					while($row = mysql_fetch_array($result)) //loop setiap baris data
					{
				?>
					<tr>
						<td><?php echo $row["id_pembelian"]; ?></td>
						<td><?php echo $row["id_pemesanan_bahan"]; ?></td>
						<td><?php echo balikTanggal($row["tanggal_pembelian"]); ?></td>
						<td><?php echo $row["nama_supplier"]; ?></td>
						<td style="text-align:right;"><?php echo number_format($row['total'],2,",","."); ?></td>
						<td><?php echo $row["jenis_pembayaran"]; ?></td>
						<td  style="text-align:right;"><?php echo number_format($row["dibayar"],2,",","."); ?></td>
						<td  style="text-align:right;"><?php echo number_format($row['total']-$row["dibayar"],2,",","."); ?></td>
						<td><?php echo (($row["jenis_pembayaran"] == "Kredit")?balikTanggal($row["tanggal_jatuh_tempo"]):"-"); ?></td>
						<td>
							<a href="pembayaran_hutang_tambah.php?id_pembelian=<?php echo $row["id_pembelian"]; ?>" class="btn btn-info">Pembayaran</a> 
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