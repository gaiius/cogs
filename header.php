	<!-- bagian atas -->
	<header>
		<nav class="navbar navbar-default navbar-inverse">
		  <div class="container-fluid" style="">
			<!-- Brand and toggle get grouped for better mobile display -->
			<div class="navbar-header ">
			  <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			  </button>
			<a class="navbar-brand"  href="index.php"  >Hans Bakery</a>
			 <!--<a class="navbar-brand" href="index.php"><img style="padding-top: 0px; margin-top: -10px;" src="image/logo.png" height="80" /></a>-->
			</div>

			<!-- Collect the nav links, forms, and other content for toggling -->
			
			<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1"  style="">
			  <ul class="nav navbar-nav">
			  <?php	
				if(isset($_SESSION["hans_id_pengguna"]))
				{
					if($_SESSION["hans_jenis_pengguna"] == "manajer")
					{
				?>
				<li <?php if(isset($namahalaman) && $namahalaman=="beranda") { echo 'class="active"'; } ?>><a href="beranda.php">Beranda</a></li>
				<li <?php if(isset($namahalaman) && $namahalaman=="master") { echo 'class="active"'; } ?> class="dropdown">
				  <a href="master_data.php" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Master Data <span class="caret"></span></a>
				  <ul class="dropdown-menu">
					<li><a href="bahan_baku.php">Bahan</a></li>
					<li><a href="roti.php">Roti</a></li>
					<li><a href="satuan.php">Satuan</a></li>
					<li role="separator" class="divider"></li>
					<li><a href="supplier.php">Supplier</a></li>
					<li><a href="overhead.php">Overhead</a></li>
					<li role="separator" class="divider"></li>
					<li><a href="pengguna.php">Pengguna</a></li>
				  </ul>
				</li>
				<li <?php if(isset($namahalaman) && $namahalaman=="pembelian") { echo 'class="active"'; } ?> class="dropdown">
				  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Pembelian <span class="caret"></span></a>
				  <ul class="dropdown-menu">
					<li><a href="pemesanan_bahan.php">Pemesanan Bahan</a></li>
					<li><a href="pembelian.php">Pembelian</a></li>
					<li><a href="pembayaran_hutang.php">Pembayaran Hutang</a></li>
					<li><a href="retur_pembelian.php">Retur Pembelian</a></li>
				  </ul>
				</li>
				<li <?php if(isset($namahalaman) && $namahalaman=="produksi") { echo 'class="active"'; } ?>><a href="produksi.php">Produksi</a></li>
				<li <?php if(isset($namahalaman) && $namahalaman=="penyesuaianstok") { echo 'class="active"'; } ?>><a href="penyesuaian_stok.php">Penyesuaian Stok</a></li>
				<li <?php if(isset($namahalaman) && $namahalaman=="laporan") { echo 'class="active"'; } ?> class="dropdown">
				  <a href="laporan.php" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Laporan <span class="caret"></span></a>
				  <ul class="dropdown-menu">
					<li><a href="laporan_stok_bahan_baku.php">Stok Bahan Baku</a></li>
					<li><a href="laporan_bill_of_material.php">Bill of  Material</a></li>
					<li><a href="laporan_pembelian.php">Pembelian</a></li>
					<li><a href="laporan_produksi_harian.php">Produksi Harian</a></li>
					<li><a href="laporan_kartu_stok_bahan_baku.php">Kartu Stok Bahan Baku</a></li>
				  </ul>
				</li>
				<?php
					}
					else if($_SESSION["hans_jenis_pengguna"] == "supervisor")
					{
				?>
				<li><a href="beranda.php">Beranda</a></li>
				<li class="dropdown">
				  <a href="master_data.php" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Master Data <span class="caret"></span></a>
				  <ul class="dropdown-menu">
					<li><a href="bahan_baku.php">Bahan</a></li>
					<li><a href="roti.php">Roti</a></li>
					<li><a href="satuan.php">Satuan</a></li>
					<li role="separator" class="divider"></li>
					<li><a href="supplier.php">Supplier</a></li>
					<li><a href="overhead.php">Overhead</a></li>
				  </ul>
				</li>
				<li class="dropdown">
				  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Pembelian <span class="caret"></span></a>
				  <ul class="dropdown-menu">
					<li><a href="pemesanan_bahan.php">Pemesanan Bahan</a></li>
					<li><a href="pembelian.php">Pembelian</a></li>
					<li><a href="pembayaran_hutang.php">Pembayaran Hutang</a></li>
					<li><a href="retur_pembelian.php">Retur Pembelian</a></li>
				  </ul>
				</li>
				<li><a href="produksi.php">Produksi</a></li>
				<li><a href="penyesuaian_stok.php">Penyesuaian Stok</a></li>
				<li class="dropdown">
				  <a href="laporan.php" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Laporan <span class="caret"></span></a>
				  <ul class="dropdown-menu">
					<li><a href="laporan_stok_bahan_baku.php">Stok Bahan Baku</a></li>
					<li><a href="laporan_bill_of_material.php">Bill of  Material</a></li>
					<li><a href="laporan_pembelian.php">Pembelian</a></li>
					<li><a href="laporan_produksi_harian.php">Produksi Harian</a></li>
					<li><a href="laporan_kartu_stok_bahan_baku.php">Kartu Stok Bahan Baku</a></li>
				  </ul>
				
				<?php
					}
					else if($_SESSION["hans_jenis_pengguna"] == "karyawan")
					{
				?>
				<li><a href="beranda.php">Beranda</a></li>
				<li><a href="produksi.php">Produksi</a></li>
				<?php
					}
				}
				?>
				
			  </ul>
			
			  <ul class="nav navbar-nav navbar-right">
			<?php
			
				if(isset($_SESSION["hans_id_pengguna"]))
				{
			?>
				<li><a href="logout.php">Logout</a></li>
			<?php	
				}
			?>
			  </ul>
			</div><!-- /.navbar-collapse -->
		  </div><!-- /.container-fluid -->
		</nav>
	</header>