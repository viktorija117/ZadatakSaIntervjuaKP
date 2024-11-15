<?php 

class PasswordValidator implements ValidatorInterface{

    private $errors = [];

    public function validate(array $data): array {
        if (empty($data['password'])){
            $this->errors['password'] = "Password is required.";
        } else if (mb_strlen($data['password']) < 8){
            $this->errors['password'] = "Password must be at least 8 characters long.";
        }

        if ($data['password'] !== $data['password2']){
            $this->errors['password'] = "Passwords do not match.";
        }

        return $this->errors;
    }
}