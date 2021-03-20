<?php
/**
 * 
 * @author Lucrecia
 * @since 09-01-2011
 * 
 * Factory para modelo.
 *
 */
class ModeloFactory implements ObjectFactory{

	/**
	 * construye una modelo. 
	 * @param $next
	 * @return unknown_type
	 */
	public function build($next){
		$oModelo = new Modelo();
		$oModelo->setCd_modelo( $next ['cd_modelo'] );
		$oModelo->setDs_modelo( $next ['ds_modelo'] );
		$oModelo->setCd_marca( $next ['cd_marca'] );		
		
		//para el caso de join con marca.
		if(array_key_exists('ds_marca',$next)){
			$marcaFactory = new MarcaFactory();
			$oModelo->setPais( $marcaFactory->build($next) );	
		}		
		
		return $oModelo;
	}
}
?>