<?php include __DIR__ . '/../includes/header.php'; ?>


<?php
$conn = new mysqli('127.0.0.1', 'root', '', 'poultry');
if ($conn->connect_error) {
    die('Database connection failed: ' . $conn->connect_error);
}

$message = '';

$totalChickens = $totalChickens ?? 0;
$dailyEggs = $dailyEggs ?? 0;
$feedInventoryKg = $feedInventoryKg ?? 0;
$monthlyNetProfit = $monthlyNetProfit ?? 0;

$batches = $batches ?? [];

$eggTrend = $eggTrend ?? [
    'labels' => [],
    'data' => []
];

/* =====================================
   ADD PRODUCT
===================================== */

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_product'])) {

    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $price = (float) $_POST['price'];
    $quantity = (int) $_POST['quantity'];
    $category = mysqli_real_escape_string($conn, $_POST['category']);

    mysqli_query(
        $conn,
        "INSERT INTO products
        (
            name,
            price,
            available_quantity,
            category
        )
        VALUES
        (
            '$name',
            '$price',
            '$quantity',
            '$category'
        )"
    );

    $message = "Product added successfully!";
}

/* =====================================
   UPDATE PRODUCT
===================================== */

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_product'])) {

    $id = (int) $_POST['id'];

    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $price = (float) $_POST['price'];
    $quantity = (int) $_POST['quantity'];
    $category = mysqli_real_escape_string($conn, $_POST['category']);

    mysqli_query(
        $conn,
        "UPDATE products
         SET
            name='$name',
            price='$price',
            available_quantity='$quantity',
            category='$category'
         WHERE id='$id'"
    );

    $message = "Product updated successfully!";
}

/* =====================================
   DELETE PRODUCT
===================================== */

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_product'])) {

    $id = (int) $_POST['id'];

    mysqli_query(
        $conn,
        "DELETE FROM products
         WHERE id='$id'"
    );

    $message = "Product deleted successfully!";
}

/* =====================================
   UPDATE ORDER
===================================== */

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_order'])) {

    $id = (int) $_POST['id'];

    $quantity = (int) $_POST['quantity'];

    $status = mysqli_real_escape_string(
        $conn,
        $_POST['status']
    );

    mysqli_query(
        $conn,
        "UPDATE orders
         SET
            quantity='$quantity',
            status='$status'
         WHERE id='$id'"
    );

    $message = "Order updated successfully!";
}

/* =====================================
   DELETE ORDER
===================================== */

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_order'])) {

    $id = (int) $_POST['id'];

    mysqli_query(
        $conn,
        "DELETE FROM orders
         WHERE id='$id'"
    );

    $message = "Order deleted successfully!";
}

/* =====================================
   FETCH PRODUCTS
===================================== */

$productQuery = mysqli_query(
    $conn,
    "SELECT *
     FROM products
     ORDER BY id DESC"
);

$products = mysqli_fetch_all(
    $productQuery,
    MYSQLI_ASSOC
);

/* =====================================
   FETCH ORDERS
===================================== */

$orderQuery = mysqli_query(
    $conn,
    "SELECT
        orders.*,
        users.name AS customer_name,
        products.name AS product_name
     FROM orders
     LEFT JOIN users
        ON users.id = orders.user_id
     LEFT JOIN products
        ON products.id = orders.product_id
     ORDER BY orders.id DESC"
);

$orders = mysqli_fetch_all(
    $orderQuery,
    MYSQLI_ASSOC
);

?>

