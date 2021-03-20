<?php 

/**
 * Acción para reportes.
 * Se define un esquema genérico para reportes.
 * 
 * @author bernardo
 * @since 27-04-2010
 * 
 */
abstract class ReporteAction extends SecureOutputAction{
	
	/**
	 * @return acción para ejecutar el reporte.
	 */
	protected abstract function getAccionReporte();
	
	
	/**
	 * @return acción para imprimir el reporte en pdf.
	 */
	protected function getAccionReportePDF(){
		return null;
	}
	
	
	/**
	 * @return acción para imprimir el reporte en excel.
	 */
	protected function getAccionReporteExcel(){
		return null;
	}
		
	/**
	 * template donde parsear la salida.
	 * @return unknown_type
	 */
	protected function getXTemplate(){
		return new XTemplate(APP_PATH. CLASS_PATH . 'codnet/view/reporte_template.html');
	}
	
	/**
	 * contenido para el criterio de búsqueda.
	 * @return texto.
	 */
	protected function getCriterioBusqueda(){
		return '';
	}
	
	/**
	 * parsea el criterio de búsqueda.
	 * @return texto.
	 */
	protected function parseCriterioBusqueda(XTemplate $xtpl){
		$criterio = $this->getCriterioBusqueda();
		$xtpl->assign('accion_reporte', $this->getAccionReporte());
		$xtpl->assign('criterio', $criterio);
		$xtpl->parse('main.criterio');		
	}

	/**
	 * contenido para el header.
	 * @return texto.
	 */
	protected function getHeader(){
		return '';
	}
	
	/**
	 * parsea el header.
	 * @return texto.
	 */
	protected function parseHeader(XTemplate $xtpl){
		$header = $this->getHeader();
		$xtpl->assign('header', $header);
		

		//botones para exportar.
		$pdf = $this->getAccionReportePDF();		
		if(!empty($pdf)){
			$xtpl->assign ( 'accion_pdf', $this->getAccionReportePDF() );
			$xtpl->parse( 'main.exportar.pdf');
		}

		$excel = $this->getAccionReporteExcel();
		if(!empty($excel)){
			$xtpl->assign ( 'accion_excel', $this->getAccionReporteExcel() );
			$xtpl->parse( 'main.exportar.excel');
		}
		
		$xtpl->parse( 'main.exportar');		
		
		
		$xtpl->parse('main.header');
		
	}
	
	/**
	 * contenido para el footer.
	 * @return texto.
	 */
	protected function getFooter(){
		return '';
	}
	
	/**
	 * parsea el footer.
	 * @return texto.
	 */
	protected function parseFooter(XTemplate $xtpl){
		$footer = $this->getFooter();
		$xtpl->assign('footer', $footer);
		
		//botones para exportar.
		$pdf = $this->getAccionReportePDF();
		if(!empty($pdf)){
			$xtpl->assign ( 'accion_pdf', $this->getAccionReportePDF() );
			$xtpl->parse( 'main.footer.exportar.pdf');
		}

		$excel = $this->getAccionReporteExcel();
		if(!empty($excel)){
			$xtpl->assign ( 'accion_excel', $this->getAccionReporteExcel() );
			$xtpl->parse( 'main.footer.exportar.excel');
		}
		
		$xtpl->parse( 'main.footer.exportar');		
		
		
		$xtpl->parse('main.footer');		
	}

	/**
	 * listados a mostrar.
	 * @return ItemCollection con los listados.
	 */
	protected function getListados(){
		return new ItemCollection();
	}
	
	/**
	 * se listan entidades.
	 * @return boolean (true=exito).
	 */
	protected function getContenido(){
		
		$xtpl = $this->getXTemplate();
		$xtpl->assign('WEB_PATH', WEB_PATH);
		
		$xtpl->assign('titulo', $this->getTitulo());
		
		//parseamos el criterio de búsqueda.				
		$this->parseCriterioBusqueda($xtpl);
		
		//parseamos el header.
		$this->parseHeader($xtpl);
		
		//parseamos los listados.
		$listados = $this->getListados();
		foreach ($listados as $listado) {
			$xtpl->assign('listado', $listado);
			$xtpl->parse('main.listado');
		}
		
		//parseamos el footer.
		$this->parseFooter($xtpl);
		
		$xtpl->parse('main');

		return $xtpl->text('main');
		
	}
	
}