<?php

namespace Presentation\Http\Controllers;

use Business\Services\EventService;
use Business\Services\RoomService;
use Business\Services\UserService;
use Presentation\Http\Attributes\Authenticated;
use Presentation\Http\Attributes\Route;
use Presentation\Http\Attributes\WithSession;
use Presentation\Http\Helpers\Http;
use Presentation\Http\Helpers\Session;
use Primitives\Models\ApprovalStatus;
use Primitives\Models\RoleName;

class AdminViewController extends Controller
{
    public function __construct(
        private readonly Session      $session,
        private readonly UserService  $userService,
        private readonly RoomService  $roomService,
        private readonly EventService $eventService
    )
    {
    }

    #[Route('/admin/dashboard', 'GET')]
    #[WithSession]
    #[Authenticated(RoleName::Administrator)]
    public function dashboard(): void
    {
        $usersCount = $this->userService->getUsersCount();
        $roomsCount = $this->roomService->getRoomsCount();
        $pendingEventsCount = $this->eventService->getPendingEventsCount();
        $approvedEventsCount = $this->eventService->getApprovedEventsCount();
        $rejectedEventsCount = $this->eventService->getRejectedEventsCount();
        $this->view('dashboard', [
            '__layout_title__' => 'Dashboard',
            'user' => $this->session->user,
            'usersCount' => $usersCount,
            'roomsCount' => $roomsCount,
            'pendingEventsCount' => $pendingEventsCount,
            'approvedEventsCount' => $approvedEventsCount,
            'rejectedEventsCount' => $rejectedEventsCount
        ]);
    }

    #[Route('/admin/room-list', 'GET')]
    #[WithSession]
    #[Authenticated(RoleName::Administrator)]
    public function roomList(): void
    {
        $rooms = $this->roomService->getAllRooms();
        $this->view('room-list', [
            '__layout_title__' => 'Room List',
            'user' => $this->session->user,
            'rooms' => $rooms
        ]);
    }

    #[Route('/admin/room', 'GET')]
    #[WithSession]
    #[Authenticated(RoleName::Administrator)]
    public function roomDetail(): void
    {
        $id = Http::query('id');
        $room = $this->roomService->getRoomById($id);
        $this->view('admin.room', [
            '__layout_title__' => 'Room Detail',
            'user' => $this->session->user,
            'room' => $room
        ]);
    }

    #[Route('/admin/add-room', 'GET')]
    #[WithSession]
    #[Authenticated(RoleName::Administrator)]
    public function addRoom(): void
    {
        $this->view('admin.add-room', [
            '__layout_title__' => 'Add Room',
            'user' => $this->session->user
        ]);
    }

    #[Route('/admin/schedule', 'GET')]
    #[WithSession]
    #[Authenticated(RoleName::Administrator)]
    public function schedule(): void
    {
        $events = $this->eventService->getAllEvents();
        $this->view('schedule', [
            '__layout_title__' => 'Schedule',
            'user' => $this->session->user,
            'events' => $events
        ]);
    }

    #[Route('/admin/user-list', 'GET')]
    #[WithSession]
    #[Authenticated(RoleName::Administrator)]
    public function userList(): void
    {
        $users = $this->userService->getAllUsers();
        $this->view('admin.user-list', [
            '__layout_title__' => 'User List',
            'user' => $this->session->user,
            'users' => $users
        ]);
    }

    #[Route('/admin/add-user', 'GET')]
    #[WithSession]
    #[Authenticated(RoleName::Administrator)]
    public function addUser(): void
    {
        $this->view('admin.add-user', [
            '__layout_title__' => 'Add User',
            'user' => $this->session->user,
        ]);
    }

    #[Route('/admin/user', 'GET')]
    #[WithSession]
    #[Authenticated(RoleName::Administrator)]
    public function userDetail(): void
    {
        $id = Http::query('id');
        $user = $this->userService->getUserById($id);
        $this->view('user', [
            '__layout_title__' => 'User Detail',
            'user' => $this->session->user,
            'userDetail' => $user
        ]);
    }

    #[Route('/admin/event', 'GET')]
    #[WithSession]
    #[Authenticated(RoleName::Administrator)]
    public function eventDetail(): void
    {
        $id = Http::query('id');
        $event = $this->eventService->getEventById($id);
        $approvers = $this->userService->getAllApprovers();
        $isAllowedToApprove =
            // more than zero approvers have been assigned
            count($event->approvers) <= 0 ||
            // the user is an approver and the event is pending for their approval
            array_filter($event->approvers, fn($approver) => $approver->user->id === $this->session->user->id && $approver->status === ApprovalStatus::Pending);
        $this->view('event-detail', [
            '__layout_title__' => 'Schedule',
            'user' => $this->session->user,
            'event' => $event,
            'approvers' => $approvers,
            'isAllowedToApprove' => $isAllowedToApprove
        ]);
    }
}