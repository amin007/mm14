<?php

class Suku1 extends Kawal 
{

	public function __construct() 
	{
		parent::__construct();
		Kebenaran::kawalKeluar();	
		//$this->papar->js = array('ruangtamu/js/default.js');
		$this->papar->js = array(
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
			'bootstrap-datepicker.ms.js');
		$this->papar->css = array(
			'bootstrap-datepicker.css');
		$this->papar->kelas = 'suku1/';
		$this->_folder = 'suku1/';
		$this->_jadual = 'qss14_q1';
		$this->_medan  = '*';
	}
	
	public function index() 
	{	//echo 'class qss2 fungsi index()<br>';		
		
		// papar semua data
		$this->papar->senaraiData[$this->_jadual] = 
			$this->tanya->paparIkutSurvey($this->_jadual);
		$this->papar->medanID ='subsektor';
		//echo '<pre>$senaraiData->', print_r($this->papar->senaraiData, 1) . '</pre>';# papar $senaraiData
		
		// Set pemboleubah utama
		$this->papar->pegawai = senarai_kakitangan();
		$this->papar->Tajuk_Muka_Surat='MM 2012';
		$this->papar->gambar=gambar_latarbelakang('../../');		

		// pergi papar kandungan fungsi papar($this->_folder) dalam KAWAL
		$fail = Kebenaran::papar($this->_folder);
		$this->papar->baca($fail);
	}

	public function asing($medanID, $cariID, $cetak = 'cetak') 
	{	//echo 'class qss4 fungsi index()<br>';		
		$cari[] = array('fix'=>'x','atau'=>'WHERE',
			'medan'=>$medanID,'apa'=>$cariID);
		$susun[] = array('susun'=>'subsektor,newss',
			'dari'=>'0','max'=>'30');

		// papar semua data
		$this->papar->senaraiData[$this->_jadual] = 
			$this->tanya->asingSv($this->_jadual, 
			'subsektor,newss,nossm,respon'
			. ',concat_ws(\' \',nama,operator) as `kod2`'
			. ',concat_ws(\'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\',newss,\'QSS2013\',msic2008) as `kod`'
			. ',concat_ws(\' \',fe,respon,msic2008,utama) as `keputusan`'
			. ',concat_ws(\' \',alamat1,alamat2,poskod,bandar) as `alamat penuh`' 
			//. ',concat_ws(\'\',utama,msic2008,ngdbbp) as kod3'
			. '',$cari,$susun);
		$this->papar->medanID ='newss';
		//echo '<pre>$senaraiData->', print_r($this->papar->senaraiData, 1) . '</pre>';# papar $senaraiData
		
		// Set pemboleubah utama
		$this->papar->cetak = 'cetak';
		$this->papar->pegawai = senarai_kakitangan();
		$this->papar->Tajuk_Muka_Surat='qss 2014';
		$this->papar->gambar=gambar_latarbelakang('../../');		

		// pergi papar kandungan fungsi papar($this->_folder) dalam KAWAL
		$this->papar->baca(Kebenaran::papar($this->_folder), 1);
	}

