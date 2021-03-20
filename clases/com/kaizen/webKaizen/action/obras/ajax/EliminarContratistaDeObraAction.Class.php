<?php
/**
 * Acción para eliminar de sesión un contratista utilizando Ajax.
 * 
 * @author Lucrecia
 * @since 09-04-2010
 *
 */
class EliminarContratistaDeObraAction extends EditarContratistaDeObraAction{

	

	/**
	 * se elimina de sesión el contratista seleccionado.
	 */
	protected function editarTrabajadorObra(){
		//eliminamos el contratista de la sesión.
		if (isset ( $_GET ['indice'] )){
			$indice = $_GET ['indice'];
			
			$trabajadores = array();
			$count = count($_SESSION['trabajadores_obra']);
			for($i=0;$i<$count;$i++) {
	    		
				if($i!=$indice)
					array_push ( $trabajadores,  $_SESSION['trabajadores_obra'][$i]);
				else{
					//TODO chequear si el contratista puede ser eliminado.
				}	
				
			}
			
			$_SESSION['trabajadores_obra'] = $trabajadores;
			
		}
	}
}