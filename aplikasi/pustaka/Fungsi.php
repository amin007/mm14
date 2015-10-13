<?php

function dpt_url()
{
    $url = isset($_GET['url']) ? $_GET['url'] : null;
    $url = rtrim($url, '/');
    $url = filter_var($url, FILTER_SANITIZE_URL);
    $url = explode('/', $url);

    return $url;
}

function dpt_url_xfilter()
{
    $url = isset($_GET['url']) ? $_GET['url'] : null;
    //$url = rtrim($url, '/');
    //$url = filter_var($url, FILTER_SANITIZE_URL);
    $url = explode('/', $url);

    return $url;
}

function dpt_ip()
{
    $IP = array('192.168.1.', '10.69.112.', 
        '127.0.0.1', '10.72.112.',
        '60.48.66.1','118.100.23',
		'202.60.56.');

    return $IP;
}

function dpt_senarai($namajadual)
{
    if ($namajadual=='msiclama')
        $jadual = array('msic08','msic2008',
        'msic_v1','msic_bandingan',
        'msic','msic_nota_kaki');
    elseif ($namajadual=='msicbaru')
        $jadual = array('msic2008','msic2008_asas',
        'msic_v1','msic_bandingan',
        'msic2000','msic2000_notakaki');
    elseif ($namajadual=='produk')
        $jadual = array('kodproduk_aup',
        'kodproduk_mei2011',
        'kodproduk_unitkuantiti');
    elseif ($namajadual=='prosesan')
        $jadual = array('tblprofpert',
        'tblprofpert_2009',
        'tblprofpert_2010');
    elseif ($namajadual=='data_prosesan')
        $jadual = array('tblemp',
		'tblframe',
		'tblmisc',
		'tblorder',
		'tblprodsale',
		'tblprofpert',
		'tblstok',
		);
    elseif ($namajadual=='syarikat')
    {
        $t='13'; // tahun rujukan
        $sv='mm_'; // jenis penyiasatan
        $jadual = array($sv.'rangka'.$t,
        $sv.'jan'.$t, $sv.'feb'.$t, $sv.'mac'.$t, $sv.'apr'.$t, 
        $sv.'mei'.$t, $sv.'jun'.$t, $sv.'jul'.$t, $sv.'ogo'.$t, 
        $sv.'sep'.$t, $sv.'okt'.$t, $sv.'nov'.$t, $sv.'dis'.$t);
    }
    
    return $jadual;
}

function pecah_post()
{
    $papar['pilih'] = isset($_POST['pilih']) ? $_POST['pilih'] : null;
    $papar['cari'] = isset($_POST['cari']) ? $_POST['cari'] : null;
    $papar['fix'] = isset($_POST['fix']) ? $_POST['fix'] : null;
    $papar['atau'] = isset($_POST['atau']) ? $_POST['atau'] : null;
    
    $kira['pilih'] = count($papar['pilih']);
    $kira['cari'] = count($papar['cari']);
    $kira['fix'] = count($papar['fix']);
    $kira['atau'] = count($papar['atau']);
    
    return $kira;
    //echo '<pre>'; print_r($kira) . '</pre>';
}

function bulanan($jenis, $t)
{    
    if ($jenis=='kawalan') // $t = '12' , tahun
        $bulan = array('rangka'.$t,
        'jan'.$t, 'feb'.$t, 'mac'.$t, 'apr'.$t, 
        'mei'.$t, 'jun'.$t, 'jul'.$t, 'ogo'.$t, 
        'sep'.$t, 'okt'.$t, 'nov'.$t, 'dis'.$t);
    elseif ($jenis=='semakan') // $t = '12' , tahun
        $bulan = array('pom_bln11.mm_rangka',
        'pom_bln12.mm_rangka');
    elseif ($jenis=='data_bulanan') 
        $bulan = array(
        'jan'.$t, 'feb'.$t, 'mac'.$t, 'apr'.$t, 
        'mei'.$t, 'jun'.$t, 'jul'.$t, 'ogo'.$t, 
        'sep'.$t, 'okt'.$t, 'nov'.$t, 'dis'.$t);
    elseif ($jenis=='nama_bulan') 
        $bulan = array(
        'jan', 'feb', 'mac', 'apr', 
        'mei', 'jun', 'jul', 'ogo', 
        'sep', 'okt', 'nov', 'dis');
    elseif ($jenis=='bulan_penuh')
        $bulan = array('Januari', 'Februari', 'Mac', 'April', 
        'Mei', 'Jun', 'Julai', 'Ogos', 
        'September', 'Oktober', 'November', 'Disember');
    elseif ($jenis=='prosesan')
        $bulan = array('info','jualan','gajistaf');
    
    return $bulan;
}

