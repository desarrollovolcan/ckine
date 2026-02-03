<div class="card">
    <div class="card-header">
        <h4 class="card-title mb-0">Editar profesional</h4>
        <small class="text-muted">ID profesional: <?php echo e($professionalId ?: 'Sin ID'); ?></small>
    </div>
    <div class="card-body">
        <form method="post" action="index.php?route=professionals/update&id=<?php echo e($professionalId); ?>">
            <input type="hidden" name="csrf_token" value="<?php echo csrf_token(); ?>">
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Nombre completo</label>
                    <input type="text" name="name" class="form-control" value="Dra. Paula Fuentes" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label">RUT</label>
                    <input type="text" name="rut" class="form-control" value="12.345.678-9" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Registro profesional</label>
                    <input type="text" name="license_number" class="form-control" value="KINE-2024-001" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Especialidad</label>
                    <input type="text" name="specialty" class="form-control" value="Kinesiología deportiva" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Correo</label>
                    <input type="email" name="email" class="form-control" value="paula.fuentes@example.com" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Teléfono</label>
                    <input type="text" name="phone" class="form-control" value="+56 9 2222 3344" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Estado</label>
                    <select name="status" class="form-select">
                        <option selected>Activo</option>
                        <option>En pausa</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Modalidad</label>
                    <select name="modality" class="form-select" required>
                        <option selected>Presencial</option>
                        <option>Mixta</option>
                        <option>Telemedicina</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Box asignado</label>
                    <select name="box" class="form-select">
                        <option selected>Box 1</option>
                        <option>Box 2</option>
                        <option>Box 3</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Horario habitual</label>
                    <input type="text" name="schedule" class="form-control" value="Lun a Vie 08:00 - 16:00" required>
                </div>
                <div class="col-12">
                    <label class="form-label">Notas</label>
                    <textarea name="notes" class="form-control" rows="3" placeholder="Disponibilidad, horarios, etc.">Disponible para turnos AM.</textarea>
                </div>
            </div>
            <div class="mt-4 d-flex gap-2 justify-content-end">
                <a href="index.php?route=professionals" class="btn btn-light">Cancelar</a>
                <button type="submit" class="btn btn-primary">Actualizar</button>
            </div>
        </form>
    </div>
</div>
