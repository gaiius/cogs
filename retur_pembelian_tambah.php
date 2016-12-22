<?php
	require_once("connect.php");
	
	//jika belum login -> kembalikan ke halaman login
	if(!isset($_SESSION["hans_id_pengguna"]))
	{
		?><script>alert('Silahkan login dahulu');</script><?php
		?><script>document.location.href='index.php';</script><?php
		die(0);
	}
	
	$id_retur_pembelian = createId("retur_pembelian","id_retur_pembelian","RB",5);
	$tanggal_retur_pembelian = date("Y-m-d");
	$id_pembelian ="";
	$id_supplier = "";
	
	$data_id_bahan_baku = array();
	$data_nama_bahan_baku = array();
	$data_jumlah_retur = array();
	$data_id_satuan = array();
	
	if(isset($_POST["simpan"]))
	{
		$id_retur_pembelian = $_POST["id_retur_pembelian"];
		$id_pembelian = $_POST["id_pembelian"];
		$tanggal_retur_pembelian = balikTanggal($_POST["tanggal_retur_pembelian"]);
		/*$id_supplier = $_POST["id_supplier"];
		$total = $_POST["total"];*/
		
		$error = 0;
		
		//pengecekan error
		
		
		if($error == 0)
		{
			$query = "insert into retur_pembelian(id_retur_pembelian,tanggal_retur_pembelian,id_pembelian,status_retur) values
							('$id_retur_pembelian','$tanggal_retur_pembelian','$id_pembelian','Belum diganti')";
			mysql_query($query);
			//echo $query;
			//die(0);
		
			
			
			$data_id_bahan_baku = $_POST["id_bahan_baku"];
			$data_nama_bahan_baku = $_POST["nama_bahan_baku"];
			$data_jumlah = $_POST["jumlah"];
			$data_id_satuan = $_POST["id_satuan"];
			for($i=0; $i<count($data_id_bahan_baku); $i++)
			{
				$id_bahan_baku = $data_id_bahan_baku[$i];
				$jumlah = $data_jumlah[$i];
				
				
				
				
				$query = "insert into detail_retur_pembelian(id_retur_pembelian,id_bahan_baku,jumlah_retur) values ('$id_retur_pembelian','$id_bahan_baku','$jumlah')";
				mysql_query($query);
				$query = "update detail_pembelian set jumlah_diretur=jumlah_diretur + '$jumlah' where id_bahan_baku='$id_bahan_baku' and id_pembelian='$id_pembelian'";
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
					$jumlah_retur = $jumlah * $konversi;
					$stok_baru = $stok - $jumlah_retur;
					$query = "update bahan_baku set stok='$stok_baru' where id_bahan_baku='$id_bahan_baku'";
					mysql_query($query);
				}
			}
			
			?><script>alert("Data berhasil ditambah");</script>
			<script>document.location.href='retur_pembelian.php'</script><?php
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
				/*total = 0;
				for(i=0; i<jumlah_baris; i++)
				{
					if($("#item_"+i).length > 0)
					{
						
						total += parseFloat($("#subtotal_"+i).val()); 
						
					}
				}
				$("#total").val(total);*/
			}
			
			loadDetail = function(){
				$.post("ajax_get_detail_pembelian.php",{
					"id_pembelian": $("#id_pembelian").val()
				},function(data){
					$("#detail_beli").html(data.data);
					jumlah_baris = data.jumlah_baris;
					hitungTotal();
				},"json");
				
			}
			$("#id_pembelian").change(function(e){
				loadDetail();
			});
			
			/*loadDataPembelian = function(){
				$.post("ajax_get_pembelian.php",{
					"id_supplier": $("#id_supplier").val()
				},function(data){
					$("#id_pembelian").html(data);
					loadDetail();
				});
			}*/
			
			/*$("#id_supplier").change(function(e){
				loadDataPembelian();
			});
			
			
			editDetail = function(i){
				
				subtotal = "";
				$("#subtotal_"+i.toString()).val(subtotal);
				jumlah=parseFloat($("#jumlah_"+i.toString()).val());
				harga=parseFloat($("#harga_"+i.toString()).val());
				subtotal = jumlah*harga;
				$("#subtotal_"+i.toString()).val(subtotal);
				hitungTotal();
			}*/
			
			deleteDetail = function(i){
				
				$("#item_"+id.toString()).remove();
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
					ada_yang_isi = 0;
					for(i=0; i<jumlah_baris; i++)
					{
						//alert($("#jumlah_"+i).val());
						if(parseInt($("#jumlah_"+i).val()) > 0)
						{
							ada_yang_isi = 1;
							
						}
					}
					
					
					if(ada_yang_isi == 1)
					{
						return confirm('Simpan data ?');
					}
					else{
						
							alert('Detail retur tidak boleh kosong');
							return false;
					}
				}
			}
			
			
		});
	</script>
