<?php

namespace App\Controllers;

use PDO;

class StudentController {
    private $db;

    public function __construct(PDO $db) {
        $this->db = $db;
    }

    public function uploadPortfolio($studentId, $portfolioData) {
        $stmt = $this->db->prepare('INSERT INTO portfolios (name, description, subject_id, student_id, date) VALUES (?, ?, ?, ?, NOW())');
        $stmt->execute([
            $portfolioData['name'],
            $portfolioData['description'],
            $portfolioData['subject_id'],
            $studentId
        ]);

        return ['message' => 'Portfolio uploaded successfully'];
    }
}