function data_prosesan()
{
    // mula masukkan nama jadual dan medan2
    //$jadual['medan'][]='*';
    /*$jadual['medan'][]='newss,ssm,nama,tel,fax,responden,' .
    '(SELECT keterangan FROM msic WHERE msic=msic2000 LIMIT 1,1) as keterangan,' .
    'msic2000,msicB2000,fe';*/
    $sama='j1.newss,concat(j1.tahun_rujukan,"-",j1.siri_kekerapan) as blnthn, ';
    $sama2='j2.newss,concat(j2.tahun_rujukan,"-",j2.siri_kekerapan) as blnthn, ';
    //$jadual['medan'][]=$sama . 'ssm, nama, operator, sv, kekerapan_sv'; 
    //$jadual['medan'][]=$sama . 'ng, po, data_anggaran, cara_maklum_balas, cara_terima, sumber_pertubuhan, kategori_sample';
    //$jadual['medan'][]=$sama . 'status_operasi, status_lain_pbb, bil_bulan_bco, siasatan_bermula, siasatan_berakhir';
    //$jadual['medan'][]=$sama . 'no_jln_bgn, tmn_kg, bandar_kawasan, poskod, negeri, daerah, catatan';
    //$jadual['medan'][]=$sama . 'responden, jawatan, email, notel, lamanweb, tarikh';
    //$jadual['medan'][]=$sama . 'responden2, jawatan2, email2, notel2, nofax2';
    //$jadual['medan'][]=$sama . '`no_jln_bgn-lokasi`, `tmn_kg-lokasi`, `bandar_kawasan-lokasi`, ' .
    //'`poskod-lokasi`, `negeri-lokasi` ng, `daerah-lokasi` dp';
    $jadual['medan'][]='j1.newss,j1.ssm,j1.nama,concat(j1.tahun_rujukan,"-",j1.siri_kekerapan) as blnthn ';
    $jadual['medan'][]=$sama . "\r" . 'msic_lama, (SELECT keterangan FROM msic WHERE msic=msic_lama LIMIT 1,1) as keterangan,' . 
    'msic_baru, utama '; 
    //$jadual['medan'][]=$sama . "\r\t" . 'F3001, F3002, catatan_soalan3, ' . 'F5001, F5002, F5003, F5104, catatan_soalan5';
    $jadual['medan'][]=$sama . 'F6001, F6002, F6003, F6004, F6005, F6101, F6102, F6103, F6104, F6105, catatan_soalan6';
    $jadual['medan'][]=$sama . 'F7001, F7002, F7003, catatan_soalan7, ' .
                'F8001, catatan_soalan8, F9001, catatan_soalan9';
    //$jadual['medan'][]=$sama . 'cara_anggaran, bulan_terakhir_data_sebenar, bil_bulan_data_telah_dianggar';

    //$jadual['medan'][]=$sama . 'Deskripsi_Produk_Oleh_Responden, Produk_Tetap, Deskripsi_Produk_Tetap,
    //Produk_Tambahan, Deskripsi_Produk_Tambahan, UnitKuantitiAsal, UnitKuantitiLain'; 
    $produk='Deskripsi_Produk_Tetap Nama, Produk_Tetap Kod, ';
    $jadual['medan'][]=$sama . $produk . 'KuantitiPengeluaran, KuantitiJualan, NilaiJualan, ' .
    'format(NilaiJualan/KuantitiJualan,2) as HargaUnit, UnitKuantitiKini';
    //$jadual['medan'][]=$sama . $produk . 'ProsesanKuantitiPengeluaran, ProsesanKuantitiJualan, ProsesanNilaiJualan, AUP';
    $jadual['medan'][]=$sama . $produk . 'F2497, F2498, F2499, Catatan';
    $jadual['medan'][]=$sama . "\r\t" . 
                'F3001, F3002, catatan_soalan3, ' .
                'F5001, F5002, F5003, F5104, catatan_soalan5';

    //$jadual['medan'][]=$sama . 'catatan';
    $jadual['medan'][]=$sama . 'F4001, F4002, F4003, F4004';
    $jadual['medan'][]=$sama . 'F4101, F4102, F4103, F4104';
    $jadual['medan'][]=$sama . 'F4201, F4202, F4203, F4204';
    $jadual['medan'][]=$sama . 'catatan "Nota ", F4302, F4303, F4304';

    // bulanan
    //$bulan=($_GET['bln']==null)? '':'AND siri_kekerapan="'.bersih($_GET['bln']).'"';
    $bulan_penuh = array('Januari', 'Februari', 'Mac', 'April', 
        'Mei', 'Jun', 'Julai', 'Ogos', 
        'September', 'Oktober', 'November', 'Disember');
    //$kerap='"'.$bulan_penuh[0].'","'.$bulan_penuh[1].'","'.$bulan_penuh[2].'"';
    //$bulan=($_GET['bln']==null)? '':'AND j1.siri_kekerapan in ('.$kerap.')';
        //$myJadual=array('mm_rangka','mm_rangka');
        for($z=1;$z <= 4;$z++) { $jadual['nama'][]='prosesmm_info'; } // bil medan = 15
        for($z=1;$z <= 2;$z++) { $jadual['nama'][]='prosesmm_jualan'; }
        $jadual['nama'][]='prosesmm_info';
        for($z=1;$z <= 4;$z++) { $jadual['nama'][]='prosesmm_gajistaf'; }
        $join1='prosesmm_info';
        $join2='prosesmm_jualan';
        $join3='prosesmm_gajistaf';
    
    return $jadual;
}

