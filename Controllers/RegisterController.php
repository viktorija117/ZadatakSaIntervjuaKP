<?php

class RegisterController{

    private $registerService;

    public function __construct(RegisterService $registerService) {
        $this->registerService = $registerService;
    }

    public function handleRequest() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'email' => $_POST['email'] ?? '',
                'password' => $_POST['password'] ?? '',
                'password2' => $_POST['password2'] ?? ''
            ];

            $response = $this->registerService->register($data);
            echo json_encode($response);
        }
    }
}