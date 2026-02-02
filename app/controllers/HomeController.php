<?php
namespace App\Controllers;

use App\Core\Auth;
use App\Core\Controller;

class HomeController extends Controller
{
    public function index(): void
    {
        if (Auth::check()) {
            $this->redirect('/dashboard');
        }
        $this->redirect('/auth/login');
    }
}
