<?php include __DIR__ . '/../includes/header.php'; ?>

<?php
$message = $message ?? '';
$batches = $batches ?? [];
$eggRecords = $eggRecords ?? [];
?>

<style>

    body{
        background:#f4f7fb;
        font-family:Arial,sans-serif;
    }

    .page-header{
        margin-bottom:30px;
    }

    .page-title{
        font-size:34px;
        font-weight:bold;
        color:#111827;
    }

    .page-subtitle{
        margin-top:8px;
        color:#6b7280;
        font-size:15px;
    }

    .message{
        background:#dcfce7;
        color:#166534;
        padding:15px 20px;
        border-radius:12px;
        margin-bottom:25px;
        font-weight:bold;
        box-shadow:0 4px 10px rgba(0,0,0,0.05);
    }

    .dashboard-grid{
        display:grid;
        grid-template-columns:1fr 1.3fr;
        gap:25px;
        margin-bottom:30px;
    }

    .card-panel{
        background:white;
        border-radius:20px;
        padding:25px;
        box-shadow:0 4px 18px rgba(0,0,0,0.06);
    }

    .card-panel h2{
        font-size:24px;
        color:#111827;
        margin-bottom:8px;
    }

    .card-panel p{
        color:#6b7280;
        font-size:14px;
        margin-bottom:20px;
    }

    /* FORM */

    .form-grid{
        display:grid;
        gap:18px;
    }

    .field label{
        display:block;
        margin-bottom:8px;
        font-weight:bold;
        color:#374151;
        font-size:14px;
    }

    .field input,
    .field select{
        width:100%;
        padding:14px;
        border:1px solid #d1d5db;
        border-radius:12px;
        outline:none;
        font-size:15px;
        transition:0.3s;
        background:#fff;
    }

    .field input:focus,
    .field select:focus{
        border-color:#2563eb;
        box-shadow:0 0 0 4px rgba(37,99,235,0.12);
    }

    .button{
        background:#2563eb;
        color:white;
        border:none;
        padding:14px;
        border-radius:12px;
        font-size:15px;
        font-weight:bold;
        cursor:pointer;
        transition:0.3s;
    }

    .button:hover{
        background:#1d4ed8;
        transform:translateY(-2px);
    }

    /* TABLE */

    .table-wrapper{
        overflow-x:auto;
    }

    .table{
        width:100%;
        border-collapse:collapse;
        margin-top:10px;
    }

    .table thead{
        background:#111827;
        color:white;
    }

    .table th{
        padding:15px;
        text-align:left;
        font-size:14px;
    }

    .table td{
        padding:15px;
        border-bottom:1px solid #eee;
        font-size:14px;
        color:#374151;
    }

    .table tbody tr{
        transition:0.3s;
    }

    .table tbody tr:hover{
        background:#f9fafb;
    }

    /* STATS */

    .stats-grid{
        display:grid;
        grid-template-columns:repeat(auto-fit,minmax(220px,1fr));
        gap:20px;
        margin-bottom:25px;
    }

    .stat-card{
        background:white;
        border-radius:18px;
        padding:22px;
        box-shadow:0 4px 18px rgba(0,0,0,0.06);
        position:relative;
        overflow:hidden;
    }

    .stat-card::before{
        content:'';
        position:absolute;
        top:0;
        left:0;
        width:100%;
        height:5px;
        background:#2563eb;
    }

    .stat-title{
        color:#6b7280;
        font-size:14px;
        margin-bottom:10px;
        font-weight:600;
    }

    .stat-value{
        font-size:30px;
        font-weight:bold;
        color:#111827;
    }

    .egg-icon{
        font-size:32px;
    }

    /* MOBILE */

    @media(max-width:900px){

        .dashboard-grid{
            grid-template-columns:1fr;
        }

    }

</style>

<div class="page-header">

    <div class="page-subtitle">
        Record daily egg collection and monitor production activity in real-time.
    </div>

</div>

<?php if ($message): ?>

    <div class="message">
        <?= htmlspecialchars($message) ?>
    </div>

<?php endif; ?>

<!-- STATS -->

