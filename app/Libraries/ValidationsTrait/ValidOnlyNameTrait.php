<?php

namespace App\Libraries\ValidationsTrait;

/**
 * Trait para guardar regras de validação para múltiplos propósitos
 */
trait ValidOnlyNameTrait
{
    /**
     * Retorna validação apenas para o campo NAME
     *
     * @return array
     */
    private function nameRules(): array
    {
        return [
            'name' => [
                'rules'  => 'permit_empty|string|min_length[3]|max_length[20]',
                'errors' => [
                    'string' => 'Este campo não atende aos requisitos mínimos!',
                    'min_length' => 'Este campo não atende aos requisitos mínimos!',
                    'max_length' => 'Este campo não atende aos requisitos mínimos!'
                ],
            ],
        ];
    }
}
