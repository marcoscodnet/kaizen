<?php

/**
 * Clase para construir el listado de piezas por Sucursal.
 *
 * @author marcos
 * @since 29-02-2012
 */
class PiezasPorSucursalListadoFactory extends ListadoFactory{

	/**
	 * (non-PHPdoc)
	 * @see clases/com/kaizen/webKaizen/action/reportes/factory/ListadoFactory#getListarTableModel($items)
	 */
	protected function getListarTableModel( ItemCollection $items ){
		return new PiezasPorSucursalTableModel( $items );
	}
		
	public function getTitulo(){
		return "Piezas por susursal";
	}	
	
	public function getDivId(){
		return "sucursal";
	}	
	
	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/IListar#getEntidades($criterio, $campoOrden, $orden, $page, $row_per_page)
	 */
	public function getEntidades(CriterioBusqueda $criterio){
		//obtenemos las conciliaciones..
		$manager = new PiezaManager();
		$piezas = $manager->getPiezasPorSucursal($criterio);

		return $piezas;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/IListar#getCantidadEntidades($criterio)
	 */
	public function getCantidadEntidades(CriterioBusqueda $criterio){
		$manager = new PiezaManager();
		$cantidad = $manager->getCantidadPiezasPorSucursal($criterio);
		return $cantidad;
	}
	
	public function getAccionReporte(){
		return "reporte_piezasporsucursal";
	}

	public function getUrlOrdenar($campoOrden, $orden, $page){
		$url = parent::getUrlOrdenar( $campoOrden, $orden, $page );
		$ds_nombre = $this->getDs_nombre();
		
		return $url . "&ds_nombre=$ds_nombre";
	}
	
	public function getUrlPaginador($campoOrden, $orden, $page){
		$url = parent::getUrlPaginador( $campoOrden, $orden, $page);
		$ds_nombre = $this->getDs_nombre();
		
		return $url . "&ds_nombre=$ds_nombre" ;
	}
	
	public function getDs_nombre(){
		if (isset ( $_GET ['ds_nombre'] )) 
			$ds_nombre = $_GET ['ds_nombre'];
			
		if(empty($ds_nombre)){
			if (isset ( $_GET ['id'] ))
				$ds_nombre = $_GET ['id'];
		}

		return $ds_nombre;	
	}
	


	
		
}
