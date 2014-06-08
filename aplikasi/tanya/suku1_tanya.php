<?php

class Suku1_Tanya extends Tanya 
{

	public function __construct() 
	{
		parent::__construct();
	}
// carian global untuk fungsi
	private function dimana($carian)
	{
		$where = null;
		if($carian==null || empty($carian) ):
			$where .= null;
		else:
			foreach ($carian as $key=>$cari)
			{
					 $atau = isset($carian[$key]['atau'])  ? $carian[$key]['atau'] . ' ' : null;
				$cariMedan = isset($carian[$key]['medan']) ? $carian[$key]['medan']      : null;
					  $fix = isset($carian[$key]['fix'])   ? $carian[$key]['fix']        : null;			
				  $cariApa = isset($carian[$key]['apa'])   ? $carian[$key]['apa']        : null;
				//echo "\r$key => ($fix) $atau $cariMedan = '$cariApa'  ";
				
				if ($cariApa==null) 
					$where .= " $atau`$cariMedan` is null\r";
				elseif($fix=='x')
					$where .= " $atau`$cariMedan`='$cariApa'\r";
				else
					$where .= " $atau`$cariMedan` like '%$cariApa%'\r";	
			}
		endif;
	
		return $where;
	
	}

	private function dibawah($carian)
	{
		$order = null;
		if($carian==null || empty($carian) ):
			$order .= null;
		else:
			foreach ($carian as $key=>$cari)
			{
				$kumpul = isset($cari['kumpul'])? $cari['kumpul']: null;
				 $susun = isset($cari['susun']) ? $cari['susun'] : null;
				  $dari = isset($cari['dari'])  ? $cari['dari']  : null;			
				   $max = isset($cari['max'])   ? $cari['max']   : null;
			}
				$order .= ($kumpul==null) ? '' : " GROUP BY $kumpul\r";
				$order .= ($susun==null) ? '' : " ORDER BY $susun\r";
				$order .= ($max==null) ? '' : (($dari==null) ? 
					"LIMIT $max" : " LIMIT $dari,$max\r");
		endif;
	
		return $order;		
	}
	
	public function kiraMedan($myTable, $medan, $carian)
	{
		$sql = 'SELECT ' . $medan . ' FROM ' . $myTable 
			. $this->dimana($carian);
		
		//echo $sql . '<br>';
		$result = $this->db->columnCount($sql);
		//echo json_encode($result);
		
		return $result;
	}

	public function kiraBaris($myTable, $medan, $carian)
	{
		$sql = 'SELECT ' . $medan . ' FROM ' . $myTable 
			. $this->dimana($carian);
		
		//echo $sql . '<br>';
		$result = $this->db->rowCount($sql);
		//echo json_encode($result);
		
		return $result;
	}

	public function paparMedan($myTable)
	{
		//return $this->db->select('SHOW COLUMNS FROM ' . $myTable);
		$sql = 'SHOW COLUMNS FROM ' . $myTable;
		return $this->db->selectAll($sql);
	}

// ubahsuai fungsi untuk carian tertentu	
	public function kumpulRespon($medanR, $f2, $r = 'respon', 
		$medan, $myTable, $carian, $jum)
	// kumpulRespon('kod','f2',$jadual,$carian,$jum);
	{
		$sql = 'SELECT ' . $medanR . ' FROM ' . $f2 
			 . ' WHERE kod not in ("X","5P") GROUP BY 1 ORDER BY no';
		$hasil = $this->db->selectAll($sql);
		
		/*** loop over the object directly ***/
		$kumpul = null;
		foreach($hasil as $key=>$val)
		{
			foreach($val as $key2=>$p)
			{
				//echo "$p<br>";
				//$kumpul .= ",\r '' as '" . $p . "'";
				$kumpul .= ",\r if($r='".$p."','X','&nbsp;') as '" . $p . "'";
				//$jumlah_kumpul.="+count(if($r='".$papar[0]."' and b.terima is not null,$r,null))\r";
			}
		} //echo '<pre>$kumpul:'; print_r($kumpul) . '</pre>';
		
		# sql kedua
		$sql2 = "SELECT $medan$kumpul\r"
			. ' FROM ' . $myTable . $this->dimana($carian)
			. ' ORDER BY '. $jum['susun']
			. ' LIMIT ' . $jum['dari'] . ', ' . $jum['max'];
		
		//echo '<pre>' . $sql2 . '</pre><br>';
		$result['kiraBaris'] = $this->db->rowCount($sql2);
		$result['kiraMedan'] = $this->db->columnCount($sql2);
		$result['kiraData'] = $this->db->selectAll($sql2);
		//echo json_encode($result);
		
		return $result;		
		
	}

	public function paparIkutSurvey($myTable)
	{
		$sql = 'SELECT subsektor,count(*) as kira FROM ' . $myTable
			 . ' GROUP BY 1';
		//echo $sql . '<br>';
		return $this->db->selectAll($sql);
	}

	public function asingSv($myTable, $medan = '*', $carian, $susun = null)
	{
		$sql = 'SELECT ' . $medan . ' FROM ' . 	$myTable 
			 . $this->dimana($carian)
			 . $this->dibawah($susun);
		
		//echo '<br>' . $sql . '<hr>';
		$result = $this->db->selectAll($sql);
		//echo json_encode($result);
		
		return $result;
	}
	
	public function cariBanyak($myTable, $medan, $carian, $susun = null)
	{
		$sql = 'SELECT ' . $medan . ' FROM ' . $myTable 
			 . $this->dimana($carian)
			 . $this->dibawah($susun);

		//echo $sql . '<br>';
		$result = $this->db->selectAll($sql);
		//echo json_encode($result);
		
		return $result;
	}

	public function cariSatu($myTable, $medan, $carian, $susun = null)
	{
		$sql = 'SELECT ' . $medan . ' FROM ' . $myTable 
			 . $this->dimana($carian)
			 . $this->dibawah($susun);			 

		 //echo $sql . '<br>';
		$result = $this->db->select($sql);
		//echo json_encode($result);
		
		return $result;
	}
	
// untuk crud - create/read/update/delete
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
