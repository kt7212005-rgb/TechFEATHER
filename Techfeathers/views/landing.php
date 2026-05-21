<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Techfeathers Poultry Management</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        body {
            margin: 0;
            min-height: 140vh;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
            background: linear-gradient(180deg, rgba(237, 242, 255, 0.95) 0%, rgba(243, 247, 255, 0.90) 60%, rgba(255, 255, 255, 0.92) 100%), url('assets/images/manukan.png') center/cover fixed no-repeat;
            color: #0f172a;
        }

        .wrapper {
            max-width: 1180px;
            margin: 0 auto;
            padding: 28px 22px 48px;
        }

        .topbar {
            display: grid;
            gap: 10px;
            padding: 0;
        }

        .topbar-announce {
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
            align-items: center;
            gap: 12px;
            padding: 10px 18px;
            background: #2563eb;
            color: white;
            border-radius: 18px;
            font-size: 0.94rem;
            font-weight: 600;
        }

        .topbar-main {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            align-items: center;
            gap: 16px;
            padding: 18px 22px;
            background: rgba(255, 255, 255, 0.80);
            border: 1px solid rgba(37, 99, 235, 0.14);
            border-radius: 18px;
            box-shadow: 0 16px 42px rgba(15, 23, 42, 0.08);
            backdrop-filter: blur(12px);
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .brand-logo {
            width: 48px;
            height: 48px;
            border-radius: 14px;
            background: #2563eb;
            display: grid;
            place-items: center;
            color: white;
            font-weight: 800;
            font-size: 1.1rem;
        }

        .brand-text strong {
            display: block;
            font-size: 1rem;
            color: #0f172a;
        }

        .brand-text span {
            display: block;
            color: #475569;
            font-size: 0.85rem;
        }

        .nav-links {
            display: flex;
            flex-wrap: wrap;
            gap: 14px;
            margin: 0;
            padding: 0;
            list-style: none;
        }

        .topbar-contact {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            align-items: center;
            color: #1e3a8a;
            font-size: 0.92rem;
        }

        .topbar-contact span,
        .topbar-contact a {
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .topbar-contact a {
            color: #2563eb;
            text-decoration: none;
            font-weight: 700;
        }

        .nav-links a {
            display: inline-flex;
            align-items: center;
            padding: 10px 14px;
            border-radius: 999px;
            color: #1e3a8a;
            text-decoration: none;
            font-weight: 600;
        }

        .nav-links a.active,
        .nav-links a:hover {
            background: #eff6ff;
        }

        .topbar-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
        }

        .button-primary,
        .button-secondary {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 12px 22px;
            border-radius: 14px;
            text-decoration: none;
            font-weight: 700;
            transition: transform 0.2s ease, background 0.2s ease;
        }

        .button-primary {
            background: #2563eb;
            color: white;
            border: 1px solid transparent;
        }

        .button-secondary {
            background: white;
            color: #2563eb;
            border: 1px solid rgba(37, 99, 235, 0.22);
        }

        .button-primary:hover {
            background: #1d4ed8;
            transform: translateY(-1px);
        }

        .button-secondary:hover {
            background: #eff6ff;
            transform: translateY(-1px);
        }

        .hero {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 32px;
            align-items: center;
            margin-top: 32px;
        }

        .hero-copy {
            display: grid;
            gap: 22px;
        }

        .eyebrow {
            font-size: 0.82rem;
            letter-spacing: 0.18em;
            text-transform: uppercase;
            color: #2563eb;
            font-weight: 700;
        }

        .hero-copy h1 {
            margin: 0;
            font-size: clamp(3rem, 4vw, 4.4rem);
            line-height: 1.02;
            color: #0f172a;
        }

        .hero-copy p {
            margin: 0;
            max-width: 620px;
            line-height: 1.75;
            color: #475569;
            font-size: 1.05rem;
        }

        .hero-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 16px;
        }

        .hero-stats {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 16px;
            margin-top: 12px;
        }

        .hero-stat {
            padding: 18px 20px;
            border-radius: 18px;
            background: #eff6ff;
            border: 1px solid rgba(37, 99, 235, 0.14);
            color: #0f172a;
            font-weight: 600;
        }

        .hero-stat strong {
            display: block;
            font-size: 1rem;
            color: #2563eb;
            margin-bottom: 4px;
        }

        .hero-image {
            position: relative;
            overflow: hidden;
            min-height: 520px;
            border-radius: 30px;
            background: #dbeafe;
            border: 1px solid rgba(37, 99, 235, 0.16);
            box-shadow: 0 26px 80px rgba(15, 23, 42, 0.12);
        }

        .hero-image img {
            width: 100%;
            min-height: 520px;
            object-fit: cover;
            display: block;
        }

        .hero-image::after {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(180deg, rgba(37, 99, 235, 0.18), rgba(255, 255, 255, 0.12));
        }

        .card-section {
            margin-top: 44px;
        }

        .card-grid {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 20px;
        }

        .card-item {
            position: relative;
            border-radius: 28px;
            overflow: hidden;
            min-height: 320px;
            background: rgba(255, 255, 255, 0.92);
            box-shadow: 0 24px 70px rgba(15, 23, 42, 0.08);
            border: 1px solid rgba(37, 99, 235, 0.1);
        }

        .card-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        .card-label {
            position: absolute;
            bottom: 20px;
            left: 20px;
            right: 20px;
            padding: 16px 18px;
            border-radius: 20px;
            background: rgba(255, 255, 255, 0.92);
            color: #1e3a8a;
            font-size: 1rem;
            font-weight: 700;
            text-align: center;
            border: 1px solid rgba(37, 99, 235, 0.14);
        }

        .section-header {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            align-items: flex-end;
            gap: 14px;
            margin-bottom: 24px;
        }

        .section-header h2 {
            margin: 0;
            font-size: clamp(2rem, 2.5vw, 2.4rem);
            color: #0f172a;
        }

        .section-header p {
            margin: 0;
            max-width: 560px;
            color: #475569;
            line-height: 1.7;
            font-size: 0.98rem;
        }

        .about {
            margin-top: 48px;
            display: grid;
            gap: 24px;
            padding: 38px 0;
        }

        .about-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 24px;
        }

        .about-card {
            background: rgba(255, 255, 255, 0.82);
            padding: 28px;
            border-radius: 24px;
            border: 1px solid rgba(37, 99, 235, 0.12);
            box-shadow: 0 20px 46px rgba(15, 23, 42, 0.06);
            backdrop-filter: blur(12px);
        }

        .about-card h3 {
            margin: 0 0 12px;
            font-size: 1.2rem;
            color: #0f172a;
        }

        .about-card p {
            margin: 0;
            color: #475569;
            line-height: 1.75;
        }

        .features {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 20px;
            margin-top: 16px;
        }

        .feature-card {
            background: white;
            padding: 28px;
            border-radius: 24px;
            border: 1px solid rgba(37, 99, 235, 0.12);
            box-shadow: 0 20px 46px rgba(15, 23, 42, 0.06);
        }

        .feature-card h3 {
            margin: 0 0 14px;
            font-size: 1.2rem;
            color: #0f172a;
        }

        .feature-card p {
            margin: 0;
            color: #475569;
            line-height: 1.75;
        }

        .landing-footer {
            margin: 42px 0 0;
            width: 100%;
            max-width: none;
            padding: 24px 22px;
            background: rgba(255, 255, 255, 0.80);
            border: 1px solid rgba(37, 99, 235, 0.12);
            border-radius: 0;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 14px;
            color: #475569;
            box-shadow: 0 14px 32px rgba(15, 23, 42, 0.08);
            backdrop-filter: blur(12px);
        }

        .footer-links {
            display: flex;
            flex-wrap: wrap;
            gap: 18px;
        }

        .footer-links a {
            color: #2563eb;
            text-decoration: none;
            font-weight: 600;
        }

        .footer-note {
            font-size: 0.95rem;
        }

        @media (max-width: 1020px) {
            .hero,
            .features {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 720px) {
            .wrapper {
                padding: 18px 16px 36px;
            }

            .topbar,
            .landing-footer {
                padding: 14px 16px;
            }

            .hero-copy h1 {
                font-size: 2.8rem;
            }
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <header class="topbar">
            <div class="topbar-announce">
                <span>Fresh poultry farm management tools for your operations</span>
                <span>info@techfeathers.local • +63 912 345 6789</span>
            </div>

            <div class="topbar-main">
                <div class="brand">
                    <div class="brand-logo">TF</div>
                    <div class="brand-text">
                        <strong>Techfeathers</strong>
                        <span>Poultry Management</span>
                    </div>
                </div>

                <ul class="nav-links">
                    <li><a href="#home" class="active">Home</a></li>
                </ul>

                <div class="topbar-contact">
                    <span>1870 Poultry Lane, Laguna</span>
                    <a href="login.php" class="button-secondary">Login</a>
                    <a href="register.php" class="button-primary">Register</a>
                </div>
            </div>
        </header>

        <section class="hero" id="home">
            <div class="hero-copy">
                <span class="eyebrow">Poultry management made simple</span>
                <h1>Your poultry operations in one Techfeathers system.</h1>
                <p>Manage batches, feed inventory, egg production, orders, and reports with the same farm-based workflow used by your application.</p>

                <div class="hero-actions">
                    <a href="login.php" class="button-primary">Login</a>
                    <a href="register.php" class="button-secondary">Register</a>
                </div>

                <div class="hero-stats">
                    <div class="hero-stat"><strong>Batch</strong> tracking</div>
                    <div class="hero-stat"><strong>Feed</strong> inventory</div>
                    <div class="hero-stat"><strong>Order</strong> management</div>
                </div>
            </div>

            <div class="hero-image">
                <img src="assets/images/poultryngani.png" alt="Poultry farm image">
            </div>
        </section>

        <section class="card-section">
            <div class="card-grid">
                <article class="card-item">
                    <img src="assets/images/poultryngani.png" alt="Chicken Production">
                    <div class="card-label">Chicken Production</div>
                </article>
                <article class="card-item">
                    <img src="assets/images/manukan.png" alt="Egg Production">
                    <div class="card-label">Egg Production</div>
                </article>
                <article class="card-item">
                    <img src="assets/images/poultryngani.png" alt="Chick and Poultry">
                    <div class="card-label">Chick and Poultry</div>
                </article>
                <article class="card-item">
                    <img src="assets/images/manukan.png" alt="Feed and Nutrition">
                    <div class="card-label">Feed and Nutrition</div>
                </article>
            </div>
        </section>

        <footer class="landing-footer">
            <div class="footer-note">© 2026 Techfeathers. Powered by your poultry management system.</div>
        </footer>
    </div>
</body>
</html>
