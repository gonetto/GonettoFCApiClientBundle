<?php

namespace Gonetto\FCApiClientBundle\Tests\Service;

use Gonetto\FCApiClientBundle\Model\RequestInterface;
use Gonetto\FCApiClientBundle\Service\CustomerUpdateRequestFactory;
use Gonetto\FCApiClientBundle\Service\DataRequestFactory;
use Gonetto\FCApiClientBundle\Service\FileRequestFactory;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * Class RequestFactoriesTest
 *
 * @package Gonetto\FCApiClientBundle\Tests\Service
 */
class RequestFactoriesTest extends KernelTestCase
{

    /**
     * @dataProvider factoriesProvider
     *
     * @param string $factory
     */
    public function testInterface(string $factory): void
    {
        /** @var \Gonetto\FCApiClientBundle\Service\RequestFactoryInterface $requestFactory */
        $requestFactory = new $factory('dummy');
        $request = $requestFactory->createRequest();
        $this->assertInstanceOf(RequestInterface::class, $request);
    }

    /**
     * @dataProvider factoriesProvider
     *
     * @param string $factory
     */
    public function testSetToken(string $factory): void
    {
        /** @var \Gonetto\FCApiClientBundle\Service\RequestFactoryInterface $requestFactory */
        $requestFactory = new $factory('dummy');
        /** @var \Gonetto\FCApiClientBundle\Model\RequestInterface $request */
        $request = $requestFactory->createRequest();
        $this->assertSame('dummy', $request->getToken());
    }

    /**
     * @dataProvider factoriesProvider
     *
     * @param string $factory
     */
    public function testMissingToken(string $factory): void
    {
        $this->expectExceptionMessage('API token can not be empty');
        $requestFactory = new $factory();
        /** @var \Gonetto\FCApiClientBundle\Service\RequestFactoryInterface $requestFactory */
        $requestFactory->createRequest();
    }

    /**
     * @return array
     */
    public function factoriesProvider(): array
    {
        return [
            'CustomerUpdateRequestFactory' => [CustomerUpdateRequestFactory::class],
            'DataRequestFactory' => [DataRequestFactory::class],
            'FileRequestFactory' => [FileRequestFactory::class],
        ];
    }
}
