<?php

namespace PothenEsxes\Messages;

interface Messages{
    public function getMessageByCode(int $code, array $replaces): string;
}