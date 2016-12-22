<?php

	require_once("connect.php");

	$id_supplier = "";
	if(isset($_POST["id_supplier"]))
	{
		$id_supplier = $_POST["id_supplier"];
	}
	
	$hasil = "<option>Pilih Pemesanan</option>";
	$query = "select * from pemesanan_bahan where id_supplier='$id_supplier' and status_pemesanan_bahan='belum finish'";
	$result = mysql_query($query);
	while($row = mysql_fetch_array($result))
	{
		$hasil .= "<option value=\"$row[id_pemesanan_bahan]\">$row[id_pemesanan_bahan]</option>";
	}
	echo $hasil;

?>