<?php
	require_once("connect.php");
	
	//jika belum login -> kembalikan ke halaman login
	if(!isset($_SESSION["hans_id_pengguna"]))
	{
		?><script>alert('Silahkan login dahulu');</script><?php
		?><script>document.location.href='index.php';</script><?php
		die(0);
	}
	
	$id_produksi = createId("produksi","id_produksi","PR",5);
	$id_detail_produksi = $id_produksi;
	$tanggal_produksi = date("Y-m-d");
	$id_roti ="";
	$nama_roti ="";
	$jumlah ="0";
	$total_overhead = 0;
	$total_bahan_baku = 0;
	$total_hpp = 0;
	$status_produksi ="Finish";
	$data_id_roti = array();
	$data_nama_roti = array();
	$data_jumlah = array();
	$id_pengguna = $_SESSION["hans_id_pengguna"];
	
	if(isset($_POST["simpan"]))
	{
		$id_produksi = $_POST["id_produksi"];
		$tanggal_produksi = balikTanggal($_POST["tanggal_produksi"]);
		$id_roti = $_POST["id_roti"];
		$nama_roti = $_POST["nama_roti"];
		$jumlah = $_POST["jumlah"];
		$total_overhead = $_POST["total_overhead"];
		$total_bahan_baku = $_POST["total_bahan_baku"];
		$total_hpp = $_POST["total_hpp"];
		$error = 0;
		
		//pengecekan error
		
		
		if($error == 0)
		{
			$query = "insert into produksi(id_produksi,tanggal_produksi,status_produksi,id_pengguna) values ('$id_produksi','$tanggal_produksi','$status_produksi','$id_pengguna')";
			mysql_query($query);
			
			
			$query = "insert into detail_produksi(id_detail_produksi,id_produksi,id_roti,jumlah,total_bahan_baku,total_overhead,total_hpp) values
					('$id_detail_produksi','$id_produksi','$id_roti','$jumlah','$total_bahan_baku','$total_overhead','$total_hpp')";
			mysql_query($query);
			
			
			//detail bhaan_baku
			$data_id_bahan_baku = $_POST["id_bahan_baku"];
			$data_nama_bahan_baku = $_POST["nama_bahan_baku"];
			$data_jumlah_bahan_baku = $_POST["jumlah_bahan_baku"];
			$data_id_satuan = $_POST["id_satuan"];
			$data_harga_bahan_baku = $_POST["harga_bahan_baku"];
			$data_subtotal_bahan_baku = $_POST["subtotal_bahan_baku"];
			for($i=0; $i<count($data_id_bahan_baku); $i++)
			{
				$id_bahan_baku = $data_id_bahan_baku[$i];
				$jumlah_bahan_baku = $data_jumlah_bahan_baku[$i];
				$harga_bahan_baku = $data_harga_bahan_baku[$i];
				$subtotal_bahan_baku = $data_subtotal_bahan_baku[$i];
				
				
				$query = "insert into detail_produksi_bahan_baku(id_detail_produksi,id_bahan_baku,jumlah_bahan_baku,harga_bahan_baku,sub_total_bahan_baku) values 
						('$id_detail_produksi','$id_bahan_baku','$jumlah_bahan_baku','$harga_bahan_baku','$subtotal_bahan_baku')";
				mysql_query($query);
				
				
				$query = "update bahan_baku set stok=stok-'$jumlah_bahan_baku' where id_bahan_baku='$id_bahan_baku'";
				mysql_query($query);
				
				$query = "update roti set stok='$jumlah' where id_roti='$id_roti'";
				mysql_query($query);
			}
			
			//detail overhead
			$data_id_overhead = $_POST["id_overhead"];
			$data_nama_overhead = $_POST["nama_overhead"];
			$data_jumlah_overhead = $_POST["jumlah_overhead"];
			$data_satuan_overhead = $_POST["satuan_overhead"];
			$data_harga_overhead = $_POST["harga_overhead"];
			$data_subtotal_overhead = $_POST["subtotal_overhead"];
			for($i=0; $i<count($data_id_overhead); $i++)
			{
				$id_overhead = $data_id_overhead[$i];
				$jumlah_overhead = $data_jumlah_overhead[$i];
				$harga_overhead = $data_harga_overhead[$i];
				$subtotal_overhead = $data_subtotal_overhead[$i];
				
				
				$query = "insert into detail_produksi_overhead(id_detail_produksi,id_overhead,jumlah_overhead,harga_overhead,sub_total_overhead) values 
						('$id_detail_produksi','$id_overhead','$jumlah_overhead','$harga_overhead','$subtotal_overhead ')";
				mysql_query($query);
				
				
			}
			
			?><script>alert("Data berhasil ditambah");</script>
			<script>document.location.href='produksi.php'</script><?php
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
			var jumlah_overhead = 0;
			
			hitungTotalBahan = function(){
				total = 0;
				for(i=0; i<jumlah_baris; i++)
				{
					if($("#item_"+i).length > 0)
					{
						
						total += parseFloat($("#subtotal_bahan_baku_"+i).val()); 
						
					}
				}
				$("#total_bahan_baku").val(total);
				hitungTotalHPP();
			}
			
			hitungTotalOverhead = function(){
				total_overhead = 0;
				for(i=0; i<jumlah_overhead; i++)
				{
					if($("#item_overhead_"+i).length > 0)
					{
						
						total_overhead += parseFloat($("#subtotal_overhead_"+i).val()); 
						
					}
				}
				$("#total_overhead").val(total_overhead);
				hitungTotalHPP();
			}
			
			hitungTotalHPP = function(){
				total_bahan_baku = 0;
				total_bahan_baku = parseFloat($("#total_bahan_baku").val());
				total_overhead = 0;
				total_overhead = parseFloat($("#total_overhead").val());
				total_hpp = total_bahan_baku + total_overhead;
				$("#total_hpp").val(total_hpp);
			}
			
			
			
			loadDetailBahan = function(){
				$.post("ajax_get_detail_resep.php",{
					"jumlah": $("#jumlah").val(),
					"id_roti": $("#id_roti").val()
				},function(data){
					$("#detail_bahan").html(data.data);
					jumlah_baris = data.jumlah_baris;
					hitungTotalBahan();
				},"json");
				
			}
			$("#jumlah").change(function(e){
				loadDetailBahan();
			});
			
			$("#id_overhead").change(function(e){
				
				harga_overhead = $("#id_overhead").find('option:selected').attr("data_harga");
				satuan_overhead = $("#id_overhead").find('option:selected').attr("data_satuan");
				$("#harga_overhead").val(harga_overhead);
				$("#satuan_overhead").val(satuan_overhead);
				
			});
			
			addDetailOverhead = function(){
				id_overhead = $("#id_overhead").val();
				jumlah = $("#jumlah_overhead").val();
				nama_overhead = $("#id_overhead").find('option:selected').attr("data_nama");
				harga_overhead = $("#harga_overhead").val();
				satuan_overhead = $("#satuan_overhead").val();
				
				if(id_overhead == "")
				{
					alert('Overhead belum dipilih');
					return false;				
				}
				if(jumlah == "")
				{
					alert('Jumlah produksi belum diisi');
					return false;				
				}
				
				for(i=0; i<jumlah_overhead; i++)
				{
					if($("#item_overhead_"+i).length > 0)
					{
						if($("#id_overhead_"+i).val() == id_overhead)
						{
							alert('Overhead sudah ada');
							return false;
						}
					}
				}
				
				subtotal_overhead = parseFloat(jumlah) * parseFloat(harga_overhead);
				tambah = '';
				tambah += '<tr id="item_overhead_'+jumlah_overhead.toString()+'">'; //start row
			
				tambah += '<td><input class="form-control" type="text" readonly data-input-name="id_overhead" name="id_overhead[]" id="id_overhead_'+jumlah_overhead+'" value="'+id_overhead+'" /></td>';
				tambah += '<td><input class="form-control" type="text" readonly data-input-name="nama_overhead" name="nama_overhead[]" id="nama_overhead_'+jumlah_overhead+'" value="'+nama_overhead+'" /></td>';
				tambah += '<td><input class="form-control" step=".01" min="0" required style="width:150px;" type="number" data-input-name="jumlah_overhead" name="jumlah_overhead[]" id="jumlah_overhead_'+jumlah_overhead+'" value="'+jumlah+'" onchange="editDetailOverhead('+jumlah_overhead+')" /></td>';
				tambah += '<td><input class="form-control" type="text" readonly data-input-name="satuan_overhead" name="satuan_overhead[]" id="satuan_overhead_'+jumlah_overhead+'" value="'+satuan_overhead+'" /></td>';
				tambah += '<td><input class="form-control" type="text" readonly data-input-name="harga_overhead" name="harga_overhead[]" id="harga_overhead_'+jumlah_overhead+'" value="'+harga_overhead+'" /></td>';
				tambah += '<td><input class="form-control" type="text" readonly data-input-name="subtotal_overhead" name="subtotal_overhead[]" id="subtotal_overhead_'+jumlah_overhead+'" value="'+subtotal_overhead+'" /></td>';
				tambah += '<td><button type="button" class="btn btn-danger" onclick="deleteDetailOverhead('+jumlah_overhead+')"><i class="glyphicon glyphicon-remove"></i> Item</button>';
				tambah += '</tr>';
				$("#detail_overhead").append(tambah);
				jumlah_overhead++;
				$("#id_overhead").val("");
				$("#jumlah_overhead").val("");
				$("#harga_overhead").val("");
				$("#satuan_overhead").val("");
				
				hitungTotalOverhead();	
			}
			
			
			editDetailOverhead = function(i){
				
				
				subtotal_overhead = "";
				jumlah_overhead=parseFloat($("#jumlah_overhead_"+i.toString()).val());
				harga_overhead=parseFloat($("#harga_overhead_"+i.toString()).val());
				subtotal_overhead = jumlah_overhead*harga_overhead;
				$("#subtotal_overhead_"+i.toString()).val(subtotal_overhead);
				hitungTotalOverhead();
			}
			
			deleteDetailOverhead = function(i){
				
				$("#item_overhead_"+i.toString()).remove();
				hitungTotalOverhead();
			}
			
			editDetail = function(i){
				subtotal_bahan_baku = "";
				jumlah_bahan_baku=parseFloat($("#jumlah_bahan_baku_"+i.toString()).val());
				harga_bahan_baku=parseFloat($("#harga_bahan_baku_"+i.toString()).val());
				
				
				subtotal_bahan_baku = Math.round(jumlah_bahan_baku*harga_bahan_baku*100)/100;
				$("#subtotal_bahan_baku_"+i.toString()).val(subtotal_bahan_baku);
				hitungTotalBahan();
			}
			
			deleteDetail = function(i){
				
				$("#item_"+i.toString()).remove();
				hitungTotalBahan();
			}
			
			hitungTotalBahan();
			hitungTotalOverhead();
			
			
			cekSave = function(){
				jumlah_bahan = $("input[data-input-name='id_bahan_baku']").length;
				//alert(jumlah_kodebarang);
				if(jumlah_bahan <= 0)
				{
					alert('Detail pemakaian bahan masih kosong');
					return false;
				}
				else
				{
					//cek stok
					var cukup = 1;
					for(i=0; i<jumlah_baris; i++)
					{
						if($("#item_"+i).length > 0)
						{
							if(parseFloat($("#jumlah_bahan_baku_"+i).val()) > parseFloat($("#stok_"+i).val()))
							{
								alert('Stok bahan baku tidak mencukupi');
								cukup = 0;
								return false;
							}
						}
					}
					
					if(cukup == 0)
					{
						alert('stok tidak cukup');
						return false;
					}
					else
					{
						return confirm('Simpan data ?');
					}
					
				}
			}
			
			$("#nama_roti").autocomplete({
				source: function( request, response ) {
					$.ajax({
						url: "ajax_get_roti.php",
						dataType: "json",
						type: "post",
						data: {
							cari: request.term
						},
						success: function( data ) {
							
							response( $.map( data, function( item ) {
								return {
									label: item.id_roti + ' - ' + item.nama_roti,
									value: item.nama_roti,
									id_roti: item.id_roti,
									nama_roti: item.nama_roti,
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
						$("#nama_roti").val("");
						$("#id_roti").val("");
						loadDetailBahan();
					}
					else
					{
						$("#id_roti").val(ui.item.id_roti);
						$("#nama_roti").val(ui.item.nama_roti);
						loadDetailBahan();
					}
				},
				search: function( event, ui ) {
					
				}
			})
			.blur(function(){
				if($("#id_roti").val() == "")
				{
					$("#id_roti").val("");
					$("#nama_roti").val("");
						loadDetailBahan();
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
		<h3>Produksi Roti</h3>
		<br/>
		<form action="" method="post">
		<div  >
			<table class="table table-bordered table-striped table-hover ">
				<thead>	<!-- kop table -->
				</thead>
				</tbody> <!-- isi table -->
					<tr>
						<td style="width:150px;">Id Produksi</td>
						<td><input required readonly style="width:150px"; class="form-control" name="id_produksi" id="id_produksi" placeholder="Id Roti" value="<?php echo $id_produksi; ?>" /></td>
					</tr>
					<tr>
						<td>Tanggal Produksi</td>
						<td><input style="width:150px;" required class="datepicker form-control" name="tanggal_produksi" id="tanggal_produksi" placeholder="Nama Roti" value="<?php echo balikTanggal($tanggal_produksi); ?>" /></td>
					</tr>
					<tr>
						<td>Roti</td>
						<td>
							<input type="text" required readonly style="width:100px; display:inline" placeholder="Id roti"  class="form-control" name="id_roti" id="id_roti" value="<?php echo $id_roti; ?>">
							<input type="text"  style="width:300px; display:inline" placeholder="Cari nama roti"  class="form-control" name="nama_roti" id="nama_roti" value="<?php echo $nama_roti; ?>">
						
						</td>
					</tr>
					<tr>
						<td>Jumlah produksi</td>
						<td><input   type="number" min="0" style="width:250px; display: inline;"   class="form-control" name="jumlah" id="jumlah" placeholder="Jumlah produksi " value="<?php echo $jumlah; ?>" />
						</td>
					</tr>
				</tbody>
			</table>	
			<br/>
			<table class="table table-bordered table-striped table-hover ">
					<tr>
						<td colspan="2"><h4>Detail Bahan Baku</h4></td>
					</tr>
					
					<tr>
						<td colspan="2">
							<table class="table table-bordered table-hover table-striped">
								<thead>
									<tr>
										<th>Id Bahan Baku</th>
										<th>Nama Bahan Baku</th>
										<th>Stok</th>
										<th>Jumlah Pemakaian</th>
										<th>Satuan</th>
										<th>Harga Average</th>
										<th>Sub total</th>
										<th>Hapus</th>
									</tr>
								</thead>
								<tbody id="detail_bahan">
								</tbody>
							</table>
						</td>
					</tr>
					<tr>
						<td>Total Bahan Baku</td>
						<td><input   type="text" readonly required style="width:250px; display: inline;"   class="form-control" id="total_bahan_baku" name="total_bahan_baku" placeholder="Total Bahan Baku " value="<?php echo $total_bahan_baku; ?>" />
						</td>
					</tr>
			</table>		
			<br/>
			<table class="table table-bordered table-striped table-hover ">
				<tbody>
					<tr>
						<td colspan="2"><h4>Detail Overhead</h4></td>
					</tr>
					<tr>
						<td>Id Overhead</td>
						<td><select style="width:300px";  class="form-control" id="id_overhead">
							<option value="">Pilih Overhead</option>
							<?php
								$query = "select * from overhead";
								$resultBahan = mysql_query($query);
								while($rowBahan = mysql_fetch_array($resultBahan))
								{
									?><option value="<?php echo $rowBahan["id_overhead"]; ?>" data_nama="<?php echo $rowBahan["nama_overhead"]; ?>" data_harga="<?php echo $rowBahan["biaya_overhead"]; ?>" data_satuan="<?php echo $rowBahan["satuan_overhead"]; ?>"  ><?php echo $rowBahan["nama_overhead"]; ?></option><?php 
								}
							?>
						</select></td>
					</tr>
					<tr>
						<td>Jumlah overhead</td>
						<td><input step=".01"  type="number" min="0" style="width:250px; display: inline;"   class="form-control" id="jumlah_overhead" placeholder="Jumlah overhead " />
						<input type="text"  readonly style="width:250px; display: inline"   class="form-control" id="satuan_overhead" placeholder="Satuan overhead " />
						</td>
					</tr>
					<tr>
						<td>Harga </td>
						<td><input type="text" min="0" readonly style="width:250px; display: inline"   class="form-control" id="harga_overhead" placeholder="Harga overhead " />
							
						</td>
					</tr>
					<tr>
						<td> </td>
						<td>
							<button type="button" onclick="addDetailOverhead()" class="btn btn-primary">Tambah Detail Overhead</button> 
						</td>
					</tr>
					
					<tr>
						<td colspan="2">
							<table class="table table-bordered table-hover table-striped">
								<thead>
									<tr>
										<th>Id Overhead</th>
										<th>Nama Overhead</th>
										<th>Jumlah</th>
										<th>Satuan</th>
										<th>Harga</th>
										<th>Subtotal</th>
										<th>Hapus</th>
									</tr>
								</thead>
								<tbody id="detail_overhead">
								</tbody>
							</table>
						</td>
					</tr>
					<tr>
						<td>Total Overhead</td>
						<td><input   type="text" readonly required style="width:250px; display: inline;"   class="form-control" id="total_overhead" name="total_overhead" placeholder="Total Overhead " value="<?php echo $total_overhead; ?>" />
						</td>
					</tr>
					<tr>
						<td>Total HPP</td>
						<td><input   type="text" readonly required style="width:250px; display: inline;"   class="form-control" id="total_hpp" name="total_hpp" placeholder="Total HPP " value="<?php echo $total_hpp; ?>" />
						</td>
					</tr>
					
					<tr>
						<td> </td>
						<td>
							<button type="submit" name="simpan" class="btn btn-success" onclick="return cekSave();">Simpan</button> 
 							<a href="produksi.php" class="btn btn-danger">Batal</a>
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