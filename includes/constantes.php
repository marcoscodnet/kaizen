<?php

define('LOG_SQL', true);

//layout que utilizan las acciones segurizadas comunes (no definidas en Kaizen).
define('DEFAULT_SECURE_LAYOUT', 'LayoutMenuKaizen');

//layout que utilizan las acciones que muestran un panel de control.
define('DEFAULT_PANEL_LAYOUT', 'LayoutPanelKaizen');

//layout que utilizan las acciones comunes (no definidas en Kaizen).
define('DEFAULT_LAYOUT', 'LayoutKaizen');

//layout para el login.
define('DEFAULT_LOGIN_LAYOUT', 'LayoutLoginKaizen');

//layout para el login.
define('DEFAULT_POPUP_LAYOUT', 'LayoutPopupKaizen');

//identificadores para los estados civiles.
define('CASADO', 2);
define('CONCUBINO', 5);

define('REMITO_CUIT', 'cuit de Kaizen');
define('REMITO_CUIT', 'cuit de Kaizen');
define('REMITO_AGENTE_RETENCION', 'Agente de retenci�n I.V.A. (S/R.G. 3125/95)');
define('REMITO_INICIO_ACTIVIDADES', '09/09/1991');
define('REMITO_CONDICION_IVA', 'I.V.A. RESPONSABLE INSCRIPTO');

define('NOMBRE_EMPRESA_PDF', 'Kaizen');

define('DEFAULT_MENU', 'MenuKaizen');

define('NOMBRE_APLICACION', 'Kaizen');

define('REMITO_COPIA_ORIGINAL', 1);
define('REMITO_COPIA_DUPLICADO', 2);
define('REMITO_COPIA_TRIPLICADO', 3);



//identificadores para los formas de pago.
define('CD_CONTADO', 1);
define('CD_CREDITO', 2);

//identificadores para los destinos de venta pieza.
define('CD_SALON', 1);
define('CD_SUCURSAL', 2);
define('CD_TALLER', 3);

define('CD_PERFIL_VENDEDOR', 3);

define('CD_MARCA_HONDA', 13);

define('MODIFICAR_PAGO_ACCION', "Modificar Pago");
define('AUTORIZAR_UNIDAD_ACCION', "Autorizar Unidad");
//template para los listados.
define('DEFAULT_LISTAR_TEMPLATE', APP_PATH . CLASS_PATH . 'codnet/view/collabtive_listar_template.html');
define('DEFAULT_BUSCAR_TEMPLATE', APP_PATH . CLASS_PATH . 'codnet/view/collabtive_buscar_template.html');

date_default_timezone_set('America/Argentina/Buenos_Aires');
ini_set("memory_limit","900M");
ini_set('display_errors', '1');
include_once 'error_codigos.php';
?>
