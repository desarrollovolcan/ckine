<?php

declare(strict_types=1);

class UserModel extends Model
{
    protected string $table = 'users';

    public function findByEmail(string $email): ?array
    {
        return $this->db->fetch(
            'SELECT u.*, r.name AS role FROM users u LEFT JOIN roles r ON r.id = u.role_id WHERE u.email = :email AND u.deleted_at IS NULL',
            ['email' => $email]
        );
    }

    public function allActive(): array
    {
        return $this->db->fetchAll('SELECT * FROM users WHERE deleted_at IS NULL ORDER BY id DESC');
    }
}
