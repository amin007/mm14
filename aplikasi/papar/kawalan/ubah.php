<?php 
function cariInput($rangka,$kira,$key,$data)
{
    /*
    0-nota,1-respon,2-fe
    3-tel,4-fax,5-responden,6-email
    7-msic,8-msic08,9-id U M
    10-nama,11-ssm,12-utama
    */
	// istihar pembolehubah 
	$name = 'name="' . $rangka . '[' . $key . ']"';
	//if ($key=='noahli') $id = $data; 
	//if ( in_array($key,$textbox) )
	if ($key=='nota' || $key=='catatan')
	{//sebab
		$input = '<textarea ' . $name . ' rows="1" cols="20">' 
			   . $data . '</textarea>';
	}
	elseif($key=='respon')
	{//msic
		$input = '<input type="text" ' . $name . ' value="' 
			   . $data . '" class="input-mini" >';
	}
	elseif(in_array($key,array('fe','tel','fax','responden','email')))
	{//msic
		$input = '<input type="text" ' . $name . ' value="' 
			   . $data . '" class="input-medium" >';
	}
	elseif(in_array($key,array('msic','msic08')))
	{//msic
		$input = '<input type="text" ' . $name . ' value="' 
			   . $data . '" class="input-mini" >';
	}
	else
	{
		$papar_data = ($data==null) ? '' : '<span class="label">' . $data . '</span>';
		$input=$papar_data.'&nbsp;';
		//$input = '<input type="text" ' . $name . ' value="' 
		//. $data . '" class="input-small" >';
	}

	// medan yang tak perlu dipaparkan
	$lepas = array('ssm','utama');
	$papar_data = ($data==null) ? '' : '<span class="label">' . $data . '</span>';
	echo (in_array($key,$lepas)) ? '' : 
	(    ($key == 'newss') ?
		$input : // kalau bukan $key==newss    
		'<span class="add-on"><i class="icon icon-remove"></i></span>' .
		$input
	);
}

