<?php

namespace Gonetto\FCApiClientBundle\Model;

interface EntityInterface
{

    public function getFinanceConsultId(): string;

    public function setFinanceConsultId(string $financeConsultId);
}
