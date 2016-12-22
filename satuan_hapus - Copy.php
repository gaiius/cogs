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
			
			
			$query = "delete from satuan 
					where id_satuan='$id_satuan'";
			mysql_query($query);
			
			if(mysql_error() == "")
			{
				?><script>alert("Data berhasil dihapus");</script>
				<script>document.location.href='satuan.php'</script><?php
				die(0);
			}
			else{
				?><script>alert("Data tidak bisa dihapus, karena masih ada di tabel lain (Foreign Key)");</script>
				<script>document.location.href='satuan.php'</script><?php
				die(0);
			}
			
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
	
	
?>