<?php

namespace Presentation\Http\Controllers;

use Presentation\Http\Attributes\Authenticated;
use Presentation\Http\Attributes\Route;
use Presentation\Http\Attributes\WithSession;
use Presentation\Http\Helpers\Http;
use Presentation\Http\Helpers\Session;
use Primitives\Models\RoleName;

class AppController extends Controller
{
    public function __construct(private readonly Session $session)
    {
    }

    #[Route('/', 'GET')]
    #[WithSession]
    public function index(): void
    {
        switch ($this->session->user?->role) {
            case RoleName::Administrator:
                Http::redirect('/admin/dashboard');
                break;
            case RoleName::Approver:
                Http::redirect('/approver/dashboard');
                break;
            case RoleName::Student:
                Http::redirect('/student/dashboard');
                break;
            default:
                Http::redirect('/login');
                break;
        }
    }

    #[Route('/login', 'GET')]
    public function login()
    {
        $this->view('login', [
            '__layout_title__' => 'Login'
        ], false);
    }

    #[Route('/profile', 'GET')]
    #[Authenticated(RoleName::Administrator, RoleName::Approver, RoleName::Student)]
    public function profile(): void
    {
        $this->view('profile', [
            '__layout_title__' => 'Profile',
            'user' => $this->session->user,
        ]);
    }
}