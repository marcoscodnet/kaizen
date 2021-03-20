<?php
/**
 *
 * @author María Jesús
 * @since 5-09-2011
 *
 * Factory para pedidos.
 *
 */
class PedidoFactory implements ObjectFactory{

	/**
	 * construye una pedido.
	 * @param $next
	 * @return unknown_type
	 */
	public function build($next){
		$oPedido = new Pedido();
		
		if ($next ['ds_pieza']){
			$oPedido->setCd_pieza( null );
			$oPedido->setDs_pieza( $next ['ds_pieza'] );
		} 
		else{
			$oPedido->setCd_pieza( $next ['cd_pieza'] );
			$oPedido->setDs_pieza( null );
		} 	
		
		$oPedido->setCd_pedido( $next ['cd_pedido'] );
		$oPedido->setNu_cantidad( $next ['nu_cantidad'] );
		$oPedido->setQt_minimo( $next ['qmin'] );
		$oPedido->setQt_sena( $next ['qt_sena'] );
		$oPedido->setCd_estado( $next ['cd_estado'] );
		$oPedido->setDt_pedido( implode("/", array_reverse(explode("-", $next ['dt_pedido'] ))));
		$oPedido->setDs_observacion( $next ['obs'] );

		//pieza
		if(array_key_exists('ds_codigo',$next)){
			$piezaFactory = new PiezaFactory();
			$oPedido->setPieza($piezaFactory->build($next));
		}
		
		return $oPedido;
	}
}
?>