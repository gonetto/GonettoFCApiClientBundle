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
     * @test
     * @dataProvider factoriesProvider
     *
     * @param string $factory
     */
    public function testInterface(string $factory)
    {
        $requestFactory = new $factory('dummy');
        $request = $requestFactory->createResponse();
        $this->assertInstanceOf(RequestInterface::class, $request);
    }

    /**
     * @test
     * @dataProvider factoriesProvider
     *
     * @param string $factory
     */
    public function testSetToken(string $factory)
    {
        $requestFactory = new $factory('dummy');
        $request = $requestFactory->createResponse();
        $this->assertSame('dummy', $request->getToken());
    }

    /**
     * @test
     * @dataProvider factoriesProvider
     *
     * @param string $factory
     */
    public function testMissingToken(string $factory)
    {
        $this->expectExceptionMessage('API token can not not be empty');
        $requestFactory = new $factory();
        $requestFactory->createResponse();
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
