<?php
/**
 *
 * @author Lucrecia
 * @since 18-01-2011
 *
 * Factory para cliente.
 *
 */
class ProductoFactory implements ObjectFactory{

	/**
	 * construye un producto.
	 * @param $next
	 * @return producto
	 */
	public function build($next){
		$oProducto = new Producto();

		$oProducto->setCd_producto($next ['cd_producto']);
		$oProducto->setDs_producto($next ['ds_producto']);
		$oProducto->setNu_monto_sugerido($next ['nu_monto_sugerido']);
		$oProducto->setNu_stock_minimo($next ['nu_stock_minimo']);
		if($next ['stock_actual'] == NULL){
			$stock_actual = 0;
		}else{
			$stock_actual = $next ['stock_actual'];
		}
		$oProducto->setNu_stock_actual($stock_actual);

		//para el caso de join con localidad.
		if(array_key_exists('ds_tipo_unidad',$next)){
			$tipounidadFactory = new TipounidadFactory();
			$oProducto->setTipounidad( $tipounidadFactory->build($next) );
		}

		if(array_key_exists('ds_marca',$next)){
			$marcaFactory = new MarcaFactory();
			$oProducto->setMarca( $marcaFactory->build($next) );
		}

		if(array_key_exists('ds_modelo',$next)){
			$modeloFactory = new ModeloFactory();
			$oProducto->setModelo( $modeloFactory->build($next) );
		}

		if(array_key_exists('ds_color',$next)){
			$colorFactory = new ColorFactory();
			$oProducto->setColor( $colorFactory->build($next) );
		}

		$oProducto->setBl_discontinuo( $next ['bl_discontinuo'] );
		return $oProducto;
	}
}
?>