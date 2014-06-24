<?php

class Kawalan_Tanya extends Tanya 
{

	public function __construct() 
	{
		parent::__construct();
	}

	public function kiraKes($sv, $myTable, $medan, $fe)
	{
		$carife = ( !isset($fe) ) ? '' : 
			(	($myTable=='rangka14') ?
				' WHERE fe = "' . $fe . '"'
				: 	' and c.fe = "' . $fe . '"'
			);
		$jadual = ($myTable=='rangka14') ? $sv . $myTable
			: $sv . $myTable
				. ' b, `mm_rangka14` as c WHERE b.newss = c.newss';

		$sql = 'SELECT ' . $medan . ' FROM ' . $jadual . $carife;
		
		//echo $sql . '<br>';
		$result = $this->db->rowCount($sql);
		//echo json_encode($result);
		
		return $result;
	}

	public function paparSemua($sv, $myTable, $medan, $fe, $jum)
	{
		$carife = ( !isset($fe) ) ? '' : 
			(	($myTable=='rangka14') ?
				' WHERE fe = "' . $fe . '"'
				: 	' and c.fe = "' . $fe . '"'
			);
		$jadual = ($myTable=='rangka14') ? $sv . $myTable
			: $sv . $myTable
				. ' b, `mm_rangka14` as c WHERE b.newss = c.newss';

		$sql = 'SELECT ' . $medan . ' FROM ' . $jadual . $carife;
		
		//echo $sql . '<br>';
		$result = $this->db->selectAll($sql);
		//echo json_encode($result);
		
		return $result;
	}

	public function kesSemua($sv, $myTable, $medan, $fe, $jum)
	{
		$carife = ( !isset($fe) ) ? '' : 
			(	
				($fe == 'xfe') ?
				(	($myTable=='rangka14') ?
					' WHERE c.fe is null '
					: 	' and c.fe is null '
				):	(
					($myTable=='rangka14') ?
					' WHERE c.fe = "' . $fe . '"'
					: 	' and c.fe = "' . $fe . '"'
				)
			);

		$jadual = ($myTable=='rangka14') ? '`' . $sv . $myTable . '` as c'
			: "\r" . $sv . $myTable 
				. ' as b, `mm_rangka14` as c WHERE b.newss = c.newss';

		$sql = 'SELECT ' . $medan . ' FROM ' . $jadual 
			. $carife
			. ' LIMIT ' . $jum['dari'] . ', ' . $jum['max'];

		//echo $sql . '<br>';
		$result = $this->db->selectAll($sql);
		//echo json_encode($result);
		
		return $result;
	}

	public function kesSelesai($sv, $myTable, $medan, $fe, $jum)
	{
		$carife = ( !isset($fe) ) ? '' : ' and b.fe = "' . $fe . '"';
		$jadual = //($myTable=='rangka13') ? $sv . $myTable :
			$sv . $myTable . ' b, `mm_rangka13` as c WHERE b.newss = c.newss';

		$sql = 'SELECT ' . $medan . ' FROM ' . $jadual
			 . ' and terima is not null ' . $carife 
			 . ' LIMIT ' . $jum['dari'] . ', ' . $jum['max'];

		//echo $sql . '<br>';
		$result = $this->db->selectAll($sql);
		//echo json_encode($result);
		
		return $result;
	}
	
	public function kesJanji($sv, $myTable, $medan, $fe, $jum)
	{
		$carife = ( !isset($fe) ) ? '' : ' and b.fe = "' . $fe . '"';

		$sql = 'SELECT ' . $medan . ' FROM ' . $sv . $myTable 
		     . ' b, `' . $sv .'rangka14` as c WHERE b.newss = c.newss '
			 . ' and (b.terima is null and c.respon != "A1") ' 
			 . $carife
			 . ' LIMIT ' . $jum['dari'] . ', ' . $jum['max'];

		//echo $sql . '<br>';
		$result = $this->db->selectAll($sql);
		//echo json_encode($result);
		
		return $result;
	}

	public function kesBelum($sv, $myTable, $medan, $fe, $jum)
	{
		$carife = ( !isset($fe) ) ? '' : ' and b.fe = "' . $fe . '"';

		$sql = 'SELECT ' . $medan . ' FROM ' . $sv . $myTable 
		     . ' b, `mm_rangka14` as c WHERE b.newss = c.newss '
			 //. ' and (b.terima is null or b.terima like "0000%") ' 
			 . ' and b.respon is null ' 
			 . $carife
			 . ' LIMIT ' . $jum['dari'] . ', ' . $jum['max'];

		//echo $sql . '<br>';
		$result = $this->db->selectAll($sql);
		//echo json_encode($result);
		
		return $result;
	}