</head>
<body>
	
	<?php include("header.php"); ?>
	
	<!-- bagian isi -->
	<div class="content container-fluid">
		<h3>Retur Pembelian</h3>
		<br/>
		<form action="" method="post">
		<div  >
			<table class="table table-bordered table-striped table-hover ">
				<thead>	<!-- kop table -->
				</thead>
				</tbody> <!-- isi table -->
					<tr>
						<td style="width:150px;">Id Retur Pembelian</td>
						<td><input required readonly style="width:150px"; class="form-control" name="id_retur_pembelian" id="id_retur_pembelian" placeholder="Id Pembelian" value="<?php echo $id_retur_pembelian; ?>" /></td>
					</tr>
					<tr>
						<td>Tanggal Pembelian</td>
						<td><input style="width: 150px" required class="datepicker form-control" name="tanggal_retur_pembelian" id="tanggal_retur_pembelian" placeholder="Tanggal Pembelian" value="<?php echo balikTanggal($tanggal_retur_pembelian); ?>" /></td>
					</tr>
					<!--
					<tr>
						<td>Id supplier</td>
						<td><select style="width:300px";  required class="form-control" name="id_supplier" id="id_supplier">
							<option value="">Pilih Id supplier</option>
							<?php
								$query = "select * from supplier";
								$resultSatuan = mysql_query($query);
								while($rowSatuan = mysql_fetch_array($resultSatuan))
								{
									?><option value="<?php echo $rowSatuan["id_supplier"]; ?>" <?php if($rowSatuan["id_supplier"] == $id_supplier) { echo "selected"; } ?> ><?php echo $rowSatuan["nama_supplier"]; ?></option><?php 
								}
							?>
						</select></td>
					</tr>
					-->
					<tr>
						<td>Id Pembelian</td>
						<td><select style="width:400px";  required class="form-control" name="id_pembelian" id="id_pembelian">
							<option value="">Pilih Nota Pembelian</option>
							<?php
								$tgl1bln = date("Y-m-d",time()-(30*24*3600));
								$query = "select * from pembelian inner join supplier on pembelian.id_supplier=supplier.id_supplier where tanggal_pembelian >= '$tgl1bln'";
								$resultPembelian = mysql_query($query);
								while($rowPembelian = mysql_fetch_array($resultPembelian))
								{
									?><option value="<?php echo $rowPembelian["id_pembelian"]; ?>" <?php if($rowPembelian["id_pembelian"] == $id_pembelian) { echo "selected"; } ?> ><?php echo $rowPembelian["id_pembelian"].", Tgl: ".balikTanggal($rowPembelian["tanggal_pembelian"]).", Supplier: ".$rowPembelian["nama_supplier"]; ?></option><?php 
								}
							?>
						</select></td>
					</tr>
					<tr>
						<td colspan="2"></td>
					</tr>
					<tr>
						<td colspan="2"><h4>Detail Retur Pembelian</h4></td>
					</tr>
					
					<tr>
						<td colspan="2">
							<table class="table table-bordered table-hover table-striped">
								<thead>
									<tr>
										<th>Id Bahan Baku</th>
										<th>Nama Bahan Baku</th>
										<th>Jumlah Retur</th>
										<th>Satuan</th>
										<th>Max Retur</th>
									</tr>
								</thead>
								<tbody id="detail_beli">
								</tbody>
							</table>
						</td>
					</tr>
					<tr>
						<td> </td>
						<td>
							<button type="submit" name="simpan" class="btn btn-success" onclick="return cekSave();">Simpan</button> 
 							<a href="retur_pembelian.php" class="btn btn-danger">Batal</a>
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