<?php
	require_once("connect.php");
	
	//jika belum login -> kembalikan ke halaman login
	if(!isset($_SESSION["hans_id_pengguna"]))
	{
		?><script>alert('Silahkan login dahulu');</script><?php
		?><script>document.location.href='index.php';</script><?php
		die(0);
	}
	
	$id_pemesanan_bahan = createId("pemesanan_bahan","id_pemesanan_bahan","PS",5);
	$tanggal_pemesanan_bahan = date("Y-m-d");
	$id_supplier ="";
	$nama_supplier = "";
	$total ="0";
	$status_pemesanan_bahan ="Belum finish";
	$data_id_bahan_baku = array();
	$data_nama_bahan_baku = array();
	$data_jumlah = array();
	$data_id_satuan = array();
	$data_harga = array();
	$data_subtotal = array();
	
	if(isset($_POST["simpan"]))
	{
		$id_pemesanan_bahan = $_POST["id_pemesanan_bahan"];
		$tanggal_pemesanan_bahan = balikTanggal($_POST["tanggal_pemesanan_bahan"]);
		$id_supplier = $_POST["id_supplier"];
		$nama_supplier = $_POST["nama_supplier"];
		$total = $_POST["total"];
		$error = 0;
		
		//pengecekan error
		
		
		if($error == 0)
		{
			$query = "insert into pemesanan_bahan(id_pemesanan_bahan,tanggal_pemesanan_bahan,id_supplier,total,status_pemesanan_bahan) values ('$id_pemesanan_bahan','$tanggal_pemesanan_bahan','$id_supplier','$total','$status_pemesanan_bahan')";
			mysql_query($query);
			
			$data_id_bahan_baku = $_POST["id_bahan_baku"];
			$data_nama_bahan_baku = $_POST["nama_bahan_baku"];
			$data_jumlah = $_POST["jumlah"];
			$data_id_satuan = $_POST["id_satuan"];
			$data_harga = $_POST["harga"];
			$data_subtotal = $_POST["subtotal"];
			for($i=0; $i<count($data_id_bahan_baku); $i++)
			{
				$id_bahan_baku = $data_id_bahan_baku[$i];
				$jumlah = $data_jumlah[$i];
				$harga = $data_harga[$i];
				$subtotal = $data_subtotal[$i];
				
				
				$query = "insert into detail_pemesanan_bahan(id_pemesanan_bahan,id_bahan_baku,harga,jumlah,subtotal) values ('$id_pemesanan_bahan','$id_bahan_baku','$harga','$jumlah','$subtotal')";
				mysql_query($query);
			}
			
			?><script>alert("Data berhasil ditambah");</script>
			<script>document.location.href='pemesanan_bahan.php'</script><?php
			die(0);
		}
	}
	
