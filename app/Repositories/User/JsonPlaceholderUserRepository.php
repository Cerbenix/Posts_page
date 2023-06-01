<?php declare(strict_types=1);

namespace App\Repositories\User;

use App\Cache;
use App\Models\User;
use App\Models\UserAddress;
use App\Models\UserCompany;
use GuzzleHttp\Client;

class JsonPlaceholderUserRepository implements UserRepository
{
    private Client $client;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => 'https://jsonplaceholder.typicode.com'
        ]);
    }

    public function all(): array
    {
        $userCollection = [];
        $userIdList = range(1, 10);
        $allCached = true;
        foreach ($userIdList as $userId) {
            if (!Cache::has('user_' . $userId)) {
                $allCached = false;
                break;
            }
        }
        if (!$allCached) {
            $response = $this->client->get('users');
            $report = json_decode($response->getBody()->getContents());
            foreach ($report as $user) {
                $userCollection[] = $this->buildModel($user);
                Cache::save('user_' . $user->id, json_encode($user));
            }
        } else {
            foreach ($userIdList as $userId) {
                $cachedReport = json_decode(Cache::get('user_' . $userId));
                $userCollection[] = $this->buildModel($cachedReport);
            }
        }
        return $userCollection;
    }

    public function getById(int $userId): User
    {
        $cacheKey = 'user_' . $userId;
        $report = $this->fetchFromApi('users/' . $userId, $cacheKey);
        return $this->buildModel($report);
    }

    private function buildModel(\stdClass $userReport): User
    {
        return new User(
            $userReport->name,
            $userReport->username,
            $userReport->email,
            $this->createAddress($userReport->address),
            $userReport->phone,
            $userReport->website,
            $this->createCompany($userReport->company),
            $userReport->id
        );
    }

    private function createCompany(\stdClass $companyReport): UserCompany
    {
        return new UserCompany(
            $companyReport->name,
            $companyReport->catchPhrase,
            $companyReport->bs
        );
    }

    private function createAddress(\stdClass $addressReport): UserAddress
    {
        return new UserAddress(
            $addressReport->street,
            $addressReport->suite,
            $addressReport->city,
            $addressReport->zipcode
        );
    }

    private function fetchFromApi(string $endpoint, string $cacheKey): \stdClass
    {
        if (!Cache::has($cacheKey)) {
            $response = $this->client->get($endpoint);
            $report = (object)json_decode($response->getBody()->getContents());
            Cache::save($cacheKey, json_encode($report));
        } else {
            $report = (object)json_decode(Cache::get($cacheKey));
        }
        return $report;
    }


    public function save(User $user): void
    {

    }

    public function findByUsername(string $username): ?User
    {
        return null;
    }

    public function update(User $user): void
    {

    }

    public function findByEmail(string $email): ?User
    {
        return null;
    }
}
