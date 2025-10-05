<?php

declare(strict_types=1);

namespace App\Controller;

use App\Auth;
use App\Flash;

class LoginController extends Controller
{
    public function showForm(): void
    {
        $this->render('login.html.twig');
    }

    public function login(): void
    {
        $username = $_POST['username'] ?? '';
        $password = $_POST['password'] ?? '';

        if (Auth::login($username, $password)) {
            $location = 'news';
        } else {
            $location = 'login';
            Flash::set('Wrong Login Data!', 'error');
        }
        
        $this->redirect($location);
    }
    
    public function logout(): void
    {
        Auth::logout();
        $this->redirect('login');
    }
}
