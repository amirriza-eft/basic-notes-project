<?php

?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="/assets/css/style.css" rel="stylesheet">
</head>
<body>

<?php include __DIR__ . '/../components/header.php'; ?>

<main class="page-content">
    <div class="container py-5">
        <div class="auth-card p-4 p-md-5">
            <h1 class="text-center auth-title mb-4">Sign Up</h1>

            <form method="POST" action="/?page=signup">
                <div class="mb-3">
                    <label class="form-label" for="full_name">Full Name</label>
                    <input
                        type="text"
                        id="full_name"
                        name="full_name"
                        class="form-control note-input"
                        placeholder="First and last name"
                        value=""
                        maxlength="255"
                        required
                    >
                </div>

                <div class="mb-3">
                    <label class="form-label" for="email">Email</label>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        class="form-control note-input"
                        placeholder="you@example.com"
                        value=""
                        required
                    >
                </div>

                <div class="mb-3">
                    <label class="form-label" for="password">Password</label>
                    <input
                        type="password"
                        id="password"
                        name="password"
                        class="form-control note-input"
                        placeholder="Choose a password"
                        required
                    >
                </div>

                <div class="mb-4">
                    <label class="form-label" for="confirm_password">Confirm Password</label>
                    <input
                        type="password"
                        id="confirm_password"
                        name="confirm_password"
                        class="form-control note-input"
                        placeholder="Repeat your password"
                        required
                    >
                </div>

                <button type="submit" class="btn btn-primary btn-add px-5 py-2 d-block mx-auto w-100">
                    Create Account
                </button>
            </form>

            <p class="text-center mt-4 mb-0 text-secondary">
                Already have an account?
                <a href="/?page=login" class="auth-link">Login</a>
            </p>
        </div>
    </div>
</main>

<?php include __DIR__ . '/../components/footer.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>