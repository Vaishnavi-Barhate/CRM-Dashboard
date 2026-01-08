<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <title>List</title>

  <script src="https://cdn.tailwindcss.com"></script>

  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">

  <style>
    html, body {
      height: 100%;
      width: 100%;
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      -webkit-font-smoothing: antialiased;
      -moz-osx-font-smoothing: grayscale;
      background-color: #f8f9fa;
      font-family: 'Inter', ui-sans-serif, system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial;
    }

    .app-root, .full-width-card {
      width: 100% !important;
      max-width: 100% !important;
      margin: 0 !important;
      padding-left: 0 !important;
      padding-right: 0 !important;
    }

    .inner-pad {
      padding-left: 12px;
      padding-right: 12px;
    }

    :root {
      --primary-green: #28a745;
      --primary-red: #dc3545;
      --border-color: #dcdcdc;
      --header-bg: #f3f3f3;
    }

    .admin-btn {
      font-weight: 500;
      padding: 0.45rem 0.85rem;
      border-radius: 6px;
      font-size: 0.875rem;
      transition: 0.15s ease;
      white-space: nowrap;
    }
    .admin-btn-light { background:#fff; border:1px solid #d1d5db; }

    table.dataTable {
      border-collapse: collapse !important;
      width: 100%;
    }
    table.dataTable thead th {
      background: #fff;
      color: #495057;
      font-weight: 600;
      border: 1px solid var(--border-color);
      padding: 0.65rem;
      text-align: left;
    }
    table.dataTable tbody td {
      border: 1px solid var(--border-color);
      padding: 0.65rem;
      color: #495057;
      vertical-align: middle;
    }

    #contactsTable thead th:first-child,
    #contactsTable tbody td:first-child {
      text-align: center;
      vertical-align: middle !important;
      padding-top: 8px !important;
      padding-bottom: 8px !important;
      width: 5%;
    }

    #contactsTable thead th:last-child,
    #contactsTable tbody td:last-child {
      width: 12%;
      text-align: center;
    }

    .dataTables_filter, .dataTables_length, .dataTables_info {
      display: none !important;
    }

    div.dt-buttons { display: none !important; }

    #contactsTable thead th { cursor: default; }

    .dataTables_wrapper { padding: 0 !important; margin: 0 !important; }

    .header-actions { display:flex; gap:8px; align-items:center; }
    @media (max-width: 640px) {
      .inner-pad { padding-left: 10px; padding-right: 10px; }
      #customSearch { width: 100% !important; }
    }

    .full-width-card.bg-\[\-\-header-bg\] {
      padding-left: 16px !important;
      padding-right: 16px !important;
    }

    .inner-pad {
      padding-left: 16px !important;
      padding-right: 16px !important;
    }

  </style>
