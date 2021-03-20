<?php

/**
 * Representa el layout para un popup:
 * 
 * sin header ni footer.
 *  
 * @author Lucrecia
 * @since 07-04-2010
 */
class LayoutPopupKaizen extends LayoutPopup {

    protected function parseMetaTags($xtpl) {
        $xtpl->assign('http_equiv', 'X-UA-Compatible');
        $xtpl->assign('meta_content', 'IE=7');
        $xtpl->parse('main.meta_tag');

        $xtpl->assign('http-equiv', 'Content-Type');
        $xtpl->assign('meta_content', 'text/html; charset=ISO-8859-1');
        $xtpl->parse('main.meta_tag');
    }

    protected function parseEstilos($xtpl) {
        /*$xtpl->assign('css', WEB_PATH . "css/estilos.css");
        $xtpl->parse('main.estilo');

        $xtpl->assign('css', WEB_PATH . "css/estilo_popup.css");
        $xtpl->parse('main.estilo');

        $xtpl->assign('css', WEB_PATH . "css/sexyalertbox.css");
        $xtpl->parse('main.estilo');*/
    }

    protected function parseScripts($xtpl) {
        /*$xtpl->assign('js', WEB_PATH . "js/mootools.js");
        $xtpl->parse('main.script');

        $xtpl->assign('js', WEB_PATH . "js/sexyalertbox.v1.js");
        $xtpl->parse('main.script');

        $xtpl->assign('js', WEB_PATH . "js/funciones.js");
        $xtpl->parse('main.script');*/
    }

    public function setMenu($html) {
        return " ";
    }

    public function showLayout() {
        return $this->show();
    }

}
