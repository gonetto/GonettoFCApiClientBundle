<?php

namespace Gonetto\FCApiClientBundle\Tests\Modal\CustomerUpdateRequest;

use Gonetto\FCApiClientBundle\Model\Customer;
use Gonetto\FCApiClientBundle\Model\CustomerUpdateRequest;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * Class SerializeTest
 *
 * @package Gonetto\FCApiClientBundle\Tests\Modal\CustomerUpdateRequest
 */
class CloneTest extends KernelTestCase
{

    /**
     * @test
     * @dataProvider parametersProvider
     *
     * @param string $parameter
     * @param string $value
     */
    public function testCloneObject(string $parameter, string $value): void
    {
        // Source
        $setter = 'set'.$parameter;
        $customer = (new Customer())->$setter($value);

        // Target
        $customerUpdateRequest = new CustomerUpdateRequest();

        // Clone
        $customerUpdateRequest->clone($customer);

        // Check result
        $getter = 'get'.$parameter;
        $this->assertSame($customer->$getter(), $customerUpdateRequest->$getter());
    }

    /**
     * @return array
     */
    public function parametersProvider(): array
    {
        return [
            'fiance consult id' => ['FianceConsultId', '19P1CF'],
            'email' => ['Email', 'anna@domain.tld'],
            //'gender' => ['Gender', 'female'],
            'first name' => ['FirstName', 'Anna'],
            'last name' => ['LastName', 'Musterfrau'],
            //'birthday' => ['Birthday', '1998-01-01'],
            'company' => ['Company', 'Beispielfirma'],
            'street' => ['Street', 'Beispielstr. 2'],
            'zip code' => ['ZipCode', 54321],
            'city' => ['City', 'Beispielstadt'],
            //'fax' => ['Fax', ''],
            //'phone' => ['Phone', ''],
            //'depositor' => ['Depositor', ''],
            'iban' => ['Iban', 'DE02500105170137075030'],
            //'contracts' => ['Contracts', []], // deprecated
        ];
    }
}
