<?php 

/**
 * Acción para inicializar el contexto para editar
 * un almacén.
 * 
 * @author Lucrecia
 * @since 15-04-2010
 * 
 */
abstract class EditarAlmacenInitAction  extends EditarInitAction{

	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/EditarInitAction#getXTemplate()
	 */
	protected function getXTemplate(){
		return new XTemplate ( APP_PATH. '/almacenes/editaralmacen.html' );
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/EditarInitAction#getEntidad()
	 */
	protected function getEntidad(){
		return new Almacen();
	}
		
	/**
	 * (non-PHPdoc)
	 * @see clases/com/codnet/action/generic/EditarInitAction#parseEntidad($entidad, $xtpl)
	 */
	protected function parseEntidad($entidad, XTemplate $xtpl){
		$oAlmacen = FormatUtils::ifEmpty($entidad, new Almacen());
		//se muestra el almacén.
		$this->parseAlmacen( $oAlmacen , $xtpl);
		$this->parsePaises( $oAlmacen->getProvincia()->getCd_pais(), $xtpl );
		$this->parseProvincias( $oAlmacen->getProvincia()->getCd_pais(), $oAlmacen->getProvincia()->getCd_provincia(), $xtpl );
		$this->parseLocalidades($oAlmacen->getProvincia()->getCd_provincia(), $oAlmacen->getLocalidad()->getCd_localidad(), $xtpl );
	}
	
	
	protected function parseAlmacen(Almacen $oAlmacen, XTemplate $xtpl){
		//se muestra el almacén.
		$xtpl->assign ( 'cd_almacen', $oAlmacen->getCd_almacen());
		$xtpl->assign ( 'ds_nombre',   htmlspecialchars( $oAlmacen->getDs_nombre () )  );
		$xtpl->assign ( 'ds_email',  $oAlmacen->getDs_email ()  );
		$xtpl->assign ( 'ds_cuit',  $oAlmacen->getDs_cuit ()  );
		$xtpl->assign ( 'ds_telefono',  $oAlmacen->getDs_telefono () );
		$xtpl->assign ( 'ds_celular', $oAlmacen->getDs_celular () ) ;
		$xtpl->assign ( 'ds_domicilio',  htmlentities( $oAlmacen->getDs_domicilio () ) ) ;
		$xtpl->assign ( 'ds_comentario',  htmlentities( $oAlmacen->getDs_comentario () ) );
		$xtpl->assign ( 'ds_contacto', htmlspecialchars( $oAlmacen->getDs_contacto () )  );
		$xtpl->assign ( 'ds_localidad', htmlspecialchars( $oAlmacen->getDs_localidad () ) ) ;
		$xtpl->assign ( 'ds_provincia', htmlspecialchars( $oAlmacen->getDs_provincia() ) ) ;
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