<style>

    body{
        background:#f4f7fb;
        font-family:Arial,sans-serif;
    }

    .dashboard-header{
        margin-bottom:30px;
    }

    .dashboard-title{
        font-size:34px;
        font-weight:bold;
        color:#111827;
    }

    .dashboard-subtitle{
        margin-top:8px;
        color:#6b7280;
        font-size:15px;
    }

    .success-message{
        background:#16a34a;
        color:white;
        padding:14px 18px;
        border-radius:12px;
        margin-bottom:20px;
        font-weight:600;
    }

    .stats-grid{
        display:grid;
        grid-template-columns:repeat(auto-fit,minmax(240px,1fr));
        gap:20px;
        margin-bottom:30px;
    }

    .stat-card{
        background:white;
        border-radius:18px;
        padding:25px;
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
        font-size:34px;
        font-weight:bold;
        color:#111827;
    }

    .stat-profit{
        color:#16a34a;
    }

    .dashboard-grid{
        display:grid;
        grid-template-columns:2fr 1fr;
        gap:25px;
        margin-bottom:30px;
    }

    .panel{
        background:white;
        border-radius:18px;
        padding:25px;
        box-shadow:0 4px 18px rgba(0,0,0,0.06);
    }

    .panel h2{
        font-size:22px;
        margin-bottom:8px;
        color:#111827;
    }

    .panel p{
        color:#6b7280;
        font-size:14px;
        margin-bottom:20px;
    }

    .quick-info{
        display:flex;
        flex-direction:column;
        gap:18px;
    }

    .info-box{
        background:#f9fafb;
        padding:18px;
        border-radius:14px;
    }

    .info-box h3{
        font-size:15px;
        margin-bottom:8px;
        color:#374151;
    }

    .info-box span{
        font-size:24px;
        font-weight:bold;
        color:#111827;
    }

    .open-modal-btn{
        border:none;
        background:#2563eb;
        color:white;
        padding:12px;
        border-radius:12px;
        cursor:pointer;
        font-weight:600;
    }

    .modal{
        display:none;
        position:fixed;
        z-index:9999;
        left:0;
        top:0;
        width:100%;
        height:100%;
        background:rgba(0,0,0,0.45);
        justify-content:center;
        align-items:center;
        padding:20px;
    }

    .modal-content{
        background:white;
        width:100%;
        max-width:1100px;
        border-radius:20px;
        padding:25px;
        position:relative;
        max-height:95vh;
        overflow-y:auto;
    }

    .close-btn{
        position:absolute;
        top:15px;
        right:20px;
        font-size:30px;
        cursor:pointer;
    }

    .modal-title{
        font-size:24px;
        font-weight:bold;
        margin-bottom:6px;
        color:#111827;
    }

    .modal-subtitle{
        color:#6b7280;
        margin-bottom:25px;
        font-size:14px;
    }

    .modal-table{
        width:100%;
        border-collapse:collapse;
    }

    .modal-table th{
        background:#111827;
        color:white;
    }

    .modal-table th,
    .modal-table td{
        padding:12px;
        border-bottom:1px solid #eee;
        font-size:14px;
    }

    .input{
        width:90%;
        padding:10px;
        border-radius:10px;
        border:1px solid #d1d5db;
        outline:none;
    }

    .form-grid{
        display:grid;
        grid-template-columns:repeat(auto-fit,minmax(180px,1fr));
        gap:14px;
        margin-bottom:25px;
    }

    .add-btn{
        background:#2563eb;
        color:white;
        border:none;
        padding:13px 18px;
        border-radius:12px;
        cursor:pointer;
        font-weight:600;
    }

    .action-btn{
        border:none;
        padding:10px 14px;
        border-radius:10px;
        color:white;
        cursor:pointer;
        font-size:13px;
        font-weight:600;
    }

    .save-btn{
        background:#16a34a;
    }

    .delete-btn{
        background:#dc2626;
    }

    @media(max-width:900px){

        .dashboard-grid{
            grid-template-columns:1fr;
        }

    }

</style>

<div class="dashboard-header">

    <div class="dashboard-title">
        Poultry Farm Dashboard
    </div>

</div>

<?php if($message): ?>

    <div class="success-message">

        <?= htmlspecialchars($message) ?>

    </div>

<?php endif; ?>


<div class="stats-grid">

    <div class="stat-card">

        <div class="stat-title">
            Total Chickens
        </div>

        <div class="stat-value">
            <?= number_format($totalChickens) ?>
        </div>

    </div>

    <div class="stat-card">

        <div class="stat-title">
            Daily Egg Count
        </div>

        <div class="stat-value">
            <?= number_format($dailyEggs) ?>
        </div>

    </div>

    <div class="stat-card">

        <div class="stat-title">
            Feed Inventory
        </div>

        <div class="stat-value">
            <?= number_format($feedInventoryKg,1) ?> kg
        </div>

    </div>

    <div class="stat-card">

        <div class="stat-title">
            Monthly Profit
        </div>

        <div class="stat-value stat-profit">
            ₱<?= number_format($monthlyNetProfit,2) ?>
        </div>

    </div>

</div>

<!-- MAIN -->