function tahunan($jenis, $t)
{    
    if ($jenis=='kawalan') 
        $tahunan = array('rangka',
        'jan'.$t, 'feb'.$t, 'mac'.$t, 'apr'.$t, 
        'mei'.$t, 'jun'.$t, 'jul'.$t, 'ogo'.$t, 
        'sep'.$t, 'okt'.$t, 'nov'.$t, 'dis'.$t);
    elseif ($jenis=='prosesan')
        $tahunan = array('info','jualan','gajistaf');
    elseif ($jenis=='semuakawalan')
        $tahunan = array('kawal_ppmas09','kawal_rpe09','kawal_tani09',
        'sse08_rangka','sse09_buat','sse09_ppt','sse10_kawal');
    elseif ($jenis=='bulan_penuh')
        $bulan = array('Januari', 'Februari', 'Mac', 'April', 
        'Mei', 'Jun', 'Julai', 'Ogos', 
        'September', 'Oktober', 'November', 'Disember');
    
    return $tahunan;
}

function senarai_kakitangan()
{
    $pegawai[]='adam';
    //$pegawai[]='ali';
    $pegawai[]='amin';
    $pegawai[]='ariff';
    $pegawai[]='azim';
    $pegawai[]='fendi';
    $pegawai[]='ita';
	$pegawai[]='irwan';
    $pegawai[]='khairi';
    $pegawai[]='murad';
    $pegawai[]='musa';
    $pegawai[]='mustaffa';
    $pegawai[]='razak';
    $pegawai[]='shukor';
    $pegawai[]='suhaida';
    $pegawai[]='sujana';
    
    return $pegawai;
}

function lihat($tab,$kini,$papar,$pegawai) 
{    
    $selit = null;
    $p = dpt_url(); // sepatutnya kawalan/semua/30/2/amin/
    $item = ( !isset($p[2]) ) ? '20/' : $p[2] . '/'; //'30'; 
    $ms = ( !isset($p[3]) ) ? '1/' : $p[3] . '/'; // '2';
    $url = URL . $papar . $item . $ms;
    $i = 1;
    
    foreach ($pegawai as $fe) 
    {
        $selit .= "\n" . $tab . '<li><a href="' . 
        $url . $fe . '">' . $i++ . ') ' .
		$fe . '</a></li>' . "\r";
    }
    echo $selit . $tab . "\n" . $tab;
}

function pencamSqlLimit($bilSemua, $item, $ms, 
	$kumpul = null, $susun = null)
{
    // Tentukan bilangan jumlah dalam DB:
    $jum['bil_semua'] = $bilSemua; //mysql_num_rows($semua);
    // ambil halaman semasa, jika tiada, cipta satu! 
    $jum['page'] = ( !isset($ms) ) ? 1 : $ms; // mukasurat
    // berapa item dalam satu halaman
    $jum['max'] = ( !isset($item) ) ? 30 : $item; // item
    // Tentukan had query berasaskan nombor halaman semasa.
    $jum['dari'] = (($jum['page'] * $jum['max']) - $jum['max']); 
    // Tentukan bilangan halaman. 
    $jum['muka_surat'] = ceil($jum['bil_semua'] / $jum['max']);
    // nak tentukan berapa bil jumlah dlm satu muka surat
    $jum['bil'] = $jum['dari']+1; 
	// susun dan group
	$jum['kumpul'] = $kumpul; 
	$jum['susun'] = $susun; 
    return $jum;
}

function halaman($jum)
{// function halaman() - mula
    $mula = '<span style="background-color: #fffaf0; color:black">';
    $tamat  = '</span>';
    $page = $jum['page'];
    $muka_surat = $jum['muka_surat'];
    $bil_semua = $jum['bil_semua'];
    $baris_max = $jum['max'];
            
    $url = dpt_url();  // sepatutnya kawalan/semua/30/1/amin/
    $class = ( !isset($url[0]) ) ? null : $url[0]; //'kawalan'; 
    $fungsi = ( !isset($url[1]) ) ? null : $url[1]; //'semua'; 
    $item = ( !isset($url[2]) ) ? null : $url[2]; //'30'; 
    $ms = ( !isset($url[3]) ) ? null : $url[3]; //'ms'; 
    $fe = ( !isset($url[4]) ) ? null : $url[4]; //'fe'; 
    
    $senarai = URL . "$class/$fungsi/$baris_max/";
    $halaman = "\n$mula Bil Kes:($bil_semua)- Papar halaman ".
        '<div class="pagination"><ul>'; 
        
    if($page > 1) // Bina halaman sebelum
        $halaman .= "\r<li><a href='$senarai" . ($page-1) . "/$fe'>Sebelum</a></li>";
    for($i = 1; $i <= $muka_surat; $i++) // Bina halaman terkini
        {$halaman .= ($page==$i)? "<li><a>($i)</a></li>" : "\r<li><a href='$senarai$i/$fe'>$i</a></li>";}
    if($page < $muka_surat) // Bina halaman akhir
        $halaman .= "\r<li><a href='$senarai" . ($page+1) . "/$fe'>Lagi</a></li>";
        
    $halaman .= "\n</ul></div>\n$tamat";

    return $halaman;
}// function halaman() - tamat

