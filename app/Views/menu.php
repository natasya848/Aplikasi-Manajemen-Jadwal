<style>
    .submenu {
        display: none;
    }

    .sidebar-item.active .submenu {
        display: block;
    }

    #sidebar {
        width: 280px;
        background: rgba(248, 249, 255, 0.95);  
        backdrop-filter: blur(8px);  
        height: 100vh;
        position: fixed;
        left: 0;
        top: 0;
        z-index: 100;
        transition: all 0.3s ease-in-out;
        box-shadow: 4px 0 12px rgba(0, 0, 0, 0.1); 
        border-right: 1px solid rgba(206, 206, 206, 0.3);  
    }

    .sidebar-wrapper {
        padding: 25px 20px;
        height: 100%;
        overflow-y: auto;
    }

    .sidebar-header img {
        width: 100px;
        height: auto;
        margin-bottom: 20px;  
        filter: drop-shadow(0 0 5px rgba(106, 76, 147, 0.2)); 
    }

    .sidebar-title {
        font-size: 16px;
        text-transform: uppercase;
        color: #6a4c93;
        font-weight: bold;
        margin: 20px 0 10px;
        letter-spacing: 1px;
    }

    .sidebar-menu .menu {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .sidebar-item {
        margin-bottom: 15px;  
    }

    .sidebar-link {
        display: flex;
        align-items: center;
        padding: 12px 16px;
        border-radius: 8px;
        color: #5e5e5e;  
        font-weight: 500;
        text-decoration: none;
        background-color: transparent;
        transition: background-color 0.2s, padding-left 0.2s, color 0.2s;
    }

    .sidebar-link:hover,
    .sidebar-item.active .sidebar-link {
        background-color: rgba(106, 76, 147, 0.2);
        color: #ffffff;
        font-weight: bold;
        padding-left: 20px;
    }

    .sidebar-item.active .sidebar-link {
        background-color: rgba(106, 76, 147, 0.3);
        color: #ffffff;
        font-weight: bold;
    }

    .has-sub .submenu {
        margin-left: 20px;
        margin-top: 5px;
    }

    .submenu-item a {
        display: block;
        padding: 8px 16px;
        border-radius: 6px;
        color: #4a4a6a;
        font-size: 0.95rem;
        text-decoration: none;
        transition: background-color 0.2s;
    }

    .submenu-item a:hover {
        background-color: rgba(106, 76, 147, 0.15);
        color: #ffffff;
    }

</style>

<div id="sidebar" class="active">
    <div class="sidebar-wrapper active">
        <div class="sidebar-header text-center">
            <h5 class="text-center mb-6" style="font-weight: 700; color: #5f7f76;"><?= $setting['nama'] ?? 'Sistem Manajemen Influencer' ?></h5>
        </div>

        <?php $level = session()->get('level'); ?> 

        <div class="sidebar-menu">
            <ul class="menu">
                <?php foreach ($menus[0] ?? [] as $menu): ?>
                    <?php if (!empty($menus[$menu->id_menu])): ?>
                        <li class="sidebar-item has-sub">
                            <a href="#" class="sidebar-link">
                                <i class="<?= $menu->icon ?>"></i>
                                <span><?= $menu->nama_menu ?></span>
                            </a>
                            <ul class="submenu">
                                <?php foreach ($menus[$menu->id_menu] as $submenu): ?>
                                    <li class="submenu-item">
                                        <a href="<?= base_url($submenu->url ?? '#') ?>">
                                            <i class="<?= $submenu->icon ?>"></i> <?= $submenu->nama_menu ?>
                                        </a>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </li>
                    <?php else: ?>
                        <li class="sidebar-item">
                        <a href="<?= base_url(isset($menu->url) ? $menu->url : '#') ?>" class="sidebar-link">
                            <i class="<?= $menu->icon ?>"></i> 
                            <span><?= $menu->nama_menu ?></span> 
                        </a>
                        </li>
                    <?php endif; ?>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const submenuLinks = document.querySelectorAll('.has-sub > a');

        submenuLinks.forEach(link => {
            link.addEventListener('click', function (e) {
                e.preventDefault();
                const parent = this.parentElement;
                parent.classList.toggle('active');
            });
        });
    });
</script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
