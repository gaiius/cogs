<?php
	require_once("connect.php");
	
	//jika belum login -> kembalikan ke halaman login
	if(!isset($_SESSION["hans_id_pengguna"]))
	{
		?><script>alert('Silahkan login dahulu');</script><?php
		?><script>document.location.href='index.php';</script><?php
		die(0);
	}
	
	$id_bahan_baku = "";
	$nama_bahan_baku = "";
	$stok = "";
	$satuan_stok = "";
	$satuan_beli = "";
	$konversi = "";
	$harga_beli = "";
	$harga_average = "";
	
	
	if(isset($_GET["id_bahan_baku"]))
	{
		$id_bahan_baku = $_GET["id_bahan_baku"];
		$query = "select * from bahan_baku where id_bahan_baku='$id_bahan_baku'";
		$result = mysql_query($query);
		if($row = mysql_fetch_array($result))
		{
			$nama_bahan_baku = $row["nama_bahan_baku"];
			$stok = $row["stok"];
			$satuan_stok = $row["satuan_stok"];
			$satuan_beli = $row["satuan_beli"];
			$konversi = $row["konversi"];
			$harga_beli = $row["harga_beli"];
			$harga_average = $row["harga_average"];
			
			$query = "delete from bahan_baku 
					where id_bahan_baku='$id_bahan_baku'";
			mysql_query($query);
			
			if(mysql_error() == "")
			{
				?><script>alert("Data berhasil dihapus");</script>
				<script>document.location.href='bahan_baku.php'</script><?php
				die(0);
			}
			else{
				?><script>alert("Data tidak bisa dihapus, karena masih ada di tabel lain (Foreign Key)");</script>
				<script>document.location.href='bahan_baku.php'</script><?php
				die(0);
			}
		}
		else{
			
			?><script>alert("Data tidak ditemukan");</script>
			<script>document.location.href='bahan_baku.php'</script><?php
			die(0);
		}
	}
	else
	{
		?><script>alert("Data tidak ditemukan");</script>
		<script>document.location.href='bahan_baku.php'</script><?php
		die(0);
	}
	
?>