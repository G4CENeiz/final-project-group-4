<?php

use Presentation\Http\Helpers\View;
use Primitives\Models\RoleName;
use Primitives\Models\User;

/** @var User $user */
?>

<nav class="sidenav">
    <ul class="sidenav-menu">
        <li>
            <img class="sidenav-logo" src="/jti-logo.png" alt="">
        </li>

        <li class="sidenav-item <?= View::activeClass('dashboard') ?>">
            <a href="<?= View::route('dashboard') ?>" class="sidenav-link">
                <svg width="48" height="48" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path
                            d="M12 38H18V26H30V38H36V20L24 11L12 20V38ZM8 42V18L24 6L40 18V42H26V30H22V42H8Z"
                            fill="currentColor"
                    />
                </svg>
            </a>
        </li>

        <?php if ($user->getRole() != RoleName::Approver): ?>
            <li class="sidenav-item <?= View::activeClass('room-list') ?>">
                <a href="<?= View::route('room-list') ?>" class="sidenav-link">
                    <svg width="48" height="48" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path
                                d="M6 26H10V22H6V26ZM6 34H10V30H6V34ZM6 18H10V14H6V18ZM14 26H42V22H14V26ZM14 34H42V30H14V34ZM14 14V18H42V14H14Z"
                                fill="currentColor"
                        />
                    </svg>
                </a>
            </li>
        <?php endif; ?>

        <li class="sidenav-item <?= View::activeClass('schedule') ?>">
            <a href="<?= View::route('schedule') ?>" class="sidenav-link">
                <svg width="48" height="48" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path
                            d="M30 44V40H38V20H10V28H6V12C6 10.9 6.392 9.958 7.176 9.174C7.96 8.39 8.90133 7.99867 10 8H12V4H16V8H32V4H36V8H38C39.1 8 40.042 8.392 40.826 9.176C41.61 9.96 42.0013 10.9013 42 12V40C42 41.1 41.608 42.042 40.824 42.826C40.04 43.61 39.0987 44.0013 38 44H30ZM16 48L13.2 45.2L18.35 40H2V36H18.35L13.2 30.8L16 28L26 38L16 48ZM10 16H38V12H10V16Z"
                            fill="currentColor"
                    />
                </svg>
            </a>
        </li>

        <?php if ($user->getRole() == RoleName::Administrator): ?>
            <li class="sidenav-item <?= View::activeClass('user-list') ?>">
                <a href="<?= View::route('user-list') ?>" class="sidenav-link">
                    <svg width="48" height="48" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path
                                d="M24 24C21.8 24 19.9167 23.2167 18.35 21.65C16.7833 20.0833 16 18.2 16 16C16 13.8 16.7833 11.9167 18.35 10.35C19.9167 8.78333 21.8 8 24 8C26.2 8 28.0833 8.78333 29.65 10.35C31.2167 11.9167 32 13.8 32 16C32 18.2 31.2167 20.0833 29.65 21.65C28.0833 23.2167 26.2 24 24 24ZM8 40V34.4C8 33.2667 8.292 32.2253 8.876 31.276C9.46 30.3267 10.2347 29.6013 11.2 29.1C13.2667 28.0667 15.3667 27.292 17.5 26.776C19.6333 26.26 21.8 26.0013 24 26C26.2 26 28.3667 26.2587 30.5 26.776C32.6333 27.2933 34.7333 28.068 36.8 29.1C37.7667 29.6 38.542 30.3253 39.126 31.276C39.71 32.2267 40.0013 33.268 40 34.4V40H8ZM12 36H36V34.4C36 34.0333 35.9087 33.7 35.726 33.4C35.5433 33.1 35.3013 32.8667 35 32.7C33.2 31.8 31.3833 31.1253 29.55 30.676C27.7167 30.2267 25.8667 30.0013 24 30C22.1333 30 20.2833 30.2253 18.45 30.676C16.6167 31.1267 14.8 31.8013 13 32.7C12.7 32.8667 12.458 33.1 12.274 33.4C12.09 33.7 11.9987 34.0333 12 34.4V36ZM24 20C25.1 20 26.042 19.6087 26.826 18.826C27.61 18.0433 28.0013 17.1013 28 16C28 14.9 27.6087 13.9587 26.826 13.176C26.0433 12.3933 25.1013 12.0013 24 12C22.9 12 21.9587 12.392 21.176 13.176C20.3933 13.96 20.0013 14.9013 20 16C20 17.1 20.392 18.042 21.176 18.826C21.96 19.61 22.9013 20.0013 24 20Z"
                                fill="currentColor"
                        />
                    </svg>
                </a>
            </li>
        <?php endif; ?>
    </ul>
</nav>