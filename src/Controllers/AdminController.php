<?php

namespace App\Controllers;

use PDO;

class AdminController {
    private $db;

    public function __construct(PDO $db) {
        $this->db = $db;
    }

    public function createClass($className) {
        $stmt = $this->db->prepare('INSERT INTO classes (name) VALUES (?)');
        $stmt->execute([$className]);

        return ['message' => 'Class created successfully'];
    }

    public function createSubject($subjectName, $teacherId) {
        $stmt = $this->db->prepare('INSERT INTO subjects (name, teacher_id) VALUES (?, ?)');
        $stmt->execute([$subjectName, $teacherId]);

        return ['message' => 'Subject created successfully'];
    }
}
