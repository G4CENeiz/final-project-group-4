<?php

namespace Business\Services;

use Exception;
use Presentation\Http\Helpers\Storage;
use Primitives\Models\RoleName;
use Primitives\Models\User;
use RepositoryInterfaces\IUserRepository;

class UserService
{
    public function __construct(private readonly IUserRepository $userRepository)
    {
    }

    public function getAllUsers(): array
    {
        return $this->userRepository->getAll();
    }

    public function getUserById(int $id): User
    {
        return $this->userRepository->getById($id);
    }

    public function getAllApprovers(): array
    {
        return $this->userRepository->getAllByRole(RoleName::Approver);
    }

    public function getUserByUsernameOrEmail(string $username_or_email): User|null
    {
        return $this->userRepository->getByUsernameOrEmailOrRegistrationNumber($username_or_email);
    }

    /**
     * @throws Exception
     */
    public function createUser(array $raw_user): User
    {
        $avatar = Storage::handleUploadedImage('avatar', 'user');
        $hashedPassword = password_hash($raw_user['password'], PASSWORD_DEFAULT);
        $user = new User(
            id: null,
            registrationNumber: $raw_user['registration_number'],
            fullname: $raw_user['fullname'],
            username: $raw_user['username'],
            password: $hashedPassword,
            email: $raw_user['email'],
            phone: $raw_user['phone'],
            avatar: $avatar,
            role: RoleName::from($raw_user['role']),
        );
        return $this->userRepository->create($user);
    }

    /**
     * @throws Exception
     */
    public function updateUser(array $raw_user): User
    {
        $user = $this->getUserById($raw_user['id']);
        $avatar = Storage::updateUploadedImage('avatar', $user->getAvatar(), 'user');
        $user->updateWith([
            'registration_number' => $raw_user['registration_number'],
            'fullname' => $raw_user['fullname'],
            'username' => $raw_user['username'],
            'password' => $raw_user['password'],
            'email' => $raw_user['email'],
            'phone' => $raw_user['phone'],
            'avatar' => $avatar,
            'role' => $raw_user['role'],
        ]);
        return $this->userRepository->update($user);
    }

    public function deleteUser(int $id): User
    {
        $user = $this->userRepository->getById($id);
        Storage::removeStoredImage("user/{$user->getAvatar()}");
        return $this->userRepository->delete($id);
    }

    public function getUsersCount(): int
    {
        return $this->userRepository->getCount();
    }
}