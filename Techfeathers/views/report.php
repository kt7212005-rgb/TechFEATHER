<?php include __DIR__ . '/../includes/header.php'; ?>

<?php
$recentExports = $recentExports ?? [];
$totalEggsThisMonth = $totalEggsThisMonth ?? 0;
$feedConversion = $feedConversion ?? 0;
$avgMortality = $avgMortality ?? 0;
$trendLabels = $trendLabels ?? [];
$trendValues = $trendValues ?? [];
$financialTrend = $financialTrend ?? [
    'labels' => [],
    'income' => [],
    'expenses' => []
];
?>

<style>

    body{
        background:#f4f7fb;
        font-family:Arial,sans-serif;
    }

    .reports-container{
        display:grid;
        grid-template-columns:320px 1fr;
        gap:24px;
    }

    .panel{
        background:#fff;
        border-radius:20px;
        padding:24px;
        box-shadow:0 4px 18px rgba(0,0,0,0.06);
    }

    .panel-title{
        font-size:24px;
        font-weight:700;
        color:#111827;
        margin-bottom:6px;
    }

    .panel-subtitle{
        color:#6b7280;
        font-size:14px;
        margin-bottom:24px;
    }

    .section-title{
        font-size:14px;
        font-weight:700;
        color:#374151;
        margin-bottom:10px;
    }

    .button-group{
        display:flex;
        flex-wrap:wrap;
        gap:10px;
        margin-bottom:22px;
    }

    .option-btn{
        border:none;
        background:#f3f4f6;
        color:#111827;
        padding:12px 16px;
        border-radius:12px;
        cursor:pointer;
        font-weight:600;
        transition:.3s;
    }

    .option-btn:hover{
        background:#e5e7eb;
    }

    .option-btn.active{
        background:#2563eb;
        color:#fff;
    }

    .date-grid{
        display:grid;
        grid-template-columns:1fr 1fr;
        gap:12px;
        margin-bottom:22px;
    }

    .date-grid input{
        padding:12px;
        border-radius:12px;
        border:1px solid #d1d5db;
        background:#fff;
    }

    .generate-btn{
        width:100%;
        border:none;
        background:#2563eb;
        color:#fff;
        padding:14px;
        border-radius:14px;
        font-size:15px;
        font-weight:700;
        cursor:pointer;
        transition:.3s;
    }

    .generate-btn:hover{
        opacity:.9;
    }

    .stats-grid{
        display:grid;
        grid-template-columns:repeat(auto-fit,minmax(180px,1fr));
        gap:18px;
        margin-bottom:24px;
    }

    .stat-card{
        background:#f9fafb;
        border-radius:18px;
        padding:20px;
    }

    .stat-title{
        font-size:13px;
        color:#6b7280;
        margin-bottom:8px;
        font-weight:600;
    }

    .stat-value{
        font-size:28px;
        font-weight:700;
        color:#111827;
    }

    .recent-list{
        display:grid;
        gap:12px;
        margin-top:18px;
    }

    .recent-item{
        display:flex;
        justify-content:space-between;
        align-items:center;
        padding:14px;
        border-radius:14px;
        background:#f9fafb;
    }

    .recent-name{
        font-weight:600;
        color:#111827;
    }

    .recent-time{
        font-size:13px;
        color:#6b7280;
        margin-top:4px;
    }

    .download-btn{
        background:#2563eb;
        color:#fff;
        border:none;
        padding:10px 14px;
        border-radius:10px;
        cursor:pointer;
        font-size:13px;
        font-weight:600;
    }

    .chart-box{
        background:#f9fafb;
        border-radius:18px;
        padding:20px;
    }

    .chart-title{
        font-size:18px;
        font-weight:700;
        color:#111827;
        margin-bottom:18px;
    }

    #reportTrendChart{
        width:100%;
        height:320px !important;
    }

    @media(max-width:950px){

        .reports-container{
            grid-template-columns:1fr;
        }

    }

</style>

