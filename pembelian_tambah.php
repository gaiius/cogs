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
	$id_pemesanan_bahan ="";
	$id_supplier = "";
	$nama_supplier="";
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
	
	if(isset($_POST["simpan"]))
	{
		$id_pembelian = $_POST["id_pembelian"];
		$id_pemesanan_bahan = $_POST["id_pemesanan_bahan"];
		$tanggal_pembelian = balikTanggal($_POST["tanggal_pembelian"]);
		$id_supplier = $_POST["id_supplier"];
		$nama_supplier = $_POST["nama_supplier"];
		$total = $_POST["total"];
		$jenis_pembayaran = $_POST["jenis_pembayaran"];
		if($jenis_pembayaran == "Tunai")
		{
			$dibayar = $total;
			$tanggal_jatuh_tempo = $tanggal_pembelian;
		}
		else
		{
			$dibayar = 0;
			$tanggal_jatuh_tempo = balikTanggal($_POST["tanggal_jatuh_tempo"]);
		}
		$error = 0;
		
		//pengecekan error
		
		
		if($error == 0)
		{
			$query = "insert into pembelian(id_pembelian,tanggal_pembelian,id_supplier,id_pemesanan_bahan,total,jenis_pembayaran,dibayar,tanggal_jatuh_tempo,id_pengguna) values
							('$id_pembelian','$tanggal_pembelian','$id_supplier','$id_pemesanan_bahan','$total','$jenis_pembayaran','$dibayar','$tanggal_jatuh_tempo','$id_pengguna')";
			mysql_query($query);
			
			
			$query = "update pemesanan_bahan set status_pemesanan_bahan='Finish' where id_pemesanan_bahan='$id_pemesanan_bahan'";
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
				
				
				
				
				$query = "insert into detail_pembelian(id_pembelian,id_bahan_baku,harga,jumlah,subtotal) values ('$id_pembelian_bahan','$id_bahan_baku','$harga','$jumlah','$subtotal')";
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
					$jumlah_beli = $jumlah * $konversi;
					$harga_beli = $harga / $konversi;
					
					$harga_average = (($harga_average * $stok)+($jumlah_beli*$harga_beli)) / ($stok + $jumlah_beli);
					$stok_baru = $stok + $jumlah_beli;
					$query = "update bahan_baku set harga_beli='$harga_beli',harga_average='$harga_average',stok='$stok_baru' where id_bahan_baku='$id_bahan_baku'";
					mysql_query($query);
				}
			}
			
			?><script>alert("Data berhasil ditambah");</script>
			<script>document.location.href='pembelian.php'</script><?php
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
			
			loadDetail = function(){
				$.post("ajax_get_detail_pemesanan_bahan.php",{
					"id_pemesanan_bahan": $("#id_pemesanan_bahan").val()
				},function(data){
					$("#detail_pesan").html(data.data);
					jumlah_baris = data.jumlah_baris;
					hitungTotal();
				},"json");
				
			}
			$("#id_pemesanan_bahan").change(function(e){
				loadDetail();
			});
			
			loadDataPemesanan = function(){
				$.post("ajax_get_pemesanan_bahan.php",{
					"id_supplier": $("#id_supplier").val()
				},function(data){
					$("#id_pemesanan_bahan").html(data);
					loadDetail();
				});
			}
			
			/*$("#id_supplier").change(function(e){
				loadDataPemesanan();
			});*/
			
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
			
			cekJenisPembayaran = function(){
				if($("#jenis_pembayaran").val() == "Tunai")
				{
					$(".data_kredit").hide();
				}
				else{
					
					$(".data_kredit").show();
				}
			}
			
			$("#jenis_pembayaran").change(function(e){
				cekJenisPembayaran();
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
						loadDataPemesanan();
					}
					else
					{
						$("#id_supplier").val(ui.item.id_supplier);
						$("#nama_supplier").val(ui.item.nama_supplier);
						loadDataPemesanan();
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
						loadDataPemesanan();
				}
			})
			.focus(function(){     
				$(this).autocomplete('search', '');
			});
			
			cekJenisPembayaran();
		});
	</script>
</head>
<body>
	
	<?php include("header.php"); ?>
	
	<!-- bagian isi -->
	<div class="content container-fluid">
		<h3>Pembelian Bahan</h3>
		<br/>
		<form action="" method="post">
		<div  >
			<table class="table table-bordered table-striped table-hover ">
				<thead>	<!-- kop table -->
				</thead>
				</tbody> <!-- isi table -->
					<tr>
						<td style="width:150px;">Id Pembelian</td>
						<td><input required readonly style="width:150px"; class="form-control" name="id_pembelian" id="id_pembelian" placeholder="Id Pembelian" value="<?php echo $id_pembelian_bahan; ?>" /></td>
					</tr>
					<tr>
						<td>Tanggal Pembelian</td>
						<td><input style="width: 150px" required class="datepicker form-control" name="tanggal_pembelian" id="tanggal_pembelian" placeholder="Tanggal Pembelian" value="<?php echo balikTanggal($tanggal_pembelian_bahan); ?>" /></td>
					</tr>
					<tr>
						<td>Supplier</td>
						<td>
							<input type="text" required readonly style="width:100px; display:inline" placeholder="Id Supplier"  class="form-control" name="id_supplier" id="id_supplier" value="<?php echo $id_supplier; ?>">
							<input type="text"  style="width:300px; display:inline" placeholder="Cari nama supplier"  class="form-control" name="nama_supplier" id="nama_supplier" value="<?php echo $nama_supplier; ?>">
						</td>
					</tr>
					<tr>
						<td>Id Pemesanan</td>
						<td><select style="width:300px";  required class="form-control" name="id_pemesanan_bahan" id="id_pemesanan_bahan">
							<option value="">Pilih Pemesanan</option>
							<?php
							?>
						</select></td>
					</tr>
					<tr>
						<td>Total</td>
						<td><input style="width:250px;" required readonly class="form-control" name="total" id="total" placeholder="total " value="<?php echo $total; ?>" /></td>
					</tr>
					<tr>
						<td>Jenis Pembayaran</td>
						<td><select style="width:100px;" required class="form-control" name="jenis_pembayaran" id="jenis_pembayaran" placeholder="Jenis Pembayaran ">
							<option value="Tunai" <?php if($jenis_pembayaran=="Tunai") { echo "selected"; } ?>>Tunai</option>
							<option value="Kredit" <?php if($jenis_pembayaran=="Kredit") { echo "selected"; } ?>>Kredit</option>
						</select></td>
					</tr>
					<tr class="data_kredit">
						<td>Tanggal Jatuh Tempo</td>
						<td><input style="width: 150px" required class="datepicker form-control" name="tanggal_jatuh_tempo" id="tanggal_jatuh_tempo" placeholder="Tanggal Jatuh Tempo" value="<?php echo balikTanggal($tanggal_jatuh_tempo); ?>" /></td>
					</tr>
					<tr>
						<td colspan="2"></td>
					</tr>
					<tr>
						<td colspan="2"><h4>Detail Pembelian</h4></td>
					</tr>
					
					<tr>
						<td colspan="2">
							<table class="table table-bordered table-hover table-striped">
								<thead>
									<tr>
										<th>Id Bahan Baku</th>
										<th>Nama Bahan Baku</th>
										<th>Jumlah</th>
										<th>Satuan</th>
										<th>Harga</th>
										<th>Subtotal</th>
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
 							<a href="pembelian.php" class="btn btn-danger">Batal</a>
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