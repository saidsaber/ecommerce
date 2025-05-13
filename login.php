<?php
session_start();
include("core/main.php");
if (isset($_SESSION['user'])):
    header("Location: index.php");
    exit;
else:
    ?>
    <!DOCTYPE html>
    <html lang="ar" dir="rtl">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>تسجيل الدخول</title>
        <!-- Bootstrap RTL -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.rtl.min.css">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
        <!-- Google Fonts - Tajawal -->
        <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700&display=swap" rel="stylesheet">
        <style>
            :root {
                --primary-color: #3498db;
                --secondary-color: #2c3e50;
                --accent-color: #e74c3c;
                --light-color: #f8f9fa;
                --dark-color: #343a40;
            }

            body {
                font-family: 'Tajawal', sans-serif;
                background-color: #f5f7fa;
                color: var(--secondary-color);
            }

            .login-container {
                display: flex;
                min-height: 100vh;
                align-items: center;
                justify-content: center;
                background: linear-gradient(135deg, rgba(52, 152, 219, 0.1), rgba(44, 62, 80, 0.1));
            }

            .login-card {
                width: 100%;
                max-width: 400px;
                border-radius: 15px;
                box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
                overflow: hidden;
                border: none;
            }

            .login-header {
                background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
                color: white;
                padding: 1.5rem;
                text-align: center;
            }

            .login-body {
                padding: 2rem;
                background-color: white;
            }

            .form-control {
                padding: 12px 15px;
                border-radius: 8px;
                margin-bottom: 1rem;
                border: 1px solid #ddd;
                transition: all 0.3s;
            }

            .form-control:focus {
                border-color: var(--primary-color);
                box-shadow: 0 0 0 0.25rem rgba(52, 152, 219, 0.25);
            }

            .btn-login {
                background-color: var(--primary-color);
                border: none;
                padding: 12px;
                font-weight: 500;
                width: 100%;
                border-radius: 8px;
                transition: all 0.3s;
            }

            .btn-login:hover {
                background-color: #2980b9;
                transform: translateY(-2px);
            }

            .input-group-text {
                background-color: #f8f9fa;
                border-right: none;
            }

            .input-with-icon {
                border-left: none;
            }

            .alert {
                border-radius: 8px;
            }

            .login-footer {
                text-align: center;
                padding: 1rem;
                background-color: #f8f9fa;
                border-top: 1px solid #eee;
            }

            .login-footer a {
                color: var(--primary-color);
                font-weight: 500;
            }

            .password-toggle {
                position: absolute;
                left: 15px;
                top: 50%;
                transform: translateY(-50%);
                cursor: pointer;
                color: #6c757d;
                z-index: 5;
            }

            .password-container {
                position: relative;
            }
        </style>
    </head>

    <body>
        <div class="login-container">
            <div class="login-card">
                <div class="login-header">
                    <h3><i class="fas fa-sign-in-alt me-2"></i>تسجيل الدخول</h3>
                </div>

                <div class="login-body">
                    <form method="post" action="headers/login.php">
                        <!-- Error Message -->
                        <div class="alert alert-danger text-center" role="alert"
                            style="display: <?= passOrMail() == null ? 'none' : 'block' ?>">
                            <i class="fas fa-exclamation-circle me-2"></i><?= passOrMail() ?>
                        </div>

                        <!-- Email Input -->
                        <div class="mb-3">
                            <label for="email" class="form-label">البريد الإلكتروني</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                <input type="text" class="form-control input-with-icon" id="email" name="email"
                                    placeholder="أدخل بريدك الإلكتروني" value="<?= old('email') ?>">
                            </div>
                            <div class="alert alert-danger mt-2" role="alert" style="display: <?= show('email') ?>">
                                <i class="fas fa-exclamation-circle me-2"></i><?= error('email') ?>
                            </div>
                        </div>

                        <!-- Password Input -->
                        <div class="mb-3">
                            <label for="password" class="form-label">كلمة المرور</label>
                            <div class="password-container">
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                    <input type="password" class="form-control input-with-icon" id="password"
                                        name="password" placeholder="أدخل كلمة المرور" value="<?= old('password') ?>">
                                    <span class="password-toggle" onclick="togglePassword()">
                                        <i class="fas fa-eye"></i>
                                    </span>
                                </div>
                                <div class="alert alert-danger mt-2" role="alert" style="display: <?= show('password') ?>">
                                    <i class="fas fa-exclamation-circle me-2"></i><?= error('password') ?>
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-login mt-3">
                            <i class="fas fa-sign-in-alt me-2"></i>تسجيل الدخول
                        </button>
                    </form>
                </div>

                <div class="login-footer">
                    <p class="mb-0">لا تملك حساباً؟ <a href="register.php">إنشاء حساب جديد</a></p>
                </div>
            </div>
        </div>

        <script>
            function togglePassword() {
                const passwordInput = document.getElementById('password');
                const toggleIcon = document.querySelector('.password-toggle i');

                if (passwordInput.type === 'password') {
                    passwordInput.type = 'text';
                    toggleIcon.classList.replace('fa-eye', 'fa-eye-slash');
                } else {
                    passwordInput.type = 'password';
                    toggleIcon.classList.replace('fa-eye-slash', 'fa-eye');
                }
            }
        </script>

        <!-- Bootstrap JS Bundle with Popper -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    </body>

    </html>
<?php endif;
$_SESSION['error'] = null ?>