	public function cetakf3($medanID, $cariID, $cetak = 'cetak') 
	{
		# kiraKes dulu
		$item = 30; $ms = 1;
		$jadual = $this->_jadual;
		//$carian[] = array('fix'=>'x','atau'=>'WHERE','medan'=>'batchAwal','apa'=>$cariBatch);
		$carian[] = array('fix'=>'x','atau'=>'WHERE',
			'medan'=>$medanID,'apa'=>$cariID);
		$susun[] = array('susun'=>'subsektor,newss',
			'dari'=>'0','max'=>'30');

		$bilSemua = $this->tanya->kiraBaris($jadual, $medan = '*', $carian);
		# tentukan bilangan mukasurat. bilangan jumlah rekod
		//echo '$bilSemua:' . $bilSemua . ', $item:' . $item . ', $ms:' . $ms . '<br>';
		$jum = pencamSqlLimit($bilSemua, $item, $ms, null, 'subsektor,newss');

		# kumpul respon
		$kumpul = $this->tanya->kumpulRespon('kod','f2','respon',
			$medan = "nama, sv as 'sv', utama, newss",$jadual,$carian,$jum);
		//echo '<pre>$kumpul:'; print_r($kumpul) . '</pre>';
		$this->papar->kiraBaris = $kumpul['kiraBaris'];
		$this->papar->kiraMedan = $kumpul['kiraMedan'];
		$this->papar->hasil = $kumpul['kiraData'];

		# Set pemboleubah utama
        $this->papar->pegawai = senarai_kakitangan();
        $this->papar->lokasi = 'QSS : FE';
		
		 # pergi papar kandungan
		//echo '<br>location: ' . URL . "batchawal/semak/$cariBatch/$dataID" . '';
		$this->papar->baca('kawalan/cetakf3', 1);
	}
	
		
	public function papar($newss) 
	{	
		if ( is_numeric($newss) )
			$cari[] = array('fix'=>'x','atau'=>'WHERE',
				'medan'=>'newss','apa'=>$cariID);
		else
			$cari[] = array('fix'=>'x','atau'=>'WHERE',
				'medan'=>'fe','apa'=>'semak');			
		
		// papar semua data
		$this->papar->senaraiData[$this->_jadual] = 
			$this->tanya->paparPOM($this->_jadual, 'newss,nama,po'
			. ',concat_ws(\'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\',newss,\'QSS2013\',msic2008'
			. ') as `kod`,sidap'
			. ',concat_ws(\'<br>\',pengurus,nama,operator) as `kod2`'
			. ',concat_ws(' . "'<br>\n'" . ',alamat1,alamat2,poskod,bandar,ng) as `alamat penuh`' 
			. ',concat_ws(' . "'<br>\n'" . ',utama,msic2008,ngdbbp) as kod3'
			. ',subsektor',$cari);
		$this->papar->medanID ='newss';
		echo '<pre>$senaraiData->', print_r($this->papar->senaraiData, 1) . '</pre>';# papar $senaraiData

		// Set pemboleubah utama
		$this->papar->pegawai = senarai_kakitangan();
		$this->papar->Tajuk_Muka_Surat='MM 2012';
		$this->papar->gambar=gambar_latarbelakang('../../');

		// pergi papar kandungan fungsi papar($this->_folder) dalam KAWAL
		$fail = Kebenaran::papar($this->_folder);
		$this->papar->baca($fail);
	}
	
	public function cari() 
	{	
		$jadual['nama'] = $this->_jadual;
		$senarai = $this->tanya->paparMedan($jadual['nama']);
		
		# Memilih nama medan dalam jadual berkenaan
		foreach ($senarai as $key => $medan): #mula ulang $kunci
			$jadual['medan'][$key] = $medan['Field'];
		endforeach; #tamat ulang $kunci

		//echo '<pre>$jadual->', print_r($jadual, 1) . '</pre>';# papar $jadual

		$this->papar->paparMedan = $jadual;
		$this->papar->url = dpt_url();

		// Set pemboleubah utama
		$this->papar->pegawai = senarai_kakitangan();
		$this->papar->Tajuk_Muka_Surat='MM 2012';
		$this->papar->gambar=gambar_latarbelakang('../../');

		// pergi papar kandungan
		$this->papar->baca($this->_folder . 'cari');
	}

	function pada($bil,$mukasurat) 
	{
		/*
		 * fungsi ini memaparkan hasil carian
		 */
		 
		$had = '0, ' . $bil;
		//echo '<pre>$url->', print_r($url, 1) . '</pre>';
	
		$kira = pecah_post(); # echo '<pre>$kira->'; print_r($kira); echo '</pre>';
		// setkan pembolehubah dulu
		$namajadual = isset($_POST['namajadual']) ? $_POST['namajadual'] : null;
		$susun = isset($_POST['susun']) ? $_POST['susun'] : 1;
		$carian = isset($_POST['cari']) ? $_POST['cari'] : null;
		$semak = isset($_POST['cari'][1]) ? $_POST['cari'][1] : null;
		$this->papar->cariNama = null;
				
		if (empty($semak)) 
		{
			header('location:' . URL . 'cari/' . $namajadual . '/1');
			exit;	
		}
		elseif (!empty($namajadual) && $namajadual==$this->_jadual) 
		{
			$myTable = $namajadual;
			// mula cari $cariID dalam $jadual
			$this->papar->cariApa[$myTable] = 
				$this->tanya->cariBanyakMedan($myTable, 
				'newss,nama,po'
				. ',concat_ws(\'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\',newss,\'QSS2013\',msic2008'
				. ') as `kod`,sidap'
				. ',concat_ws(\'<br>\',pengurus,nama,operator) as `kod2`'
				. ',concat_ws(' . "'<br>\n'" . ',alamat1,alamat2,poskod,bandar,ng) as `alamat penuh`' 
				. ',concat_ws(' . "'<br>\n'" . ',utama,msic2008,ngdbbp) as kod3'
				. ',subsektor',$kira, $had);
			$this->papar->carian = $carian;
			$this->papar->kekunci_utama = 'newss';
		}

		//echo '<pre>$this->papar->cariApa:', print_r($this->papar->cariApa, 1) . '</pre>';

		// Set pemboleubah utama
		$this->papar->pegawai = senarai_kakitangan();
		$this->papar->Tajuk_Muka_Surat='Qss Suku 2';
		$this->papar->gambar=gambar_latarbelakang('../../');

		// pergi papar kandungan
		$this->papar->baca($this->_folder . 'jumpa');

	}
	
