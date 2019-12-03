<?php

namespace I4code\PleskApi;

function selectHost()
{
    $host = getenv('TESTAPIHOST');
    if (empty($host) && ('cli' == php_sapi_name())) {
        fwrite(STDERR, "\n");
        fwrite(STDERR, 'Please insert API host: ');
        $host = trim(fgets(STDIN));
        fwrite(STDERR, "\n");
        putenv('TESTAPIHOST=' . $host);
    }
    return $host;
}

function getAuthFromEnv()
{
    $token = getenv('TESTAPITOKEN');
    if (!empty($token)) {
        return (object)[
            'type' => 'token',
            'token' => $token
        ];
    }
    $user = getenv('TESTAPIUSER');
    $pass = getenv('TESTAPIPASS');
    if (!empty($user) && !empty($pass)) {
        return (object)[
            'type' => 'login',
            'user' => $user,
            'password' => $pass
        ];
    }
    return null;
}

function useToken()
{
    $token = getenv('TESTAPITOKEN');
    if (empty($token)) {
        fwrite(STDERR, "\n");
        fwrite(STDERR, 'If known insert API token here or just press enter to continue with basic auth: ');
        fwrite(STDERR, "\n");
        $token = trim(fgets(STDIN));
        fwrite(STDERR, "\n");
        putenv('TESTAPITOKEN=' . $token);
    }
    if (!empty($token)) {
        return (object)[
            'type' => 'token',
            'token' => $token
        ];
    }
    return null;
}

function useCredentials()
{
    $user = getenv('TESTAPIUSER');
    $pass = getenv('TESTAPIPASS');
    if (empty($user)) {
        fwrite(STDERR, "\n");
        fwrite(STDERR, 'User not set. Please insert name: ');
        $user = trim(fgets(STDIN));
        putenv('TESTAPIUSER=' . $user);
    }
    if (empty($pass)) {
        fwrite(STDERR, "Password required for user '{$user}': ");
        $pass = trim(fgets(STDIN));
        putenv('TESTAPIPASS=' . $pass);
    }
    if (!empty($user) && !empty($pass)) {
        return (object)[
            'type' => 'login',
            'user' => $user,
            'password' => $pass
        ];
    }
    return null;
}

