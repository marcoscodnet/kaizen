<?php

/**
 * Acci�n para modificar un usuario.
 * 
 * @author bernardo
 * @since 14-03-2010
 * 
 */
class ModificarUsuarioKaizenAction extends EditarUsuarioKaizenAction {

    /**
     * (non-PHPdoc)
     * @see clases/com/codnet/action/generic/EditarAction#editar($oEntidad)
     */
    protected function editar($oEntidad) {
        $manager = new UsuarioKaizenManager();
        $manager->modificarUsuario($oEntidad);
    }

    /**
     * (non-PHPdoc)
     * @see clases/com/codnet/action/generic/EditarAction#getForwardSuccess()
     */
    protected function getForwardSuccess() {
        return 'modificar_usuarioKaizen_success';
    }

    /**
     * (non-PHPdoc)
     * @see clases/com/codnet/action/generic/EditarAction#getForwardError()
     */
    protected function getForwardError() {
        return 'modificar_usuarioKaizen_error';
    }

    /**
     * (non-PHPdoc)
     * @see clases/com/codnet/action/generic/SecureAction#getFuncion()
     */
    public function getFuncion() {
        return "Modificar Usuario";
    }

}