// cetakF3
function halamanf3($jum)
{// function halaman() - mula
    $mula = '<div style="background-color: #fffaf0; color:black;text-align:center">';
    $tamat = '</div>';
    $page = $jum['page'];
    // Tentukan had query berasaskan nombor halaman semasa.
    //$jum['dari'] = (($jum['page'] * $jum['max']) - $jum['max']); 
    // Tentukan bilangan halaman. $jum['muka_surat'] 
	$jum['max'] = 30; // ubahsuai bil max untuk cetakf3
	$muka_surat = ceil($jum['bil_semua'] / $jum['max']);
    $bil_semua = $jum['bil_semua'];
    $baris_max = $jum['max'];
            
    $url = dpt_url();  // sepatutnya kawalan/semua/30/1/amin/
    $class = ( !isset($url[0]) ) ? null : $url[0]; //'kawalan'; 
    $fungsi = 'cetakf3'; //( !isset($url[1]) ) ? null : $url[1]; //'semua'; 
    $batch = ( !isset($url[2]) ) ? null : $url[2]; //'30'; 
    $item = ( !isset($url[3]) ) ? null : $url[3]; //'30'; 
    $ms = ( !isset($url[4]) ) ? null : $url[4]; //'ms'; 
    //$fe = ( !isset($url[4]) ) ? null : $url[4]; //'fe'; 
    
    //return "\$batch:$batch|\$bil_semua:$bil_semua|\$baris_max:$baris_max|\$muka_surat:$muka_surat";
	
	$senarai = URL . "$class/$fungsi/$batch/$baris_max/";
    $halaman = "\n$mula\r" 
		. '<ul class="pagination pagination-sm">' 
		. "\r<li><a>Bil:($bil_semua) ms($muka_surat)- Papar halaman</a></li>";
    
    if($page > 1) // Bina halaman sebelum
        $halaman .= "\r<li><a href='$senarai" . ($page-1) . "'>&laquo;</a></li>";
    for($i = 1; $i <= $muka_surat; $i++) // Bina halaman terkini
        {$halaman .= ($page==$i)? "\r<li><a href='$senarai$i'>($i)</a></li>" : 
		"\r<li><a href='$senarai$i'>$i</a></li>";}
    if($page < $muka_surat) // Bina halaman akhir
        $halaman .= "\r<li><a href='$senarai" . ($page+1) . "'>&raquo;</a></li>";
        
    $halaman .= "\n</ul>\n$tamat";

    return $halaman;
	
}// function halaman() - tamat

function paparJadualF3_TajukBesar($allRows,$rows,$fields,$kodsv,$nama_penyelia,$nama_pegawai,$item,$ms)
{
	## tajuk besar
	switch ($kodsv):
		case 'MDT': $SV='PENYIASATAN PERDAGANGAN EDARAN BULANAN'; break;
		case 'CDT': $SV='BANCI PERDAGANGAN EDARAN'; break;
		case 'MM':  $SV='PENYIASATAN PEMBUATAN BULANAN'; break;
		case 'QSS': $SV='PENYIASATAN PERKHIDMATAN SUKU TAHUNAN'; break;
		case 'EJOB': $SV='PENYIASATAN GUNA TENAGA SUKU TAHUNAN'; break;
		case 'BST': $SV='PENYIASATAN BINAAN SUKU TAHUNAN'; break;
		case 'MFG':  $SV='PENYIASATAN PEMBUATAN TAHUNAN'; break;
		case 'SERVIS':  $SV='PENYIASATAN PERKHDIMATAN TAHUNAN'; break;
		case 'PPPMAS':  $SV='PENYIASATAN PERBELANJAAN UNTUK PELINDUNGAN ALAM SEKITAR'; break;
		default: $SV=null;
	endswitch;

	echo '<td colspan=' . ($fields+1) . '><font size=2>' .
		//'<div align="right">Lampiran 3<br>F 3 </div>' .
		'<div align="right">Lampiran A : F3 </div>' .
		'<div align="center">' .
		'JABATAN PERANGKAAN MALAYSIA NEGERI JOHOR' .
		'<br>SENARAI INDUK AGIHAN KES ANGGOTA ' .
		'<br>' . $SV . ' 3-2015' . //date('Y') .
		'</div><br><div align="left">' .
		"Nama Penyelia : $nama_penyelia" .
		'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' .
		'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' .
		'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' .
		'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' .
		'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' .
		'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' .
		'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' .
		"Nama FE : $nama_pegawai ($allRows kes)" .
		"(muka $ms dari " . ($item*$ms) . ")" .
		'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' .
		'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' .
		'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' .
		'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' .
		'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' .
		'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' .
		'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' .
		'Tarikh : <u>' . (date('d')) .
		(date('/m/Y')) . '</u> ' .
		'</div></font></td>' . "\r";

}

