<?php include __DIR__ . '/../includes/header.php'; ?>

<?php
$message = $message ?? '';
$search = $search ?? '';
$status = $status ?? '';
$viewMode = $viewMode ?? 'list';

$totalPopulation = $totalPopulation ?? 0;
$avgMortality = $avgMortality ?? 0;
$productionReady = $productionReady ?? 0;
$totalBreeds = $totalBreeds ?? 0;

$batches = $batches ?? [];
$mortalityRecords = $mortalityRecords ?? [];
?>

<style>

body{
    background:#f5f7fb;
    font-family:Arial,sans-serif;
    color:#111827;
}

.page-header{
    display:flex;
    justify-content:space-between;
    align-items:center;
    flex-wrap:wrap;
    gap:15px;
    margin-bottom:25px;
}

.page-title{
    font-size:30px;
    font-weight:bold;
}

.top-actions{
    display:flex;
    gap:10px;
    flex-wrap:wrap;
}

.btn{
    border:none;
    border-radius:12px;
    padding:12px 18px;
    font-weight:bold;
    cursor:pointer;
    transition:.3s;
    text-decoration:none;
    display:inline-flex;
    align-items:center;
    justify-content:center;
}

.btn-primary{
    background:#2563eb;
    color:white;
}

.btn-primary:hover{
    background:#1d4ed8;
}

.btn-light{
    background:white;
    color:#111827;
    border:1px solid #e5e7eb;
}

.btn-light:hover{
    background:#f3f4f6;
}

.stats-grid{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(220px,1fr));
    gap:18px;
    margin-bottom:25px;
}

.stat-card{
    background:white;
    border-radius:18px;
    padding:22px;
    box-shadow:0 4px 15px rgba(0,0,0,0.05);
}

.stat-title{
    color:#6b7280;
    font-size:14px;
    margin-bottom:10px;
}

.stat-value{
    font-size:30px;
    font-weight:bold;
}

.filter-box{
    background:white;
    padding:18px;
    border-radius:18px;
    margin-bottom:25px;
    box-shadow:0 4px 15px rgba(0,0,0,0.05);
}

.filter-form{
    display:flex;
    gap:12px;
    flex-wrap:wrap;
}

.filter-form input,
.filter-form select{
    padding:12px;
    border:1px solid #d1d5db;
    border-radius:12px;
    outline:none;
    min-width:200px;
}

.panel{
    background:white;
    border-radius:18px;
    padding:22px;
    box-shadow:0 4px 15px rgba(0,0,0,0.05);
    margin-bottom:25px;
}

.panel-title{
    font-size:22px;
    font-weight:bold;
    margin-bottom:18px;
}

.table-wrapper{
    overflow-x:auto;
}

table{
    width:100%;
    border-collapse:collapse;
}

thead{
    background:#111827;
    color:white;
}

th,
td{
    padding:14px;
    text-align:left;
    font-size:14px;
}

tbody tr{
    border-bottom:1px solid #f1f1f1;
}

tbody tr:hover{
    background:#f9fafb;
}

.badge{
    padding:6px 12px;
    border-radius:30px;
    font-size:12px;
    font-weight:bold;
}

.success{
    background:#dcfce7;
    color:#15803d;
}

.danger{
    background:#fee2e2;
    color:#b91c1c;
}

.grid-view{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(260px,1fr));
    gap:18px;
}

.batch-card{
    background:white;
    border-radius:18px;
    padding:20px;
    border:1px solid #e5e7eb;
}

.batch-card h3{
    margin-bottom:14px;
    font-size:20px;
}

.batch-info{
    margin-bottom:8px;
    color:#374151;
    font-size:14px;
}

.modal{
    display:none;
    position:fixed;
    inset:0;
    background:rgba(0,0,0,0.45);
    z-index:999;
    justify-content:center;
    align-items:center;
    padding:20px;
}

.modal-content{
    background:white;
    width:100%;
    max-width:550px;
    border-radius:20px;
    padding:25px;
    max-height:90vh;
    overflow-y:auto;
}

.modal-header{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:20px;
}

.modal-title{
    font-size:24px;
    font-weight:bold;
}

.close-btn{
    background:none;
    border:none;
    font-size:26px;
    cursor:pointer;
}

.form-grid{
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:15px;
}

.field{
    margin-bottom:15px;
}

.field label{
    display:block;
    margin-bottom:8px;
    font-weight:bold;
    font-size:14px;
}

.field input,
.field select{
    width:90%;
    padding:12px;
    border:1px solid #d1d5db;
    border-radius:12px;
    outline:none;
}

.form-actions{
    display:flex;
    gap:10px;
    margin-top:10px;
}

.message{
    background:#dcfce7;
    color:#166534;
    padding:14px;
    border-radius:12px;
    margin-bottom:20px;
    font-weight:bold;
}

@media(max-width:768px){

    .form-grid{
        grid-template-columns:1fr;
    }

}

</style>

<?php if($message): ?>

<div class="message">
    <?= htmlspecialchars($message) ?>
</div>

<?php endif; ?>

