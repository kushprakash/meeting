<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Best Recharge - Leading Utility Service Provider & B2B Solutions</title>
    <meta name="description" content="Best Recharge is India's premier utility service provider offering robust B2B recharge solutions, utility bill payment APIs, retailer franchise opportunities, and mobile app services.">
    <link rel="shortcut icon" href="/best_recharge.PNG" type="image/png">
    
    <!-- Google Fonts: Outfit & Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- FontAwesome 6 Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root {
            --bg-dark: #070D1E;
            --bg-card: #0F172A;
            --bg-card-hover: #1E293B;
            --accent-cyan: #00F2FE;
            --accent-cyan-glow: rgba(0, 242, 254, 0.35);
            --accent-blue: #4FACFE;
            --accent-purple: #7C3AED;
            --text-main: #F8FAFC;
            --text-muted: #94A3B8;
            --text-dim: #64748B;
            --border-glow: rgba(0, 242, 254, 0.2);
            --border-light: rgba(255, 255, 255, 0.08);
            --shadow-glass: 0 20px 50px rgba(0, 0, 0, 0.5);
            --success-green: #10B981;
            --warning-amber: #F59E0B;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Outfit', 'Inter', -apple-system, sans-serif;
            scroll-behavior: smooth;
        }

        body {
            background-color: var(--bg-dark);
            color: var(--text-main);
            min-height: 100vh;
            overflow-x: hidden;
            line-height: 1.6;
        }

        /* Ambient Glow Background Grid */
        .bg-cyber-grid {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            background-image: 
                radial-gradient(circle at 15% 15%, rgba(0, 242, 254, 0.08) 0%, transparent 40%),
                radial-gradient(circle at 85% 65%, rgba(124, 58, 237, 0.08) 0%, transparent 40%),
                linear-gradient(rgba(15, 23, 42, 0.5) 1px, transparent 1px),
                linear-gradient(90deg, rgba(15, 23, 42, 0.5) 1px, transparent 1px);
            background-size: 100% 100%, 100% 100%, 40px 40px, 40px 40px;
            z-index: -1;
            pointer-events: none;
        }

        /* Header Navigation */
        .header {
            background: rgba(15, 23, 42, 0.85);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border-bottom: 1px solid var(--border-light);
            position: sticky;
            top: 0;
            z-index: 1000;
            padding: 0.85rem 2.5rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .brand-logo-container {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            text-decoration: none;
            cursor: pointer;
        }

        .brand-logo-img {
            height: 46px;
            width: auto;
            object-fit: contain;
            filter: drop-shadow(0 0 10px rgba(0, 242, 254, 0.4));
            transition: transform 0.3s ease;
        }

        .brand-logo-container:hover .brand-logo-img {
            transform: scale(1.03);
        }

        .nav-links {
            display: flex;
            align-items: center;
            gap: 1.75rem;
            list-style: none;
        }

        .nav-link {
            color: var(--text-muted);
            text-decoration: none;
            font-size: 0.95rem;
            font-weight: 600;
            padding: 0.4rem 0.6rem;
            transition: all 0.2s;
        }

        .nav-link:hover, .nav-link.active {
            color: var(--accent-cyan);
        }

        .header-actions {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .btn-glow-primary {
            background: linear-gradient(135deg, var(--accent-cyan), var(--accent-blue));
            color: var(--bg-dark);
            font-weight: 800;
            font-size: 0.92rem;
            padding: 0.65rem 1.4rem;
            border-radius: 99px;
            border: none;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 4px 20px var(--accent-cyan-glow);
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-glow-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 30px rgba(0, 242, 254, 0.6);
            filter: brightness(1.1);
        }

        .btn-outline-glow {
            background: transparent;
            color: var(--text-main);
            border: 1px solid var(--border-glow);
            font-weight: 700;
            font-size: 0.92rem;
            padding: 0.6rem 1.3rem;
            border-radius: 99px;
            cursor: pointer;
            transition: all 0.2s;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-outline-glow:hover {
            background: rgba(0, 242, 254, 0.08);
            border-color: var(--accent-cyan);
            color: var(--accent-cyan);
        }

        /* Hero Section */
        .hero-section {
            padding: 5rem 2rem 4rem;
            max-width: 1280px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: 1.15fr 1fr;
            gap: 3.5rem;
            align-items: center;
        }

        .hero-badge-pill {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            background: rgba(0, 242, 254, 0.1);
            border: 1px solid var(--border-glow);
            color: var(--accent-cyan);
            padding: 0.45rem 1.2rem;
            border-radius: 99px;
            font-size: 0.85rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            margin-bottom: 1.5rem;
        }

        .hero-title {
            font-size: 3.5rem;
            font-weight: 900;
            line-height: 1.15;
            letter-spacing: -0.03em;
            margin-bottom: 1.25rem;
            background: linear-gradient(180deg, #FFFFFF 0%, #CBD5E1 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .hero-title span {
            background: linear-gradient(135deg, var(--accent-cyan) 0%, var(--accent-blue) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .hero-subtitle {
            font-size: 1.15rem;
            color: var(--text-muted);
            margin-bottom: 2.25rem;
            line-height: 1.6;
        }

        .hero-cta-group {
            display: flex;
            align-items: center;
            gap: 1.25rem;
            flex-wrap: wrap;
        }

        /* Hero Visual Showcase Frame */
        .hero-visual-card {
            background: linear-gradient(135deg, rgba(15, 23, 42, 0.9), rgba(7, 13, 30, 0.95));
            border: 1px solid var(--border-glow);
            border-radius: 24px;
            padding: 2.25rem;
            box-shadow: 0 25px 60px rgba(0, 0, 0, 0.6), 0 0 30px var(--accent-cyan-glow);
            position: relative;
        }

        .visual-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1.5rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid var(--border-light);
        }

        .visual-title {
            font-size: 1.1rem;
            font-weight: 800;
            color: var(--text-main);
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .visual-title i { color: var(--accent-cyan); }

        .service-list-mini {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .service-mini-item {
            background: rgba(255, 255, 255, 0.04);
            border: 1px solid var(--border-light);
            border-radius: 14px;
            padding: 1rem 1.25rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            transition: all 0.3s;
        }

        .service-mini-item:hover {
            border-color: var(--accent-cyan);
            transform: translateX(4px);
            background: rgba(0, 242, 254, 0.05);
        }

        .service-mini-left {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .service-mini-icon {
            width: 42px;
            height: 42px;
            border-radius: 10px;
            background: rgba(0, 242, 254, 0.1);
            color: var(--accent-cyan);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
        }

        .service-mini-name {
            font-weight: 700;
            font-size: 0.95rem;
            color: var(--text-main);
        }

        .service-mini-sub {
            font-size: 0.8rem;
            color: var(--text-muted);
        }

        .status-badge-active {
            font-size: 0.75rem;
            font-weight: 800;
            color: var(--success-green);
            background: rgba(16, 185, 129, 0.12);
            padding: 0.25rem 0.65rem;
            border-radius: 99px;
            display: flex;
            align-items: center;
            gap: 0.35rem;
        }

        /* Stats Bar */
        .stats-bar-section {
            background: rgba(15, 23, 42, 0.6);
            border-top: 1px solid var(--border-light);
            border-bottom: 1px solid var(--border-light);
            padding: 3rem 2rem;
        }

        .stats-container {
            max-width: 1280px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 2rem;
            text-align: center;
        }

        .stat-box-val {
            font-size: 2.75rem;
            font-weight: 900;
            color: var(--accent-cyan);
            margin-bottom: 0.25rem;
            letter-spacing: -0.02em;
        }

        .stat-box-lbl {
            font-size: 0.95rem;
            color: var(--text-muted);
            font-weight: 600;
        }

        /* Services Grid Section */
        .services-section {
            padding: 5rem 2rem;
            max-width: 1280px;
            margin: 0 auto;
        }

        .section-header {
            text-align: center;
            max-width: 700px;
            margin: 0 auto 3.5rem;
        }

        .section-tag {
            color: var(--accent-cyan);
            font-weight: 800;
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            margin-bottom: 0.75rem;
        }

        .section-title {
            font-size: 2.5rem;
            font-weight: 900;
            color: var(--text-main);
            margin-bottom: 1rem;
            letter-spacing: -0.02em;
        }

        .section-subtitle {
            font-size: 1.05rem;
            color: var(--text-muted);
        }

        .services-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 2rem;
        }

        .service-card {
            background: rgba(15, 23, 42, 0.6);
            border: 1px solid var(--border-light);
            border-radius: 20px;
            padding: 2.25rem;
            transition: all 0.3s;
            display: flex;
            flex-direction: column;
        }

        .service-card:hover {
            border-color: var(--accent-cyan);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.5), 0 0 25px var(--accent-cyan-glow);
            transform: translateY(-5px);
        }

        .service-icon-box {
            width: 60px;
            height: 60px;
            border-radius: 16px;
            background: linear-gradient(135deg, rgba(0, 242, 254, 0.15), rgba(79, 172, 254, 0.2));
            border: 1px solid var(--border-glow);
            color: var(--accent-cyan);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.6rem;
            margin-bottom: 1.5rem;
        }

        .service-card-title {
            font-size: 1.35rem;
            font-weight: 800;
            color: var(--text-main);
            margin-bottom: 0.75rem;
        }

        .service-card-desc {
            font-size: 0.95rem;
            color: var(--text-muted);
            line-height: 1.6;
            margin-bottom: 1.5rem;
            flex-grow: 1;
        }

        .service-bullets {
            list-style: none;
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        .service-bullet-item {
            font-size: 0.88rem;
            color: var(--text-main);
            display: flex;
            align-items: center;
            gap: 0.6rem;
            font-weight: 600;
        }

        .service-bullet-item i {
            color: var(--accent-cyan);
            font-size: 0.8rem;
        }

        /* App Showcase Section */
        .app-showcase-section {
            background: linear-gradient(135deg, #0F172A 0%, #1E1B4B 100%);
            border-top: 1px solid var(--border-light);
            border-bottom: 1px solid var(--border-light);
            padding: 5rem 2rem;
        }

        .app-showcase-container {
            max-width: 1280px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 4rem;
            align-items: center;
        }

        .app-badge-group {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-top: 2rem;
            flex-wrap: wrap;
        }

        .store-btn {
            background: rgba(7, 13, 30, 0.9);
            border: 1px solid var(--border-glow);
            color: var(--text-main);
            padding: 0.75rem 1.5rem;
            border-radius: 14px;
            display: flex;
            align-items: center;
            gap: 0.85rem;
            text-decoration: none;
            transition: all 0.25s;
        }

        .store-btn:hover {
            border-color: var(--accent-cyan);
            box-shadow: 0 0 20px var(--accent-cyan-glow);
            transform: translateY(-2px);
        }

        .store-btn i { font-size: 1.8rem; color: var(--accent-cyan); }
        .store-btn-text { display: flex; flex-direction: column; text-align: left; line-height: 1.2; }
        .store-sub { font-size: 0.72rem; color: var(--text-muted); text-transform: uppercase; }
        .store-main { font-size: 1.05rem; font-weight: 800; }

        /* B2B Franchise Retailer Section */
        .b2b-section {
            padding: 5rem 2rem;
            max-width: 1280px;
            margin: 0 auto;
        }

        .b2b-card-box {
            background: rgba(15, 23, 42, 0.8);
            border: 1px solid var(--border-glow);
            border-radius: 28px;
            padding: 3.5rem;
            display: grid;
            grid-template-columns: 1.2fr 1fr;
            gap: 3.5rem;
            align-items: center;
            box-shadow: 0 25px 60px rgba(0, 0, 0, 0.6);
        }

        .b2b-calc-widget {
            background: rgba(7, 13, 30, 0.9);
            border: 1px solid var(--border-glow);
            padding: 2.25rem;
            border-radius: 20px;
            text-align: left;
        }

        .slider-row {
            display: flex;
            justify-content: space-between;
            font-size: 0.9rem;
            font-weight: 700;
            color: var(--text-muted);
            margin-bottom: 0.6rem;
        }

        .custom-slider {
            width: 100%;
            height: 8px;
            border-radius: 4px;
            background: var(--bg-dark);
            outline: none;
            accent-color: var(--accent-cyan);
            cursor: pointer;
            margin-bottom: 1.5rem;
        }

        .profit-box {
            background: rgba(0, 242, 254, 0.1);
            border: 1px solid var(--border-glow);
            padding: 1.25rem;
            border-radius: 14px;
            text-align: center;
        }

        .profit-lbl { font-size: 0.8rem; color: var(--text-muted); text-transform: uppercase; font-weight: 700; }
        .profit-val { font-size: 2.25rem; font-weight: 900; color: var(--accent-cyan); }

        /* Contact & Business Inquiry Section */
        .contact-section {
            background: rgba(15, 23, 42, 0.4);
            border-top: 1px solid var(--border-light);
            padding: 5rem 2rem;
        }

        .contact-container {
            max-width: 1000px;
            margin: 0 auto;
            background: rgba(15, 23, 42, 0.85);
            border: 1px solid var(--border-glow);
            border-radius: 24px;
            padding: 3rem;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.6);
        }

        .form-grid-2 {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1.25rem;
            margin-bottom: 1.25rem;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
            text-align: left;
        }

        .form-label {
            font-size: 0.85rem;
            font-weight: 700;
            color: var(--text-muted);
        }

        .form-input, .form-select, .form-textarea {
            width: 100%;
            background: rgba(7, 13, 30, 0.8);
            border: 1px solid var(--border-light);
            color: var(--text-main);
            padding: 0.85rem 1.1rem;
            border-radius: 12px;
            font-size: 0.95rem;
            font-weight: 600;
            outline: none;
            transition: all 0.2s;
        }

        .form-input:focus, .form-select:focus, .form-textarea:focus {
            border-color: var(--accent-cyan);
            box-shadow: 0 0 15px var(--accent-cyan-glow);
        }

        .btn-submit-inquiry {
            width: 100%;
            background: linear-gradient(135deg, var(--accent-cyan), var(--accent-blue));
            color: var(--bg-dark);
            font-size: 1.1rem;
            font-weight: 900;
            padding: 1rem;
            border-radius: 14px;
            border: none;
            cursor: pointer;
            transition: all 0.3s;
            box-shadow: 0 8px 25px var(--accent-cyan-glow);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.6rem;
            margin-top: 1rem;
        }

        .btn-submit-inquiry:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 35px rgba(0, 242, 254, 0.5);
        }

        /* FAQ Section */
        .faq-section {
            max-width: 900px;
            margin: 5rem auto;
            padding: 0 2rem;
        }

        .faq-item {
            background: rgba(15, 23, 42, 0.6);
            border: 1px solid var(--border-light);
            border-radius: 16px;
            margin-bottom: 1rem;
            overflow: hidden;
        }

        .faq-question {
            padding: 1.25rem 1.5rem;
            font-size: 1.1rem;
            font-weight: 800;
            color: var(--text-main);
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: space-between;
            transition: color 0.2s;
        }

        .faq-question:hover { color: var(--accent-cyan); }

        .faq-answer {
            padding: 0 1.5rem 1.25rem;
            font-size: 0.95rem;
            color: var(--text-muted);
            line-height: 1.6;
            display: none;
        }

        .faq-item.active .faq-answer { display: block; }
        .faq-item.active .faq-question i { transform: rotate(180deg); color: var(--accent-cyan); }

        /* Footer */
        .footer {
            background: rgba(7, 13, 30, 0.95);
            border-top: 1px solid var(--border-light);
            padding: 4rem 2rem 2rem;
            color: var(--text-muted);
        }

        .footer-container {
            max-width: 1280px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: 2fr repeat(3, 1fr);
            gap: 3rem;
            text-align: left;
            margin-bottom: 3rem;
        }

        .footer-brand-logo {
            height: 44px;
            margin-bottom: 1rem;
        }

        .footer-desc {
            font-size: 0.9rem;
            line-height: 1.6;
            margin-bottom: 1.5rem;
            max-width: 360px;
        }

        .footer-col-title {
            color: var(--text-main);
            font-size: 1.05rem;
            font-weight: 800;
            margin-bottom: 1.25rem;
        }

        .footer-links {
            list-style: none;
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
        }

        .footer-links a {
            color: var(--text-muted);
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: 500;
            transition: color 0.2s;
        }

        .footer-links a:hover { color: var(--accent-cyan); }

        .footer-bottom {
            max-width: 1280px;
            margin: 0 auto;
            padding-top: 2rem;
            border-top: 1px solid var(--border-light);
            display: flex;
            align-items: center;
            justify-content: space-between;
            font-size: 0.85rem;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .security-badges {
            display: flex;
            align-items: center;
            gap: 1.25rem;
        }

        .security-item {
            display: flex;
            align-items: center;
            gap: 0.4rem;
            color: var(--text-main);
            font-size: 0.8rem;
            font-weight: 700;
        }

        .security-item i { color: var(--accent-cyan); }

        /* Toast Container */
        .toast-container {
            position: fixed;
            bottom: 2rem;
            right: 2rem;
            z-index: 3000;
        }

        .toast-msg {
            background: #0F172A;
            border: 1px solid var(--accent-cyan);
            color: var(--text-main);
            padding: 0.9rem 1.4rem;
            border-radius: 14px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.6);
            display: flex;
            align-items: center;
            gap: 0.75rem;
            font-weight: 700;
            font-size: 0.92rem;
        }

        @media (max-width: 1024px) {
            .hero-section { grid-template-columns: 1fr; }
            .stats-container { grid-template-columns: repeat(2, 1fr); }
            .app-showcase-container { grid-template-columns: 1fr; }
            .b2b-card-box { grid-template-columns: 1fr; }
            .footer-container { grid-template-columns: 1fr 1fr; }
        }

        @media (max-width: 768px) {
            .header { padding: 0.85rem 1rem; }
            .nav-links { display: none; }
            .hero-title { font-size: 2.5rem; }
            .form-grid-2 { grid-template-columns: 1fr; }
            .footer-container { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>

    <!-- Cyber Ambient Grid -->
    <div class="bg-cyber-grid"></div>

    <!-- Header Navigation -->
    <header class="header">
        <a href="/" class="brand-logo-container">
            <img src="/best_recharge.PNG" alt="Best Recharge Logo" class="brand-logo-img">
        </a>

        <ul class="nav-links">
            <li><a href="#about" class="nav-link active">About Us</a></li>
            <li><a href="#services" class="nav-link">Our Services</a></li>
            <li><a href="#app" class="nav-link">Mobile App</a></li>
            <li><a href="#retailer" class="nav-link">B2B Franchise</a></li>
            <li><a href="#faq" class="nav-link">FAQ</a></li>
        </ul>

        <div class="header-actions">
            <a href="#contact" class="btn-outline-glow"><i class="fa-solid fa-headset"></i> Support</a>
            <a href="#contact" class="btn-glow-primary"><i class="fa-solid fa-handshake"></i> Partner With Us</a>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="hero-section" id="about">
        <div>
            <div class="hero-badge-pill">
                <i class="fa-solid fa-bolt-lightning"></i> Premier Utility Service Provider
            </div>
            <h1 class="hero-title">
                Next-Gen Utility Payments & <span>Recharge Infrastructure</span>
            </h1>
            <p class="hero-subtitle">
                Best Recharge powers seamless digital utility payments, high-speed recharge APIs, and B2B retailer franchise solutions for millions of consumers and business partners across India.
            </p>

            <div class="hero-cta-group">
                <a href="#contact" class="btn-glow-primary">
                    <i class="fa-solid fa-store"></i> Become a Retailer / Agent
                </a>
                <a href="#services" class="btn-outline-glow">
                    <i class="fa-solid fa-layer-group"></i> Explore Solutions
                </a>
            </div>
        </div>

        <!-- Hero Graphic Card -->
        <div class="hero-visual-card">
            <div class="visual-header">
                <div class="visual-title">
                    <i class="fa-solid fa-shield-halved"></i> Live Service Ecosystem
                </div>
                <span class="status-badge-active"><i class="fa-solid fa-circle"></i> 99.99% Operational</span>
            </div>

            <div class="service-list-mini">
                <div class="service-mini-item">
                    <div class="service-mini-left">
                        <div class="service-mini-icon"><i class="fa-solid fa-mobile-screen-button"></i></div>
                        <div>
                            <div class="service-mini-name">Mobile & DTH Recharge APIs</div>
                            <div class="service-mini-sub">Sub-200ms processing SLA across all operators</div>
                        </div>
                    </div>
                    <i class="fa-solid fa-chevron-right" style="color: var(--text-dim);"></i>
                </div>

                <div class="service-mini-item">
                    <div class="service-mini-left">
                        <div class="service-mini-icon"><i class="fa-solid fa-bolt"></i></div>
                        <div>
                            <div class="service-mini-name">BBPS Utility Bill Payments</div>
                            <div class="service-mini-sub">100+ State Electricity, Water & Gas Boards</div>
                        </div>
                    </div>
                    <i class="fa-solid fa-chevron-right" style="color: var(--text-dim);"></i>
                </div>

                <div class="service-mini-item">
                    <div class="service-mini-left">
                        <div class="service-mini-icon"><i class="fa-solid fa-car-tunnel"></i></div>
                        <div>
                            <div class="service-mini-name">FASTag & Toll Mobility</div>
                            <div class="service-mini-sub">Direct banking integration with instant toll clearance</div>
                        </div>
                    </div>
                    <i class="fa-solid fa-chevron-right" style="color: var(--text-dim);"></i>
                </div>
            </div>
        </div>
    </section>

    <!-- Key Statistics Bar -->
    <section class="stats-bar-section">
        <div class="stats-container">
            <div>
                <div class="stat-box-val">99.99%</div>
                <div class="stat-box-lbl">API Uptime & Reliability</div>
            </div>
            <div>
                <div class="stat-box-val">100,000+</div>
                <div class="stat-box-lbl">Active Retail Partners</div>
            </div>
            <div>
                <div class="stat-box-val">25M+</div>
                <div class="stat-box-lbl">Monthly Transactions</div>
            </div>
            <div>
                <div class="stat-box-val">100+</div>
                <div class="stat-box-lbl">Utility Biller Integration</div>
            </div>
        </div>
    </section>

    <!-- Services Overview Section -->
    <section class="services-section" id="services">
        <div class="section-header">
            <div class="section-tag">Comprehensive Utility Portfolio</div>
            <h2 class="section-title">End-to-End Solutions For Individuals & Businesses</h2>
            <p class="section-subtitle">Delivering robust, secure, and instant utility services across multiple service verticals.</p>
        </div>

        <div class="services-grid">
            <!-- Service 1 -->
            <div class="service-card">
                <div class="service-icon-box"><i class="fa-solid fa-tower-cell"></i></div>
                <h3 class="service-card-title">Mobile & DTH Recharge</h3>
                <p class="service-card-desc">High-throughput processing for all major telecom and satellite providers including Airtel, Jio, Vi, BSNL, Tata Play, Dish TV, and Sun Direct.</p>
                <ul class="service-bullets">
                    <li class="service-bullet-item"><i class="fa-solid fa-check"></i> Instant Automated Operator Switch</li>
                    <li class="service-bullet-item"><i class="fa-solid fa-check"></i> 1% Guaranteed Cashback Earnings</li>
                    <li class="service-bullet-item"><i class="fa-solid fa-check"></i> Instant Refund on Failed Operator Queries</li>
                </ul>
            </div>

            <!-- Service 2 -->
            <div class="service-card">
                <div class="service-icon-box"><i class="fa-solid fa-plug-circle-bolt"></i></div>
                <h3 class="service-card-title">Electricity & Utility Bills</h3>
                <p class="service-card-desc">Direct BBPS bill fetching and payment infrastructure for state electricity boards, municipal water departments, and piped gas distributors.</p>
                <ul class="service-bullets">
                    <li class="service-bullet-item"><i class="fa-solid fa-check"></i> Live Bill Fetch by CA/Consumer ID</li>
                    <li class="service-bullet-item"><i class="fa-solid fa-check"></i> Real-time Settlement Acknowledgement</li>
                    <li class="service-bullet-item"><i class="fa-solid fa-check"></i> Zero Processing Charge for End Users</li>
                </ul>
            </div>

            <!-- Service 3 -->
            <div class="service-card">
                <div class="service-icon-box"><i class="fa-solid fa-shop"></i></div>
                <h3 class="service-card-title">B2B Retailer Franchise</h3>
                <p class="service-card-desc">Turn local retail stores, Kirana shops, or cyber cafes into high-revenue digital banking and utility kiosks with maximum commission margins.</p>
                <ul class="service-bullets">
                    <li class="service-bullet-item"><i class="fa-solid fa-check"></i> High Commission per Transaction</li>
                    <li class="service-bullet-item"><i class="fa-solid fa-check"></i> Single Wallet Balance for All Services</li>
                    <li class="service-bullet-item"><i class="fa-solid fa-check"></i> Dedicated Master Distributor Support</li>
                </ul>
            </div>

            <!-- Service 4 -->
            <div class="service-card">
                <div class="service-icon-box"><i class="fa-solid fa-car"></i></div>
                <h3 class="service-card-title">FASTag & Toll Clearance</h3>
                <p class="service-card-desc">Instant vehicle FASTag recharge services connected to NHAI, Paytm, ICICI Bank, SBI, and HDFC bank gateways.</p>
                <ul class="service-bullets">
                    <li class="service-bullet-item"><i class="fa-solid fa-check"></i> Vehicle Registration Number Verification</li>
                    <li class="service-bullet-item"><i class="fa-solid fa-check"></i> Immediate Balance Reflection at Toll Plaza</li>
                </ul>
            </div>

            <!-- Service 5 -->
            <div class="service-card">
                <div class="service-icon-box"><i class="fa-solid fa-code"></i></div>
                <h3 class="service-card-title">Developer Recharge APIs</h3>
                <p class="service-card-desc">RESTful JSON APIs built for fintech developers, websites, and mobile app publishers seeking 99.99% uptime multi-recharge backend routing.</p>
                <ul class="service-bullets">
                    <li class="service-bullet-item"><i class="fa-solid fa-check"></i> Comprehensive Documentation & Sandbox</li>
                    <li class="service-bullet-item"><i class="fa-solid fa-check"></i> Webhook Callback Notifications</li>
                </ul>
            </div>

            <!-- Service 6 -->
            <div class="service-card">
                <div class="service-icon-box"><i class="fa-solid fa-shield-virus"></i></div>
                <h3 class="service-card-title">Bank Grade Security</h3>
                <p class="service-card-desc">PCI-DSS compliance, 256-bit TLS encryption, and AI fraud prevention systems to ensure safe digital transactions.</p>
                <ul class="service-bullets">
                    <li class="service-bullet-item"><i class="fa-solid fa-check"></i> ISO 27001 Certified Infrastructure</li>
                    <li class="service-bullet-item"><i class="fa-solid fa-check"></i> NPCI & BBPS Compliant Gateways</li>
                </ul>
            </div>
        </div>
    </section>

    <!-- App Download Showcase -->
    <section class="app-showcase-section" id="app">
        <div class="app-showcase-container">
            <div>
                <div class="hero-badge-pill"><i class="fa-solid fa-mobile-retro"></i> Mobile App</div>
                <h2 class="hero-title" style="font-size: 2.75rem;">Manage All Utility Services On The Go</h2>
                <p class="hero-subtitle">
                    Download the official <strong>Best Recharge App</strong> on Android & iOS. Experience 1-tap recharges, auto bill reminders, instant refund tracking, and exclusive cashback rewards.
                </p>

                <div class="app-badge-group">
                    <a href="javascript:void(0)" class="store-btn" onclick="showToast('App Download Available on Play Store!')">
                        <i class="fa-brands fa-google-play"></i>
                        <div class="store-btn-text">
                            <span class="store-sub">GET IT ON</span>
                            <span class="store-main">Google Play</span>
                        </div>
                    </a>

                    <a href="javascript:void(0)" class="store-btn" onclick="showToast('App Download Available on App Store!')">
                        <i class="fa-brands fa-apple"></i>
                        <div class="store-btn-text">
                            <span class="store-sub">DOWNLOAD ON THE</span>
                            <span class="store-main">App Store</span>
                        </div>
                    </a>
                </div>
            </div>

            <div style="text-align: center;">
                <div style="background: rgba(0, 242, 254, 0.05); border: 1px solid var(--border-glow); padding: 2.5rem; border-radius: 30px; box-shadow: 0 20px 50px rgba(0,0,0,0.5);">
                    <i class="fa-solid fa-mobile-screen" style="font-size: 8rem; color: var(--accent-cyan); margin-bottom: 1rem;"></i>
                    <h4 style="font-size: 1.5rem; font-weight: 800; color: var(--text-main);">Best Recharge Mobile App</h4>
                    <p style="color: var(--text-muted); font-size: 0.95rem; margin-top: 0.5rem;">Fast. Secure. 100% Reliable.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- B2B Franchise Calculator Section -->
    <section class="b2b-section" id="retailer">
        <div class="b2b-card-box">
            <div>
                <div class="section-tag"><i class="fa-solid fa-shop"></i> B2B Retailer Opportunities</div>
                <h2 style="font-size: 2.25rem; font-weight: 900; color: var(--text-main); margin-bottom: 1rem;">
                    Start Your Utility Franchise & Earn Up to ₹45,000 / Month
                </h2>
                <p style="color: var(--text-muted); font-size: 1.05rem; margin-bottom: 1.5rem;">
                    Join over 100,000 retailers across India. Offer mobile recharges, DTH, electricity bill payments, and money transfers with instant wallet settlements.
                </p>
                <a href="#contact" class="btn-glow-primary"><i class="fa-solid fa-user-plus"></i> Apply For Retailer ID</a>
            </div>

            <!-- Earnings Estimator Widget -->
            <div class="b2b-calc-widget">
                <h3 style="font-size: 1.15rem; font-weight: 800; margin-bottom: 1.25rem; color: var(--text-main);">
                    <i class="fa-solid fa-calculator" style="color: var(--accent-cyan);"></i> Estimated Monthly Earnings
                </h3>

                <div class="slider-row">
                    <span>Daily Transaction Volume</span>
                    <span id="sliderVal" style="color: var(--accent-cyan);">₹50,000 / day</span>
                </div>
                <input type="range" class="custom-slider" min="5000" max="200000" step="5000" value="50000" oninput="updateEarnings(this.value)">

                <div class="profit-box">
                    <div class="profit-lbl">Estimated Monthly Profit</div>
                    <div class="profit-val" id="estProfit">₹22,500.00</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact & Inquiry Form -->
    <section class="contact-section" id="contact">
        <div class="contact-container">
            <div style="text-align: center; margin-bottom: 2rem;">
                <div class="section-tag">Business Contact & Partner Inquiries</div>
                <h2 style="font-size: 2rem; font-weight: 900; color: var(--text-main);">Get In Touch With Our Team</h2>
                <p style="color: var(--text-muted); font-size: 0.95rem;">Have questions about Retailer ID, API Integration, or Corporate Partnerships?</p>
            </div>

            <form onsubmit="handleInquirySubmit(event)">
                <div class="form-grid-2">
                    <div class="form-group">
                        <label class="form-label">Full Name</label>
                        <input type="text" class="form-input" placeholder="Your Full Name" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Mobile Number</label>
                        <input type="text" class="form-input" placeholder="10 Digit Mobile No" required>
                    </div>
                </div>

                <div class="form-grid-2">
                    <div class="form-group">
                        <label class="form-label">Email Address</label>
                        <input type="email" class="form-input" placeholder="name@company.com" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Inquiry Type</label>
                        <select class="form-select" required>
                            <option value="">Select Category</option>
                            <option value="retailer">New Retailer Franchise</option>
                            <option value="distributor">Distributor Partnership</option>
                            <option value="api">Recharge API Integration</option>
                            <option value="support">Customer Support Query</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Message</label>
                    <textarea class="form-textarea" rows="4" placeholder="Tell us how we can help your business..." required></textarea>
                </div>

                <button type="submit" class="btn-submit-inquiry">
                    <i class="fa-solid fa-paper-plane"></i> Submit Inquiry
                </button>
            </form>
        </div>
    </section>

    <!-- FAQ Section -->
    <section class="faq-section" id="faq">
        <div style="text-align: center; margin-bottom: 2.5rem;">
            <div class="section-tag">Help & Clarity</div>
            <h2 class="section-title">Frequently Asked Questions</h2>
        </div>

        <div class="faq-item active" onclick="toggleFaq(this)">
            <div class="faq-question">
                <span>What is Best Recharge?</span>
                <i class="fa-solid fa-chevron-down"></i>
            </div>
            <div class="faq-answer">
                Best Recharge is a leading utility service platform providing instant mobile recharges, DTH payments, electricity & gas bill payment infrastructure, B2B agent franchise setups, and developer APIs.
            </div>
        </div>

        <div class="faq-item" onclick="toggleFaq(this)">
            <div class="faq-question">
                <span>How can I become an authorized Retailer or Agent?</span>
                <i class="fa-solid fa-chevron-down"></i>
            </div>
            <div class="faq-answer">
                You can fill out the contact form above under "Retailer Franchise". Our distributor team will guide you through instant KYC onboarding and activate your agent account within 30 minutes.
            </div>
        </div>

        <div class="faq-item" onclick="toggleFaq(this)">
            <div class="faq-question">
                <span>What happens if a recharge query fails?</span>
                <i class="fa-solid fa-chevron-down"></i>
            </div>
            <div class="faq-answer">
                Our system features an automated 5-second refund mechanism. If an operator server experiences downtime, the debited amount is instantly refunded back to the wallet balance.
            </div>
        </div>

        <div class="faq-item" onclick="toggleFaq(this)">
            <div class="faq-question">
                <span>Are recharge APIs available for developers?</span>
                <i class="fa-solid fa-chevron-down"></i>
            </div>
            <div class="faq-answer">
                Yes! We offer RESTful APIs with webhook integration for fintech apps, websites, and portal owners. Contact our API team for sandbox API keys.
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="footer-container">
            <div>
                <img src="/best_recharge.PNG" alt="Best Recharge" class="footer-brand-logo">
                <p class="footer-desc">
                    Best Recharge is a premier utility service provider powering digital recharges, bill payments, and B2B distributor networks across India.
                </p>
                <div class="security-badges">
                    <span class="security-item"><i class="fa-solid fa-lock"></i> PCI-DSS v4.0</span>
                    <span class="security-item"><i class="fa-solid fa-shield-check"></i> ISO 27001</span>
                    <span class="security-item"><i class="fa-solid fa-building-columns"></i> NPCI Compliant</span>
                </div>
            </div>

            <div>
                <h4 class="footer-col-title">Services</h4>
                <ul class="footer-links">
                    <li><a href="#services">Mobile & DTH Recharge</a></li>
                    <li><a href="#services">Electricity Bill Payments</a></li>
                    <li><a href="#services">Piped Gas & Cylinder</a></li>
                    <li><a href="#services">Water Bill Payments</a></li>
                    <li><a href="#services">FASTag Solutions</a></li>
                </ul>
            </div>

            <div>
                <h4 class="footer-col-title">B2B Franchise</h4>
                <ul class="footer-links">
                    <li><a href="#retailer">Become a Retailer</a></li>
                    <li><a href="#retailer">Distributor Network</a></li>
                    <li><a href="#services">Recharge APIs</a></li>
                    <li><a href="#retailer">Commission Structure</a></li>
                </ul>
            </div>

            <div>
                <h4 class="footer-col-title">Company</h4>
                <ul class="footer-links">
                    <li><a href="#about">About Best Recharge</a></li>
                    <li><a href="#app">Mobile App</a></li>
                    <li><a href="#contact">Contact Support</a></li>
                    <li><a href="#faq">FAQ & Help</a></li>
                </ul>
            </div>
        </div>

        <div class="footer-bottom">
            <div>&copy; 2026 Best Recharge Utility Services Ltd. All Rights Reserved.</div>
            <div style="display: flex; gap: 1.5rem;">
                <a href="javascript:void(0)" style="color: var(--text-muted);"><i class="fa-brands fa-facebook"></i></a>
                <a href="javascript:void(0)" style="color: var(--text-muted);"><i class="fa-brands fa-twitter"></i></a>
                <a href="javascript:void(0)" style="color: var(--text-muted);"><i class="fa-brands fa-instagram"></i></a>
                <a href="javascript:void(0)" style="color: var(--text-muted);"><i class="fa-brands fa-linkedin"></i></a>
            </div>
        </div>
    </footer>

    <!-- Toast Notifications Container -->
    <div class="toast-container" id="toastContainer"></div>

    <!-- JavaScript Logic -->
    <script>
        function updateEarnings(val) {
            const daily = parseFloat(val);
            document.getElementById('sliderVal').innerText = `₹${daily.toLocaleString('en-IN')} / day`;
            const profit = (daily * 30 * 0.015).toFixed(0);
            document.getElementById('estProfit').innerText = `₹${parseInt(profit).toLocaleString('en-IN')}.00`;
        }

        function handleInquirySubmit(e) {
            e.preventDefault();
            showToast('Thank you! Your inquiry has been submitted. Our business team will contact you shortly.', 'success');
            e.target.reset();
        }

        function toggleFaq(el) {
            el.classList.toggle('active');
        }

        function showToast(msg, type = 'info') {
            const container = document.getElementById('toastContainer');
            const toast = document.createElement('div');
            toast.className = 'toast-msg';
            
            let icon = '<i class="fa-solid fa-circle-info" style="color: var(--accent-cyan);"></i>';
            if (type === 'success') icon = '<i class="fa-solid fa-circle-check" style="color: var(--success-green);"></i>';

            toast.innerHTML = `${icon} <span>${msg}</span>`;
            container.appendChild(toast);

            setTimeout(() => {
                toast.style.opacity = '0';
                toast.style.transition = 'all 0.3s';
                setTimeout(() => toast.remove(), 300);
            }, 3500);
        }
    </script>
</body>
</html>
