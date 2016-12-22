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
			$id_roti = $row["id_roti"];
			$nama_roti = $row["nama_roti"];
			$harga_jual = $row["harga_jual"];
			$stok = $row["stok"];
		
			$query = "delete from roti 
					where id_roti='$id_roti'";
			mysql_query($query);
			
			if(mysql_error() == "")
			{
				?><script>alert("Data berhasil dihapus");</script>
				<script>document.location.href='roti.php'</script><?php
				die(0);
			}
			else{
				?><script>alert("Data tidak bisa dihapus, karena masih ada di tabel lain (Foreign Key)");</script>
				<script>document.location.href='roti.php'</script><?php
				die(0);
			}
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
	
?>