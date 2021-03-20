<?php 

/**
 * 
 * @author bernardo
 * @since 31-03-2010
 * 
 * Manager para referencias.
 * 
 * Se deberá implementar una subclase para cada referencia 
 * concreta. Asi por ejemplo, si tenemos la referencia Motivo,
 * creamos MotivoManager el cual retornará la clase Query específica
 * para motivos.
 *
 */
abstract class ReferenciaManager implements IListar{

	protected abstract function getReferenciaQuery();
	
	/**
	 * se agrega un referencia nuevo.
	 * @param $oReferencia a agregar.
	 */
	public function agregarReferencia(Referencia $oReferencia){
		
		//persistir referencia en la bbdd.
		$this->getReferenciaQuery()->insertReferencia( $oReferencia );
				 
	}
	
	/**
	 * se modifica un referencia.
	 * @param Referencia $oReferencia a modificar.
	 */
	public function modificarReferencia(Referencia $oReferencia){

		//persistir los cambios del referencia en la bbdd.		
		$this->getReferenciaQuery()->modificarReferencia($oReferencia);
					
	}
	
	
	/**
	 * eliminar un referencia.
	 * @param $cd_referencia identificador del referencia a eliminar
	 */
	public function eliminarReferencia($cd_referencia){

		$oReferencia = new Referencia ();
		$oReferencia->setCd_referencia ( $cd_referencia );		
		
		//TODO validaciones.
		
		//persistir los cambios en la bbdd.
		$this->getReferenciaQuery()->eliminarReferencia($oReferencia );
		
	}

	/**
	 * se listan referencias.
	 * @param $criterio
	 * @return unknown_type
	 */
	public function getReferencias(CriterioBusqueda $criterio=null){
		$criterio = FormatUtils::ifEmpty( $criterio, new CriterioBusqueda());		
		$referencias = $this->getReferenciaQuery()->getReferencias( $criterio );
				
		return $referencias;
	}
	
	
	
	/**
	 * obtiene un referencia específico dado un identificador.
	 * @param $cd_referencia identificador del referencia a recuperar 
	 * @return unknown_type
	 */
	public function getReferenciaPorId($cd_referencia){
		$oReferencia = new Referencia ();
		$oReferencia->setCd_referencia ( $cd_referencia );		
		$oReferencia =  $this->getReferenciaQuery()->getReferenciaPorId( $oReferencia );
		return $oReferencia;
	}
	
	/**
	 * obtiene la cantidad de referencias dado un filtro.
	 * @param $criterio filtro de búsqueda. 
	 * @return cantidad de referencias
	 */
	public function getCantidadReferencias( CriterioBusqueda $criterio ){
		$cant =  $this->getReferenciaQuery()->getCantReferencias( $criterio );
		return $cant;
	}

	
	//INTERFACE IListar.
	
	function getEntidades ( CriterioBusqueda $criterio ){
		return  $this->getReferencias( $criterio );
	}
	
	function getCantidadEntidades ( CriterioBusqueda $criterio){
		return $this->getCantidadReferencias( $criterio );
	}
}