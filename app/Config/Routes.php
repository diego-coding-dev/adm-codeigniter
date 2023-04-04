<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
// $routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Home::index', ['as' => 'home']);

/**
 * rota adm
 */
$routes->group('adm', function ($routes) {
    /**
     * rota rh
     */
    $routes->group('rh', function ($routes) {
        /**
         * rota employee
         */
        $routes->group('employee', function ($routes) {
            $routes->get('list-search', 'Adm\Rh\EmployeeController::listSearch', ['as' => 'employee.list-search']);
            $routes->get('adding', 'Adm\Rh\EmployeeController::adding', ['as' => 'employee.adding']);
            $routes->post('add', 'Adm\Rh\EmployeeController::add', ['as' => 'employee.add']);
            $routes->get('show/(:hash)', 'Adm\Rh\EmployeeController::show/$1', ['as' => 'employee.show']);
            $routes->get('disable/(:hash)', 'Adm\Rh\EmployeeController::disable/$1', ['as' => 'employee.disable']);
            $routes->post('confirm-disable', 'Adm\Rh\EmployeeController::confirmDisable', ['as' => 'employee.confirm-disable']);
            $routes->get('reactivate/(:hash)', 'Adm\Rh\EmployeeController::reactivate/$1', ['as' => 'employee.reactivate']);
            $routes->post('confirm-reactivate', 'Adm\Rh\EmployeeController::confirmReactivate', ['as' => 'employee.confirm-reactivate']);
        });
    });
});

/**
 * Rota activation
 */
$routes->group('activation', function ($routes) {
    /**
     * Rota employee
     */
    $routes->group('employee', function ($routes) {
        $routes->get('check/(:hash)', 'Activation\EmployeeActivationController::check/$1', ['as' => 'activation.employee-check']);
        $routes->post('set-password', 'Activation\EmployeeActivationController::setPassword', ['as' => 'activation.employee-set-password']);
    });
});

$routes->get('error', function () {
    return view('errors/html/error_404');
});
/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
