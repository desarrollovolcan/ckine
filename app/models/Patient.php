<?php
namespace App\Models;

use App\Core\Model;

class Patient extends Model
{
    public function all(): array
    {
        return $this->db->query('SELECT * FROM patients ORDER BY created_at DESC')->fetchAll();
    }

    public function find(int $id): ?array
    {
        $stmt = $this->db->prepare('SELECT * FROM patients WHERE id = :id');
        $stmt->execute(['id' => $id]);
        $result = $stmt->fetch();
        return $result ?: null;
    }

    public function findByRutOrEmail(string $rut, ?string $email): ?array
    {
        $stmt = $this->db->prepare('SELECT * FROM patients WHERE rut = :rut OR email = :email LIMIT 1');
        $stmt->execute(['rut' => $rut, 'email' => $email]);
        $result = $stmt->fetch();
        return $result ?: null;
    }

    public function create(array $data): int
    {
        $stmt = $this->db->prepare('INSERT INTO patients (first_name, last_name, rut, birth_date, phone, email, address, insurance, emergency_contact, notes) VALUES (:first_name, :last_name, :rut, :birth_date, :phone, :email, :address, :insurance, :emergency_contact, :notes)');
        $stmt->execute($data);
        return (int) $this->db->lastInsertId();
    }

    public function update(int $id, array $data): void
    {
        $data['id'] = $id;
        $stmt = $this->db->prepare('UPDATE patients SET first_name = :first_name, last_name = :last_name, rut = :rut, birth_date = :birth_date, phone = :phone, email = :email, address = :address, insurance = :insurance, emergency_contact = :emergency_contact, notes = :notes WHERE id = :id');
        $stmt->execute($data);
    }

    public function delete(int $id): void
    {
        $stmt = $this->db->prepare('DELETE FROM patients WHERE id = :id');
        $stmt->execute(['id' => $id]);
    }
}
