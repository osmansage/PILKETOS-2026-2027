<?php
require_once __DIR__ . '/../includes/functions.php';

unset($_SESSION['admin_id'], $_SESSION['admin_username']);
flash('success', 'Admin telah keluar.');
redirect('login.php');
