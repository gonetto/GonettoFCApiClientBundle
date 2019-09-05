<?php

namespace Gonetto\FCApiClientBundle\Tests\Service\DataClient\GetFile;

Use Exception;
use Gonetto\FCApiClientBundle\Model\Document;
use Gonetto\FCApiClientBundle\Model\FileResponse;
use Gonetto\FCApiClientBundle\Tests\ClientTestCase;

class GetFileTest extends ClientTestCase
{

    /** @var \Gonetto\FCApiClientBundle\Service\DataClient */
    protected $dataClient;

    /**
     * GetFileTest constructor.
     *
     * @param null $name
     * @param array $data
     * @param string $dataName
     *
     * @throws \Exception
     */
    public function __construct($name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);

        $json = file_get_contents(__DIR__.'/ApiFileResponse.json');
        $this->dataClient = $this->mockGuzzleClientInDataClient($json);
    }

    /**
     * @throws \Exception
     */
    public function testGetFile(): void
    {
        // Request file
        $document = (new Document())
            ->setFinanceConsultId('1B5O3V')
            ->setContractId('19DB5Y');
        $fileResponse = $this->dataClient->getFile($document);

        // Check response
        $this->assertInstanceOf(FileResponse::class, $fileResponse);
    }

    /**
     * @dataProvider parametersProvider
     *
     * @param \Gonetto\FCApiClientBundle\Model\Document $document
     *
     * @throws \Exception
     */
    public function testMissingParameters(Document $document): void
    {
        $this->expectException(Exception::class);
        $this->dataClient->getFile($document);
    }

    /**
     * @return array
     */
    public function parametersProvider(): array
    {
        return [
            'FinanceConsultId missing' => [
                (new Document())
                    ->setFinanceConsultId('')
                    ->setContractId('19DB5Y'),
            ],
            'ContractId missing' => [
                (new Document())
                    ->setFinanceConsultId('1B5O3V')
                    ->setContractId(''),
            ],
        ];
    }

    /**
     * Test error message at getFile()
     *
     * @throws \Exception
     */
    public function testInvalidId(): void
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('check the submitted Fiance Consult ID');

        $client = $this->mockGuzzleClientInDataClient('{"result":false}');
        $client->getFile(
            (new Document())
                ->setFinanceConsultId('wrongId')
                ->setContractId('wrongId')
        );
    }
}
