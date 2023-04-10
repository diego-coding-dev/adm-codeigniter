<?php

namespace App\Validations;

class ProductValidation extends BaseValidation
{
    private array $rules = [
        'type_product_id' => [
            'rules' => 'required|string|min_length[1]|max_length[3]',
            'errors' => [
                'required' => '* Este campo é obrigatório!',
                'integer' => '* Este campo não atende aos requisitos mínimos!'
            ]
        ],
        'description' => [
            'rules' => 'required|string|min_length[4]|max_length[150]',
            'errors' => [
                'required' => '* Este campo é obrigatório!',
                'string' => '* Este campo não atende aos requisitos mínimos!',
                'min_length' => '* Este campo não atende aos requisitos mínimos!',
                'max_length' => '* Este campo não atende aos requisitos mínimos!'
            ]
        ],
        'image' => [
            'rules' => [
                'uploaded[image]',
                'is_image[image]',
                'mime_in[image,image/jpg,image/jpeg,image/gif,image/png,image/webp]',
                'max_size[image,100]',
                'max_dims[image,1024,768]',
            ],
            'errors' => [
                'uploaded' => '* Nenhum arquivo carregado',
                'is_image' => '* Arquivo não é uma imagem',
                'mime_in' => '* Este arquivo não atende aos requisitos mínimos!',
                'max_size' => '* Este arquivo não atende aos requisitos mínimos!',
                'max_dims' => '* Este arquivo não atende aos requisitos mínimos!'
            ]
        ]
    ];

    public function __construct()
    {
        parent::__construct();
    }

    public function run(array $data)
    {
        return parent::validate($this->rules, $data);
    }

    public function imagesValidationRules()
    {
        return [
            'image' => $this->rules['image']
        ];
    }

    public function fieldsValidationRules()
    {
        unset($this->rules['image']);

        return $this;
    }

    public function forSearchProduct()
    {
        unset($this->rules['type_product_id']);
        unset($this->rules['image']);

        $this->rules['description']['rules'] = str_replace('required|', 'permit_empty|', $this->rules['description']['rules']);

        return $this;
    }

    public function rules()
    {
        return $this->rules;
    }
}