function paparInputBulanan($bulan,$row,$kira,$key,$data)
{
	$s1 = '<span class="label">';
    $s2 = '</span>';
	$name = 'name="' . $bulan . '[' . $key . ']"';
	$tandaX = 'name="' . $bulan . '[' . $key . 'x]"';
	//if ($key=='noahli') $id = $data; 
	//if ( in_array($key,$textbox) )
	if ($key=='newss')
	{
		$input = $s1 . $row[$kira]['newss'] . '|<br>'
			   . $row[$kira]['nama'] . $s2;
	}
	elseif ( in_array($key,array('msic','web','staf','outlet','respon')) )
	{//msic
		$input = '<input type="text" ' . $name . ' value="' 
			   . $data . '" class="input-micro" >';
	}
	elseif ( in_array($key,array('terima','hantar')) )
	{//terima - style="font-family:sans-serif;font-size:10px;"
		$input = '<input type="text" ' . $name . ' value="' . $data . '" '
			   . 'class="input-date tarikh" readonly>'
			   . '<input type="checkbox" ' . $tandaX . ' value="x">';
	}
	elseif ($key=='nota')
	{//sebab
		$input = '<textarea ' . $name . ' rows="1" cols="20">' 
			   . $data . '</textarea>';
	}
	else
	{	//$input=$bulan.'-'.$data.'&nbsp;';    $input=$data;
		$input = '<input type="text" ' . $name . ' value="' 
			   . $data . '" class="input-small" >';
	}
	
	return $input;
}
// mula untuk kod php+html
function papar_jadual($row, $myTable, $pilih)
{
    if ($pilih == 1)
    {
        ?><!-- Jadual <?php echo $myTable ?> ########################################### -->
        <table  border="1" class="excel" id="example">
        <?php
        // mula bina jadual
        $printed_headers = false;
        #-----------------------------------------------------------------
        for ($kira=0; $kira < count($row); $kira++)
        {
            //print the headers once:  
            if ( !$printed_headers )
            {
                ?><thead><tr>
        <th>#</th>
        <?php
                foreach ( array_keys($row[$kira]) as $tajuk )
                {
                    // anda mempunyai kunci integer serta kunci rentetan
                    // kerana cara PHP mengendalikan tatasusunan.
                    ?><th><?php echo $tajuk ?></th>
        <?php    
                }
        ?></tr></thead>
        <?php
                $printed_headers = true;
            }
        #-----------------------------------------------------------------      
            //print the data row
            ?><tbody><tr>
            <td><?php echo $kira+1 ?></td>
            <?php foreach ( $row[$kira] as $key=>$data ) : ?>
            <td><?php echo $data ?></td>
            <?php endforeach; ?>
        </tr></tbody>
        <?php
        }
        #-----------------------------------------------------------------
        ?>
        </table>
        <!-- Jadual <?php echo $myTable ?> ########################################### --><?php
    }
    elseif ($pilih == 2)
    {
        ?><!-- Jadual <?php echo $myTable ?> ########################################### -->
        <table class="table table-striped">
        <?php
        // mula bina jadual
        $printed_headers = false;
        #-----------------------------------------------------------------
        for ($kira=0; $kira < count($row); $kira++)
        {
            //print the headers once:  
            if ( !$printed_headers )
            {
                ?><thead><tr>
        <th>#</th>
        <?php
                foreach ( array_keys($row[$kira]) AS $tajuk )
                {
                // anda mempunyai kunci integer serta kunci rentetan
                // kerana cara PHP mengendalikan tatasusunan.
                    $paparTajuk = ($tajuk=='keterangan') ?
                    $tajuk . ' (jadual:' . $myTable . ')'
                    : $tajuk;
                    ?><th><?php echo $paparTajuk ?></th>
        <?php   
                }
        ?></tr></thead>
        <?php
                $printed_headers = true;
            }
        #-----------------------------------------------------------------      
            //print the data row ?>
            <tbody><tr>
            <td><?php echo $kira+1 ?></td>
            <?php foreach ( $row[$kira] as $key=>$data ) : ?>
            <td><?php echo $data ?></td>
            <?php endforeach; ?>
        </tr></tbody>
        <?php
        }
        #-----------------------------------------------------------------
        ?>
        </table>
        <!-- Jadual <?php echo $myTable ?> ########################################### --><?php
    }
    elseif ($pilih == 3)
    {
        ?><!-- Jadual <?php echo $myTable ?> ########################################### --><?php
            for ($kira=0; $kira < count($row); $kira++)
            {//print the data row
            #-----------------------------------------------------------------
            ?><table border="1" class="excel" id="example">
        <caption><?php echo $myTable ?></caption>
        <tbody><?php foreach ( $row[$kira] as $key=>$data ) :?>
        <tr>
        <td><span class="label"><?php echo $key ?></span></td>
        <td><?php echo $data ?></td>
        </tr><?php endforeach ?>
        </tbody>
        </table>
        <?php
            }// final print the data row
            #-----------------------------------------------------------------
        ?><!-- Jadual <?php echo $myTable ?> ########################################### --><?php
    } // tamat if (jadual ==3
 
}
// tamat untuk kod php+html 

function paparData($cariIndustri, $kira, $key, $data)
{
	if($key != 'msic'): echo $data;
	else:
		//echo 'papar jadual untuk msic=' . $data . ' |<br>';
		foreach ($cariIndustri as $myTable => $bilang)
		{// mula ulang $bilang
			papar_jadual($bilang, $myTable, $pilih=2);
		}// tamat ulang $bilang
		
	endif;
}

/*
echo '<pre>';
//echo '<br>$this->kesID:<br>'; print_r($this->kesID);
echo '<br>$this->rangka:<br>'; print_r($this->rangka);
//echo '<br>$this->carian:<br>'; print_r($this->carian); 
echo '</pre>';
*/

// set pembolehubah
$mencari = URL . 'kawalan/ubahCari/' . $this->cari;
$carian = $this->cari;

