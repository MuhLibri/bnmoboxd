<?php

namespace app\services;

use app\core\Application;
use app\core\Service;
use app\exceptions\BadRequestException;
use app\exceptions\NotFoundException;
use app\repositories\UserRepository;

class UserService extends Service
{
    private UserRepository $userRepository;
    public function __construct()
    {
        require_once Application::$BASE_DIR . '/src/repositories/UserRepository.php';
        $this->userRepository = new UserRepository();
    }

    public function setSession($user) {
        $_SESSION['username'] = $user['username'];
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['role'] = $user['role'];
        $_SESSION['profile_picture_path'] = $user['profile_picture_path'];
    }

    /**
     * @throws BadRequestException
     */
    public function login($credentials) {
        $errors = $this->validateRequired($credentials, ['username', 'password']);

        $this->handleValidationErrors($errors);

        $user = $this->userRepository->getUserByUsername($credentials['username']);

        if ($user) {
            $verify = password_verify($credentials['password'], $user['password_hash']);
            if ($verify) {
               $this->setSession($user);
                return;
            }
        }
        $errors['auth'] = 'Invalid username/password';
        $this->handleValidationErrors($errors);
    }
    /*
     * Service level validation: checks for unique email and unique username
     * Creates user if successful
     * */
    /**
     * @throws BadRequestException
     */
    public function register(array $registerData) {
        $this->validateRegisterFields($registerData);
        $hashedPassword = $this->hashPassword($registerData['password']);
        $this->userRepository->addUser($registerData['username'], $registerData['email'], $hashedPassword, $registerData['first_name'], $registerData['last_name']);
        $user = $this->userRepository->getUserByUsername($registerData['username']);
        $this->setSession($user);
    }

    public function logout()
    {
        session_unset();
        session_destroy();
    }

    /**
     * @throws NotFoundException
     */
    public function getUserProfile($username): array {
        $user = $this->userRepository->getUserByUsername($username);
        if (!$user) {
            throw new NotFoundException();
        }
        return [
            'id' => $user['id'],
            'username' => $user['username'],
            'email' => $user['email'],
            'firstName' => $user['first_name'],
            'lastName' => $user['last_name'],
            'profilePicturePath' => $user['profile_picture_path']
        ];
    }
    private function hashPassword (string $password) {
        return password_hash($password, PASSWORD_BCRYPT);
    }

    /**
     * @throws BadRequestException
     */
    private function validateRegisterFields(array $data){
        $errors = $this->validateRequired($data, ['username', 'password', 'first_name', 'email']);
        $user = null;

        if (!isset($errors['email'])) {
            $errors = array_merge($errors, $this->validateEmail($data['email']));
        }

        if (!isset($errors['username'])) {
            $errors = array_merge($errors, $this->validateUsername($data['username']));
        }

        $this->handleValidationErrors($errors);
    }

    /**
     * @throws NotFoundException
     * @throws BadRequestException
     */
    private function validateUpdateUserFields (array $updateData) {
        $errors = $this->validateRequired($updateData, ['username', 'first_name', 'email']);
        $currentUser = $this->userRepository->getUserById($updateData['user_id']);

        if (!$currentUser) {
            throw new NotFoundException(true);
        }

        if(!isset($errors['email'])) {
            $errors = array_merge($errors, $this->validateEmail($updateData['email'], $currentUser));
        }

        if (!isset($errors['username'])) {
            $errors = array_merge($errors, $this->validateUsername($updateData['username'], $currentUser));
        }

        $this->handleValidationErrors($errors);
    }

    private function validateEmail(string $email, $currentUser = null): array
    {
        $pattern = '/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/';
        $errors = [];
        if (!preg_match($pattern, $email)) {
            $errors['email'] = 'Email is invalid';
        } else {
            $userWithEmail = $this->userRepository->getUserByEmail($email);
            if (($currentUser && $userWithEmail && $userWithEmail['id'] !== $currentUser['id']) || (!$currentUser && $userWithEmail)) {
                $errors['email'] = 'Email is already taken';
            }
        }
        return $errors;
    }

    private function validateUsername(string $username, $currentUser = null): array {
        $pattern = "/^[a-zA-Z0-9_]{4,18}$/";
        $errors = [];
        if (!preg_match($pattern, $username)) {
            $errors['username'] = 'Username should only contain letters (A-Z, a-z), numbers (0-9), and underscores (_) and must be 4 to 18 characters long.';
        } else {
            $userWithUsername = $this->userRepository->getUserByUsername($username);
            if (($currentUser && $userWithUsername && $userWithUsername['id'] !== $currentUser['id']) || (!$currentUser && $userWithUsername)) {
                $errors['username'] = 'Username is already taken';
            }
        }
        return $errors;
    }


    /**
     * @throws BadRequestException
     * @throws NotFoundException
     */
    public function updateUser(array $updateData)
    {
        $this->validateUpdateUserFields($updateData);
        $profilePicturePath = null;
        if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['name'] !== '') {
            $profilePicturePath = saveFile($_FILES['profile_picture'], Application::$BASE_DIR . '/public/assets/users/');
        }
        $this->userRepository->updateUser((int)$updateData['user_id'], $updateData['username'], $updateData['email'], $updateData['first_name'], $updateData['last_name'], $profilePicturePath);
    }

    /**
     * @throws NotFoundException
     */
    public function deleteUser($username)
    {
        $currentUser = $this->getUserProfile($username);
        $this->userRepository->deleteUser((int)$currentUser['id']);
        $this->logout();
    }
}
