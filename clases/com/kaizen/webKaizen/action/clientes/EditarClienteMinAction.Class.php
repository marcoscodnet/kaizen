<?php/** * Acci�n para editar un cliente. * * @author Lucrecia * @since 22-04-2010 * */abstract class EditarClienteMinAction extends EditarAction {    /**     * (non-PHPdoc)     * @see clases/com/codnet/action/generic/EditarAction#getEntidad()     */    protected function getEntidad() {        $oCliente = new Cliente();        if (isset($_POST ['cd_cliente']))            $oCliente->setCd_cliente($_POST ['cd_cliente']);        if (isset($_POST ['ds_apynom']))            $oCliente->setDs_apynom(utf8_encode(($_POST ['ds_apynom'])));        if (isset($_POST ['cd_tipodoc']))            $oCliente->setCd_tipodoc($_POST ['cd_tipodoc']);        if (isset($_POST ['nu_doc']))            $oCliente->setNu_doc($_POST ['nu_doc']);        if (isset($_POST ['localidad']))            $oCliente->setCd_localidad($_POST ['localidad']);        if (isset($_POST ['dt_nacimiento']))            $oCliente->setDt_nacimiento($_POST ['dt_nacimiento']);        if (isset($_POST ['cd_estadocivil']))            $oCliente->setCd_estadocivil($_POST ['cd_estadocivil']);        if (isset($_POST ['ds_conyuge']))            $oCliente->setDs_conyuge(utf8_decode($_POST ['ds_conyuge']));        if (isset($_POST ['ds_nacionalidad']))            $oCliente->setDs_nacionalidad($_POST ['ds_nacionalidad']);        if (isset($_POST ['ds_cp']))            $oCliente->setDs_cp($_POST ['ds_cp']);        if (isset($_POST ['ds_teparticular']))            $oCliente->setDs_teparticular($_POST ['ds_teparticular']);        if (isset($_POST ['ds_telaboral']))            $oCliente->setDs_telaboral($_POST ['ds_telaboral']);        if (isset($_POST ['ds_actividad_ocupacion']))            $oCliente->setDs_actividad_ocupacion($_POST ['ds_actividad_ocupacion']);        if (isset($_POST ['ds_lugartrabajo']))            $oCliente->setDs_lugartrabajo($_POST ['ds_lugartrabajo']);        if (isset($_POST ['ds_cuil_cuit']))            $oCliente->setDs_cuil_cuit($_POST ['ds_cuil_cuit']);        if (isset($_POST ['ds_email']))            $oCliente->setDs_email($_POST ['ds_email']);        if (isset($_POST ['cd_condiva']))            $oCliente->setCd_condiva($_POST ['cd_condiva']);        if (isset($_POST ['ds_comollego']))            $oCliente->setDs_comollego($_POST ['ds_comollego']);        if (isset($_POST ['ds_dircalle']))            $oCliente->setDs_dircalle($_POST ['ds_dircalle']);        if (isset($_POST ['ds_dirnro']))            $oCliente->setDs_dirnro($_POST ['ds_dirnro']);        if (isset($_POST ['ds_dirpiso']))            $oCliente->setDs_dirpiso($_POST ['ds_dirpiso']);        if (isset($_POST ['ds_dirdepto']))            $oCliente->setDs_dirdepto($_POST ['ds_dirdepto']);        return $oCliente;    }}