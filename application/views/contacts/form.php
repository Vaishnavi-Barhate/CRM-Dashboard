<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= isset($contact->id) ? 'Edit Contact' : 'Add Contact' ?></title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
<style>
:root {
    --primary-color: #dc3545; 
    --secondary-color: #6c757d;
    --background-color: #f4f6f9;
}

body {
    font-family: 'Inter', ui-sans-serif, system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial;
    background-color: var(--background-color);
    margin: 0;
    padding: 0;
}

.container-main { 
    width: 100%; 
    margin:0; 
    padding:0; 
    min-height: 100vh; 
}

.breadcrumb-bar {
    width:100%; background:#fff; border-bottom:1px solid #dee2e6;
    padding:1rem 3rem; display:flex; align-items:center; box-shadow:0 1px 3px rgba(0,0,0,0.05);
}

.breadcrumb-item a { 
    color: var(--secondary-color); 
    text-decoration:none; 
}

.breadcrumb-item.active { 
    color: var(--primary-color); 
    font-weight:600;
}

.breadcrumb-item + .breadcrumb-item::before { 
    content:'>'; 
    color:#ccc; 
    padding:0 0.5rem; 
}

.card { 
    width:100%; 
    margin:0; 
    border:none; 
    border-radius:0; 
    box-shadow:none; 
    min-height:calc(100vh - 4.25rem);
}

.card-header { 
    padding:1.25rem 3rem; 
    font-size:1.05rem; 
    font-weight:600; 
    background:#fff; 
    border-bottom:1px solid #e9ecef; 
    display:flex; 
    align-items:center;
}

.card-header .bi { 
    margin-right:0.75rem; 
    color:#495057;
}

.card-body { 
    padding:2.5rem 3rem; 
}

.form-label { 
    font-size:0.9rem; 
    font-weight:600; 
    margin-bottom:0; 
    min-width:120px; 
    color:#343a40;
}

.form-control { 
    font-family:'Inter', sans-serif; 
    border-radius:0.5rem; 
    border:1px solid #dee2e6; 
    padding:0.75rem 1rem; 
    height:auto; 
}

.form-control:focus { 
    border-color:#dc3545; 
    box-shadow:0 0 0 0.25rem rgba(220,53,69,0.25); 
}

.required { 
    color: var(--primary-color); 
    font-weight:700; 
}

.btn-submit { 
    background-color: var(--primary-color); 
    border:none; 
    color:#fff; 
    border-radius:0.5rem; 
    padding:0.6rem 1.8rem; 
    font-size:1rem; 
    font-weight:600; 
    display:flex; 
    align-items:center; 
}

.btn-submit:hover { 
    background-color:#c82333; 
    box-shadow:0 4px 8px rgba(220,53,69,0.3); 
}

.form-group { 
    margin-bottom:1.5rem; 
}

.alert-danger { 
    border-radius:0.5rem; 
    font-size:0.95rem; 
}

</style>
</head>
<body>

<div class="container-main">

    <div class="breadcrumb-bar">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="<?= site_url('contacts') ?>"><i class="bi bi-house-door me-1"></i>Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page"><?= isset($contact->id) ? 'Edit Record' : 'Add Record' ?></li>
            </ol>
        </nav>
    </div>

    <div class="card">
        <div class="card-header">
            <i class="bi bi-person-plus-fill"></i> <?= isset($contact->id) ? 'Edit' : 'Add' ?>
        </div>
        <div class="card-body">

            <?php if(validation_errors()): ?>
                <div class="alert alert-danger"><?= validation_errors() ?></div>
            <?php endif; ?>

            <form method="post" action="<?= site_url('contacts/save') ?>">

                <?php if(isset($contact->id)): ?>
                    <input type="hidden" name="id" value="<?= $contact->id ?>">
                <?php endif; ?>

                <div class="row g-4 mb-4">

                    <div class="col-md-6">
                        <div class="form-group mb-0 d-flex align-items-center">
                            <label class="form-label text-nowrap me-3 mb-0" for="name">Name <span class="required">*</span></label>
                            <input type="text" id="name" name="name" placeholder="Full Name" class="form-control flex-grow-1" 
                                   value="<?= set_value('name', $contact->name ?? '') ?>" required>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group mb-0 d-flex align-items-center">
                            <label class="form-label text-nowrap me-3 mb-0" for="company_name">Company Name <span class="required">*</span></label>
                            <input type="text" id="company_name" name="company_name" placeholder="Company Name" class="form-control flex-grow-1" 
                                   value="<?= set_value('company_name', $contact->company_name ?? '') ?>" required>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group mb-0 d-flex align-items-center">
                            <label class="form-label text-nowrap me-3 mb-0" for="designation">Designation</label>
                            <input type="text" id="designation" name="designation" placeholder="Job Title" class="form-control flex-grow-1" 
                                   value="<?= set_value('designation', $contact->designation ?? '') ?>">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group mb-0 d-flex align-items-center">
                            <label class="form-label text-nowrap me-3 mb-0" for="email">Email Id <span class="required">*</span></label>
                            <input type="email" id="email" name="email" placeholder="Email Address" class="form-control flex-grow-1" 
                                   value="<?= set_value('email', $contact->email ?? '') ?>" required>
                        </div>
                    </div>

                </div>

                <div class="d-flex justify-content-end mt-4 pt-2">
                    <button type="submit" class="btn btn-submit">Submit <i class="bi bi-arrow-right-short ms-2"></i></button>
                </div>

            </form>

        </div>
    </div>

</div>

</body>
</html>
