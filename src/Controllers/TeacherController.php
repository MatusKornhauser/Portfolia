<?php

namespace App\Controllers;

use PDO;

class TeacherController {
    private $db;

    public function __construct(PDO $db) {
        $this->db = $db;
    }

    public function viewStudentPortfolio($studentId) {
        $stmt = $this->db->prepare('SELECT * FROM portfolios WHERE student_id = ?');
        $stmt->execute([$studentId]);
        $portfolios = $stmt->fetchAll();

        return $portfolios;
    }
}
