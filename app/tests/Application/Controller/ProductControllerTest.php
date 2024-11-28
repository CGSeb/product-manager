<?
namespace App\Tests\Application\Controller;

use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;

class ProductControllerTest extends AuthTest
{
    /**
     * @dataProvider provideCreateData
     */
    public function testProductCreation(
        array $payload,
        int $responseCode=200,
        array $violations=[], 
    ): void {
        $client = $this->createAuthenticatedClient();
        $client->jsonRequest(
            method:'POST', 
            uri: '/api/product',
            parameters: $payload,
        );

        $response = $client->getResponse();
        $jsonResponse = json_decode($response->getContent(), true);

        $this->assertEquals($responseCode, $response->getStatusCode());

        if ($responseCode !== 200) {
            $this->assertViolations($jsonResponse, $violations);

            return;
        }

        $createdProduct = $this->getContainer()->get(EntityManagerInterface::class)->getRepository(Product::class)->findOneBy(['name' => $payload['name']]);

        self::assertEquals($payload['price'], $createdProduct->getPrice());
        self::assertEquals($payload['name'], $createdProduct->getName());
    }

    public static function provideCreateData(): iterable
    {
        yield 'Success: creation' => [
            'payload' => [
                'name' => 'My product',
                'price' => 12.52,
            ],
        ];

        yield 'Fail: empty name' => [
            'payload' => [
                'name' => '',
                'price' => 12.52,
            ],
            'responseCode' => 422,
            'violations' => [
                ['propertyPath' => 'name', 'title' => 'This value should not be blank.'],
            ],
        ];

        yield 'Fail: price equal 0' => [
            'payload' => [

                'name' => 'My product',
                'price' => 0,
            ],
            'responseCode' => 422,
            'violations' => [
                ['propertyPath' => 'price', 'title' => 'This value should be greater than 0.'],
            ],
        ];

        yield 'Fail: no name' => [
            'payload' => [
                'price' => 0,
            ],
            'responseCode' => 422,
            'violations' => [
                ['propertyPath' => 'name', 'title' => 'This value should not be blank.'],
            ],
        ];

        yield 'Fail: no price' => [
            'payload' => [
                'name' => 'My product',
            ],
            'responseCode' => 422,
            'violations' => [
                ['propertyPath' => 'price', 'title' => 'This value should be greater than 0.'],
            ],
        ];
    }

    /**
     * @dataProvider provideProductList
     */
    public function testProductList(
        array $queryParams, 
        int $responseCode=200, 
        int $expectedCount=0, 
        string $firstItemName='',
        array $violations=[], 
    ) {
        $queryStrings = [];
        foreach($queryParams as $key => $value) {
            if ($key !== 'catalogs') {
                $queryStrings[] = $key.'='.$value;
                continue;
            }
            
            foreach ($value as $catalogId) {
                $queryStrings[] = 'catalogs[]='.$catalogId;
            }
        }

        $queryString = '?'.implode('&', $queryStrings);

        $client = $this->createAuthenticatedClient();
        $client->jsonRequest(
            method:'GET', 
            uri: '/api/product'.$queryString,
        );

        $response = $client->getResponse();
        $jsonResponse = json_decode($response->getContent(), true);
        
        $this->assertEquals($responseCode, $response->getStatusCode());

        if ($expectedCount > 0) {
            $this->assertCount($expectedCount, $jsonResponse);
        }
        if ($firstItemName !== '') {
            $this->assertEquals($firstItemName, $jsonResponse[0]['name'] ?? null);
        }

        if ($responseCode !== 200) {
            $this->assertViolations($jsonResponse, $violations);

            return;
        }
    }

    public static function provideProductList(): iterable
    {
        yield 'Success: list nameASC 10' => [
            'queryParams' => [
                'sortType' => 'nameASC',
                'limit' => 10,
            ],
            'responseCode' => 200,
            'expectedCount' => 10,
            'firstItemName' => 'Product 01',
        ];

        yield 'Success: list nameDESC 10 q=2' => [
            'queryParams' => [
                'sortType' => 'nameDESC',
                'limit' => 10,
                'q' => '2',
            ],
            'responseCode' => 200,
            'expectedCount' => 2,
            'firstItemName' => 'Product 12',
        ];

        yield 'Success: list nameDESC 10 catalog id 1 "Catalog 02"' => [
            'queryParams' => [
                'sortType' => 'nameDESC',
                'limit' => 10,
                'catalogs' => [1],
            ],
            'responseCode' => 200,
            'expectedCount' => 3,
            'firstItemName' => 'Product 11',
        ];

        yield 'Fail: missing sortType' => [
            'queryParams' => [
                'limit' => 10,
            ],
            'responseCode' => 404,
            'violations' => [
                ['propertyPath' => 'sortType', 'title' => 'This value should be of type string.'],
            ],
        ];

        yield 'Fail: missing limit' => [
            'queryParams' => [
                'sortType' => 'nameASC',
            ],
            'responseCode' => 404,
            'violations' => [
                ['propertyPath' => 'limit', 'title' => 'This value should be of type int.'],
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