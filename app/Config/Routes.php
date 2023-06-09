<?php

namespace Config;

use App\Controllers\Adm\ProfileController;

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

/**
 * rota raiz
 */
$routes->group('/', function ($routes) {
    $routes->get('', 'Home::index', ['as' => 'home']);
    /**
     * rota authentication
     */
    $routes->group('authentication', ['filter' => 'is_authenticated'], function ($routes) {
        $routes->get('', 'Authentication\EmployeeAuthenticationController::authentication', ['as' => 'authentication']);
        $routes->post('authenticate', 'Authentication\EmployeeAuthenticationController::authenticate', ['as' => 'authenticate']);
    });
});

/**
 * rota adm
 */
$routes->group('adm', ['filter' => 'is_not_authenticated'], function ($routes) {
    /**
     * rota rh
     */
    $routes->group('rh', function ($routes) {
        /**
         * rota employee
         */
        $routes->group('employee', function ($routes) {
            $routes->get('list', 'Adm\Rh\EmployeeController::listSearch', ['as' => 'employee.list-search']);
            $routes->get('adding', 'Adm\Rh\EmployeeController::adding', ['as' => 'employee.adding']);
            $routes->post('add', 'Adm\Rh\EmployeeController::add', ['as' => 'employee.add']);
            $routes->get('show/(:hash)', 'Adm\Rh\EmployeeController::show/$1', ['as' => 'employee.show']);
            $routes->get('disable/(:hash)', 'Adm\Rh\EmployeeController::disable/$1', ['as' => 'employee.disable']);
            $routes->post('confirm-disable/(:hash)', 'Adm\Rh\EmployeeController::confirmDisable/$1', ['as' => 'employee.confirm-disable']);
            $routes->get('reactivate/(:hash)', 'Adm\Rh\EmployeeController::reactivate/$1', ['as' => 'employee.reactivate']);
            $routes->post('confirm-reactivate/(:hash)', 'Adm\Rh\EmployeeController::confirmReactivate/$1', ['as' => 'employee.confirm-reactivate']);
        });
        /**
         * rota client
         */
        $routes->group('client', function ($routes) {
            $routes->get('list', 'Adm\Rh\ClientController::listSearch', ['as' => 'client.list-search']);
            $routes->get('adding', 'Adm\Rh\ClientController::adding', ['as' => 'client.adding']);
            $routes->post('add', 'Adm\Rh\ClientController::add', ['as' => 'client.add']);
            $routes->get('show/(:hash)', 'Adm\Rh\ClientController::show/$1', ['as' => 'client.show']);
            $routes->get('remove/(:hash)', 'Adm\Rh\ClientController::remove/$1', ['as' => 'client.remove']);
            $routes->post('confirm-remove/(:hash)', 'Adm\Rh\ClientController::confirmRemove/$1', ['as' => 'client.confirm-remove']);
        });
    });
    /**
     * rota storage
     */
    $routes->group('storage', function ($routes) {
        $routes->group('', function ($routes) {
            $routes->get('', 'Adm\Storage\StorageController::listSearch', ['as' => 'storage.list-search']);
            $routes->get('show/(:hash)', 'Adm\Storage\StorageController::show/$1', ['as' => 'storage.show']);
            $routes->get('add/(:hash)', 'Adm\Storage\StorageController::add/$1', ['as' => 'storage.add']);
            $routes->post('add-inits/(:hash)', 'Adm\Storage\StorageController::addUnits/$1', ['as' => 'storage.add-units']);
        });
        /**
         * rota type-product
         */
        $routes->group('type-product', function ($routes) {
            $routes->get('list', 'Adm\Storage\TypeProductController::listSearch', ['as' => 'type-product.list-search']);
            $routes->get('adding', 'Adm\Storage\TypeProductController::adding', ['as' => 'type-product.adding']);
            $routes->post('add', 'Adm\Storage\TypeProductController::add', ['as' => 'type-product.add']);
            $routes->get('show/(:hash)', 'Adm\Storage\TypeProductController::show/$1', ['as' => 'type-product.show']);
            $routes->get('remove/(:hash)', 'Adm\Storage\TypeProductController::remove/$1', ['as' => 'type-product.remove']);
            $routes->post('confirm-remove/(:hash)', 'Adm\Storage\TypeProductController::confirmRemove/$1', ['as' => 'type-product.confirm-remove']);
        });
        /**
         * rota product
         */
        $routes->group('product', function ($routes) {
            $routes->get('list', 'Adm\Storage\ProductController::listSearch', ['as' => 'product.list-search']);
            $routes->get('product-image/(:segment)', 'Adm\Storage\ProductController::image/$1', ['as' => 'product.image']);
            $routes->get('adding', 'Adm\Storage\ProductController::adding', ['as' => 'product.adding']);
            $routes->post('add', 'Adm\Storage\ProductController::add', ['as' => 'product.add']);
            $routes->get('show/(:hash)', 'Adm\Storage\ProductController::show/$1', ['as' => 'product.show']);
            $routes->get('change-image/(:hash)', 'Adm\Storage\ProductController::changeImage/$1', ['as' => 'product.change-image']);
            $routes->post('save-image/(:hash)', 'Adm\Storage\ProductController::saveImage/$1', ['as' => 'product.save-image']);
            $routes->get('remove/(:hash)', 'Adm\Storage\ProductController::remove/$1', ['as' => 'product.remove', 'filter' => 'product_is_zero']);
            $routes->post('confirm-remove/(:hash)', 'Adm\Storage\ProductController::confirmRemove/$1', ['as' => 'product.confirm-remove']);
        });
    });
    /**
     * rota order
     */
    $routes->group('order', function ($routes) {
        $routes->get('list', 'Adm\Delivery\OrderController::list', ['as' => 'order.list']);
        $routes->get('details/(:hash)', 'Adm\Delivery\OrderController::details/$1', ['as' => 'order.details']);
        /**
         * rota finish
         */
        $routes->group('finish/(:hash)', ['filter' => 'cart_item_empty'], function ($routes) {
            $routes->get('', 'Adm\Delivery\OrderController::finish/$1', ['as' => 'order.finish']);
            $routes->post('confirm/(:hash)', 'Adm\Delivery\OrderController::finishConfirm/$1', ['as' => 'order.finish-confirm']);
        });
        /**
         * rota cancel
         */
        $routes->group('cancel', function ($routes) {
            $routes->get('(:hash)', 'Adm\Delivery\OrderController::cancel/$1', ['as' => 'order.cancel']);
            $routes->post('confirm/(:hash)', 'Adm\Delivery\OrderController::cancelConfirm/$1', ['as' => 'order.cancel-confirm']);
        });
        /**
         * rota client
         */
        $routes->group('client', function ($routes) {
            $routes->get('list', 'Adm\Delivery\OrderController::listClient', ['as' => 'order.list-client']);
            $routes->get('select/(:hash)', 'Adm\Delivery\OrderController::selectClient/$1', ['as' => 'order.select-client']);
        });
        /**
         * rota orderCart
         */
        $routes->group('order-cart', function ($routes) {
            $routes->get('show/(:hash)', 'Adm\Delivery\OrderCartController::show/$1', ['as' => 'order.order-cart-show']);
            $routes->get('adding-item/(:hash)', 'Adm\Delivery\OrderCartController::addingItem/$1', ['as' => 'order.order-cart.adding-item']);
            $routes->get('add-item-quantity/(:hash)', 'Adm\Delivery\OrderCartController::addItemQuantity/$1', ['as' => 'order.order-cart.add-item-quantity']);
            $routes->post('add-item/(:hash)', 'Adm\Delivery\OrderCartController::addItem/$1', ['as' => 'order.order-cart.add-item']);
            $routes->get('remove-item/(:hash)', 'Adm\Delivery\OrderCartController::removeItem/$1', ['as' => 'order.order-cart.remove-item']);
        });
    });
    /**
     * rota profile
     */
    $routes->group('profile', function ($routes) {
        $routes->get('', 'Adm\ProfileController::myProfile', ['as' => 'profile.my-profile']);
        $routes->get('edit', 'Adm\ProfileController::edit', ['as' => 'profile.edit']);
        $routes->post('save-edit', 'Adm\ProfileController::saveEdit', ['as' => 'profile.save-edit']);
        $routes->get('password', 'Adm\ProfileController::password', ['as' => 'profile.password']);
        $routes->post('save-password', 'Adm\ProfileController::savePassword', ['as' => 'profile.save-password']);
        $routes->get('logout', 'Adm\ProfileController::logout', ['as' => 'profile.logout']);
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
