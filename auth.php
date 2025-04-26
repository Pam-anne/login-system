<?php

function requireAuth() {
    if (!isset($_SESSION['user'])) {
        header('Location: /login');
        exit();
    }
}

function guest() {
    if (isset($_SESSION['user'])) {
        header('Location: /');
        exit();
    }
}