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
     * @param string $emailClass
     * @return object
     */
    public static function mail(string $emailClass)
    {
        $emailClass = str_replace('Mail', '', $emailClass);

        $class =  '\\App\\Mail\\' . ucfirst($emailClass) . 'Mail';

        if (!class_exists($class)) {
            throw new Exception("Class {$class} not exists!");
        }

        return new $class();
    }

    /**
     * Retorna instância de um determinado model
     *
     * @param string $validationClass
     * @return object
     */
    public static function validationForm(string $validationClass)
    {
        $validationClass = str_replace('Validation', '', $validationClass);

        $class = '\\App\\Validations\\' . ucfirst($validationClass) . 'Validation';

        if (!class_exists($class)) {
            throw new Exception("Class {$class} not exists!");
        }

        return new $class();
    }

    /**
     * Retorna instância de um determinado model
     *
     * @param string $repositoryClass
     * @return object
     */
    public static function repository(string $repositoryClass)
    {
        $repositoryClass = str_replace('Repository', '', $repositoryClass);

        $class = '\\App\\Repository\\ORMdefault\\' . ucfirst($repositoryClass) . 'Repository';

        if (!class_exists($class)) {
            throw new Exception("Class {$class} not exists!");
        }

        return new $class();
    }

    /**
     * Retorna instância de um determinado model
     *
     * @param string $modelClass
     * @return object
     */
    public static function model(string $modelClass): object
    {
        $modelClass = str_replace('Model', '', $modelClass);

        $class = '\\App\\Models\\' . ucfirst($modelClass);

        if (!class_exists($class)) {
            throw new Exception("Class {$class} not exists!");
        }

        return new $class();
    }

    /**
     * Retorna instância de uma determinada library
     *
     * @param string $libraryClass
     * @return object
     */
    public static function library(string $libraryClass, mixed $paramContructor = null): object
    {
        $class = '\\App\\Libraries\\' . ucfirst($libraryClass);

        if (!class_exists($class)) {
            throw new Exception("Class {$class} not exists!");
        }

        if(!$paramContructor){
            return new $class();
        }

        return new $class($paramContructor);
    }

    /**
     * Retorna instância de uma determinada library
     *
     * @param string $fileClass
     * @return object
     */
    public static function file(string $fileClass): object
    {
        $class = '\\App\\Libraries\\Files\\' . ucfirst($fileClass);

        if (!class_exists($class)) {
            throw new Exception("Class {$class} not exists!");
        }

        return new $class();
    }

    /**
     * Retorna instância de uma determinada library
     *
     * @param string $class
     * @return object
     */
    public static function core(string $class): object
    {
        $explodedClass = explode(',', $class);
        $core = [
            'FileCollection' => '\\CodeIgniter\\Files\\FileCollection',
            'File' => '\\CodeIgniter\\Files\\File'
        ];

        $coreClass = $core[$explodedClass];

        if (!class_exists($coreClass)) {
            throw new Exception("Class {$coreClass} not exists!");
        }

        return new $coreClass();
    }

    /**
     * Retorna instância de autenticação
     *
     * @param string $auth
     * @return object
     */
    public static function auth(string $authClass): object
    {
        $authClass = str_replace('Authentication', '', $authClass);

        $class = '\\App\\Libraries\\Authentication\\' . ucfirst($authClass) . 'Authentication';

        if (!class_exists($class)) {
            throw new Exception("Class {$class} not exists!");
        }

        return new $class();
    }
}
