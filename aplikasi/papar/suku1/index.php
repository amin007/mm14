<style type="text/css">table.excel {	border-style:ridge;	border-width:1;	border-collapse:collapse;	font-family:sans-serif;	font-size:11px;}table.excel thead th, table.excel tbody th {	background:#CCCCCC;	border-style:ridge;	border-width:1;	text-align: center;	vertical-align: top;}table.excel tbody th { text-align:center; vertical-align: top; }table.excel tbody td { vertical-align:bottom; }table.excel tbody td { 	padding: 0 3px; border: 1px solid #aaaaaa;	background:#ffffff;}</style><?php //echo '<br>$this->senaraiData:'; print_r($this->senaraiData); //this->medanID => $this->lihat->medanID ='username';// $this->cariID => $this->lihat->cariID  = $sesi['pengguna'];$tajuk = 'Data QSS SUKU 1';$pautan = URL . 'suku1/';// papar_jadual($row, $myTable, 1);?><div class="wall">	<h1><?php //echo $tajuk ?></h1><?php foreach ($this->senaraiData as $myTable => $row):?>		<table  border="1" class="excel" id="example"><?php		// mula bina jadual		$printed_headers = false; 		#-----------------------------------------------------------------		for ($kira=0; $kira < count($row); $kira++)		{	//print the headers once: 				if ( !$printed_headers ) : ?>		<thead><tr>		<th>#</th><?php foreach ( array_keys($row[$kira]) as $key=>$tajuk ) :		?><th><?php echo $tajuk ?></th>		<?php endforeach; ?>		<th>Tindakan</th>		</tr></thead>		<?php	$printed_headers = true; 			endif;		#-----------------------------------------------------------------		 		//print the data row ?>		<tbody><tr>		<td><?php echo $kira+1 ?></td>			<?php foreach ( $row[$kira] as $key=>$data ) : 			// cari $id dalam jadual $myTable 			// dan buat pautan untuk ubah/buang/cetak			if ($key==$this->medanID) 			{				$id = $key . '/' . $data; 				$p1 = $pautan . 'asing/' . $id;				$p2 = $pautan . 'rangka/' . $id;				$ubah = $pautan . 'ubah/' . $id;			}			elseif ($key=='nama') 			{				$nama = $key . '=' . $data; 			}		?><td><?php echo huruf('kecil', $data) ?></td><?php endforeach; ?>		<td><?php if (isset($this->cetak) && $this->cetak!='cetak'):?>			<a target="_blank" href="<?php echo $p1 ?>" class="btn btn-info btn-mini">			<i class="icon-filter icon-white"></i>Asing <?php echo $nama?></a><br>			<a target="_blank" href="<?php echo $ubah ?>" class="btn btn-primary btn-mini">			<i class="icon-pencil icon-white"></i>Ubah <?php echo $nama?></a><br>			<a target="_blank" href="<?php echo $p2 ?>" class="btn btn-success btn-mini">			<i class="icon-print icon-white"></i>Export <?php echo $nama ?></a><?php endif; ?>		</td>		</tr></tbody>		<?php		}		#-----------------------------------------------------------------		?></table><?php endforeach; // tamat ?></div><!-- container -->