<div class="page-header">

    <div class="top-actions">

        <a href="?<?= http_build_query(array_merge($_GET,['export'=>1])) ?>"
           class="btn btn-light">
            Export CSV
        </a>

        <button id="openBatchModal"
                class="btn btn-primary">
            Add Batch
        </button>

    </div>

</div>

<div class="stats-grid">

    <div class="stat-card">
        <div class="stat-title">Population</div>
        <div class="stat-value"><?= number_format($totalPopulation) ?></div>
    </div>

    <div class="stat-card">
        <div class="stat-title">Mortality</div>
        <div class="stat-value"><?= $avgMortality ?>%</div>
    </div>

    <div class="stat-card">
        <div class="stat-title">Ready</div>
        <div class="stat-value"><?= number_format($productionReady) ?></div>
    </div>

    <div class="stat-card">
        <div class="stat-title">Breeds</div>
        <div class="stat-value"><?= number_format($totalBreeds) ?></div>
    </div>

</div>

<div class="filter-box">

    <form method="get" class="filter-form">

        <input type="text"
               name="search"
               placeholder="Search..."
               value="<?= htmlspecialchars($search) ?>">

        <select name="status">

            <option value="">All Status</option>

            <option value="active"
                <?= $status === 'active' ? 'selected' : '' ?>>
                Active
            </option>

            <option value="inactive"
                <?= $status === 'inactive' ? 'selected' : '' ?>>
                Inactive
            </option>

        </select>

        <input type="hidden"
               name="view"
               value="<?= htmlspecialchars($viewMode) ?>">

        <button class="btn btn-primary" type="submit">
            Apply
        </button>

        <div style="margin-left:auto; display:flex; gap:10px;">

            <a href="?<?= http_build_query(array_merge($_GET,['view'=>'list','export'=>null])) ?>"
               class="btn <?= $viewMode === 'list' ? 'btn-primary' : 'btn-light' ?>">
                List
            </a>

            <a href="?<?= http_build_query(array_merge($_GET,['view'=>'grid','export'=>null])) ?>"
               class="btn <?= $viewMode === 'grid' ? 'btn-primary' : 'btn-light' ?>">
                Grid
            </a>

        </div>

    </form>

</div>

<div class="panel">

    <div class="panel-title">
        Batches
    </div>

    <?php if($viewMode === 'grid'): ?>

        <div class="grid-view">

            <?php foreach($batches as $batch): ?>

                <?php
                    $ageWeeks =
                    floor((time() - strtotime($batch['started_at'])) / (7*24*60*60));

                    $mortality = 1;

                    $statusClass =
                    $batch['status'] === 'active'
                    ? 'success'
                    : 'danger';
                ?>

                <div class="batch-card">

                    <h3>
                        <?= htmlspecialchars($batch['batch_code']) ?>
                    </h3>

                    <div class="batch-info">
                        Breed:
                        <?= htmlspecialchars($batch['breed']) ?>
                    </div>

                    <div class="batch-info">
                        Age:
                        <?= max(1,$ageWeeks) ?> week(s)
                    </div>

                    <div class="batch-info">
                        Quantity:
                        <?= htmlspecialchars($batch['quantity']) ?>
                    </div>

                    <div class="batch-info">
                        Status:
                        <span class="badge <?= $statusClass ?>">
                            <?= ucfirst($batch['status']) ?>
                        </span>
                    </div>

                </div>

            <?php endforeach; ?>

        </div>

    <?php else: ?>

        <div class="table-wrapper">

            <table>

                <thead>

                    <tr>

                        <th>Batch</th>
                        <th>Breed</th>
                        <th>Age</th>
                        <th>Quantity</th>
                        <th>Status</th>

                    </tr>

                </thead>

                <tbody>

                    <?php foreach($batches as $batch): ?>

                        <?php
                            $ageWeeks =
                            floor((time() - strtotime($batch['started_at'])) / (7*24*60*60));

                            $statusClass =
                            $batch['status'] === 'active'
                            ? 'success'
                            : 'danger';
                        ?>

                        <tr>

                            <td>
                                <?= htmlspecialchars($batch['batch_code']) ?>
                            </td>

                            <td>
                                <?= htmlspecialchars($batch['breed']) ?>
                            </td>

                            <td>
                                <?= max(1,$ageWeeks) ?> week(s)
                            </td>

                            <td>
                                <?= htmlspecialchars($batch['quantity']) ?>
                            </td>

                            <td>

                                <span class="badge <?= $statusClass ?>">

                                    <?= ucfirst($batch['status']) ?>

                                </span>

                            </td>

                        </tr>

                    <?php endforeach; ?>

                </tbody>

            </table>

        </div>

    <?php endif; ?>

</div>

