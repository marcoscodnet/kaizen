<?php 

/**
 * Interfaz que deberán implementar los "managers"
 * para ser utilizadas en el ListarAction.
 * 
 * @author bernardo
 * @since 05-03-2010
 * 
 */
interface IListar{

	/**
	 * lista entidades.
	 * @param $criterio
	 * @return ItemCollection
	 */
	function getEntidades ( CriterioBusqueda $criterio );
	
	/**
	 * obtiene cantidad de entidades dado un filtro.
	 * @param $criterio
	 * @return ItemCollection
	 */
	function getCantidadEntidades ( CriterioBusqueda $criterio );
	
	
}