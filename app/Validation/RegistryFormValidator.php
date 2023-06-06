<?php declare(strict_types=1);

namespace App\Validation;

use App\Exceptions\ValidatorException;
use App\Repositories\User\UserRepository;

class RegistryFormValidator
{
    private UserRepository $userRepository;
    private array $errors = [];
    private array $fields = [];

    public function __construct(UserRepository $userRepository)
    {

        $this->userRepository = $userRepository;
    }

    public function validateRegisterForm(array $fields = []): void
    {
        $this->fields = $fields;
        foreach ($fields as $field => $value){
            $methodName = 'validate' . ucfirst($field);
            if(method_exists($this, $methodName))
            {
                $this->$methodName();
            }
        }

        if(count($this->errors) > 0){
            $_SESSION['errors'] = $this->errors;
            throw new ValidatorException('Form validation has failed.');
        }
    }

    private function validateEmail()
    {
        $email = $this->fields['email'];

        if(!isset($email) || strlen($email) < 1){
            $this->errors['email'][] = 'Email field is required';
        }

        $userExists = $this->userRepository->findByEmail($email);

        if($userExists != null){
            $this->errors['email'][] = 'User already exists';
        }
    }

    private function validateName()
    {
        $name = $this->fields['name'];
        if(!isset($name) || strlen($name) < 1){
            $this->errors['name'][] = 'Name field is required';
        }
    }

    private function validateUsername()
    {
        $username = $this->fields['username'];
        if(!isset($username) || strlen($username) < 1){
            $this->errors['username'][] = 'Username field is required';
        }
    }

    private function validatePassword()
    {
        $password = $this->fields['password'];
        $passwordConfirmation = $this->fields['password_confirmation'];

        if(!isset($password) || strlen($password) < 1){
            $this->errors['password'][] = 'Password field is required';
        }

        if(!isset($passwordConfirmation) || strlen($passwordConfirmation) < 1){
            $this->errors['password_confirmation'][] = 'Password confirmation field is required';
        }

        if($password !== $passwordConfirmation){
            $this->errors['password'][] = 'Passwords do not match';
        }

    }

    public function getError(): array
    {
        return $this->errors;
    }
}
