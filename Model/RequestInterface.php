<?php

namespace Gonetto\FCApiClientBundle\Model;

interface RequestInterface
{

    public function getToken(): string;

    public function setToken(string $token);

    public function getAction(): string;
}