</head>
<body>

  <div class="app-root">

    <div class="full-width-card bg-[--header-bg]" style="display:block; padding:12px 16px;">
      <div style="display:flex; align-items:center; justify-content:space-between; width:100%;">
        <div style="display:flex; align-items:center; gap:12px;">
          <a href="#" class="text-gray-700 font-medium flex items-center text-sm">
            <svg class="w-4 h-4 mr-1 text-gray-600" viewBox="0 0 20 20" fill="currentColor"><path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"/></svg>
            Dashboard
          </a>
        </div>

        <div class="header-actions">
          <a href="<?= site_url('contacts/form') ?>" class="admin-btn text-white" style="background:var(--primary-green);">Add</a>
          <button id="deleteSelected" class="admin-btn text-white" style="background:var(--primary-red);" disabled>Delete</button>
        </div>
      </div>
    </div>

    <div class="full-width-card inner-pad" style="margin-top:12px;">
      <div class="bg-white rounded shadow-md" style="width:100%;">

        <div style="display:flex; justify-content:space-between; align-items:center; gap:12px; padding:16px; border-bottom:1px solid #ececec; flex-wrap:wrap;">
          
          <div style="display:flex; align-items:center; gap:8px; min-width:240px;">
            <label for="customSearch" class="text-sm font-medium text-gray-700">Search:</label>
            <input id="customSearch" type="text" placeholder="Type to search..." style="padding:8px 12px; border:1px solid #d1d5db; border-radius:6px; width:260px;">
          </div>

          <div style="display:flex; align-items:center; gap:8px;">
            <label class="text-sm font-medium text-gray-700">Show:</label>
            <select id="showCount" style="padding:6px 10px; border:1px solid #d1d5db; border-radius:6px;">
              <option value="10">10</option>
              <option value="25" selected>25</option>
              <option value="50">50</option>
            </select>

            <button id="exportExcel" class="admin-btn admin-btn-light">Excel</button>
            <button id="resetFilters" class="admin-btn admin-btn-light">Reset Filters</button>
          </div>
        </div>

        <div style="padding:12px 12px 18px 12px;">
          <div style="overflow-x:auto;">
            <table id="contactsTable" class="display" style="width:100%;">
              <thead>
                <tr>
                  <th><input type="checkbox" id="selectAll"></th>
                  <th>Name</th>
                  <th>Company Name</th>
                  <th>Designation</th>
                  <th>Email</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
                <?php if (!empty($contacts)): ?>
                  <?php foreach ($contacts as $row): ?>
                    <tr>
                      <td><input type="checkbox" class="selectItem" value="<?= $row->id ?>"></td>
                      <td><?= htmlspecialchars($row->name) ?></td>
                      <td><?= htmlspecialchars($row->company_name) ?></td>
                      <td><?= htmlspecialchars($row->designation) ?></td>
                      <td><?= htmlspecialchars($row->email) ?></td>
                      <td style="text-align:center;">
                        <a href="<?= site_url('contacts/form/'.$row->id) ?>" style="display:inline-block;padding:6px 8px;border-radius:4px;border:1px solid #e6e6e6;color:#495057;margin-right:6px;">Edit</a>
                        <button data-id="<?= $row->id ?>" data-action="single-delete" style="display:inline-block;padding:6px 8px;border-radius:4px;background:var(--primary-red);color:#fff;border:none;">Delete</button>
                      </td>
                    </tr>
                  <?php endforeach; ?>
                <?php else: ?>
                  <tr><td colspan="6" style="text-align:center;padding:18px;color:#6b7280;">No contacts found.</td></tr>
                <?php endif; ?>
              </tbody>
            </table>
          </div>
        </div>

      </div>
    </div>
  </div>

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>

  <script>
    $(document).ready(function(){
      // init DataTable 
      var table = $('#contactsTable').DataTable({
        paging: true,
        pageLength: parseInt($('#showCount').val() || 25),
        lengthChange: false,
        ordering: false,
        info: false,
        searching: true,
        dom: 'Brtp',
        buttons: [{ extend: 'excelHtml5', title: 'Contacts_List', className: 'd-none dt-excel-btn' }],
        columnDefs: [{ orderable: false, targets: [0,5] }]
      });

      // visible Excel button triggers datatable export
      $('#exportExcel').on('click', function(){ table.button('.dt-excel-btn').trigger(); });

      // custom search
      $('#customSearch').on('keyup', function(){ table.search(this.value).draw(); });

      // show count change
      $('#showCount').on('change', function(){ table.page.len($(this).val()).draw(); });

      // reset
      $('#resetFilters').on('click', function(){
        $('#customSearch').val('');
        $('#showCount').val('25');
        table.search('').page.len(25).draw();
      });

      // selectAll (current page)
      $('#selectAll').on('change', function(){
        var checked = $(this).is(':checked');
        $('input.selectItem', table.rows({ page: 'current' }).nodes()).prop('checked', checked);
        toggleBulkBtn();
      });

      // individual checkbox toggle
      $('#contactsTable tbody').on('change', '.selectItem', function(){
        toggleBulkBtn();
        var visible = $('input.selectItem', table.rows({ page: 'current' }).nodes()).length;
        var checkedVisible = $('input.selectItem:checked', table.rows({ page: 'current' }).nodes()).length;
        $('#selectAll').prop('checked', visible > 0 && checkedVisible === visible);
      });

      function toggleBulkBtn(){
        var totalChecked = $('input.selectItem:checked').length;
        $('#deleteSelected').prop('disabled', totalChecked === 0);
      }

      // bulk delete
      $('#deleteSelected').on('click', function(){
        var ids = $('input.selectItem:checked').map(function(){ return $(this).val(); }).get();
        if (!ids.length) return;
        if (!confirm('Delete selected contacts?')) return;
        $.post('<?= site_url('contacts/delete_bulk') ?>', { ids: ids }, function(){ location.reload(); });
      });

      // single delete
      $('#contactsTable').on('click', 'button[data-action="single-delete"]', function(){
        var id = $(this).data('id');
        if (!confirm('Delete this contact?')) return;
        $.post('<?= site_url('contacts/delete') ?>/' + id, function(){ location.reload(); });
      });
    });
  </script>
</body>
</html>
