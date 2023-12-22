<?php

namespace Primitives\Models;

class User
{
    public function __construct(
        private ?int          $id,
        private ?string       $registrationNumber,
        private string        $fullname,
        private string        $username,
        private ?string       $password,
        private string        $email,
        private string        $phone,
        private string        $avatar,
        private RoleName      $role,
    )
    {
    }

    public function comparePassword(string $password): bool
    {
        return password_verify($password, $this->password);
    }

    public static function fromArray(array $user): User
    {
        return new User(
            id: $user['Id'],
            registrationNumber: $user['RegistrationNumber'],
            fullname: $user['FullName'],
            username: $user['Username'],
            password: $user['Password'] ?? null,
            email: $user['Email'],
            phone: $user['Phone'],
            avatar: $user['Avatar'],
            role: RoleName::from($user['Role']),
        );
    }

    public function updateWith(array $user): void
    {
        if (isset($user['registrationNumber']) && $user['registrationNumber'] !== '') {
            $this->registrationNumber = $user['registrationNumber'];
        }

        if (isset($user['fullname']) && $user['fullname'] !== '') {
            $this->fullname = $user['fullname'];
        }

        if (isset($user['username']) && $user['username'] !== '') {
            $this->username = $user['username'];
        }

        if (isset($user['password']) && $user['password'] !== '') {
            $hashed_password = password_hash($user['password'], PASSWORD_DEFAULT);
            $this->password = $hashed_password;
        }

        if (isset($user['email']) && $user['email'] !== '') {
            $this->email = $user['email'];
        }

        if (isset($user['phone']) && $user['phone'] !== '') {
            $this->phone = $user['phone'];
        }

        if (isset($user['avatar']) && $user['avatar'] !== '') {
            $this->avatar = $user['avatar'];
        }

        if (isset($user['role']) && $user['role'] !== '') {
            $this->role = RoleName::from($user['role']);
        }
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function getRegistrationNumber(): ?string
    {
        return $this->registrationNumber;
    }

    public function setRegistrationNumber(?string $registrationNumber): void
    {
        $this->registrationNumber = $registrationNumber;
    }

    public function getFullname(): string
    {
        return $this->fullname;
    }

    public function setFullname(string $fullname): void
    {
        $this->fullname = $fullname;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function setUsername(string $username): void
    {
        $this->username = $username;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function getPhone(): string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): void
    {
        $this->phone = $phone;
    }

    public function getAvatar(): string
    {
        return $this->avatar;
    }

    public function setAvatar(string $avatar): void
    {
        $this->avatar = $avatar;
    }

    public function getRole(): RoleName
    {
        return $this->role;
    }

    public function setRole(RoleName $role): void
    {
        $this->role = $role;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(?string $password): void
    {
        $this->password = $password;
    }
}