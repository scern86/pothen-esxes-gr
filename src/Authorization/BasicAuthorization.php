<?php

namespace PothenEsxes\Authorization;

use PothenEsxes\Authorization\Authorization;

class BasicAuthorization implements Authorization {
    public function __construct(protected string $login,protected string $password)
    {
    }

    public function createAuthorizationHeader(): string
    {
        $auth = base64_encode("{$this->login}:{$this->password}");
        return "Authorization: Basic {$auth}";
    }

    public function isValidAuthorization(string $authString): bool
    {
        $decryptString = base64_decode($authString);
        if($decryptString){
            list($login,$password) = explode(':',$decryptString);
            if(!empty($login) && !empty($password)){
                if($this->login===$login && $this->password===$password) return true;
            }
        }
        return false;
    }
}