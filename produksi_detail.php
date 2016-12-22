<?php
	require_once("connect.php");
	
	//jika belum login -> kembalikan ke halaman login
	if(!isset($_SESSION["hans_id_pengguna"]))
	{
		?><script>alert('Silahkan login dahulu');</script><?php
		?><script>document.location.href='index.php';</script><?php
		die(0);
	}
	
	$id_produksi = createId("produksi","id_produksi","PR",5);
	$id_detail_produksi = $id_produksi;
	$tanggal_produksi = date("Y-m-d");
	$id_roti ="";
	$nama_roti = "";
	$jumlah ="0";
	$total_overhead = 0;
	$total_bahan_baku = 0;
	$total_hpp = 0;
	$status_produksi ="Finish";
	$data_id_roti = array();
	$data_nama_roti = array();
	$data_jumlah = array();
	$id_pengguna = $_SESSION["hans_id_pengguna"];
	
	if(isset($_GET["id_produksi"]))
	{
		$id_produksi = $_GET["id_produksi"];
		$query = "select * from produksi
								inner join detail_produksi on produksi.id_produksi=detail_produksi.id_produksi
								inner join roti on detail_produksi.id_roti=roti.id_roti where produksi.id_produksi='$id_produksi'";
		$result = mysql_query($query);
		if($row = mysql_fetch_array($result))
		{
			
			$id_produksi = $row["id_produksi"];
			$id_detail_produksi = $row["id_detail_produksi"];
			$tanggal_produksi = $row["tanggal_produksi"];
			$id_roti = $row["id_roti"];
			$nama_roti = $row["nama_roti"];
			$jumlah = $row["jumlah"];
			$total_overhead = $row["total_overhead"];
			$total_bahan_baku = $row["total_bahan_baku"];
			$total_hpp = $row["total_hpp"];
			$status_produksi = $row["status_produksi"];
	
		}
		else{
			
			?><script>alert("Data tidak ditemukan");</script>
			<script>document.location.href='produksi.php'</script><?php
			die(0);
		}
	}
	else
	{
		?><script>alert("Data tidak ditemukan");</script>
		<script>document.location.href='produksi.php'</script><?php
		die(0);
	}
?>
<!doctype html>
<html lang="en">
<head>
	<?php include("head.php"); ?>
	<script>
		$(function(){
			
		});
	</script>
