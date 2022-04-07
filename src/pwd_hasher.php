<?php

/*
 * Copyright 2022 Michael Lucas <nasumilu@gmail.com>.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *      http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */


require_once __DIR__.'/hash_functions.php';


//Minimum eight characters, at least one letter, one number and one special character:
$regex = '/^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,}$/';

// get the password from stdin
$pwd = '';
do {
    // This is OK but doesn't hide or make inputted password
    echo "\e[33mEnter a password:\e[0m ";
    $pwd = readline();
} while(!preg_match($regex, $pwd));

// an array of possible hashing algorithms
// see https://www.php.net/manual/en/function.password-hash.php
$algorithms = [ 
    'default' => defaultPwdHash(...), // <- new to php 8.1 first class callable syntax (https://www.php.net/manual/en/functions.first_class_callable_syntax.php)
    'bcrypt' => bcryptPwdHash(...)
];

// check to see if php compiled with argon2 support and add those
// to the list of possible hashing algorithms
// Argon support is provided by ext-libargon2 or ext-sodium
if(extension_loaded('sodium') || extension_loaded('libargon2')) {
    $algorithms['argon2i']= argon2iPwdHash(...);
    $algorithms['argon2id'] = argon2idPwdHash(...);
}


// get the desired hashing algorithm
$algo = '';
do {
    echo sprintf("\e[33mChoose an hashing algorithm (%s)\e[0m \e[32m[default]:\e[0m ", implode(', ', array_keys($algorithms)));
    $algo = readline();
    if(empty($algo)) {
        $algo = 'default';
    }
} while(!array_key_exists($algo, $algorithms));

// finally call the selected hashing function
// any extra input is delegated to the specific algalgorithm function 
echo "Password Hash: \e[35m" . call_user_func($algorithms[$algo], $pwd) . "\e[0m\n";
