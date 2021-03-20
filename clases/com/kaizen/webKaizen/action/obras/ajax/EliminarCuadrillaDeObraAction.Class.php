<?php
/**
 * Acci�n para eliminar de sesi�n una cuadrilla utilizando Ajax.
 * 
 * @author Lucrecia
 * @since 12-04-2010
 *
 */
class EliminarCuadrillaDeObraAction extends EditarCuadrillaDeObraAction{

	/**
	 * se elimina de sesi�n la cuadrilla seleccionada.
	 */
	protected function editarTrabajadorObra(){

		//eliminamos el contratista de la sesi�n.
		if (isset ( $_GET ['indice'] )){
			$indice = $_GET ['indice'];
			
			$trabajadores = array();
			$count = count($_SESSION['trabajadores_obra']);
			for($i=0;$i<$count;$i++) {
	    		
				if($i!=$indice){
					array_push ( $trabajadores,  $_SESSION['trabajadores_obra'][$i]);
				}else{
					//TODO chequear si la cuadrilla puede ser eliminada.
					
				}
				
			}
			
			$_SESSION['trabajadores_obra'] = $trabajadores;
			
		}
	}
}