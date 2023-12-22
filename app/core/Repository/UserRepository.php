<?php

namespace Repository;

use Primitives\Models\RoleName;
use Primitives\Models\User;
use RepositoryInterfaces\IUserRepository;

class UserRepository implements IUserRepository
{
    public function __construct(private readonly MssqlClient $databaseClient)
    {
    }

    public function getAll(): array
    {
        $users = $this->databaseClient->executeQuery("
            SELECT
                [User].Id,
                RegistrationNumber,
                Username,
                FullName,
                Email,
                Phone,
                Avatar,
                Role
            FROM
                 dbo.[User]
        ");

        return array_map(fn($user) => User::fromArray($user), $users);
    }

    public function getById(int $id): User
    {
        $user = $this->databaseClient->executeQuery("
            SELECT
                [User].Id as Id,
                RegistrationNumber,
                Username,
                Password,
                FullName,
                Email,
                Phone,
                Avatar,
                Role
            FROM
                 dbo.[User]
            WHERE [User].Id = ?
        ", [$id])[0];

        return User::fromArray($user);
    }

    public function getByUsernameOrEmailOrRegistrationNumber(string $username): User|null
    {
        $users = $this->databaseClient->executeQuery("
            SELECT
                [User].Id as Id,
                RegistrationNumber,
                Username,
                Password,
                FullName,
                Email,
                Phone,
                Avatar,
                Role
            FROM
                 dbo.[User]
            WHERE Username = ? OR Email = ? OR RegistrationNumber = ?
        ", [
            $username,
            $username,
            $username
        ]);
        if (sizeof($users) < 1) return null;

        return User::fromArray($users[0]);
    }

    public function getAllByRole(RoleName $role): array
    {
        $users = $this->databaseClient->executeQuery("
            SELECT
                [User].Id as Id,
                RegistrationNumber,
                Username,
                Password,
                FullName,
                Email,
                Phone,
                Avatar,
                Role
            FROM
                 dbo.[User]
            WHERE Role = :role
        ", ['role' => $role->value]);

        return array_map(fn($user) => User::fromArray($user), $users);
    }

    public function create(User $user): User
    {
        $this->databaseClient->executeNonQuery("
            INSERT INTO dbo.[User] (RegistrationNumber, FullName, Username, Password, Email, Phone, Avatar, Role)
            VALUES (:registration_number, :fullname, :username, :password, :email, :phone, :avatar, :role);
        ", [
            'registration_number' => $user->getRegistrationNumber(),
            'fullname' => $user->getFullname(),
            'username' => $user->getUsername(),
            'password' => $user->getPassword(),
            'email' => $user->getEmail(),
            'phone' => $user->getPhone(),
            'avatar' => $user->getAvatar(),
            'role' => $user->getRole()->value
        ]);

        return $this->getById($this->databaseClient->getLastInsertedId());
    }

    public function update(User $user): User
    {
        // update user based on the available fields
        $this->databaseClient->executeNonQuery("
            UPDATE dbo.[User]
            SET
                RegistrationNumber = ?,
                FullName = ?,
                Username = ?,
                Password = ?,
                Email = ?,
                Phone = ?,
                Avatar = ?,
                Role = ?
            WHERE Id = ?
        ", [
            $user->getRegistrationNumber(),
            $user->getFullname(),
            $user->getUsername(),
            $user->getPassword(),
            $user->getEmail(),
            $user->getPhone(),
            $user->getAvatar(),
            $user->getRole()->value,
            $user->getId()
        ]);

        return $user;
    }

    public function delete(int $id): User
    {
        $user = $this->getById($id);
        $this->databaseClient->executeNonQuery("
            DELETE FROM dbo.[User] WHERE Id = ?
        ", [$id]);
        return $user;
    }

    public function getCount(): int
    {
        return $this->databaseClient->executeQuery("
            SELECT COUNT(Id) as Count FROM dbo.[User]
        ")[0]['Count'];
    }
}