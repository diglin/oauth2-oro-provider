#!/usr/bin/env bash

echo 'Check PHP 7.1 compatibility'
vendor/bin/phpcs -p src --standard=PHPCompatibility --runtime-set testVersion 7.1
echo 'Check PHP 7.1 compatibility - DONE'

echo 'Check PHP 7.4 compatibility'
vendor/bin/phpcs -p src --standard=PHPCompatibility --runtime-set testVersion 7.4
echo 'Check PHP 7.4 compatibility - DONE'

echo 'Check PHP 8.1 compatibility'
vendor/bin/phpcs -p src --standard=PHPCompatibility --runtime-set testVersion 8.1
echo 'Check PHP 8.1 compatibility - DONE'