function paparJadualF3_TajukMedan($sv,$nama_penyelia,$nama_pegawai,$allRows,$rows,$fields,$hasil,$item,$ms)
{
	## tajuk besar
	echo '<tr style="page-break-before:always">';
	paparJadualF3_TajukBesar($allRows,$rows,$fields,$sv,$nama_penyelia,$nama_pegawai,$item,$ms);
	echo '</tr>';
	
	## tajuk medan - keputusan 
		echo '<tr>';
	echo "\n<th rowspan=2>Bil</th>\n";
	echo '<th rowspan=2>Nama Syarikat (KES ' . $nama_pegawai . ')</th>' . "\n";
	echo '<th rowspan=2>Kod Peny.</th>' . "\n";
	echo '<th rowspan=1>BBU</th>' . "\n";
	echo '<th rowspan=2>NO SIRI NEWSS</th>' . "\n";
	echo '<th rowspan=2>NOTA/CATATAN</th>' . "\n";
	echo '<th colspan=22>Diisi oleh Anggota Kerja Luar sahaja</th>' . "\n";
	
	// bawah 	
	echo '<tr>';
	echo '<th>SBU</th>' . "\n";
	foreach ($hasil[0] as $kunci => $dataan)
	{
		echo (in_array($kunci,array('nama','sv','utama','newss','nota')))?  
		'':'<th>'.$kunci.'</th>' . "\n";	
	}
	echo '</tr>';

}

function paparJadualF3_TajukMedan1($nama_pegawai=null)
{
	## tajuk medan - keputusan 
	echo "<tr>\n<th rowspan=2>Bil</th>\n";
	echo '<th rowspan=2>Nama Syarikat</th>' . "\n";
	echo '<th rowspan=2>Kod Peny.</th>' . "\n";
	echo '<th rowspan=1>BBU</th>' . "\n";
	echo '<th rowspan=2>NO SIRI NEWSS</th>' . "\n";
	echo '<th colspan=22>Diisi oleh Anggota Kerja Luar sahaja</th>' . "\n";
	echo "</tr>\n";
	
}
function paparJadualF3_TajukMedan2($nama_pegawai,$rows,$fields,$hasil,$item,$ms)
{
	// nilai dari tajuk
	echo '<tr>';
	echo '<th>SBU</th>' . "\n";
	foreach ($hasil[0] as $kunci => $dataan)
	{
		echo (in_array($kunci,array('nama','sv','utama','newss')))?  
		'':'<th>'.$kunci.'</th>' . "\n";	
	}
	echo '</tr>';

}
function paparJadualF3_TajukBawah($rows,$fields)
{
	## pecah muka surat
	//$cetak=($bil==$rows)?'style="page-break-after:always">':'>';
	$cetak='style="page-break-after:always">';
	echo '<tr style="page-break-after:always"><td colspan=' . ($fields+1) . '>' .
		'<p align=left><font size=2>' .
		'A) Laporan kawalan harian ini merujuk kepada arahan Pengarah pada mesyuarat Pemantauan' .
		'<br>B) Sila kemaskini laporan ini setiap hari dan failkan mengikut turutan tarikh oleh FE' .
		'<br>C) Tarikh laporan ini bersamaan tarikh kerja luar pada F2 syarikat yang disenaraikan' .
		'<br>D) Laporan ini tidak perlu diisi oleh FE jika tiada kerja luar / telefon dsb' .
		'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' .
		'</font></p></td></tr>' . "\r";
}
function paparJadualF3_Data($sv,$nama_penyelia,$nama_pegawai,$allRows,$rows,$fields,$hasil,$item,$ms)
{	
	// nak cari $rows
	if ($rows=='0'): echo "\n";
	else: // mula kalau jumpa
		# PEMBOLEH UBAH
		$highlight="onmouseover=\"this.className='tikusatas';\" onmouseout=\"this.className='tikuslepas1';\"";
		$highlight2=" onmouseover=\"this.className='tikusatas';\" onmouseout=\"this.className='tikuslepas2';\"";
	
		// nilai dari isi
		$jum = array();
		
		foreach ($hasil as $kira => $nilai)
		{
			//$mula = ($ms==1) ? $ms : ($ms*$item)-$ms;
			// style="page-break-after:always"
			if ($kira%'30'=='0')
			{
				echo paparJadualF3_TajukMedan($sv,$nama_penyelia,$nama_pegawai,$allRows,$rows,$fields,$hasil,$item,$ms);
				echo "<tr><td><a target='_blank' href='"
				. URL . 'kawalan/ubah/'
				. $nilai['newss']."'>".($kira+1)."</a></td>\n";

			}
			else
			{
				echo "<tr><td><a target='_blank' href='"
				. URL . 'kawalan/ubah/'
				. $nilai['newss']."'>".($kira+1)."</a></td>\n";		
			}
			foreach ($nilai as $key => $data)
			{
				echo '<td>' . $data . '</td>';
				//echo '<td>' . $key . ' | ' . $data . '</td>';
				//if (!in_array($key,array('nama','sv','utama','newss')))
					//$key['jum'] .= $data;
			}echo "</tr>\n";	

		}

		## ruang kodong
		if ($allRows != 30)
		{
			for($gst=$allRows; $gst < 30; $gst++)
			{
				echo "<tr>\n<td>" .($gst+1) . '</td>' . "\n";
				echo "<td>&nbsp;</td>\n<td>&nbsp;</td>\n<td>&nbsp;</td>\n<td>&nbsp;</td>\n";
				foreach ($hasil[0] as $key => $kunci)
				{
					//echo '<th>&nbsp;</th>' . "\n";	
					echo (in_array($key,array('nama','sv','utama','newss')))?  
					'':'<td>&nbsp;</td>' . "\n";	
				}
				echo "</tr>\n";
				
			}
		}	
			## tajuk bawah - bil, jumlah besar, utama, newss, A1-B7
			echo "<tr>\n";// dptkan nama medan
			echo '<th>&nbsp;</th>' . "\n";
			echo '<th>Jumlah Besar</th>' . "\n";
			echo '<th>&nbsp;</th>' . "\n";
			echo '<th>&nbsp;</th>' . "\n";
			echo '<th>&nbsp;</th>' . "\n";
			foreach ($hasil[0] as $key => $kunci)
			{
				//echo '<th>&nbsp;</th>' . "\n";	
				echo (in_array($key,array('nama','sv','utama','newss')))?  
				'':'<th>&nbsp;</th>' . "\n";	
			}
			echo "</tr>\n";

	endif;
	
}


