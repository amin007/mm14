<?php

class Batch extends Kawal 
{

    public function __construct() 
    {
        parent::__construct();
        Kebenaran::kawalKeluar();
        
        $this->papar->js = array(
            /*'bootstrap.js',
            'bootstrap-transition.js',
            'bootstrap-alert.js',
            'bootstrap-modal.js',
            'bootstrap-dropdown.js',
            'bootstrap-scrollspy.js',
            'bootstrap-tab.js',
            'bootstrap-tooltip.js',
            'bootstrap-popover.js',
            'bootstrap-button.js',
            'bootstrap-collapse.js',
            'bootstrap-carousel.js',
            'bootstrap-typeahead.js',
            'bootstrap-affix.js',*/
            'bootstrap-datepicker.js',
            'bootstrap-datepicker.ms.js',
            'bootstrap-editable.min.js');
        $this->papar->css = array(
            'bootstrap-datepicker.css',
            'bootstrap-editable.css');
			
        $this->medanRangka = 'newss,nossm,concat_ws("<br>",nama,operator) as nama,batchAwal,respon r,'
			. 'substring(1,5,`YR_MSIC_ID`) msic2008, subsektor,' . "\r "
			. 'concat_ws("<br>",alamat1,alamat2,poskod,bandar) as alamat' . "\r";
			//. 'tel,fax,responden,email,nota';
		$space = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
		$this->medanData = 'newss,'
			. 'concat_ws("<br>",LOWER(nama),'
			. 'concat("<br>(",newss,")'.$space.'205'.$space.'",msic2008,"'.$space.'2014"),'
			. 'nossm,"<br>PENGURUS",nama,operator,alamat1,alamat2,'
			. 'concat(poskod," ",bandar) ) as nama,'
			. 'batchAwal fe,respon,data_tahunan,' //substring(`YR_MSIC_ID`,1,5) msic,'
			. 'nota,'  . "\r"
			. ' concat_ws("</td></tr>\r\t<tr><td>",' . "\r"
			. ' 	concat_ws("</td><td>","pengurusan",bil_pengurusan,gaji_pengurusan),' . "\r"
			//. ' 	concat("\r<tr><td>"),' . "\r"
			. ' 	concat_ws("</td><td>","juruteknik",bil_juruteknik,gaji_juruteknik),' . "\r"
			. ' 	concat_ws("</td><td>","kerani",bil_kerani,gaji_kerani),' . "\r"
			. ' 	concat_ws("</td><td>","operatif",bil_operatif,gaji_operatif),' . "\r"
			. ' 	concat_ws("</td><td>","asas",bil_asas,gaji_asas)' . "\r"
			//. '		concat(),'
 			. ' ) as bil_staf'
			. "\r";
			//'b.newss,b.nama,b.fe,c.respon R,terima,' . "\r"
		   //. 'hantar,format(gaji,0) gaji,format(staf,0) staf,format(hasil,0) hasil,catatan';
		$this->pengguna = Sesi::get('namaPegawai');
		$this->level = Sesi::get('levelPegawai');
    }
    
    public function index() 
    { 
		echo 'class Batchawal::index() extends Kawal ';
    }
	
// UNTUK KES POM
	public function buangBatchAwal($cariBatch = null, $dataID = null)
	{
		# masuk dalam database
			# ubahsuai $posmen
			$jadual = 'ejob14_q1';
			$medanID = 'newss';
			$posmen[$jadual]['batchAwal'] = null;
			$posmen[$jadual]['respon'] = null;
			$posmen[$jadual][$medanID] = $dataID;
			//echo '<br>$dataID=' . $dataID . '<br>';
			//echo '<pre>$posmen='; print_r($posmen) . '</pre>';
        
			$this->tanya->ubahSimpan($posmen[$jadual], $jadual, $medanID);

		# Set pemboleubah utama
        $this->papar->pegawai = senarai_kakitangan();
        $this->papar->lokasi = 'CDT 2014 - Ubah';
		
		 # pergi papar kandungan
		//echo '<br>location: ' . URL . "batch/awal/$cariBatch" . '';
		header('location: ' . URL . "batch/awal/$cariBatch");

	}

