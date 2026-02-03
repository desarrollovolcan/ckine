<?php

class ErrorController extends Controller
{
    public function forbidden(): void
    {
        $this->render('errors/403', [
            'title' => 'Acceso denegado',
            'subtitle' => 'Seguridad',
        ]);
    }

    public function notFound(): void
    {
        $this->render('errors/404', [
            'title' => 'Página no encontrada',
            'subtitle' => 'Navegación',
        ]);
    }
}
