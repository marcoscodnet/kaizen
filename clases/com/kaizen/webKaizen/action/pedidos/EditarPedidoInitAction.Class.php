<?php

/**
 * Acciï¿½n para inicializar el contexto para editar
 * un pedido.
 *
 * @author María Jesús
 * @since 23-08-2011
 *
 */
abstract class EditarPedidoInitAction extends EditarInitAction {

    /**
     * (non-PHPdoc)
     * @see clases/com/codnet/action/generic/EditarInitAction#getXTemplate()
     */
    protected function getXTemplate() {
        return new XTemplate(APP_PATH . '/pedidos/editarPedido.html');
    }

    protected function getEntidad() {
        return new Pedido();
    }

    protected function parseEntidad($entidad, XTemplate $xtpl) {
        $oPedido = FormatUtils::ifEmpty($entidad, new Pedido());
		//se muestra el pedido.
		$this->parsePedido( $oPedido , $xtpl);
		$this->parsePiezas($oPedido->getCd_pieza(), $xtpl);
		$this->parseEstados($oPedido->getCd_estado(), $xtpl);
		//$this->parseEstados($oPedido->getCd_estado(), $xtpl);
    }

	protected function parsePedido(Pedido $oPedido, XTemplate $xtpl){
		//se muestra el pedido.
		
		if ($oPedido->getDs_pieza()){
			$xtpl->assign ( 'cd_pieza', 0);
			$xtpl->assign ( 'ds_pieza_nueva', $oPedido->getDs_pieza());
			$xtpl->assign ( 'disabled', "disabled");
		} 
		else{
			$xtpl->assign ( 'cd_pieza', $oPedido->getCd_pieza());
			$xtpl->assign ( 'ds_pieza_nueva', "");
		} 	
		
		$xtpl->assign ( 'cd_pedido', $oPedido->getCd_pedido());
		$xtpl->assign ( 'nu_cantidad', $oPedido->getNu_cantidad());
		$xtpl->assign ( 'qt_minimo', stripslashes ( $oPedido->getQt_minimo () ) );
		$xtpl->assign ( 'qt_sena', stripslashes ( $oPedido->getQt_sena () ) );
		$xtpl->assign ( 'cd_estado', $oPedido->getCd_estado());
		$xtpl->assign ( 'dt_pedido', $oPedido->getDt_pedido());
		$xtpl->assign ( 'ds_observacion', $oPedido->getDs_observacion());
	}
	
 	protected function parseEstados($cd_selected='', XTemplate $xtpl) {
            $xtpl->assign('ds_estado', "A PEDIR");
            $xtpl->assign('cd_estado', FormatUtils::selected(0, $cd_selected));
            $xtpl->parse('main.option_estado');
            $xtpl->assign('ds_estado', "PEDIDO");
            $xtpl->assign('cd_estado', FormatUtils::selected(1, $cd_selected));
            $xtpl->parse('main.option_estado');
    }
    
	protected function parsePiezas($cd_selected='', XTemplate $xtpl) {
        $piezaManager = new PiezaManager();
        $criterio = new CriterioBusqueda();
        $piezas = $piezaManager->getPiezas($criterio);
        foreach ($piezas as $key => $pieza) {
            $xtpl->assign('ds_codigo', $pieza->getDs_codigo());
            $xtpl->assign('cd_pieza', FormatUtils::selected($pieza->getCd_pieza(), $cd_selected));
            $xtpl->parse('main.option_pieza');
        }
    }
    
	/* function parseEstados($cd_selected='', XTemplate $xtpl) {
        if ($cd_selected==0){
            $xtpl->assign('ds_estado', "A Pedir");
            $xtpl->assign('cd_estado', FormatUtils::selected(0, $cd_selected));
            $xtpl->parse('main.option_estado');
            $xtpl->assign('ds_estado', "Pedido");
            $xtpl->assign('cd_estado', 1);
            $xtpl->parse('main.option_estado');
        }
        if ($cd_selected==1){
        	$xtpl->assign('ds_estado', "A Pedir");
            $xtpl->assign('cd_estado', 0);
            $xtpl->parse('main.option_estado');
            $xtpl->assign('ds_estado', "Pedido");
            $xtpl->assign('cd_estado', FormatUtils::selected(1, $cd_selected));
            $xtpl->parse('main.option_estado');
        }
    }*/
}