<div class="panel">

    <div class="panel-title">
        Mortality Records
    </div>

    <div class="table-wrapper">

        <table>

            <thead>

                <tr>

                    <th>Date</th>
                    <th>Batch</th>
                    <th>Deaths</th>
                    <th>Reason</th>

                </tr>

            </thead>

            <tbody>

                <?php if(empty($mortalityRecords)): ?>

                    <tr>

                        <td colspan="4"
                            style="text-align:center; color:#6b7280;">

                            No records found

                        </td>

                    </tr>

                <?php else: ?>

                    <?php foreach($mortalityRecords as $record): ?>

                        <tr>

                            <td>
                                <?= htmlspecialchars($record['recorded_at']) ?>
                            </td>

                            <td>
                                <?= htmlspecialchars($record['batch_code']) ?>
                            </td>

                            <td>
                                <?= htmlspecialchars($record['deaths']) ?>
                            </td>

                            <td>
                                <?= htmlspecialchars($record['reason']) ?>
                            </td>

                        </tr>

                    <?php endforeach; ?>

                <?php endif; ?>

            </tbody>

        </table>

    </div>

</div>

<!-- BATCH MODAL -->

<div id="batchModal" class="modal">

    <div class="modal-content">

        <div class="modal-header">

            <div class="modal-title">
                Add Batch
            </div>

            <button id="closeBatchModal"
                    class="close-btn">
                ×
            </button>

        </div>

        <form id="batchForm"
              method="post">

            <input type="hidden"
                   name="batch_submission"
                   value="1">

            <div class="form-grid">

                <div class="field">

                    <label>Batch ID</label>

                    <input type="text"
                           name="batch_code"
                           required>

                </div>

                <div class="field">

                    <label>Breed</label>

                    <select name="breed" required>

                        <option value="">Select</option>
                        <option>Leghorn</option>
                        <option>Rhode Island Red</option>
                        <option>Silkie</option>

                    </select>

                </div>

            </div>

            <div class="form-grid">

                <div class="field">

                    <label>Date</label>

                    <input type="date"
                           name="started_at"
                           value="<?= date('Y-m-d') ?>"
                           required>

                </div>

                <div class="field">

                    <label>Quantity</label>

                    <input type="number"
                           name="quantity"
                           min="1"
                           required>

                </div>

            </div>

            <div class="form-actions">

                <button type="submit"
                        class="btn btn-primary">
                    Save
                </button>

                <button type="button"
                        id="cancelBatch"
                        class="btn btn-light">
                    Cancel
                </button>

                <button type="button"
                        id="openMortalityModal"
                        class="btn"
                        style="background:#dc2626;color:white;">
                    Mortality
                </button>

            </div>

        </form>

    </div>

</div>

<!-- MORTALITY MODAL -->

<div id="mortalityModal" class="modal">

    <div class="modal-content">

        <div class="modal-header">

            <div class="modal-title">
                Mortality
            </div>

            <button id="closeMortalityModal"
                    class="close-btn">
                ×
            </button>

        </div>

        <form method="post">

            <input type="hidden"
                   name="mortality_submission"
                   value="1">

            <div class="form-grid">

                <div class="field">

                    <label>Batch</label>

                    <select name="mortality_batch" required>

                        <option value="">Select</option>

                        <?php foreach($batches as $batch): ?>

                            <option value="<?= $batch['id'] ?>">

                                <?= htmlspecialchars($batch['batch_code']) ?>

                            </option>

                        <?php endforeach; ?>

                    </select>

                </div>

                <div class="field">

                    <label>Deaths</label>

                    <input type="number"
                           name="mortality_count"
                           min="0"
                           required>

                </div>

            </div>

            <div class="form-grid">

                <div class="field">

                    <label>Reason</label>

                    <select name="mortality_reason" required>

                        <option value="">Select</option>
                        <option>Illness</option>
                        <option>Predation</option>
                        <option>Feed / Water</option>
                        <option>Other</option>

                    </select>

                </div>

                <div class="field">

                    <label>Date</label>

                    <input type="date"
                           name="mortality_date"
                           value="<?= date('Y-m-d') ?>"
                           required>

                </div>

            </div>

            <div class="field">

                <label>Notes</label>

                <input type="text"
                       name="mortality_notes">

            </div>

            <div class="form-actions">

                <button type="submit"
                        class="btn btn-primary">
                    Save
                </button>

                <button type="button"
                        id="cancelMortality"
                        class="btn btn-light">
                    Cancel
                </button>

            </div>

        </form>

    </div>

</div>

<script>

const batchModal =
document.getElementById('batchModal');

const mortalityModal =
document.getElementById('mortalityModal');

document.getElementById('openBatchModal')
.onclick = () => {
    batchModal.style.display = 'flex';
};

document.getElementById('closeBatchModal')
.onclick = () => {
    batchModal.style.display = 'none';
};

document.getElementById('cancelBatch')
.onclick = () => {
    batchModal.style.display = 'none';
};

document.getElementById('openMortalityModal')
.onclick = () => {
    batchModal.style.display = 'none';
    mortalityModal.style.display = 'flex';
};

document.getElementById('closeMortalityModal')
.onclick = () => {
    mortalityModal.style.display = 'none';
};

document.getElementById('cancelMortality')
.onclick = () => {
    mortalityModal.style.display = 'none';
};

window.onclick = (e) => {

    if(e.target === batchModal){
        batchModal.style.display = 'none';
    }

    if(e.target === mortalityModal){
        mortalityModal.style.display = 'none';
    }

};

</script>

<?php include __DIR__ . '/../includes/footer.php'; ?>