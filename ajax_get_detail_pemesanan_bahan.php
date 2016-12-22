<?php

	require_once("connect.php");

	$id_pemesanan_bahan = "";
	if(isset($_POST["id_pemesanan_bahan"]))
	{
		$id_pemesanan_bahan = $_POST["id_pemesanan_bahan"];
	}
	
	$query = "select * from detail_pemesanan_bahan inner join bahan_baku on detail_pemesanan_bahan.id_bahan_baku=bahan_baku.id_bahan_baku
				where id_pemesanan_bahan='$id_pemesanan_bahan'";
	$resultDetail = mysql_query($query);
	$i = 0;
	$hasil = array();
	$data = "";
	while($rowDetail = mysql_fetch_array($resultDetail))
	{
		$data .= '<tr id="item_'.$i.'">
			<td><input class="form-control" type="text" readonly data-input-name="id_bahan_baku" name="id_bahan_baku[]" id="id_bahan_baku_'.$i.'" value="'.$rowDetail["id_bahan_baku"].'" /></td>
			<td><input class="form-control" type="text" readonly data-input-name="nama_bahan_baku" name="nama_bahan_baku[]" id="nama_bahan_baku_'.$i.'" value="'.$rowDetail["nama_bahan_baku"].'" /></td>
			<td><input class="form-control" text="text" readonly required style="width:150px;" type="number" data-input-name="jumlah" name="jumlah[]" id="jumlah_'.$i.'" value="'.$rowDetail["jumlah"].'" /></td>
			<td><input class="form-control" readonly required style="width:150px;" type="text" data-input-name="id_satuan" name="id_satuan[]" id="id_satuan_'.$i.'" value="'.$rowDetail["satuan_beli"].'" /></td>
			<td><input class="form-control" readonly step=".01" style="width:150px;" type="text" data-input-name="harga" name="harga[]" id="harga_'.$i.'" value="'.$rowDetail["harga"].'" /></td>
			<td><input class="form-control" readonly min="0" required style="width:150px;" type="number" data-input-name="subtotal" name="subtotal[]" id="subtotal_'.$i.'" value="'.$rowDetail["subtotal"].'" /></td>
		</tr>';

		$i++;
	}		
	$hasil = array(
		"data" => $data,
		"jumlah_baris" => $i
	);
	echo json_encode($hasil);

?>