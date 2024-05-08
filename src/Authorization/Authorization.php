<?php

namespace PothenEsxes\Authorization;

interface Authorization{
    public function isValidAuthorization(string $authString): bool;
    public function createAuthorizationHeader(): string;
}