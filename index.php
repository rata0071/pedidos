<?php /*

          .___.    .   ,    ,      .__           
          [__ |* _ |_ -+-  -+- _   [__) _.._.* __
          |   ||(_][ ) |    | (_)  |   (_][  |_) 
                ._|                              

          Flight - Mike Cao // http://flightphp.com MIT
    Paris&Idiorm - Jamie Matthews // http://j4mie.github.com/idiormandparis BSD
 Flight to Paris - Aza // http://esfriki.com GPLv3

*/
define ( 'APP_PATH', realpath ( dirname ( __FILE__ ) . '/app' ) );
define ( 'LIB_PATH', realpath ( dirname ( __FILE__ ) . '/lib' ) );

define ( 'FLIGHT_PATH', LIB_PATH . '/flight' );
define ( 'PARIS_PATH', LIB_PATH . '/paris' );
define ( 'MAILER_PATH', LIB_PATH . '/phpmailer' );

require FLIGHT_PATH.'/Flight.php';
require PARIS_PATH.'/paris.php';

set_include_path(get_include_path() . PATH_SEPARATOR . FLIGHT_PATH);
set_include_path(get_include_path() . PATH_SEPARATOR . LIB_PATH);
set_include_path(get_include_path() . PATH_SEPARATOR . APP_PATH);
set_include_path(get_include_path() . PATH_SEPARATOR . APP_PATH . '/model');

Flight::set('flight.lib.path', APP_PATH);
Flight::set('flight.views.path', APP_PATH.'/view');


/****  CONFIGURE YOUR DOMAIN AND DB HERE  ****/ 
define ( 'DOMAIN', 'verde.esfriki.com' );
define ( 'SITE', 'Viveverde' );

ORM::configure('mysql:host=localhost;dbname=pedidos');
ORM::configure('username', 'root');
ORM::configure('password', '');

date_default_timezone_set('America/Argentina/Buenos_Aires');
/****  AND DOWN THE RABBIT HOLE  ****/


require APP_PATH.'/model/auth.php';
$auth = new auth;

Flight::route('GET /',array('controller_producto','home'));

Flight::route('GET /pedido',array('controller_pedido','nuevo'));
Flight::route('POST /pedido',array('controller_pedido','encargar'));

Flight::route('GET /pedido/@id:[0-9]+/confirmar',array('controller_pedido','confirmar'));
Flight::route('GET /pedido/@id:[0-9]+/cancel',array('controller_pedido','cancelar'));

Flight::route('GET /user/datos',array('controller_user','datos'));
Flight::route('POST /user/update',array('controller_user','update'));

// Paginas estaticas

Flight::route('GET /ecobolsa',array('controller_layout','ecobolsa'));
Flight::route('GET /como-comprar',array('controller_layout','comocomprar'));
Flight::route('GET /quienes-somos',array('controller_layout','quienessomos'));
Flight::route('GET /contacto',array('controller_layout','contacto'));

// Metodos de autenticacion

Flight::route('POST /auth/login/?$',array('controller_auth','login'));
Flight::route('GET /auth/logout/?$',array('controller_auth','logout'));

Flight::route('GET /auth/password/?$',array('controller_auth','changeForm'));
Flight::route('POST /auth/password/?$',array('controller_auth','change'));

Flight::route('POST /auth/newpassword/?$', array('controller_auth','newpassword'));

Flight::route('GET /auth/forgotpassword/?$', array('controller_auth','forgotpassword'));
Flight::route('POST /auth/forgotpassword/?$', array('controller_auth','sendpassword'));

Flight::route('GET /auth/@id:[0-9]+/setpassword/@c:[a-f0-9]+/?$', array('controller_auth','setpassword'));

// Metodos de administracion
Flight::route('GET /admin/pedidos', array('controller_admin','pedidos'));
Flight::route('POST /admin/actualizar', array('controller_admin','actualizar'));

Flight::route('GET /user/@id:[0-9]+/getdata', array('controller_user','getData'));
Flight::start();
