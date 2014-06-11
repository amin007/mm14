<?php 
//print_r($this->url);
//print_r($this->cariApa); 
//print_r($this->carian); 

if ($this->carian=='[id:0]')
{
	echo 'data kosong<br>';
}
else 
{ // $this->carian=='newss' - mula
	$cariBatch = (!isset($this->_cariBatch)) ? null : $this->_cariBatch; 
?>
<h1>Ubah BatchAwal : <?=$cariBatch?><br>
<small>Nota: <?=$this->error?></small></h1>
<?php if ($cariBatch != null):?>
<form method="POST" action="<?php echo URL ?>batch/ubahSimpan/">
<?php else: echo null; endif; 

foreach ($this->cariApa as $myTable => $row)
{
	if ( count($row)==0 )
		echo '';
	else
	{
		$mula2 = ''; //($jadual=='rangka13') ? ' active' : '';
	?>
	<div class="tab-pane<?php echo $mula2?>" id="<?php echo $myTable ?>">
	<?php //echo $this->halaman[$myTable] ?>
<!-- Jadual <?php echo $myTable ?> ########################################### -->
<table border="1" class="excel" id="example">
<?php
// mula bina jadual
$printed_headers = false; 
#-----------------------------------------------------------------
for ($kira=0; $kira < count($row); $kira++)
{	//print the headers once: 	
	if ( !$printed_headers ) 
	{
		?><thead><tr><th>#</th><?php
		foreach ( array_keys($row[$kira]) as $tajuk ) 
		{	// anda mempunyai kunci integer serta kunci rentetan
			// kerana cara PHP mengendalikan tatasusunan.
				?><th><?php echo $tajuk ?></th><?php 			
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
		$tabline = "\n\t\t\t\t\t";
		$tabline2 = "\n\t\t\t\t";
		if ($key=='newss')
		{
			$id = $data; 
			$k1 = URL . 'kawalan/ubah/' . $id;
			$class = 'btn btn-primary btn-mini';
			?><td><?php echo $data ?></td><?php echo "\n";
		}
		elseif(in_array($key,array('nossm')))
		{
			$input = ''
				   //. '<div class="controls">' . $tabline
			       . '<div class="input-prepend input-append">' . $tabline
				   //. '<span class="add-on">$</span>' . $tabline
				   . '<input type="text" name="' . $key . '[' . $id . ']"' 
				   . ' value="' . $data . '"'
				   . ' class="span2" id="appendedPrependedInput">' . $tabline
				   . '<span class="add-on">' . $data . '</span>'
				   //. '</div>'
				   . '</div>';
			?><td valign="top"><?php echo $input ?></td><?php echo "\n";
		}
		elseif(in_array($key,array('respon','msic2008','kp')))
		{ 
			$input = '<div class="input-prepend input-append">' . $tabline
				   . '<span class="add-on">' . $data . '</span>' . $tabline
				   . '<input type="text" name="' . $key . '[' . $id . ']"' 
				   . ' value="' . $data . '"'
				   . ' class="span1">'
				   . $tabline2 . '</div>'
				   //. '<pre>' . $data . '</pre>'
				   . '';
			?><td valign="top"><?php echo $input ?></td><?php echo "\n";
		}
		elseif(in_array($key,array('nota','data_tahunan')))
		{ 
			$input = '' //'<div class="input-prepend input-append">' . $tabline
				   //. '<span class="add-on">' . $data . '</span>' . $tabline
				   . '<textarea class="input-xlarge" id="textarea" rows="3"'
				   . ' name="' . $key . '[' . $id . ']" >'
				   //. '<input type="text" name="' . $key . '[' . $id . ']"' 
				   . $data . '</textarea>'
				   //. $tabline2 . '</div>'
				   . $tabline2 . '<pre>' . $data . '</pre>'
				   . '';
			?><td valign="top"><?php echo $input ?></td><?php echo "\n";
		}
		elseif(in_array($key,array('tentang_staf')))
		{
			$namaMedan = array('pengurusan','juruteknik','kerani','operatif','asas');
			$tambah = 1; $input = $tabline . '<table>';
			
			foreach($namaMedan as $medanApa)
			{
				$input .= $tabline . '<tr><td valign="center">'
					   . $medanApa
					   . "</td>$tabline<td>"
					   . '<input type="text" name="bil_' . $medanApa . '[' . $id . ']"' 
					   . ' class="span1">'
					   . "</td>$tabline<td>"
					   . '<input type="text" name="gaji_' . $medanApa . '[' . $id . ']"' 
					   . ' class="span2">'
					   //. $tabline2 . '</div>'
					   . '</td></tr>' . "\n";
			}	$input .= '</table>';
			
			?><td valign="top"><?php echo $input ?></td><?php echo "\n";
		}
		elseif(in_array($key,array('bil_staf')))
		{
			?><td valign="top"><?php echo "<table>\n\t<tr><td>" .
				$data . "\n\t</td></tr></table>\n" ?></td><?php echo "\n";
		}
		else
		{
			?><td><?php echo $data ?></td><?php echo "\n";
		}
	} 

	//<a href="$p2" class="btn btn-danger btn-mini">
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
 
<?php if ($cariBatch != null):?>
<input type="hidden" name="batchAwal" value="<?=$this->_cariBatch?>">
<input type="hidden" name="cariSemua" value="<?=$this->_cariSemua?>">
<input type="submit" name="Simpan" value="Simpan" class="btn btn-primary btn-large">
</form>
<?php else: echo null; endif; ?>
<?php } // $this->carian=='sidap' - tamat ?>