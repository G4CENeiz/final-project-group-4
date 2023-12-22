<?php

use Presentation\Http\Helpers\View;
use Primitives\Models\RoleName;
use Primitives\Models\Room;
use Primitives\Models\User;

/** @var Room[] $rooms */
/** @var User $user */
?>
<div class="container mt-2">
    <div class="row mb-4">
        <div class="col-6">
            <h1 class="list-title">List of All Rooms</h1>
        </div>
        <?php if ($user->getRole() == RoleName::Administrator): ?>
            <div class="col-6">
                <a type="button" class="button info-button float-end" href="/admin/add-room">+ Add New Room</a>
            </div>
        <?php endif; ?>
    </div>
    <?= View::flashMessages() ?>
    <table class="table" id="rooms-table">
        <thead>
        <tr>
            <th scope="col" class="name-row">Code</th>
            <th scope="col">Name</th>
            <th scope="col">Capacity</th>
            <th scope="col">Floor</th>
            <th scope="col">Side</th>
            <th scope="col" class="text-center">Action</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($rooms as $room): ?>
            <tr>
                <td><?= $room->getCode() ?></td>
                <td><?= $room->getName() ?></td>
                <td><?= $room->getCapacity() ?></td>
                <td><?= $room->getFloor() ?></td>
                <td><?= $room->getSide() ?></td>
                <td class="text-center d-flex justify-content-center" style="gap: 0.5rem">
                    <?php if ($user->getRole() == RoleName::Student): ?>
                        <a href="/student/room?id=<?= $room->getId() ?>" class="button primary-button">Detail</a>
                    <?php else: ?>
                        <button
                                type="button" class="button danger-button"
                                data-bs-toggle="modal"
                                data-bs-target="#deleteRoomModal"
                                data-bs-room-id="<?= $room->getId() ?>"
                        >
                            Delete
                        </button>
                        <a href="/admin/room?id=<?= $room->getId() ?>" class="button primary-button">Edit</a>
                    <?php endif; ?>
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
                <button type="button" class="button secondary-button" data-bs-dismiss="modal">Close</button>
                <form id="form" action="/rooms" method="post">
                    <button type="submit" class="button danger-button">Delete</button>
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
