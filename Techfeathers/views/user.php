<?php include __DIR__ . '/../includes/header.php'; ?>

<?php
$message = $message ?? '';
$users = $users ?? [];
?>

<style>
    .users-container{
        max-width: 1100px;
        margin: 30px auto;
        padding: 20px;
    }

    .users-card{
        background: #fff;
        border-radius: 18px;
        padding: 25px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.08);
    }

    .users-header{
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
        flex-wrap: wrap;
        gap: 10px;
    }

    .users-header h2{
        margin: 0;
        font-size: 28px;
        color: #222;
    }

    .users-count{
        background: #f4f6f9;
        padding: 8px 15px;
        border-radius: 10px;
        font-size: 14px;
        color: #555;
        font-weight: 600;
    }

    .message{
        background: #e8f5e9;
        color: #2e7d32;
        padding: 14px 18px;
        border-radius: 12px;
        margin-bottom: 20px;
        font-weight: 500;
        border-left: 5px solid #43a047;
    }

    .table-wrapper{
        overflow-x: auto;
    }

    .table{
        width: 100%;
        border-collapse: collapse;
        min-width: 700px;
    }

    .table thead{
        background: #f8f9fc;
    }

    .table th{
        padding: 15px;
        text-align: left;
        font-size: 14px;
        color: #555;
        text-transform: uppercase;
        letter-spacing: .5px;
    }

    .table td{
        padding: 16px 15px;
        border-top: 1px solid #eee;
        color: #333;
        font-size: 15px;
    }

    .table tbody tr{
        transition: 0.2s ease;
    }

    .table tbody tr:hover{
        background: #f9fbfd;
    }

    .role-badge{
        display: inline-block;
        padding: 6px 12px;
        border-radius: 30px;
        font-size: 13px;
        font-weight: 600;
        text-transform: capitalize;
    }

    .role-admin{
        background: #ffeaea;
        color: #d63031;
    }

    .role-user{
        background: #eaf4ff;
        color: #0984e3;
    }

    .empty-state{
        text-align: center;
        padding: 40px 20px;
        color: #888;
        font-size: 16px;
    }

    @media (max-width: 768px){
        .users-header{
            flex-direction: column;
            align-items: flex-start;
        }

        .users-header h2{
            font-size: 24px;
        }
    }
</style>

<div class="users-container">

    <?php if ($message): ?>
        <div class="message">
            <?= htmlspecialchars($message) ?>
        </div>
    <?php endif; ?>

    <div class="users-card">

        <div class="users-header">
            <h2>Existing Users</h2>
            <div class="users-count">
                Total Users: <?= count($users) ?>
            </div>
        </div>

        <div class="table-wrapper">
            <table class="table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Created</th>
                    </tr>
                </thead>

                <tbody>
                    <?php if (!empty($users)): ?>
                        
                        <?php foreach ($users as $user): ?>
                            <tr>
                                <td>
                                    <?= htmlspecialchars($user['name']) ?>
                                </td>

                                <td>
                                    <?= htmlspecialchars($user['email']) ?>
                                </td>

                                <td>
                                    <span class="role-badge role-<?= htmlspecialchars($user['role']) ?>">
                                        <?= htmlspecialchars(ucfirst($user['role'])) ?>
                                    </span>
                                </td>

                                <td>
                                    <?= htmlspecialchars($user['created_at']) ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>

                    <?php else: ?>

                        <tr>
                            <td colspan="4">
                                <div class="empty-state">
                                    No users found.
                                </div>
                            </td>
                        </tr>

                    <?php endif; ?>
                </tbody>
            </table>
        </div>

    </div>
</div>

<?php include __DIR__ . '/../includes/footer.php'; ?>