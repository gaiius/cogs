<?php
	require_once("connect.php");
	
	//jika belum login -> kembalikan ke halaman login
	if(!isset($_SESSION["hans_id_pengguna"]))
	{
		?><script>alert('Silahkan login dahulu');</script><?php
		?><script>document.location.href='index.php';</script><?php
		die(0);
	}
	
	$id_roti = "";
	$nama_roti = "";
	$harga_jual ="";
	$stok ="";
	if(isset($_GET["id_roti"]))
	{
		$id_roti = $_GET["id_roti"];
		$query = "select * from roti where id_roti='$id_roti'";
		$result = mysql_query($query);
		if($row = mysql_fetch_array($result))
		{
			$nama_roti = $row["nama_roti"];
			$harga_jual = $row["harga_jual"];
			$stok = $row["stok"];
	
		}
		else{
			
			?><script>alert("Data tidak ditemukan");</script>
			<script>document.location.href='roti.php'</script><?php
			die(0);
		}
	}
	else
	{
		?><script>alert("Data tidak ditemukan");</script>
		<script>document.location.href='roti.php'</script><?php
		die(0);
	}
	
	if(isset($_POST["simpan"]))
	{
		$id_roti = $_POST["id_roti"];
		$nama_roti = $_POST["nama_roti"];
		$harga_jual = $_POST["harga_jual"];
		$stok = $_POST["stok"];
		
		$error = 0;
		//pengecekan error
		$query = "select * from roti where nama_roti='$nama_roti' and id_roti <> '$id_roti'";
		$resultCek = mysql_query($query);
		if(mysql_num_rows($resultCek) > 0)
		{
			?><script>alert("Nama roti sudah ada sebelumnya");</script><?php
			$error = 1;
		}
		
		if($error == 0)
		{
			$query = "update roti set 
						nama_roti='$nama_roti',harga_jual='$harga_jual',stok='$stok'
					where id_roti='$id_roti'";
			mysql_query($query);
			
			?><script>alert("Data berhasil diubah");</script>
			<script>document.location.href='roti.php'</script><?php
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
		<h3>Roti</h3>
		<br/>
		<form action="" method="post">
		<div  style="width: 600px;">
			<table class="table table-bordered table-striped table-hover ">
				<thead>	<!-- kop table -->
				</thead>
				</tbody> <!-- isi table -->
					<tr>
						<td style="width:150px;">Id Roti</td>
						<td><input readonly required style="width:150px"; class="form-control" name="id_roti" id="id_roti" placeholder="Id Roti" value="<?php echo $id_roti; ?>" /></td>
					</tr>
					<tr>
						<td>Nama Roti</td>
						<td><input required class="form-control" name="nama_roti" id="nama_roti" placeholder="Nama Satuan" value="<?php echo $nama_roti; ?>" /></td>
					</tr>
					<tr>
						<td>Harga Roti</td>
						<td><input required class="form-control" name="harga_jual" id="harga_jual" placeholder="Harga " value="<?php echo $harga_jual; ?>" /></td>
					</tr>
					<tr>
						<td>Stok</td>
						<td><input readonly type="number" required class="form-control" name="stok" id="stok" placeholder="Stok" value="<?php echo $stok; ?>" /></td>
					</tr>
					<tr>
						<td> </td>
						<td>
							<button type="submit" name="simpan" class="btn btn-success">Simpan</button> 
 							<a href="roti.php" class="btn btn-danger">Batal</a>
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