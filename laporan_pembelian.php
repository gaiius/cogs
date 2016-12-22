<?php
	require_once("connect.php");
	
	//jika belum login -> kembalikan ke halaman login
	if(!isset($_SESSION["hans_id_pengguna"]))
	{
		?><script>alert('Silahkan login dahulu');</script><?php
		?><script>document.location.href='index.php';</script><?php
		die(0);
	}
	
	$tanggal_awal = date("Y-m-d");
	$tanggal_akhir = date("Y-m-d");
	$id_supplier = "";
	$nama_supplier = "";
	$id_bahan_baku= "";
	$nama_bahan_baku = "";
	
	if(isset($_POST["cari"]))
	{
		$tanggal_awal = balikTanggal($_POST["tanggal_awal"]);
		$tanggal_akhir = balikTanggal($_POST["tanggal_akhir"]);
		$id_supplier =$_POST["id_supplier"];
		$nama_supplier =$_POST["nama_supplier"];
		$id_bahan_baku =$_POST["id_bahan_baku"];
		$nama_bahan_baku =$_POST["nama_bahan_baku"];
	
	}
?>
<!doctype html>
<html lang="en">
<head>
	<?php include("head.php"); ?>
<script>
	$(function(){
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
					}
					else
					{
						$("#id_bahan_baku").val(ui.item.id_bahan_baku);
						$("#nama_bahan_baku").val(ui.item.nama_bahan_baku);
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
		<h3>Laporan Pembelian</h3>
		<form action="" method="post">
			<table class="table table-bordered table-striped table-hover ">
				</tbody> <!-- isi table -->
					<tr>
						<td style="width:150px;">Periode</td>
						<td><input style="width: 150px; display: inline;" required class="datepicker form-control" name="tanggal_awal" id="tanggal_awal" placeholder="Tanggal Awal" value="<?php echo balikTanggal($tanggal_awal); ?>" />
						s/d
						<input style="width: 150px; display: inline;" required class="datepicker form-control" name="tanggal_akhir" id="tanggal_akhir" placeholder="Tanggal Akhir" value="<?php echo balikTanggal($tanggal_akhir); ?>" /></td>
					</tr>
					<tr style="display:none">
						<td>Supplier</td>
						<td>
							<input type="text" readonly style="width:100px; display:inline" placeholder="Id Supplier"  class="form-control" name="id_supplier" id="id_supplier" value="<?php echo $id_supplier; ?>">
							<input type="text"  style="width:300px; display:inline" placeholder="Cari nama supplier.."  class="form-control" name="nama_supplier" id="nama_supplier" value="<?php echo $nama_supplier; ?>">
							<span style="color:red">* kosong = semua supplier</span>
						</td>
					</tr>
					<tr >
						<td>Bahan Baku</td>
						<td>
							<input type="text" readonly style="width:100px; display:inline" placeholder="Id Bahan Baku"  class="form-control" name="id_bahan_baku" id="id_bahan_baku" value="<?php echo $id_bahan_baku; ?>">
							<input type="text"  style="width:300px; display:inline" placeholder="Cari nama bahan baku.."  class="form-control" name="nama_bahan_baku" id="nama_bahan_baku" value="<?php echo $nama_bahan_baku; ?>">
							<span style="color:red">* kosong = semua bahan</span>
						</td>
					</tr>
					<tr>
						<td> </td>
						<td>
							<button type="submit" name="cari" class="btn btn-success">Cari</button> 
						</td>
					</tr>
				</tbody>
				<tfoot>	<!-- bagian bawah table -->
				</tfoot>
			</table>	
		</form>
		
		<button class="btn btn-primary no-print" onclick="window.print()">Cetak</button>
		<br/>
		<br/>
		<div >
			<table class="table table-bordered table-striped table-hover">
				<thead>	<!-- kop table -->
					<tr>
						<th style="width: 100px;">Id Pembelian</th>
						<th style="width: 100px;">Tanggal Pembelian</th>
						<th style="width: 200px;">Supplier</th>
						<th style="width: 100px;">Bahan Baku</th>
						<th style="width: 100px;">Jumlah</th>
						<th style="width: 100px;">Satuan</th>
						<th style="width: 100px;">Harga</th>
						<th style="width: 100px;">Sub Total</th>
					</tr>
				</thead>
				</tbody> <!-- isi table -->
				<?php
					
					$filter = " where tanggal_pembelian >= '$tanggal_awal' and tanggal_pembelian <= '$tanggal_akhir' ";
					if($id_supplier != "")
					{
						$filter .= " and pembelian.id_supplier='$id_supplier'";
					}
					if($id_bahan_baku != "")
					{
						$filter .= " and detail_pembelian.id_bahan_baku='$id_bahan_baku'";
					}
					$query = "select * from pembelian 
									inner join supplier on pembelian.id_supplier=supplier.id_supplier
									inner join detail_pembelian on pembelian.id_pembelian=detail_pembelian.id_pembelian
									inner join bahan_baku on detail_pembelian.id_bahan_baku=bahan_baku.id_bahan_baku $filter"; //ambil smua data table satuan
					$result = mysql_query($query); //eksekusi query
					while($row = mysql_fetch_array($result)) //loop setiap baris data
					{
				?>
					<tr>
						<td><?php echo $row["id_pembelian"]; ?></td>
						<td><?php echo balikTanggal($row["tanggal_pembelian"]); ?></td>
						<td><?php echo $row["nama_supplier"]; ?></td>
						<td><?php echo $row["nama_bahan_baku"]; ?></td>
						<td style="text-align: right"><?php echo number_format($row["jumlah"],2,",","."); ?></td>
						<td><?php echo $row["satuan_beli"]; ?></td>
						<td style="text-align: right"><?php echo number_format($row["harga"],2,",","."); ?></td>
						<td style="text-align: right"><?php echo number_format($row["subtotal"],2,",","."); ?></td>
					</tr>
				<?php
					}
					
				?>
				</tbody>
				<tfoot>	<!-- bagian bawah table -->
				</tfoot>
			</table>
		</div>
	</div>
	<!-- akhir bagian isi -->
	

	<?php include("footer.php"); ?>

</body>
</html>