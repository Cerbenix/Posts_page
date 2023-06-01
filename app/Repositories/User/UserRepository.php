<?php declare(strict_types=1);

namespace App\Repositories\User;


use App\Models\User;

interface UserRepository
{
    public function all(): array;
    public function getById(int $userId): User;
    public function save(User $user):void;
    public function update(User $user):void;
    public function findByUsername(string $username): ?User;
    public function findByEmail(string $email): ?User;
}