	public function kesTegar($sv, $myTable, $medan, $fe, $jum)
	{
		$carife = ( !isset($fe) ) ? '' : ' and b.fe = "' . $fe . '"';

		$sql = 'SELECT ' . $medan . ' FROM ' . $sv . $myTable 
		     . ' b, `mm_rangka14` as c WHERE b.newss = c.newss'
			 . ' and (`c.respon` not like "A1" '
			 . ' and `c.respon` not like "B%") ' . $carife .
			' LIMIT ' . $jum['dari'] . ', ' . $jum['max'];

		//echo $sql . '<br>';
		$result = $this->db->selectAll($sql);
		//echo json_encode($result);
		
		return $result;
	}

	public function kiraKesUtama($myTable, $medan, $cari)
	{
		$cariUtama = ( !isset($cari['utama']) ) ? 
		'' : ' WHERE b.newss=c.newss and b.utama = "' . $cari['utama'] . '"';
		$cariFe = ( !isset($fe) ) ? '' : ' and b.fe = "' . $fe . '"';
		$respon = ( !isset($cari['respon']) ) ? null : $cari['respon'] ;
		$AN=array('A2','A3','A4','A5','A6','A7','A8','A9','A10','A11','A12','A13');
		
		if  ($respon=='a1')
			$cariRespon = " AND c.respon='A1' and b.terima like '20%' \r";
		elseif ($respon=='xa1')
			$cariRespon = " AND b.terima is null \r";
		elseif ($respon=='tegar')
			$cariRespon = " AND(`respon` IN ('" . implode("','",$AN) . "')) \r";
		else $cariRespon = '';

		$sql = 'SELECT ' . $medan . ' FROM ' . 	$myTable 
			 . ' b, `mm_rangka14` as c '
			 . $cariUtama . $cariRespon . $cariFe;

		//echo $sql . '<br>';
		$result = $this->db->rowcount($sql);
		//echo json_encode($result);
		
		return $result;
	}
	
	public function kesUtama($myTable, $medan, $cari, $jum)
	{
		$cariUtama = ( !isset($cari['utama']) ) ? 
		'' : ' WHERE b.newss=c.newss and b.utama = "' . $cari['utama'] . '"';
		$respon = ( !isset($cari['respon']) ) ? null : $cari['respon'] ;
		$cariFe = ( !isset($fe) ) ? '' : ' and b.fe = "' . $fe . '"';
		$AN=array('A2','A3','A4','A5','A6','A7','A8','A9','A10','A11','A12','A13');
		
		if  ($respon=='a1')
			$cariRespon = " AND c.respon='A1' and b.terima like '20%' \r";
		elseif ($respon=='xa1')
			$cariRespon = " AND b.terima is null \r";
		elseif ($respon=='tegar')
			$cariRespon = " AND(`c.respon` IN ('" . implode("','",$AN) . "')) \r";
		else $cariRespon = '';

		$sql = 'SELECT ' . $medan . ' FROM ' . 	$myTable 
			 . ' b, `mdt_rangka13` as c '
			 . $cariUtama . $cariRespon . $cariFe
			 . ' LIMIT ' . $jum['dari'] . ', ' . $jum['max'];

		//echo $sql . '<br>';
		$result = $this->db->selectAll($sql);
		//echo json_encode($result);
		
		return $result;
	}

	public function kesSemak($myTable, $myJoin, $medan, $jum)
	{
		$sql = 'SELECT ' . $medan . ' FROM ' . 
			$myTable . ' a, '.$myJoin.' b ' .
			' WHERE a.newss=b.newss ' . 
			' LIMIT ' . $jum['dari'] . ', ' . $jum['max'];
			
		$result = $this->db->selectAll($sql);
		//echo '<pre>' . $sql . '</pre><br>';
		//echo json_encode($result);
		
		return $result;
	}
	
	public function cariMedan($myTable, $medan, $cari)
	{
		$cariMedan = ( !isset($cari['medan']) ) ? '' : $cari['medan'];
		$cariID = ( !isset($cari['id']) ) ? '' : $cari['id'];
		
		$sql = 'SELECT ' . $medan . ' FROM ' . $myTable .
		' WHERE ' . $cariMedan . ' like "%' . $cariID . '%" ';
		//' WHERE ' . $medan . ' like %:cariID% ', array(':cariID' => $cariID));

		//echo $sql . '<br>';
		$result = $this->db->selectAll($sql);
		//echo json_encode($result);
		
		return $result;
	}
	