	public function ubahBatchAwal($cariBatch)
	{
		//echo '<pre>$_GET->', print_r($_GET, 1) . '</pre>';
		# bersihkan data $_POST
		$dataID = bersihGET('cari');
		
		# masuk dalam database
			# ubahsuai $posmen
			$jadual = 'ejob14_q1';
			$medanID = 'newss';
			$posmen[$jadual]['batchAwal'] = $cariBatch;
			$posmen[$jadual]['respon'] = 'B7';
			$posmen[$jadual][$medanID] = $dataID;
			//echo '<br>$dataID=' . $dataID . '<br>';
			//echo '<pre>$posmen='; print_r($posmen) . '</pre>';
        
			$data = $posmen[$jadual];
			$this->tanya->ubahSimpan($data, $jadual, $medanID);

		# Set pemboleubah utama
        $this->papar->pegawai = senarai_kakitangan();
        $this->papar->lokasi = 'CDT 2014 - Ubah';
		
		 # pergi papar kandungan
		//echo '<br>location: ' . URL . "batch/awal/$cariBatch/$dataID" . '';
		header('location: ' . URL . "batch/awal/$cariBatch/$dataID");

	}
	
	public function awal($cariBatch = null, $cariID = null) 
    {    
		# setkan pembolehubah untuk $this->tanya
			//echo "\$cariBatch = $cariBatch . \$cariID = $cariID <br>";
			$item = 500; $ms = 1;
            $medanRangka = $this->medanRangka;
			$medanData = $this->medanData;
			$medan = $medanRangka;
			$senaraiJadual = array('ejob14_q1');	

		if (!isset($cariBatch) || empty($cariBatch) ):
			$paparError = 'Tiada batch<br>';
		else:
			if((!isset($cariID) || empty($cariID) ))
				$paparError = 'Tiada id<br>';
			else
			{
				$paparMedan = 'newss,nossm,nama,operator'
					. ',concat_ws(" ",alamat1,alamat2,poskod,bandar) as alamat';
				$cariNama[] = array('fix'=>'x=','atau'=>'WHERE','medan'=>'newss','apa'=>$cariID);
				$dataKes = $this->tanya->cariSatuSahaja($senaraiJadual[0], $paparMedan, $cariNama);
				//echo '<pre>', print_r($dataKes, 1) . '</pre><br>';
				$paparError = 'Ada id:' . $dataKes['newss'] 
							. '| ssm:' . $dataKes['nossm']
							. '<br> nama:' . $dataKes['nama'] 
							. '| operator:' . $dataKes['operator']
							. '<br> alamat:' . $dataKes['alamat']; 
			}			
		endif;
			# buat group ikut batchAwal
			# tentukan bilangan mukasurat. bilangan jumlah rekod
			//echo '$bilSemua:' . $bilSemua . ', $item:' . $item . ', $ms:' . $ms . '<br>';
			$jum = pencamSqlLimit(300, $item, $ms);
			$susun[] = array_merge($jum,array('kumpul' => 'batchAwal', 'susun' => 'batchAwal'));
			$jadualGroup = $senaraiJadual[0];
			# sql semula
			$this->papar->cariApa['kiraBatchAwal'] = $this->tanya->
				cariGroup($jadualGroup, $medanGroup = 'batchAwal, count(*) as kira', $carian = null, $susun);

			# mula papar semua dalam $myTable
			$jum = $susun = null;
			$carian[] = array('fix'=>'x=','atau'=>'WHERE','medan'=>'batchAwal','apa'=>$cariBatch);
			foreach ($senaraiJadual as $key => $myTable)
			{# mula ulang table
				# dapatkan bilangan jumlah rekod
				//echo "\$myTable:$myTable | \$medan:$medan | \$cariBatch:$cariBatch<br>";
				$bilSemua = $this->tanya->kiraKes($myTable, $medan, $carian);
				# tentukan bilangan mukasurat. bilangan jumlah rekod
				//echo '$bilSemua:' . $bilSemua . ', $item:' . $item . ', $ms:' . $ms . '<br>';
				$jum = pencamSqlLimit($bilSemua, $item, $ms);
				$susun[] = array_merge($jum,array('kumpul' => null, 'susun' => 'respon DESC,nama'));
				# sql guna limit
				$this->papar->cariApa[$myTable] = $this->tanya->
					kesBatchAwal($myTable, $medan, $carian, $susun);
			}# tamat ulang table
			//$this->papar->cariApa = array();

        # semak pembolehubah $this->papar->cariApa
        //echo '<pre>', print_r($this->papar->cariApa, 1) . '</pre><br>';

        # Set pemboleubah utama
		## untuk menubar
		$this->papar->pegawai = senarai_kakitangan();
		
		## untuk dalam class Papar
		$this->papar->error = $paparError; //echo ' Error : ' . $paparError . '<br>';
		$this->papar->cariBatch = $cariBatch;
		$this->papar->cariID = $cariID;
		$this->papar->carian = 'semua';
        
        # pergi papar kandungan
        $this->papar->baca('kawalan/batchawal', 1);
    }

// tukar banyak kes sendiri ikut alamat
    public function ubah($item = 30, $ms = 1, $cariBatch = null, $cariSemua = null, $khas = null) 
    {    
        /*
         * $item = 30 // set bil. data dalam 1 muka surat
         * $ms = 1 // set $ms = mula surat bermula dengan 1
         * $cariBatch = null // set $cariBatch = tiada | atau untuk pegawai kerja luar
         */
        # setkan pembolehubah untuk $this->tanya sql 1
			$myTable = 'ejob14_q1';
            $medan = $this->medanData; 
			$cari[] = array('fix'=>'x=','atau'=>'WHERE','medan'=>'batchAwal','apa'=>$cariBatch,'akhir'=>'');
			//$cari[] = array('fix'=>'%like%','atau'=>'AND','medan'=>'dp_baru','apa'=>$cariSemua,'akhir'=>'');
		# sql 1
            # dapatkan bilangan jumlah rekod
            $bilSemua = $this->tanya->kiraKes($myTable, $medan, $cari);
            # tentukan bilangan mukasurat & bilangan jumlah rekod
            $jum = pencamSqlLimit($bilSemua, $item, $ms, null);
            # sql guna limit
            $this->papar->cariApa[$myTable] = $this->tanya->
				kesBatchAwal($myTable, $medan, $cari, $jum);
		# setkan pembolehubah untuk $this->tanya sql2
			$paparTable = $cariBatch;
			$jadual = 'ejob14_q1';
			$jadualMedan2 = 'batchAwal, count(*)as jum';
			$cari2[] = array('fix'=>'like','atau'=>'WHERE','medan'=>'batchAwal','apa'=>$cariBatch);
        # mula cari jadual khas
			# khas utk laporan sahaja
            $jum2 = pencamSqlLimit($bilSemua, $item = 500, $ms, 'batchAwal', 'batchAwal');
            # sql guna limit
            $this->papar->cariApa[$paparTable] = $this->tanya->
				cariGroup($jadual, $jadualMedan2, $cari2, $jum2);
		//*/
        # semak pembolehubah $this->papar->cariApa
		//echo '<pre>$this->papar->cariApa:', print_r($this->papar->cariApa, 1) . '</pre><br>';
        
        # Set pemboleubah utama
		//$this->papar->cariApa[] = array(0=>array('data'=>'kosong'));
        $this->papar->pegawai = senarai_kakitangan();
        $this->papar->carian = 'alamat';
        $this->papar->_cariBatch = $cariBatch;
        $this->papar->_cariSemua = $cariSemua;
        $this->papar->error = null; # kalau ada error laa
        # pergi papar kandungan
        $this->papar->baca('kawalan/respon', 0);
    }
	
