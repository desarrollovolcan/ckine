<?php $calendarEvents = $calendarEvents ?? []; ?>

<div class="row g-3">
    <div class="col-lg-8">
        <div class="card h-100">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="card-title mb-0">Calendario de citas</h4>
                <a href="index.php?route=appointments/create" class="btn btn-primary">Nueva cita</a>
            </div>
            <div class="card-body">
                <div id="appointments-calendar"></div>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title mb-0">Resumen del día</h4>
            </div>
            <div class="card-body">
                <p class="text-muted">Citas programadas para hoy.</p>
                <?php if (empty($todayAppointments)): ?>
                    <p class="text-muted mb-0">No hay citas para hoy.</p>
                <?php else: ?>
                    <ul class="list-group list-group-flush">
                        <?php foreach ($todayAppointments as $appointment): ?>
                            <li class="list-group-item d-flex flex-column gap-1">
                                <span class="fw-semibold"><?php echo e($appointment['appointment_time'] ?? ''); ?> · <?php echo e($appointment['patient_name'] ?? ''); ?></span>
                                <span class="text-muted fs-xs">
                                    <?php echo e($appointment['professional_name'] ?? ''); ?>
                                    · <?php echo e($appointment['box_name'] ?? 'Sin box'); ?>
                                </span>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="appointment-modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detalle de la cita</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                <div class="mb-2">
                    <div class="text-muted fs-xs">Paciente</div>
                    <div class="fw-semibold" data-appointment-patient></div>
                </div>
                <div class="mb-2">
                    <div class="text-muted fs-xs">Profesional</div>
                    <div class="fw-semibold" data-appointment-professional></div>
                </div>
                <div class="mb-2">
                    <div class="text-muted fs-xs">Fecha y hora</div>
                    <div class="fw-semibold" data-appointment-datetime></div>
                </div>
                <div class="mb-2">
                    <div class="text-muted fs-xs">Box</div>
                    <div class="fw-semibold" data-appointment-box></div>
                </div>
                <div class="mb-2">
                    <div class="text-muted fs-xs">Estado</div>
                    <div class="fw-semibold" data-appointment-status></div>
                </div>
                <div>
                    <div class="text-muted fs-xs">Notas</div>
                    <div class="text-muted" data-appointment-notes>Sin notas.</div>
                </div>
            </div>
            <div class="modal-footer">
                <a class="btn btn-outline-primary" data-appointment-edit href="#">Editar</a>
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<script src="assets/plugins/fullcalendar/index.global.min.js"></script>
<script>
    window.appointmentsCalendar = <?php echo json_encode($calendarEvents, JSON_UNESCAPED_UNICODE); ?>;
</script>
<script>
    (function () {
        const calendarEl = document.getElementById('appointments-calendar');
        if (!calendarEl) {
            return;
        }
        const modalElement = document.getElementById('appointment-modal');
        const modal = modalElement ? new bootstrap.Modal(modalElement) : null;
        const modalFields = {
            patient: modalElement?.querySelector('[data-appointment-patient]'),
            professional: modalElement?.querySelector('[data-appointment-professional]'),
            datetime: modalElement?.querySelector('[data-appointment-datetime]'),
            box: modalElement?.querySelector('[data-appointment-box]'),
            status: modalElement?.querySelector('[data-appointment-status]'),
            notes: modalElement?.querySelector('[data-appointment-notes]'),
            edit: modalElement?.querySelector('[data-appointment-edit]'),
        };

        const escapeHtml = (value) => String(value ?? '')
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#39;');

        const calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            themeSystem: 'bootstrap',
            height: 640,
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay'
            },
            buttonText: {
                today: 'Hoy',
                month: 'Mes',
                week: 'Semana',
                day: 'Día',
                prev: 'Anterior',
                next: 'Siguiente'
            },
            events: window.appointmentsCalendar || [],
            eventDidMount: function (info) {
                const props = info.event.extendedProps || {};
                const tooltipContent = `
                    <div class="fw-semibold">${escapeHtml(props.patient)}</div>
                    <div class="text-muted fs-xs">${escapeHtml(props.professional)}</div>
                    <div class="text-muted fs-xs">${escapeHtml(props.date)} ${escapeHtml(props.time)}</div>
                    <div class="text-muted fs-xs">${escapeHtml(props.box)}</div>
                    <div class="text-muted fs-xs">${escapeHtml(props.status)}</div>
                `;
                new bootstrap.Tooltip(info.el, {
                    title: tooltipContent,
                    html: true,
                    placement: 'top',
                    container: 'body'
                });
            },
            eventClick: function (info) {
                if (!modal) {
                    return;
                }
                const props = info.event.extendedProps || {};
                if (modalFields.patient) {
                    modalFields.patient.textContent = props.patient || '';
                }
                if (modalFields.professional) {
                    modalFields.professional.textContent = props.professional || '';
                }
                if (modalFields.datetime) {
                    modalFields.datetime.textContent = `${props.date || ''} ${props.time || ''}`.trim();
                }
                if (modalFields.box) {
                    modalFields.box.textContent = props.box || 'Sin box';
                }
                if (modalFields.status) {
                    modalFields.status.textContent = props.status || '';
                }
                if (modalFields.notes) {
                    modalFields.notes.textContent = props.notes || 'Sin notas.';
                }
                if (modalFields.edit) {
                    modalFields.edit.setAttribute('href', props.editUrl || '#');
                }
                modal.show();
            }
        });

        calendar.render();
    })();
</script>
