<?php

use Primitives\Models\Event;
use Primitives\Models\Room;

/** @var Room $room */
/** @var Event[] $events */
?>
<div class="container mx-auto form-container">
    <div class="cover-image-container" style="height: 28rem">
        <img
                class="cover-image" src="/uploaded_images/room/<?= $room->getImage() ?>" alt="<?= $room->getName() ?>"
                style="top: 0"
        />
        <div class="white-shadow"></div>
        <a class="back-button" href="/student/room-list">
            <svg width="48" height="48" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                <g id="material-symbols:arrow-back">
                    <path
                            id="Vector"
                            d="M15.65 26L26.85 37.2L24 40L8 24L24 8L26.85 10.8L15.65 22H40V26H15.65Z"
                            fill="white"
                    />
                </g>
            </svg>
        </a>
        <div class="room-detail-container">
            <div class="room-detail">
                <h1><?= $room->getCode() ?>: <?= $room->getName() ?></h1>
                <div class="d-flex text-capitalize" style="gap: 1rem">
                    <p><strong>Capacity:</strong> <?= $room->getCapacity() ?></p>
                    <p><strong>Floor:</strong> <?= $room->getFloor() ?></p>
                    <p><strong>Side:</strong> <?= $room->getSide() ?></p>
                </div>
            </div>
            <a href="/student/room/reserve?id=<?= $room->getId() ?>" class="button primary-button">Book</a>
        </div>
    </div>
    <div class="bordered-container">
        <table class="table" id="rooms-table">
            <thead>
            <tr>
                <th scope="col">Title</th>
                <th scope="col">Description</th>
                <th scope="col">Starts At</th>
                <th scope="col">Ends At</th>
            </tr>
            </thead>
            <tbody>
            <?php if (empty($events)): ?>
                <tr>
                    <td colspan="4" class="text-center" style="padding-block: 1.5rem">No events for this room</td>
                </tr>
            <?php else: ?>
                <?php foreach ($events as $event): ?>
                    <tr>
                        <td><?= $event->getTitle() ?></td>
                        <td><?= $event->getDescription() ?></td>
                        <td><?= $event->getStartsAt()->format('d-m-Y H:i:s') ?></td>
                        <td><?= $event->getEndsAt()->format('d-m-Y H:i:s') ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
