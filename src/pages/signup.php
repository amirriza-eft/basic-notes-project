<?php

$db = new DB();

$user = new User($db->getConnection());

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $fullName = trim($_POST['full_name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirmPassword = $_POST['confirm_password'] ?? '';

    $errors = [];

    if ($fullName === '') {
        $errors[] = 'Full name is required.';
    }

    if ($email === '') {
        $errors[] = 'Email is required.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Please enter a valid email address.';
    }

    if ($password === '') {
        $errors[] = 'Password is required.';
    } elseif (strlen($password) < 8) {
        $errors[] = 'Password must be at least 8 characters.';
    }

    if ($password !== $confirmPassword) {
        $errors[] = 'Passwords do not match.';
    }

    if (empty($errors)) {

        $existingUser = $user->findByEmail($email);

        if ($existingUser) {
            $errors[] = 'Email already exists.';
        } else {
            $user->create(
                    $fullName,
                    $email,
                    $password
            );

            header('Location: /?page=login&signup=success');
            exit;
        }
    }
}

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

            <?php if (!empty($errors)): ?>
                <div class="alert alert-danger">
                    <?php foreach ($errors as $error): ?>
                        <div><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

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