<?php 

/**
 * Acción para inicializar el contexto para editar
 * una sucursal.
 * 
 * @author Lucrecia
 * @since 25-04-2010
 * 
 */
abstract class EditarSucursalInitAction  extends EditarInitAction{

	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/EditarInitAction#getXTemplate()
	 */
	protected function getXTemplate(){
		return new XTemplate ( APP_PATH. '/sucursales/editarsucursal.html' );
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/EditarInitAction#getEntidad()
	 */
	protected function getEntidad(){
		return new Sucursal();
	}
		
	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/EditarInitAction#parseEntidad($entidad, $xtpl)
	 */
	protected function parseEntidad($entidad, XTemplate $xtpl){
		$oSucursal = FormatUtils::ifEmpty($entidad, new Sucursal());
		//se muestra el cliente.
		$this->parseSucursal( $oSucursal , $xtpl);
		$this->parsePaises( $oSucursal->getProvincia()->getCd_pais(), $xtpl );
		$this->parseProvincias( $oSucursal->getProvincia()->getCd_pais(), $oSucursal->getProvincia()->getCd_provincia(), $xtpl );
		$this->parseLocalidades($oSucursal->getProvincia()->getCd_provincia(), $oSucursal->getLocalidad()->getCd_localidad(), $xtpl );
	}
	
	
	protected function parseSucursal(Sucursal $oSucursal, XTemplate $xtpl){
		//se muestra el cliente.
		$xtpl->assign ( 'cd_sucursal', $oSucursal->getCd_sucursal());
		$xtpl->assign ( 'ds_nombre', stripslashes ( $oSucursal->getDs_nombre () ) );
		$xtpl->assign ( 'ds_email', stripslashes ( $oSucursal->getDs_email () ) );
		$xtpl->assign ( 'ds_telefono', stripslashes ( $oSucursal->getDs_telefono () ) );
		$xtpl->assign ( 'ds_domicilio', stripslashes ( $oSucursal->getDs_domicilio () ) );
		$xtpl->assign ( 'ds_comentario', stripslashes ( $oSucursal->getDs_comentario () ) );
		$xtpl->assign ( 'ds_localidad', stripslashes ( $oSucursal->getDs_localidad () ) );
		$xtpl->assign ( 'ds_provincia', stripslashes ( $oSucursal->getDs_provincia() ) );
	}

	protected function parsePaises($cd_selected='', XTemplate $xtpl){
		//recupera y parsea países.
		$localizacionManager = new LocalizacionManager();
		$paises = $localizacionManager->getPaises();
		
		foreach($paises as $key => $pais) {
			$xtpl->assign ( 'ds_pais', $pais->getDs_pais() );
			$xtpl->assign ( 'cd_pais', FormatUtils::selected($pais->getCd_pais(), $cd_selected)  );
			$xtpl->parse ( 'main.option_pais' );
		}
	}
	
	protected function parseProvincias($cd_pais, $cd_selected='', XTemplate $xtpl){
		//recupera y parsea provincias.
		$localizacionManager = new LocalizacionManager();
		$cd_pais= FormatUtils::ifEmpty( $cd_pais, 0);
		$provincias = $localizacionManager->getProvinciasPorPais($cd_pais);
		
		foreach($provincias as $key => $provincia) {
			$xtpl->assign ( 'ds_provincia', $provincia->getDs_provincia() );
			$xtpl->assign ( 'cd_provincia', FormatUtils::selected($provincia->getCd_provincia(), $cd_selected)  );
			$xtpl->parse ( 'main.option_provincia' );
		}
	}
	
	protected function parseLocalidades($cd_provincia, $cd_selected='', XTemplate $xtpl){
		//recupera y parsea localidades.
		$localizacionManager = new LocalizacionManager();
		$cd_provincia= FormatUtils::ifEmpty( $cd_provincia, 0);

		$localidades = $localizacionManager->getLocalidadesPorProvincia($cd_provincia);
		
		foreach($localidades as $key => $localidad) {
			$xtpl->assign ( 'ds_localidad', $localidad->getDs_localidad() );
			$xtpl->assign ( 'cd_localidad', FormatUtils::selected($localidad->getCd_localidad(), $cd_selected)  );
			$xtpl->parse ( 'main.option_localidad' );
		}
	}
	
}