    public function ubahSimpan()
    {
        $posmen = array();
        $medanID = 'newss';
		$medanUbah = array('respon','nota','data_tahunan'
			//'bil_pengurusan','bil_juruteknik','bil_kerani','bil_operatif','bil_asas',
			//'gaji_pengurusan','gaji_juruteknik','gaji_kerani','gaji_operatif','gaji_asas'
		);
		$myTable = 'ejob14_q1';
        foreach ($_POST as $namaMedan => $value)
        {
            if ( in_array($namaMedan,$medanUbah) )
            {
                foreach ($value as $kekunci => $papar)
				{
					$posmen[$kekunci][$myTable][$medanID] = $kekunci;
					$posmen[$kekunci][$myTable][$namaMedan] = huruf('BESAR', bersih($papar) );
				}
            }	
        }
        # semak data 
		//echo '<pre>$_POST='; print_r($_POST) . '</pre>';
        //echo '<pre>$posmen='; print_r($posmen) . '</pre>';

        # mula ulang $posmen
        foreach ($posmen as $cariID => $poskad)
		{
			foreach ($poskad as $jadual => $data)
			{
				$this->tanya->ubahSimpan($data, $jadual, $medanID);
			}
        }

        # pergi papar kandungan
		//alamat($item = 30, $ms = 1, $cariBatch = null, $cariSemua = null, $kawasan = null) 
		$cariBatch = $_POST['batchAwal'];
		$cariSemua = '/' . $_POST['cariSemua'];
		//echo 'location: ' . URL . "/batch/ubah/10/1/$cariBatch$cariSemua";
        header('location: ' . URL . "batch/ubah/10/1/$cariBatch$cariSemua");
 //*/      
    }
		
