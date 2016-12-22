<?php
	require_once("connect.php");
	$namahalaman = "pembelian";
	
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
		<h3>Pemesanan Bahan</h3>
		<a href="pemesanan_bahan_tambah.php" class="btn btn-primary" >Tambah</a>
		<br/>
		<br/>
		<div style="width : 1000px:">
			<table class="table table-bordered table-striped table-hover table-sort">
				<thead>	<!-- kop table -->
					<tr>
						<th style="width: 100px;">Id Pemesanan</th>
						<th style="width: 250px;">Tanggal</th>
						<th style="width: 150px;">Supplier</th>
						<th style="width: 100px;">Total</th>
						<th style="width: 300px;">Detail</th>
						<th style="width: 100px;">Status</th>
						<th style="width: 250px;">Aksi</th>
					</tr>
				</thead>
				</tbody> <!-- isi table -->
				<?php
					$query = "select * from pemesanan_bahan inner join supplier on pemesanan_bahan.id_supplier=supplier.id_supplier"; //ambil smua data table satuan
					$result = mysql_query($query); //eksekusi query
					while($row = mysql_fetch_array($result)) //loop setiap baris data
					{
						$detail = "<ul>";
						$query = "select * from detail_pemesanan_bahan inner join bahan_baku on detail_pemesanan_bahan.id_bahan_baku=bahan_baku.id_bahan_baku where id_pemesanan_bahan='$row[id_pemesanan_bahan]' ";
						$resultDetail = mysql_query($query);
						while($rowDetail = mysql_fetch_array($resultDetail))
						{
							$detail .= "<li>$rowDetail[nama_bahan_baku] $rowDetail[jumlah] $rowDetail[satuan_beli]</li>";
						}
						$detail .="</ul>";
				?>
					<tr>
						<td><?php echo $row["id_pemesanan_bahan"]; ?></td>
						<td><?php echo balikTanggal($row["tanggal_pemesanan_bahan"]); ?></td>
						<td><?php echo $row["nama_supplier"]; ?></td>
						<td style="text-align:right;"><?php echo number_format($row['total'],2,",","."); ?></td>
						<td><?php echo $detail; ?></td>
						<td><?php echo $row["status_pemesanan_bahan"]; ?></td>
						<td>
							<a href="pemesanan_bahan_detail.php?id_pemesanan_bahan=<?php echo $row["id_pemesanan_bahan"]; ?>" class="btn btn-info">Detail</a> 
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