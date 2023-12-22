<?php

use Presentation\Http\Helpers\View;
use Primitives\Models\ApprovalStatus;
use Primitives\Models\Event;
use Primitives\Models\RoleName;
use Primitives\Models\User;

/** @var Event[] $events */
/** @var User $user */
?>

<div class="container mt-2">
    <div class="row mb-4">
        <div class="col-6">
            <h1 class="list-title">List of All Events</h1>
        </div>
    </div>
    <?= View::flashMessages() ?>
    <table class="table" id="rooms-table">
        <thead>
        <tr>
            <th scope="col">Title</th>
            <th scope="col">Description</th>
            <th scope="col">Starts At</th>
            <th scope="col">Ends At</th>
            <?php if ($user->getRole() !== RoleName::Student): ?>
                <th scope="col">Status</th>
            <?php endif; ?>
            <th scope="col" class="text-center">Action</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($events as $event): ?>

            <tr>
                <td class="text-truncate" style="max-width: 10rem"><?= $event->getTitle() ?></td>
                <td class="text-truncate" style="max-width: 12rem"><?= $event->getDescription() ?></td>
                <td><?= $event->getStartsAt()->format('Y-m-d') ?></td>
                <td><?= $event->getEndsAt()->format('Y-m-d') ?></td>
                <?php if ($user->getRole() !== RoleName::Student): ?>
                    <?php
                    $status = $event->getStatus($user->getId());
                    $badgeColor = match ($status) {
                        ApprovalStatus::Approved => "badge-success",
                        ApprovalStatus::Rejected => "badge-danger",
                        ApprovalStatus::Pending => "badge-pending",
                        default => "badge-secondary",
                    };
                    ?>
                    <td><span class="badge <?= $badgeColor ?>"><?= $status->value ?></span></td>
                <?php endif; ?>
                <td class="text-center d-flex justify-content-center">
                    <a
                            href="<?= View::route('event') ?>?id=<?= $event->getId() ?>"
                            class="button button-edit"
                    >
                        Detail
                    </a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>

<div
        class="modal fade"
        id="deleteRoomModal"
        tabindex="-1"
        aria-labelledby="delete_room_modal_label"
        data-bs-backdrop="static"
        data-bs-keyboard="false"
        aria-hidden="true"
>
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="deleteRoomModalLabel">Delete this room?</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>
                    This action is irreversible. Are you sure you want to delete this room? Any reservations made for
                    this room will be deleted as well. Please confirm.
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <form id="form" action="/rooms" method="post">
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    $(function () {
        const table = new DataTable('#rooms-table', {
            scrollY: '38rem'
        });

        const deleteRoomModal = document.getElementById('deleteRoomModal')
        deleteRoomModal.addEventListener('show.bs.modal', event => {
            const button = event.relatedTarget
            const roomId = button.getAttribute('data-bs-room-id')
            const modalForm = deleteRoomModal.querySelector('#form')
            modalForm.action = `/rooms?id=${roomId}&_method=DELETE`
        })
    })
</script>
