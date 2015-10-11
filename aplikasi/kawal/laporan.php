<?php

class Laporan extends Kawal 
{

    public function __construct() 
    {
        parent::__construct();
        Kebenaran::kawalKeluar();
        
        $this->papar->js = array(
            //'bootstrap.js',
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
            'bootstrap-affix.js',
            'bootstrap-datepicker.js',
            'bootstrap-datepicker.ms.js',
            'bootstrap-editable.min.js');
        $this->papar->css = array(
            'bootstrap-datepicker.css',
            'bootstrap-editable.css');
		$this->_folder = 'laporan';
    }
    
    public function index($item = 30, $ms = 1, $fe = null) 
    {    
		echo 'index($item = 30, $ms = 1, $fe = null)<br>';
    }

	public function bulanan() 
	{	
		//$carian[] = array('fix'=>'like','atau'=>'WHERE','medan'=>'hantar','apa'=>$hantar);
		$carian = null;
		$jadual = 'ejob14_q1';
		$jum = pencamSqlLimit($bilSemua = 500, $item = 30, $ms = 1, $orderBy = '1,2', $groupBy = '1,2');
		$laporan = $this->tanya->laporan_bulanan($jadual, $jum);
		$this->papar->cariNama[$jadual] = $laporan;
        # semak pembolehubah $laporan
        //echo '<pre>', print_r($laporan, 1) . '</pre><br>';

		// Set pemboleubah utama
		$this->papar->pegawai = senarai_kakitangan();
		$this->papar->fungsi = 'bulanan';
		$this->papar->url = dpt_url();
		// pergi papar kandungan
		$this->papar->baca('laporan/index', 0);
	}

	public function daerah() 
	{	
		//$carian[] = array('fix'=>'like','atau'=>'WHERE','medan'=>'hantar','apa'=>$hantar);
		$carian = null;
		$jadual = 'ejob14_q1';
		$jum = pencamSqlLimit($bilSemua = 500, $item = 30, $ms = 1, $orderBy = '1,2', $groupBy = '1,2');
		$laporan = $this->tanya->laporan_daerah($jadual, $jum);
		$this->papar->cariNama[$jadual] = $laporan;
        # semak pembolehubah $laporan
        //echo '<pre>', print_r($laporan, 1) . '</pre><br>';

		// Set pemboleubah utama
		$this->papar->pegawai = senarai_kakitangan();
		$this->papar->fungsi = 'daerah';
		$this->papar->url = dpt_url();
		// pergi papar kandungan
		$this->papar->baca('laporan/index', 0);
	}

	public function fe() 
	{	
		//$carian[] = array('fix'=>'like','atau'=>'WHERE','medan'=>'hantar','apa'=>$hantar);
		$carian = null;
		$jadual = 'ejob14_q1';
		$jum = pencamSqlLimit($bilSemua = 500, $item = 30, $ms = 1, $orderBy = '1,2', $groupBy = '1,2');
		$laporan = $this->tanya->laporan_fe($jadual, $jum);
		$this->papar->cariNama[$jadual] = $laporan;
        # semak pembolehubah $laporan
        //echo '<pre>', print_r($laporan, 1) . '</pre><br>';

		// Set pemboleubah utama
		$this->papar->pegawai = senarai_kakitangan();
		$this->papar->fungsi = 'fe';
		$this->papar->url = dpt_url();
		// pergi papar kandungan
		$this->papar->baca('laporan/index', 0);
	}

	public function a8() 
	{	
		$carian[] = array('fix'=>'like','atau'=>'WHERE','medan'=>'borang','apa'=>'A8');
		$jum = pencamSqlLimit($bilSemua = 500, $item = 30, $ms = 1, $orderBy = null, $groupBy = null);
		$laporan = $this->tanya->cariSemuaData($myTable = 'ejob14_q1', 
			'newss,concat_ws("<br>",nama,operator) nama,msic2008,kp,batchAwal,fe,nota,'
			. 'concat_ws(" ",alamat1,alamat2,poskod,bandar,negeri) as alamat' . "\r"
			,$carian, $jum);
		$this->papar->cariNama[$myTable] = $laporan;
        # semak pembolehubah $laporan
        //echo '<pre>', print_r($laporan, 1) . '</pre><br>';

		// Set pemboleubah utama
		$this->papar->pegawai = senarai_kakitangan();
		$this->papar->fungsi = 'A8';
		$this->papar->url = dpt_url();
		// pergi papar kandungan
		$this->papar->baca('laporan/index', 0);
	}

