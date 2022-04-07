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


// php default password hashing algorithm
function defaultPwdHash(string $pwd): string 
{
    return password_hash($pwd, PASSWORD_DEFAULT);
}

function bcryptPwdHash(string $pwd, ?int $cost = null): string 
{
    if(null === $cost) {
        do {
            echo "\e[33mAlgorithmic cost to use (>= 10)\e[0m \e[32m[10]:\e[0m ";
            $cost = readline();
            // if input is empty use dfault: 10
            if(empty($cost)) {
                $cost = 10;
            }
        } while(!is_numeric($cost) && $cost < 10);
    }
    return password_hash($pwd, PASSWORD_BCRYPT, ['cost' => $cost]);
}

function handleArgon2Options(array $options = []): array 
{

    // get memory_cost from input if not already set.
    if(!isset($options['memory_cost'])) {
        $defaultCost = PASSWORD_ARGON2_DEFAULT_MEMORY_COST;
        do {
            echo "\e[33mMaximum memory (in kibibytes) that may be used to compute the Argon2 hash (>= {$defaultCost})\e[0m \e[32m[$defaultCost]:\e[0m ";
            $options['memory_cost'] = readline();
            // if input is empty use default value
            if(empty($options['memory_cost'])) {
                $options['memory_cost'] = PASSWORD_ARGON2_DEFAULT_MEMORY_COST;
            }
        } while(!is_numeric($options['memory_cost']) && $options['memory_cost'] < PASSWORD_ARGON2_DEFAULT_MEMORY_COST);
    }

    // get time_cost from input if not already set.
    if(!isset($options['time_cost'])) {
        $defaultTimeCost = PASSWORD_ARGON2_DEFAULT_TIME_COST;
        do {
            echo "\e[33mMaximum amount of time it may take to compute the Argon2 hash (>= {$defaultTimeCost})\e[0m \e[0m \e[32m[$defaultTimeCost]:\e[0m ";
            $options['time_cost'] = readline();
            // if input is empty use default value
            if(empty($options['time_cost'])) {
                $options['time_cost'] = PASSWORD_ARGON2_DEFAULT_TIME_COST;
            }
        } while(!is_numeric($options['time_cost']) && $options['time_cost'] < PASSWORD_ARGON2_DEFAULT_TIME_COST);
    }

    // get number of threads from input if not already set.
    // only works with ext-libargon2 not ext-sodium
    if(extension_loaded('libargon2') && !isset($options['threads'])) {
        $defaultThreads = PASSWORD_ARGON2_DEFAULT_THREADS;
        do {
            echo "\e[33mNumber of threads to use for computing the Argon2 hash (>= {$defaultThreads})\e[0m \e[0m \e[32m[$defaultThreads]:\e[0m ";
            $options['threads'] = readline();
            if(empty($options['time_cost'])) {
                $options['threads'] = PASSWORD_ARGON2_DEFAULT_TIME_COST;
            }
        } while(!is_numeric($options['threads']) && $options['threads'] < PASSWORD_ARGON2_DEFAULT_THREADS);
    }

    return $options;
}


function argon2iPwdHash(string $pwd, array $options = []): string 
{
    return password_hash($pwd, PASSWORD_ARGON2I, handleArgon2Options($options));
}

function argon2idPwdHash(string $pwd, array $options = []): string 
{
    return password_hash($pwd, PASSWORD_ARGON2ID, handleArgon2Options($options));
}