	function tambah() 
	{				
		$myTable = $this->_jadual;
		
		// set dalam KAWAL sahaja
		$paparMedan[$myTable] = $this->tanya->paparMedan($myTable);
		// dapatkan nama_medan,jenis_medan,input_medan 
		// dlm class Borang::tambah()
		Borang::tambah($paparMedan);
		
		// set dalam LIHAT sahaja
		$this->papar->paparMedan[$myTable] = $paparMedan[$myTable];
	
		// Set pemboleubah utama
		$this->papar->pegawai = senarai_kakitangan();
		$this->papar->Tajuk_Muka_Surat='MM 2012';
		$this->papar->gambar=gambar_latarbelakang('../../');

		// pergi papar kandungan
		$this->papar->baca($this->_folder . 'tambah');
	}
	
	public function tambahSimpan() 
	{	
		// semak $_POST dalam class Borang
		$data = Borang::tambahSimpan($this->_jadual); //echo '<pre>$data:'; print_r($data) . '</pre>';
		$jadual = $data['namaJadual'];
		$this->tanya->tambahSimpan($data, $jadual);
		
		// pergi papar kandungan tambahSimpan() dalam KAWAL
		Kebenaran::tambahSimpan($this->_folder);
		//$this->papar->baca($fail);
	}
	
	public function ubah($medanID, $cariID, $mesej = null) 
	{	//echo '$this->tanya->noAhli('.$medanID.'='.$cariID .')<br>';

		$myTable = $this->_jadual;
		
		// set dalam KAWAL sahaja
		$cari[] = array('fix'=>'x','atau'=>'WHERE','medan'=>$medanID,'apa'=>$cariID);
		$noAhli = $this->tanya->cariSatu($myTable, '*', $cari);
		$paparMedan[$myTable] = $this->tanya->paparMedan($myTable);

		// dapatkan nama_medan,jenis_medan,input_medan dlm class Borang::ubah()
		$this->papar->inputBorang = Borang::ubah($noAhli, $paparMedan, $this->_medan);
				
		// set dalam LIHAT sahaja
		$this->papar->paparMedan[$myTable] = $paparMedan[$myTable];
		$this->papar->noAhli[$myTable][] = $noAhli;
		$this->papar->medan  = $medanID;
		$this->papar->cariID = $cariID;
		$this->papar->mesej = (isset($mesej)) ? $mesej : null;
				
		// Set pemboleubah utama
		$this->papar->pegawai = senarai_kakitangan();
		$this->papar->Tajuk_Muka_Surat='QSS 2014';
		$this->papar->gambar=gambar_latarbelakang('../../');

		// pergi papar kandungan
		$this->papar->baca($this->_folder . 'ubah');	
	}
	
	public function ubahSimpan($medanID, $cariID)
	{
		// semak $_POST dalam class Borang::ubahSimpan($thid->_jadual)
		$data = Borang::ubahSimpan($this->_jadual);
		$jadual = array('nama' => $data['namaJadual'],
			'medanID' => $medanID,
			'cariID' => $cariID);
		unset($data['namaJadual']);
		echo '<pre>$data:'; print_r($data) . '</pre>';
		#Do your error checking! 
		
		$semakID = $this->tanya->ubahSimpan($data, $jadual);
		$pilihID = ($cariID==$semakID) ? $cariID : $semakID;
		$ID = 'ubah/' . $medanID . '/' . $pilihID . '/berjaya';
		//*/
		// pergi papar kandungan ubahSimpan($medanID, $cariID) dalam KAWAL
		Kebenaran::ubahSimpan($this->_folder, $ID);
		//$this->papar->baca($fail);
		
	}
	
	public function buang($medanID, $cariID)
	{
		//echo '$this->tanya->buang('.$medanID.'='.$cariID .')<br>';
		$jadual = $this->_jadual;
		$cari['medan'] = $medanID;
		$cari['id'] = $cariID;

		$this->tanya->buang($jadual, null, $cari);
		header('location: ' . URL . $this->_folder);
	}

