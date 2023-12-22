<?php

use Presentation\Http\Helpers\View;
use Primitives\Models\Event;
use Primitives\Models\Room;
use Primitives\Models\User;

/** @var Room $room */
/** @var Event[] $events */
/** @var User $user */
?>
<div class="container mx-auto form-container">
    <div class="cover-image-container">
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
        <div class="room-detail">
            <h1><?= $room->getCode() ?>: <?= $room->getName() ?></h1>
            <div class="d-flex text-capitalize" style="gap: 1rem">
                <p><strong>Capacity:</strong> <?= $room->getCapacity() ?></p>
                <p><strong>Floor:</strong> <?= $room->getFloor() ?></p>
                <p><strong>Side:</strong> <?= $room->getSide() ?></p>
            </div>
        </div>
    </div>
    <div class="bordered-container">
        <h1 class="form-title">Reservation Details</h1>
        <?= View::flashMessages() ?>
        <form class="reservation-container" method="post" action="/room/reserve">
            <div class="">
                <h2 class="coc-title">Code of Conduct</h2>
                <ul class="coc-list">
                    <li>When the event was over, the room was clean and tidy</li>
                    <li>Lights, air conditioning and projectors are turned off when finished using them</li>
                    <li>The number of seats when the event starts and when the event ends must be the same</li>
                    <li>No facilities were damaged or lost</li>
                </ul>
                <div class="coc-checkbox-container">
                    <input class="coc-checkbox" type="checkbox" id="coc-input" name="coc" required>
                    <label for="coc-input">I agree to the terms and conditions for renting a room</label>
                </div>
            </div>
            <div class="">
                <input type="text" value="<?= $room->getId() ?>" name="room_id" hidden>
                <input type="text" value="<?= $user->getId() ?>" name="user_id" hidden>
                <div class="mb-4 w-100">
                    <label for="title-input" class="form-label">Event Title</label>
                    <input type="text" class="input-text" id="title-input" name="title" required>
                </div>
                <div class="mb-4 w-100 event-form-input">
                    <div class="w-100">
                        <label for="start-date-input" class="form-label">Starts At</label>
                        <input type="datetime-local" class="input-text" id="start-date-input" name="start_date"
                               required>
                    </div>
                    <div class="w-100">
                        <label for="end-date-input" class="form-label">Ends At</label>
                        <input type="datetime-local" class="input-text" id="end-date-input" name="end_date" required>
                    </div>
                </div>
                <div class="mb-4 w-100">
                    <label for="description-input" class="form-label">Event Description</label>
                    <textarea class="input-text" id="description-input" name="description" required rows="6"></textarea>
                </div>
                <div>
                    <button class="coc-button primary-button" type="submit">Reserve</button>
                </div>
            </div>
        </form>
    </div>
</div>
