<?

namespace App\Tests\Application\Controller;

use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpKernel\Exception\HttpException;

class AuthTest extends WebTestCase
{
    protected function createAuthenticatedClient($email = 'test@test.fr', $password = 'Test123%'): KernelBrowser
    {
        $client = static::createClient();
        $client->jsonRequest(
        'POST',
        '/api/login_check',
        [
            'email' => $email,
            'password' => $password,
        ]
        );

        if ($client->getResponse()->getStatusCode() === 401) {
            throw new HttpException(401);
        }

        $data = json_decode($client->getResponse()->getContent(), true);

        $client->setServerParameter('HTTP_Authorization', sprintf('Bearer %s', $data['token']));

        return $client;
    }

    public function testAuthSuccess()
    {
        $client = $this->createAuthenticatedClient();

        $this->assertNotNull($client);
    }

    public function testWrongCredentials()
    {
        $this->expectException(HttpException::class);
        $this->createAuthenticatedClient('wrong@email.com');
    }

    public function tearDown(): void
    {
        parent::tearDown();

        restore_exception_handler();
    }
}