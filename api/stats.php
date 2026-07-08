<?php
declare(strict_types=1);

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../includes/functions.php';

header('Content-Type: application/json; charset=utf-8');

if (!is_admin_logged_in()) {
    http_response_code(401);
    echo json_encode(['message' => 'Unauthorized']);
    exit;
}

$totalVoters = (int) $pdo->query('SELECT COUNT(*) FROM users')->fetchColumn();
$voted = (int) $pdo->query("SELECT COUNT(*) FROM users WHERE status_vote = 'sudah'")->fetchColumn();
$notVoted = max(0, $totalVoters - $voted);
$totalVotes = (int) $pdo->query('SELECT COUNT(*) FROM votes')->fetchColumn();
$participation = $totalVoters > 0 ? round(($voted / $totalVoters) * 100, 2) : 0;

$stmt = $pdo->query('SELECT id, number, chair_name, vice_name, total_votes FROM candidates ORDER BY number ASC');
$candidates = [];

foreach ($stmt->fetchAll() as $candidate) {
    $candidateVotes = (int) $candidate['total_votes'];
    $candidates[] = [
        'id' => (int) $candidate['id'],
        'number' => (int) $candidate['number'],
        'chair_name' => $candidate['chair_name'],
        'vice_name' => $candidate['vice_name'],
        'total_votes' => $candidateVotes,
        'percentage' => $totalVotes > 0 ? round(($candidateVotes / $totalVotes) * 100, 2) : 0,
    ];
}

echo json_encode([
    'total_voters' => $totalVoters,
    'voted' => $voted,
    'not_voted' => $notVoted,
    'participation' => $participation,
    'candidates' => $candidates,
    'updated_at' => date('H:i:s'),
], JSON_THROW_ON_ERROR);
