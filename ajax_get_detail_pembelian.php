<?php

	require_once("connect.php");

	$id_pembelian = "";
	if(isset($_POST["id_pembelian"]))
	{
		$id_pembelian = $_POST["id_pembelian"];
	}
	
	$query = "select * from detail_pembelian inner join bahan_baku on detail_pembelian.id_bahan_baku=bahan_baku.id_bahan_baku
				where id_pembelian='$id_pembelian'";
	$resultDetail = mysql_query($query);
	$i = 0;
	$hasil = array();
	$data = "";
	while($rowDetail = mysql_fetch_array($resultDetail))
	{
		$max_retur = $rowDetail["jumlah"] - $rowDetail["jumlah_diretur"];
		if($max_retur > 0)
		{
		$data .= '<tr id="item_'.$i.'">
			<td><input class="form-control" type="text" readonly data-input-name="id_bahan_baku" name="id_bahan_baku[]" id="id_bahan_baku_'.$i.'" value="'.$rowDetail["id_bahan_baku"].'" /></td>
			<td><input class="form-control" type="text" readonly data-input-name="nama_bahan_baku" name="nama_bahan_baku[]" id="nama_bahan_baku_'.$i.'" value="'.$rowDetail["nama_bahan_baku"].'" /></td>
			<td><input class="form-control" text="number" min="0" max="'.$max_retur.'" required style="width:150px;"  data-input-name="jumlah" name="jumlah[]" id="jumlah_'.$i.'" value="0" /></td>
			<td><input class="form-control" readonly required style="width:150px;" type="text" data-input-name="id_satuan" name="id_satuan[]" id="id_satuan_'.$i.'" value="'.$rowDetail["satuan_beli"].'" /></td>
			<td><input class="form-control" text="text" readonly required style="width:150px;" data-input-name="max_retur" name="max_retur[]" id="max_retur_'.$i.'" value="'.$max_retur.'" /></td>
		</tr>';

		$i++;
		}
	}		
	$hasil = array(
		"data" => $data,
		"jumlah_baris" => $i
	);
	echo json_encode($hasil);

?>