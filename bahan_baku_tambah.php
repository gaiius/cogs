<?php
	require_once("connect.php");
	$namahalaman = "master";
	
	//jika belum login -> kembalikan ke halaman login
	if(!isset($_SESSION["hans_id_pengguna"]))
	{
		?><script>alert('Silahkan login dahulu');</script><?php
		?><script>document.location.href='index.php';</script><?php
		die(0);
	}
	
	$id_bahan_baku = createId("bahan_baku","id_bahan_baku","B",3);
	$nama_bahan_baku = "";
	$stok = "0";
	$satuan_stok = "";
	$satuan_beli = "";
	$konversi = "";
	$harga_beli = "0";
	$harga_average = "0";
	
	if(isset($_POST["simpan"]))
	{
		$id_bahan_baku = $_POST["id_bahan_baku"];
		$nama_bahan_baku = $_POST["nama_bahan_baku"];
		$stok = $_POST["stok"];
		$satuan_stok = $_POST["satuan_stok"];
		$satuan_beli = $_POST["satuan_beli"];
		$konversi = $_POST["konversi"];
		$harga_beli = $_POST["harga_beli"];
		$harga_average = $_POST["harga_average"];
		
		$error = 0;
		//pengecekan error
		$query = "select * from bahan_baku where id_bahan_baku='$id_bahan_baku'";
		$resultCek = mysql_query($query);
		if(mysql_num_rows($resultCek) > 0) //menghitung jumlah baris hasil query
		{
			?><script>alert("Id Bahan Baku sudah ada sebelumnya");</script><?php
			$error = 1;
		}
		
		
		$query = "select * from bahan_baku where nama_bahan_baku='$nama_bahan_baku' and id_bahan_baku <> '$id_bahan_baku'";
		$resultCek = mysql_query($query);
		if(mysql_num_rows($resultCek) > 0)
		{
			?><script>alert("Nama Bahan Baku sudah ada sebelumnya");</script><?php
			$error = 1;
		}
		
		$konversi = "";
		$query = "select * from konversi_satuan where satuan_beli='$satuan_beli' and satuan_stok='$satuan_stok'";
		$resultCek = mysql_query($query);
		if($rowCek = mysql_fetch_array($resultCek))
		{
			
			$konversi = $rowCek["konversi"];
		}
		if($konversi == "")
		{
			
			?><script>alert("Belum ada setting konversi dari $satuan_beli ke $satuan_stok");</script><?php
			$error = 1;
			
		}
		
		if($error == 0)
		{
			$query = "insert into bahan_baku 
						(id_bahan_baku,nama_bahan_baku,stok,
						satuan_stok,satuan_beli,konversi,harga_beli,harga_average) values
						('$id_bahan_baku','$nama_bahan_baku','$stok',
						'$satuan_stok','$satuan_beli','$konversi','$harga_beli','$harga_average')";
			mysql_query($query);
			
			?><script>alert("Data berhasil ditambah");</script>
			<script>document.location.href='bahan_baku.php'</script><?php
			die(0);
		}
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
		<h3>Bahan Baku</h3>
		<br/>
		<form action="" method="post">
		<div  style="width: 700px;">
			<table class="table table-bordered table-striped table-hover ">
				<thead>	<!-- kop table -->
				</thead>
				</tbody> <!-- isi table -->
					<tr>
						<td style="width:200px;">Id Bahan Baku</td>
						<td><input required readonly style="width:150px"; class="form-control" name="id_bahan_baku" id="id_bahan_baku" placeholder="Id Bahan Baku" value="<?php echo $id_bahan_baku; ?>" /></td>
					</tr>
					<tr>
						<td>Nama Bahan Baku</td>
						<td><input required class="form-control" name="nama_bahan_baku" id="nama_bahan_baku" placeholder="Nama Bahan Baku" value="<?php echo $nama_bahan_baku; ?>" /></td>
					</tr>
					<tr>
						<td>Stok</td>
						<td><input style="width:200px" readonly type="number" required class="form-control" name="stok" id="stok" placeholder="Stok" value="<?php echo $stok; ?>" /></td>
					</tr>
					<tr>
						<td>Satuan Stok</td>
						<td><select style="width:200px";  required class="form-control" name="satuan_stok" id="satuan_stok">
							<option value="">Pilih Satuan Stok</option>
							<?php
								$query = "select * from satuan";
								$resultSatuan = mysql_query($query);
								while($rowSatuan = mysql_fetch_array($resultSatuan))
								{
									?><option value="<?php echo $rowSatuan["id_satuan"]; ?>" <?php if($rowSatuan["id_satuan"] == $satuan_stok) { echo "selected"; } ?> ><?php echo $rowSatuan["nama_satuan"]; ?></option><?php 
								}
							?>
						</select></td>
					</tr>
					<tr>
						<td>Satuan Beli</td>
						<td><select style="width:200px";  required class="form-control" name="satuan_beli" id="satuan_beli">
							<option value="">Pilih Satuan Beli</option>
							<?php
								$query = "select * from satuan";
								$resultSatuan = mysql_query($query);
								while($rowSatuan = mysql_fetch_array($resultSatuan))
								{
									?><option value="<?php echo $rowSatuan["id_satuan"]; ?>" <?php if($rowSatuan["id_satuan"] == $satuan_beli) { echo "selected"; } ?> ><?php echo $rowSatuan["nama_satuan"]; ?></option><?php 
								}
							?>
						</select></td>
					</tr>
					<tr style="display:none">
						<td>Konversi<br/>(1 Satuan Beli = X Satuan Stok)</td>
						<td><input style="width:200px";  type="number"  class="form-control" name="konversi" id="konversi" placeholder="Konversi" value="<?php echo $konversi; ?>" /></td>
					</tr>
					<tr>
						<td>Harga Beli</td>
						<td><input style="width:250px;" readonly step=".01" type="number" required class="form-control" name="harga_beli" id="harga_beli" placeholder="Harga Beli" value="<?php echo $harga_beli; ?>" /></td>
					</tr>
					<tr>
						<td>Harga Average</td>
						<td><input style="width:250px;" readonly  step=".01"  type="number" required class="form-control" name="harga_average" id="harga_average" placeholder="Harga Average" value="<?php echo $harga_average; ?>" /></td>
					</tr>
					<tr>
						<td> </td>
						<td>
							<button type="submit" name="simpan" class="btn btn-success">Simpan</button> 
 							<a href="bahan_baku.php" class="btn btn-danger">Batal</a>
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