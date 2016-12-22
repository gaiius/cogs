<?php
	require_once("connect.php");
	$namahalaman = "beranda";
	
	//jika belum login -> kembalikan ke halaman login
	if(!isset($_SESSION["hans_id_pengguna"]))
	{
		?><script>alert('Silahkan login dahulu');</script><?php
		?><script>document.location.href='index.php';</script><?php
		die(0);
	}
	
	$bulan_1 = date("m");
	$tahun_1 = date("Y");
	$id_bahan_baku="";
	$nama_bahan_baku = "";
	if(isset($_POST["laporan_1"]))
	{
		$bulan_1 = $_POST["bulan_1"];
		$tahun_1 = $_POST["tahun_1"];
		$id_bahan_baku = $_POST["id_bahan_baku"];
		$nama_bahan_baku = $_POST["nama_bahan_baku"];
	}
	$tgl_1 = strtotime($tahun_1."-".$bulan_1."-01");
?>
<!doctype html>
<html lang="en">
<head>
	<?php include("head.php"); ?>
	
	<script src="highcharts/js/highcharts.js"></script>
	<script>
		$(function(){
			
			
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
				if($("#nama_bahan_baku").val() == "")
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
		Selamat datang <?php echo $_SESSION["hans_nama_pengguna"]; ?>
	</div>
	<br/>
		<form action="" method="post">
			<table class="table table-bordered table-striped table-hover ">
				</tbody> <!-- isi table -->
					<tr>
						<td style="width:150px;">Periode</td>
						<td><select style="width: 200px; display: inline;" required class="datepicker form-control" name="bulan_1" id="bulan_1" >
							<?php
								for($i=0; $i<count($daftar_bulan); $i++)
								{
									?><option value="<?php echo ($i+1); ?>" <?php if($bulan_1 == $i+1) { echo "selected";} ?>><?php echo $daftar_bulan[$i]; ?></option><?php
								}
							?>
						</select>
						
						<input type="number" style="width: 100px; display: inline;" required class="form-control" name="tahun_1" id="tahun_1" placeholder="Tahun" value="<?php echo $tahun_1; ?>" /></td>
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
							<button type="submit" name="laporan_1" class="btn btn-success">Cari</button> 
						</td>
					</tr>
			</table>	
		</form>
		<div class="row">
			<div class="col-md-6">
				<div id="chart1" style="width:95%; height: 400px;"></div>
			</div>
			<div class="col-md-6">
				<div id="chart2" style="width:95%; height: 400px;"></div>
			</div>
		</div>
	<?php
		$categories_1 = "";
		$data_1 = "";
		$categories_2 = "";
		$data_2 = "";
		for($i=1; $i<intval(date("t",$tgl_1)); $i++)
		{
			if($i > 1)
			{
				$categories_1 .= ",";
				$data_1 .= ",";
				$categories_2 .= ",";
				$data_2 .= ",";
			}
			$categories_1 .= "'$i'";
			$filter=" where pembelian.tanggal_pembelian='".date("Y-m-d",strtotime($tahun_1."-".$bulan_1."-".$i))."' ";
			if($id_bahan_baku != "")
			{
				$filter .= " and detail_pembelian.id_bahan_baku='$id_bahan_baku'";
			}
			$total_beli = 0;
			$qty_beli = 0;
			$query = "select sum(detail_pembelian.subtotal) as total,sum(detail_pembelian.jumlah) as jumlah from pembelian 
							inner join supplier on pembelian.id_supplier=supplier.id_supplier
							inner join detail_pembelian on pembelian.id_pembelian=detail_pembelian.id_pembelian
							inner join bahan_baku on detail_pembelian.id_bahan_baku=bahan_baku.id_bahan_baku $filter"; //ambil smua data table satuan
			$result1 = mysql_query($query); //eksekusi query
			if($row1 = mysql_fetch_array($result1)) //loop setiap baris data
			{
				if(isset($row1["total"]))
				{
					$total_beli = $row1["total"];
				}
				if(isset($row1["jumlah"]))
				{
					$qty_beli = $row1["jumlah"];
				}
			}
			$data_1 .= $total_beli;
			$data_2 .= $qty_beli;
		}
	?>
	<script>
		$(function(){
			 $('#chart1').highcharts({
				title: {
					text: 'Nilai Pembelian bulan <?php echo $daftar_bulan[$bulan_1-1]." ".$tahun_1; ?>',
					x: -20 //center
				},
				subtitle: {
					text: '<?php
						if($id_bahan_baku == ""){
							echo "Semua Bahan Baku";
						}
						else{
							echo 'Bahan : '.$nama_bahan_baku;
						}
					?>',
					x: -20
				},
				xAxis: {
					categories: [<?php echo $categories_1; ?>]
				},
				yAxis: {
					title: {
						text: 'Total Pembelian (Rupiah)'
					},
					plotLines: [{
						value: 0,
						width: 1,
						color: '#808080'
					}]
				},
				tooltip: {
					valueSuffix: ''
				},
				legend: {
					layout: 'vertical',
					align: 'right',
					verticalAlign: 'middle',
					borderWidth: 0
				},
				series: [{
					name: 'Pembelian',
					data: [<?php echo $data_1; ?>]
				}]
			});
			
			
			 $('#chart2').highcharts({
				title: {
					text: 'Jumlah Pembelian bulan <?php echo $daftar_bulan[$bulan_1-1]." ".$tahun_1; ?>',
					x: -20 //center
				},
				subtitle: {
					text: '<?php
						if($id_bahan_baku == ""){
							echo "Semua Bahan Baku";
						}
						else{
							echo 'Bahan : '.$nama_bahan_baku;
						}
					?>',
					x: -20
				},
				xAxis: {
					categories: [<?php echo $categories_2; ?>]
				},
				yAxis: {
					title: {
						text: 'Total Jumlah Pembelian'
					},
					plotLines: [{
						value: 0,
						width: 1,
						color: '#808080'
					}]
				},
				tooltip: {
					valueSuffix: ''
				},
				legend: {
					layout: 'vertical',
					align: 'right',
					verticalAlign: 'middle',
					borderWidth: 0
				},
				series: [{
					name: 'Qty Pembelian',
					data: [<?php echo $data_2; ?>]
				}]
			});
		});
	</script>
	<hr style="border-top: 1px solid #999;"/>
	<h4>Hutang</h4>
	<table class="table table-bordered table-striped table-hover  table-sort">
		<thead>	<!-- kop table -->
			<tr>
				<th style="width: 100px;">Id Pembelian</th>
				<th style="width: 100px;">Tanggal Beli</th>
				<th style="width: 100px;">Supplier</th>
				<th style="width: 100px;">Total Pembelian</th>
				<th style="width: 100px;">Sisa Hutang</th>
				<th style="width: 100px;">Jatuh Tempo</th>
			</tr>
		</thead>
		</tbody> <!-- isi table -->
		<?php
			$query = "select * from pembelian inner join supplier on pembelian.id_supplier=supplier.id_supplier
						where jenis_pembayaran='Kredit' 
							and total > dibayar
						order by tanggal_jatuh_tempo,tanggal_pembelian,id_pembelian"; //ambil smua data table satuan
						
			$result = mysql_query($query); //eksekusi query
			$total_sisa= 0;
			while($row = mysql_fetch_array($result)) //loop setiap baris data
			{
				$total_sisa += ($row["total"]-$row["dibayar"]);
		?>
			<tr>
				<td><?php echo $row["id_pembelian"]; ?></td>
				<td><?php echo balikTanggal($row["tanggal_pembelian"]); ?></td>
				<td><?php echo $row["nama_supplier"]; ?></td>
				<td style="text-align: right"><?php echo number_format($row["total"],2,",","."); ?></td>
				<td style="text-align: right"><?php echo number_format($row["total"]-$row["dibayar"],2,",","."); ?></td>
				<td><?php echo balikTanggal($row["tanggal_jatuh_tempo"]); ?></td>
			</tr>
		<?php
			}
			
		?>
		</tbody>
		<tfoot>	<!-- bagian bawah table -->
			<tr>
				<th colspan="4">Total Hutang</th>
				<th style="text-align:right;"><?php echo number_format($total_sisa,2,",","."); ?></th>
				<th></th>
			</tr>
		</tfoot>
	</table>
	<br/>
	<hr style="border-top: 1px solid #999;"/>
	<h4>Produksi Hari Ini</h4>
	<table class="table table-bordered table-striped table-hover table-sort">
		<thead>	<!-- kop table -->
			<tr>
				<th style="width: 100px;">Id Produksi</th>
				<th style="width: 100px;">Tanggal Produksi</th>
				<th style="width: 100px;">Roti</th>
				<th style="width: 100px;">Jumlah Produksi</th>
				<th style="width: 100px;">Total HPP</th>
				<th style="width: 100px;">HPP / Roti</th>
			</tr>
		</thead>
		</tbody> <!-- isi table -->
		<?php
			$filter = " where tanggal_produksi = '".date("Y-m-d")."' ";
			$query = "select * from produksi 
							inner join detail_produksi on produksi.id_produksi=detail_produksi.id_produksi
							inner join roti on detail_produksi.id_roti=roti.id_roti $filter"; //ambil smua data table satuan
			$result = mysql_query($query); //eksekusi query
			while($row = mysql_fetch_array($result)) //loop setiap baris data
			{
		?>
			<tr>
				<td><?php echo $row["id_produksi"]; ?></td>
				<td><?php echo balikTanggal($row["tanggal_produksi"]); ?></td>
				<td><?php echo $row["nama_roti"]; ?></td>
				<td style="text-align: right"><?php echo number_format($row["jumlah"],2,",","."); ?></td>
				<td style="text-align: right"><?php echo number_format($row["total_hpp"],2,",","."); ?></td>
				<td style="text-align: right"><?php echo number_format($row["total_hpp"]/$row["jumlah"],2,",","."); ?></td>
			</tr>
		<?php
			}
			
		?>
		</tbody>
		<tfoot>	<!-- bagian bawah table -->
		</tfoot>
	</table>
	
	<br/><br/>
	<p><!-- akhir bagian isi -->
	  
	  
	  <?php include("footer.php"); ?>
	  
</p>
	<?php	
		if(!isset($_SESSION["reminderHutang"]) )
		{
			$tgljt = date("Y-m-d",time()+(7*24*3600));
			$query = "select * from pembelian inner join supplier on pembelian.id_supplier=supplier.id_supplier
						where jenis_pembayaran='Kredit' 
							and total > dibayar
							and tanggal_jatuh_tempo <= '$tgljt'
						order by tanggal_jatuh_tempo,tanggal_pembelian,id_pembelian";
			$resultReminder = mysql_query($query);
			if(mysql_num_rows($resultReminder) > 0)
			{
				$_SESSION["reminderHutang"] = 1;
				?>
				
	<div class="modal fade" id="reminderModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog  modal-lg" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title" id="myModalLabel">Hutang Akan Jatuh Tempo</h4>
		  </div>
		  <div class="modal-body">
				<table class="table table-bordered table-striped table-hover  table-sort">
					<thead>	<!-- kop table -->
						<tr>
							<th style="width: 100px;">Id Pembelian</th>
							<th style="width: 100px;">Tanggal Beli</th>
							<th style="width: 100px;">Supplier</th>
							<th style="width: 100px;">Total Pembelian</th>
							<th style="width: 100px;">Sisa Hutang</th>
							<th style="width: 100px;">Jatuh Tempo</th>
						</tr>
					</thead>
					</tbody> <!-- isi table -->
					<?php
						$total_sisa= 0;
						while($row = mysql_fetch_array($resultReminder)) //loop setiap baris data
						{
							$total_sisa += ($row["total"]-$row["dibayar"]);
					?>
						<tr class="danger">
							<td><?php echo $row["id_pembelian"]; ?></td>
							<td><?php echo balikTanggal($row["tanggal_pembelian"]); ?></td>
							<td><?php echo $row["nama_supplier"]; ?></td>
							<td style="text-align: right"><?php echo number_format($row["total"],2,",","."); ?></td>
							<td style="text-align: right"><?php echo number_format($row["total"]-$row["dibayar"],2,",","."); ?></td>
							<td><?php echo balikTanggal($row["tanggal_jatuh_tempo"]); ?></td>
						</tr>
					<?php
						}
						
					?>
					</tbody>
					<tfoot>	<!-- bagian bawah table -->
						<tr>
							<th colspan="4">Total Hutang</th>
							<th style="text-align:right;"><?php echo number_format($total_sisa,2,",","."); ?></th>
							<th></th>
						</tr>
					</tfoot>
				</table>
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
		  </div>
		</div>
	  </div>
	</div>
	<script>
	$(function(){
		$("#reminderModal").modal('show');
	});
	</script>
				<?php
			}
		}
	?>
</body>
</html>