<?php

require_once 'Controllers/RegisterController.php';
require_once 'Services/RegisterService.php';
require_once 'Repositories/UserRepository.php';
require_once 'Libraries/Database.php';
require_once 'Libraries/QueryBuilder.php';
require_once 'Libraries/MaxMindInterface.php'; 
require_once 'Libraries/MaxMind.php';
require_once 'Validators/ValidatorInterface.php';
require_once 'Validators/EmailValidator.php';
require_once 'Validators/PasswordValidator.php';

$db = Database::getInstance();
$queryBuilder = new QueryBuilder();
$userRepository = new UserRepository($db,$queryBuilder);
$emailValidator = new EmailValidator();
$passwordValidator = new PasswordValidator();
$maxmind = new MaxMind();

$registerService = new RegisterService($emailValidator, $passwordValidator, $userRepository, $maxmind);
$controller = new RegisterController($registerService);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $controller->handleRequest();
} else {
    include 'register_form.html';
}
