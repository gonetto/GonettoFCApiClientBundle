<?php

namespace Gonetto\FCApiClientBundle\Tests\Modal\CustomerUpdateRequest;

use Faker\Factory;
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

    /** @var \Faker\Generator */
    protected $faker;

    /** {@inheritDoc} */
    public function __construct($name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);

        $this->faker = Factory::create('de_DE');
    }

    /**
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
            'finance consult id' => ['FianceConsultId', strtoupper($this->faker->bothify('******'))],
            'email' => ['Email', $this->faker->email],
            //'gender' => ['Gender', 'female'],
            'first name ' => ['FirstName', $this->faker->firstName('female')],
            'last name' => ['LastName', $this->faker->lastName],
            //'birthday' => ['Birthday', $this->faker->dateTimeBetween($startDate = '-60 years', $endDate = '-18 years')->format('Y-m-d')],
            'company' => ['Company', $this->faker->company],
            'street' => ['Street', $this->faker->streetAddress],
            'zip code' => ['ZipCode', $this->faker->postcode],
            'city' => ['City', $this->faker->city],
            //'fax' => ['Fax', $this->faker->phoneNumber],
            //'phone' => ['Phone', $this->faker->phoneNumber],
            //'depositor' => ['Depositor', $this->faker->name],
            'iban' => ['Iban', $this->faker->iban('de')],
            //'contracts' => ['Contracts', []], // deprecated
        ];
    }
}
