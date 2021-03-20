<?php

/**
 * Acción para inicializar el contexto para editar
 * un almacén.
 *
 * @author Lucrecia
 * @since 15-04-2010
 *
 */
abstract class EditarMarcaInitAction  extends EditarInitAction{

	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/EditarInitAction#getXTemplate()
	 */
	protected function getXTemplate(){
		return new XTemplate ( APP_PATH. '/marcas/editarmarca.html' );
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/EditarInitAction#getEntidad()
	 */
	protected function getEntidad(){
		return new Marca();
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/EditarInitAction#parseEntidad($entidad, $xtpl)
	 */
	protected function parseEntidad($entidad, XTemplate $xtpl){
		$oMarca = FormatUtils::ifEmpty($entidad, new Marca());
		//se muestra el marca.
		$xtpl->assign ( 'cd_marca', stripslashes ( $oMarca->getCd_marca () ) );
		$xtpl->assign ( 'ds_marca', stripslashes ( $oMarca->getDs_marca () ) );

		//obtenemos todas los tipos de unidades.
		$manager = new MarcaManager();
		$tiposunidades = $manager->getTiposunidades();

		$index=0;
		foreach($tiposunidades as $key => $tipounidad) {

			if($index==4){
				$index=0;
				$xtpl->parse ( 'main.row' );
			}

			$xtpl->assign ( 'ds_tipounidad',  $tipounidad->getDs_tipounidad() ) ;
			if( $this->existe( $oMarca->getTiposunidades(), $tipounidad ) )
			$xtpl->assign ( 'cd_tipounidad', "'".$tipounidad->getCd_tipounidad()."'"." checked" );
			else
			$xtpl->assign ( 'cd_tipounidad',  $tipounidad->getCd_tipounidad() ) ;

			$xtpl->parse ( 'main.row.tipounidades' );
			$index++;
		}
		//Esto es para completar las celdas vacías en una fila.
		if($index<=4){
			while($index< 4){
				$xtpl->parse ( 'main.row.celdavacia' );
				$index++;
			}
			$xtpl->parse( 'main.row' );
		}

	}

	private function existe( ItemCollection $tiposunidades=null, Tipounidad $tipounidad ){
		if(empty($tiposunidades))
		return false;

		$existe = false;
		foreach($tiposunidades as $key => $next) {
			$existe =  ( $next->getCd_tipounidad() == $tipounidad->getCd_tipounidad() );
			if($existe)
			return true;
		}
		return false;
	}


}