<?

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class CgoService
{
    private $client;

    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }

    public function getFranceData(): array
    {
        $response = $this->client->request(
            'GET',
            'https://api.tomtom.com/routing/1/calculateRoute/52.50931,13.42936:52.50274,13.43872/json?key=CY0cA0IJXHBdI3e8kqVijtyRoxuV6ULL'
        );

        return $response->toArray();
        // return $response;
    }
}