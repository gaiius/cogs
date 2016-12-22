<?php
	require_once("connect.php");
	
	//jika belum login -> kembalikan ke halaman login
	if(!isset($_SESSION["hans_id_pengguna"]))
	{
		?><script>alert('Silahkan login dahulu');</script><?php
		?><script>document.location.href='index.php';</script><?php
		die(0);
	}
	
	$id_satuan = "";
	$nama_satuan = "";
	
	if(isset($_GET["id_satuan"]))
	{
		$id_satuan = $_GET["id_satuan"];
		$query = "select * from satuan where id_satuan='$id_satuan'";
		$result = mysql_query($query);
		if($row = mysql_fetch_array($result))
		{
			$nama_satuan = $row["nama_satuan"];
		}
		else{
			
			?><script>alert("Data tidak ditemukan");</script>
			<script>document.location.href='satuan.php'</script><?php
			die(0);
		}
	}
	else
	{
		?><script>alert("Data tidak ditemukan");</script>
		<script>document.location.href='satuan.php'</script><?php
		die(0);
	}
	
	if(isset($_POST["simpan"]))
	{
		$id_satuan = $_POST["id_satuan"];
		$nama_satuan = $_POST["nama_satuan"];
		
		$error = 0;
		//pengecekan error
		$query = "select * from satuan where nama_satuan='$nama_satuan' and id_satuan <> '$id_satuan'";
		$resultCek = mysql_query($query);
		if(mysql_num_rows($resultCek) > 0)
		{
			?><script>alert("Nama satuan sudah ada sebelumnya");</script><?php
			$error = 1;
		}
		
		if($error == 0)
		{
			$query = "update satuan set 
						nama_satuan='$nama_satuan'
					where id_satuan='$id_satuan'";
			mysql_query($query);
			
			?><script>alert("Data berhasil diubah");</script>
			<script>document.location.href='satuan.php'</script><?php
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
		<h3>Satuan</h3>
		<br/>
		<form action="" method="post">
		<div  style="width: 600px;">
			<table class="table table-bordered table-striped table-hover ">
				<thead>	<!-- kop table -->
				</thead>
				</tbody> <!-- isi table -->
					<tr>
						<td style="width:150px;">Id Satuan</td>
						<td><input readonly required style="width:150px"; class="form-control" name="id_satuan" id="id_satuan" placeholder="Id Satuan" value="<?php echo $id_satuan; ?>" /></td>
					</tr>
					<tr>
						<td>Nama Satuan</td>
						<td><input required class="form-control" name="nama_satuan" id="nama_satuan" placeholder="Nama Satuan" value="<?php echo $nama_satuan; ?>" /></td>
					</tr>
					<tr>
						<td> </td>
						<td>
							<button type="submit" name="simpan" class="btn btn-success">Simpan</button> 
 							<a href="satuan.php" class="btn btn-danger">Batal</a>
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