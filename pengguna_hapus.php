<?php
	require_once("connect.php");
	
	//jika belum login -> kembalikan ke halaman login
	if(!isset($_SESSION["hans_id_pengguna"]))
	{
		?><script>alert('Silahkan login dahulu');</script><?php
		?><script>document.location.href='index.php';</script><?php
		die(0);
	}
	
	$id_pengguna = "";
	$nama_pengguna = "";
	$password = "";
	$jenis_pengguna = "";
	
	if(isset($_GET["id_pengguna"]))
	{
		$id_pengguna = $_GET["id_pengguna"];
		$query = "select * from pengguna where id_pengguna='$id_pengguna'";
		$result = mysql_query($query);
		if($row = mysql_fetch_array($result))
		{
			$id_pengguna = $row["id_pengguna"];
			$nama_pengguna = $row["nama_pengguna"];
			$password = $row["password"];
			$jenis_pengguna = $row["jenis_pengguna"];
		
			$query = "delete from pengguna 
					where id_pengguna='$id_pengguna'";
			mysql_query($query);
			
			if(mysql_error() == "")
			{
				?><script>alert("Data berhasil dihapus");</script>
				<script>document.location.href='pengguna.php'</script><?php
				die(0);
			}
			else{
				?><script>alert("Data tidak bisa dihapus, karena masih ada di tabel lain (Foreign Key)");</script>
				<script>document.location.href='pengguna.php'</script><?php
				die(0);
			}
		}
		else{
			
			?><script>alert("Data tidak ditemukan");</script>
			<script>document.location.href='pengguna.php'</script><?php
			die(0);
		}
	}
	
	
?>