	public function limaUtama($cariBatch = 'murad') 
	{	
		$carian[] = array('fix'=>'like','atau'=>'WHERE','medan'=>'batchAwal','apa'=>$cariBatch,'akhir'=>NULL);
		$carian[] = array('fix'=>'x!=','atau'=>'AND (','medan'=>'hasil_cdt','apa'=>'','akhir'=>NULL);
		$carian[] = array('fix'=>'x!=','atau'=>'OR','medan'=>'hasil_cdt','apa'=>'','akhir'=>')');
		$jum = pencamSqlLimit($bilSemua = 500, $item = 30, $ms = 1, $orderBy = null, $groupBy = null);
		$laporan = $this->tanya->cariSemuaData($myTable = 'data_tembak', 
			  'newss,concat_ws("|",nama,operator,tel_newss) nama,'
			. 'concat_ws(" ",msic2008,kp,batchAwal) m6,'
			. 'concat_ws(" ",alamat1,alamat2,poskod,bandar,negeri) as alamat,' . "\r"
			. 'format(hasil_cdt,0) hasil_cdt,format(hasil_icdt,0) hasil_icdt,'
			. 'format(belanja_cdt,0) belanja_cdt,format(belanja_icdt,0) belanja_icdt,'
			. 'lelaki_cdt,lelaki_icdt,wanita_cdt,wanita_icdt,'
			. 'format(gaji_cdt,0) gaji_cdt,format(gaji_icdt,0) gaji_icdt,'
			. 'format(aset_cdt,0) aset_cdt,format(aset_icdt,0) aset_icdt,'
			. 'format(stok_cdt,0) stok_cdt,format(stok_icdt,0) stok_icdt'
			,$carian, $jum);
		$this->papar->cariNama[$myTable] = $laporan;
        # semak pembolehubah $laporan
        //echo '<pre>', print_r($laporan, 1) . '</pre><br>';

		// Set pemboleubah utama
		$this->papar->pegawai = senarai_kakitangan();
		$this->papar->fungsi = 'limaUtama';
		$this->papar->url = dpt_url();
		// pergi papar kandungan
		$this->papar->baca('laporan/index', 0);
	}

	public function masalah() 
	{	
		//$carian[] = array('fix'=>'like','atau'=>'WHERE','medan'=>'hantar','apa'=>$hantar);
		$carian = null;
		$jadual = 'ejob14_q1';
		$jum = pencamSqlLimit($bilSemua = 500, $item = 30, $ms = 1, $orderBy = '1,2', $groupBy = '1,2');
		$laporan = $this->tanya->laporan_daerah($jadual, $jum);
		$this->papar->cariNama[$jadual] = $laporan;
        # semak pembolehubah $laporan
        //echo '<pre>', print_r($laporan, 1) . '</pre><br>';

		// Set pemboleubah utama
		$this->papar->pegawai = senarai_kakitangan();
		$this->papar->fungsi = 'tahunan';
		$this->papar->url = dpt_url();
		// pergi papar kandungan
		$this->papar->baca('laporan/index', 0);
	}
	
	public function utama($jadual = 'jan13') 
	{	
		// Set pemboleubah utama
		$this->papar->pegawai = senarai_kakitangan();
		$this->papar->fungsi = 'bulanan';
		$this->papar->url = dpt_url();
		// pergi papar kandungan
		$this->papar->baca('laporan/index', 0);
	}

