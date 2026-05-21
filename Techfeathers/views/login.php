<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Poultry Management - Login</title>
    <link rel="stylesheet" href="assets/css/style.css" />

    <style>
        body{
            margin:0;
            padding: 0;
            min-height:100vh;
            display:flex;
            justify-content:center;
            align-items:center;
            background:url('assets/images/manukan.png') center/cover fixed no-repeat;
            font-family:Arial, sans-serif;
        }

        .login-container{
            width:100%;
            max-width:900px;
            display:flex;
            align-items:center;
            justify-content:space-between;
            gap:60px;
            padding:40px;
        }

        .logo-side{
            flex:1;
            display:flex;
            justify-content:center;
            align-items:center;
        }

        .logo-side img{
            width: 100%;
            max-width:100%;
        }

        .login-card{
            flex:1;
            max-width:320px;
            background:#fff;
            padding:30px;
            border-radius:20px;
            box-shadow:0 10px 25px rgba(0,0,0,0.08);
        }

        @media(max-width:900px){

            .login-container{
                flex-direction:column;
                text-align:center;
            }

            .login-card{
                width:100%;
            }

            .logo-side img{
                width:220px;
            }
        }
    </style>
</head>
<body>

    <div class="login-container">

        <div class="logo-side">
            <img src="assets/images/logoo.png" alt="Logo">
        </div>

        <div class="login-card card">
            <form class="form" method="post" novalidate>
                <h1>TECHFEATHERS LOGIN</h1>

                <?php $error = $error ?? ''; ?>

                <?php if ($error): ?>
                    <div class="message"><?= htmlspecialchars($error) ?></div>
                <?php endif; ?>

                <div class="field">
                    <label for="email">Email</label>
                    <input id="email" name="email" type="email" placeholder="admin@poultry.local" required autofocus />
                </div>

                <div class="field">
                    <label for="password">Password</label>
                    <input id="password" name="password" type="password" placeholder="Password" required />
                </div>

                <div style="display:flex; justify-content: space-between; align-items: center; margin-bottom: 18px;">
                    <a href="forgot_password.php" style="font-size:0.9rem;">Forgot Password?</a>
                </div>

                <button class="button" type="submit">Log In</button>

                <div style="text-align: center; margin-top: 16px;">
                    <a href="register.php" style="color: var(--muted); text-decoration: none;">Don't have an account? Create one here</a>
                </div>
            </form>
        </div>

    </div>

</body>
</html>