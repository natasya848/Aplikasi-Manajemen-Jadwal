<?= $this->extend('layout') ?> 
<?= $this->section('content') ?>

<style>
    .table {
            background-color: #ffffff;  
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); 
            overflow: hidden;
        }

        table.dataTable thead {
            background-color: #f9f9f9; 
        }

        table.dataTable thead th {
            color: #5e5e5e; 
            font-weight: 600;
            text-transform: none;
            padding: 12px;
            border-bottom: 2px solid #f0dbc4; 
        }

        table.dataTable tbody tr {
            transition: background 0.3s ease;
        }

        table.dataTable tbody tr:hover {
            background-color: #fef5ec !important; 
        }

        table.dataTable td {
            color: #3e3e3e;
            padding: 10px;
            vertical-align: middle;
            border-bottom: 1px solid #f2e5d7; 
        }
    </style>
<body>

<div class="container mt-5">
    <h3 class="mb-4">Hak Akses Menu</h3>

    <div class="mb-3">
        <label for="roleSelect" class="form-label">Pilih Role:</label>
        <select class="form-select" id="roleSelect">
            <option value="">-- Pilih Role --</option>
            <?php foreach ($roles as $role): ?>
                <option value="<?= $role['id_role'] ?>"><?= $role['nama_role'] ?></option>
            <?php endforeach; ?>
        </select>
    </div>

    <form action="<?= base_url('hakakses/update_akses') ?>" method="post" id="aksesForm" style="display: none;">
        <input type="hidden" name="id_role" id="id_role_hidden">

        <?php
        $groupedMenus = [];
        foreach ($menus as $menu) {
            if ($menu['parent_id'] == null) {
                $groupedMenus[$menu['id_menu']]['parent'] = $menu;
            } else {
                $groupedMenus[$menu['parent_id']]['children'][] = $menu;
            }
        }

        $i = 0;
        ?>

            <?php foreach ($groupedMenus as $group): ?>
                <?php if (!isset($group['parent'])) continue; ?>
                <div class="mb-3 border rounded p-3">

                    <div class="form-check mb-2">
                        <input class="form-check-input parent-check" type="checkbox" id="parent_<?= $group['parent']['id_menu'] ?>" data-menu-id="<?= $group['parent']['id_menu'] ?>" name="menu[<?= $i ?>][is_parent]">
                        <label class="form-check-label fw-bold" for="parent_<?= $group['parent']['id_menu'] ?>">
                            <?= $group['parent']['nama_menu'] ?>
                        </label>

                        <input type="hidden" name="menu[<?= $i ?>][id_menu]" value="<?= $group['parent']['id_menu'] ?>">
                        <input type="hidden" name="menu[<?= $i ?>][parent_id]" value="0">
                        <input type="hidden" name="menu[<?= $i ?>][can_view]" class="can_view_parent">
                        <input type="hidden" name="menu[<?= $i ?>][can_add]" class="can_add_parent">
                        <input type="hidden" name="menu[<?= $i ?>][can_edit]" class="can_edit_parent">
                        <input type="hidden" name="menu[<?= $i ?>][can_delete]" class="can_delete_parent">
                    </div>

                    <?php $i++; ?>

                    <?php if (!empty($group['children'])): ?>
                        <table class="table table-bordered table-striped">
                            <thead class="table-light">
                                <tr>
                                    <th>Submenu</th>
                                    <th>View</th>
                                    <th>Add</th>
                                    <th>Edit</th>
                                    <th>Delete</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($group['children'] as $menu): ?>
                                    <tr data-menu-id="<?= $menu['id_menu'] ?>" data-parent-id="<?= $menu['parent_id'] ?>">
                                        <td><?= $menu['nama_menu'] ?></td>
                                        <td><input type="checkbox" name="menu[<?= $i ?>][can_view]" class="form-check-input can_view"></td>
                                        <td><input type="checkbox" name="menu[<?= $i ?>][can_add]" class="form-check-input can_add"></td>
                                        <td><input type="checkbox" name="menu[<?= $i ?>][can_edit]" class="form-check-input can_edit"></td>
                                        <td><input type="checkbox" name="menu[<?= $i ?>][can_delete]" class="form-check-input can_delete"></td>
                                        <input type="hidden" name="menu[<?= $i ?>][parent_id]" value="<?= $group['parent']['id_menu'] ?>">
                                        <input type="hidden" name="menu[<?= $i ?>][id_menu]" value="<?= $menu['id_menu'] ?>">
                                    </tr>
                                    <?php $i++; ?>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        <button type="submit" class="btn btn-success mt-3">Simpan Hak Akses</button>
    </form>
</div>

<script>
    const aksesData = <?= json_encode($aksesData) ?>;

    $('#roleSelect').on('change', function () {
        const roleId = $(this).val();
        if (roleId) {
            $('#aksesForm').show();
            $('#id_role_hidden').val(roleId);
            $('#aksesForm input[type=checkbox]').prop('checked', false);

            const dataRole = aksesData[roleId] ?? {};
            $('tr[data-menu-id]').each(function () {
                const menuId = $(this).data('menu-id');
                const akses = dataRole[menuId] ?? {};
                $(this).find('.can_view').prop('checked', akses.can_view == 1);
                $(this).find('.can_add').prop('checked', akses.can_add == 1);
                $(this).find('.can_edit').prop('checked', akses.can_edit == 1);
                $(this).find('.can_delete').prop('checked', akses.can_delete == 1);
            });
        } else {
            $('#aksesForm').hide();
        }
    });

    $(document).on('change', '.parent-check', function () {
        const parentId = $(this).data('menu-id');
        const isChecked = $(this).is(':checked');

        $(`input[name="menu[][id_menu]"][value="${parentId}"]`).each(function() {
            const row = $(this).closest('div');
            row.find('.can_view_parent').val(isChecked ? 1 : 0);
            row.find('.can_add_parent').val(isChecked ? 1 : 0);
            row.find('.can_edit_parent').val(isChecked ? 1 : 0);
            row.find('.can_delete_parent').val(isChecked ? 1 : 0);
        });

        const childRows = $(`tr[data-parent-id="${parentId}"]`);
        childRows.find('input[type=checkbox]').prop('checked', isChecked);
    });

    $(document).on('change', 'tr[data-parent-id] input[type=checkbox]', function () {
        const parentId = $(this).closest('tr').data('parent-id');
        const allCheckboxes = $(`tr[data-parent-id="${parentId}"] input[type=checkbox]`);
        const parentCheckbox = $(`#parent_${parentId}`);
        const allChecked = allCheckboxes.length === allCheckboxes.filter(':checked').length;
        parentCheckbox.prop('checked', allChecked);
    });
</script>

<?= $this->endSection() ?>