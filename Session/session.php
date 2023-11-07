<?php
session_start();

function isUserLoggedIn() {
    return isset($_SESSION['user_id']);
}

function loginUser($user_id, $username) {
    $_SESSION['user_id'] = $user_id;
    $_SESSION['username'] = $username;
}

function logoutUser() {
    unset($_SESSION['user_id']);
    unset($_SESSION['username']);
}

function getLoggedInUserId() {
    return isUserLoggedIn() ? $_SESSION['user_id'] : null;
}

function getLoggedInUsername() {
    return isUserLoggedIn() ? $_SESSION['username'] : null;
}