	public function cetakA1($hantar, $item = 300, $ms = 1)
	{
		# kiraKes dulu
		$jadual = 'ejob14_q1';
		$respon = 'A1'; $kp = '327'; $borang = '2';
			$carian[] = array('fix'=>'like','atau'=>'WHERE','medan'=>'hantar_prosesan','apa'=>$hantar);
			$carian[] = array('fix'=>'x=','atau'=>'AND','medan'=>'respon','apa'=>$respon);
			//$carian[] = array('fix'=>'==','atau'=>'AND','medan'=>'kp','apa'=>$kp);
			//$carian[] = array('fix'=>'like','atau'=>'AND','medan'=>'borang','apa'=>$borang);
			//$carian[] = array('fix'=>'xin','atau'=>'AND','medan'=>'batchAwal','apa'=>"('amin007','mdt-amin007')");

		$bilSemua = $this->tanya->kiraKes($jadual, $medan = '*', $carian);
		# tentukan bilangan mukasurat. bilangan jumlah rekod
		//echo '$bilSemua:' . $bilSemua . ', $item:' . $item . ', $ms:' . $ms . '<br>';
		$jum = pencamSqlLimit($bilSemua, $item, $ms);
		$susun[] = array_merge($jum, array('kumpul'=>null, 'susun'=>'kp, borang, nama' ) );

		# kumpul respon
		$kumpul = $this->tanya->cariSemuaData($jadual, 
			$medan = " newss, concat_ws(' | ',nama,operator) nama,"
				   . " concat_ws('-',kp,borang) kp,"
				   . " if(respon='A1',respon,'&nbsp;') A1,"
				   . " if(respon!='A1',respon,'&nbsp;') NONA1,"
				   . " nota_prosesan",
			$carian, $susun);
		
		//echo '<pre>$kumpul:'; print_r($kumpul) . '</pre>';
		
		# Set pembolehubah
		$this->papar->hasil = $kumpul;
		# Set pemboleubah utama
        $this->papar->pegawai = senarai_kakitangan();
        $this->papar->lokasi = 'CDT 2014 - Ubah';
		
		 # pergi papar kandungan
		//echo '<br>location: ' . URL . "batchawal/semak/$cariBatch/$dataID" . '';
		$this->papar->baca('laporan/f10', 1);
//*/		
	}
	
	public function cetakNonA1($hantar, $item = 300, $ms = 1)
	{
		# kiraKes dulu
		$jadual = 'ejob14_q1';
		$respon = 'A1'; $kp = '327'; $borang = '2';
			$carian[] = array('fix'=>'like','atau'=>'WHERE','medan'=>'hantar_prosesan','apa'=>$hantar);
			$carian[] = array('fix'=>'x!=','atau'=>'AND','medan'=>'respon','apa'=>$respon);
			//$carian[] = array('fix'=>'==','atau'=>'AND','medan'=>'kp','apa'=>$kp);
			//$carian[] = array('fix'=>'like','atau'=>'AND','medan'=>'borang','apa'=>$borang);
			//$carian[] = array('fix'=>'xin','atau'=>'AND','medan'=>'batchAwal','apa'=>"('amin007','mdt-amin007')");

		$bilSemua = $this->tanya->kiraKes($jadual, $medan = '*', $carian);
		# tentukan bilangan mukasurat. bilangan jumlah rekod
		//echo '$bilSemua:' . $bilSemua . ', $item:' . $item . ', $ms:' . $ms . '<br>';
		$jum = pencamSqlLimit($bilSemua, $item, $ms);
		$susun[] = array_merge($jum, array('kumpul'=>null, 'susun'=>'kp, borang, nama' ) );

		# kumpul respon
		$kumpul = $this->tanya->cariSemuaData($jadual, 
			$medan = " newss, concat_ws(' | ',nama,operator) nama,"
				   . " concat_ws('-',kp,borang) kp,"
				   . " if(respon='A1',respon,'&nbsp;') A1,"
				   . " if(respon!='A1',respon,'&nbsp;') NONA1,"
				   . " nota_prosesan",
			$carian, $susun);
		
		//echo '<pre>$kumpul:'; print_r($kumpul) . '</pre>';
		# Set pembolehubah
		$this->papar->hasil = $kumpul;
		# Set pemboleubah utama
        $this->papar->pegawai = senarai_kakitangan();
        $this->papar->lokasi = 'CDT 2014 - Ubah';
		
		 # pergi papar kandungan
		//echo '<br>location: ' . URL . "batchawal/semak/$cariBatch/$dataID" . '';
		$this->papar->baca('laporan/f10', 1);
//*/		
	}