?>
<h1>Ubah Data Bulanan</h1>
<div align="center"><form method="POST" action="<?php echo $mencari ?>" autocomplete="off">
<font size="5" color="red">&rarr;</font><br>
<input type="text" name="cari" size="40" value="<?=$carian;?>" 
id="inputString" onkeyup="lookup(this.value);" onblur="fill();">
<input type="submit" value="mencari">
<div class="suggestionsBox" id="suggestions" style="display: none; " >
	<div class="suggestionList" id="autoSuggestionsList">&nbsp;</div>
</div>
</form></div>

<?php 
if ($this->carian=='[tiada id diisi]')
{
    echo 'data kosong<br>';
}
else
{ // $this->carian=='sidap' - mula
    $cari = $this->carian;
    $s1 = '<span class="label">';
    $s2 = '</span>';
    
    // isytihar pembolehubah untuk sistem sms
	$rangka = 'rangka14';
	//$newss = $this->kesID['jan13'][0]['newss'];
	$newss = $this->rangka['kes'][0]['newss'];
    $sykt  = urlencode($this->rangka['kes'][0]['nama']);
    $kawan = urlencode($this->rangka['kes'][0]['fe']);
    $hantar_sms = URL . 'pengguna/smskes/' . $kawan . '/' . $sykt;
	
?>
<form method="post" action="<?php echo URL?>kawalan/ubahSimpan/<?php echo $newss ?>"> 
<!-- jadual rangka ########################################### -->
<?php
foreach ($this->rangka as $myTable => $row)
{// mula ulang $row
    for ($kira=0; $kira < count($row); $kira++)
    {//print the data row
    #-----------------------------------------------------------------
    ?><table class="table table-striped">
    <tbody><?php foreach ($row[$kira] as $key=>$data): ?>
    <tr>
    <td><span class="label"><?php echo $key ?></span></td>
    <td><?php cariInput($rangka, $kira, $key, $data) ?>&nbsp;</td>
    <td><?php paparData($this->cariIndustri, $kira, $key, $data) ?>&nbsp;</td>
    </tr><?php endforeach ?>
    </tbody>
    </table>
    <?php
    }// final print the data row
    #-----------------------------------------------------------------
}// tamat ulang $row
?>
<hr border="9"><!-- jadual data ########################################### -->
<a target='_blank' href="<?php echo $hantar_sms ?>" class="btn btn-primary btn-large">Hantar sms</a>
<table border="1" class="table table-bordered table-striped">
<tr><?php echo $this->paparTajuk; ?></tr>
<?php
foreach ($this->kesID as $myTable => $row)
{// mula ulang $row
#-----------------------------------------------------------------
    // mula bina jadual
    for ($kira=0; $kira < count($row); $kira++)
    {//print the data row // bgcolor='#ffffff' ?><tr>
<td><?php echo $s1 . $myTable . '<br>' . $row[$kira]['fe'] . $s2 ?></td>
<?php
        $bulan = $myTable;
		// medan yang tak perlu dipaparkan
		$lepas = array('nama','utama','fe',);

        //$textbox = array('nota');
        foreach ( $row[$kira] as $key=>$data ) 
        {
            $input = paparInputBulanan($bulan,$row,$kira,$key,$data);
            $papar_data = ($data==null) ? '' : '<span class="label">' . $data . '</span>';
            echo (in_array($key,$lepas)) ? '' : 
            (    ($key == 'newss') ?
                '<td>' . $input . '</td>' : // kalau bukan $key==newss                
                "\n" . '<td>' // . '<div class="input-prepend">' . $input 
                //. '<span class="add-on"><i class="icon- icon-remove"></i></span></div>'
                . $input . $papar_data . '</td>'
            );
        } 
?>
</tr>
<?php
    } 
#-----------------------------------------------------------------
}// tamat ulang $row
?>
</table>
<input type="submit" name="Simpan" value="Simpan" class="btn btn-primary btn-large">
</form>
<hr>
<?php } // $this->carian=='sidap' - tamat ?>
