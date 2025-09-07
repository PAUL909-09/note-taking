<?php
require_once 'includes/functions.php';

if (!isset($_GET['id'])) {
    header('Location: index.php');
    exit;
}

if (deleteNote($_GET['id'])) {
    header('Location: index.php');
    exit;
} else {
    die("Failed to delete note.");
}
?>