</head>
<body>
	
	<?php include("header.php"); ?>
	
	<!-- bagian isi -->
	<div class="content container-fluid">
		<h3>Produksi Roti</h3>
		<br/>
		<form action="" method="post">
		<div  >
			<table class="table table-bordered table-striped table-hover ">
				<thead>	<!-- kop table -->
				</thead>
				</tbody> <!-- isi table -->
					<tr>
						<td style="width:150px;">Id Produksi</td>
						<td><input required readonly style="width:150px"; class="form-control" name="id_produksi" id="id_produksi" placeholder="Id Roti" value="<?php echo $id_produksi; ?>" /></td>
					</tr>
					<tr>
						<td>Tanggal Produksi</td>
						<td><input readonly style="width:150px;" required class=" form-control" name="tanggal_produksi" id="tanggal_produksi" placeholder="Nama Roti" value="<?php echo balikTanggal($tanggal_produksi); ?>" /></td>
					</tr>
					<tr>
						<td>Roti</td>
						<td><input type="text" readonly style="width:300px";   class="form-control" name="id_roti" id="id_roti" value="<?php echo $nama_roti; ?>"></td>
					</tr>
					<tr>
						<td>Jumlah produksi</td>
						<td><input   type="text" readonly min="0" style="width:250px; display: inline;"   class="form-control" name="jumlah" id="jumlah" placeholder="Jumlah produksi " value="<?php echo $jumlah; ?>" />
						</td>
					</tr>
					<tr>
						<td colspan="2"></td>
					</tr>
					<tr>
						<td colspan="2"><h4>Detail Bahan Baku</h4></td>
					</tr>
					
					<tr>
						<td colspan="2">
							<table class="table table-bordered table-hover table-striped">
								<thead>
									<tr>
										<th>Id Bahan Baku</th>
										<th>Nama Bahan Baku</th>
										<th>Jumlah Pemakaian</th>
										<th>Satuan</th>
										<th>Harga Average</th>
										<th>Sub total</th>
									</tr>
								</thead>
								<tbody id="detail_bahan">
								<?php
									$query = "select * from detail_produksi_bahan_baku inner join bahan_baku on detail_produksi_bahan_baku.id_bahan_baku=bahan_baku.id_bahan_baku
												where id_detail_produksi='$id_detail_produksi'";
									$resultDetail = mysql_query($query);
									$i = 0;
									
									while($rowDetail = mysql_fetch_array($resultDetail))
									{
								?>
								<tr>
									<td><input class="form-control" type="text" readonly data-input-name="id_bahan_baku" name="id_bahan_baku[]" id="id_bahan_baku_<?php echo $i; ?>" value="<?php echo $rowDetail["id_bahan_baku"]; ?>" /></td>
									<td><input class="form-control" type="text" readonly data-input-name="nama_bahan_baku" name="nama_bahan_baku[]" id="nama_bahan_baku_<?php echo $i; ?>" value="<?php echo $rowDetail["nama_bahan_baku"]; ?>" /></td>
									<td><input class="form-control" text="text" readonly required style="width:150px;" type="number" data-input-name="jumlah" name="jumlah[]" id="jumlah_<?php echo $i; ?>" value="<?php echo $rowDetail["jumlah_bahan_baku"]; ?>" /></td>
									<td><input class="form-control" readonly required style="width:150px;" type="text" data-input-name="id_satuan" name="id_satuan[]" id="id_satuan_<?php echo $i; ?>" value="<?php echo $rowDetail["satuan_stok"]; ?>" /></td>
									<td><input class="form-control" readonly style="width:150px;" type="text" data-input-name="harga" name="harga[]" id="harga_<?php echo $i; ?>" value="<?php echo $rowDetail["harga_bahan_baku"]; ?>" /></td>
									<td><input class="form-control" readonly min="0" required style="width:150px;" type="number" data-input-name="subtotal" name="subtotal[]" id="subtotal_<?php echo $i; ?>" value="<?php echo $rowDetail["sub_total_bahan_baku"]; ?>" /></td>
								</tr>
								<?php
										$i++;
									}
								?>	
								</tbody>
							</table>
						</td>
					</tr>
					<tr>
						<td>Total Bahan Baku</td>
						<td><input   type="text" readonly required style="width:250px; display: inline;"   class="form-control" id="total_bahan_baku" name="total_bahan_baku" placeholder="Total Bahan Baku " value="<?php echo $total_bahan_baku; ?>" />
						</td>
					</tr>
					
					<tr>
						<td colspan="2"></td>
					</tr>
					<tr>
						<td colspan="2"><h4>Detail Overhead</h4></td>
					</tr>
					
					<tr>
						<td colspan="2">
							<table class="table table-bordered table-hover table-striped">
								<thead>
									<tr>
										<th>Id Overhead</th>
										<th>Nama Overhead</th>
										<th>Jumlah</th>
										<th>Satuan</th>
										<th>Harga</th>
										<th>Subtotal</th>
									</tr>
								</thead>
								<tbody id="detail_overhead">
								<?php
									$query = "select * from detail_produksi_overhead inner join overhead on detail_produksi_overhead.id_overhead=overhead.id_overhead
												where id_detail_produksi='$id_detail_produksi'";
									$resultDetail = mysql_query($query);
									$i = 0;
									
									while($rowDetail = mysql_fetch_array($resultDetail))
									{
								?>
								<tr>
									<td><input class="form-control" type="text" readonly data-input-name="id_overhead" name="id_overhead[]" id="id_overhead_<?php echo $i; ?>" value="<?php echo $rowDetail["id_overhead"]; ?>" /></td>
									<td><input class="form-control" type="text" readonly data-input-name="nama_overhead" name="nama_overhead[]" id="nama_overhead_<?php echo $i; ?>" value="<?php echo $rowDetail["nama_overhead"]; ?>" /></td>
									<td><input class="form-control" text="text" readonly required style="width:150px;" type="number" data-input-name="jumlah" name="jumlah[]" id="jumlah_<?php echo $i; ?>" value="<?php echo $rowDetail["jumlah_overhead"]; ?>" /></td>
									<td><input class="form-control" readonly required style="width:150px;" type="text" data-input-name="id_satuan" name="id_satuan[]" id="id_satuan_<?php echo $i; ?>" value="<?php echo $rowDetail["satuan_overhead"]; ?>" /></td>
									<td><input class="form-control" readonly style="width:150px;" type="text" data-input-name="harga" name="harga[]" id="harga_<?php echo $i; ?>" value="<?php echo $rowDetail["harga_overhead"]; ?>" /></td>
									<td><input class="form-control" readonly min="0" required style="width:150px;" type="number" data-input-name="subtotal" name="subtotal[]" id="subtotal_<?php echo $i; ?>" value="<?php echo $rowDetail["sub_total_overhead"]; ?>" /></td>
								</tr>
								<?php
										$i++;
									}
								?>	
								</tbody>
							</table>
						</td>
					</tr>
					<tr>
						<td>Total Overhead</td>
						<td><input   type="text" readonly required style="width:250px; display: inline;"   class="form-control" id="total_overhead" name="total_overhead" placeholder="Total Overhead " value="<?php echo $total_overhead; ?>" />
						</td>
					</tr>
					<tr>
						<td>Total HPP</td>
						<td><input   type="text" readonly required style="width:250px; display: inline;"   class="form-control" id="total_hpp" name="total_hpp" placeholder="Total HPP " value="<?php echo $total_hpp; ?>" />
						</td>
					</tr>
					<tr>
						<td> </td>
						<td>
							
 							<a href="produksi.php" class="btn btn-danger">Batal</a>
						</td>
					</tr>
				</tbody>
				<tfoot>	<!-- bagian bawah table -->
				</tfoot>
			</table>
		</div>
		</form>
	</div>
	<!-- akhir bagian isi -->
	

	<?php include("footer.php"); ?>

</body>
</html>