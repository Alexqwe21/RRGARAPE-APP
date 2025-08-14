<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Definir uma URL BASE do APP
define('BASE_URL_APP', 'https://rrgarageapp.webdevsolutions.com.br/public/');

// Definir uma URL BASE do SITE
define('BASE_URL_SITE', 'https://rrgarage.webdevsolutions.com.br/');

// Definir uma API BASE
define('BASE_API', 'https://rrgarage.webdevsolutions.com.br/api/');

// Definir uma BASE FOTO
define('BASE_FOTO', 'https://rrgarage.webdevsolutions.com.br/uploads');

// Sistema para carregamento automático 
spl_autoload_register(function ($class) {
    if (file_exists('../app/controllers/' . $class . '.php')) {
        require_once '../app/controllers/' . $class . '.php';
    }

    if (file_exists('../rotas/' . $class . '.php')) {
        require_once '../rotas/' . $class . '.php';
    }
});
