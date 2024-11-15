<?php

class EmailValidator implements ValidatorInterface{

    private $errors = [];
    public function validate(array $data): array{
        if (empty($data['email'])){
            $this->errors['email'] = 'Email is required.'; 
        } else if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)){
            $this->errors['email'] = 'Invalid email format.';
        }
        return $this->errors;
    }
}