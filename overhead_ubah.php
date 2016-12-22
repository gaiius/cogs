<?php
	require_once("connect.php");
	
	//jika belum login -> kembalikan ke halaman login
	if(!isset($_SESSION["hans_id_pengguna"]))
	{
		?><script>alert('Silahkan login dahulu');</script><?php
		?><script>document.location.href='index.php';</script><?php
		die(0);
	}
	
	$id_overhead = "";
	$nama_overhead = "";
	$biaya_overhead ="";
	$satuan_overhead = "";
	
	if(isset($_GET["id_overhead"]))
	{
		$id_overhead = $_GET["id_overhead"];
		$query = "select * from overhead where id_overhead='$id_overhead'";
		$result = mysql_query($query);
		if($row = mysql_fetch_array($result))
		{
			$nama_overhead = $row["nama_overhead"];
			$biaya_overhead	 = $row["biaya_overhead"];
			$satuan_overhead = $row["satuan_overhead"];
	
		}
		else{
			
			?><script>alert("Data tidak ditemukan");</script>
			<script>document.location.href='overhead.php'</script><?php
			die(0);
		}
	}
	else
	{
		?><script>alert("Data tidak ditemukan");</script>
		<script>document.location.href='overhead.php'</script><?php
		die(0);
	}
	
	if(isset($_POST["simpan"]))
	{
		$id_overhead = $_POST["id_overhead"];
		$nama_overhead = $_POST["nama_overhead"];
		$biaya_overhead = $_POST["biaya_overhead"];
		$satuan_overhead = $_POST["satuan_overhead"];
		
		
		$error = 0;
		//pengecekan error
		$query = "select * from overhead where nama_overhead='$nama_overhead' and id_overhead <> '$id_overhead'";
		$resultCek = mysql_query($query);
		if(mysql_num_rows($resultCek) > 0)
		{
			?><script>alert("Nama overhead sudah ada sebelumnya");</script><?php
			$error = 1;
		}
		
		if($error == 0)
		{
			$query = "update overhead set 
						nama_overhead='$nama_overhead',biaya_overhead='$biaya_overhead',satuan_overhead='$satuan_overhead'
					where id_overhead='$id_overhead'";
			mysql_query($query);
			
			?><script>alert("Data berhasil diubah");</script>
			<script>document.location.href='overhead.php'</script><?php
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
		<h3>Overhead</h3>
		<br/>
		<form action="" method="post">
		<div  style="width: 600px;">
			<table class="table table-bordered table-striped table-hover ">
				<thead>	<!-- kop table -->
				</thead>
				</tbody> <!-- isi table -->
					<tr>
						<td style="width:150px;">Id overhead</td>
						<td><input readonly required style="width:150px"; class="form-control" name="id_overhead" id="id_overhead" placeholder="Id overhead" value="<?php echo $id_overhead; ?>" /></td>
					</tr>
					<tr>
						<td>Nama overhead</td>
						<td><input required class="form-control" name="nama_overhead" id="nama_overhead" placeholder="Nama Satuan" value="<?php echo $nama_overhead; ?>" /></td>
					</tr>
					<tr>
						<td>Biaya / Satuan</td>
						<td><input required class="form-control" name="biaya_overhead" id="biaya_overhead" placeholder="Biaya overhead " value="<?php echo $biaya_overhead; ?>" /></td>
					</tr>
					<tr>
						<td>Satuan biaya</td>
						<td><input required class="form-control" name="satuan_overhead" id="satuan_overhead" placeholder="Satuan overhead" value="<?php echo $satuan_overhead; ?>" /></td>
					</tr>
					<tr>
						<td> </td>
						<td>
							<button type="submit" name="simpan" class="btn btn-success">Simpan</button> 
 							<a href="overhead.php" class="btn btn-danger">Batal</a>
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