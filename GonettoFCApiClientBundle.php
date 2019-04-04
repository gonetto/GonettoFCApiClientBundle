<?php

namespace Gonetto\FCApiClientBundle;

use Gonetto\FCApiClientBundle\DependencyInjection\GonettoFCApiClientExtension;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class GonettoFCApiClientBundle extends Bundle
{
    public function getContainerExtension()
    {
        return new GonettoFCApiClientExtension();
    }
}
