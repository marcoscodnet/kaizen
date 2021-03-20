<?php 

/**
 * 
 * @author bernardo
 * @since 14-03-2010
 * 
 * Manager para perfil.
 *
 */
class PerfilManager implements IListar{

	/**
	 * se agrega un perfil nuevo.
	 * @param $oPerfil a agregar.
	 */
	public function agregarPerfil(Perfil $oPerfil, Array $perfilFunciones){
		
		//persistir perfil en la bbdd.
		PerfilQuery::insertarPerfil( $oPerfil );

		//persistir las funciones asociadas al perfil.
		PerfilFuncionQuery::insertarFuncionesDePerfil ( $oPerfil, $perfilFunciones );
	}
	
	/**
	 * se modifica un perfil.
	 * @param Perfil $oPerfil a modificar.
	 */
	public function modificarPerfil(Perfil $oPerfil, Array $perfilFunciones){
		//persistir los cambios del perfil en la bbdd.		
		PerfilQuery::modificarPerfil($oPerfil);
		
		//persistir los cambios en las funciones asociadas al perfil.
		PerfilFuncionQuery::modificarFuncionesDePerfil ( $oPerfil, $perfilFunciones );
	}
	
	
	/**
	 * eliminar un perfil.
	 * @param $cd_perfil identificador del perfil a eliminar
	 */
	public function eliminarPerfil($cd_perfil){

		$oPerfil = new Perfil ();
		$oPerfil->setCd_perfil ( $cd_perfil );		
		
		//Verificar que no esté asignado a ningún usuario
		$oUsuario = new Usuario ( );
		$oUsuario->setCd_perfil ( $oPerfil->getCd_perfil () );
		$asignado = UsuarioQuery::estaAsignadoAPerfil ( $oUsuario );
		
		if (! $asignado) {
			//persistir los cambios en la bbdd.
			PerfilQuery::eliminarPerfil($oPerfil );
		}else{
			//TODO excepcion con mensaje de error.
		}
	}

	/**
	 * se listan perfiles.
	 * @param $criterio
	 * @return unknown_type
	 */
	public function getPerfiles(CriterioBusqueda $criterio=null){
		$criterio = FormatUtils::ifEmpty( $criterio, new CriterioBusqueda());				
		$perfiles = PerfilQuery::getPerfiles($criterio);
				
		return $perfiles;
	}
	
	
	
	/**
	 * obtiene un perfil específico dado un identificador.
	 * @param $cd_perfil identificador del perfil a recuperar 
	 * @return unknown_type
	 */
	public function getPerfilPorId($cd_perfil){
		$oPerfil = new Perfil ();
		$oPerfil->setCd_perfil ( $cd_perfil );		
		$oPerfil =  PerfilQuery::getPerfilPorId( $oPerfil );
		return $oPerfil;
	}
	
	/**
	 * obtiene un perfil específico dado un identificador junto con sus funciones asociadas.
	 * @param $cd_perfil identificador del perfil a recuperar 
	 * @return unknown_type
	 */
	public function getPerfilConFuncionesPorId($cd_perfil){
		$oPerfil = new Perfil ();
		$oPerfil->setCd_perfil ( $cd_perfil );		
		$oPerfil =  PerfilQuery::getPerfilPorId( $oPerfil );		
		$funciones = FuncionQuery::getFuncionesDePerfil ( $oPerfil );		
		$oPerfil->setFunciones($funciones);
		return $oPerfil;
	}
	
	/**
	 * obtiene la cantidad de perfiles dado un filtro.
	 * @param $filtro filtro de búsqueda. 
	 * @return cantidad de perfiles
	 */
	public function getCantidadPerfiles( CriterioBusqueda $criterio ){
		$cant =  PerfilQuery::getCountPerfiles(  $criterio );
		return $cant;
	}

	function getFunciones() {
		return FuncionQuery::getFunciones();
	}
	
	function getFuncionesDeUsuario( Usuario $oUsuario ) {
		return FuncionQuery::getFuncionesDeUsuario($oUsuario);
	}
	
		
	//INTERFACE IListar.
	
	function getEntidades ( CriterioBusqueda $criterio ){
		return  $this->getPerfiles( $criterio );
	}
	
	function getCantidadEntidades (  CriterioBusqueda $criterio ){
		return $this->getCantidadPerfiles(  $criterio );
	}
}