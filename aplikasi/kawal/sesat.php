<?php

class Sesat extends Kawal 
{

	function __construct() 
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

		$this->_tajukAtas = 'Sesat Pada Bulan/Suku:';
		$this->_folder = 'sesat';

	}
	
	function index() 
	{
		$this->papar->pegawai = senarai_kakitangan();
		$this->papar->mesej = 'Halaman ini tidak wujud';
		$this->papar->Tajuk_Muka_Surat = $this->_tajukAtas . $this->papar->mesej;
		$this->papar->baca($this->_folder . '/index');
	}

	function parameter() 
	{
		$this->papar->pegawai = senarai_kakitangan();
		$this->papar->mesej = 'Class wujud tapi parameter/method/fungsi tidak wujud';
		$this->papar->Tajuk_Muka_Surat = $this->_tajukAtas . $this->papar->mesej;		
		$this->papar->baca($this->_folder . '/index');
	}

	function classTidakWujud($amaran) 
	{
		$this->papar->pegawai = senarai_kakitangan();
		$this->papar->mesej = $amaran;
		$this->papar->Tajuk_Muka_Surat = $this->_tajukAtas . $this->papar->mesej;		
		$this->papar->baca($this->_folder . '/index');
	}

	function failTidakWujud() 
	{
		$this->papar->pegawai = senarai_kakitangan();
		$this->papar->mesej = 'Fail tidak wujud dalam PAPAR';
		$this->papar->Tajuk_Muka_Surat = $this->_tajukAtas . $this->papar->mesej;		
		$this->papar->baca($this->_folder . '/index');
	}
	
}