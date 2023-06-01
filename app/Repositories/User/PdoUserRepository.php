<?php declare(strict_types=1);

namespace App\Repositories\User;

use App\DatabaseConnector;
use App\Models\User;
use App\Models\UserAddress;
use App\Models\UserCompany;
use Doctrine\DBAL\Query\QueryBuilder;

class PdoUserRepository implements UserRepository
{
    private DatabaseConnector $connection;
    private QueryBuilder $queryBuilder;

    public function __construct()
    {
        $this->connection = new DatabaseConnector();
        $this->queryBuilder = $this->connection->getConnection()->createQueryBuilder();
    }

    public function all(): array
    {
        $userCollection = [];
        $users = $this->queryBuilder->select('*')
            ->from('users')
            ->fetchAllAssociative();
        foreach ($users as $user) {
            $userCollection[] = $this->buildModel($user);
        }
        return $userCollection;
    }

    public function getById(int $userId): User
    {
        $user = $this->queryBuilder->select('*')
            ->from('users')
            ->where("id = ?")
            ->setParameter(0, $userId)
            ->fetchAssociative();
        return $this->buildModel((array)$user);
    }

    public function save(User $user): void
    {
        $this->queryBuilder->insert('users')
            ->values(
                [
                    'name' => '?',
                    'username' => '?',
                    'email' => '?',
                    'street' => '?',
                    'suite' => '?',
                    'city' => '?',
                    'zipcode' => '?',
                    'phone' => '?',
                    'website' => '?',
                    'company_name' => '?',
                    'company_catch_phrase' => '?',
                    'company_business_services' => '?',
                    'password' => '?',
                ]
            )
            ->setParameter(0, $user->getName())
            ->setParameter(1, $user->getUsername())
            ->setParameter(2, $user->getEmail())
            ->setParameter(3, $user->getAddress()->getStreet())
            ->setParameter(4, $user->getAddress()->getSuite())
            ->setParameter(5, $user->getAddress()->getCity())
            ->setParameter(6, $user->getAddress()->getZipCode())
            ->setParameter(7, $user->getPhone())
            ->setParameter(8, $user->getWebsite())
            ->setParameter(9, $user->getCompany()->getName())
            ->setParameter(10, $user->getCompany()->getCatchPhrase())
            ->setParameter(11, $user->getCompany()->getBusinessServices())
            ->setParameter(12, $user->getPassword())
            ->executeQuery();

        $user->setId((int)$this->connection->getConnection()->lastInsertId());
    }

    public function findByUsername(string $username): ?User
    {
        try {
            $user = $this->queryBuilder->select('*')
                ->from('users')
                ->where("username = ?")
                ->setParameter(0, $username)
                ->fetchAssociative();
            if ($user) {
                return $this->buildModel($user);
            } else {
                return null;
            }
        } catch (\Doctrine\DBAL\Exception $e) {
            return null;
        }
    }

    public function findByEmail(string $email): ?User
    {
        try {
            $user = $this->queryBuilder->select('*')
                ->from('users')
                ->where("email = ?")
                ->setParameter(0, $email)
                ->fetchAssociative();
            if ($user) {
                return $this->buildModel($user);
            } else {
                return null;
            }
        } catch (\Doctrine\DBAL\Exception $e) {
            return null;
        }
    }

    public function update(User $user): void
    {
        $this->queryBuilder->update('users')
            ->set('name', '?')
            ->set('username', '?')
            ->set('email', '?')
            ->set('street', '?')
            ->set('suite', '?')
            ->set('city', '?')
            ->set('zipcode', '?')
            ->set('phone', '?')
            ->set('website', '?')
            ->set('company_name', '?')
            ->set('company_catch_phrase', '?')
            ->set('company_business_services', '?')
            ->where('id = ?')
            ->setParameter(0, $user->getName())
            ->setParameter(1, $user->getUsername())
            ->setParameter(2, $user->getEmail())
            ->setParameter(3, $user->getAddress()->getStreet())
            ->setParameter(4, $user->getAddress()->getSuite())
            ->setParameter(5, $user->getAddress()->getCity())
            ->setParameter(6, $user->getAddress()->getZipCode())
            ->setParameter(7, $user->getPhone())
            ->setParameter(8, $user->getWebsite())
            ->setParameter(9, $user->getCompany()->getName())
            ->setParameter(10, $user->getCompany()->getCatchPhrase())
            ->setParameter(11, $user->getCompany()->getBusinessServices())
            ->setParameter(12, $user->getId())
            ->executeQuery();
    }

    private function buildModel(array $userReport): User
    {
        return new User(
            $userReport['name'],
            $userReport['username'],
            $userReport['email'],
            $this->createAddress($userReport),
            $userReport['phone'],
            $userReport['website'],
            $this->createCompany($userReport),
            $userReport['password'],
            (int)$userReport['id']
        );
    }

    private function createCompany(array $companyReport): UserCompany
    {
        return new UserCompany(
            $companyReport['company_name'],
            $companyReport['company_catch_phrase'],
            $companyReport['company_business_services']
        );
    }

    private function createAddress(array $addressReport): UserAddress
    {
        return new UserAddress(
            $addressReport['street'],
            $addressReport['suite'],
            $addressReport['city'],
            $addressReport['zipcode']
        );
    }
}
