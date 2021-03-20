<?php

/**
 * Acción para editar un pedido.
 *
 * @author María Jesús
 * @since 23-08-2011
 *
 */
abstract class EditarPedidoAction extends EditarAction {

	protected function getEntidad() {
		$oPedido = new Pedido();

		if (isset($_POST ['cd_pedido'])){
			$oPedido->setCd_pedido($_POST['cd_pedido']);
		}

		if (isset($_POST ['nueva_pieza'])){
			$oPedido->setCd_pieza( null );
			$oPedido->setDs_pieza( $_POST['ds_pieza_nueva'] );
		} 
		else{
			$oPedido->setCd_pieza($_POST['cd_pieza']);
			$oPedido->setDs_pieza($_POST['ds_pieza']);
		} 	
		
		if (isset($_POST ['nu_cantidad'])){
			$oPedido->setNu_cantidad($_POST['nu_cantidad']);
		}

		if (isset($_POST ['qt_minimo'])){
			$oPedido->setQt_minimo($_POST['qt_minimo']);
		}
		
		if (isset($_POST ['qt_sena'])){
			$oPedido->setQt_sena($_POST['qt_sena']);
		}
		
		if (isset($_POST ['cd_estado'])){
			$oPedido->setCd_estado($_POST['cd_estado']);
		}

		if (isset($_POST ['dt_pedido'])){
			$dt_pedido = str_replace("/","-", $_POST['dt_pedido']);
			$dt_pedido = implode("-", array_reverse(explode("-", $dt_pedido)));
			$oPedido->setDt_pedido($dt_pedido);
		}

		if (isset ( $_POST ['ds_observacion'] ))
			$oPedido->setDs_observacion( $_POST ['ds_observacion'] ) ;
		
		return $oPedido;
	}

}