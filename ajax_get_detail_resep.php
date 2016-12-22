<?php

	require_once("connect.php");

	$id_roti = "";
	if(isset($_POST["id_roti"]))
	{
		$id_roti = $_POST["id_roti"];
	}
	$jumlah = 0;
	if(isset($_POST["jumlah"]))
	{
		$jumlah = $_POST["jumlah"];
	}
	
	$query = "select * from resep_roti inner join bahan_baku on resep_roti.id_bahan_baku=bahan_baku.id_bahan_baku
				where id_roti='$id_roti'";
	$resultDetail = mysql_query($query);
	$i = 0;
	$hasil = array();
	$data = "";
	while($rowDetail = mysql_fetch_array($resultDetail))
	{
		$subtotal_bahan_baku = $rowDetail["jumlah_bahan_baku"] * $jumlah * $rowDetail["harga_average"];
		$data .= '<tr id="item_'.$i.'">
			<td><input class="form-control" type="text" readonly data-input-name="id_bahan_baku" name="id_bahan_baku[]" id="id_bahan_baku_'.$i.'" value="'.$rowDetail["id_bahan_baku"].'" /></td>
			<td><input class="form-control" type="text" readonly data-input-name="nama_bahan_baku" name="nama_bahan_baku[]" id="nama_bahan_baku_'.$i.'" value="'.$rowDetail["nama_bahan_baku"].'" /></td>
			<td><input class="form-control" readonly required style="width:150px;" type="text"  name="stok[]" id="stok_'.$i.'" value="'.$rowDetail["stok"].'" /></td>
			<td><input class="form-control" text="text" required style="width:150px;" type="number" min="0" max="'.$rowDetail["stok"].'" step=".01"  onchange="editDetail('.$i.')" name="jumlah_bahan_baku[]" id="jumlah_bahan_baku_'.$i.'" value="'.($rowDetail["jumlah_bahan_baku"]*$jumlah).'" /></td>
			<td><input class="form-control" readonly required style="width:150px;" type="text" name="id_satuan[]" id="id_satuan_'.$i.'" value="'.$rowDetail["satuan_stok"].'" /></td>
			<td><input class="form-control" readonly style="width:150px;" type="text"  name="harga_bahan_baku[]" id="harga_bahan_baku_'.$i.'" value="'.$rowDetail["harga_average"].'" /></td>
			<td><input class="form-control" readonly min="0" required style="width:150px;" type="number"  name="subtotal_bahan_baku[]" id="subtotal_bahan_baku_'.$i.'" value="'.$subtotal_bahan_baku.'" /></td>
			<td><button type="button" class="btn btn-danger" onclick="deleteDetail('.$i.')"><i class="glyphicon glyphicon-remove"></i> Item</button>				
		</tr>';
				

		$i++;
	}		
	$hasil = array(
		"data" => $data,
		"jumlah_baris" => $i
	);
	echo json_encode($hasil);

?>