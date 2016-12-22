<?php
	require_once("connect.php");
	
	//jika belum login -> kembalikan ke halaman login
	if(!isset($_SESSION["hans_id_pengguna"]))
	{
		?><script>alert('Silahkan login dahulu');</script><?php
		?><script>document.location.href='index.php';</script><?php
		die(0);
	}
	
	$id_pembelian_bahan = createId("pembelian","id_pembelian","PB",5);
	$tanggal_pembelian_bahan = date("Y-m-d");
	$id_pembelian ="";
	$id_supplier = "";
	$total ="0";
	$jenis_pembayaran = "";
	$id_pengguna = $_SESSION["hans_id_pengguna"];
	$dibayar ="0";
	$tanggal_jatuh_tempo=date("Y-m-d",time()+(30*24*3600));
	$data_id_bahan_baku = array();
	$data_nama_bahan_baku = array();
	$data_jumlah = array();
	$data_id_satuan = array();
	$data_harga = array();
	$data_subtotal = array();
	
	if(isset($_GET["id_retur_pembelian"]))
	{
		$id_retur_pembelian = $_GET["id_retur_pembelian"];
		$query = "select * from retur_pembelian inner join pembelian on retur_pembelian.id_pembelian=pembelian.id_pembelian
				inner join supplier on pembelian.id_supplier=supplier.id_supplier where id_retur_pembelian='$id_retur_pembelian'";
		$result = mysql_query($query);
		if($row = mysql_fetch_array($result))
		{
			
			$id_pembelian = $row["id_pembelian"];
			$tanggal_retur_pembelian = $row["tanggal_retur_pembelian"];
			$status_retur = $row["status_retur"];
			$id_supplier = $row["id_supplier"];
			$nama_supplier = $row["nama_supplier"];
			
			if($status_retur == "Sudah diganti")
			{
				?><script>alert("Penggantian sudah dilakukan sebelumnya");</script>
				<script>document.location.href='retur_pembelian.php'</script><?php
				die(0);
			}
			else
			{
				$query = "update retur_pembelian set status_retur = 'Sudah diganti' where id_retur_pembelian='$id_retur_pembelian'";
				mysql_query($query);
				
				$query = "select * from detail_retur_pembelian where id_retur_pembelian='$id_retur_pembelian'";
				$resultDetail = mysql_query($query);
				while($rowDetail = mysql_fetch_array($resultDetail))
				{
					$id_bahan_baku = $rowDetail["id_bahan_baku"];
					$jumlah = $rowDetail["jumlah_retur"];
					
					$query = "update detail_pembelian set jumlah_diretur=jumlah_diretur - '$jumlah' where id_bahan_baku='$id_bahan_baku' and id_pembelian='$id_pembelian'";
					mysql_query($query);
				
				
					//hitung average + stok baru
					$query = "select * from bahan_baku where id_bahan_baku='$id_bahan_baku'";
					$resultBahan = mysql_query($query);
					if($rowBahan = mysql_fetch_array($resultBahan))
					{
						$konversi = $rowBahan["konversi"];
						$harga_average = $rowBahan["harga_average"];
						$stok = $rowBahan["stok"];
						
						if($konversi == 0)
						{
							$konversi = 1;
						}
						$jumlah_retur = $jumlah * $konversi;
						$stok_baru = $stok + $jumlah_retur;
						$query = "update bahan_baku set stok='$stok_baru' where id_bahan_baku='$id_bahan_baku'";
						mysql_query($query);
					}
				}
				?><script>alert("Penggantian retur sukses");</script>
				<script>document.location.href='retur_pembelian.php'</script><?php
				die(0);
			}
	
		}
		else{
			
			?><script>alert("Data tidak ditemukan");</script>
			<script>document.location.href='retur_pembelian.php'</script><?php
			die(0);
		}
	}
	else
	{
		?><script>alert("Data tidak ditemukan");</script>
		<script>document.location.href='retur_pembelian.php'</script><?php
		die(0);
	}
	
?>>