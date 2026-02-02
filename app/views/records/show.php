<?php use App\Core\CSRF; ?>
<h4 class="mb-3">Ficha de <?php echo htmlspecialchars(($patient['first_name'] ?? '') . ' ' . ($patient['last_name'] ?? ''), ENT_QUOTES, 'UTF-8'); ?></h4>
<div class="row">
    <div class="col-md-6">
        <h5>Evaluación inicial</h5>
        <?php if ($evaluation): ?>
            <p><strong>Motivo:</strong> <?php echo htmlspecialchars($evaluation['reason'], ENT_QUOTES, 'UTF-8'); ?></p>
            <p><strong>Antecedentes:</strong> <?php echo htmlspecialchars($evaluation['antecedentes'], ENT_QUOTES, 'UTF-8'); ?></p>
            <p><strong>Diagnóstico:</strong> <?php echo htmlspecialchars($evaluation['diagnosis'], ENT_QUOTES, 'UTF-8'); ?></p>
            <p><strong>Objetivos:</strong> <?php echo htmlspecialchars($evaluation['objectives'], ENT_QUOTES, 'UTF-8'); ?></p>
            <p><strong>Plan:</strong> <?php echo htmlspecialchars($evaluation['plan'], ENT_QUOTES, 'UTF-8'); ?></p>
        <?php else: ?>
            <form method="post" action="<?php echo $baseUrl; ?>records/<?php echo $patient['id']; ?>/evaluation">
                <input type="hidden" name="csrf_token" value="<?php echo CSRF::token(); ?>">
                <div class="mb-2">
                    <label class="form-label">Motivo consulta</label>
                    <textarea name="reason" class="form-control" required></textarea>
                </div>
                <div class="mb-2">
                    <label class="form-label">Antecedentes relevantes</label>
                    <textarea name="antecedentes" class="form-control"></textarea>
                </div>
                <div class="mb-2">
                    <label class="form-label">Diagnóstico funcional</label>
                    <textarea name="diagnosis" class="form-control"></textarea>
                </div>
                <div class="mb-2">
                    <label class="form-label">Objetivos</label>
                    <textarea name="objectives" class="form-control"></textarea>
                </div>
                <div class="mb-2">
                    <label class="form-label">Plan</label>
                    <textarea name="plan" class="form-control"></textarea>
                </div>
                <button class="btn btn-primary" type="submit">Guardar evaluación</button>
            </form>
        <?php endif; ?>
    </div>
    <div class="col-md-6">
        <h5>Evoluciones</h5>
        <form method="post" action="<?php echo $baseUrl; ?>records/<?php echo $patient['id']; ?>/evolutions">
            <input type="hidden" name="csrf_token" value="<?php echo CSRF::token(); ?>">
            <div class="mb-2">
                <label class="form-label">Notas</label>
                <textarea name="notes" class="form-control" required></textarea>
            </div>
            <div class="mb-2">
                <label class="form-label">Procedimientos</label>
                <textarea name="procedures" class="form-control"></textarea>
            </div>
            <div class="mb-2">
                <label class="form-label">Ejercicios</label>
                <textarea name="exercises" class="form-control"></textarea>
            </div>
            <button class="btn btn-secondary" type="submit">Agregar evolución</button>
        </form>
        <ul class="list-group mt-3">
            <?php foreach ($evolutions as $evolution): ?>
                <li class="list-group-item">
                    <strong><?php echo htmlspecialchars($evolution['created_at'], ENT_QUOTES, 'UTF-8'); ?></strong><br>
                    <?php echo nl2br(htmlspecialchars($evolution['notes'] ?? '', ENT_QUOTES, 'UTF-8')); ?>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</div>
<hr>
<h5>Adjuntos</h5>
<form method="post" action="<?php echo $baseUrl; ?>records/<?php echo $patient['id']; ?>/attachments" enctype="multipart/form-data">
    <input type="hidden" name="csrf_token" value="<?php echo CSRF::token(); ?>">
    <div class="input-group mb-3">
        <input type="file" name="attachment" class="form-control" required>
        <button class="btn btn-outline-secondary" type="submit">Subir</button>
    </div>
</form>
<ul class="list-group">
    <?php foreach ($attachments as $attachment): ?>
        <li class="list-group-item">
            <a href="<?php echo htmlspecialchars($attachment['file_path'], ENT_QUOTES, 'UTF-8'); ?>" target="_blank">
                <?php echo htmlspecialchars($attachment['file_name'], ENT_QUOTES, 'UTF-8'); ?>
            </a>
        </li>
    <?php endforeach; ?>
</ul>
