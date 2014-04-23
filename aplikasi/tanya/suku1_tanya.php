<?php

class Suku1_Tanya extends Tanya 
{

	public function __construct() 
	{
		parent::__construct();
	}

	public function paparMedan($myTable)
	{
		//return $this->db->select('SHOW COLUMNS FROM ' . $myTable);
		$sql = 'SHOW COLUMNS FROM ' . $myTable;
		return $this->db->selectAll($sql);
	}

	public function paparSemuaData($myTable)
	{
		$sql = 'SELECT * FROM ' . $myTable;
		//echo $sql . '<br>';
		return $this->db->selectAll($sql);
	}
	
	public function paparMedanTerpilih($myTable, $medan = '*')
	{
		$sql = 'SELECT ' . $medan . ' FROM ' . $myTable;
		//echo $sql . '<br>';
		return $this->db->selectAll($sql);
	}
	
	public function paparIkutSurvey($myTable)
	{
		$sql = 'SELECT subsektor,count(*) as kira FROM ' . $myTable
			 . ' GROUP BY 1';
		//echo $sql . '<br>';
		return $this->db->selectAll($sql);
	}

	public function paparData($myTable, $medan = '*', $cari)
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
	
	public function asingSv($myTable, $medan = '*', $cari)
	{
		$cariMedan = ( !isset($cari['medan']) ) ? '' : $cari['medan'];
		$b = ( !isset($cari['operator']) ) ? '<>' : $cari['operator'];
		$cariID = ( !isset($cari['id']) ) ? '' : $cari['id'];
		
		$sql = 'SELECT ' . $medan . ' FROM ' . 	$myTable 
			 . ' WHERE ' . $cariMedan . ' ' . $b 
			 . ' "' . $cariID . '" '
			 . ' ORDER BY subsektor,newss';
		
		//echo $medan . '<hr>' . $sql . '<br>';
		$result = $this->db->selectAll($sql);
		//echo json_encode($result);
		
		return $result;
	}

	public function paparPOM($myTable, $medan = '*', $cari)
	{
		$cariMedan = ( !isset($cari['medan']) ) ? '' : $cari['medan'];
		$b = ( !isset($cari['operator']) ) ? '<>' : $cari['operator'];
		$cariID = ( !isset($cari['id']) ) ? '' : $cari['id'];
		
		$sql = 'SELECT ' . $medan . ' FROM ' . 	$myTable . 
			' WHERE ' . $cariMedan . ' ' . $b . 
			' "' . $cariID . '" ';
		
		//echo $medan . '<hr>' . $sql . '<br>';
		$result = $this->db->selectAll($sql);
		//echo json_encode($result);
		
		return $result;
	}
	
	public function cariBanyakMedan($myTable, $medan, $kira, $had)
	{
		$sql ="\rSELECT $medan FROM `$myTable` WHERE \r";
		
		foreach ($_POST['pilih'] as $key=>$cari)
		{
			$apa = $_POST['cari'][$key];
			$f = isset($_POST['fix'][$key]) ? $_POST['fix'][$key] : null;
			$atau = isset($_POST['atau'][$key]) ? $_POST['atau'][$key] : null;
			
			//$sql.="\r$key => $f  | ";

			if ($apa==null) 
				$sql .= "$atau $cari is null\r";
			elseif ($myTable=='msic2008') 
			{
				if ($cari=='msic') $sql.=($f=='x') ?
				"$atau ($cari='$apa' or msic2000='$apa')\r" :
				"$atau ($cari like '%$apa%' or msic2000 like '%$apa%')\r";
				else $sql.=($f=='x') ?
				"$atau ($cari='$apa' or notakaki='$apa')\r" :
				"$atau ($cari like '%$apa%' or notakaki like '%$apa%')\r";
			}
			else 
				$sql.=($f=='x') ? "$atau `$cari`='$apa'\r" : 
				"$atau `$cari` like '%$apa%'\r";					
		}
		
		$sql.="LIMIT $had ";
		//echo $sql . '<br>';
		return $this->db->selectAll($sql);
	
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

	public function cariBanyak($myTable, $medan, $cari)
	{
	
		$cariMedan = ( !isset($cari['medan']) ) ? '' : $cari['medan'];
		$cariID = ( !isset($cari['id']) ) ? '' : $cari['id'];
		
		$sql = 'SELECT ' . $medan . ' FROM ' . 	$myTable . 
			' WHERE ' . $cariMedan . ' like "%' . $cariID . '%" ';
		
		//echo $sql . '<br>';
		$result = $this->db->selectAll($sql);
		//echo json_encode($result);
		
		return $result;
	}

	public function noAhli($myTable, $medan, $cari)
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

	public function tambahSimpan($data, $jadual)
	{
		//echo '<pre>$data->', print_r($data, 1) . '</pre>';
		$senarai = null;
		$myTable = $jadual['nama'];
		
		foreach ($data as $medan => $nilai)
		{
			$senarai[] = ($nilai==null) ? "null" : "'$nilai'"; 
		}
		
		$senaraiMedan = implode("`,\r`", array_keys($data));
		$senaraiData = implode(",\r",$senarai);
		
		// set sql
		$sql = "INSERT INTO `$myTable` \r(`$senaraiMedan`)\rVALUES(\r$senaraiData) ";
		//echo '<pre>$sql->', print_r($sql, 1) . '</pre>';
		//$this->db->insert($sql);
	}
	
	public function ubahSimpan($data, $jadual)
	{
		// isytihar pembolehubah
		$senarai = null;
		$myTable = $jadual['nama'];
		$medanID = $jadual['medanID'];
		$cariID  = $jadual['cariID'];
		
		// semak tatasusunan $data & $jadual
		#echo '<pre>$jadual->', print_r($jadual, 1) . '</pre>';
		#echo '<pre>$data->', print_r($data, 1) . '</pre>';
	
		foreach ($data as $medan => $nilai)
		{
			if ($cariID!=$data[$medanID]) // kalau primary_key berubah
				$senarai[] = ($nilai==null) ? " `$medan`=null" : " `$medan`='$nilai'"; 
			elseif ($medan != $medanID) // kalau medan bukan primary_key
				$senarai[] = ($nilai==null) ? " `$medan`=null" : " `$medan`='$nilai'"; 
		}
		
		$senaraiData = implode(",\r",$senarai);
		$where = "`$medanID` = '{$cariID}' ";
		$ubahID = ($cariID!=$data[$medanID]) ? '$ubahID berubah' : '$ubahID sama';
		$semakID = ($cariID!=$data[$medanID]) ?  $data[$medanID] : $cariID;
		
		/*
		echo '<br>$cariID:' . $cariID . '<br>$data[$medanID]:' . $data[$medanID] .
			 '<br>$ubahID:' . $ubahID . '<br>$semakID:' . $semakID .'<hr>';
		*/
		
		// set sql
		$sql = " UPDATE `$myTable` SET \r$senaraiData\r WHERE $where";
		//echo '<pre>$sql->', print_r($sql, 1) . '</pre>';
		$this->db->update($sql);
		
		return $semakID;
	}

	public function buang($myTable, $medan, $cari)
	{
	
		$cariMedan = ( !isset($cari['medan']) ) ? '' : $cari['medan'];
		$cariID = ( !isset($cari['id']) ) ? '' : $cari['id'];
		
		$where = '`' . $cariMedan . '` = "' . $cariID . '" ';
		//echo $where . '<br>';
		
		$this->db->delete($myTable, $where, 1);
		
	}

}
