<?php

class AppointmentsModel extends Model
{
    protected string $table = 'appointments';

    public function active(int $companyId): array
    {
        return $this->db->fetchAll(
            'SELECT appointments.*,
                    patients.name AS patient_name,
                    professionals.name AS professional_name,
                    boxes.name AS box_name
             FROM appointments
             LEFT JOIN patients ON appointments.patient_id = patients.id
             LEFT JOIN professionals ON appointments.professional_id = professionals.id
             LEFT JOIN boxes ON appointments.box_id = boxes.id
             WHERE appointments.deleted_at IS NULL
               AND appointments.company_id = :company_id
             ORDER BY appointments.appointment_date DESC, appointments.appointment_time DESC',
            ['company_id' => $companyId]
        );
    }

    public function findByCompany(int $companyId, int $id): ?array
    {
        return $this->db->fetch(
            'SELECT * FROM appointments WHERE id = :id AND company_id = :company_id AND deleted_at IS NULL',
            ['id' => $id, 'company_id' => $companyId]
        );
    }

    public function upcoming(int $companyId, int $limit = 6): array
    {
        return $this->db->fetchAll(
            'SELECT appointments.*,
                    patients.name AS patient_name,
                    professionals.name AS professional_name,
                    boxes.name AS box_name
             FROM appointments
             LEFT JOIN patients ON appointments.patient_id = patients.id
             LEFT JOIN professionals ON appointments.professional_id = professionals.id
             LEFT JOIN boxes ON appointments.box_id = boxes.id
             WHERE appointments.deleted_at IS NULL
               AND appointments.company_id = :company_id
             ORDER BY appointments.appointment_date ASC, appointments.appointment_time ASC
             LIMIT ' . (int)$limit,
            ['company_id' => $companyId]
        );
    }
}