	public function cetakf3($cariBatch, $item = 30, $ms = 1)
	{
		# kiraKes dulu
		//$jadual = 'cdt_pom_baki';
		$jadual = 'cdt_pom_kawalan';
		$carian[] = array('fix'=>'x=','atau'=>'WHERE','medan'=>'batchAwal','apa'=>$cariBatch);
		$bilSemua = $this->tanya->kiraKes($jadual, $medan = '*', $carian);
		# tentukan bilangan mukasurat. bilangan jumlah rekod
		//echo '$bilSemua:' . $bilSemua . ', $item:' . $item . ', $ms:' . $ms . '<br>';
		$jum = pencamSqlLimit($bilSemua, $item, $ms, 'nama ASC');

		# kumpul respon
		$kumpul = $this->tanya->kumpulRespon('kod','f2','respon',
			$medan = "concat_ws('<br>Operator:',nama,operator) nama, concat_ws(' ',kp) as 'sv', utama, newss",
			$jadual,$carian,$jum);
		//echo '<pre>$kumpul:'; print_r($kumpul) . '</pre>';
		$this->papar->kiraSemuaBaris = $bilSemua;
		$this->papar->item = $item;
		$this->papar->ms = $ms;
		$this->papar->kiraBaris = $kumpul['kiraBaris'];
		$this->papar->kiraMedan = $kumpul['kiraMedan'];
		$this->papar->hasil = $kumpul['kiraData'];
		$this->papar->fe = $cariBatch;
		//$this->papar->halaman = halamanf3($jum);

		# Set pemboleubah utama
        $this->papar->pegawai = senarai_kakitangan();
        $this->papar->lokasi = 'CDT 2014 - Ubah';
		
		 # pergi papar kandungan
		//echo '<br>location: ' . URL . "batchawal/semak/$cariBatch/$dataID" . '';
		//$this->papar->baca('kawalan/batchsemak_cetak', 1);
		$this->papar->baca('laporan/f3', 1);
	}

	public function cetakf3semua($cariBatch, $item = 30, $ms = 1)
	{
		# kiraKes dulu
		$jadual = 'ejob14_q1';
		$carian[] = array('fix'=>'x=','atau'=>'WHERE','medan'=>'batchAwal','apa'=>$cariBatch);
		$bilSemua = $this->tanya->kiraKes($jadual, $medan = '*', $carian);
		# tentukan bilangan mukasurat. bilangan jumlah rekod
		//echo '$bilSemua:' . $bilSemua . ', $item:' . $item . ', $ms:' . $ms . '<br>';
		$jum = pencamSqlLimit($bilSemua, $item, $ms, null, 'nama ASC');

		# kumpul respon
		$kumpul = $this->tanya->kumpulRespon('kod','f2','respon',
			$medan = "concat_ws('<br>Operator:',nama,operator) nama, subsektor as sv, "
				. "'' utama, newss, nota",
			$jadual,$carian,$jum);
		//echo '<pre>$kumpul:'; print_r($kumpul) . '</pre>';
		$this->papar->kiraSemuaBaris = $bilSemua;
		$this->papar->item = $item;
		$this->papar->ms = $ms;	
		$this->papar->kiraBaris = $kumpul['kiraBaris'];
		$this->papar->kiraMedan = $kumpul['kiraMedan'];
		$this->papar->hasil = $kumpul['kiraData'];
		$this->papar->fe = $cariBatch;
		$this->papar->halaman = halaman($jum);

		# Set pemboleubah utama
        $this->papar->pegawai = senarai_kakitangan();
        $this->papar->lokasi = 'CDT 2014 - Ubah';
		
		 # pergi papar kandungan
		//echo '<br>location: ' . URL . "batchawal/semak/$cariBatch/$dataID" . '';
		$this->papar->baca('laporan/f3all', 1);
	}

