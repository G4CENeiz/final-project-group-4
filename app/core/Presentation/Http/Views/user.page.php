<?php

use Presentation\Http\Helpers\View;
use Primitives\Models\RoleName;
use Primitives\Models\User;

/** @var User $user */
/** @var User $userDetail */
?>

<div class="container mx-auto form-container">
    <div class="cover-image-container">
        <a class="back-button" href="/admin/user-list">
            <svg width="48" height="48" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                <g id="material-symbols:arrow-back">
                    <path
                            id="Vector" d="M15.65 26L26.85 37.2L24 40L8 24L24 8L26.85 10.8L15.65 22H40V26H15.65Z"
                            fill="#020617"
                    />
                </g>
            </svg>
        </a>
    </div>
    <form class="bordered-container" method="POST" action="/users?_method=PUT" enctype="multipart/form-data">
        <h1 class="form-title">Edit User Detail</h1>
        <input type="text" value="<?= $userDetail->getId() ?>" name="id" hidden>
        <div class="input-container">
            <?= View::flashMessages() ?>
            <div class="mb-4 image-input">
                <svg id="camera-icon" xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24">
                    <path fill="#888888"
                          d="M12 18q2.075 0 3.538-1.462Q17 15.075 17 13q0-2.075-1.462-3.538Q14.075 8 12 8Q9.925 8 8.463 9.462Q7 10.925 7 13q0 2.075 1.463 3.538Q9.925 18 12 18Zm0-2q-1.25 0-2.125-.875T9 13q0-1.25.875-2.125T12 10q1.25 0 2.125.875T15 13q0 1.25-.875 2.125T12 16Zm6-6q.425 0 .712-.288Q19 9.425 19 9t-.288-.713Q18.425 8 18 8t-.712.287Q17 8.575 17 9t.288.712Q17.575 10 18 10ZM4 21q-.825 0-1.412-.587Q2 19.825 2 19V7q0-.825.588-1.412Q3.175 5 4 5h3.15L8.7 3.325q.15-.15.337-.238Q9.225 3 9.425 3h5.15q.2 0 .388.087q.187.088.337.238L16.85 5H20q.825 0 1.413.588Q22 6.175 22 7v12q0 .825-.587 1.413Q20.825 21 20 21Z"/>
                </svg>
                <img id="image-preview" src="/uploaded_images/user/<?= $userDetail->getAvatar() ?>" alt="Image Preview">
                <svg id="edit-icon" xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24">
                    <path fill="white"
                          d="M5 21q-.825 0-1.412-.587T3 19V5q0-.825.588-1.412T5 3h8.925l-2 2H5v14h14v-6.95l2-2V19q0 .825-.587 1.413T19 21zm4-6v-4.25l9.175-9.175q.3-.3.675-.45t.75-.15q.4 0 .763.15t.662.45L22.425 3q.275.3.425.663T23 4.4q0 .375-.137.738t-.438.662L13.25 15zM21.025 4.4l-1.4-1.4zM11 13h1.4l5.8-5.8l-.7-.7l-.725-.7L11 11.575zm6.5-6.5l-.725-.7zl.7.7z"/>
                </svg>
                <input id="image-input-file" type="file" name="avatar" accept="image/*">
            </div>
            <div class="mb-4 w-100">
                <label for="select-approver" class="event-detail-label form-label">Role</label>
                <select name="role" id="select-approver" class="input-text">
                    <option value="">Select Role</option>
                    <option value="STUDENT" <?= $userDetail->getRole() == RoleName::Student ? 'selected' : '' ?>>
                        Student
                    </option>
                    <option value="APPROVER" <?= $userDetail->getRole() == RoleName::Approver ? 'selected' : '' ?>>
                        Approver
                    </option>
                </select>
            </div>
            <div class="mb-4 w-100">
                <label for="fullname-input" class="form-label">Full Name</label>
                <input type="text" class="input-text" id="fullname-input" name="fullname" required
                       value="<?= $userDetail->getFullname() ?>">
            </div>
            <div class="mb-4 w-100">
                <label for="username-input" class="form-label">Username</label>
                <input type="text" class="input-text" id="username-input" name="username" required
                       value="<?= $userDetail->getUsername() ?>">
            </div>
            <div class="mb-4 w-100">
                <label for="phone-input" class="form-label">Phone</label>
                <input type="phone" class="input-text" id="phone-input" name="phone" required
                       value="<?= $userDetail->getPhone() ?>">
            </div>
            <div class="mb-4 w-100">
                <label for="registration-number-input" class="form-label">Registration Number</label>
                <input
                        type="text"
                        class="input-text"
                        id="registration-number-input"
                        name="registration_number"
                        minlength="10"
                        maxlength="10"
                        required
                        value="<?= $userDetail->getRegistrationNumber() ?>"
                >
            </div>
            <div class="mb-4 w-100">
                <label for="email-input" class="form-label">Email</label>
                <input type="text" class="input-text" id="email-input" name="email"
                       value="<?= $userDetail->getEmail() ?>">
            </div>
            <div class="row">
                <div class="col mb-4 w-100">
                    <label for="password-input" class="form-label">Password</label>
                    <div class="button-group">
                        <input
                                type="password"
                                class="input-text input-text-left"
                                id="password-input"
                                name="password"
                                minlength="8"
                        >
                        <button id="toggle-password" class="button-small button-right" type="button">
                            <svg id="eye-open" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                 viewBox="0 0 24 24" style="display: none">
                                <g fill="none" stroke="#888888" stroke-linecap="round" stroke-linejoin="round"
                                   stroke-width="2">
                                    <path d="M21.257 10.962c.474.62.474 1.457 0 2.076C19.764 14.987 16.182 19 12 19c-4.182 0-7.764-4.013-9.257-5.962a1.692 1.692 0 0 1 0-2.076C4.236 9.013 7.818 5 12 5c4.182 0 7.764 4.013 9.257 5.962"/>
                                    <circle cx="12" cy="12" r="3"/>
                                </g>
                            </svg>
                            <svg id="eye-closed" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                 viewBox="0 0 24 24">
                                <g fill="none" stroke="#888888" stroke-linecap="round" stroke-linejoin="round"
                                   stroke-width="2">
                                    <path d="M6.873 17.129c-1.845-1.31-3.305-3.014-4.13-4.09a1.693 1.693 0 0 1 0-2.077C4.236 9.013 7.818 5 12 5c1.876 0 3.63.807 5.13 1.874"/>
                                    <path d="M14.13 9.887a3 3 0 1 0-4.243 4.242M4 20L20 4M10 18.704A7.124 7.124 0 0 0 12 19c4.182 0 7.764-4.013 9.257-5.962a1.694 1.694 0 0 0-.001-2.078A22.939 22.939 0 0 0 19.57 9"/>
                                </g>
                            </svg>
                        </button>
                    </div>
                </div>
                <div class="col mb-4 w-100">
                    <label for="confirm-password-input" class="form-label">Confirm Password</label>
                    <div class="button-group">
                        <input
                                type="password"
                                class="input-text input-text-left"
                                id="confirm-password-input"
                                name="confirm_password"
                                minlength="8"
                        >
                        <button id="toggle-confirm-password" class="button-small button-right" type="button">
                            <svg id="eye-open" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                 viewBox="0 0 24 24" style="display: none">
                                <g fill="none" stroke="#888888" stroke-linecap="round" stroke-linejoin="round"
                                   stroke-width="2">
                                    <path d="M21.257 10.962c.474.62.474 1.457 0 2.076C19.764 14.987 16.182 19 12 19c-4.182 0-7.764-4.013-9.257-5.962a1.692 1.692 0 0 1 0-2.076C4.236 9.013 7.818 5 12 5c4.182 0 7.764 4.013 9.257 5.962"/>
                                    <circle cx="12" cy="12" r="3"/>
                                </g>
                            </svg>
                            <svg id="eye-closed" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                 viewBox="0 0 24 24">
                                <g fill="none" stroke="#888888" stroke-linecap="round" stroke-linejoin="round"
                                   stroke-width="2">
                                    <path d="M6.873 17.129c-1.845-1.31-3.305-3.014-4.13-4.09a1.693 1.693 0 0 1 0-2.077C4.236 9.013 7.818 5 12 5c1.876 0 3.63.807 5.13 1.874"/>
                                    <path d="M14.13 9.887a3 3 0 1 0-4.243 4.242M4 20L20 4M10 18.704A7.124 7.124 0 0 0 12 19c4.182 0 7.764-4.013 9.257-5.962a1.694 1.694 0 0 0-.001-2.078A22.939 22.939 0 0 0 19.57 9"/>
                                </g>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
            <div class="row mx-auto mt-4" style="gap: 1rem; max-width: 30rem">
                <button class="col button secondary-button">Cancel</button>
                <button class="col button primary-button">Save</button>
            </div>
        </div>
    </form>
