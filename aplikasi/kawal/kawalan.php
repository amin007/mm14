<?php

class Kawalan extends Kawal 
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
			
        $this->medanRangka = 'newss,ssm,nama,fe,msic2008,alamat,'
			//. 'concat_ws("<br>",alamat1_lokasi,alamat2_lokasi,poskod_lokasi,bandar_lokasi,ng_lokasi) as alamat,' . "\r"
			. 'dp,tel,respon R';
			//. 'tel,fax,responden,email,nota,msic08';
		$this->medanData = 'b.newss,b.nama,b.fe,b.respon R,b.msic2008 M6,terima,' . "\r"
		   . 'hantar,format(gaji,0) gaji,format(staf,0) staf,format(hasil,0) hasil,b.nota';
		$this->sv = 'mm_';
		$this->pengguna = Sesi::get('namaPegawai');
		$this->level = Sesi::get('levelPegawai');
    }
    
    public function index($item = 30, $ms = 1, $fe = null) 
    {    
		$fe = ($this->level == 'kawal') ? $fe : $this->pengguna; # set nama fe
        $bulanan = bulanan('kawalan','14'); # papar bulan dlm tahun semasa     
        // setkan pembolehubah untuk $this->tanya
            $medanRangka = $this->medanRangka;
			$medanData = $this->medanData;
            $sv = $this->sv;

        // mula papar semua dalam $myTable
        foreach ($bulanan as $key => $myTable)
        {// mula ulang table
			// setkan $medan
			$medan = ($myTable=='rangka14') ? $medanRangka : $medanData;
            // dapatkan bilangan jumlah rekod
            $bilSemua = $this->tanya->kiraKes($sv, $myTable, $medan, $fe);
            // tentukan bilangan mukasurat 
            // bilangan jumlah rekod
			//echo '$bilSemua:'.$bilSemua.', $item:'.$item.', $ms:'.$ms.'<br>';
            $jum = pencamSqlLimit($bilSemua, $item, $ms);
            $this->papar->bilSemua[$myTable] = $bilSemua;
            // sql guna limit
            $this->papar->cariApa[$myTable] = $this->tanya->
            paparSemua($sv, $myTable, $medan, $fe, $jum);
            // halaman
            $this->papar->halaman[$myTable] = halaman($jum);
        }// tamat ulang table
        
        # semak pembolehubah $this->papar->cariApa
        //echo '<pre>', print_r($this->papar->cariApa, 1) . '</pre><br>';
		
        // papar
        $this->papar->pegawai = senarai_kakitangan();
        $this->papar->carian = 'semuajadual';
        $this->papar->baca('kawalan/index' ,0);
    }

    public function semua($item = 30, $ms = 1, $fe = null) 
    {    
        /*
         * $item = 30 // set bil. data dalam 1 muka surat
         * $ms = 1 // set $ms = mula surat bermula dengan 1
         * $fe = null // set $fe = pegawai kerja luar tiada
         */
		$fe = ($this->level == 'kawal') ? $fe : $this->pengguna; # set nama fe
        $bulanan = bulanan('kawalan','14'); # papar bulan dlm tahun semasa
        # semak pembolehubah $bulanan
        //echo '<pre>', print_r($bulanan, 1) . '</pre><br>';

        // setkan pembolehubah untuk $this->tanya
            $medanRangka = $this->medanRangka;
			$medanData = $this->medanData;
            $sv = $this->sv; //$myTable='rangka14';

        // mula papar semua dalam $myTable
        foreach ($bulanan as $key => $myTable)
        {// mula ulang table
			// setkan $medan 
			$medan = ($myTable=='rangka14') ? $medanRangka : $medanData;
            // dapatkan bilangan jumlah rekod
            $bilSemua = $this->tanya->kiraKes($sv, $myTable, $medan, $fe);
            // tentukan bilangan mukasurat 
            // bilangan jumlah rekod
			//echo '$bilSemua:'.$bilSemua.', $item:'.$item.', $ms:'.$ms.'<br>';
            $jum = pencamSqlLimit($bilSemua, $item, $ms);
            $this->papar->bilSemua[$myTable] = $bilSemua;
            // sql guna limit
            $this->papar->cariApa[$myTable] = $this->tanya->
            kesSemua($sv, $myTable, $medan, $fe, $jum);
            // halaman
            $this->papar->halaman[$myTable] = halaman($jum);
        }// tamat ulang table
        
        # semak pembolehubah $this->papar->cariApa
        //echo '<pre>', print_r($this->papar->cariApa, 1) . '</pre><br>';

        // Set pemboleubah utama
        $this->papar->pegawai = senarai_kakitangan();
        $this->papar->carian = 'semua';
        $this->papar->url = dpt_url();
        // pergi papar kandungan
        $this->papar->baca('kawalan/index', 0);
    }

    public function selesai($item = 30, $ms = 1, $fe = null) 
    {    
        /*
         * $item = 30 // set bil. data dalam 1 muka surat
         * $ms = 1 // set $ms = mula surat bermula dengan 1
         * $fe = null // set $fe = pegawai kerja luar tiada
         */
		$fe = ($this->level == 'kawal') ? $fe : $this->pengguna; # set nama fe
        $bulanan = bulanan('kawalan','14'); # papar bulan dlm tahun semasa
        # semak pembolehubah $bulanan
        //echo '<pre>', print_r($bulanan, 1) . '</pre><br>';

        // setkan pembolehubah untuk $this->tanya
            $medanRangka = $this->medanRangka;
			$medanData = $this->medanData;
            $sv = $this->sv;

        // mula papar semua dalam $myTable
        foreach ($bulanan as $key => $myTable)
        {// mula ulang table
			// setkan $medan
			$medan = ($myTable=='rangka13') ? $medanRangka : $medanData;
            // dapatkan bilangan jumlah rekod
            $bilSemua = $this->tanya->kiraKes($sv, $myTable, $medan, $fe);
            // tentukan bilangan mukasurat 
            // bilangan jumlah rekod
    		//echo '$bilSemua:'.$bilSemua.', $item:'.$item.', $ms:'.$ms.'<br>';
            $jum = pencamSqlLimit($bilSemua, $item, $ms);
            $this->papar->bilSemua[$myTable] = $bilSemua;
            // sql guna limit
            $this->papar->cariApa[$myTable] = $this->tanya->
            kesSelesai($sv, $myTable, $medan, $fe, $jum);
            // halaman
            $this->papar->halaman[$myTable] = halaman($jum);
        }// tamat ulang table
        
        # semak pembolehubah $this->papar->cariApa
		//echo '<pre>', print_r($this->papar->cariApa, 1) . '</pre><br>';
        
        // Set pemboleubah utama
        $this->papar->pegawai = senarai_kakitangan();
        $this->papar->carian = 'selesai';
        $this->papar->url = dpt_url();
        // pergi papar kandungan
        $this->papar->baca('kawalan/index');
    }

    public function janji($item = 30, $ms = 1, $fe = null) 
    {    
        /*
         * $item = 30 // set bil. data dalam 1 muka surat
         * $ms = 1 // set $ms = mula surat bermula dengan 1
         * $fe = null // set $fe = pegawai kerja luar tiada
         */
		$fe = ($this->level == 'kawal') ? $fe : $this->pengguna; # set nama fe
        $bulanan = bulanan('kawalan','14'); # papar bulan dlm tahun semasa
        # semak pembolehubah $bulanan
        //echo '<pre>', print_r($bulanan, 1) . '</pre><br>';

        // setkan pembolehubah untuk $this->tanya
            $medanRangka = $this->medanRangka;
			$medanData = $this->medanData;
            $sv = $this->sv;

		// mula papar semua dalam $myTable
        foreach ($bulanan as $key => $myTable)
        {// mula ulang table
			// setkan $medan
			$medan = ($myTable=='rangka13') ? $medanRangka : $medanData;
            // dapatkan bilangan jumlah rekod
            $bilSemua = $this->tanya->kiraKes($sv, $myTable, $medan, $fe);
            // tentukan bilangan mukasurat 
            // bilangan jumlah rekod
    		//echo '$bilSemua:'.$bilSemua.', $item:'.$item.', $ms:'.$ms.'<br>';
            $jum = pencamSqlLimit($bilSemua, $item, $ms);
            $this->papar->bilSemua[$myTable] = $bilSemua;
            // sql guna limit
            $this->papar->cariApa[$myTable] = $this->tanya->
            kesJanji($sv, $myTable, $medan, $fe, $jum);
            // halaman
            $this->papar->halaman[$myTable] = halaman($jum);
        }// tamat ulang table
        
        # semak pembolehubah $this->papar->cariApa
        //echo '<pre>', print_r($this->papar->cariApa, 1) . '</pre><br>';
        
        // Set pemboleubah utama
        $this->papar->pegawai = senarai_kakitangan();
        $this->papar->carian = 'belum';
        $this->papar->url = dpt_url();
        // pergi papar kandungan
        $this->papar->baca('kawalan/index');
    }

    public function belum($item = 30, $ms = 1, $fe = null) 
    {    
        /*
         * $item = 30 // set bil. data dalam 1 muka surat
         * $ms = 1 // set $ms = mula surat bermula dengan 1
         * $fe = null // set $fe = pegawai kerja luar tiada
         */
		$fe = ($this->level == 'kawal') ? $fe : $this->pengguna; # set nama fe
        $bulanan = bulanan('kawalan','14'); # papar bulan dlm tahun semasa
        # semak pembolehubah $bulanan
        //echo '<pre>', print_r($bulanan, 1) . '</pre><br>';

        // setkan pembolehubah untuk $this->tanya
            $medanRangka = $this->medanRangka;
			$medanData = $this->medanData;
            $sv = $this->sv;

		// mula papar semua dalam $myTable
        foreach ($bulanan as $key => $myTable)
        {// mula ulang table
			// setkan $medan
			$medan = ($myTable=='rangka13') ? $medanRangka : $medanData;
            // dapatkan bilangan jumlah rekod
            $bilSemua = $this->tanya->kiraKes($sv, $myTable, $medan, $fe);
            // tentukan bilangan mukasurat 
            // bilangan jumlah rekod
    		//echo '$bilSemua:'.$bilSemua.', $item:'.$item.', $ms:'.$ms.'<br>';
            $jum = pencamSqlLimit($bilSemua, $item, $ms);
            $this->papar->bilSemua[$myTable] = $bilSemua;
            // sql guna limit
            $this->papar->cariApa[$myTable] = $this->tanya->
            kesBelum($sv, $myTable, $medan, $fe, $jum);
            // halaman
            $this->papar->halaman[$myTable] = halaman($jum);
        }// tamat ulang table
        
        # semak pembolehubah $this->papar->cariApa
        //echo '<pre>', print_r($this->papar->cariApa, 1) . '</pre><br>';
        
        // Set pemboleubah utama
        $this->papar->pegawai = senarai_kakitangan();
        $this->papar->carian = 'belum';
        $this->papar->url = dpt_url();
        // pergi papar kandungan
        $this->papar->baca('kawalan/index');
    }

    public function tegar($item = 30, $ms = 1, $fe = null) 
    {    
        /*
         * $item = 30 // set bil. data dalam 1 muka surat
         * $ms = 1 // set $ms = mula surat bermula dengan 1
         * $fe = null // set $fe = pegawai kerja luar tiada
         */
		$fe = ($this->level == 'kawal') ? $fe : $this->pengguna; # set nama fe
        $bulanan = bulanan('kawalan','14'); # papar bulan dlm tahun semasa
        # semak pembolehubah $bulanan
        //echo '<pre>', print_r($bulanan, 1) . '</pre><br>';

        // setkan pembolehubah untuk $this->tanya
            $medanRangka = $this->medanRangka;
			$medanData = $this->medanData;
            $sv = $this->sv;

		// mula papar semua dalam $myTable
        foreach ($bulanan as $key => $myTable)
        {// mula ulang table
			// setkan $medan
			$medan = ($myTable=='rangka13') ? $medanRangka : $medanData;
            // dapatkan bilangan jumlah rekod
            $bilSemua = $this->tanya->kiraKes($sv, $myTable, $medan, $fe);
            // tentukan bilangan mukasurat 
            // bilangan jumlah rekod
    		//echo '$bilSemua:'.$bilSemua.', $item:'.$item.', $ms:'.$ms.'<br>';
            $jum = pencamSqlLimit($bilSemua, $item, $ms);
            $this->papar->bilSemua[$myTable] = $bilSemua;
            // sql guna limit
            $this->papar->cariApa[$myTable] = $this->tanya->
            kesTegar($sv, $myTable, $medan, $fe, $jum);
            // halaman
            $this->papar->halaman[$myTable] = halaman($jum);
        }// tamat ulang table
        
        # semak pembolehubah $this->papar->cariApa
        //echo '<pre>', print_r($this->papar->cariApa, 1) . '</pre><br>';
        
        // Set pemboleubah utama
        $this->papar->pegawai = senarai_kakitangan();
        $this->papar->carian = 'tegar';
        $this->papar->url = dpt_url();
        // pergi papar kandungan
        $this->papar->baca('kawalan/index');
    }

    public function utama($item = 30, $ms = 1, $utama = null, $respon = null, $fe = null) 
    {    
        /*
         * $item = 30 // set bil. data dalam 1 muka surat
         * $ms = 1 // set $ms = mula surat bermula dengan 1
         * $utama = null // set $utama = BBU/SBU tiada
		 * $respon = null // set $respon = a1/xa1/tegar tiada
         */
		$fe = ($this->level == 'kawal') ? $fe : $this->pengguna; # set nama fe
        $bulanan = bulanan('data_bulanan','14'); # papar bulan dlm tahun semasa
        # semak pembolehubah $bulanan
        //echo '<pre>', print_r($bulanan, 1) . '</pre><br>';

        // setkan pembolehubah untuk $this->tanya
					 //. 'format(b.hasil,0) as hasil,format(b.dptlain,0) as dptlain,' . "\r"
					 //. 'format(b.stok,0) as stok,b.staf,format(b.gaji,0) as gaji,' . "\r"
					 //. 'outlet,sebab';
            $medanRangka = $this->medanRangka;
			$medanData = $this->medanData;
            $sv = $this->sv;
			$cari['utama'] = $utama;
			$cari['respon'] = $respon;
			$cari['fe'] = $fe;
			
		// paparkan pembolehubah
			//echo ' item ' . $item . '<br>';
			//echo ' bil muka surat ' . $ms . '<br>';
			echo ' kes utama ' . $utama . '| ';
			echo ($respon==null)? '<br>' : ' respon ' . $respon . '<br>';
        // mula papar semua dalam $myTable
        foreach ($bulanan as $key => $myTable)
        {// mula ulang table
			// setkan $medan
			$medan = ($myTable=='rangka13') ? $medanRangka : $medanData;
            // dapatkan bilangan jumlah rekod
            $bilSemua = $this->tanya->kiraKesUtama($sv.$myTable, $medan, $cari);
            // tentukan bilangan mukasurat 
            // bilangan jumlah rekod
    		//echo '$bilSemua:'.$bilSemua.', $item:'.$item.', $ms:'.$ms.'<br>';
            $jum = pencamSqlLimit($bilSemua, $item, $ms);
            $this->papar->bilSemua[$myTable] = $bilSemua;
            // sql guna limit
            $this->papar->cariApa[$myTable] = $this->tanya->
            kesUtama($sv.$myTable, $medan, $cari, $jum);
            // halaman
            $this->papar->halaman[$myTable] = halaman($jum);
        }// tamat ulang table
        
        # semak pembolehubah $this->papar->cariApa
        //echo '<pre>', print_r($this->papar->cariApa, 1) . '</pre><br>';
        
        // Set pemboleubah utama
        $this->papar->pegawai = senarai_kakitangan();
        $this->papar->carian = 'utama';
        $this->papar->url = dpt_url();
        // pergi papar kandungan
        $this->papar->baca('kawalan/index', 0);
    }
    
    // semak jadualp9
    function semak() 
    {    
        $bulanan = array('pom_bln11.mm_rangka',
        'pom_bln12.mm_rangka'); 
        $myJadual = array('mm11_rangka','mm12_rangka'); 
        $myJoin = 'jadualp9'; // $semak = 'jadualp10';
        $jum['dari']=0;
        $jum['max']=300;

        // papar kes tegar dlm $myTable
        foreach ($bulanan as $key => $myTable)
        {// mula ulang table
            // senarai nama medan
            $medan = 'a.newss,a.ssm,a.nama,a.operator,a.fe,' .
            '`thn-respon`,`bln-respon`,`thn-msic-2000`,`thn-msic-2008`,' .
            '`bln-msic-2000`,`bln-msic-2008`';
            // sql tak guna limit
            $this->papar->cariApa[$myJadual[$key]] = $this->tanya->
            kesSemak($myTable, $myJoin, $medan, $jum);
        }// tamat ulang table
        
        // Set pemboleubah utama
        $this->papar->pegawai = senarai_kakitangan();
        $this->papar->carian = 'semak';
        $this->papar->url = dpt_url();
        // pergi papar kandungan
        $this->papar->baca('kawalan/index');
    }    

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
        $this->papar->baca('cimej/cari');
        
    }
    
    function ubah($cariID) 
    {//echo '<br>Anda berada di class Imej extends Kawal:ubah($cari)<br>';
                
        // senaraikan tatasusunan jadual dan setkan pembolehubah
        $bulanan = bulanan('data_bulanan','14'); # papar bulan dlm tahun semasa
        $jadualRangka = 'rangka14';
        $medanRangka ='newss,nama,ssm,alamat,' 
			//. 'concat_ws("&nbsp;",alamat1_lokasi,alamat2_lokasi,poskod_lokasi,bandar_lokasi,ng_lokasi) as alamat,' . "\r"
			. 'nota,respon,fe,tel,fax,responden,email,msic2008,' . "\r" 
			. 'concat(substring(newss,1,3),\' \',substring(newss,4,3),\' \',' 
			. 'substring(newss,7,3),\' \',substring(newss,10,3),\' | \',' 
			. 'msic2008) as ' . '`id U M`';
        $medanData = 'newss,fe,nama,terima,hantar,gaji,staf,hasil,respon,nota';
        $sv='mm_'; // survey apa
        $cari['medan'] = 'newss'; // cari dalam medan apa
        $id = isset($cariID) ? $cariID : null; // cari id berasaskan sidap
        $cari['id'] = $id; // benda yang dicari
        $this->papar->kesID = array();

        if (!empty($id)) 
        {
            //echo '$id:' . $id . '<br>';
            $this->papar->carian='newss';
        
            // 1. mula semak dalam rangka 
            $this->papar->rangka['kes'] = 
                $this->tanya->cariSemuaMedan($sv . $jadualRangka, 
                $medanRangka, $cari);
				
			//echo '$this->papar->rangka:<br><pre>'; print_r($this->papar->rangka) . '</pre>'; 
			
			// 1.1 ambil nilai msic & msic08
			//$msic00 = $this->papar->rangka['kes'][0]['msic'];
			$msic08 = $this->papar->rangka['kes'][0]['msic2008'];
			$cariM6['medan'] = 'msic';
			$cariM6['id'] = $msic08;
			
			// 1.2 cari nilai msic & msic08 dalam jadual msic2008
			$jadualMSIC = dpt_senarai('msiclama');
			// mula cari $cariID dalam $jadual
			foreach ($jadualMSIC as $m6 => $msic)
			{// mula ulang table
				// senarai nama medan
				$medanM6 = ($msic=='msic2008') ? 
					'seksyen S,bahagian B,kumpulan Kpl,kelas Kls,' .
					'msic2000,msic,keterangan,notakaki' : '*'; 
				//echo "cariMSIC($msic, $medanM6, $cariM6)<br>";
				$this->papar->cariIndustri[$msic] = $this->tanya->
				cariIndustri($msic, $medanM6, $cariM6);
			}// tamat ulang table

            // 2. mula cari $cariID dalam $bulanan
            foreach ($bulanan as $key => $myTable)
            {// mula ulang table
                $this->papar->kesID[$myTable] = 
                    $this->tanya->cariSemuaMedan($sv . $myTable, 
                    $medanData, $cari);
            }// tamat ulang table
			//*/
		}
        else
        {
            $this->papar->carian='[tiada id diisi]';
        }
        
        // isytihar pemboleubah
        //$tajuk2=array('bulan','nama','msic','terima','hasil','dptLain',
        //'web','stok','staf','gaji','sebab','outlet','nota');
        $tajuk2=array('bulan','nama','terima','hantar','gaji','staf','hasil','respon','nota');
        $s1 = '<th><span class="label">';
        $s2 = '</span></th>';
        $this->papar->paparTajuk = null;
		foreach ($tajuk2 as $tajuk)
        {
            $this->papar->paparTajuk .= "\n" . $s1 . $tajuk . $s2;
        }

        $this->papar->pegawai = senarai_kakitangan();
        $this->papar->lokasi = 'MM14 - Ubah';
		$this->papar->cari = $id;
		
        // semak data
		/*
		echo '<pre>';
        echo '$this->papar->kesID:<br>'; print_r($this->papar->kesID); 
		echo '$this->papar->rangka:<br>'; print_r($this->papar->rangka); 
		echo '$this->papar->cari:<br>'; print_r($this->papar->cari); 
		echo '</pre>';
		//*/
		
        // paparkan ke fail cimej/cari.php
        $this->papar->baca('kawalan/ubah', 0);

    }
    
	public function ubahCari()
	{
		// echo '<pre>$_POST->', print_r($_POST, 1) . '</pre>';
		// bersihkan data $_POST
		$dataID = bersih($_POST['cari']);
		
		// Set pemboleubah utama
        $this->papar->pegawai = senarai_kakitangan();
        $this->papar->lokasi = 'MM14 - Ubah';
		
		// paparkan ke fail kawalan/ubah.php
		header('location: ' . URL . 'kawalan/ubah/' . $dataID);

	}

    public function ubahSimpan($dataID)
    {
        $bulanan = bulanan('kawalan','14'); # papar bulan dlm tahun semasa
        $posmen = array();
        $id = 'newss';
		$sv = 'mm_'; // sv = kod penyiasatan
    
        foreach ($_POST as $key => $value)
        {
            if ( in_array($key,$bulanan) )
            {
                $myTable = $sv . $key;
                foreach ($value as $kekunci => $papar)
                {
                    if ( in_array($kekunci,array('terimax','hantarx')) )
					{	// kosongkan nilai dalam tarikh terima/hantar
						$posmen[$myTable]['terima'] = null;
						$posmen[$myTable]['hantar'] = null;
					}
					elseif ( in_array($kekunci,array('fe','email')) )
						$posmen[$myTable][$kekunci]=strtolower(bersih($papar)); // huruf kecil
					elseif ( in_array($kekunci,array('respon')) )
						$posmen[$myTable][$kekunci]=strtoupper(bersih($papar)); // HURUF BESAR
					elseif ( in_array($kekunci,array('responden')) )
						$posmen[$myTable][$kekunci] = // Huruf Besar Pada Depan Sahaja
							mb_convert_case(bersih($papar), MB_CASE_TITLE); 
					else
						$posmen[$myTable][$kekunci] = bersih($papar);
	            }
                $posmen[$myTable][$id] = $dataID;
            }
        }
        
			# buat peristiharan
			$rangka = 'mm_rangka14'; // jadual rangka kawalan
			//echo '<br>$dataID=' . $dataID . '<br>';
			//echo '<pre>$_POST='; print_r($_POST) . '</pre>';
			//echo '<pre>$posmen='; print_r($posmen) . '</pre>';
        
        // mula ulang $bulanan
        
        foreach ($bulanan as $kunci => $jadual)
        {// mula ulang table
			//if($jadual == 'rangka14'):
				$myTable = $sv . $jadual;
				$posmen[$myTable]['fe'] = $posmen[$rangka]['fe'];
				//$posmen[$myTable]['respon'] = $posmen[$rangka]['respon'];
				$data = $posmen[$myTable];
				$this->tanya->ubahSimpan($data, $myTable);
			//endif;
        }// tamat ulang table
        
        //$this->papar->baca('kawalan/ubah/' . $dataID);
        header('location: ' . URL . 'kawalan/ubah/' . $dataID);
		//*/
        
    }
	
	function baru($cariID) 
    {//echo '<br>Anda berada di class Imej extends Kawal:ubah($cari)<br>';
                
        // senaraikan tatasusunan jadual dan setkan pembolehubah
        $bulanan = bulanan('data_bulanan','14'); # papar bulan dlm tahun semasa
        $jadualRangka = 'rangka14';
        $medanRangka ='newss,nama,ssm,alamat,' 
			//. 'concat_ws("&nbsp;",alamat1_lokasi,alamat2_lokasi,poskod_lokasi,bandar_lokasi,ng_lokasi) as alamat,' . "\r"
			. 'nota,respon,fe,tel,fax,responden,email,msic2008,' . "\r" 
			. 'concat(substring(newss,1,3),\' \',substring(newss,4,3),\' \',' 
			. 'substring(newss,7,3),\' \',substring(newss,10,3),\' | \',' 
			. 'msic2008) as ' . '`id U M`';
        $medanData = 'newss,fe,nama,terima,hantar,gaji,staf,hasil,catatan';
        $sv='mm_'; // survey apa
        $cari['medan'] = 'newss'; // cari dalam medan apa
        $id = isset($cariID) ? $cariID : null; // cari id berasaskan sidap
        $cari['id'] = $id; // benda yang dicari
        $this->papar->kesID = array();

        if (!empty($id)) 
        {
            //echo '$id:' . $id . '<br>';
            $this->papar->carian='newss';
        
            // 1. mula semak dalam rangka 
            $this->papar->rangka['kes'] = 
                $this->tanya->cariSemuaMedan($sv . $jadualRangka, 
                $medanRangka, $cari);
				
			//echo '$this->papar->rangka:<br><pre>'; print_r($this->papar->rangka) . '</pre>'; 
			
			// 1.1 ambil nilai msic & msic08
			//$msic00 = $this->papar->rangka['kes'][0]['msic'];
			$msic08 = $this->papar->rangka['kes'][0]['msic2008'];
			$cariM6['medan'] = 'msic';
			$cariM6['id'] = $msic08;
			
			// 1.2 cari nilai msic & msic08 dalam jadual msic2008
			$jadualMSIC = dpt_senarai('msiclama');
			// mula cari $cariID dalam $jadual
			foreach ($jadualMSIC as $m6 => $msic)
			{// mula ulang table
				// senarai nama medan
				$medanM6 = ($msic=='msic2008') ? 
					'seksyen S,bahagian B,kumpulan Kpl,kelas Kls,' .
					'msic2000,msic,keterangan,notakaki' : '*'; 
				//echo "cariMSIC($msic, $medanM6, $cariM6)<br>";
				$this->papar->cariIndustri[$msic] = $this->tanya->
				cariIndustri($msic, $medanM6, $cariM6);
			}// tamat ulang table

            // 2. mula cari $cariID dalam $bulanan
			/*
            foreach ($bulanan as $key => $myTable)
            {// mula ulang table
                $this->papar->kesID[$myTable] = 
                    $this->tanya->cariSemuaMedan($sv . $myTable, 
                    $medanData, $cari);
            }// tamat ulang table
			//*/
		}
        else
        {
            $this->papar->carian='[tiada id diisi]';
        }
        
        // isytihar pemboleubah
        //$tajuk2=array('bulan','nama','msic','terima','hasil','dptLain',
        //'web','stok','staf','gaji','sebab','outlet','nota');
        $tajuk2=array('bulan','nama','terima','hantar','gaji','staf','hasil','catatan');
        $this->papar->paparTajuk = null;
        $s1 = '<span class="label">';
        $s2 = '</span>';
        foreach ($tajuk2 as $tajuk)
        {
            $this->papar->paparTajuk .= "\n" . '<th>' . $s1 . $tajuk . $s2 . '</th>';
        }

        $this->papar->pegawai = senarai_kakitangan();
        $this->papar->lokasi = 'MM14 - Ubah';
		$this->papar->cari = $id;
		
        // semak data
		/*
		echo '<pre>';
        echo '$this->papar->kesID:<br>'; print_r($this->papar->kesID); 
		echo '$this->papar->rangka:<br>'; print_r($this->papar->rangka); 
		echo '$this->papar->cari:<br>'; print_r($this->papar->cari); 
		echo '</pre>';
		//*/
		
        // paparkan ke fail cimej/cari.php
        $this->papar->baca('kawalan/baru', 0);


    }

	function buang($cariID) 
    {//echo '<br>Anda berada di class Imej extends Kawal:ubah($cari)<br>';
                
        // senaraikan tatasusunan jadual dan setkan pembolehubah
        $bulanan = bulanan('data_bulanan','14'); # papar bulan dlm tahun semasa
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
	
	
}