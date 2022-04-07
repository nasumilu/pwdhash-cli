# PHP Password Hash CLI

This is a very simple CLI to hash a password using PHP's `password_hash` function.


# Usage

```shell
$ ./pwdhash
Enter a password: [the password to hash]
Choose an hashing algorithm (default, bcrypt, argon2i, argon2id) [default]: 
Password Hash: $2y$10$qaDMKKdnOXk17xdGQsixte4LYN8f1v4vkdYwj80w.FwnnSfQOLk6e
```

# Hashing Algorithms

- default: As of PHP 5.5.0 this uses bycrypt with a default cost of 10
- bycrypt: Uses the blowfish to to generate a standard crypt compatiable hash.
- argon2i: Uses the Argon2i hashing algorithm (requires: ext-sodium or ext-libargon2)
- argon2id: Uses the Argon2id hashing algorithm (requires: ext-sodium or ext-libargon2)

# Additional Information

- [PHP `password_hash` function](https://www.php.net/manual/en/function.password-hash.php)
- [PHP `crypt` function](https://www.php.net/manual/en/function.crypt.php)
- [PHP password algorithm const](https://www.php.net/manual/en/password.constants.php)
- [PHP `password_verify` function](https://www.php.net/manual/en/function.password-verify.php)
- [Argon2](https://github.com/P-H-C/phc-winner-argon2)
- [Blowfish](https://en.wikipedia.org/wiki/Blowfish_(cipher))