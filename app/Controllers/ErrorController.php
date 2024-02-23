<?php

namespace App\Controllers;

// Classe gérant les erreurs (404, 403)
class ErrorController extends CoreController
{
    /**
     * Affichage de la page 404
     *
     * @return void
     */
    public function err404()
    {
        header('HTTP/1.0 404 Not Found');
        $this->show('error/err404');
    }

    /**
     * Affichage de la page 403
     *
     * @return void
     */
    public function err403()
    {
        header('HTTP/1.0 403 Forbidden');
        $this->show('error/err403');
    }
}