	public function tukarBatch($tukarBatch)
	{
		//echo '<pre>$_GET->', print_r($_GET, 1) . '</pre>';
		# bersihkan data $_GET
		$asalBatch = bersihGET('asal');			
		# masuk dalam database
			# ubahsuai $posmen
			$jadual = 'cdt_pom_kawalan';
			//$jadual = 'cdt_pom_baki';
			$medanID = 'batchAwal';
			$posmen[$jadual]['batchAwal'] = $tukarBatch;
			$dimana[$jadual]['batchAwal'] = $asalBatch;
			$posmen[$jadual]['respon'] = 'B7';
			//echo '<br>$dataID=' . $dataID . '<br>';
			//echo '<pre>$posmen='; print_r($posmen) . '</pre>';
        
			$this->tanya->ubahSimpanSemua($posmen[$jadual], $jadual, 
				$medanID, $dimana[$jadual]);
  
		# Set pemboleubah utama
        $this->papar->pegawai = senarai_kakitangan();
        $this->papar->lokasi = 'CDT 2014 - Ubah';
		
		 # pergi papar kandungan
		//echo '<br>location: ' . URL . "batch/awal/$tukarBatch" . '';
		header('location: ' . URL . "batch/awal/$tukarBatch");
		//*/
	}
	
// untuk penghantaran ke prosesan
	public function cetakf10($cariBatch,$cariKP = null)
	{
		# kiraKes dulu
		$item = 30; $ms = 1;
		$jadual = 'cdt_pom_baki';
		$carian[] = array('fix'=>'x','atau'=>'WHERE','medan'=>'batchAwal','apa'=>$cariBatch);
		$bilSemua = $this->tanya->kiraKes($jadual, $medan = '*', $carian);
		# tentukan bilangan mukasurat. bilangan jumlah rekod
		//echo '$bilSemua:' . $bilSemua . ', $item:' . $item . ', $ms:' . $ms . '<br>';
		$jum = pencamSqlLimit($bilSemua, $item, $ms, 'nama DESC');

		# kumpul respon
		$kumpul = $this->tanya->kumpulRespon('kod','f2','respon',
			$medan = "newss, nama, respon, '' as nona1, '' as catatan",
			$jadual,$carian,$jum);
		//echo '<pre>$kumpul:'; print_r($kumpul) . '</pre>';
		$this->papar->kiraBaris = $kumpul['kiraBaris'];
		$this->papar->kiraMedan = $kumpul['kiraMedan'];
		$this->papar->hasil = $kumpul['kiraData'];
		$this->papar->KP = $cariKP;

		# Set pemboleubah utama
        $this->papar->pegawai = senarai_kakitangan();
        $this->papar->lokasi = 'CDT 2014 - Ubah';
		
		 # pergi papar kandungan
		//echo '<br>location: ' . URL . "batchawal/semak/$cariBatch/$dataID" . '';
		$this->papar->baca('kawalan/batchprosesan_cetak', 1);
//*/		
	}

// CARIAN
    function cari() 
    {
        //echo '<br>Anda berada di class Imej extends Kawal:cari()<br>';
        //echo '<pre>'; print_r($_POST) . '</pre>';
        /*     $_POST[id] => Array ( [ssm] => 188561 atau [nama] => sharp manu ) */
        
        // senaraikan tatasusunan jadual
        $myJadual = tahunan('semuakawalan', null);
        $this->papar->cariNama = array();

        // cari id berasaskan newss/ssm/sidap/nama
        $id['ssm'] = isset($_POST['id']['ssm']) ? $_POST['id']['ssm'] : null;
        $id['nama'] = isset($_POST['id']['nama']) ? $_POST['id']['nama'] : null;
            
        
        if (!empty($id['ssm'])) 
        {
            //echo "POST[id][ssm]:" . $_POST['id']['ssm'];
            $cariMedan = 'sidap'; // cari dalam medan apa
            $cariID = $id['ssm']; // benda yang dicari
            $this->papar->carian='ssm';
            
            // mula cari $cariID dalam $myJadual
            foreach ($myJadual as $key => $myTable)
            {// mula ulang table
                // senarai nama medan
                $medan = ($myTable=='sse10_kawal') ? 
                    'sidap,newss,nama' : 'sidap,nama'; 
                $this->papar->cariNama[$myTable] = 
                $this->tanya->cariMedan($myTable, $medan, $cariMedan, $cariID);
            }// tamat ulang table
        }
        elseif (!empty($id['nama']))
        {
            //echo "POST[id][nama]:" . $_POST['id']['nama'];
            $cariMedan = 'nama'; // cari dalam medan apa
            $cariID = $id['nama'];
            $this->papar->carian='nama';
            
            // mula cari $cariID dalam $myJadual
            foreach ($myJadual as $key => $myTable)
            {// mula ulang table
                // senarai nama medan
                $medan = ($myTable=='sse10_kawal') ? 
                    'sidap,newss,nama' : 'sidap,nama'; 
                $this->papar->cariNama[$myTable] = 
                $this->tanya->cariMedan($myTable, $medan, $cariMedan, $cariID);
            }// tamat ulang table

        }
        else
        {
            $this->papar->carian='[id:0]';
        }
        
        // paparkan ke fail cimej/cari.php
		echo '<pre>'; print_r($this->papar->cariNama) . '</pre>';
        //$this->papar->baca('cimej/cari');
        
    }
    