function cariMedanInput($ubah,$f,$row,$nama) 
{/* mula -
    $ubah = nama jadual
    $f = nombor medan
    $row = data medan
    $nama = nama medan
    
    senarai nama medan
    0-nota,1-respon,2-fe,3-tel,4-fax,        
    5-responden,6-email,7-msic,8-msic08,
    9-`id U M`,10-nama,11-sidap,12-status 
 */// papar medan yang terlibat
 
    $cariMedan = array(0,1,2,3,4,5,6,8);
    $cariText = array(0); // papar jika nota ada
    $cariMsic = array(8); // papar input text msic sahaja 
    $namaM = $ubah .'[' . $nama . ']';
        
    // tentukan medan yang ada input
    $input=in_array($f,$cariMedan)? 
    (@in_array($f,$cariMsic)? // tentukan medan yang ada msic
        '<input type="text" name="' . $namaM . '" value="' . $row[$f] . '" size=6>'
        :(@in_array($f,$cariText)? // tentukan medan yang ada input textarea
            '<textarea name="' . $namaM . '" rows=2 cols=23>' . $row[$f] . '</textarea>'
            : // tentukan medan yang bukan input textarea
            '<input type="text" name="' . $namaM . '" value="' . $row[$f] . '" size=30>'
        )
    ):'<label class="papan">' . $row[$f] . '</label>';
    
    return $input;

}
function semakMedanDaftar($myTable, $nama, $jenis, $data) 
{
    return $myTable.'->'.$nama.'->'.$jenis.'='.$data;
}

function paparMedanDaftar($myTable, $nama, $jenis, $data) 
{
    $namaMedan = 'name="' . $myTable . '[' . $nama . ']" '
               . 'id="' . $nama . '"';
    $papar = null;
    
    if ($nama == 'password')
    {
        $papar = '<input type="password" ' . $namaMedan . ' class="span3">';
    }
    elseif ($nama == 'level')
    {
        $papar = '<select ' . $namaMedan . '>';
        $senaraiLevel= array('baru');
        
        foreach ($senaraiLevel as $key => $value)
        {
            $papar .= '<option value="' . $value . '">'
                   . ucfirst(strtolower($value)) 
                   . '</option>';
        }
        $papar .= '</select>';

    }
    elseif ($nama == 'jantina')
    {
        $papar = '<select ' . $namaMedan . '>';
        $senaraiJantina = array('lelaki','perempuan');
        
        foreach ($senaraiJantina as $key => $value)
        {
            $papar .= '<option value="' . $value . '">'
                   . ucfirst(strtolower($value)) 
                   . '</option>';
        }
        $papar .= '</select>';
    }
    else
    {
        $papar = inputDaftar($jenis, $namaMedan, $data);
    }

    return $papar;
}

function inputDaftar($jenis, $namaMedan, $data)
{
        switch ($jenis) 
        {// mula - pilih type
        case 'varchar(15)':
            $papar = '<input type="text" ' . $namaMedan . ' class="span2">';
            break;
        case 'varchar(20)':
            $papar = '<input type="text" ' . $namaMedan . ' class="span3">';
            break;
        case 'varchar(35)':
            $papar = '<input type="text" ' . $namaMedan . ' class="span4">';
            break;
        case 'varchar(50)':
            $papar = '<input type="text" ' . $namaMedan . ' class="span5">';
            break;        
        case 'date':
            $papar = '<input type="text" ' . $namaMedan . ' class="input-small tarikh" readonly">';
            break;
        case 'text':
            $jenisText = $namaMedan . ' rows="3" cols="30" ';
            $papar = '<textarea ' . $jenisText . '></textarea>';
            break;
        default: 
            $papar="$namaMedan-$jenis-$data"; 
            break;
        }// tamat - pilih type

        return $papar;
}


