<?php

class Batch_Tanya extends Tanya 
{

	public function __construct() 
	{
		parent::__construct();
	}

	private function cariApa($fix, $atau, $cariMedan, $cariApa)
	{
		$where = null;
			if ($cariApa==null) 
				$where .= " $atau`$cariMedan` is null\r";
			elseif($fix=='x=') 
				$where .= " $atau`$cariMedan` = '$cariApa'\r";
			elseif($fix=='xlike') 
				$where .= " $atau`$cariMedan` like '%$cariApa%'\r";	
				
		return $where;
	}
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
				$where = $this->cariApa($fix, $atau, $cariMedan, $cariApa);
			}
		endif;
	
		return $where;
	
	}
	
	private function dibawah($carian)
	{
		$susunan = null; 
		if($carian==null || empty($carian) ):
			$susunan .= null;
		else:
			foreach ($carian as $key=>$cari)
			{
				$kumpul = isset($cari['kumpul'])? $cari['kumpul'] : null;
				 $order = isset($cari['susun']) ? $cari['susun']  : null;
				  $dari = isset($cari['dari'])  ? $cari['dari']   : null;			
				   $max = isset($cari['max'])   ? $cari['max']    : null;
				   
				//echo " \$key=$key, \$cari = $cari,<br>";
			}
				if ($kumpul!=null)$susunan .= " GROUP BY $kumpul\r";
				if ($order!=null) $susunan .= " ORDER BY $order\r";
				if ($max!=null)   $susunan .= ($dari==0) ? 
					" LIMIT $max\r" : " LIMIT $dari,$max\r";
		endif; //echo " $susunan hahaha<hr>";
		
		//echo '<pre>carian:'; print_r($carian) . '</pre><br>';
		//echo "<hr>\$kumpul:$kumpul \$order:$order \$dari:$dari \$max:$max hahaha<hr>";
		return $susunan;		
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
	
	public function kiraKes($myTable, $medan, $carian)
	{
		$sql = 'SELECT ' . $medan . ' FROM ' . $myTable 
			. $this->dimana($carian);
		
		//echo $sql . '<br>';
		$result = $this->db->rowCount($sql);
		//echo json_encode($result);
		
		return $result;
	}
	
	public function kumpulRespon($medanR, $f2, $r = 'respon', 
		$medan, $myTable, $carian, $jum)
	// kumpulRespon('kod','f2',$jadual,$carian,$jum);
	{	// sql untuk 
		$kod = 'SELECT ' . $medanR . ' FROM ' . $f2 
			 . ' WHERE kod not in ("X","5P") GROUP BY 1 ORDER BY no';
		$hasil = $this->db->selectAll($kod);
		
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
		
		//echo '$carian:'; print_r($carian) . '<br>';
		//echo '<pre>' . $sql2 . '</pre><br>';
		$result['kiraBaris'] = $this->db->rowCount($sql2);
		$result['kiraMedan'] = $this->db->columnCount($sql2);
		$result['kiraData'] = $this->db->selectAll($sql2);
		//echo json_encode($result);
		
		return $result;		
		
	}

	public function kesBatchAwal($myTable, $medan, $carian = null, $susun = null)
	{
		$sql = ' SELECT ' . $medan . ' FROM ' . $myTable 
			 . $this->dimana($carian)
			 . $this->dibawah($susun)
			 . '';
		
		echo '<pre>' . htmlentities($sql) . '</pre>';
		$result = $this->db->selectAll($sql);
		
		return $result;
	}

	public function cariSemuaData($myTable, $medan, $carian = null, $susun = null)
	{
		$sql = 'SELECT ' . $medan . ' FROM ' . $myTable 
			 . $this->dimana($carian)
			 . $this->dibawah($susun)
			 . '';
		
		//echo $sql . '<br>';
		$result = $this->db->selectAll($sql);
		//echo json_encode($result);
		
		return $result;
	}

	public function cariSatuSahaja($myTable, $medan, $carian)
	{
		$sql = 'SELECT ' . $medan . ' FROM ' . $myTable . $this->dimana($carian);
		
		//echo $sql . '<br>';
		$result = $this->db->select($sql);
		//echo json_encode($result);
		
		return $result;
	}
	
	public function ubahSimpan($data, $myTable, $medanID = null)
	{
		//echo '<pre>$data->', print_r($data, 1) . '</pre>';
		$senarai = null;
		
		foreach ($data as $medan => $nilai)
		{
			if ($medan == $medanID)
				$where = " WHERE `$medanID` = '{$data[$medanID]}' ";
			elseif ($medan != $medanID)
				$senarai[] = ($nilai==null) ? 
				" `$medan`=null" : " `$medan`='$nilai'"; 
		}
		
		$senaraiData = implode(",\r",$senarai);
		
		# set sql
		$sql = " UPDATE `$myTable` SET \r$senaraiData\r $where";
		//echo '<pre>$sql->', print_r($sql, 1) . '</pre>';
		$this->db->update($sql);
	}

	public function ubahSimpanSemua($data, $myTable, $medanID, $dimana)
	{
		//echo '<pre>$data->', print_r($data, 1) . '</pre>';
		//echo '<pre>$dimana->', print_r($dimana, 1) . '</pre>';
		$senarai = null;
		
		foreach ($data as $medan => $nilai)
		{
			if ($medan == $medanID)
				$where = " WHERE `$medanID` = '{$dimana[$medanID]}' ";
			$senarai[] = ($nilai==null) ? 
				" `$medan`=null" : " `$medan`='$nilai'"; 
		}
		
		$senaraiData = implode(",\r",$senarai);
		
		# set sql
		$sql = " UPDATE `$myTable` SET \r$senaraiData\r $where";
		echo '<pre>$sql->', print_r($sql, 1) . '</pre>';
		//$this->db->update($sql);
		//*/
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

*/

}