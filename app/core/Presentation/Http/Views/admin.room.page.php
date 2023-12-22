<?php

use Primitives\Models\Room;

/** @var Room $room */
?>
<div class="container mx-auto form-container">
    <div class="cover-image-container">
        <img class="cover-image" src="/uploaded_images/room/<?= $room->getImage() ?>" alt="<?= $room->getName() ?>"/>
        <div class="white-shadow"></div>
        <a class="back-button" href="/admin/room-list">
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
            <h1><?= $room->getCode() ?>: <?= $room->getName() ?></h1>
            <div class="d-flex text-capitalize" style="gap: 1rem">
                <p><strong>Capacity:</strong> <?= $room->getCapacity() ?></p>
                <p><strong>Floor:</strong> <?= $room->getFloor() ?></p>
                <p><strong>Side:</strong> <?= $room->getSide() ?></p>
            </div>
        </div>
    </div>
    <form class="bordered-container" method="post" action="/rooms?_method=PUT" enctype="multipart/form-data">
        <h1 class="form-title">Edit Room Details</h1>
        <input type="text" name="id" value="<?= $room->getId() ?>" hidden/>
        <div class="input-container">
            <div class="mb-4 w-100">
                <label for="name-input" class="form-label">Name</label>
                <input type="text" class="input-text" id="name-input" name="name" value="<?= $room->getName() ?>" required>
            </div>
            <div class="mb-4 w-100">
                <label for="code-input" class="form-label">Code</label>
                <input
                        type="text"
                        class="input-text"
                        id="code-input"
                        name="code"
                        value="<?= $room->getCode() ?>"
                        required
                        maxlength="4"
                >
            </div>
            <div class="row">
                <div class="col mb-4 w-100">
                    <label for="floor-input" class="form-label">Floor</label>
                    <input
                            type="number" class="input-text" id="floor-input" name="floor"
                            value="<?= $room->getFloor() ?>"
                            required
                    >
                </div>
                <div class="col mb-4 w-100">
                    <label for="side-input" class="form-label">Side</label>
                    <input
                            type="text" class="input-text" id="side-input" name="side"
                            value="<?= $room->getSide() ?>"
                            required
                    >
                </div>
                <div class="col mb-4 w-100">
                    <label for="capacity-input" class="form-label">Capacity</label>
                    <input
                            type="number" class="input-text" id="capacity-input" name="capacity"
                            value="<?= $room->getCapacity() ?>"
                            required
                    >
                </div>
            </div>
            <div class="mb-4 w-100">
                <label for="image-input" class="form-label">Image</label>
                <input type="file" class="input-text" id="image-input" name="image" value="<?= $room->getImage() ?>">
            </div>
            <div class="row mx-auto" style="gap: 1rem; max-width: 30rem">
                <button class="col button secondary-button">Cancel</button>
                <button class="col button primary-button">Save</button>
            </div>
        </div>
    </form>
</div>