	public function cetakf10($cariBatch,$item = null)
	{
		# kiraKes dulu
		$item = 30; $ms = 1;
		$jadual = 'ejob14_q1';
		//$carian[] = array('fix'=>'x=','atau'=>'WHERE','medan'=>'batchProses','apa'=>$cariBatch);
		$carian[] = array('fix'=>'x=','atau'=>'WHERE','medan'=>'hantar','apa'=>$cariBatch);
		$bilSemua = $this->tanya->kiraKes($jadual, $medan = '*', $carian);
		# tentukan bilangan mukasurat. bilangan jumlah rekod
		//echo '$bilSemua:' . $bilSemua . ', $item:' . $item . ', $ms:' . $ms . '<br>';
		$jum = pencamSqlLimit($bilSemua, $item, $ms, 'respon ASC,nama', null);

		# kumpul respon
		$kumpul = $this->tanya->cariSemuaData($jadual, 
			$medan = "newss, concat_ws('<br',nama,operator) nama,"
				   . " concat_ws('-',kp,borang) kp,"
				   . " if(respon='A1',respon,'&nbsp;') A1,"
				   . " if(respon!='A1',respon,'&nbsp;') NONA1, nota",
			$carian, $jum);
		
		//echo '<pre>$kumpul:'; print_r($kumpul) . '</pre>';
		# Set pembolehubah
		$this->papar->hasil = $kumpul;
		$this->papar->fe = $cariBatch;
		# Set pemboleubah utama
        $this->papar->pegawai = senarai_kakitangan();
        $this->papar->lokasi = 'CDT 2014 - Ubah';
		
		 # pergi papar kandungan
		//echo '<br>location: ' . URL . "batchawal/semak/$cariBatch/$dataID" . '';
		$this->papar->baca('laporan/f10', 1);
//*/		
	}
# hantar kawalan ke en razak
	public function cetakSelesai($cariBatch = null,$cariTarikh = null,$item = 30)
	{
		# kiraKes dulu
		$ms = 1;
		$jadual = 'ejob14_q1';
		$carian[] = array('fix'=>'like','atau'=>'WHERE','medan'=>'batchAwal','apa'=>"%$cariBatch");
		$carian[] = array('fix'=>'x=','atau'=>'AND','medan'=>'hantar','apa'=>$cariTarikh);
		$carian[] = array('fix'=>'x=','atau'=>'AND','medan'=>'respon','apa'=>'A1');		
		$bilSemua = $this->tanya->kiraKes($jadual, $medan = '*', $carian);
		# tentukan bilangan mukasurat. bilangan jumlah rekod
		//echo '$bilSemua:' . $bilSemua . ', $item:' . $item . ', $ms:' . $ms . '<br>';
		$jum = pencamSqlLimit($bilSemua, $item, $ms);
		$kumpul = array('kumpul'=>'', 'susun'=>'kp ASC, nama');
		$susun[] = array_merge($jum, $kumpul );
		# kumpul respon
		$kumpul = $this->tanya->cariSemuaData($jadual, 
			$medan = "newss, concat_ws('<br>',nama,operator) nama,"
				   . " concat_ws('|',kp,borang) kp,"
				   . " if(respon='A1',respon,'&nbsp;') A1,"
				   . " if(respon!='A1',respon,'&nbsp;') NONA1, "
				   //. 'concat_ws("|",concat("hasil=",hasil),concat("belanja=",belanja),' 
				   //. 'concat("gaji=",gaji),concat("aset=",aset),concat("staf=",staf),'
				   . 'concat_ws("|",concat("nobp=",ngdbbp_baru),nota) as nota'
			,$carian, $susun);
		
		//echo '<pre>$kumpul:'; print_r($kumpul) . '</pre>';
		//echo '<pre>$cariBatch:' . $cariBatch . '</pre>';
		# Set pembolehubah
		$this->papar->hasil = $kumpul;
		$this->papar->fe = $cariBatch;
		# Set pemboleubah utama
        $this->papar->pegawai = senarai_kakitangan();
        $this->papar->lokasi = 'CDT 2014 - Ubah';
		
		 # pergi papar kandungan
		//echo '<br>location: ' . URL . "batchawal/semak/$cariBatch/$dataID" . '';
		$this->papar->baca('laporan/f10_kawalan', 1);
//*/		
	}

