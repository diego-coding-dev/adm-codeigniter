<?php

namespace Config;

use CodeIgniter\Config\BaseService;
use Exception;

/**
 * Services Configuration file.
 *
 * Services are simply other classes/libraries that the system uses
 * to do its job. This is used by CodeIgniter to allow the core of the
 * framework to be swapped out easily without affecting the usage within
 * the rest of your application.
 *
 * This file holds any application-specific services, or service overrides
 * that you might need. An example has been included with the general
 * method format you should use for your service methods. For more examples,
 * see the core Services file at system/Config/Services.php.
 */
class Services extends BaseService
{
    /*
     * public static function example($getShared = true)
     * {
     *     if ($getShared) {
     *         return static::getSharedInstance('example');
     *     }
     *
     *     return new \CodeIgniter\Example();
     * }
     */

    /**
     * Retorna instância de um determinado model
     *
     * @param string $model
     * @return object
     */
    public static function model(string $model): object
    {
        $modelClass = '\\App\\Models\\' . $model;

        if (!class_exists($modelClass)) {
            throw new Exception("Class {$modelClass} not exists!");
        }

        return new $modelClass();
    }

    /**
     * Retorna instância de uma determinada library
     *
     * @param string $library
     * @return object
     */
    public static function library(string $library): object
    {
        $libraryClass = '\\App\\Libraries\\' . $library;

        if (!class_exists($libraryClass)) {
            throw new Exception("Class {$libraryClass} not exists!");
        }

        return new $libraryClass();
    }

    /**
     * Retorna instância de autenticação
     *
     * @param string $auth
     * @return object
     */
    public static function auth(string $auth): object
    {
        $authClass = '\\App\\Libraries\\Authentication\\' . $auth;

        if (!class_exists($authClass)) {
            throw new Exception("Class {$authClass} not exists!");
        }

        return new $authClass(
            new \App\Models\Employee()
        );
    }
}
