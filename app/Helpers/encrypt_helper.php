<?php

/**
 * Função para realizar criptgrafia de um dado valor
 */
if (!function_exists('encrypt')) {
    function encrypt(string $value): string
    {
        return bin2hex(service('encrypter')->encrypt($value));
    }
}

/**
 * Função para realizar decriptgrafia de um dado valor
 */
if (!function_exists('decrypt')) {
    function decrypt(string $value): string
    {
        return service('encrypter')->decrypt(hex2bin($value));
    }
}