<?php

use Presentation\Http\Helpers\View;
use Primitives\Models\User;

/** @var User[] $users */
/** @var User $user */
?>
<div class="container mt-2">
    <div class="row mb-4">
        <div class="col-6">
            <h1 class="list-title">List of All Users</h1>
        </div>
        <div class="col-6">
            <a href="/admin/add-user" type="button" class="button info-button float-end">+ Add New User</a>
        </div>
    </div>

    <?= View::flashMessages() ?>

    <table class="table" id="users-table">
        <thead>
        <tr>
            <th scope="col" class="name-row">Email</th>
            <th scope="col">NIM</th>
            <th scope="col">Fullname</th>
            <th scope="col">Role</th>
            <th scope="col" class="text-center">Action</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($users as $u) { ?>
            <tr>
                <td><?= $u->getEmail() ?></td>
                <td><?= $u->getRegistrationNumber() ?></td>
                <td><?= $u->getFullname() ?></td>
                <td><?= $u->getRole()->name ?></td>
                <td class="text-center d-flex justify-content-center" style="gap: 0.5rem">
                    <?php if ($user->getId() !== $u->getId()) { ?>
                        <button
                                type="button" class="button danger-button"
                                data-bs-toggle="modal"
                                data-bs-target="#deleteUserModal"
                                data-bs-room-id="<?= $u->getId() ?>"
                        >
                            Delete
                        </button>
                    <?php } ?>
                    <a type="button" class="button primary-button" href="/admin/user?id=<?= $u->getId() ?>">Edit</a>
                </td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
</div>

<div
        class="modal fade"
        id="deleteUserModal"
        tabindex="-1"
        aria-labelledby="deleteUserModalLabel"
        data-bs-backdrop="static"
        data-bs-keyboard="false"
        aria-hidden="true"
>
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="deleteUserModalLabel">Delete this user?</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>
                    This action is irreversible. Are you sure you want to delete this user? Any reservations made by
                    this user will be deleted as well. Please confirm.
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="button secondary-button" data-bs-dismiss="modal">Close</button>
                <form id="form" action="/users" method="post">
                    <button type="submit" class="button danger-button">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    $(function () {
        const table = new DataTable('#users-table', {
            scrollY: '38rem'
        });

        const deleteUserModal = document.getElementById('deleteUserModal')
        deleteUserModal.addEventListener('show.bs.modal', event => {
            const button = event.relatedTarget
            const roomId = button.getAttribute('data-bs-room-id')
            const modalForm = deleteUserModal.querySelector('#form')
            modalForm.action = `/users?id=${roomId}&_method=DELETE`
        })
    })
</script>
