<?php 

/**
 * Acción para inicializar el contexto para editar
 * un almacén.
 * 
 * @author bernardo
 * @since 15-04-2010
 * 
 */
abstract class EditarPerfilInitAction  extends EditarInitAction{

	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/EditarInitAction#getXTemplate()
	 */
	protected function getXTemplate(){
		return new XTemplate ( APP_PATH. '/perfiles/editarperfil.html' );
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/EditarInitAction#getEntidad()
	 */
	protected function getEntidad(){
		return new Perfil();
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/EditarInitAction#parseEntidad($entidad, $xtpl)
	 */
	protected function parseEntidad($entidad, XTemplate $xtpl){
		$oPerfil = FormatUtils::ifEmpty($entidad, new Perfil());
		//se muestra el perfil.
		$xtpl->assign ( 'cd_perfil', stripslashes ( $oPerfil->getCd_perfil () ) );
		$xtpl->assign ( 'ds_perfil', stripslashes ( $oPerfil->getDs_perfil () ) );

		//obtenemos todas las funciones.
		$manager = new PerfilManager();
		$funciones = $manager->getFunciones();

		$index=0;
		foreach($funciones as $key => $funcion) {

			if($index==4){
				$index=0;
				$xtpl->parse ( 'main.row' );
			}

			$xtpl->assign ( 'ds_funcion',  $funcion->getDs_funcion() ) ;

			if( $this->existe( $oPerfil->getFunciones(), $funcion ) )
			$xtpl->assign ( 'cd_funcion', "'".$funcion->getCd_funcion()."'"." checked" );
			else
			$xtpl->assign ( 'cd_funcion',  $funcion->getCd_funcion() ) ;

			$xtpl->parse ( 'main.row.funciones' );
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

	private function existe( ItemCollection $funciones=null, Funcion $funcion ){
		if(empty($funciones))
		return false;

		$existe = false;
		foreach($funciones as $key => $next) {
			$existe =  ( $next->getCd_funcion() == $funcion->getCd_funcion() );
			if($existe)
			return true;
		}
		return false;
	}


}