<?php

class MaxMind implements MaxMindInterface{
    public function check(string $email, string $ip):bool{
        if(strpos($email, 'zlonamerno')){
            return true;
        }
        return false;
    }
}