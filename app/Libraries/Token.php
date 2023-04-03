<?php

namespace App\Libraries;

/**
 * Class reponsável por gerar hashes
 * 
 * @method void __construct(string $token = null)
 * @method string getToken()
 * @method string getHash()
 */
class Token
{
    /**
     * Token
     *
     * @var string
     */
    private string $token;

    public function __construct(string $token = null)
    {
        if (!$token) {
            $this->token = bin2hex(random_bytes(16));
        } else {
            $this->token = $token;
        }
    }

    /**
     * Função responsável por devolver um token
     *
     * @return string
     */
    public function getToken(): string
    {
        return $this->token;
    }

    /**
     * Função responsável por devolver um hash
     *
     * @return string
     */
    public function getTokenHash(): string
    {
        return hash_hmac('sha256', $this->token, env('ACTIVATION_KEY'));
    }
}
