<?php
/**
* 
*/
include FCPATH.'vendor/mpdf/mpdf/mpdf.php';

class Pdf
{
	private $mpdf;
	function load($config = NULL)
	{
		if ($config === NULL) {
			$config = '"en-GB-x","Legal","","",10,10,10,10,6,3,""';
		}
		return new mPDF($config);
		// return $this->mpdf;
	}
}