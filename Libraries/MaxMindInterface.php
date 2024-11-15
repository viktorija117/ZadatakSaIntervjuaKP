<?php

interface MaxMindInterface{
    public function check(string $email, string $ip):bool;
}