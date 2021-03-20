<?php 

/**
 * Acción para editar un almacén.
 * 
 * @author Lucrecia
 * @since 15-04-2010
 * 
 */
abstract class EditarMarcaAction extends EditarAction{

	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/EditarAction#getEntidad()
	 */
	protected function getEntidad(){
		
		//se construye el marca a modificar.
		$oMarca = new Marca ( );
		
		if( isset($_POST ['cd_marca']))
			$oMarca->setCd_marca (  $_POST ['cd_marca'] ) ;
		
		$oMarcatipounidad = new MarcaTipoUnidad ( );
		
		if (isset ( $_POST ['tiposunidades'] ))
			$tiposunidades = $_POST ['tiposunidades']; 
			else
			$tiposunidades = array ( );
			
		//Recorro las tiposunidades y creo nuevos obj MarcaTipounidad por cada tiposunidad del marca
		if (isset ( $_POST ['cd_marca'] )) {
			$oMarcatipounidad->setCd_marca ( $_POST ['cd_marca']  );
			$tiposunidades = $_POST ['tiposunidades'];
			$marcaTipounidades = array ( );
			$i = 0;
			$long = count ( $tiposunidades );
			while ( $i < $long ) {
				$tu = $tiposunidades [$i];
				$mtu = new $oMarcatipounidad ( );
				$mtu->setCd_marca ( $oMarca->getCd_marca () );
				$mtu->setCd_tipounidad ( $tu );
				array_push ( $marcaTipounidades, $mtu );
				$i ++;
			}
		}
		if (isset ( $_POST ['ds_marca'] ))
		$oMarca->setDs_marca ( $_POST ['ds_marca'] );
			
		$oEntidad[]=$oMarca;
		$oEntidad[]=$marcaTipounidades;
		return $oEntidad;
	}
}