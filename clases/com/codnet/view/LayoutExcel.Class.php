<?php

/**
 * Representa el layout básico para exportar a Excel:
 * 
 * @author bernardo
 * @since 03-06-2010
 */
class LayoutExcel extends LayoutHeaderContentFooter{
	
	//nombre del archivo excel.
	private $nombreArchivo;
	
	public function setNombreArchivo($value){
		$this->nombreArchivo = $value;
	}
	public function getNombreArchivo(){
		return $this->nombreArchivo;
	}
	
	/*	
	protected function getXTemplate(){
		return new XTemplate (APP_PATH. CLASS_PATH . 'codnet/view/layout_excel_template.html');
	}*/
	
	protected function getHeader(){
		//$xtpl = new XTemplate (APP_PATH.  'common/header.html');
		//$xtpl->parse('main');
		//return $xtpl->text('main');
		return "";
	}
	
	protected function getFooter(){
		return "";
	}
	
	protected function parseMetaTags($xtpl){
/*		$xtpl->assign('http_equiv', 'Content-Type');
		$xtpl->assign('meta_content', 'application/vnd.ms-excel;charset:ISO-8859-1;');
		$xtpl->parse('main.meta_tag');

		$xtpl->assign('http_equiv', 'Content-Description');
		$xtpl->assign('meta_content', 'File Transfer');
		$xtpl->parse('main.meta_tag');
		
		$xtpl->assign('http_equiv', 'Content-Disposition');
		$xtpl->assign('meta_content', 'attachment; filename=' . $this->nombreArchivo . '.xls');
		$xtpl->parse('main.meta_tag');
		
		$xtpl->assign('http_equiv', 'Content-Transfer-Encoding');
		$xtpl->assign('meta_content', 'binary');
		$xtpl->parse('main.meta_tag');
*/		
	}
	
	protected function parseEstilos($xtpl){
//		$xtpl->assign('css', WEB_PATH ."css/estilos.css");
//		$xtpl->parse('main.estilo');		
	}
	
	protected function parseScripts($xtpl){
	}

	public function show(){
		header("Pragma: public");
		header("Expires: 0");
		header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
		header("Cache-Control: public");
		header("Content-Description: File Transfer");
		header("Content-type:application/vnd.ms-excel;charset:ISO-8859-1;");
		header("Content-Disposition: attachment; filename=". $this->getNombreArchivo() .".xls");
				
		
		return parent::show();
	}

	public function setMenu( $value ){}
	public function showLayout(){
		return $this->show();
	}
}
