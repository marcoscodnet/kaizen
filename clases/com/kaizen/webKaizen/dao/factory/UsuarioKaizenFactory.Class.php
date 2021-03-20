<?php

/**
 * 
 * @author bernardo
 * @since 14-03-2010
 * 
 * Factory para usuario.
 *
 */
class UsuarioKaizenFactory implements ObjectFactory {

    public function build($next) {
        $oUsuarioKaizen = new UsuarioKaizen();
        $oUsuarioKaizen->setDs_nomusuario($next ['ds_nomusuario']);
        $oUsuarioKaizen->setCd_usuario($next ['cd_usuario']);
        $oUsuarioKaizen->setCd_perfil($next ['cd_perfil']);
        $oUsuarioKaizen->setDs_apynom($next ['ds_apynom']);
        $oUsuarioKaizen->setDs_mail($next ['ds_mail']);
        $oUsuarioKaizen->setDs_password($next ['ds_password']);
        $oUsuarioKaizen->setBl_resetearclave($next ['bl_resetearclave']);
        $oUsuarioKaizen->setBl_activo($next ['bl_activo']);

        //para el caso que se hace el join con el perfil.
        if (array_key_exists('ds_perfil', $next)) {
            $perfilFactory = new PerfilFactory();
            $oUsuarioKaizen->setPerfil($perfilFactory->build($next));
        }

        if (array_key_exists('ds_nombre', $next)) {
            $sucursalFactory = new SucursalFactory();
            $oUsuarioKaizen->setSucursal($sucursalFactory->build($next));
        }
        return $oUsuarioKaizen;
    }

}
?>