	public function cetakNegatif($cariBatch,$cariTarikh = null,$item = null)
	{
		# kiraKes dulu
		$ms = 1; //$item = 60;  //echo "\$cariTarikh = $cariTarikh\n";
		$jadual = 'ejob14_q1';
		$carian[] = array('fix'=>'like','atau'=>'WHERE','medan'=>'batchAwal','apa'=>"%$cariBatch");
		$carian[] = array('fix'=>'x=','atau'=>'AND','medan'=>'hantar','apa'=>$cariTarikh);
		$carian[] = array('fix'=>'xin','atau'=>'AND','medan'=>'respon','apa'=>"('A1','B1','B2','B3','B4','B5','B6','B7')");
		$bilSemua = $this->tanya->kiraKes($jadual, $medan = '*', $carian);
		# tentukan bilangan mukasurat. bilangan jumlah rekod
		//echo '$bilSemua:' . $bilSemua . ', $item:' . $item . ', $ms:' . $ms . '<br>';
		$jum = pencamSqlLimit($bilSemua, $item, $ms);
		$kumpul = array('kumpul'=>'', 'susun'=>'hantar DESC,respon,lawat,nama');
		$susun[] = array_merge($jum, $kumpul );
		//echo '<pre>susun:'; print_r($susun) . '</pre><br>';

		# kumpul respon
		$kumpul = $this->tanya->cariSemuaData($jadual, 
			$medan = "newss, concat_ws('|',nama,operator,nossm) nama,\r"
				   . " concat_ws('<br>',kp,msic2008) kp,"
				   . " borang A1, if(respon!='A1',respon,'&nbsp;') NONA1, "
				   //. " concat_ws(' ',tel_newss,responden_newss,nota) nota"
				   . " nota"
			,$carian, $susun);
		
		//echo '<pre>$kumpul:'; print_r($kumpul) . '</pre>';
		//echo '<pre>$cariBatch:' . $cariBatch . '</pre>';
		# Set pembolehubah
		$this->papar->hasil = $kumpul;
		$this->papar->fe = $cariBatch;
		# Set pemboleubah utama
        $this->papar->pegawai = senarai_kakitangan();
        $this->papar->lokasi = 'CDT 2014 - Ubah';
		
		 # pergi papar kandungan
		//echo '<br>location: ' . URL . "batchawal/semak/$cariBatch/$dataID" . '';
		$this->papar->baca('laporan/f10_kawalan', 1);
//*/		
	}

	public function cetakf3suku($sv = 'QSS', $cariBatch, $item = 30, $ms = 1)
	{
		# kiraKes dulu
		//$jadual = 'qss14_q1';
		$jadual = 'ejob15_q1';
		$carian[] = array('fix'=>'like','atau'=>'WHERE','medan'=>'fe','apa'=>$cariBatch);
		$bilSemua = $this->tanya->kiraKes($jadual, $medan = '*', $carian);
		# tentukan bilangan mukasurat. bilangan jumlah rekod
		//echo '$bilSemua:' . $bilSemua . ', $item:' . $item . ', $ms:' . $ms . '<br>';
		$jum = pencamSqlLimit($bilSemua, $item, $ms);
		$susun[] = array_merge($jum, array('kumpul'=>null, 'susun'=>'kp, nama' ) );

		# kumpul respon
		$kumpul = $this->tanya->kumpulRespon('kod','f2','respon',
			//$medan = "concat_ws('<br>Operator:',nama,operator) nama, concat_ws(' ',kp) as 'sv', "
			$medan = "concat_ws('',nama,operator) nama, concat_ws(' ',kp) as 'sv', "
				   . "'' utama, newss, '' nota",
			$jadual,$carian,$susun);
		//echo '<pre>$kumpul:'; print_r($kumpul) . '</pre>';
		$this->papar->kiraSemuaBaris = $bilSemua;
		$this->papar->item = $item;
		$this->papar->ms = $ms;
		$this->papar->hasil = $kumpul['kiraData'];
		$this->papar->fe = $cariBatch;
		$this->papar->kp = $sv;
		//$this->papar->halaman = halamanf3($jum);

		# Set pemboleubah utama
        $this->papar->pegawai = senarai_kakitangan();
        $this->papar->lokasi = 'QSS 2014 - F3';
		
		# pergi papar kandungan
		//echo '<br>location: ' . URL . "batchawal/semak/$cariBatch/$dataID" . '';
		//$this->papar->baca('kawalan/batchsemak_cetak', 1);
		$this->papar->baca('laporan/f3all', 1);
	}
// cetak f3 - senarai nama syarikat ikut fe/batchAwal
	public function cetakf3($cariBatch, $item = 30, $ms = 1)
	{
		# kiraKes dulu
		$jadual = 'ejob14_q1';
		$carian[] = array('fix'=>'like','atau'=>'WHERE','medan'=>'batchAwal','apa'=>$cariBatch);
		$bilSemua = $this->tanya->kiraKes($jadual, $medan = '*', $carian);
		# tentukan bilangan mukasurat. bilangan jumlah rekod
		//echo '$bilSemua:' . $bilSemua . ', $item:' . $item . ', $ms:' . $ms . '<br>';
		$jum = pencamSqlLimit($bilSemua, $item, $ms);
		$susun[] = array_merge($jum, array('kumpul'=>null,'susun'=>'kp,nama ASC') );
		# kumpul respon
		$kumpul = $this->tanya->kumpulRespon('kod','f2','respon',
			$medan = "concat_ws('<br>Operator:',nama,operator) nama, concat_ws(' ',kp) as 'sv', "
				   . "utama, newss, concat_ws(' ',respon,dsk,nota) nota",
			$jadual,$carian,$susun);
		//echo '<pre>$kumpul:'; print_r($kumpul) . '</pre>';
		$this->papar->kiraSemuaBaris = $bilSemua;
		$this->papar->item = $item;
		$this->papar->ms = $ms;
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
		//$jadual = 'cdt_pom_baki';
		$jadual = 'ejob14_q1';
		$carian[] = array('fix'=>'like','atau'=>'WHERE','medan'=>'batchAwal','apa'=>$cariBatch);
		$bilSemua = $this->tanya->kiraKes($jadual, $medan = '*', $carian);
		# tentukan bilangan mukasurat. bilangan jumlah rekod
		//echo '$bilSemua:' . $bilSemua . ', $item:' . $item . ', $ms:' . $ms . '<br>';
		$jum = pencamSqlLimit($bilSemua, $item, $ms);
		$susun[] = array_merge($jum, array('kumpul'=>null, 'susun'=>'nama ASC' ) );
		# kumpul respon
		$kumpul = $this->tanya->kumpulRespon('kod','f2','respon',
			$medan = "concat_ws('<br>Operator:',nama,operator) nama, concat_ws(' ',kp) as 'sv', "
				. "'' utama, newss, nota",
			$jadual,$carian,$susun);
		//echo '<pre>$kumpul:'; print_r($kumpul) . '</pre>';
		$this->papar->kiraSemuaBaris = $bilSemua;
		$this->papar->item = $item;
		$this->papar->ms = $ms;	
		$this->papar->hasil = $kumpul['kiraData'];
		$this->papar->fe = $cariBatch;
		$this->papar->halaman = halaman($jum);

		# Set pemboleubah utama
        $this->papar->pegawai = senarai_kakitangan();
        $this->papar->lokasi = 'CDT 2014 - Ubah';
		
		 # pergi papar kandungan
		//echo '<br>location: ' . URL . "batchawal/semak/$cariBatch/$dataID" . '';
		//$this->papar->baca('kawalan/batchsemak_cetak', 1);
		$this->papar->baca('laporan/f3all', 1);
	}

