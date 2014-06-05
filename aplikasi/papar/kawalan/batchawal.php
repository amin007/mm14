<?php 
//print_r($this->url);
//print_r($this->cariApa); 
//print_r($this->carian); 
//print_r($this->error); 
//print_r($this->cariBatch); 
//print_r($this->cariID); 
//print_r($this->carian); 


if ($this->carian=='[id:0]')
{
	echo 'data kosong<br>';
}
else
{ // $this->carian=='newss' - mula
	$carian = (!isset($this->cariID)) ? null : $this->cariID;
	$cariBatch = (!isset($this->cariBatch)) ? null : $this->cariBatch;
	$mencari = URL . 'batch/ubahBatchAwal/' . $cariBatch;
	$cetakF3 = URL . 'laporan/cetakf3/' . $cariBatch;
	$cetakF3semua = URL . 'laporan/cetakf3semua/' . $cariBatch . "/500";
	$halaman = (!isset($this->halaman)) ? null : $this->halaman;
	//echo $halaman . '<br>';
?>
<h3><a target="_blank" href="<?=$cetakF3semua?>">Cetak F3 Semua</a></h3>
<h1>Ubah BatchAwal : <?=$cariBatch?><br>
<small>Nota: <?=$this->error?></small></h1>
<div align="center"><form method="GET" action="<?=$mencari?>" class="form-inline" autocomplete="off">
<div class="form-group"><div class="input-group">
	<input type="text" name="cari" class="form-control" autofocus
	id="inputString" onkeyup="lookup(this.value);" onblur="fill();">
	<span class="input-group-addon">
	<input type="submit" value="Kemaskini">
	</span>
</div></div>
<div class="suggestionsBox" id="suggestions" style="display: none; " >
	<div class="suggestionList" id="autoSuggestionsList">&nbsp;</div>
</div>
</form></div><br>

<?php 
foreach ($this->cariApa as $myTable => $row)
{
	if ( count($row)==0 )
		echo '';
	else
	{
	?>
	<!-- Jadual <?php echo $myTable ?> ########################################### -->	
	<span class="badge badge-success"><?php echo $myTable ?></span>
	<span class="badge"><?php echo count($row) ?></span>
	<table border="1" class="excel" id="example">
	<?php
	// mula bina jadual
	$printed_headers = false; 
	#-----------------------------------------------------------------
	for ($kira=0; $kira < count($row); $kira++)
	{
		//print the headers once: 	
		if ( !$printed_headers ) 
		{
			?><thead><tr><th>#</th><?php
			foreach ( array_keys($row[$kira]) as $tajuk ) 
			{ 
				if ($tajuk=='newss')
				{
					?><th>Tindakan</th><?php
				}
				// anda mempunyai kunci integer serta kunci rentetan
				// kerana cara PHP mengendalikan tatasusunan.
				if ( !is_int($tajuk) ) 
				{ 
					?><th><?php echo $tajuk ?></th><?php
				} 
			}
			?></tr></thead>
	<?php
			$printed_headers = true; 
		} 
	#-----------------------------------------------------------------		 
		//print the data row 
		?><tbody><tr><td><?php echo $kira+1 ?></td><?php
		foreach ( $row[$kira] as $key=>$data ) 
		{		
			if ($key=='newss')
			{
				$id = $data; 
				$k1 = URL . "kawalan/ubah/$id";
				$cb = URL . "batch/buangBatchAwal/$cariBatch/$id";

				?><td><?php
				?><a target="_blank" href="<?php echo $k1 ?>" class="btn btn-primary btn-mini">Ubah</a><?php
				?><a href="<?php echo $cb ?>" class="btn btn-danger btn-mini">Kosong</a><?php
				?></td><td><?php echo $data ?></td><?php
			}
			elseif ($key=='batchAwal')
			{
				$k1 = URL . "batch/awal/$data";
				$t1 = str_replace(' ', '', huruf('Besar_Depan', $data) );
				//$k2 = URL . "batch/tukarBatch/$t1?asal=$data";
				$k2 = URL . "laporan/cetakf3semua/$data/500";
				if ($data == null) { ?><td>&nbsp;</td><?php }
				else
				{	?><td><?php
					?><a href="<?php echo $k1 ?>" class="btn btn-primary btn-mini"><?php echo $data ?></a><?php
					?><a target="_blank" href="<?php echo $k2 ?>" class="btn btn-danger btn-mini">Cetak</a><?php
					?></td><?php
				}
			}
			else
			{
				?><td><?php echo $data ?></td><?php
			}
		} 
		?></tr></tbody>
	<?php
	}
	#-----------------------------------------------------------------?>
	</table>
<!-- Jadual <?php echo $myTable ?> ########################################### -->		
<?php
	} // if ( count($row)==0 )
}

?>	
 
<?php } // $this->carian=='newss'' - tamat ?>