	public function rangka($medanID, $cariID, $mesej = null) 
	{	//echo '$this->tanya->noAhli('.$medanID.'='.$cariID .')<br>';

		$myTable = $this->_jadual;
		
		// set dalam KAWAL sahaja
		$cari['medan'] = $medanID;
		$cari['id'] = $cariID;
		$medan2 = 'newss,sidap,nama,fe'
			   . ',alamat1,alamat2,poskod,bandar,ng,dp' 
			   . ',utama,msic2008,msic2000,ngdbbp,subsektor';
		$medan = '*';
		$noAhli = $this->tanya->noAhli($myTable, $medan, $cari);
		$paparMedan[$myTable] = $this->tanya->paparMedan($myTable, $medan);
		
		// cari dalam prosesan
		//echo '$nosidap='.$noAhli['nosidap'].'<br>';
		$rangkaNewss = $this->tanya->cariBanyak('pom_dataekonomi.alamat_newss_2013', 'newss,sidap,nama', array('medan'=>'newss', 'id' => $cariID));
		
		$jadualProsesan = array('makanan','hartanah','ict','kesihatan','pendidikan','pengangkutan',
		'penginapan','pentadbiran','profesional','rekreasi');
		$cari['medan'] = 'daftar_18digit';
		$cari['id'] = ($noAhli['nosidap']==null) ? (int) $cariID : $noAhli['nosidap'];
		foreach ($jadualProsesan as $key => $jadual):
			$prosesan['qss_' . $jadual] = $this->tanya->cariBanyak('qss_' . $jadual, '*', $cari);
		endforeach;
		
		// semak pembolehubah
		//echo '<pre>$noAhli:'; print_r($noAhli) . '</pre>';
		//echo '<pre>$paparMedan:'; print_r($paparMedan) . '</pre>';
		//echo '<pre>$rangkaNewss:'; print_r($rangkaNewss) . '</pre>';
		//echo '<pre>$prosesan:'; print_r($prosesan) . '</pre>';		
		
		// dapatkan nama_medan,jenis_medan,input_medan dlm class Borang::ubah()
		$this->papar->inputBorang = Borang::ubah($noAhli, $paparMedan, $this->_medan);
				
		// set dalam LIHAT sahaja
		$this->papar->paparMedan[$myTable] = $paparMedan[$myTable];
		$this->papar->cariApa = $prosesan;
		$this->papar->noAhli[$myTable][] = $noAhli;
		$this->papar->medan  = $medanID;
		$this->papar->cariID = $cariID;
		$this->papar->mesej = (isset($mesej)) ? $mesej : null;
				
		// Set pemboleubah utama
		$this->papar->pegawai = senarai_kakitangan();
		$this->papar->Tajuk_Muka_Surat='QSS 2013';
		$this->papar->gambar=gambar_latarbelakang('../../');

		// pergi papar kandungan
		$this->papar->baca($this->_folder . 'export');
	}

	public function exportExcel($medanID, $cariID)
	{
		// semak pembolehubah
		//echo '<pre>$_POST:'; print_r($_POST) . '</pre>';
		//echo 'url=' . URL;
		###############################################################################
		$namasyarikat=bersih($_POST['qss12_s4']['nama']);
		$sv = Excel::pilihSurvey();
		//echo '<pre>$sv:'; print_r($sv) . '</pre>';
		//$data = Excel::$sv['template']();
		$data = Excel::simpanData(Excel::$sv['template']());
		//echo '<pre>$data:'; print_r($data) . '</pre>';
		################################################################################
		$template = $sv['template'] . '.xls'; // contoh template borang dalam excel xls
		$templateDir = '../../bg/template/borang_qss/'; // setkan folder yang ada contoh template borang

		//set tatarajah untuk class PHPReport
		$config=array(
				'template'=>$template,
				'templateDir'=>$templateDir
			);
		//echo '<pre>$config:'; print_r($config) . '</pre>';
		################################################################################

		// export to excel again
		$R=new PHPReport($config);
		$R->load($data); // $data adalah tatasusunan dari pangkalan data
		//print_r($R);
		################################################################################
		// kita boleh setkan fail untuk dimuatturun
		// seperti html, excel, excel2003 sebagai $type
		// dan $filename sebagai nama fail
		// public function render($type='html',$filename='')
		$type = array ('html','excel','excel2003');
		$filename = $namasyarikat;
		echo $R->render($type[2], $filename);
		exit();
		
	}

}
