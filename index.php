<?php
	require_once("connect.php");
	
	//jika sudah login
	if(isset($_SESSION["hans_id_pengguna"]))
	{
		?><script>document.location.href='beranda.php';</script><?php
		die(0);
	}
	
	//jika pengguna menekan login
	if(isset($_POST["login"]))
	{
		$id_pengguna = $_POST["id_pengguna"];
		$password = $_POST["password"];
		
		//cek ke database -> select
		$query = "select * FROM pengguna WHERE id_pengguna='$id_pengguna' and password='$password'";
		$hasil = mysql_query($query); //mysql_query(...) ->  utk eksekusi query (insert/update/delete/select)
		
		//mysql_fetch_array -> ambil 1 bari dari hasil select lalu pindah ke baris berikutnya
		//jika query empty result atau sudah sampai baris akhir -> FALSE
		if($data = mysql_fetch_array($hasil)) //kalau berhasil fetch -> data benar
		{
			$_SESSION["hans_id_pengguna"] = $data["id_pengguna"];
			$_SESSION["hans_nama_pengguna"] = $data["nama_pengguna"];
			$_SESSION["hans_jenis_pengguna"] = $data["jenis_pengguna"];
			?><script>alert('Login sukses');</script><?php
			?><script>document.location.href='beranda.php';</script><?php
			die(0);
		}
		else	//data login salah
		{
			?><script>alert('Login salah');</script><?php
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
		<br><br>
		
	
		<div class="row">
			<div class="col-md-6 col-md-offset-3">
				<div class="panel panel-warning">
				  <div class="panel-heading">Silahkan login dahulu</div>
				  <div class="panel-body">
					<form class="form-horizontal" action="" method="post">
					  <div class="form-group">
						<label for="id_pengguna" class="col-sm-3 control-label">Id Pengguna</label>
						<div class="col-sm-9">
						  <input type="text" class="form-control" name="id_pengguna" id="id_pengguna" placeholder="Masukkan ID Pengguna">
						</div>
					  </div>
					  <div class="form-group">
						<label for="password" class="col-sm-3 control-label">Password</label>
						<div class="col-sm-9">
						  <input type="password" class="form-control" name="password" id="password" placeholder="Masukkan Password">
						</div>
					  </div>
					  <div class="form-group">
						<div class="col-sm-offset-3 col-sm-9">
						  <button type="submit" name="login" class="btn btn-warning">Login</button>
						  <button type="reset" class="btn btn-danger">Batal</button>
						</div>
					  </div>
					</form>
				  </div>
				</div>

			
			</div>
		</div>
	</div>
	<!-- akhir bagian isi -->
	

	<?php include("footer.php"); ?>

</body>
</html>