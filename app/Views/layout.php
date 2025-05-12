<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $setting['nama'] ?? 'Manajemen Jadwal' ?></title>
    <link rel="icon" href="<?= base_url('uploads/' . ($setting['foto'] ?? 'default-logo.png')) ?>">

    <link rel="stylesheet" href="<?= base_url('assets/css/bootstrap.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/fontawesome/css/all.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/app.css') ?>">
    <script src="<?= base_url('assets/js/main.js') ?>"></script>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">

    <style>
        body {
            font-family: 'Nunito', sans-serif;
            background: linear-gradient(to right, #f7e9dc, #fceacb, #cdeae1);
            min-height: 100vh;
        }

        .card {
            background: #fff;
            border-radius: 1rem;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }

        .btn-primary {
            background-color: #a9c5b7;
            border: none;
        }

        .btn-primary:hover {
            background-color: #87b1a1;
        }
    </style>

    <script src="<?= base_url('assets/js/bootstrap.bundle.min.js') ?>"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>

    <div id="app">
        <?= $this->include('menu') ?>

        <div id="main">
            <?= $this->include('header') ?>

            <div class="main-content">
                <div class="section">
                    <?= $this->renderSection('content') ?>
                </div>
            </div>

            <?= $this->include('footer') ?>
        </div>
    </div>

    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

    <script type="text/javascript">
        function googleTranslateElementInit() {
            new google.translate.TranslateElement({
                pageLanguage: 'id',
                includedLanguages: 'en,id',
                layout: google.translate.TranslateElement.InlineLayout.SIMPLE,
                autoDisplay: false
            }, 'google_translate_element');
        }
    </script>
    <script type="text/javascript" src="https://translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>

    <?= $this->renderSection('scripts') ?>
</body>
</html>
