<?php

global $auth;

$isLoggedIn = $auth->check();
$userFullName = $auth->fullName();

?>
<header class="site-header mb-5">
    <nav class="navbar navbar-expand-lg">
        <div class="container">

            <a class="navbar-brand text-white fw-bold fs-3" href="/">
                Note Manager
            </a>

            <div class="d-flex align-items-center gap-2">
                <?php if ($isLoggedIn): ?>

                    <span class="text-white">
                        <?= htmlspecialchars($userFullName) ?>
                    </span>
                    <a href="/?page=logout" class="btn btn-danger">
                        Logout
                    </a>

                <?php else: ?>

                    <a href="/?page=login" class="btn btn-primary login-btn">
                        Login / Signup
                    </a>

                <?php endif; ?>
            </div>
        </div>
    </nav>
</header>