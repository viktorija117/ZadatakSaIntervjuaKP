<?php

class RegisterService {

    private $emailvalidator;
    private $passwordvalidator;
    private $user;
    private $maxmind;

    public function __construct(ValidatorInterface $emailvalidator, ValidatorInterface $passwordvalidator, UserRepository $user, MaxMindInterface $maxmind){
        $this->emailvalidator = $emailvalidator;
        $this->passwordvalidator = $passwordvalidator;
        $this->user = $user;
        $this->maxmind = $maxmind;
    }

    public function register($data){

        $errors = $this->emailvalidator->validate($data);
        if (!empty($errors)){
            return ['succes' => false, 'errors' => $errors];
        }

        $errors = $this->passwordvalidator->validate($data);
        if (!empty($errors)){
            return ['succes' => false, 'errors' => $errors];
        }

        if ($errors = $this->user->findbyemail($data['email'])){
            return ['succes' => false, 'errors' => ['email' => 'Email already exists.']];
        }

        if ($this->maxmind->check($data['email'], $_SERVER['REMOTE_ADDR'])){
            return ['succes' => false, 'errors' => ['maxmind' => 'Malicious intent detected.']];
        }

        $user_id = $this->user->insertUser($data['email'], $data['password']);
        $this->user->logAction($user_id, 'register');
        return ['success' => true, 'user_id' => $user_id];
    }

}