<?php

use Presentation\Http\Helpers\View;
use Primitives\Models\ApprovalStatus;
use Primitives\Models\Event;
use Primitives\Models\RoleName;
use Primitives\Models\User;

/** @var Event $event */
/** @var User[] $approvers */
/** @var User $user */
/** @var bool $isAllowedToApprove */

?>
<div class="container mx-auto form-container">
    <div class="cover-image-container">
        <img class="cover-image" src="/uploaded_images/room/<?= $event->getRoom()->getImage() ?>"
             alt="<?= $event->getRoom()->getName() ?>"/>
        <div class="white-shadow"></div>
        <a class="back-button" href="<?= View::route('schedule') ?>">
            <svg width="48" height="48" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                <g id="material-symbols:arrow-back">
                    <path
                            id="Vector" d="M15.65 26L26.85 37.2L24 40L8 24L24 8L26.85 10.8L15.65 22H40V26H15.65Z"
                            fill="white"
                    />
                </g>
            </svg>
        </a>
        <div class="room-detail">
            <h1><?= $event->getRoom()->getCode() ?>: <?= $event->getRoom()->getName() ?></h1>
            <div class="d-flex text-capitalize" style="gap: 1rem">
                <p><strong>Capacity:</strong> <?= $event->getRoom()->getCapacity() ?></p>
                <p><strong>Floor:</strong> <?= $event->getRoom()->getFloor() ?></p>
                <p><strong>Side:</strong> <?= $event->getRoom()->getSide() ?></p>
            </div>
        </div>
    </div>
    <form class="bordered-container" method="post"
          action="/event/<?= $user->getRole() == RoleName::Administrator ? 'assign-approver' : 'approve' ?>?id=<?= $event->getId() ?>">
        <h1 class="form-title">Event Details</h1>
        <div class="input-container">
            <div class="event-detail-item">
                <span class="event-detail-label">Full Name</span>
                <span><?= $event->getPic()->getFullname() ?></span>
            </div>
            <div class="event-detail-item">
                <span class="event-detail-label">Event Name</span>
                <span><?= $event->getTitle() ?></span>
            </div>
            <div class="event-detail-item">
                <span class="event-detail-label">Starts At</span>
                <span><?= $event->getStartsAt()->format('D, d M Y H:i:s') ?></span>
            </div>
            <div class="event-detail-item">
                <span class="event-detail-label">Ends At</span>
                <span><?= $event->getEndsAt()->format('D, d M Y H:i:s') ?></span>
            </div>
            <div class="event-detail-item event-description">
                <span class="event-detail-label">Event Details</span>
                <p>
                    <?= $event->getDescription() ?>
                </p>
            </div>
            <!-- Dynamic Form to add approver using a dropdown select -->
            <div class="event-approver">
                <label for="select-approver" class="event-detail-label">Approver</label>
                <?php if ($user->getRole() == RoleName::Administrator): ?>
                    <?php if (count($event->getApprovers()) <= 0): ?>
                        <div class="event-approver-input">
                            <select name="approver" id="select-approver" class="input-text">
                                <?php foreach ($approvers as $approver): ?>
                                    <option value="<?= $approver->getId() ?>"><?= $approver->getFullname() ?></option>
                                <?php endforeach; ?>
                            </select>
                            <button class="button primary-button" id="event-approver-button" type="button"
                                    style="font-size: 1rem">
                                Add
                            </button>
                        </div>
                        <small>This will be requested in the order they're added</small>
                    <?php endif; ?>
                <?php endif; ?>
                <div class="approver-list" id="approver-list">
                    <?php if (count($event->getApprovers()) > 0): ?>
                        <?php foreach ($event->getApprovers() as $approver): ?>
                            <?php
                            $badgeColor = "";
                            switch ($approver->getStatus()) {
                                case ApprovalStatus::Approved:
                                    $badgeColor = "badge-success";
                                    break;
                                case ApprovalStatus::Rejected:
                                    $badgeColor = "badge-danger";
                                    break;
                                case ApprovalStatus::Pending:
                                    $badgeColor = "badge-pending";
                                    break;
                            }
                            ?>
                            <div class="approver-item-wrapper">
                                <div class="approver-item">
                                    <span><?= $approver->getUser()->getFullname() ?></span>
                                    <span class="badge <?= $badgeColor ?>"
                                          style="font-size: 0.95rem"><?= $approver->getStatus()->value ?></span>
                                </div>
                                <p><?= $approver->getReason() ?></p>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>

            <?php if ($isAllowedToApprove):
                ?>
                <div class="row mx-auto" style="gap: 1rem; max-width: 30rem">
                    <button
                            type="button" class="col button danger-button"
                            data-bs-toggle="modal"
                            data-bs-target="#rejectRequestModal"
                            data-bs-event-id="<?= $event->getId() ?>"
                    >
                        Reject
                    </button>
                    <button class="col button primary-button">Approve</button>
                </div>
            <?php endif; ?>
        </div>
    </form>
</div>

<div
        class="modal fade"
        id="rejectRequestModal"
        tabindex="-1"
        aria-labelledby="rejectRequestModalLabel"
        data-bs-backdrop="static"
        data-bs-keyboard="false"
        aria-hidden="true"
>
    <div class="modal-dialog">
        <form class="modal-content" action="/event/reject" id="form" method="post">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="rejectRequestModalLabel">Reject Request</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="w-100">
                    <label for="reason-input" class="form-label">Reason for Rejection</label>
                    <textarea class="input-text" id="reason-input" name="reason" required rows="6"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="button secondary-button" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="button danger-button">Reject</button>
            </div>
        </form>
    </div>
</div>

<script>
    $(function () {
        // append approver
        const addButton = $('#event-approver-button');
        const approverList = $('#approver-list');
        const selectApprover = $('#select-approver');

        addButton.click(function () {
            const approverId = selectApprover.val();
            const approverName = selectApprover.find(`option[value="${approverId}"]`).text();
            const approver = $(`
                <div class="approver-item">
                    <input type="hidden" name="approvers[]" value="${approverId}">
                    <span>${approverName}</span>
                    <button class="button-small danger-button" type="button">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                             xmlns="http://www.w3.org/2000/svg">
                            <g id="material-symbols:close">
                                <path id="Vector"
                                      d="M18 6L12 12L18 18L16.8 19.2L12 14.4L7.2 19.2L6 18L12 12L6 6L7.2 4.8L12 9.6L16.8 4.8L18 6Z"
                                      fill="white"/>
                            </g>
                        </svg>
                    </button>
                </div>
            `);
            approver.find('button').click(function () {
                approver.remove();
                // restore approver to select
                selectApprover.append(`<option value="${approverId}">${approverName}</option>`);
            });
            approverList.append(approver);
            // remove approver from select
            selectApprover.find(`option[value="${approverId}"]`).remove();
        });

        const deleteUserModal = document.getElementById('rejectRequestModal')
        deleteUserModal.addEventListener('show.bs.modal', event => {
            const button = event.relatedTarget
            const roomId = button.getAttribute('data-bs-event-id')
            const modalForm = deleteUserModal.querySelector('#form')
            modalForm.action = `/event/reject?id=${roomId}`
        })
    })
</script>