<?php
/**
 * Acci�n para agregar en sesi�n una cuadrilla utilizando Ajax.
 * 
 * @author Lucrecia
 * @since 11-04-2010
 *
 */
class AsignarCuadrillaAObraAction extends EditarCuadrillaDeObraAction{


	
	/**
	 * se agrega una cuadrilla en sesi�n.
	 */
	protected function editarTrabajadorObra(){

		//formamos el contratista.
		$oTrabajadorObra = $this->getTrabajadorObra();

		$cd_trabajadorObra = $oTrabajadorObra->getCd_trabajadorObra();
		
		if( !empty( $cd_trabajadorObra ) ){
			//chequeamos que no haya sido agregado
			if( ! $this->existeEnSesion($oTrabajadorObra) )
				//agregamos el trabajador en la sesi�n.
				$_SESSION['trabajadores_obra'][] = serialize( $oTrabajadorObra );
		}
	}
	

	public function getTrabajadorObra(){
		$oTrabajadorObra = new TrabajadorObra();

		if (isset ( $_GET ['cd_cuadrilla'] ) ){
			
			$cd_trabajadorObra = addslashes ( $_GET ['cd_cuadrilla'] ) ;
			
			if(!empty( $cd_trabajadorObra )){
			
				$manager = new TrabajadorObraManager();
				$oTrabajadorObra = $manager->getTrabajadorObraPorId( $cd_trabajadorObra );
			}
		}
		
		return $oTrabajadorObra;
	}
	
}