	function buang($cariID) 
    {//echo '<br>Anda berada di class Imej extends Kawal:ubah($cari)<br>';
                
        // senaraikan tatasusunan jadual dan setkan pembolehubah
        $bulanan = bulanan('data_bulanan','13'); # papar bulan dlm tahun semasa
        $jadualRangka = 'rangka13';
        $medanRangka ='newss,nama,ssm,' 
			. 'nota,respon,fe,tel,fax,responden,email,msic,msic08,' . "\r" 
			. 'concat(substring(newss,1,3),\' \',substring(newss,4,3),\' \',' 
			. 'substring(newss,7,3),\' \',substring(newss,10,3),\' | \',' 
			. '\' \',msic) as ' . '`id U M`';
        $medanData = 'newss,fe,nama,terima,hantar,catatan';
        $sv='mm_'; // survey apa
        $cari['medan'] = 'newss'; // cari dalam medan apa
        $id = isset($cariID) ? $cariID : null; // cari id berasaskan sidap
        $cari['id'] = $id; // benda yang dicari
        $this->papar->kesID = array();

        if (!empty($id)) 
        {
            //echo '$id:' . $id . '<br>';
            $this->papar->carian='newss';
        
            // mula cari $cariID dalam $bulanan
            foreach ($bulanan as $key => $myTable)
            {// mula ulang table
                $this->papar->kesID[$myTable] = 
                    $this->tanya->cariSemuaMedan($sv . $myTable, 
                    $medanData, $cari);
            }// tamat ulang table

            // semak dalam rangka pulak
            $this->papar->rangka['kes'] = 
                $this->tanya->cariSemuaMedan($sv . $jadualRangka, 
                $medanRangka, $cari);
			
        }
        else
        {
            $this->papar->carian='[tiada id diisi]';
        }
        
        // isytihar pemboleubah
        $tajuk2=array('bulan','nama','terima','hantar','catatan');
        $this->papar->paparTajuk = null;
        $s1 = '<span class="label">';
        $s2 = '</span>';
        foreach ($tajuk2 as $tajuk)
        {
            $this->papar->paparTajuk .= "\n" . '<th>' . $s1 . $tajuk . $s2 . '</th>';
        }

        $this->papar->pegawai = senarai_kakitangan();
        $this->papar->lokasi = 'MM13 - Buang';
		$this->papar->cari = $id;
		
	
        // paparkan ke fail cimej/cari.php
        $this->papar->baca('kawalan/buang', 1);

    }
/*
000000495684	255560	EASTOOL INDUSTRIES SDN. BHD.
NO. 133-139, JALAN SEGAMAT,TAMAN LABIS,85300 LABIS JOHOR
	public function buangTerus($dataID)
    {
        $bulanan = bulanan('kawalan','13'); # papar bulan dlm tahun semasa
        $posmen = array();
        $id = 'newss';
    
        foreach ($_POST as $key => $value)
        {
            if ( in_array($key,$bulanan) )
            {
                $myTable = 'mm_' . $key;
                foreach ($value as $kekunci => $papar)
                {
                    $posmen[$myTable][$kekunci] = bersih($papar);
                }
                $posmen[$myTable][$id] = bersih($dataID);
            }
        }
        
        // mula ulang $bulanan       
        foreach ($bulanan as $kunci => $jadual)
        {// mula ulang table
            $myTable = 'mm_' . $jadual;
			$data = $posmen[$myTable];
            $this->tanya->buangTerus($data, $myTable);
        }// tamat ulang table
        
        //$this->papar->baca('kawalan/ubah/' . $dataID);
        header('location: ' . URL . 'kawalan/semua/30/1');
        
    }
*/
}