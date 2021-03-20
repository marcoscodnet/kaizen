<?php
require_once( APP_PATH . 'fpdf/fpdf.php' );
require_once( APP_PATH . 'fpdi/fpdi.php' );

/**
 * Clase para unir documentos PDF
 * @author bernardo
 *
 */
class PDFConcat extends FPDI {

	var $files = array();

	function setFiles($files) {
		$this->files = $files;
	}
	
	function addFile($file){
		$this->files[] = $file;
	}

	function concat() {
		foreach($this->files AS $file) {
			$pagecount = $this->setSourceFile($file);
			for ($i = 1; $i <= $pagecount; $i++) {
				$tplidx = $this->ImportPage($i);
				$s = $this->getTemplatesize($tplidx);
				$this->AddPage('P', array($s['w'], $s['h']));
				$this->useTemplate($tplidx);
			}
		}
	}

}