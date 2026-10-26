<?php
require 'core/config.php';
if (isAdmin()) {
    redirectTo('admin.php');
    exit;
}
if (isUser() === true) {
    redirectTo('');
    exit;
}
$brand = "merekaam";
$brand_name = "Mere Kaam";
$crmName = "Mere Kaam CRM";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title><?php echo $brand; ?></title>
    <link rel="shortcut icon" href="assets/images/<?php echo strtolower($brand); ?>.png">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php include "temp-parts/head.php"; ?>
</head>

<body class="app app-login p-0">
    <canvas id="canv" style="position: absolute;height: 100vh;width: 100%;"></canvas>
    <div class="wrapper">
        <section class="login-content">
            <div class="row m-0 align-items-center bg-white vh-100">
                <div class="col-md-6">
                    <div class="row justify-content-center">
                        <div class="col-md-10">
                            <div class="card card-transparent shadow-none d-flex justify-content-center mb-0 auth-card">
                                <div class="card-body">
                                    <a href="index.php" class="navbar-brand d-flex align-items-center mb-3">
                                        <!--Logo start-->
                                        <div class="logo-main">
                                            <div class="logo-normal">
                                                <svg class="text-primary icon-30" viewBox="0 0 64 64"
                                                    xmlns="http://www.w3.org/2000/svg" fill="none">
                                                    <!-- Briefcase -->
                                                    <rect x="8" y="24" width="48" height="28" rx="4" fill="currentColor"
                                                        opacity="0.8" />
                                                    <rect x="20" y="18" width="24" height="8" rx="2"
                                                        fill="currentColor" />
                                                    <rect x="28" y="14" width="8" height="4" rx="1"
                                                        fill="currentColor" />

                                                    <!-- Clipboard -->
                                                    <rect x="12" y="6" width="20" height="28" rx="2" fill="white"
                                                        stroke="currentColor" stroke-width="2" />
                                                    <rect x="14" y="10" width="16" height="4" rx="1"
                                                        fill="currentColor" />
                                                    <line x1="14" y1="18" x2="28" y2="18" stroke="currentColor"
                                                        stroke-width="2" />
                                                    <line x1="14" y1="24" x2="28" y2="24" stroke="currentColor"
                                                        stroke-width="2" />

                                                    <!-- Checkmark -->
                                                    <path d="M20 34 L26 40 L36 28" stroke="currentColor"
                                                        stroke-width="3" fill="none" stroke-linecap="round"
                                                        stroke-linejoin="round" />
                                                </svg>

                                            </div>
                                            <div class="logo-mini">
                                                <svg class="text-primary icon-30" viewBox="0 0 64 64"
                                                    xmlns="http://www.w3.org/2000/svg" fill="none">
                                                    <!-- Briefcase -->
                                                    <rect x="8" y="24" width="48" height="28" rx="4" fill="currentColor"
                                                        opacity="0.8" />
                                                    <rect x="20" y="18" width="24" height="8" rx="2"
                                                        fill="currentColor" />
                                                    <rect x="28" y="14" width="8" height="4" rx="1"
                                                        fill="currentColor" />

                                                    <!-- Clipboard -->
                                                    <rect x="12" y="6" width="20" height="28" rx="2" fill="white"
                                                        stroke="currentColor" stroke-width="2" />
                                                    <rect x="14" y="10" width="16" height="4" rx="1"
                                                        fill="currentColor" />
                                                    <line x1="14" y1="18" x2="28" y2="18" stroke="currentColor"
                                                        stroke-width="2" />
                                                    <line x1="14" y1="24" x2="28" y2="24" stroke="currentColor"
                                                        stroke-width="2" />

                                                    <!-- Checkmark -->
                                                    <path d="M20 34 L26 40 L36 28" stroke="currentColor"
                                                        stroke-width="3" fill="none" stroke-linecap="round"
                                                        stroke-linejoin="round" />
                                                </svg>

                                            </div>
                                        </div>
                                        <!--logo End-->

                                        <h4 class="logo-title ms-3">MereKaam</h4>
                                    </a>
                                    <h2 class="mb-2 text-center">Sign In</h2>
                                    <p class="text-center">Login to stay connected.</p>
                                    <ul class="nav nav-tabs mb-3" id="loginTabs" role="tablist">
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link active" id="email-tab" data-bs-toggle="tab"
                                                data-bs-target="#emailLogin" type="button" role="tab"><i
                                                    class="fa fa-lock"></i>
                                                Email</button>
                                        </li>
                                        <!-- <li class="nav-item" role="presentation">
                                            <button class="nav-link " id="mobile-tab" data-bs-toggle="tab"
                                                data-bs-target="#mobileLogin" type="button" role="tab"><i
                                                    class="fa fa-phone"></i> Mobile</button>
                                        </li> -->
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link" id="forgot-tab" data-bs-toggle="tab"
                                                data-bs-target="#forgotPassword" type="button" role="tab"><i
                                                    class="fa fa-key"></i> Forgot Password</button>
                                        </li>

                                    </ul>

                                    <div class="tab-content" id="loginTabContent">

                                        <!-- Email Login -->
                                        <div class="tab-pane fade show active" id="emailLogin" role="tabpanel">
                                            <form id="loginForm">
                                                <div class="mb-3">
                                                    <label>Email</label>
                                                    <input type="email" class="form-control" id="loginEmail"
                                                        name="email" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label>Password</label>
                                                    <input type="password" name="password" class="form-control"
                                                        id="loginPassword" required>
                                                </div>
                                                <div class="mb-3 form-check">
                                                    <input class="form-check-input" type="checkbox"
                                                        id="RememberPassword">
                                                    <label class="form-check-label" for="RememberPassword">Remember
                                                        me</label>
                                                </div>
                                                <div class="d-grid">
                                                    <button type="submit" class="btn btn-primary btn-lg"><i
                                                            class="fa fa-lock"></i>
                                                        Login</button>
                                                </div>
                                            </form>
                                        </div>
                                        <div class="tab-pane fade" id="forgotPassword" role="tabpanel">
                                            <form id="forgotForm">
                                                <div class="mb-3">
                                                    <label>Email</label>
                                                    <input type="email" class="form-control" id="forgotEmail"
                                                        name="email" required>
                                                </div>
                                                <div class="d-grid">
                                                    <button type="submit" class="btn btn-warning"><i
                                                            class="fa fa-envelope"></i>
                                                        Send Reset
                                                        Link</button>
                                                </div>
                                                <div class="mt-3 text-end">
                                                    <a href="#" onclick="$('#email-tab').click()">Back to
                                                        Login</a>
                                                </div>
                                            </form>
                                        </div>
                                        <div class="auth-footer row">
                                            <div class="col my-1">
                                                <p class="m-0">Copyright © 2026 <a href="" class="">
                                                        <?php echo $crmName; ?>
                                                    </a></p>

                                            </div>
                                            <div class="col-auto my-1">
                                                <p class="">
                                                    <small class="copyright">Developed <i class="fa fa-heart"
                                                            style="color: #fb866a;"></i> by <a class="app-link"
                                                            href="mailto:rahulphp6@gmail.com" target="_blank">
                                                            <?php echo $crmName; ?>
                                                        </a></small>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="sign-bg">
                        <svg width="280" height="230" viewBox="0 0 431 398" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <g opacity="0.05">
                                <rect x="-157.085" y="193.773" width="543" height="77.5714" rx="38.7857"
                                    transform="rotate(-45 -157.085 193.773)" fill="#3B8AFF" />
                                <rect x="7.46875" y="358.327" width="543" height="77.5714" rx="38.7857"
                                    transform="rotate(-45 7.46875 358.327)" fill="#3B8AFF" />
                                <rect x="61.9355" y="138.545" width="310.286" height="77.5714" rx="38.7857"
                                    transform="rotate(45 61.9355 138.545)" fill="#3B8AFF" />
                                <rect x="62.3154" y="-190.173" width="543" height="77.5714" rx="38.7857"
                                    transform="rotate(45 62.3154 -190.173)" fill="#3B8AFF" />
                            </g>
                        </svg>

                    </div>
                </div>
                <div class="col-md-6 d-md-block d-none bg-primary p-0 mt-n1 vh-100 overflow-hidden">
                    <img src="images/pos-login.png" class="img-fluid gradient-main animated-scaleX" alt="images"
                        style="opacity: 0.4;">
                </div>
            </div>
        </section>
    </div>
    <!-- Toast Container -->
    <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 9999">
        <div id="liveToast" class="toast align-items-center text-white bg-success border-0" role="alert">
            <div class="d-flex">
                <div class="toast-body" id="toastMessage">Success</div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
            </div>
        </div>
    </div>
    <!-- jQuery -->
    <script src="plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 to 5 -->
    <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="dist/js/adminlte.min.js"></script>
    <!-- SweetAlert2 -->
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- toaster -->
    <script src="plugins/toastr/toastr.min.js"></script>
    <script>
        function showOverlay() {
            $('.overlay').removeClass('d-none');
        }

        function hideOverlay() {
            $('.overlay').addClass('d-none');
        }
        hideOverlay();
        // Login
        $('#loginForm').submit(function (e) {
            e.preventDefault();

            const email = $('#loginEmail').val().trim();
            const password = $('#loginPassword').val();

            if (!email || !password) {
                boom('Please enter both email and password', 'warning', true);
                return;
            }

            showOverlay(); // 🔹 Moved outside $.post to trigger immediately

            $.post(BASE_URL + 'model/login.php', { email, password }, function (res) {
                try {
                    const data = typeof res === 'string' ? JSON.parse(res) : res;

                    if (data.success) {
                        let redirectUrl = BASE_URL;
                        if (data.role > 0 && data.role < 3) {
                            redirectUrl += 'admin.php';
                        } else if (data.contact_id) {
                            redirectUrl = PDC_URL;
                        }

                        boom(`Welcome ${data.email}`, 'success', true);

                        setTimeout(() => {
                            hideOverlay();
                            window.location.href = redirectUrl;
                        }, 2000);
                    } else {
                        hideOverlay();
                        boom(data.error || 'Login failed', 'danger', true);
                    }
                } catch (err) {
                    console.error('Login parse error:', err);
                    hideOverlay();
                    boom('Invalid server response', 'danger', true);
                }
            }).fail(function () {
                hideOverlay();
                boom('Server unreachable. Try again later.', 'danger', true);
            });
        });
        // opt login
        $('#mobileOtp').prop('disabled', true);

        $('#sendOtpBtn').on('click', function (e) {
            e.preventDefault(); // ⛔ Prevent form refresh

            const mobile = $('#mobileNumber').val().replace(/\D/g, '');
            if (mobile.length < 10) {
                boom('Enter a valid mobile number', 'danger', true);
                return;
            }
            $.post(BASE_URL + 'model/sender.php', {
                action: 'request_otp',
                mobile: mobile
            }, function (res) {
                const data = typeof res === 'string' ? JSON.parse(res) : res;
                if (data.success) {
                    boom('OTP sent successfully', 'success');
                    $('#mobileOtp').prop('disabled', false).focus();
                } else {
                    boom(data.error || 'Failed to send OTP', 'danger', true);
                }
            });
        });
        // Submit OTP for login
        $('#mobileLoginForm').submit(function (e) {
            e.preventDefault();

            const mobile = $('#mobileNumber').val().replace(/\D/g, '');
            const otp = $('#mobileOtp').val().trim();

            if (mobile.length < 10 || otp.length < 4) {
                boom('Enter valid mobile and OTP', 'danger', true);
                return;
            }

            $.post(BASE_URL + 'model/login.php', {
                mobile: mobile,
                otp: otp
            }, function (res) {
                const data = typeof res === 'string' ? JSON.parse(res) : res;
                if (data.success && data.token) {
                    localStorage.setItem('jwt', data.token);
                    boom(`Welcome ${data.phone}`, 'success', true);
                    setTimeout(() => window.location.href = BASE_URL, 1500);
                } else {
                    boom(data.error || 'Login failed', 'danger', true);
                }
            }).fail(function () {
                boom('Server error during login', 'danger', true);
            });
        });
        // Forgot Password
        $('#forgotForm').submit(function (e) {
            e.preventDefault();
            const email = $('#forgotEmail').val().trim();
            if (!email) {
                boom('Enter a valid email', 'danger');
                return;
            }

            $.post(BASE_URL + 'forgot-password.php', { email }, function (res) {
                const data = typeof res === 'string' ? JSON.parse(res) : res;
                if (data.success) {
                    boom('Reset link sent to your email', 'success', true);
                    $('#forgotForm')[0].reset();
                } else {
                    boom(data.error || 'Failed to send reset link', 'danger', true);
                }
            }).fail(function () {
                boom('Server error while sending reset link', 'danger', true);
            });
        });
        $('#togglePassword').on('click', function () {
            const input = $('#loginPassword');
            const icon = $(this).find('i');

            const isPassword = input.attr('type') === 'password';
            input.attr('type', isPassword ? 'text' : 'password');
            icon.toggleClass('fa-lock fa-unlock');
        });
    </script>
    <script>
        const canvas = document.getElementById('canv');
        const ctx = canvas.getContext('2d');

        let w, h;
        function resize() {
            w = canvas.width = window.innerWidth;
            h = canvas.height = window.innerHeight;
        }
        window.addEventListener('resize', resize);
        resize();

        let angle = 0;

        // Draw shield shape
        function drawShield(x, y, size) {
            ctx.save();
            ctx.beginPath();
            ctx.moveTo(x, y - size / 2);
            ctx.lineTo(x + size / 2, y - size / 4);
            ctx.lineTo(x + size / 3, y + size / 2);
            ctx.lineTo(x - size / 3, y + size / 2);
            ctx.lineTo(x - size / 2, y - size / 4);
            ctx.closePath();
            ctx.fillStyle = "#0d6efd";
            ctx.shadowBlur = 20;
            ctx.shadowColor = "#00d4ff";
            ctx.fill();
            ctx.restore();
        }

        // Draw lock inside shield
        function drawLock(x, y, size) {
            ctx.save();
            ctx.fillStyle = "#fff";
            ctx.strokeStyle = "#00d4ff";
            ctx.lineWidth = 2;

            // Body
            ctx.fillRect(x - size / 2, y, size, size * 0.7);
            ctx.strokeRect(x - size / 2, y, size, size * 0.7);

            // Shackle
            ctx.beginPath();
            ctx.arc(x, y, size / 2, Math.PI, 0, false);
            ctx.stroke();
            ctx.restore();
        }

        // Circuit particle
        class Node {
            constructor(radius, speed) {
                this.radius = radius;
                this.speed = speed;
                this.angle = Math.random() * Math.PI * 2;
            }
            update() {
                this.angle += 0.002 * this.speed;
                this.x = w / 2 + Math.cos(this.angle) * this.radius;
                this.y = h / 2 + Math.sin(this.angle) * this.radius;
            }
            draw() {
                ctx.beginPath();
                ctx.arc(this.x, this.y, 3, 0, Math.PI * 2);
                ctx.fillStyle = "#00d4ff";
                ctx.fill();
                // Connect to center (circuit line)
                ctx.beginPath();
                ctx.moveTo(w / 2, h / 2);
                ctx.lineTo(this.x, this.y);
                ctx.strokeStyle = "rgba(0,212,255,0.3)";
                ctx.stroke();
            }
        }

        let nodes = [];
        for (let i = 0; i < 30; i++) {
            nodes.push(new Node(100 + Math.random() * 200, 1 + Math.random() * 2));
        }

        function animate() {
            ctx.clearRect(0, 0, w, h);

            // Draw shield + lock
            drawShield(w / 2, h / 2, 120);
            drawLock(w / 2, h / 2, 50);

            // Draw orbiting circuit nodes
            nodes.forEach(n => {
                n.update();
                n.draw();
            });

            requestAnimationFrame(animate);
        }
        animate();
    </script>


</body>

</html>