function paparMedanDaftarSesi($myTable, $nama, $jenis, $data, $sesi) 
{
    $namaMedan = 'name="' . $myTable . '[' . $nama . ']" '
               . 'id="' . $nama . '"';
    $papar = null;
        
    if ($nama == 'nama_penuh')
    {
        $papar = '<input type="text" ' . $namaMedan 
               . ' value="' . $sesi['namaPenuh'] . '" class="span4">';
    }
    elseif ($nama == 'namapengguna')
    {
        $papar = '<input type="text" ' . $namaMedan 
               . ' value="' . $sesi['pengguna'] . '" class="span4">';

    }
    elseif ($nama == 'level')
    {
        $papar = '<select ' . $namaMedan . '>';
        $senaraiPengguna= array('baru');
        
        foreach ($senaraiPengguna as $key => $value)
        {
            $papar .= '<option value="' . $value . '"';
            $papar .= ($value == $sesi['level']) ? ' selected >' : '>';
            $papar .= ucfirst(strtolower($value));
            $papar .= '</option>';
        }
        $papar .= '</select>';

    }
    elseif ($nama == 'jantina')
    {
        $papar = '<select ' . $namaMedan . '>';
        $senaraiJantina = array('lelaki','perempuan');
        
        foreach ($senaraiJantina as $key => $value)
        {
            $papar .= '<option value="' . $value . '">'
                   . ucfirst(strtolower($value)) 
                   . '</option>';
        }
        $papar .= '</select>';
    }
    elseif ($nama == 'password')
    {
        $papar = '<input type="password" ' . $namaMedan . ' class="span3">';
    }
    elseif ($nama == 'level')
    {
        $papar = '';
    }
    else
    {
        $papar = inputDaftar($jenis, $namaMedan, $data);
    }

    return $papar;
}

function ubahMedanSesi($myTable, $nama, $jenis, $data) 
{
    $namaMedan = 'name="' . $myTable . '[' . $nama . ']" '
               . 'id="' . $nama . '"';

    //$papar = null;
        
    if ($nama == 'jantina')
    {
        $papar = '<select ' . $namaMedan . '>';
        $senaraiJantina = array('lelaki','perempuan');
        
        foreach ($senaraiJantina as $key => $value)
        {
            $papar .= '<option value="' . $value . '"';
            $papar .= ($value == $data) ? ' selected >' : '>';
            $papar .= ucfirst(strtolower($value));
            $papar .= '</option>';
        }
        $papar .= '</select>';
    }
    elseif ($nama == 'password')
    {
        $papar = '<input type="password" ' . $namaMedan . ' value="' . $data . '" class="span3">';
    }
    elseif ($nama == 'BIL')
    {
        $papar = '<input type="text" ' . $namaMedan . ' value="' . $data . '" class="span3">';;
    }
    else
    {
        $papar = ubahInputDaftar($jenis, $namaMedan, $data);
    }

    return $papar;
}

function ubahInputDaftar($jenis, $namaMedan, $data)
{
        switch ($jenis) 
        {// mula - pilih type
        case 'varchar(3)':
            $papar = '<input type="text" ' . $namaMedan . ' value="' . $data . '" class="input-small">';
            break;
        case 'varchar(10)':
            $papar = '<input type="text" ' . $namaMedan . ' value="' . $data . '" class="span3">';
            break;
        case 'varchar(20)':
            $papar = '<input type="text" ' . $namaMedan . ' value="' . $data . '" class="span4">';
            break;
        case 'varchar(50)':
            $papar = '<input type="text" ' . $namaMedan . ' value="' . $data . '" class="span5">';
            break;
        case 'varchar(255)':
            $papar = '<input type="text" ' . $namaMedan . ' value="' . $data . '" class="span6">';
            break;
        case 'date':
            $papar = '<input type="text" ' . $namaMedan . ' value="' . $data . '" class="input-small tarikh" readonly">';
            break;
        case 'text':
            $jenisText = $namaMedan . ' rows="3" cols="30" ';
            $papar = '<textarea ' . $jenisText . '>' . $data . '</textarea>';
            break;
        default: 
            $papar="$namaMedan-$data"; 
            break;
        }// tamat - pilih type

        return $papar;
}

function kira($kiraan)
{
    // pecahan kepada ratus
    return number_format($kiraan,0,'.',',');
} 

function kira2($dulu,$kini)
{
    // buat bandingan dan pecahan kepada ratus
    return @number_format((($kini-$dulu)/$dulu)*100,0,'.',',');
    //@$kiraan=(($kini-$dulu)/$dulu)*100;
}

