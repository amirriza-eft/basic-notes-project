<?php

$db = new DB();

$user = new User($db->getConnection());

$errors = array();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($email === '') {
        $errors[] = 'Email is required.';
    }

    if ($password === '') {
        $errors[] = 'Password is required.';
    }

    if (empty($errors)) {

        $loggedUser = $user->login($email, $password);

        if ($loggedUser) {

            $_SESSION['user_id'] = $loggedUser['id'];
            $_SESSION['user_name'] = $loggedUser['full_name'];
            $_SESSION['user_email'] = $loggedUser['email'];

            header('Location: /');
            exit;

        } else {

            $errors[] = 'Invalid email or password.';
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="/assets/css/style.css" rel="stylesheet">
</head>
<body>

<?php include __DIR__ . '/../components/header.php'; ?>

<main class="page-content">
    <div class="container py-5">
        <div class="auth-card p-4 p-md-5">
            <h1 class="text-center auth-title mb-4">Login</h1>

            <?php if (!empty($errors)): ?>
                <div class="alert alert-danger">
                    <?php foreach ($errors as $error): ?>
                        <div><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <form method="POST" action="/?page=login">
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
                            placeholder="Your password"
                            required
                    >
                </div>

                <div class="form-check mb-4">
                    <input
                            class="form-check-input"
                            type="checkbox"
                            name="remember_me"
                            id="remember_me"
                            value="1"
                    >
                    <label class="form-check-label" for="remember_me">Remember Me</label>
                </div>

                <button type="submit" class="btn btn-primary btn-add px-5 py-2 d-block mx-auto w-100">
                    Login
                </button>
            </form>

            <p class="text-center mt-4 mb-0 text-secondary">
                Don't have an account?
                <a href="/?page=signup" class="auth-link">Sign up</a>
            </p>
        </div>
    </div>
</main>

<?php include __DIR__ . '/../components/footer.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>