</div>


<script>
    $(function () {
        const fileInputContainer = $('.image-input');
        const fileInput = $('#image-input-file');
        const imagePreview = $('#image-preview');
        const cameraIcon = $('#camera-icon');

        fileInput.on("click", function (e) {
            e.stopPropagation();
        });

        fileInput.on("change", function (e) {
            const file = e.target.files[0];

            if (file === null || file === undefined) {
                imagePreview.css('display', 'none');
                cameraIcon.css('display', 'block');
                return;
            }

            const reader = new FileReader();

            reader.onload = function (e) {
                imagePreview.attr('src', e.target.result);
                imagePreview.css('display', 'block');
                cameraIcon.css('display', 'none');
            };

            reader.readAsDataURL(file);
        });

        fileInputContainer.on("click", function () {
            fileInput.click();
        });

        // ====================
        const togglePassword = $('#toggle-password');
        const toggleConfirmPassword = $('#toggle-confirm-password');
        const passwordInput = $('#password-input');
        const confirmPasswordInput = $('#confirm-password-input');

        togglePassword.on('click', function () {
            const eyeOpen = togglePassword.find('#eye-open');
            const eyeClosed = togglePassword.find('#eye-closed');
            if (passwordInput.attr('type') === 'password') {
                passwordInput.attr('type', 'text');
                eyeOpen.show();
                eyeClosed.hide();
            } else {
                passwordInput.attr('type', 'password');
                eyeClosed.show();
                eyeOpen.hide();
            }
        });

        toggleConfirmPassword.on('click', function () {
            const eyeOpen = toggleConfirmPassword.find('#eye-open');
            const eyeClosed = toggleConfirmPassword.find('#eye-closed');
            if (confirmPasswordInput.attr('type') === 'password') {
                confirmPasswordInput.attr('type', 'text');
                eyeOpen.show();
                eyeClosed.hide();
            } else {
                confirmPasswordInput.attr('type', 'password');
                eyeClosed.show();
                eyeOpen.hide();
            }
        });
    });
</script>