<div class="stats-grid">

    <div class="stat-card">

        <div class="stat-title">
            Total Egg Records
        </div>

        <div class="stat-value">
            <?= count($eggRecords) ?>
        </div>

    </div>

    <div class="stat-card">

        <div class="stat-title">
            Active Batches
        </div>

        <div class="stat-value">
            <?= count($batches) ?>
        </div>

    </div>

    <div class="stat-card">

        <div class="stat-title">
            Total Eggs Collected
        </div>

        <div class="stat-value">

            <?php
                $totalEggs = 0;

                foreach($eggRecords as $record){
                    $totalEggs += $record['quantity'];
                }

                echo number_format($totalEggs);
            ?>

        </div>

    </div>

</div>

<!-- MAIN GRID -->

<div class="dashboard-grid">

    <!-- FORM -->

    <div class="card-panel">

        <h2>
            Record Egg Collection
        </h2>

        <p>
            Add new egg collection data from your poultry batches.
        </p>

        <form method="post"
              class="form-grid">

            <div class="field">

                <label for="batch_id">
                    Select Batch
                </label>

                <select id="batch_id"
                        name="batch_id"
                        required>

                    <option value="">
                        Select a batch
                    </option>

                    <?php foreach ($batches as $batch): ?>

                        <option value="<?= $batch['id'] ?>">

                            <?= htmlspecialchars($batch['batch_code']) ?>

                        </option>

                    <?php endforeach; ?>

                </select>

            </div>

            <div class="field">

                <label for="collected_at">
                    Collection Date
                </label>

                <input id="collected_at"
                       name="collected_at"
                       type="date"
                       value="<?= date('Y-m-d') ?>"
                       required />

            </div>

            <div class="field">

                <label for="quantity">
                    Egg Quantity
                </label>

                <input id="quantity"
                       name="quantity"
                       type="number"
                       min="1"
                       value="0"
                       required />

            </div>

            <button class="button"
                    type="submit">

                Save Egg Record

            </button>

        </form>

    </div>

    <!-- QUICK SUMMARY -->

    <div class="card-panel">

        <h2>
            Production Summary
        </h2>

        <p>
            Quick overview of your egg production performance.
        </p>

        <div class="stats-grid"
             style="grid-template-columns:1fr; margin-bottom:0;">

            <div class="stat-card">

                <div class="stat-title">
                    Today's Date
                </div>

                <div class="stat-value"
                     style="font-size:22px;">

                    <?= date('F d, Y') ?>

                </div>

            </div>

            <div class="stat-card">

                <div class="stat-title">
                    Farm Status
                </div>

                <div class="stat-value"
                     style="color:#16a34a;">

                    Healthy

                </div>

            </div>

            <div class="stat-card">

                <div class="stat-title">
                    Egg Production
                </div>

                <div class="stat-value egg-icon">

                    🥚🥚🥚

                </div>

            </div>

        </div>

    </div>

</div>

<!-- TABLE -->

<div class="card-panel">

    <h2>
        Recent Egg Logs
    </h2>

    <p>
        View recently recorded egg collection entries.
    </p>

    <div class="table-wrapper">

        <table class="table">

            <thead>

                <tr>

                    <th>Date</th>
                    <th>Batch</th>
                    <th>Egg Count</th>

                </tr>

            </thead>

            <tbody>

                <?php if(count($eggRecords) > 0): ?>

                    <?php foreach ($eggRecords as $row): ?>

                        <tr>

                            <td>
                                <?= htmlspecialchars($row['collected_at']) ?>
                            </td>

                            <td>
                                <?= htmlspecialchars($row['batch_code']) ?>
                            </td>

                            <td>
                                <?= htmlspecialchars($row['quantity']) ?>
                            </td>

                        </tr>

                    <?php endforeach; ?>

                <?php else: ?>

                    <tr>

                        <td colspan="3"
                            style="text-align:center; padding:30px; color:#6b7280;">

                            No egg records found.

                        </td>

                    </tr>

                <?php endif; ?>

            </tbody>

        </table>

    </div>

</div>

<?php include __DIR__ . '/../includes/footer.php'; ?>