?>
<!doctype html>
<html lang="en">
<head>
	<?php include("head.php"); ?>
	<script>
		$(function(){
			var jumlah_baris = 0;
			
			hitungTotal = function(){
				total = 0;
				for(i=0; i<jumlah_baris; i++)
				{
					if($("#item_"+i).length > 0)
					{
						
						total += parseFloat($("#subtotal_"+i).val()); 
						
					}
				}
				$("#total").val(total);
			}
			
			addDetail = function(){
				id_bahan_baku = $("#id_bahan_baku").val();
				jumlah = $("#jumlah").val();
				harga = parseFloat($("#harga").val());
				harga = Math.round(harga / jumlah * 100) / 100;
				nama_bahan_baku = $("#nama_bahan_baku").val();
				id_satuan = $("#id_satuan").val();
				
				if(id_bahan_baku == "")
				{
					alert('Bahan belum dipilih');
					return false;				
				}
				if(jumlah == "")
				{
					alert('Jumlah pesan belum diisi');
					return false;				
				}
				if(harga == "")
				{
					alert('Harga pesan belum diisi');
					return false;				
				}
				
				for(i=0; i<jumlah_baris; i++)
				{
					if($("#item_"+i).length > 0)
					{
						if($("#id_bahan_baku_"+i).val() == id_bahan_baku)
						{
							alert('Bahan sudah ada');
							return false;
						}
					}
				}
				
				subtotal = parseFloat(jumlah) * parseFloat(harga);
			
				tambah = '';
				tambah += '<tr id="item_'+jumlah_baris.toString()+'">'; //start row
			
				tambah += '<td><input class="form-control" type="text" readonly data-input-name="id_bahan_baku" name="id_bahan_baku[]" id="id_bahan_baku_'+jumlah_baris+'" value="'+id_bahan_baku+'" /></td>';
				tambah += '<td><input class="form-control" type="text" readonly data-input-name="nama_bahan_baku" name="nama_bahan_baku[]" id="nama_bahan_baku_'+jumlah_baris+'" value="'+nama_bahan_baku+'" /></td>';
				tambah += '<td><input class="form-control" step=.01" min="0" required style="width:150px;" type="number" data-input-name="jumlah" name="jumlah[]" id="jumlah_'+jumlah_baris+'" value="'+$("#jumlah").val()+'" onchange="editDetail('+jumlah_baris+')" /></td>';
				tambah += '<td><input class="form-control" readonly required style="width:150px;" type="text" data-input-name="id_satuan" name="id_satuan[]" id="id_satuan_'+jumlah_baris+'" value="'+id_satuan+'" /></td>';
				tambah += '<td><input class="form-control" min="0" step=".01"required style="width:150px;" type="number" data-input-name="harga" name="harga[]" id="harga_'+jumlah_baris+'" value="'+harga+'"  onchange="editDetail('+jumlah_baris+')" /></td>';
				tambah += '<td><input class="form-control" readonly min="0" required style="width:150px;" type="number" data-input-name="subtotal" name="subtotal[]" id="subtotal_'+jumlah_baris+'" value="'+subtotal+'" /></td>';
				tambah += '<td><button type="button" class="btn btn-danger" onclick="deleteDetail('+jumlah_baris+')"><i class="glyphicon glyphicon-remove"></i> Item</button>';
				tambah += '</tr>';
				$("#detail_pesan").append(tambah);
				jumlah_baris++;
				$("#id_bahan_baku").val("");
				$("#nama_bahan_baku").val("");
				$("#jumlah").val("");
				$("#harga").val("");
				$("#id_satuan").val("");
				
				hitungTotal();	
			}
			editDetail = function(i){
				
				subtotal = "";
				$("#subtotal_"+i.toString()).val(subtotal);
				jumlah=parseFloat($("#jumlah_"+i.toString()).val());
				harga=parseFloat($("#harga_"+i.toString()).val());
				subtotal = jumlah*harga;
				$("#subtotal_"+i.toString()).val(subtotal);
				hitungTotal();
			}
			
			deleteDetail = function(i){
				
				$("#item_"+i.toString()).remove();
				hitungTotal();
			}
			
			cekSave = function(){
				jumlah_kodebarang = $("input[data-input-name='id_bahan_baku']").length;
				//alert(jumlah_kodebarang);
				if(jumlah_kodebarang <= 0)
				{
					alert('Detail pesanan masih kosong');
					return false;
				}
				else
				{
					return confirm('Simpan data ?');
					
				}
			}
			$("#id_bahan_baku").change(function(e){
				
				id_satuan = $("#id_bahan_baku").find('option:selected').attr("data_id_satuan");
				$("#id_satuan").val(id_satuan);
			});
			
			
			
			$("#nama_bahan_baku").autocomplete({
				source: function( request, response ) {
					$.ajax({
						url: "ajax_get_bahan_baku.php",
						dataType: "json",
						type: "post",
						data: {
							cari: request.term
						},
						success: function( data ) {
							
							response( $.map( data, function( item ) {
								return {
									label: item.id_bahan_baku + ' - ' + item.nama_bahan_baku,
									value: item.nama_bahan_baku,
									id_bahan_baku: item.id_bahan_baku,
									nama_bahan_baku: item.nama_bahan_baku,
									satuan_beli: item.satuan_beli,
								}
							}));
							
						}
					});
				},
				minLength: 0,
				autoFocus: true,
				select: function( event, ui ) {
					if(!ui.item)
					{
						$("#nama_bahan_baku").val("");
						$("#id_bahan_baku").val("");
						$("#id_satuan").val("");
					}
					else
					{
						$("#id_bahan_baku").val(ui.item.id_bahan_baku);
						$("#nama_bahan_baku").val(ui.item.nama_bahan_baku);
						$("#id_satuan").val(ui.item.satuan_beli);
					}
				},
				search: function( event, ui ) {
					
				}
			})
			.blur(function(){
				if($("#id_bahan_baku").val() == "")
				{
					$("#id_bahan_baku").val("");
					$("#nama_bahan_baku").val("");
						$("#id_satuan").val("");
				}
			})
			.focus(function(){     
				$(this).autocomplete('search', '');
			});
			
			$("#nama_supplier").autocomplete({
				source: function( request, response ) {
					$.ajax({
						url: "ajax_get_supplier.php",
						dataType: "json",
						type: "post",
						data: {
							cari: request.term
						},
						success: function( data ) {
							
							response( $.map( data, function( item ) {
								return {
									label: item.id_supplier + ' - ' + item.nama_supplier,
									value: item.nama_supplier,
									id_supplier: item.id_supplier,
									nama_supplier: item.nama_supplier,
								}
							}));
							
						}
					});
				},
				minLength: 0,
				autoFocus: true,
				select: function( event, ui ) {
					if(!ui.item)
					{
						$("#nama_supplier").val("");
						$("#id_supplier").val("");
					}
					else
					{
						$("#id_supplier").val(ui.item.id_supplier);
						$("#nama_supplier").val(ui.item.nama_supplier);
					}
				},
				search: function( event, ui ) {
					
				}
			})
			.blur(function(){
				if($("#id_supplier").val() == "")
				{
					$("#id_supplier").val("");
					$("#nama_supplier").val("");
				}
			})
			.focus(function(){     
				$(this).autocomplete('search', '');
			});
		});
	</script>