<div class="dashboard-grid">

    <div class="panel">

        <h2>
            Egg Production Trend
        </h2>

        <p>
            Daily collection overview.
        </p>

        <div style="height:300px;">

            <canvas id="eggTrendChart"></canvas>

        </div>

    </div>

    <div class="panel">

        <h2>
            Quick Actions
        </h2>

        <p>
            Manage products and orders.
        </p>

        <div class="quick-info">

            <div class="info-box">

                <h3>
                    Active Batches
                </h3>

                <span>
                    <?= count($batches) ?>
                </span>

            </div>

            <button class="open-modal-btn"
                    id="openProductsModal">

                Manage Products

            </button>

            <button class="open-modal-btn"
                    id="openOrdersModal">

                Manage Orders

            </button>

            
            <button class="open-modal-btn"
                    id="openFeedsModal">

                Manage Feeds Inventory

            </button>


        </div>

    </div>

</div>

<!-- PRODUCTS MODAL -->

<div class="modal"
     id="productsModal">

    <div class="modal-content">

        <span class="close-btn"
              id="closeProductsModal">

            &times;

        </span>

        <div class="modal-title">
            Products
        </div>

        <div class="modal-subtitle">
            Add, edit, and delete products.
        </div>

        <!-- ADD PRODUCT -->

        <form method="post"
              class="form-grid">

            <input type="hidden"
                   name="add_product"
                   value="1">

            <input class="input"
                   type="text"
                   name="name"
                   placeholder="Product name"
                   required>

            <input class="input"
                   type="number"
                   step="0.01"
                   name="price"
                   placeholder="Price"
                   required>

            <input class="input"
                   type="number"
                   name="quantity"
                   placeholder="Stock"
                   required>

            <select class="input"
                    name="category">

                <option value="eggs">Eggs</option>
                <option value="feed">Feed</option>
                <option value="fertilizer">Fertilizer</option>

            </select>

            <button class="add-btn"
                    type="submit">

                Add Product

            </button>

        </form>

        <!-- PRODUCTS TABLE -->

        <div style="overflow-x:auto;">

            <table class="modal-table">

                <thead>

                    <tr>

                        <th>Name</th>
                        <th>Price</th>
                        <th>Stock</th>
                        <th>Category</th>
                        <th>Actions</th>

                    </tr>

                </thead>

                <tbody>

                    <?php if(!empty($products)): ?>

                        <?php foreach($products as $product): ?>

                            <tr>

                                <form method="post">

                                    <td>

                                        <input type="hidden"
                                               name="update_product"
                                               value="1">

                                        <input type="hidden"
                                               name="id"
                                               value="<?= $product['id'] ?>">

                                        <input class="input"
                                               type="text"
                                               name="name"
                                               value="<?= htmlspecialchars($product['name']) ?>"
                                               required>

                                    </td>

                                    <td>

                                        <input class="input"
                                               type="number"
                                               step="0.01"
                                               name="price"
                                               value="<?= $product['price'] ?>"
                                               required>

                                    </td>

                                    <td>

                                        <input class="input"
                                               type="number"
                                               name="quantity"
                                               value="<?= $product['available_quantity'] ?>"
                                               required>

                                    </td>

                                    <td>

                                        <select class="input"
                                                name="category">

                                            <option value="eggs"
                                                <?= $product['category']=='eggs' ? 'selected' : '' ?>>
                                                Eggs
                                            </option>

                                            <option value="feed"
                                                <?= $product['category']=='feed' ? 'selected' : '' ?>>
                                                Feed
                                            </option>

                                            <option value="fertilizer"
                                                <?= $product['category']=='fertilizer' ? 'selected' : '' ?>>
                                                Fertilizer
                                            </option>

                                        </select>

                                    </td>

                                    <td style="display:flex;gap:8px;">

                                        <button type="submit"
                                                class="action-btn save-btn">

                                            Save

                                        </button>

                                </form>

                                <form method="post"
                                      onsubmit="return confirm('Delete product?')">

                                    <input type="hidden"
                                           name="delete_product"
                                           value="1">

                                    <input type="hidden"
                                           name="id"
                                           value="<?= $product['id'] ?>">

                                    <button type="submit"
                                            class="action-btn delete-btn">

                                        Delete

                                    </button>

                                </form>

                                    </td>

                            </tr>

                        <?php endforeach; ?>

                    <?php else: ?>

                        <tr>

                            <td colspan="5"
                                style="text-align:center;padding:30px;">

                                No products found.

                            </td>

                        </tr>

                    <?php endif; ?>

                </tbody>

            </table>

        </div>

    </div>

</div>

<!-- ORDERS MODAL -->

