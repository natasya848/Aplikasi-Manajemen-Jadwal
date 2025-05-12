<?= $this->extend('layout'); ?>
<?= $this->section('content'); ?>

<style>
    body {
        background: linear-gradient(to right, #f7e9dc, #fceacb, #cdeae1);
        color: #333;
        font-family: 'Nunito', sans-serif;
    }

    .profile-container { 
        max-width: 520px; 
        margin: 80px auto; 
        background: #ffffff; 
        padding: 35px; 
        border-radius: 16px; 
        box-shadow: 0px 8px 18px rgba(0, 0, 0, 0.07); 
    }

    .profile-img { 
        width: 110px; 
        height: 110px; 
        border-radius: 50%; 
        object-fit: cover; 
        border: 3px solid #90d6b6; 
        margin-bottom: 20px;
        transition: transform 0.3s;
    }

    .profile-img:hover {
        transform: scale(1.05);
    }

    label {
        font-weight: 600;
        color: #4d4d4d;
    }

    .form-control {
        border-radius: 10px;
        border: 1px solid #cbead6;
        background-color: #f8fdfb;
        color: #333;
    }

    .form-control:focus {
        border-color: #9fd6b5;
        box-shadow: 0 0 5px rgba(159, 214, 181, 0.4);
    }

    .btn-save {
        background-color: #a8e6cf;
        border: none;
        color: #2e2e2e;
        font-weight: bold;
        padding: 10px 20px;
        border-radius: 12px;
        transition: all 0.3s;
        width: 100%;
    }

    .btn-save:hover {
        background-color: #90d6b6;
    }

    @media (max-width: 576px) {
        .profile-container {
            margin: 30px 15px;
            padding: 25px;
        }
    }
</style>


<div class="container">
    <div class="profile-container text-center">

        <form id="settingsForm" action="<?= base_url('home/update_setting') ?>" method="POST" enctype="multipart/form-data">
            <div class="mt-2">
                <img id="currentLogo" src="<?= base_url('uploads/' . $setting['foto']) ?>" class="profile-img">
            </div>

            <div class="mb-3 text-start">
                <label class="form-label text-dark">Nama Website:</label>
                <input type="text" class="form-control" name="nama" value="<?= esc($setting['nama']) ?>" required>
            </div>

            <div class="mb-3 text-start">
                <label class="form-label text-dark">Logo Website:</label>
                <input type="file" class="form-control" name="foto" id="logoInput" onchange="previewLogo()">
            </div>

            <button type="submit" class="btn btn-save w-100">Simpan Perubahan</button>
        </form>
    </div>
</div>

<script>
    function previewLogo() {
        const fileInput = document.getElementById('logoInput');
        const previewImage = document.getElementById('currentLogo');
        
        const file = fileInput.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                previewImage.src = e.target.result;
            };
            reader.readAsDataURL(file);
        }
    }

    document.getElementById('settingsForm').addEventListener('submit', function(e) {
        e.preventDefault(); 
        const formData = new FormData(this);

        fetch('<?= base_url('home/update_setting') ?>', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Pengaturan berhasil diperbarui');
            location.reload();
        } else {
            alert('Terjadi kesalahan, coba lagi');
        }
    })

        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan, coba lagi');
        });
    });
    </script>


<?= $this->endSection() ?>
