<?= $this->extend('layout'); ?>
<?= $this->section('content'); ?>

<style>
    body {
        background: linear-gradient(to right, #f7e9dc, #fceacb, #cdeae1);
        color: #333;
        font-family: 'Nunito', sans-serif;
    }

    .profile-container {
        background: #ffffff;
        border-radius: 16px;
        padding: 35px;
        box-shadow: 0px 8px 18px rgba(0, 0, 0, 0.07);
        max-width: 600px;
        margin: 50px auto;
        text-align: center;
    }

    .profile-img {
        width: 110px;
        height: 110px;
        object-fit: cover;
        margin-bottom: 20px;
        transition: transform 0.3s;
    }

    .profile-img:hover {
        transform: scale(1.05);
    }

    .profile-name {
        font-size: 22px;
        font-weight: bold;
        color: #2d4739;
    }

    .profile-username {
        font-size: 16px;
        color: #6c8b7c;
        margin-bottom: 20px;
    }

    .info-table {
        text-align: left;
        margin-top: 10px;
        background-color: #f8fdfb;
        padding: 20px;
        border: 1px solid #cbead6;
        border-radius: 12px;
    }

    .info-table th,
    .info-table td {
        padding: 8px;
        font-size: 15px;
        color: #333;
    }

    .btn-group-custom {
        margin-top: 25px;
    }

    .btn-edit {
        padding: 10px 20px;
        border-radius: 12px;
        font-weight: 600;
        width: 45%;
    }

    .btn-warning {
        background-color: #f7c8b0;
        color: #fff;
        border: none;
    }

    .btn-primary {
        background-color: #a8d6ea;
        color: #fff;
        border: none;
    }

    .btn-warning:hover {
        background-color: #ec9f7e;
    }

    .btn-primary:hover {
        background-color: #85c1d8;
    }

    .modal-content {
        background-color: #ffffff;
        border-radius: 12px;
    }

    .modal-header {
        border-bottom: 1px solid #cbead6;
    }

    .modal-title {
        color: #2d4739;
    }

    .form-label {
        font-weight: 600;
        color: #2d4739;
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

    .btn-success {
        background-color: #a8e6cf;
        color: #2e2e2e;
        font-weight: bold;
        border: none;
    }

    .btn-success:hover {
        background-color: #90d6b6;
    }

    @media (max-width: 576px) {
        .profile-container {
            margin: 30px 15px;
            padding: 25px;
        }

        .btn-edit {
            width: 100%;
        }

        .btn-group-custom {
            flex-direction: column;
            gap: 10px;
        }
    }
</style>


<div class="container py-5">
    <div class="profile-container text-center">
        <img src="<?= base_url('uploads/' . ($user['foto'] ?? 'default.png')) ?>" class="profile-img rounded-circle border" 
        alt="Foto Profil" style="width: 120px; height: 120px; object-fit: cover;">
        <div class="profile-name"><?= $user['nama_user'] ?></div>
        <div class="profile-username">@<?= $user['username'] ?></div>

        <div class="info-table text-start mt-4">
            <table class="table table-borderless mb-0">
                <tr>
                    <th>Level Akses</th>
                    <td>
                        <?php
                        if ($user['level'] == 1) echo "Super Admin";
                        elseif ($user['level'] == 2) echo "Admin";
                        elseif ($user['level'] == 3) echo "Manajer";
                        ?>
                    </td>
                </tr>
                <tr>
                    <th>Email</th>
                    <td><?= $user['email'] ?></td>
                </tr>
            </table>
        </div>

        <div class="btn-group-custom d-flex justify-content-center gap-3">
            <button class="btn btn-warning btn-edit" data-bs-toggle="modal" data-bs-target="#editProfileModal">
                <i class="bi bi-pencil"></i> Edit Profil
            </button>
            <a href="<?= base_url('home/logout') ?>" class="btn btn-primary btn-edit">
                <i class="bi bi-box-arrow-right"></i> Logout
            </a>
        </div>
    </div>
</div>

<div class="modal fade" id="editProfileModal" tabindex="-1" aria-labelledby="editProfileModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content p-3">
            <div class="modal-header">
                <h5 class="modal-title" id="editProfileModalLabel">Edit Profil</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= base_url('home/updateProfile') ?>" method="post" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama</label>
                        <input type="text" class="form-control" id="nama" name="nama" value="<?= $user['nama_user'] ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control" id="username" name="username" value="<?= $user['username'] ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" value="<?= $user['email'] ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password Baru (Opsional)</label>
                        <input type="password" class="form-control" id="password" name="password">
                    </div>
                    <div class="mb-3">
                        <label for="foto" class="form-label">Foto Profil</label>
                        <input type="file" class="form-control" id="foto" name="foto">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
