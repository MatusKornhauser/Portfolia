<?php

require __DIR__ . '/../vendor/autoload.php';

use App\Controllers\AuthController;
use App\Controllers\StudentController;
use App\Controllers\TeacherController;
use App\Controllers\AdminController;
use App\Controllers\FileUploadController;
use App\Middleware\RoleMiddleware;

$config = require __DIR__ . '../src/config/database.php';

var_dump($config);   // TEMP – delete after test
die;

$dsn = "mysql:host=localhost;dbname={$config['database']};charset=utf8mb4";

$db = new PDO(
    $dsn,
    $config['username'],
    $config['password'],
    [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]
);

// Initialize controllers
$authController = new AuthController($db);
$studentController = new StudentController($db);
$teacherController = new TeacherController($db);
$adminController = new AdminController($db);
$fileUploadController = new FileUploadController();

// Handle request
$requestMethod = $_SERVER['REQUEST_METHOD'];
$requestUri = $_SERVER['REQUEST_URI'];

if ($requestMethod === 'POST' && $requestUri === '/api/login') {
    $input = json_decode(file_get_contents('php://input'), true);
    $response = $authController->login($input['email'], $input['password']);
    header('Content-Type: application/json');
    echo json_encode($response);
}

$authHeader = $_SERVER['HTTP_AUTHORIZATION'] ?? '';
$jwt = str_replace('Bearer ', '', $authHeader);

if ($requestMethod === 'POST' && $requestUri === '/api/student/portfolio/upload') {
    $roleCheck = RoleMiddleware::checkRole('STUDENT', $jwt);
    if ($roleCheck) {
        header('Content-Type: application/json');
        echo json_encode($roleCheck);
        exit;
    }
    $response = $fileUploadController->uploadFile($_FILES['file']);
    header('Content-Type: application/json');
    echo json_encode($response);
}

if ($requestMethod === 'GET' && preg_match('/\/api\/teacher\/portfolio\/(\d+)/', $requestUri, $matches)) {
    $roleCheck = RoleMiddleware::checkRole('TEACHER', $jwt);
    if ($roleCheck) {
        header('Content-Type: application/json');
        echo json_encode($roleCheck);
        exit;
    }
    $studentId = $matches[1];
    $response = $teacherController->viewStudentPortfolio($studentId);
    header('Content-Type: application/json');
    echo json_encode($response);
}

if ($requestMethod === 'POST' && $requestUri === '/api/admin/class') {
    $roleCheck = RoleMiddleware::checkRole('ADMIN', $jwt);
    if ($roleCheck) {
        header('Content-Type: application/json');
        echo json_encode($roleCheck);
        exit;
    }
    $input = json_decode(file_get_contents('php://input'), true);
    $response = $adminController->createClass($input['name']);
    header('Content-Type: application/json');
    echo json_encode($response);
}

if ($requestMethod === 'POST' && $requestUri === '/api/admin/subject') {
    $roleCheck = RoleMiddleware::checkRole('ADMIN', $jwt);
    if ($roleCheck) {
        header('Content-Type: application/json');
        echo json_encode($roleCheck);
        exit;
    }
    $input = json_decode(file_get_contents('php://input'), true);
    $response = $adminController->createSubject($input['name'], $input['teacher_id']);
    header('Content-Type: application/json');
    echo json_encode($response);
}

if ($requestMethod === 'POST' && $requestUri === '/api/student/portfolio') {
    $input = json_decode(file_get_contents('php://input'), true);
    $response = $studentController->uploadPortfolio($input['student_id'], $input);
    header('Content-Type: application/json');
    echo json_encode($response);
}

?>
