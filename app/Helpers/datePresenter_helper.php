<?php

/**
 * Função para formatar data
 */
if (!function_exists('format')) {
    function format(string $value): string
    {
        return date('d/m/Y', strtotime($value));
    }
}
