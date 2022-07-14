<?

namespace App\Service;

use App\Repository\VilleRepository;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class CgoService
{
    private $client;
    private $villeRepository;

    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }

    public function getDistancesBeetweenDepannageAndShop($lieuDepannage, $shop): array
    {
        $response = $this->client->request(
            'GET',
            'https://api.tomtom.com/routing/1/calculateRoute/'.$lieuDepannage->getLat().','.$lieuDepannage->getLng().':'.$shop->getVille()->getLat().','.$shop->getVille()->getLng().'/json?key=CY0cA0IJXHBdI3e8kqVijtyRoxuV6ULL'
        );

        return $response->toArray();
        // return $response;
    }
}