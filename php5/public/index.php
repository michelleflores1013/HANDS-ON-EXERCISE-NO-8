<?php

$page = $_GET['page'] ?? 'person';

if ($page === 'faculty') {

    require_once __DIR__ .
        '/../controllers/FacultyController.php';

    $controller = new FacultyController();

    $controller->index();

} else {

    require_once __DIR__ .
        '/../controllers/PersonController.php';

    $controller = new PersonController();

    $controller->index();
}