</head>
<body>
	
	<?php include("header.php"); ?>
	
	<!-- bagian isi -->
	<div class="content container-fluid">
		<h3>Pemesanan Bahan</h3>
		<br/>
		<form action="" method="post">
		<div  >
			<table class="table table-bordered table-striped table-hover ">
				<thead>	<!-- kop table -->
				</thead>
				</tbody> <!-- isi table -->
					<tr>
						<td style="width:150px;">Id Pemesanan</td>
						<td><input required readonly style="width:150px"; class="form-control" name="id_pemesanan_bahan" id="id_pemesanan_bahan" placeholder="Id Roti" value="<?php echo $id_pemesanan_bahan; ?>" /></td>
					</tr>
					<tr>
						<td>tanggal_pemesanan_bahan</td>
						<td><input required class="datepicker form-control" name="tanggal_pemesanan_bahan" id="tanggal_pemesanan_bahan" placeholder="Nama Roti" value="<?php echo balikTanggal($tanggal_pemesanan_bahan); ?>" /></td>
					</tr>
					<tr>
						<td>Supplier</td>
						<td>
							<input type="text" required readonly style="width:100px; display:inline" placeholder="Id Supplier"  class="form-control" name="id_supplier" id="id_supplier" value="<?php echo $id_supplier; ?>">
							<input type="text"  style="width:300px; display:inline" placeholder="Cari nama supplier"  class="form-control" name="nama_supplier" id="nama_supplier" value="<?php echo $nama_supplier; ?>">
						</td>
					</tr>
					<tr>
						<td>total</td>
						<td><input style="width:250px;" required readonly class="form-control" name="total" id="total" placeholder="total " value="<?php echo $total; ?>" /></td>
					</tr>
					<tr>
						<td colspan="2"></td>
					</tr>
					<tr>
						<td colspan="2"><h4>Detail Pemesanan</h4></td>
					</tr>
					<tr>
						<td>Id bahan baku</td>
						<td>
							<input type="text" readonly style="width:100px; display:inline" placeholder="Id bahan baku"  class="form-control" id="id_bahan_baku" >
							<input type="text"  style="width:300px; display:inline" placeholder="Cari nama bahan baku"  class="form-control" id="nama_bahan_baku">
						</td>
					</tr>
					<tr>
						<td>Jumlah pesan</td>
						<td><input step=".01"  type="number" min="0" style="width:250px; display: inline;"   class="form-control" id="jumlah" placeholder="Jumlah pesan " />
						<input type="text" readonly style="width:120px; display: inline;" class="form-control" id="id_satuan" placeholder="Satuan" />
						</td>
					</tr>
					<tr>
						<td>Subtotal Harga</td>
						<td><input type="number" min="0" style="width:250px;"   class="form-control" id="harga" placeholder="Harga pesan " /></td>
					</tr>
					<tr>
						<td> </td>
						<td>
							<button type="button" onclick="addDetail()" class="btn btn-primary">Tambah Detail Pemesanan</button> 
						</td>
					</tr>
					
					<tr>
						<td colspan="2">
							<table class="table table-bordered table-hover table-striped">
								<thead>
									<tr>
										<th>Id Bahan Baku</th>
										<th>Nama Bahan Baku</th>
										<th>Jumlah Pesan</th>
										<th>Satuan</th>
										<th>Harga / Satuan</th>
										<th>Subtotal</th>
										<th>Hapus</th>
									</tr>
								</thead>
								<tbody id="detail_pesan">
								</tbody>
							</table>
						</td>
					</tr>
					<tr>
						<td> </td>
						<td>
							<button type="submit" name="simpan" class="btn btn-success" onclick="return cekSave();">Simpan</button> 
 							<a href="pemesanan_bahan.php" class="btn btn-danger">Batal</a>
						</td>
					</tr>
				</tbody>
				<tfoot>	<!-- bagian bawah table -->
				</tfoot>
			</table>
		</div>
		</form>
	</div>
	<!-- akhir bagian isi -->
	

	<?php include("footer.php"); ?>

</body>
</html>