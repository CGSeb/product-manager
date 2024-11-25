<?
namespace App\Tests\Application\Controller;

use App\Entity\Catalog;
use Doctrine\ORM\EntityManagerInterface;

class CatalogControllerTest extends AuthTest
{
    /**
     * @dataProvider provideCreateCatalog
     */
    public function testCatalogCreation(
        array $payload,
        int $responseCode=200,
        array $violations=[], 
        string $detail='',
    ): void {
        $client = $this->createAuthenticatedClient();
        $client->jsonRequest(
            method:'POST', 
            uri: '/api/catalog',
            parameters: $payload,
        );

        $response = $client->getResponse();
        $jsonResponse = json_decode($response->getContent(), true);

        $this->assertEquals($responseCode, $response->getStatusCode());

        if ($responseCode !== 200) {
            if (!empty($violations)) {
                $this->assertViolations($jsonResponse, $violations);
                return;
            }
            
            $this->assertEquals($detail, $jsonResponse['detail']);

            return;
        }

        /** @var Catalog $createdCatalog */
        $createdCatalog = $this->getContainer()->get(EntityManagerInterface::class)->getRepository(Catalog::class)->findOneBy(['name' => $payload['name']]);

        self::assertCount(count($payload['products']), $createdCatalog->getProducts());
        self::assertEquals($payload['name'], $createdCatalog->getName());
    }

    public static function provideCreateCatalog(): iterable
    {
        yield 'Success: creation' => [
            'payload' => [
                'name' => 'My Catalog',
                'products' => [1, 2, 3],
            ],
        ];

        yield 'Fail: product not found' => [
            'payload' => [
                'name' => 'My Catalog',
                'products' => [456, 2, 3],
            ],
            'responseCode' => 400,
            'detail' => "Product with id '456' not found",
        ];

        yield 'Fail: empty name' => [
            'payload' => [
                'name' => '',
                'products' => [1, 2, 3],
            ],
            'responseCode' => 422,
            'violations' => [
                ['propertyPath' => 'name', 'title' => 'This value should not be blank.'],
            ],
        ];

        yield 'Fail: not products' => [
            'payload' => [
                'name' => 'My Catalog',
                'products' => [],
            ],
            'responseCode' => 422,
            'violations' => [
                ['propertyPath' => 'products', 'title' => 'This value should not be empty.'],
            ],
        ];

        yield 'Fail: no name' => [
            'payload' => [
                'products' => [1, 2, 3],
            ],
            'responseCode' => 422,
            'violations' => [
                ['propertyPath' => 'name', 'title' => 'This value should be of type string.'],
            ],
        ];

        yield 'Fail: no products' => [
            'payload' => [
                'name' => 'My catalog',
            ],
            'responseCode' => 422,
            'violations' => [
                ['propertyPath' => 'products', 'title' => 'This value should be of type array.'],
            ],
        ];
    }
    
    public function tearDown(): void
    {
        parent::tearDown();

        restore_exception_handler();
    }

    private function assertViolations(array $jsonResponse, array $violations): void
    {
        $index=0;
        foreach ($violations as $violation) {
            $this->assertEquals($violation['propertyPath'], $jsonResponse['violations'][$index]['propertyPath']);
            $this->assertEquals($violation['title'], $jsonResponse['violations'][$index]['title']);
            $index ++;
        }
    }
}