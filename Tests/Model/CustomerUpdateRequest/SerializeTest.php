<?php

namespace Gonetto\FCApiClientBundle\Tests\Modal\CustomerUpdateRequest;

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

    /** @var \JMS\Serializer\Serializer */
    protected $serializer;

    /** {@inheritDoc} */
    protected function setUp()
    {
        $this->serializer = (new JmsSerializerFactory())->createSerializer();
    }

    /**
     * @test
     */
    public function testUpdateAll()
    {
        // Serialize object
        $request = (new CustomerUpdateRequest())
            // TODO:GN:MS: Test without token to checkup if FC check this value!
            ->setToken('8029fdd175474c61909ca5f0803965bb464ff546')
            ->setFianceConsultId('19P1CF')
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
     * @test
     * @dataProvider parametersProvider
     *
     * @param string $setter
     * @param string $serializedName
     * @param string $value
     */
    public function testUpdatePartial(string $setter, string $serializedName, string $value): void
    {
        $request = (new CustomerUpdateRequest())
            ->setToken('802...')
            ->setFianceConsultId('19P1CF')// TODO:GN:MS: set required and test FC if/which error will show if empty
            ->$setter(
                $value
            );
        $jsonRequest = $this->serializer->serialize($request, 'json');

        // Check result
        $this->assertJsonStringEqualsJsonString(
            '{"oid": "19P1CF","'.$serializedName.'": "'.$value.'","token": "802...","action": "setKunde"}',
            $jsonRequest
        );
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
        ];
    }
}