<div class="modal"
     id="ordersModal">

    <div class="modal-content">

        <span class="close-btn"
              id="closeOrdersModal">

            &times;

        </span>

        <div class="modal-title">
            Orders
        </div>

        <div class="modal-subtitle">
            Update and delete orders.
        </div>

        <div style="overflow-x:auto;">

            <table class="modal-table">

                <thead>

                    <tr>

                        <th>Customer</th>
                        <th>Product</th>
                        <th>Quantity</th>
                        <th>Status</th>
                        <th>Actions</th>

                    </tr>

                </thead>

                <tbody>

                    <?php if(!empty($orders)): ?>

                        <?php foreach($orders as $order): ?>

                            <tr>

                                <form method="post">

                                    <td>

                                        <?= htmlspecialchars($order['customer_name']) ?>

                                        <input type="hidden"
                                               name="update_order"
                                               value="1">

                                        <input type="hidden"
                                               name="id"
                                               value="<?= $order['id'] ?>">

                                    </td>

                                    <td>

                                        <?= htmlspecialchars($order['product_name']) ?>

                                    </td>

                                    <td>

                                        <input class="input"
                                               type="number"
                                               name="quantity"
                                               value="<?= $order['quantity'] ?>"
                                               required>

                                    </td>

                                    <td>

                                        <select class="input"
                                                name="status">

                                            <option value="pending"
                                                <?= $order['status']=='pending' ? 'selected' : '' ?>>
                                                Pending
                                            </option>

                                            <option value="approved"
                                                <?= $order['status']=='approved' ? 'selected' : '' ?>>
                                                Approved
                                            </option>

                                            <option value="completed"
                                                <?= $order['status']=='completed' ? 'selected' : '' ?>>
                                                Completed
                                            </option>

                                        </select>

                                    </td>

                                    <td style="display:flex;gap:8px;">

                                        <button type="submit"
                                                class="action-btn save-btn">

                                            Update

                                        </button>

                                </form>

                                <form method="post"
                                      onsubmit="return confirm('Delete order?')">

                                    <input type="hidden"
                                           name="delete_order"
                                           value="1">

                                    <input type="hidden"
                                           name="id"
                                           value="<?= $order['id'] ?>">

                                    <button type="submit"
                                            class="action-btn delete-btn">

                                        Delete

                                    </button>

                                </form>

                                    </td>

                            </tr>

                        <?php endforeach; ?>

                    <?php else: ?>

                        <tr>

                            <td colspan="5"
                                style="text-align:center;padding:30px;">

                                No orders found.

                            </td>

                        </tr>

                    <?php endif; ?>

                </tbody>

            </table>

        </div>

    </div>

</div>

<script>

    const labels =
    <?= json_encode($eggTrend['labels'], JSON_HEX_TAG) ?>;

    const data =
    <?= json_encode($eggTrend['data'], JSON_HEX_TAG) ?>;

    new Chart(
        document.getElementById('eggTrendChart'),
        {
            type:'line',

            data:{
                labels,
                datasets:[{
                    label:'Eggs Collected',
                    data,
                    borderColor:'#2563eb',
                    backgroundColor:'rgba(37,99,235,0.1)',
                    borderWidth:3,
                    fill:true,
                    tension:0.4
                }]
            },

            options:{
                responsive:true,
                maintainAspectRatio:false,
                plugins:{
                    legend:{
                        display:false
                    }
                },
                scales:{
                    y:{
                        beginAtZero:true
                    }
                }
            }
        }
    );

    // PRODUCTS MODAL

    const productsModal =
    document.getElementById('productsModal');

    document.getElementById('openProductsModal')
    .onclick = () => {

        productsModal.style.display =
        'flex';

    };

    document.getElementById('closeProductsModal')
    .onclick = () => {

        productsModal.style.display =
        'none';

    };

    // ORDERS MODAL

    const ordersModal =
    document.getElementById('ordersModal');

    document.getElementById('openOrdersModal')
    .onclick = () => {

        ordersModal.style.display =
        'flex';

    };

    document.getElementById('closeOrdersModal')
    .onclick = () => {

        ordersModal.style.display =
        'none';

    };

    // CLOSE OUTSIDE

    window.onclick = (e) => {

        if(e.target == productsModal){

            productsModal.style.display =
            'none';

        }

        if(e.target == ordersModal){

            ordersModal.style.display =
            'none';

        }

    };

</script>

<?php include __DIR__ . '/../includes/footer.php'; ?>