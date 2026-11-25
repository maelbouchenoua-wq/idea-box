<?php
require_once __DIR__ . '/config.php';

function get_card(int $userId = 0): array
{
    $stmt = getPDO()->prepare("
        SELECT info.*,
            info.createDate AS date,
            info.description AS descri,
            info.nbVote AS vote,
            EXISTS (
                SELECT 1 FROM votes
                WHERE votes.info_id = info.id AND votes.user_id = :user_id
            ) AS dejaVote
        FROM info
        ORDER BY info.createDate DESC, info.id DESC
    ");
    $stmt->execute(['user_id' => $userId]);
    return $stmt->fetchAll();
}
