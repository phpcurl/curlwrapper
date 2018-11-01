#!/usr/bin/env bash
php -S localhost:8888 test/server.php &
echo $! > server_pid
sleep 1
