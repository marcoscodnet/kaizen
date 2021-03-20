<?php

class UsuarioKaizen {

    private $oSucursal;
    private $cd_usuario;
    private $ds_nomusuario;
    private $ds_apynom;
    private $ds_mail;
    private $ds_password;
    private $oPerfil;
    private $funciones;
    private $bl_resetearclave;        private $bl_activo;

    function UsuarioKaizen($nombre='', $clave='') {

        $this->cd_usuario = '';
        $this->ds_nomusuario = $nombre;
        $this->ds_password = $clave;
        $this->oSucursal = new Sucursal();
        $this->oPerfil = new Perfil();
        $this->funciones = new ItemCollection();
        $this->bl_resetearclave='';                $this->bl_activo='1';
    }

    //M�todos Get

	function getBl_resetearclave() {
        return $this->bl_resetearclave;
    }
    
    function getSucursal() {
        return $this->oSucursal;
    }

    function getDs_sucursal() {
        return $this->getSucursal()->getDs_nombre();
    }

    function getCd_sucursal() {
        return $this->getSucursal()->getCd_sucursal();
    }

    function getFunciones() {
        return $this->funciones;
    }

    function getCd_usuario() {
        return $this->cd_usuario;
    }

    function getDs_nomusuario() {
        return $this->ds_nomusuario;
    }

    function getDs_password() {
        return $this->ds_password;
    }

    function getCd_perfil() {
        return $this->oPerfil->getCd_perfil();
    }

    function getDs_perfil() {
        return $this->getPerfil()->getDs_perfil();
    }

    function getPerfil() {
        return $this->oPerfil;
    }

    function getDs_mail() {
        return $this->ds_mail;
    }

    function getDs_apynom() {
        return $this->ds_apynom;
    }

    //M�todos Set

	function setBl_resetearclave($value) {
        $this->bl_resetearclave = $value;
    }
    
    function setSucursal($value) {
        $this->oSucursal = $value;
    }

    function setDs_sucursal($value) {
        $this->getSucursal()->setDs_nombre($value);
    }

    function setCd_sucursal($value) {
        $this->oSucursal->setCd_sucursal($value);
    }

    function setCd_usuario($value) {
        $this->cd_usuario = $value;
    }

    function setDs_nomusuario($value) {
        $this->ds_nomusuario = $value;
    }

    function setDs_password($value) {
        $this->ds_password = $value;
    }

    function setCd_perfil($value) {
        $this->oPerfil->setCd_perfil( $value );
    }

    function setPerfil($value) {
        $this->oPerfil = $value;
    }

    function setDs_mail($value) {
        $this->ds_mail = $value;
    }

    function setDs_apynom($value) {
        $this->ds_apynom = $value;
    }

    function setFunciones($value) {
        $this->funciones = $value;
    }

    //Functions


    function iniciarSesion() {
        session_start ();
        $_SESSION ["ds_usuario"] = $this->getDs_nomusuario();
        $_SESSION ["cd_usuarioSession"] = $this->getCd_usuario();

        //dejamos en sessi�n las funciones que puede realizar el usuario (permisos).
        $_SESSION ["funciones"] = $this->funciones;
    }

    function cerrarSesion() {
        session_start();
        if (!session_destroy ()) {
            $_SESSION ['cd_usuarioSession'] = null;
            unset($_SESSION ['cd_usuarioSession']);
            unset($_SESSION ['funciones']);
            session_unregister('cd_usuarioSession');
        }
    }

	public function getBl_activo()	{	    return $this->bl_activo;	}	public function setBl_activo($bl_activo)	{	    $this->bl_activo = $bl_activo;	}}

