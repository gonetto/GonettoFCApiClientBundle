<?php

namespace Gonetto\FCApiClientBundle\Tests\Modal\CustomerUpdateRequest;

use Faker\Factory;
use Gonetto\FCApiClientBundle\Model\CustomerUpdateRequest;
use Gonetto\FCApiClientBundle\Service\JmsSerializerFactory;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * Class SerializeTest
 *
 * @package Gonetto\FCApiClientBundle\Tests\Modal\CustomerUpdateRequest
 */
class SerializeTest extends KernelTestCase
{

    /** @var \Faker\Generator */
    protected $faker;

    /** @var \JMS\Serializer\Serializer */
    protected $serializer;

    public function __construct($name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);

        $this->faker = Factory::create('de_DE');
    }

    /** {@inheritDoc} */
    protected function setUp()
    {
        $this->serializer = (new JmsSerializerFactory())->createSerializer();
    }

    public function testUpdateAll(): void
    {
        // Serialize object
        $request = (new CustomerUpdateRequest())
            ->setInformCompanyAboutAddress(true)
            ->setInformCompanyAboutBank(true)
            ->setToken('8029fdd175474c61909ca5f0803965bb464ff546')
            ->setFinanceConsultId('19P1CF')
            ->setEmail('anna.musterfrau@domain.tld')
            ->setFirstName('Anna')
            ->setLastName('Musterfrau')
            ->setCompany('Beispielfirma')
            ->setStreet('Beispielstr. 2')
            ->setZipCode(54321)
            ->setCity('Beispielstadt')
            ->setIban('DE02500105170137075030');
        $jsonRequest = $this->serializer->serialize($request, 'json');

        // Check result
        $this->assertJsonStringEqualsJsonFile(__DIR__.'/CustomerUpdateRequest.json', $jsonRequest);
    }

    /**
     * @dataProvider parametersProvider
     *
     * @param string $setter
     * @param string $serializedName
     * @param string $value
     */
    public function testUpdatePartial(string $setter, string $serializedName, string $value): void
    {
        // Example object
        $request = (new CustomerUpdateRequest())
            ->setToken('802...')
            ->setFinanceConsultId('19P1CF')
            ->$setter(
                $value
            );
        $jsonRequest = $this->serializer->serialize($request, 'json');

        // Expected JSON result
        $expectedArray = [
            'oid' => '19P1CF',
            $serializedName => $value,
            'token' => '802...',
            'action' => 'setKunde',
            'gesellschaftInformierenAdresse' => false,
            'gesellschaftInformierenBank' => false,
        ];
        // Reorder expected array
        if ($serializedName === 'gesellschaftInformierenAdresse') {
            unset($expectedArray['gesellschaftInformierenAdresse'], $expectedArray['gesellschaftInformierenBank']);
            $expectedArray['gesellschaftInformierenAdresse'] = (bool)$value;
            $expectedArray['gesellschaftInformierenBank'] = false;
        }
        if ($serializedName === 'gesellschaftInformierenBank') {
            unset($expectedArray['gesellschaftInformierenBank'], $expectedArray['gesellschaftInformierenBank']);
            $expectedArray['gesellschaftInformierenBank'] = (bool)$value;
        }

        // Check JSON result
        $this->assertJsonStringEqualsJsonString(json_encode($expectedArray), $jsonRequest);
    }

    /**
     * @return array
     */
    public function parametersProvider(): array
    {
        return [
            'email' => ['setEmail', 'email', 'anna@domain.tld'],
            'first name' => ['setFirstName', 'vorname', 'Anna'],
            'last name' => ['setLastName', 'nachname', 'Musterfrau'],
            'company' => ['setCompany', 'firma', 'Beispielfirma'],
            'street' => ['setStreet', 'strasse', 'Beispielstr. 2'],
            'zip code' => ['setZipCode', 'plz', 54321],
            'city' => ['setCity', 'ort', 'Beispielstadt'],
            'iban' => ['setIban', 'iban', 'DE02500105170137075030'],
            'ges. informieren adresse' => ['setInformCompanyAboutAddress', 'gesellschaftInformierenAdresse', true],
            'ges. informieren bank' => ['setInformCompanyAboutBank', 'gesellschaftInformierenBank', true],
        ];
    }
}