	public function cariSemuaMedan($myTable, $medan, $cari)
	{
		$cariMedan = ( !isset($cari['medan']) ) ? '' : $cari['medan'];
		$cariID = ( !isset($cari['id']) ) ? '' : $cari['id'];
		
		$sql = 'SELECT ' . $medan . ' FROM ' . 	$myTable . 
			' WHERE ' . $cariMedan . ' = "' . $cariID . '" ';
		
		//echo $sql . '<br>';
		$result = $this->db->selectAll($sql);
		//echo json_encode($result);
		
		return $result;
	}

	public function cariSatuSahaja($myTable, $medan, $cari)
	{
		$cariMedan = ( !isset($cari['medan']) ) ? '' : $cari['medan'];
		$cariID = ( !isset($cari['id']) ) ? '' : $cari['id'];
		
		$sql = 'SELECT ' . $medan . ' FROM ' . 	$myTable . 
			' WHERE ' . $cariMedan . ' = "' . $cariID . '" ';
		
		//echo $sql . '<br>';
		$result = $this->db->select($sql);
		//echo json_encode($result);
		
		return $result;
	}

	public function cariIndustri($myTable, $medan, $cari)
	{
		$cariMedan = ( !isset($cari['medan']) ) ? '' : $cari['medan'];
		$cariID = ( !isset($cari['id']) ) ? '' : $cari['id'];
		
		$sql = 'SELECT ' . $medan . ' FROM ' . 	$myTable . 
			' WHERE ' . $cariMedan . ' = "' . $cariID . '" ';
		
		//echo $sql . '<br>';
		$result = $this->db->selectAll($sql);
		//echo json_encode($result);
		
		return $result;
	}
	
	public function ubahSimpan($data, $myTable)
	{
		//echo '<pre>$sql->', print_r($data, 1) . '</pre>';
		$senarai = null;
		$medanID = 'newss';
		
		foreach ($data as $medan => $nilai)
		{
			//$postData[$medan] = $nilai;
			if ($medan == $medanID)
				$cariID = $medan;
			elseif ($medan != $medanID)
				$senarai[] = ($nilai==null) ? " `$medan` = null" : " `$medan` = '$nilai'"; 
			if(($medan == 'fe'))
				$fe = ($nilai==null) ? " `$medan` = null" : " `$medan` = '$nilai'"; 
		}
		
		$senaraiData = implode(",\r",$senarai);
		$where = "`$cariID` = '{$data[$cariID]}' ";
		
		// set sql
		$sql = " UPDATE `$myTable` SET \r$senaraiData\r WHERE $where";
		//echo '<pre>$sql->', print_r($sql, 1) . '</pre>';
		$this->db->update($sql);
	}
	/*
	public function buangTerus($data, $myTable)
	{
		//echo '<pre>$sql->', print_r($data, 1) . '</pre>';
		$cariID = 'newss';
				
		// set sql
		//$sql = " DELETE `$myTable` WHERE `$cariID` = '{$data[$cariID]}' ";
		//echo '<pre>$sql->', print_r($sql, 1) . '</pre>';
		$this->db->delete($myTable, "`$cariID` = '{$data[$cariID]}' ");
			
	}

	public function senarai($)
	{
		//$jum['dari'] . ', ' . $jum['max']
		$carife = ( !isset($fe) ) ? '' : ' WHERE fe = "' . $fe . '"';
		$sql = 'SELECT ' . $medan . ' FROM ' . 
		$sv . $myTable . $carife;
		
		//echo $sql . '<br>';
		$result = $this->db->selectAll($sql);
		//echo json_encode($result);
		
		return $result;
	}
*/
	public function xhrInsert() 
	{
		$text = $_POST['text'];
		$this->db->insert('data', array('text' => $text));
		$data = array('text' => $text, 'id' => $this->db->lastInsertId());
		echo json_encode($data);
	}
	
	public function xhrGetListings()
	{
		$result = $this->db->select("SELECT * FROM data");
		//echo $result;
		echo json_encode($result);
	}
	
	public function xhrDeleteListing()
	{
		$id = (int) $_POST['id'];
		$this->db->delete('data', "id = '$id'");
	}

}