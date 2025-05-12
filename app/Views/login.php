<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rekap Jadwal</title>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('assets/css/bootstrap.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('assets/vendors/bootstrap-icons/bootstrap-icons.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/app.css'); ?>">
    <script src="https://www.google.com/recaptcha/api.js"></script>

    <style>
        body {
            background: linear-gradient(to right, #f7e9dc, #fceacb, #cdeae1);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: 'Nunito', sans-serif;
            margin: 0;
        }

        #auth {
            max-width: 420px;
            width: 100%;
            background: rgba(255, 255, 255, 0.95);
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0px 4px 25px rgba(0, 0, 0, 0.15);
            position: relative;
        }

        .form-control {
            border-radius: 30px;
            padding: 10px 20px;
            font-size: 1rem;
        }

        .btn-primary {
            border-radius: 30px;
            background: #a9c5b7;
            border: none;
            transition: 0.3s;
            font-weight: bold;
        }

        .btn-primary:hover {
            background: #87b1a1;
        }

        .text-gray-600 a {
            color: #87b1a1;
            font-weight: bold;
            text-decoration: underline;
        }

        #math-captcha {
            padding: 10px;
            background-color: #f8f9fa;
            border-radius: 8px;
        }

        .btn-center {
            display: flex;
            justify-content: center;
        }

        .dropdown-center {
            display: flex;
            justify-content: center;
        }
    </style>
</head>

<body>
    <div id="auth">
        <h5 class="text-center mb-4" style="font-weight: 700; color: #5f7f76;">Sistem Manajemen Influencer</h5>
        <form id="login-form" action="<?= base_url('login/aksi_login') ?>" method="post">
            <input type="hidden" name="correct_answer" id="correct-answer">
            <input type="hidden" name="math_answer" id="user-answer">

            <div class="form-group position-relative has-icon-left mb-3">
                <input type="text" name="usn" class="form-control form-control-lg" placeholder="Username" required>
                <div class="form-control-icon">
                    <i class="bi bi-person"></i>
                </div>
            </div>

            <div class="form-group position-relative has-icon-left mb-3">
                <input type="password" name="pswd" class="form-control form-control-lg" placeholder="Password" required>
                <div class="form-control-icon">
                    <i class="bi bi-shield-lock"></i>
                </div>
            </div>

            <p class="text-end text-gray-600">
                <a href="<?= base_url('login/resetpass') ?>" class="text-decoration-none">Forgot Password?</a>
            </p>

            <div class="g-recaptcha mb-3" data-sitekey="6LcNvAsrAAAAAOiX2u-w_9h-pza_Sd2Rnao-9jbB"></div>

            <div id="math-captcha" class="mt-3" style="display: none;">
                <label id="math-question" class="form-label fw-bold"></label>
                <input type="number" id="math-answer" class="form-control" placeholder="Jawaban Anda">
            </div>

            <div class="btn-center">
                <button type="button" onclick="validateCaptcha()" class="btn btn-primary btn-lg shadow-lg mt-4 w-100">
                    Log in
                </button>
            </div>

            <div id="google_translate_element" style="position: absolute; top: -9999px;"></div>
        </form>
    </div>

    <script>
        let questions = [
            { a: 2, b: 3, op: '+' },
            { a: 5, b: 2, op: '-' },
            { a: 1, b: 6, op: '+' },
            { a: 8, b: 4, op: '-' }
        ];

        let correctAnswer;

        function generateMathCaptcha() {
            const soal = questions[Math.floor(Math.random() * questions.length)];
            const question = `Berapa hasil dari ${soal.a} ${soal.op} ${soal.b}?`;
            document.getElementById('math-question').innerText = question;
            correctAnswer = soal.op === '+' ? soal.a + soal.b : soal.a - soal.b;
            document.getElementById('correct-answer').value = correctAnswer;
        }

        function validateCaptcha() {
            if (!navigator.onLine) {
                const userAnswer = parseInt(document.getElementById('math-answer').value);
                document.getElementById('user-answer').value = userAnswer;
                if (isNaN(userAnswer) || userAnswer !== correctAnswer) {
                    alert("Jawaban soal matematika salah. Silakan coba lagi.");
                    generateMathCaptcha();
                } else {
                    document.getElementById('login-form').submit();
                }
            } else {
                const response = grecaptcha.getResponse();
                if (response.length === 0) {
                    alert("Silakan lengkapi CAPTCHA terlebih dahulu.");
                } else {
                    document.getElementById('login-form').submit();
                }
            }
        }

        window.addEventListener('load', function () {
            if (!navigator.onLine) {
                document.getElementById('math-captcha').style.display = 'block';
                generateMathCaptcha();
            }
        });
    </script>
</body>
</html>
