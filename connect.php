<?php
	session_start();	//utk simpan data login pada session
	//session start harus dilakukan sebelum ada html syntax apapun
	
	//syntax konek database
	mysql_connect("localhost","root","");
	mysql_select_db("beta_hpp");
	
	function createId($namatabel,$namakolom, $awalan, $jumlah)
	{
		$akhir = 0;	//inisialisasi angka terakhir adalah 0 -> belum ada data, akhir: 0
		
		//query untuk mencari angka paling akhir (dipotong dari kanan), B001,B002,B003 -> 003 -> 3 (akhir)
		$query = "select max(right($namakolom,$jumlah)) as akhir from $namatabel where $namakolom like '".$awalan."%' ";
		//PJ.1511.00017
		//PJ.1510.00048
		//PJ.1511. -> 18
		$result = mysql_query($query);
		if($row = mysql_fetch_array($result))
		{
			if(isset($row["akhir"]))
			{
				$akhir = intval($row["akhir"]);	//kalau ada data -> akhir > 0
			}
		}
		$akhir = $akhir + 1;	//id yang baru pasti angka terakhir di plus (+) 1*$jumlah
		//gabungkan awalan dengan angka akhiran
		//angka akhiran misal 5 digit
		//235 -> 00235 (+00)
		//17  -> 00017 (+000)
		//cara: pertama ditambah 0 yang banyak (000000000000) lalu setelah ditambah angka -> potong dari kanan sejumlah yang dipakai
		//0000000235 -> Right(5) => 00235
		//000000017  -> Right(5) => 00017
		return $awalan.substr("000000000".$akhir,-1*$jumlah);
	}
	
	function balikTanggal($tgl)
	{
		if($tgl != "")
		{
			
			$tgl2 = explode("-",$tgl);
			if(count($tgl2) >= 3)
			{
				return $tgl2[2]."-".$tgl2[1]."-".$tgl2[0];
			}
		}
		else
		{
			return $tgl;
		}
	}
	$daftar_bulan = array("Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember");
	
?>