	public function cetakf3kosong($cariBatch, $item = 30, $ms = 1)
	{
		# kiraKes dulu
		$jadual = 'bst15_q3';
		$carian = null;
		//$carian[] = array('fix'=>'like','atau'=>'WHERE','medan'=>'msic2008','apa'=>null);
		$bilSemua = $this->tanya->kiraKes($jadual, $medan = '*', $carian);
		# tentukan bilangan mukasurat. bilangan jumlah rekod
		//echo '$bilSemua:' . $bilSemua . ', $item:' . $item . ', $ms:' . $ms . '<br>';
		$jum = pencamSqlLimit($bilSemua, $item, $ms);
		//$susun[] = array_merge($jum, array('kumpul'=>null, 'susun'=>'borang DESC,fe DESC,nama ASC' ) );
		$susun[] = array_merge($jum, array('kumpul'=>null, 'susun'=>'nama ASC' ) );
		# kumpul respon
		$kumpul = $this->tanya->kumpulRespon('kod','f2','respon',
			$medan = "concat_ws('',nama) nama, concat_ws(' ',kp) as 'sv', "
				. "utama, newss, concat_ws(' msic2008 ','',msic2008) nota",
			$jadual,$carian,$susun);
		//echo '<pre>$kumpul:'; print_r($kumpul) . '</pre>';
		$this->papar->kiraSemuaBaris = $bilSemua;
		$this->papar->item = $item;
		$this->papar->ms = $ms;	
		$this->papar->hasil = $kumpul['kiraData'];
		$this->papar->fe = $cariBatch;
		$this->papar->kp = 'BST';
		$this->papar->halaman = halaman($jum);

		# Set pemboleubah utama
        $this->papar->pegawai = senarai_kakitangan();
        $this->papar->lokasi = 'CDT 2014 - Ubah';
		
		 # pergi papar kandungan
		//echo '<br>location: ' . URL . "batchawal/semak/$cariBatch/$dataID" . '';
		//$this->papar->baca('kawalan/batchsemak_cetak', 1);
		$this->papar->baca('laporan/f3all', 1);
	}
////////////////////////////////////////////////////////////////////////////////////////////////////////
	
}