<div class="reports-container">

    <div class="panel">


        <div class="panel-subtitle">
            Generate and export farm reports.
        </div>

        <form id="reportForm" method="post" action="reports.php?action=generate">

            <input type="hidden" name="report_type" id="reportType" value="batch_performance">

            <input type="hidden" name="start_date" id="startDate"
                   value="<?= date('Y-m-d', strtotime('-30 days')) ?>">

            <input type="hidden" name="end_date" id="endDate"
                   value="<?= date('Y-m-d') ?>">

            <input type="hidden" name="format" id="reportFormat" value="pdf">

        </form>

        <div class="section-title">
            Report Type
        </div>

        <div class="button-group">

            <button class="option-btn active report-template-btn"
                    type="button"
                    data-type="batch_performance">

                Batch

            </button>

            <button class="option-btn report-template-btn"
                    type="button"
                    data-type="financial">

                Financial

            </button>

            <button class="option-btn report-template-btn"
                    type="button"
                    data-type="feed_inventory">

                Feed

            </button>

        </div>

        <div class="section-title">
            Date Range
        </div>

        <div class="date-grid">

            <input type="date"
                   id="dateStart"
                   value="<?= date('Y-m-d', strtotime('-30 days')) ?>">

            <input type="date"
                   id="dateEnd"
                   value="<?= date('Y-m-d') ?>">

        </div>

        <div class="section-title">
            Format
        </div>

        <div class="button-group">

            <button class="option-btn active export-format-btn"
                    type="button"
                    data-format="pdf">

                PDF

            </button>

            <button class="option-btn export-format-btn"
                    type="button"
                    data-format="excel">

                Excel

            </button>

            <button class="option-btn export-format-btn"
                    type="button"
                    data-format="json">

                JSON

            </button>

        </div>

        <button id="generateReportBtn"
                class="generate-btn"
                type="button">

            Generate Report

        </button>

        <div style="margin-top:30px;">

            <div class="section-title">
                Recent Exports
            </div>

            <div class="recent-list">

                <?php foreach ($recentExports as $export): ?>

                    <div class="recent-item">

                        <div>

                            <div class="recent-name">
                                <?= htmlspecialchars($export['name']) ?>
                            </div>

                            <div class="recent-time">
                                <?= htmlspecialchars($export['time']) ?>
                            </div>

                        </div>

                    </div>

                <?php endforeach; ?>

            </div>

        </div>

    </div>

    <div class="panel">

        <div class="panel-title">
            Analytics
        </div>

        <div class="panel-subtitle">
            Farm performance overview.
        </div>

        <div class="stats-grid">

            <div class="stat-card">

                <div class="stat-title">
                    Egg Production
                </div>

                <div class="stat-value">
                    <?= number_format($totalEggsThisMonth) ?>
                </div>

            </div>

            <div class="stat-card">

                <div class="stat-title">
                    Feed Conversion
                </div>

                <div class="stat-value">
                    <?= number_format($feedConversion, 2) ?>
                </div>

            </div>

            <div class="stat-card">

                <div class="stat-title">
                    Mortality
                </div>

                <div class="stat-value">
                    <?= number_format($avgMortality, 1) ?>%
                </div>

            </div>

        </div>

        <div class="chart-box">

            <div class="chart-title">
                Production & Financial Trend
            </div>

            <canvas id="reportTrendChart"></canvas>

        </div>

    </div>

</div>

<script>

    const reportLabels =
    <?= json_encode($trendLabels, JSON_HEX_TAG) ?>;

    const eggData =
    <?= json_encode($trendValues, JSON_HEX_TAG) ?>;

    const incomeData =
    <?= json_encode($financialTrend['income'], JSON_HEX_TAG) ?>;

    const expenseData =
    <?= json_encode($financialTrend['expenses'], JSON_HEX_TAG) ?>;

    new Chart(
        document.getElementById('reportTrendChart'),
        {
            type:'line',

            data:{
                labels:reportLabels,

                datasets:[

                    {
                        label:'Eggs',
                        data:eggData,
                        borderColor:'#16a34a',
                        backgroundColor:'rgba(22,163,74,0.1)',
                        fill:true,
                        tension:0.4,
                        borderWidth:3
                    },

                    {
                        label:'Income',
                        data:incomeData,
                        borderColor:'#2563eb',
                        backgroundColor:'rgba(37,99,235,0.08)',
                        fill:true,
                        tension:0.4,
                        borderWidth:3
                    },

                    {
                        label:'Expenses',
                        data:expenseData,
                        borderColor:'#dc2626',
                        backgroundColor:'rgba(220,38,38,0.08)',
                        fill:true,
                        tension:0.4,
                        borderWidth:3
                    }

                ]
            },

            options:{
                responsive:true,
                maintainAspectRatio:false,

                plugins:{
                    legend:{
                        position:'top'
                    }
                },

                scales:{
                    y:{
                        beginAtZero:true,
                        ticks:{
                            precision:0
                        }
                    }
                }
            }
        }
    );

    // REPORT TYPE

    document.querySelectorAll('.report-template-btn')
    .forEach(button => {

        button.addEventListener('click', function(){

            document.querySelectorAll('.report-template-btn')
            .forEach(btn => btn.classList.remove('active'));

            this.classList.add('active');

            document.getElementById('reportType').value =
            this.dataset.type;

        });

    });

    // FORMAT

    document.querySelectorAll('.export-format-btn')
    .forEach(button => {

        button.addEventListener('click', function(){

            document.querySelectorAll('.export-format-btn')
            .forEach(btn => btn.classList.remove('active'));

            this.classList.add('active');

            document.getElementById('reportFormat').value =
            this.dataset.format;

        });

    });

    // DATE

    document.getElementById('dateStart')
    .addEventListener('change', function(){

        document.getElementById('startDate').value =
        this.value;

    });

    document.getElementById('dateEnd')
    .addEventListener('change', function(){

        document.getElementById('endDate').value =
        this.value;

    });

    // GENERATE

    document.getElementById('generateReportBtn')
    .addEventListener('click', function(){

        const btn = this;

        btn.innerText = 'Generating...';

        btn.disabled = true;

        setTimeout(() => {

            document.getElementById('reportForm').submit();

        }, 700);

    });

</script>

<?php include __DIR__ . '/../includes/footer.php'; ?>