function huruf($jenis, $papar)
{
    /*
    $_POST['mdt_rangka']['respon']=strtoupper($_POST['mdt_rangka']['respon']);
    $_POST['mdt_rangka']['fe']=strtolower($_POST['mdt_rangka']['fe']);
    $_POST['mdt_rangka']['responden']=mb_convert_case($_POST['mdt_rangka']['responden'], MB_CASE_TITLE);
    */
    
    switch ($jenis) 
    {// mula - pilih $jenis
    case 'BESAR':
        $papar = strtoupper($papar);
        break;
    case 'kecil':
        $papar = strtolower($papar);
        break;
    case 'Depan':
        $papar = ucfrist($papar);
        break;
    case 'Besar_Depan':
        $papar = mb_convert_case($papar, MB_CASE_TITLE);
        break;
    }// tamat - pilih $jenis
    
    return $papar;
}

function bersih($papar) 
{
    # lepas lari aksara khas dalam SQL
    //$papar = mysql_real_escape_string($papar);
	# buang ruang kosong (atau aksara lain) dari mula & akhir 
    $papar = trim($papar);
    # menghapuskan semua special characters dan cuma tinggalkan aksara dan integer sahaja
	//$papar = preg_replace('/[^a-z0-9]/i', '', $papar);
	
    return $papar;
}

function bersihGET($papar) 
{
	# bersih untuk $_GET sahaja
	$paparHTML = filter_input(INPUT_GET, $papar, FILTER_SANITIZE_SPECIAL_CHARS);
	$paparURL = filter_input(INPUT_GET, $papar, FILTER_SANITIZE_ENCODED);
	//$papar = filter_var($_GET[$papar], FILTER_SANITIZE_URL);
	
	//echo "You have searched for $paparHTML.\n";
	//echo "<a href='?search=$paparURL'>Search again.</a>";
    
    //return $papar;
    return $paparHTML;
}


function gambar_latarbelakang($lokasi)
{
    $tmpt = //$lokasi . 'bg/bg/';
        //$_SERVER['SERVER_NAME'] . '/private_html/bg/bg/';
        '../../bg/bg/' ;
        
    foreach(scandir($tmpt) as $gambar) 
    {
        if (substr($gambar,-3) == 'jpg') 
            $papar[]=$gambar;
    }

    $bg['papar'] = print_r($papar, 1);
    //$bg['papar'] = '<br>count($papar)='.count($papar);
    $bg['count_tolak_1'] = (count($papar)-1);
    $bg['today'] = rand(0, count($papar)-1);
    $bg['gambar'] = $papar[$bg['today']];
    
    return $bg;
}

function cari_imej($ssm,$strDir)
{
    //require_once ('public/skrip/listfiles2/dir_functions.php');

    if ( isset($ssm) && empty($ssm) )
    {
        $cariImej = null;
    }
    else
    {
        // You can modify this in case you need a different extension
        $strExt = "tif";

        // This is the full match pattern based upon your selections above
        $pattern = "*" . $ssm . "*." . $strExt;
        $cariImej = GetMatchingFiles(GetContents($strDir),$pattern);
    }
    
    //print_r($cariImej);
    return $cariImej;
}
// lisfile2 - mula
function GetMatchingFiles($files, $search) 
{
    // Split to name and filetype
    if(strpos($search,".")) 
    {
        $baseexp=substr($search,0,strpos($search,"."));
        $typeexp=substr($search,strpos($search,".")+1,strlen($search));
    } 
    else 
    { 
        $baseexp=$search;
        $typeexp="";
    } 
        
    // Escape all regexp Characters 
    $baseexp=preg_quote($baseexp); 
    $typeexp=preg_quote($typeexp); 
        
    // Allow ? and *
    $baseexp=str_replace(array("\*","\?"), array(".*","."), $baseexp);
    $typeexp=str_replace(array("\*","\?"), array(".*","."), $typeexp);
           
    // Search for Matches
    $i=0;
    $matches=null; // $matches adalah array()
    foreach($files as $file) 
    {
        $filename=basename($file);
              
        if(strpos($filename,".")) 
        {
            $base=substr($filename,0,strpos($filename,"."));
            $type=substr($filename,strpos($filename,".")+1,strlen($filename));
        } 
        else 
        { 
            $base=$filename;
            $type="";
        }

        if(preg_match("/^".$baseexp."$/i",$base) && preg_match("/^".$typeexp."$/i",$type))  
        {
            $matches[$i]=$file;
            $i++;
        }
    }
    
    return $matches;
    //return $matches;
}

// Returns all Files contained in given dir, including subdirs
function GetContents($dir,$files=array()) 
{
    if(!($res=opendir($dir))) exit("$dir doesn't exist!");
        while(($file=readdir($res))==TRUE) 
        if($file!="." && $file!="..")
            if(is_dir("$dir/$file")) $files=GetContents("$dir/$file",$files);
                else array_push($files,"$dir/$file");
         
    closedir($res);
    return $files;
}
// listfile2 - tamat
