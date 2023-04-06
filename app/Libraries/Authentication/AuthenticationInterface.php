<?php

namespace App\Libraries\Authentication;

interface AuthenticationInterface
{
    public function authenticate(array $credentials);
}
