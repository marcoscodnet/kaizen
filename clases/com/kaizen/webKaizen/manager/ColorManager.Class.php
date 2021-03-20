<?php 

/**
 * 
 * @author Lucrecia
 * @since 31-01-2011
 * 
 * Manager para colores.
 * 
 */
class ColorManager extends ReferenciaManager{

	protected function getReferenciaQuery(){
		return new ColorQuery();
	}

	public function agregarColor(Color $oColor){

		//persistir color en la bbdd.
		ColorQuery::insertColor( $oColor );

	}

	/**
	 * se modifica una color.
	 * @param Color $oColor a modificar.
	 */
	
	public function modificarColor(Color $oColor){

		//persistir los cambios de la color en la bbdd.
		ColorQuery::modificarColor($oColor);

	}


	/**
	 * eliminar una color.
	 * @param $cd_color identificador de la color a eliminar
	 */
	public function eliminarColor($cd_color){
		$oColor = new Color();
		$oColor->setCd_color ( $cd_color );
		ColorQuery::eliminarColor($oColor);
	}

	/**
	 * se listan colores.
	 * @param $criterio
	 * @return unknown_type
	 */
	public function getColores(CriterioBusqueda $criterio){

		$colores = ColorQuery::getcolores($criterio);

		return $colores;
	}



	/**
	 * obtiene una color específico dado un identificador.
	 * @param $cd_color identificador de la color a recuperar 
	 * @return unknown_type
	 */
	public function getColorPorId($cd_color){
		$criterio = new CriterioBusqueda();
		$criterio->addFiltro('C.cd_color', $cd_color, '=');
		$oColor =  ColorQuery::getColor ( $criterio );
		return $oColor;
	}

	/**
	 * obtiene la cantidad de colores dado un filtro.
	 * @param $filtro filtro de búsqueda. 
	 * @return cantidad de colores
	 */
	public function getCantidadColores( CriterioBusqueda $criterio){
		$cant =  ColorQuery::getCantColores( $criterio );
		return $cant;
	}


	//INTERFACE IListar.

	function getEntidades ( CriterioBusqueda $criterio ){
		return  $this->getColores( $criterio );
	}

	function getCantidadEntidades ( CriterioBusqueda $criterio){
		return $this->getCantidadColores( $criterio );
	}

}