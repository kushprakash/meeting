<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Best Recharge - Instant Mobile Recharge, DTH & Utility Bill Payment</title>
    <meta name="description" content="Best Recharge is India's leading utility service provider for instant mobile recharge, DTH payments, electricity bill payments, water bills, gas booking, and FASTag recharges with guaranteed 1% cashback.">
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
            --danger-red: #EF4444;
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

        /* Top Header Navigation */
        .header {
            background: rgba(15, 23, 42, 0.85);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border-bottom: 1px solid var(--border-light);
            position: sticky;
            top: 0;
            z-index: 1000;
            padding: 0.75rem 2rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            transition: all 0.3s;
        }

        .brand-logo-container {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            text-decoration: none;
            cursor: pointer;
        }

        .brand-logo-img {
            height: 48px;
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
            gap: 1.5rem;
            list-style: none;
        }

        .nav-link {
            color: var(--text-muted);
            text-decoration: none;
            font-size: 0.95rem;
            font-weight: 600;
            padding: 0.5rem 0.85rem;
            border-radius: 8px;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            gap: 0.4rem;
        }

        .nav-link:hover, .nav-link.active {
            color: var(--text-main);
            background: rgba(255, 255, 255, 0.06);
        }

        .header-actions {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        /* Wallet Badge Header */
        .wallet-pill {
            background: linear-gradient(135deg, rgba(0, 242, 254, 0.1), rgba(79, 172, 254, 0.15));
            border: 1px solid var(--border-glow);
            padding: 0.4rem 0.9rem;
            border-radius: 99px;
            display: flex;
            align-items: center;
            gap: 0.6rem;
            cursor: pointer;
            transition: all 0.2s;
        }

        .wallet-pill:hover {
            background: linear-gradient(135deg, rgba(0, 242, 254, 0.2), rgba(79, 172, 254, 0.25));
            box-shadow: 0 0 15px var(--accent-cyan-glow);
            transform: translateY(-1px);
        }

        .wallet-icon {
            color: var(--accent-cyan);
            font-size: 1.1rem;
        }

        .wallet-info {
            display: flex;
            flex-direction: column;
            line-height: 1.1;
        }

        .wallet-label {
            font-size: 0.7rem;
            color: var(--text-muted);
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .wallet-amount {
            font-size: 0.95rem;
            font-weight: 800;
            color: var(--accent-cyan);
        }

        .btn-add-funds {
            background: var(--accent-cyan);
            color: var(--bg-dark);
            border: none;
            border-radius: 50%;
            width: 22px;
            height: 22px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.75rem;
            font-weight: 900;
            margin-left: 0.25rem;
        }

        .btn-glow-primary {
            background: linear-gradient(135deg, var(--accent-cyan), var(--accent-blue));
            color: var(--bg-dark);
            font-weight: 800;
            font-size: 0.92rem;
            padding: 0.6rem 1.3rem;
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
            padding: 0.55rem 1.2rem;
            border-radius: 99px;
            cursor: pointer;
            transition: all 0.2s;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-outline-glow:hover {
            background: rgba(0, 242, 254, 0.08);
            border-color: var(--accent-cyan);
            color: var(--accent-cyan);
        }

        /* Hero Banner Section */
        .hero-section {
            padding: 3.5rem 2rem 2.5rem;
            max-width: 1280px;
            margin: 0 auto;
            text-align: center;
            position: relative;
        }

        .hero-badge-pill {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            background: rgba(0, 242, 254, 0.1);
            border: 1px solid var(--border-glow);
            color: var(--accent-cyan);
            padding: 0.4rem 1.1rem;
            border-radius: 99px;
            font-size: 0.85rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            margin-bottom: 1.25rem;
            animation: pulseGlow 3s infinite alternate;
        }

        @keyframes pulseGlow {
            0% { box-shadow: 0 0 10px rgba(0, 242, 254, 0.2); }
            100% { box-shadow: 0 0 25px rgba(0, 242, 254, 0.5); }
        }

        .hero-title {
            font-size: 3.25rem;
            font-weight: 900;
            line-height: 1.15;
            letter-spacing: -0.03em;
            margin-bottom: 1rem;
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
            max-width: 760px;
            margin: 0 auto 2.5rem;
            font-weight: 400;
        }

        /* Trust Stats Bar */
        .trust-stats-row {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 2.5rem;
            flex-wrap: wrap;
            margin-bottom: 3rem;
        }

        .trust-stat-item {
            display: flex;
            align-items: center;
            gap: 0.6rem;
            color: var(--text-muted);
            font-size: 0.9rem;
            font-weight: 600;
        }

        .trust-stat-item i {
            color: var(--accent-cyan);
            font-size: 1.1rem;
        }

        /* Main Utility Portal Card Box */
        .utility-portal-card {
            background: rgba(15, 23, 42, 0.75);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(0, 242, 254, 0.25);
            border-radius: 24px;
            box-shadow: 0 25px 60px rgba(0, 0, 0, 0.6), 0 0 40px rgba(0, 242, 254, 0.08);
            max-width: 1100px;
            margin: 0 auto 4rem;
            overflow: hidden;
            position: relative;
        }

        /* Service Selector Tabs Header */
        .service-tabs-header {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(110px, 1fr));
            background: rgba(7, 13, 30, 0.8);
            border-bottom: 1px solid var(--border-light);
            padding: 0.5rem;
            gap: 0.4rem;
        }

        .service-tab-btn {
            background: transparent;
            border: none;
            color: var(--text-muted);
            padding: 0.85rem 0.5rem;
            border-radius: 12px;
            cursor: pointer;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 0.45rem;
            font-size: 0.82rem;
            font-weight: 700;
            transition: all 0.25s;
        }

        .service-tab-btn i {
            font-size: 1.35rem;
            transition: transform 0.2s;
        }

        .service-tab-btn:hover {
            color: var(--text-main);
            background: rgba(255, 255, 255, 0.05);
        }

        .service-tab-btn.active {
            background: linear-gradient(135deg, rgba(0, 242, 254, 0.15), rgba(79, 172, 254, 0.2));
            color: var(--accent-cyan);
            border: 1px solid var(--border-glow);
            box-shadow: 0 4px 15px rgba(0, 242, 254, 0.15);
        }

        .service-tab-btn.active i {
            transform: scale(1.15);
            color: var(--accent-cyan);
        }

        /* Service Form Body */
        .service-form-body {
            padding: 2.25rem;
        }

        .form-view-panel {
            display: none;
            animation: fadeIn 0.3s ease-in-out;
        }

        .form-view-panel.active {
            display: block;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(6px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .panel-heading-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1.5rem;
        }

        .panel-title {
            font-size: 1.35rem;
            font-weight: 800;
            color: var(--text-main);
            display: flex;
            align-items: center;
            gap: 0.6rem;
        }

        .panel-title i {
            color: var(--accent-cyan);
        }

        .radio-switch-group {
            display: flex;
            background: rgba(7, 13, 30, 0.6);
            padding: 3px;
            border-radius: 99px;
            border: 1px solid var(--border-light);
        }

        .radio-switch-btn {
            background: transparent;
            border: none;
            color: var(--text-muted);
            font-size: 0.82rem;
            font-weight: 700;
            padding: 0.35rem 1rem;
            border-radius: 99px;
            cursor: pointer;
            transition: all 0.2s;
        }

        .radio-switch-btn.active {
            background: var(--accent-cyan);
            color: var(--bg-dark);
        }

        /* Inputs Grid */
        .form-grid-3 {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1.25rem;
            margin-bottom: 1.5rem;
        }

        .form-grid-2 {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1.25rem;
            margin-bottom: 1.5rem;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 0.45rem;
            text-align: left;
        }

        .form-label {
            font-size: 0.85rem;
            font-weight: 700;
            color: var(--text-muted);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .input-wrapper {
            position: relative;
            display: flex;
            align-items: center;
        }

        .input-icon {
            position: absolute;
            left: 1rem;
            color: var(--text-dim);
            font-size: 1rem;
            pointer-events: none;
            transition: color 0.2s;
        }

        .form-input, .form-select {
            width: 100%;
            background: rgba(7, 13, 30, 0.7);
            border: 1px solid var(--border-light);
            color: var(--text-main);
            padding: 0.85rem 1rem 0.85rem 2.75rem;
            border-radius: 12px;
            font-size: 0.95rem;
            font-weight: 600;
            outline: none;
            transition: all 0.2s;
        }

        .form-select {
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%20%2394A3B8'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M19 9l-7 7-7-7'%3E%3C/path%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 1rem center;
            background-size: 1.2rem;
            cursor: pointer;
        }

        .form-input:focus, .form-select:focus {
            border-color: var(--accent-cyan);
            box-shadow: 0 0 15px var(--accent-cyan-glow);
            background: rgba(7, 13, 30, 0.95);
        }

        .form-input:focus + .input-icon, .form-select:focus + .input-icon {
            color: var(--accent-cyan);
        }

        .input-action-link {
            color: var(--accent-cyan);
            font-size: 0.8rem;
            font-weight: 700;
            text-decoration: none;
            cursor: pointer;
        }

        .input-action-link:hover {
            text-decoration: underline;
        }

        .btn-submit-action {
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
        }

        .btn-submit-action:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 35px rgba(0, 242, 254, 0.5);
            filter: brightness(1.05);
        }

        /* Fetched Bill Info Box */
        .bill-fetched-result {
            background: linear-gradient(135deg, rgba(0, 242, 254, 0.08), rgba(15, 23, 42, 0.9));
            border: 1px dashed var(--accent-cyan);
            border-radius: 14px;
            padding: 1.25rem;
            margin-bottom: 1.5rem;
            display: none;
        }

        .bill-fetched-result.active {
            display: block;
            animation: fadeIn 0.3s;
        }

        .bill-details-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 1rem;
        }

        .bill-detail-item {
            display: flex;
            flex-direction: column;
        }

        .bill-detail-label {
            font-size: 0.75rem;
            color: var(--text-muted);
            font-weight: 600;
            text-transform: uppercase;
        }

        .bill-detail-val {
            font-size: 1.05rem;
            font-weight: 800;
            color: var(--text-main);
        }

        .bill-detail-val.highlight {
            color: var(--accent-cyan);
            font-size: 1.25rem;
        }

        /* Offer Codes Carousel / Grid */
        .offers-section {
            max-width: 1280px;
            margin: 0 auto 5rem;
            padding: 0 2rem;
        }

        .section-header-flex {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1.75rem;
        }

        .section-title {
            font-size: 1.75rem;
            font-weight: 800;
            color: var(--text-main);
            display: flex;
            align-items: center;
            gap: 0.6rem;
        }

        .section-title i {
            color: var(--accent-cyan);
        }

        .offers-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
            gap: 1.5rem;
        }

        .offer-card {
            background: rgba(15, 23, 42, 0.6);
            border: 1px solid var(--border-light);
            border-radius: 18px;
            padding: 1.5rem;
            display: flex;
            align-items: center;
            gap: 1.25rem;
            position: relative;
            overflow: hidden;
            transition: all 0.3s;
        }

        .offer-card:hover {
            border-color: var(--border-glow);
            transform: translateY(-3px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.4);
        }

        .offer-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 4px;
            height: 100%;
            background: linear-gradient(180deg, var(--accent-cyan), var(--accent-blue));
        }

        .offer-icon-box {
            width: 56px;
            height: 56px;
            border-radius: 14px;
            background: rgba(0, 242, 254, 0.1);
            color: var(--accent-cyan);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            flex-shrink: 0;
        }

        .offer-details {
            flex-grow: 1;
            text-align: left;
        }

        .offer-badge {
            font-size: 0.72rem;
            font-weight: 800;
            color: var(--accent-cyan);
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .offer-title {
            font-size: 1.1rem;
            font-weight: 800;
            color: var(--text-main);
            margin: 0.15rem 0 0.25rem;
        }

        .offer-desc {
            font-size: 0.85rem;
            color: var(--text-muted);
        }

        .btn-copy-code {
            background: rgba(255, 255, 255, 0.08);
            border: 1px stroke var(--border-glow);
            color: var(--accent-cyan);
            font-size: 0.8rem;
            font-weight: 800;
            padding: 0.4rem 0.85rem;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.2s;
            margin-top: 0.5rem;
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
        }

        .btn-copy-code:hover {
            background: var(--accent-cyan);
            color: var(--bg-dark);
        }

        /* Features Section Grid */
        .features-section {
            background: rgba(15, 23, 42, 0.4);
            border-top: 1px solid var(--border-light);
            border-bottom: 1px solid var(--border-light);
            padding: 5rem 2rem;
            margin-bottom: 5rem;
        }

        .features-container {
            max-width: 1280px;
            margin: 0 auto;
            text-align: center;
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 2rem;
            margin-top: 3rem;
        }

        .feature-card {
            background: rgba(15, 23, 42, 0.7);
            border: 1px solid var(--border-light);
            padding: 2rem;
            border-radius: 20px;
            text-align: left;
            transition: all 0.3s;
        }

        .feature-card:hover {
            border-color: var(--accent-cyan);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.5), 0 0 20px var(--accent-cyan-glow);
            transform: translateY(-5px);
        }

        .feature-icon-wrapper {
            width: 54px;
            height: 54px;
            border-radius: 14px;
            background: linear-gradient(135deg, rgba(0, 242, 254, 0.15), rgba(124, 58, 237, 0.15));
            border: 1px solid var(--border-glow);
            color: var(--accent-cyan);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.4rem;
            margin-bottom: 1.25rem;
        }

        .feature-card-title {
            font-size: 1.2rem;
            font-weight: 800;
            color: var(--text-main);
            margin-bottom: 0.5rem;
        }

        .feature-card-desc {
            font-size: 0.9rem;
            color: var(--text-muted);
            line-height: 1.55;
        }

        /* Retailer B2B Franchise Banner */
        .b2b-banner {
            max-width: 1280px;
            margin: 0 auto 5rem;
            padding: 0 2rem;
        }

        .b2b-box {
            background: linear-gradient(135deg, #0F172A 0%, #1E1B4B 100%);
            border: 1px solid var(--border-glow);
            border-radius: 28px;
            padding: 3.5rem 3rem;
            display: grid;
            grid-template-columns: 1.2fr 1fr;
            gap: 3rem;
            align-items: center;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.6);
            position: relative;
            overflow: hidden;
        }

        .b2b-box::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -20%;
            width: 500px;
            height: 500px;
            background: radial-gradient(circle, rgba(0, 242, 254, 0.15) 0%, transparent 70%);
            pointer-events: none;
        }

        .b2b-content {
            text-align: left;
        }

        .b2b-tag {
            color: var(--accent-cyan);
            font-weight: 800;
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            margin-bottom: 0.75rem;
        }

        .b2b-title {
            font-size: 2.25rem;
            font-weight: 900;
            color: var(--text-main);
            margin-bottom: 1rem;
            line-height: 1.2;
        }

        .b2b-desc {
            color: var(--text-muted);
            font-size: 1.05rem;
            margin-bottom: 1.75rem;
        }

        .b2b-calc-card {
            background: rgba(7, 13, 30, 0.85);
            border: 1px solid var(--border-glow);
            padding: 2rem;
            border-radius: 20px;
            text-align: left;
        }

        .calc-title {
            font-size: 1.1rem;
            font-weight: 800;
            color: var(--text-main);
            margin-bottom: 1.25rem;
        }

        .range-slider-group {
            margin-bottom: 1.5rem;
        }

        .slider-label-row {
            display: flex;
            justify-content: space-between;
            font-size: 0.85rem;
            font-weight: 700;
            color: var(--text-muted);
            margin-bottom: 0.5rem;
        }

        .custom-range-input {
            width: 100%;
            height: 6px;
            border-radius: 3px;
            background: var(--bg-dark);
            outline: none;
            accent-color: var(--accent-cyan);
            cursor: pointer;
        }

        .earning-box {
            background: rgba(0, 242, 254, 0.1);
            border: 1px solid var(--border-glow);
            padding: 1rem;
            border-radius: 12px;
            text-align: center;
        }

        .earning-lbl {
            font-size: 0.78rem;
            color: var(--text-muted);
            font-weight: 700;
            text-transform: uppercase;
        }

        .earning-amt {
            font-size: 1.85rem;
            font-weight: 900;
            color: var(--accent-cyan);
        }

        /* Operators Badges Grid */
        .partners-section {
            max-width: 1280px;
            margin: 0 auto 5rem;
            padding: 0 2rem;
            text-align: center;
        }

        .partners-title {
            font-size: 1rem;
            font-weight: 700;
            color: var(--text-dim);
            text-transform: uppercase;
            letter-spacing: 0.1em;
            margin-bottom: 2rem;
        }

        .partners-flex {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 2.5rem;
            flex-wrap: wrap;
            opacity: 0.8;
        }

        .partner-badge {
            background: rgba(15, 23, 42, 0.6);
            border: 1px solid var(--border-light);
            padding: 0.75rem 1.5rem;
            border-radius: 12px;
            font-weight: 800;
            font-size: 1rem;
            color: var(--text-main);
            display: flex;
            align-items: center;
            gap: 0.6rem;
            transition: all 0.2s;
        }

        .partner-badge:hover {
            border-color: var(--accent-cyan);
            color: var(--accent-cyan);
            transform: scale(1.05);
        }

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
            height: 42px;
            margin-bottom: 1rem;
        }

        .footer-desc {
            font-size: 0.9rem;
            line-height: 1.6;
            margin-bottom: 1.5rem;
            max-width: 340px;
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

        .footer-links a:hover {
            color: var(--accent-cyan);
        }

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

        .security-item i {
            color: var(--accent-cyan);
        }

        /* MODALS (Login, Plans, Wallet) */
        .modal-backdrop {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            background: rgba(0, 0, 0, 0.75);
            backdrop-filter: blur(8px);
            z-index: 2000;
            display: none;
            align-items: center;
            justify-content: center;
            padding: 1.5rem;
        }

        .modal-backdrop.active {
            display: flex;
            animation: fadeIn 0.25s;
        }

        .modal-box {
            background: #0F172A;
            border: 1px solid var(--border-glow);
            border-radius: 24px;
            width: 100%;
            max-width: 520px;
            padding: 2.25rem;
            box-shadow: 0 25px 60px rgba(0, 0, 0, 0.8), 0 0 30px var(--accent-cyan-glow);
            position: relative;
            max-height: 90vh;
            overflow-y: auto;
        }

        .modal-close-btn {
            position: absolute;
            top: 1.25rem;
            right: 1.25rem;
            background: rgba(255, 255, 255, 0.08);
            border: none;
            color: var(--text-muted);
            width: 34px;
            height: 34px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            font-size: 1.1rem;
            transition: all 0.2s;
        }

        .modal-close-btn:hover {
            background: rgba(255, 255, 255, 0.2);
            color: var(--text-main);
        }

        .plans-modal-box {
            max-width: 850px;
        }

        .plan-item-card {
            background: rgba(7, 13, 30, 0.8);
            border: 1px solid var(--border-light);
            border-radius: 14px;
            padding: 1.25rem;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            transition: all 0.2s;
        }

        .plan-item-card:hover {
            border-color: var(--accent-cyan);
            background: rgba(7, 13, 30, 0.95);
        }

        .plan-price-tag {
            font-size: 1.6rem;
            font-weight: 900;
            color: var(--accent-cyan);
        }

        .plan-meta-pills {
            display: flex;
            gap: 0.5rem;
            margin: 0.4rem 0;
        }

        .plan-pill {
            font-size: 0.75rem;
            font-weight: 700;
            background: rgba(255, 255, 255, 0.08);
            padding: 0.2rem 0.6rem;
            border-radius: 6px;
            color: var(--text-main);
        }

        /* Toast Notifications */
        .toast-container {
            position: fixed;
            bottom: 2rem;
            right: 2rem;
            z-index: 3000;
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
        }

        .toast-msg {
            background: #0F172A;
            border: 1px solid var(--accent-cyan);
            color: var(--text-main);
            padding: 0.9rem 1.4rem;
            border-radius: 14px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.6), 0 0 15px var(--accent-cyan-glow);
            display: flex;
            align-items: center;
            gap: 0.75rem;
            font-weight: 700;
            font-size: 0.92rem;
            animation: slideInRight 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        @keyframes slideInRight {
            from { transform: translateX(100%); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }

        /* Responsive Media Queries */
        @media (max-width: 1024px) {
            .footer-container { grid-template-columns: 1fr 1fr; }
            .b2b-box { grid-template-columns: 1fr; gap: 2rem; }
            .form-grid-3 { grid-template-columns: 1fr; }
            .bill-details-grid { grid-template-columns: repeat(2, 1fr); }
        }

        @media (max-width: 768px) {
            .header { padding: 0.75rem 1rem; }
            .nav-links { display: none; }
            .hero-title { font-size: 2.25rem; }
            .service-tabs-header { grid-template-columns: repeat(3, 1fr); }
            .form-grid-2 { grid-template-columns: 1fr; }
            .footer-container { grid-template-columns: 1fr; }
            .trust-stats-row { gap: 1.25rem; }
        }
    </style>
</head>
<body>

    <!-- Cybernetic Ambient Background -->
    <div class="bg-cyber-grid"></div>

    <!-- Header Navigation -->
    <header class="header">
        <a href="/" class="brand-logo-container">
            <img src="/best_recharge.PNG" alt="Best Recharge Logo" class="brand-logo-img">
        </a>

        <ul class="nav-links">
            <li><a href="#utility-portal" class="nav-link active"><i class="fa-solid fa-bolt"></i> Recharges & Bills</a></li>
            <li><a href="#offers-section" class="nav-link"><i class="fa-solid fa-tags"></i> Promo Cashback</a></li>
            <li><a href="#b2b-banner" class="nav-link"><i class="fa-solid fa-store"></i> Retailer Franchise</a></li>
            <li><a href="#features-section" class="nav-link"><i class="fa-solid fa-shield-halved"></i> Why Us</a></li>
            <li><a href="javascript:void(0)" onclick="openStatusModal()" class="nav-link"><i class="fa-solid fa-receipt"></i> Track Txn</a></li>
        </ul>

        <div class="header-actions">
            <!-- Wallet Indicator Pill -->
            <div class="wallet-pill" onclick="openWalletModal()">
                <i class="fa-solid fa-wallet wallet-icon"></i>
                <div class="wallet-info">
                    <span class="wallet-label">Balance</span>
                    <span class="wallet-amount" id="headerWalletBalance">₹1,250.00</span>
                </div>
                <div class="btn-add-funds" title="Add Money"><i class="fa-solid fa-plus"></i></div>
            </div>

            <!-- Auth Buttons -->
            <button class="btn-outline-glow" id="btnHeaderLogin" onclick="openAuthModal('login')">
                <i class="fa-solid fa-user-lock"></i> Login
            </button>
            <button class="btn-glow-primary" id="btnHeaderRegister" onclick="openAuthModal('register')">
                <i class="fa-solid fa-user-plus"></i> Register
            </button>
        </div>
    </header>

    <!-- Hero Banner -->
    <section class="hero-section">
        <div class="hero-badge-pill">
            <i class="fa-solid fa-bolt-lightning"></i> India's #1 Instant Utility Service Provider
        </div>
        <h1 class="hero-title">
            Fastest Mobile Recharge & <span>Utility Bill Payment</span>
        </h1>
        <p class="hero-subtitle">
            Pay Mobile, DTH, Electricity, Gas, & Water bills instantly. Enjoy guaranteed <strong>1% Cashback</strong> on every transaction with 256-bit bank-grade encryption.
        </p>

        <!-- Trust Badges -->
        <div class="trust-stats-row">
            <div class="trust-stat-item">
                <i class="fa-solid fa-circle-check"></i> 0.2 Sec Auto-Processing
            </div>
            <div class="trust-stat-item">
                <i class="fa-solid fa-shield-cat"></i> 256-Bit SSL Encrypted
            </div>
            <div class="trust-stat-item">
                <i class="fa-solid fa-hand-holding-dollar"></i> Instant Auto-Refund Guarantee
            </div>
            <div class="trust-stat-item">
                <i class="fa-solid fa-percent"></i> 1% Unlimited Cashback
            </div>
        </div>

        <!-- MAIN UTILITY SERVICE PORTAL CARD -->
        <div class="utility-portal-card" id="utility-portal">
            
            <!-- Service Selector Tabs Header -->
            <div class="service-tabs-header">
                <button class="service-tab-btn active" onclick="switchServiceTab('mobile')">
                    <i class="fa-solid fa-mobile-screen-button"></i> Mobile
                </button>
                <button class="service-tab-btn" onclick="switchServiceTab('dth')">
                    <i class="fa-solid fa-tv"></i> DTH
                </button>
                <button class="service-tab-btn" onclick="switchServiceTab('electricity')">
                    <i class="fa-solid fa-bolt"></i> Electricity
                </button>
                <button class="service-tab-btn" onclick="switchServiceTab('gas')">
                    <i class="fa-solid fa-fire-flame-simple"></i> Gas Cylinder
                </button>
                <button class="service-tab-btn" onclick="switchServiceTab('water')">
                    <i class="fa-solid fa-droplet"></i> Water
                </button>
                <button class="service-tab-btn" onclick="switchServiceTab('broadband')">
                    <i class="fa-solid fa-wifi"></i> Broadband
                </button>
                <button class="service-tab-btn" onclick="switchServiceTab('fastag')">
                    <i class="fa-solid fa-car-tunnel"></i> FASTag
                </button>
                <button class="service-tab-btn" onclick="switchServiceTab('loan')">
                    <i class="fa-solid fa-building-columns"></i> Loan EMI
                </button>
            </div>

            <!-- Service Form Body -->
            <div class="service-form-body">
                
                <!-- 1. MOBILE RECHARGE PANEL -->
                <div class="form-view-panel active" id="panel-mobile">
                    <div class="panel-heading-row">
                        <h3 class="panel-title"><i class="fa-solid fa-mobile-retro"></i> Mobile Recharge</h3>
                        <div class="radio-switch-group">
                            <button class="radio-switch-btn active" onclick="setMobileSubtype('prepaid')">Prepaid</button>
                            <button class="radio-switch-btn" onclick="setMobileSubtype('postpaid')">Postpaid</button>
                        </div>
                    </div>

                    <form id="formMobileRecharge" onsubmit="handleRechargeSubmit(event, 1)">
                        <div class="form-grid-3">
                            <div class="form-group">
                                <label class="form-label">Mobile Number</label>
                                <div class="input-wrapper">
                                    <i class="fa-solid fa-phone input-icon"></i>
                                    <input type="text" class="form-input" id="mobileNumber" placeholder="Enter 10 digit number" maxlength="10" required onkeyup="autoDetectOperator(this.value)">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="form-label">Operator</label>
                                <div class="input-wrapper">
                                    <i class="fa-solid fa-tower-cell input-icon"></i>
                                    <select class="form-select" id="mobileOperator" required>
                                        <option value="">Select Operator</option>
                                        <option value="AT">Airtel</option>
                                        <option value="JIO">Jio Reliance</option>
                                        <option value="VI">Vodafone Idea (Vi)</option>
                                        <option value="BSNL">BSNL Prepaid</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="form-label">
                                    <span>Recharge Amount</span>
                                    <a class="input-action-link" onclick="openPlansModal()"><i class="fa-solid fa-eye"></i> Browse Plans</a>
                                </label>
                                <div class="input-wrapper">
                                    <i class="fa-solid fa-indian-rupee-sign input-icon"></i>
                                    <input type="number" class="form-input" id="mobileAmount" placeholder="Amount (e.g. 299)" min="10" required>
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn-submit-action">
                            <i class="fa-solid fa-bolt-lightning"></i> Proceed to Recharge Now
                        </button>
                    </form>
                </div>

                <!-- 2. DTH RECHARGE PANEL -->
                <div class="form-view-panel" id="panel-dth">
                    <div class="panel-heading-row">
                        <h3 class="panel-title"><i class="fa-solid fa-satellite-dish"></i> DTH Recharge</h3>
                    </div>

                    <form id="formDthRecharge" onsubmit="handleRechargeSubmit(event, 2)">
                        <div class="form-grid-3">
                            <div class="form-group">
                                <label class="form-label">Smart Card / Customer ID</label>
                                <div class="input-wrapper">
                                    <i class="fa-solid fa-id-card input-icon"></i>
                                    <input type="text" class="form-input" id="dthCustomerId" placeholder="Enter Smart Card No" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="form-label">DTH Operator</label>
                                <div class="input-wrapper">
                                    <i class="fa-solid fa-tv input-icon"></i>
                                    <select class="form-select" id="dthOperator" required>
                                        <option value="">Select Operator</option>
                                        <option value="TATAPLAY">Tata Play (Tata Sky)</option>
                                        <option value="AIRTELDTH">Airtel Digital TV</option>
                                        <option value="DISHTV">Dish TV</option>
                                        <option value="SUNDIRECT">Sun Direct</option>
                                        <option value="D2H">Videocon d2h</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="form-label">Amount</label>
                                <div class="input-wrapper">
                                    <i class="fa-solid fa-indian-rupee-sign input-icon"></i>
                                    <input type="number" class="form-input" id="dthAmount" placeholder="Enter Amount" min="50" required>
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn-submit-action">
                            <i class="fa-solid fa-bolt-lightning"></i> Proceed to DTH Recharge
                        </button>
                    </form>
                </div>

                <!-- 3. ELECTRICITY BILL PANEL -->
                <div class="form-view-panel" id="panel-electricity">
                    <div class="panel-heading-row">
                        <h3 class="panel-title"><i class="fa-solid fa-plug"></i> Electricity Bill Payment</h3>
                    </div>

                    <form id="formElectricityBill" onsubmit="handleFetchBillSubmit(event, 'Electricity')">
                        <div class="form-grid-2">
                            <div class="form-group">
                                <label class="form-label">State / Electricity Board</label>
                                <div class="input-wrapper">
                                    <i class="fa-solid fa-landmark input-icon"></i>
                                    <select class="form-select" id="elecBoard" required>
                                        <option value="">Select Board</option>
                                        <option value="ADANI">Adani Electricity Mumbai</option>
                                        <option value="BESCOM">BESCOM - Bengaluru</option>
                                        <option value="TNEB">TNEB - Tamil Nadu</option>
                                        <option value="MSEDCL">MSEDCL - Maharashtra Mahavitaran</option>
                                        <option value="UPPCL">UPPCL - Uttar Pradesh Power</option>
                                        <option value="WBSEDCL">WBSEDCL - West Bengal State Power</option>
                                        <option value="BSES_YAMUNA">BSES Yamuna - Delhi</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="form-label">Consumer Number / CA Number</label>
                                <div class="input-wrapper">
                                    <i class="fa-solid fa-hashtag input-icon"></i>
                                    <input type="text" class="form-input" id="elecConsumerId" placeholder="Enter Consumer Account ID" required>
                                </div>
                            </div>
                        </div>

                        <!-- Fetched Bill Display Card -->
                        <div class="bill-fetched-result" id="fetchedBillElec">
                            <div class="bill-details-grid">
                                <div class="bill-detail-item">
                                    <span class="bill-detail-label">Consumer Name</span>
                                    <span class="bill-detail-val" id="fetchedCustomerName">Rahul Kumar</span>
                                </div>
                                <div class="bill-detail-item">
                                    <span class="bill-detail-label">Bill Number</span>
                                    <span class="bill-detail-val" id="fetchedBillNo">BILL-883920</span>
                                </div>
                                <div class="bill-detail-item">
                                    <span class="bill-detail-label">Due Date</span>
                                    <span class="bill-detail-val" id="fetchedDueDate">24 Oct 2026</span>
                                </div>
                                <div class="bill-detail-item">
                                    <span class="bill-detail-label">Net Payable Amount</span>
                                    <span class="bill-detail-val highlight" id="fetchedBillAmount">₹1,840.00</span>
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn-submit-action" id="btnElecAction">
                            <i class="fa-solid fa-file-invoice-dollar"></i> Fetch & Pay Electricity Bill
                        </button>
                    </form>
                </div>

                <!-- 4. GAS CYLINDER & PIPED GAS PANEL -->
                <div class="form-view-panel" id="panel-gas">
                    <div class="panel-heading-row">
                        <h3 class="panel-title"><i class="fa-solid fa-fire-flame-simple"></i> Piped Gas & Cylinder Booking</h3>
                    </div>

                    <form id="formGasBill" onsubmit="handleFetchBillSubmit(event, 'Gas')">
                        <div class="form-grid-2">
                            <div class="form-group">
                                <label class="form-label">Gas Provider</label>
                                <div class="input-wrapper">
                                    <i class="fa-solid fa-fire input-icon"></i>
                                    <select class="form-select" id="gasBiller" required>
                                        <option value="">Select Gas Provider</option>
                                        <option value="INDANE">Indane Gas (LPG)</option>
                                        <option value="HPGAS">HP Gas (LPG)</option>
                                        <option value="BHARATGAS">Bharat Gas (LPG)</option>
                                        <option value="IGL">IGL - Indraprastha Gas Delhi</option>
                                        <option value="MGL">Mahanagar Gas Mumbai</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="form-label">Registered Contact / Consumer ID</label>
                                <div class="input-wrapper">
                                    <i class="fa-solid fa-user-gear input-icon"></i>
                                    <input type="text" class="form-input" id="gasConsumerId" placeholder="10 Digit Mobile / Consumer No" required>
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn-submit-action">
                            <i class="fa-solid fa-bolt-lightning"></i> Fetch & Book Cylinder
                        </button>
                    </form>
                </div>

                <!-- 5. WATER BILL PANEL -->
                <div class="form-view-panel" id="panel-water">
                    <div class="panel-heading-row">
                        <h3 class="panel-title"><i class="fa-solid fa-droplet"></i> Water Bill Payment</h3>
                    </div>

                    <form id="formWaterBill" onsubmit="handleFetchBillSubmit(event, 'Water')">
                        <div class="form-grid-2">
                            <div class="form-group">
                                <label class="form-label">Water Board</label>
                                <div class="input-wrapper">
                                    <i class="fa-solid fa-faucet-drip input-icon"></i>
                                    <select class="form-select" id="waterBoard" required>
                                        <option value="">Select Municipal Board</option>
                                        <option value="DJB">Delhi Jal Board (DJB)</option>
                                        <option value="BWSSB">Bengaluru Water Supply (BWSSB)</option>
                                        <option value="MCGM">MCGM Water Department Mumbai</option>
                                        <option value="HMWSSB">Hyderabad Water Board</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="form-label">K Number / Consumer ID</label>
                                <div class="input-wrapper">
                                    <i class="fa-solid fa-hashtag input-icon"></i>
                                    <input type="text" class="form-input" id="waterConsumerId" placeholder="Enter K Number" required>
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn-submit-action">
                            <i class="fa-solid fa-file-invoice"></i> Pay Water Bill
                        </button>
                    </form>
                </div>

                <!-- 6. BROADBAND PANEL -->
                <div class="form-view-panel" id="panel-broadband">
                    <div class="panel-heading-row">
                        <h3 class="panel-title"><i class="fa-solid fa-wifi"></i> Broadband / Landline Bill</h3>
                    </div>

                    <form id="formBroadband" onsubmit="handleFetchBillSubmit(event, 'Broadband')">
                        <div class="form-grid-3">
                            <div class="form-group">
                                <label class="form-label">Provider</label>
                                <div class="input-wrapper">
                                    <i class="fa-solid fa-network-wired input-icon"></i>
                                    <select class="form-select" id="bbProvider" required>
                                        <option value="">Select Provider</option>
                                        <option value="AIRTEL_BB">Airtel Xstream Fiber</option>
                                        <option value="JIO_BB">JioFiber Broadband</option>
                                        <option value="ACT_BB">ACT Fibernet</option>
                                        <option value="BSNL_BB">BSNL Broadband / Landline</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="form-label">Account No / Telephone No</label>
                                <div class="input-wrapper">
                                    <i class="fa-solid fa-phone-volume input-icon"></i>
                                    <input type="text" class="form-input" id="bbAccNo" placeholder="Account Number with STD code" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="form-label">Bill Amount</label>
                                <div class="input-wrapper">
                                    <i class="fa-solid fa-indian-rupee-sign input-icon"></i>
                                    <input type="number" class="form-input" id="bbAmount" placeholder="Bill Amount" min="100" required>
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn-submit-action">
                            <i class="fa-solid fa-bolt-lightning"></i> Pay Broadband Bill
                        </button>
                    </form>
                </div>

                <!-- 7. FASTAG PANEL -->
                <div class="form-view-panel" id="panel-fastag">
                    <div class="panel-heading-row">
                        <h3 class="panel-title"><i class="fa-solid fa-car-side"></i> FASTag Recharge</h3>
                    </div>

                    <form id="formFastag" onsubmit="handleRechargeSubmit(event, 3)">
                        <div class="form-grid-3">
                            <div class="form-group">
                                <label class="form-label">FASTag Issuer Bank</label>
                                <div class="input-wrapper">
                                    <i class="fa-solid fa-building-columns input-icon"></i>
                                    <select class="form-select" id="fastagBank" required>
                                        <option value="">Select Issuer Bank</option>
                                        <option value="NHAI">NHAI FASTag</option>
                                        <option value="ICICI">ICICI Bank FASTag</option>
                                        <option value="PAYTM">Paytm Payments Bank FASTag</option>
                                        <option value="SBI">SBI FASTag</option>
                                        <option value="HDFC">HDFC Bank FASTag</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="form-label">Vehicle Registration Number</label>
                                <div class="input-wrapper">
                                    <i class="fa-solid fa-closed-captioning input-icon"></i>
                                    <input type="text" class="form-input" id="fastagVehicle" placeholder="e.g. MH02CB1234" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="form-label">Amount</label>
                                <div class="input-wrapper">
                                    <i class="fa-solid fa-indian-rupee-sign input-icon"></i>
                                    <input type="number" class="form-input" id="fastagAmount" placeholder="Recharge Amount" min="100" required>
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn-submit-action">
                            <i class="fa-solid fa-bolt-lightning"></i> Recharge FASTag
                        </button>
                    </form>
                </div>

                <!-- 8. LOAN EMI REPAYMENT PANEL -->
                <div class="form-view-panel" id="panel-loan">
                    <div class="panel-heading-row">
                        <h3 class="panel-title"><i class="fa-solid fa-hand-holding-dollar"></i> Loan EMI Repayment</h3>
                    </div>

                    <form id="formLoan" onsubmit="handleFetchBillSubmit(event, 'Loan')">
                        <div class="form-grid-3">
                            <div class="form-group">
                                <label class="form-label">Lender / NBFC</label>
                                <div class="input-wrapper">
                                    <i class="fa-solid fa-briefcase input-icon"></i>
                                    <select class="form-select" id="loanLender" required>
                                        <option value="">Select Lender</option>
                                        <option value="BAJAJ">Bajaj Finserv</option>
                                        <option value="HDFC_LOAN">HDFC Bank Ltd - Loan</option>
                                        <option value="TVS">TVS Credit</option>
                                        <option value="MUTHOOT">Muthoot Finance</option>
                                        <option value="HOMEFIRST">Home First Finance</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="form-label">Loan Agreement / Account Number</label>
                                <div class="input-wrapper">
                                    <i class="fa-solid fa-file-contract input-icon"></i>
                                    <input type="text" class="form-input" id="loanAccNo" placeholder="Enter Loan Account No" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="form-label">EMI Amount</label>
                                <div class="input-wrapper">
                                    <i class="fa-solid fa-indian-rupee-sign input-icon"></i>
                                    <input type="number" class="form-input" id="loanAmount" placeholder="EMI Amount" min="100" required>
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn-submit-action">
                            <i class="fa-solid fa-shield-halved"></i> Pay Loan EMI
                        </button>
                    </form>
                </div>

            </div>
        </div>
    </section>

    <!-- PROMOTIONS & CASHBACK OFFERS -->
    <section class="offers-section" id="offers-section">
        <div class="section-header-flex">
            <h2 class="section-title"><i class="fa-solid fa-gift"></i> Exclusive Promo Offers & Cashback</h2>
            <span class="input-action-link" style="font-size: 0.95rem;">View All 12 Offers &rarr;</span>
        </div>

        <div class="offers-grid">
            <div class="offer-card">
                <div class="offer-icon-box"><i class="fa-solid fa-bolt"></i></div>
                <div class="offer-details">
                    <span class="offer-badge">First Electricity Bill</span>
                    <h4 class="offer-title">Flat ₹100 Cashback</h4>
                    <p class="offer-desc">Pay Electricity bill above ₹1,000 & get flat ₹100 instantly in wallet.</p>
                    <button class="btn-copy-code" onclick="copyPromo('BEST100')"><i class="fa-regular fa-copy"></i> Code: BEST100</button>
                </div>
            </div>

            <div class="offer-card">
                <div class="offer-icon-box"><i class="fa-solid fa-mobile-screen"></i></div>
                <div class="offer-details">
                    <span class="offer-badge">All Mobile & DTH</span>
                    <h4 class="offer-title">1% Unlimited Cashback</h4>
                    <p class="offer-desc">Get 1% guaranteed cashback credited directly to your wallet passbook.</p>
                    <button class="btn-copy-code" onclick="copyPromo('POWER10')"><i class="fa-regular fa-copy"></i> Auto-Applied</button>
                </div>
            </div>

            <div class="offer-card">
                <div class="offer-icon-box"><i class="fa-solid fa-fire"></i></div>
                <div class="offer-details">
                    <span class="offer-badge">LPG Cylinder Booking</span>
                    <h4 class="offer-title">Flat ₹50 Super Saver</h4>
                    <p class="offer-desc">Book Indane, HP or Bharat Gas cylinder & save flat ₹50 on your booking.</p>
                    <button class="btn-copy-code" onclick="copyPromo('GAS50')"><i class="fa-regular fa-copy"></i> Code: GAS50</button>
                </div>
            </div>
        </div>
    </section>

    <!-- WHY CHOOSE BEST RECHARGE FEATURES -->
    <section class="features-section" id="features-section">
        <div class="features-container">
            <div class="hero-badge-pill"><i class="fa-solid fa-star"></i> Enterprise Grade Utility Platform</div>
            <h2 class="hero-title" style="font-size: 2.5rem;">Why Millions Choose <span>Best Recharge</span></h2>
            <p class="hero-subtitle">Engineered for maximum uptime, instant settlement speed, and bulletproof security.</p>

            <div class="features-grid">
                <div class="feature-card">
                    <div class="feature-icon-wrapper"><i class="fa-solid fa-bolt-lightning"></i></div>
                    <h3 class="feature-card-title">Sub-Second Processing</h3>
                    <p class="feature-card-desc">Our high-throughput API gateway ensures your mobile recharge or bill payment completes in under 200 milliseconds.</p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon-wrapper"><i class="fa-solid fa-rotate-left"></i></div>
                    <h3 class="feature-card-title">Instant Auto-Refund</h3>
                    <p class="feature-card-desc">If an operator server fails to acknowledge your recharge, money is immediately credited back to your wallet within 5 seconds.</p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon-wrapper"><i class="fa-solid fa-percent"></i></div>
                    <h3 class="feature-card-title">1% Guaranteed Cashback</h3>
                    <p class="feature-card-desc">Earn 1% cashback on every mobile & DTH recharge. Passbook ledger automatically tracks every reward credit.</p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon-wrapper"><i class="fa-solid fa-shield-virus"></i></div>
                    <h3 class="feature-card-title">Bank Grade Encryption</h3>
                    <p class="feature-card-desc">PCI-DSS certified architecture with 256-bit TLS encryption protects every customer transaction and credential.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- B2B RETAILER & FRANCHISE CALCULATOR BANNER -->
    <section class="b2b-banner" id="b2b-banner">
        <div class="b2b-box">
            <div class="b2b-content">
                <div class="b2b-tag"><i class="fa-solid fa-shop"></i> Best Recharge Retailer Network</div>
                <h2 class="b2b-title">Start Your Own Recharge Kiosk & Earn Up To ₹45,000/Month</h2>
                <p class="b2b-desc">Become an authorized Best Recharge retailer or distributor. Get high commission rates on mobile, DTH, electricity & pan card services.</p>
                <button class="btn-glow-primary" onclick="openAuthModal('register')">
                    <i class="fa-solid fa-handshake"></i> Become a Retailer Partner
                </button>
            </div>

            <!-- Interactive Commission Calculator -->
            <div class="b2b-calc-card">
                <h3 class="calc-title"><i class="fa-solid fa-calculator"></i> Earnings Estimator</h3>
                <div class="range-slider-group">
                    <div class="slider-label-row">
                        <span>Daily Recharge Volume</span>
                        <span id="sliderVal" style="color: var(--accent-cyan);">₹50,000 / day</span>
                    </div>
                    <input type="range" class="custom-range-input" min="5000" max="200000" step="5000" value="50000" oninput="updateEarningsCalc(this.value)">
                </div>

                <div class="earning-box">
                    <span class="earning-lbl">Estimated Monthly Profit</span>
                    <div class="earning-amt" id="estMonthlyProfit">₹22,500.00</div>
                </div>
            </div>
        </div>
    </section>

    <!-- SUPPORTED OPERATORS GRID -->
    <section class="partners-section">
        <div class="partners-title">Supported Utility Partners & Network Operators</div>
        <div class="partners-flex">
            <div class="partner-badge"><i class="fa-solid fa-signal" style="color: #EF4444;"></i> Airtel</div>
            <div class="partner-badge"><i class="fa-solid fa-bolt" style="color: #3B82F6;"></i> Jio Reliance</div>
            <div class="partner-badge"><i class="fa-solid fa-tower-cell" style="color: #F59E0B;"></i> Vodafone Idea</div>
            <div class="partner-badge"><i class="fa-solid fa-satellite" style="color: #10B981;"></i> Tata Play</div>
            <div class="partner-badge"><i class="fa-solid fa-plug-circle-bolt" style="color: #00F2FE;"></i> Adani Power</div>
            <div class="partner-badge"><i class="fa-solid fa-fire" style="color: #EC4899;"></i> Indane Gas</div>
            <div class="partner-badge"><i class="fa-solid fa-faucet" style="color: #06B6D4;"></i> Delhi Jal Board</div>
        </div>
    </section>

    <!-- FOOTER -->
    <footer class="footer">
        <div class="footer-container">
            <div>
                <img src="/best_recharge.PNG" alt="Best Recharge" class="footer-brand-logo">
                <p class="footer-desc">
                    Best Recharge is a premier utility service provider enabling seamless digital payments for mobile recharges, utility bill payments, and agent franchise management across India.
                </p>
                <div class="security-badges">
                    <span class="security-item"><i class="fa-solid fa-lock"></i> PCI-DSS v4.0</span>
                    <span class="security-item"><i class="fa-solid fa-shield-check"></i> ISO 27001</span>
                    <span class="security-item"><i class="fa-solid fa-building-columns"></i> NPCI Compliant</span>
                </div>
            </div>

            <div>
                <h4 class="footer-col-title">Recharge & Payments</h4>
                <ul class="footer-links">
                    <li><a href="javascript:void(0)" onclick="switchServiceTab('mobile')">Mobile Recharge</a></li>
                    <li><a href="javascript:void(0)" onclick="switchServiceTab('dth')">DTH Connection</a></li>
                    <li><a href="javascript:void(0)" onclick="switchServiceTab('electricity')">Electricity Bill</a></li>
                    <li><a href="javascript:void(0)" onclick="switchServiceTab('gas')">Piped Gas & Cylinder</a></li>
                    <li><a href="javascript:void(0)" onclick="switchServiceTab('water')">Water Bill Payment</a></li>
                </ul>
            </div>

            <div>
                <h4 class="footer-col-title">B2B Retailer</h4>
                <ul class="footer-links">
                    <li><a href="#b2b-banner">Retailer Franchise</a></li>
                    <li><a href="#b2b-banner">Distributor Login</a></li>
                    <li><a href="javascript:void(0)" onclick="openAuthModal('register')">Become an Agent</a></li>
                    <li><a href="#offers-section">Commission Rates</a></li>
                    <li><a href="javascript:void(0)" onclick="openStatusModal()">API Documentation</a></li>
                </ul>
            </div>

            <div>
                <h4 class="footer-col-title">Help & Support</h4>
                <ul class="footer-links">
                    <li><a href="javascript:void(0)" onclick="openStatusModal()">Transaction Status Check</a></li>
                    <li><a href="javascript:void(0)" onclick="showToast('Helpline 24x7: 1800-123-4567')">24x7 Customer Support</a></li>
                    <li><a href="javascript:void(0)" onclick="showToast('Email: support@bestrecharge.com')">Raise a Grievance</a></li>
                    <li><a href="javascript:void(0)" onclick="openWalletModal()">Wallet Refund Policy</a></li>
                    <li><a href="javascript:void(0)" onclick="showToast('Privacy Policy & Terms Active')">Privacy Policy</a></li>
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

    <!-- MODAL: MOBILE PLANS BROWSER -->
    <div class="modal-backdrop" id="plansModal">
        <div class="modal-box plans-modal-box">
            <button class="modal-close-btn" onclick="closeModal('plansModal')"><i class="fa-solid fa-xmark"></i></button>
            <h3 class="panel-title" style="margin-bottom: 1.25rem;"><i class="fa-solid fa-list-check"></i> Available Mobile Plans</h3>
            
            <div class="radio-switch-group" style="margin-bottom: 1.5rem; justify-content: flex-start;">
                <button class="radio-switch-btn active" onclick="filterPlans('all')">All Plans</button>
                <button class="radio-switch-btn" onclick="filterPlans('unlimited')">Truly Unlimited</button>
                <button class="radio-switch-btn" onclick="filterPlans('data')">Data Add-on</button>
                <button class="radio-switch-btn" onclick="filterPlans('ott')">OTT Bundles</button>
            </div>

            <div id="plansListContainer">
                <div class="plan-item-card">
                    <div>
                        <div class="plan-price-tag">₹299</div>
                        <div class="plan-meta-pills">
                            <span class="plan-pill"><i class="fa-regular fa-clock"></i> 28 Days</span>
                            <span class="plan-pill"><i class="fa-solid fa-wifi"></i> 1.5 GB/Day</span>
                            <span class="plan-pill"><i class="fa-solid fa-phone"></i> Unlimited Calls</span>
                        </div>
                        <p style="font-size: 0.85rem; color: var(--text-muted);">100 SMS/Day + Free JioCinema & Wynk Music Subscription.</p>
                    </div>
                    <button class="btn-glow-primary" onclick="selectPlan(299)">Select ₹299</button>
                </div>

                <div class="plan-item-card">
                    <div>
                        <div class="plan-price-tag">₹719</div>
                        <div class="plan-meta-pills">
                            <span class="plan-pill"><i class="fa-regular fa-clock"></i> 84 Days</span>
                            <span class="plan-pill"><i class="fa-solid fa-wifi"></i> 2.0 GB/Day</span>
                            <span class="plan-pill"><i class="fa-solid fa-phone"></i> Unlimited Calls</span>
                        </div>
                        <p style="font-size: 0.85rem; color: var(--text-muted);">Unlimited 5G Data Included + Disney+ Hotstar 3 Months Mobile.</p>
                    </div>
                    <button class="btn-glow-primary" onclick="selectPlan(719)">Select ₹719</button>
                </div>

                <div class="plan-item-card">
                    <div>
                        <div class="plan-price-tag">₹61</div>
                        <div class="plan-meta-pills">
                            <span class="plan-pill"><i class="fa-regular fa-clock"></i> Active Base</span>
                            <span class="plan-pill"><i class="fa-solid fa-wifi"></i> 6 GB Data</span>
                        </div>
                        <p style="font-size: 0.85rem; color: var(--text-muted);">High speed 5G Data booster pack for existing active connection.</p>
                    </div>
                    <button class="btn-glow-primary" onclick="selectPlan(61)">Select ₹61</button>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL: WALLET & ADD MONEY -->
    <div class="modal-backdrop" id="walletModal">
        <div class="modal-box">
            <button class="modal-close-btn" onclick="closeModal('walletModal')"><i class="fa-solid fa-xmark"></i></button>
            <h3 class="panel-title" style="margin-bottom: 0.5rem;"><i class="fa-solid fa-wallet"></i> Best Recharge Wallet</h3>
            <p style="font-size: 0.9rem; color: var(--text-muted); margin-bottom: 1.5rem;">Instant auto-credit wallet with zero processing charges.</p>

            <div style="background: rgba(7, 13, 30, 0.8); border: 1px solid var(--border-glow); padding: 1.5rem; border-radius: 16px; text-align: center; margin-bottom: 1.5rem;">
                <span class="wallet-label">Available Balance</span>
                <div style="font-size: 2.25rem; font-weight: 900; color: var(--accent-cyan);" id="modalWalletBalance">₹1,250.00</div>
                <div style="font-size: 0.8rem; color: var(--success-green); margin-top: 0.25rem;"><i class="fa-solid fa-circle-check"></i> Includes ₹45.00 Cashback Earned</div>
            </div>

            <h4 style="font-size: 0.95rem; font-weight: 800; color: var(--text-main); margin-bottom: 0.75rem;">Add Funds to Wallet</h4>
            <div class="form-group" style="margin-bottom: 1rem;">
                <div class="input-wrapper">
                    <i class="fa-solid fa-indian-rupee-sign input-icon"></i>
                    <input type="number" class="form-input" id="addFundsAmount" placeholder="Enter amount to add" value="500">
                </div>
            </div>

            <div style="display: flex; gap: 0.5rem; margin-bottom: 1.5rem;">
                <button class="btn-outline-glow" style="flex: 1; padding: 0.4rem;" onclick="setAddFundPreset(200)">+ ₹200</button>
                <button class="btn-outline-glow" style="flex: 1; padding: 0.4rem;" onclick="setAddFundPreset(500)">+ ₹500</button>
                <button class="btn-outline-glow" style="flex: 1; padding: 0.4rem;" onclick="setAddFundPreset(1000)">+ ₹1000</button>
            </div>

            <button class="btn-glow-primary" style="width: 100%; justify-content: center;" onclick="handleAddMoneySubmit()">
                <i class="fa-solid fa-qrcode"></i> Pay via UPI / QR Code
            </button>
        </div>
    </div>

    <!-- MODAL: TRANSACTION STATUS CHECKER -->
    <div class="modal-backdrop" id="statusModal">
        <div class="modal-box">
            <button class="modal-close-btn" onclick="closeModal('statusModal')"><i class="fa-solid fa-xmark"></i></button>
            <h3 class="panel-title" style="margin-bottom: 0.5rem;"><i class="fa-solid fa-magnifying-glass"></i> Track Transaction Status</h3>
            <p style="font-size: 0.85rem; color: var(--text-muted); margin-bottom: 1.5rem;">Enter your Order ID (REC...) to query live operator status.</p>

            <div class="form-group" style="margin-bottom: 1.25rem;">
                <div class="input-wrapper">
                    <i class="fa-solid fa-receipt input-icon"></i>
                    <input type="text" class="form-input" id="txnQueryId" placeholder="e.g. REC202610081234">
                </div>
            </div>

            <button class="btn-glow-primary" style="width: 100%; justify-content: center;" onclick="queryTxnStatus()">
                <i class="fa-solid fa-rotate"></i> Query Live Status
            </button>

            <div id="statusQueryResult" style="margin-top: 1.25rem; display: none;"></div>
        </div>
    </div>

    <!-- MODAL: AUTHENTICATION (LOGIN / REGISTER) -->
    <div class="modal-backdrop" id="authModal">
        <div class="modal-box">
            <button class="modal-close-btn" onclick="closeModal('authModal')"><i class="fa-solid fa-xmark"></i></button>
            
            <div class="radio-switch-group" style="margin-bottom: 1.5rem;">
                <button class="radio-switch-btn active" id="tabAuthLogin" onclick="switchAuthTab('login')">Account Login</button>
                <button class="radio-switch-btn" id="tabAuthRegister" onclick="switchAuthTab('register')">Register New</button>
            </div>

            <!-- Login Form -->
            <form id="formLogin" onsubmit="handleAuthSubmit(event, 'login')">
                <div class="form-group" style="margin-bottom: 1rem;">
                    <label class="form-label">Mobile Number or Email</label>
                    <div class="input-wrapper">
                        <i class="fa-solid fa-user input-icon"></i>
                        <input type="text" class="form-input" id="loginId" placeholder="Registered mobile or email" required>
                    </div>
                </div>

                <div class="form-group" style="margin-bottom: 1.5rem;">
                    <label class="form-label">Password</label>
                    <div class="input-wrapper">
                        <i class="fa-solid fa-key input-icon"></i>
                        <input type="password" class="form-input" id="loginPassword" placeholder="Enter password" required>
                    </div>
                </div>

                <button type="submit" class="btn-glow-primary" style="width: 100%; justify-content: center;">
                    <i class="fa-solid fa-right-to-bracket"></i> Login to Account
                </button>
            </form>

            <!-- Register Form -->
            <form id="formRegister" style="display: none;" onsubmit="handleAuthSubmit(event, 'register')">
                <div class="form-group" style="margin-bottom: 1rem;">
                    <label class="form-label">Full Name</label>
                    <div class="input-wrapper">
                        <i class="fa-solid fa-id-card input-icon"></i>
                        <input type="text" class="form-input" id="regName" placeholder="Enter full name" required>
                    </div>
                </div>

                <div class="form-group" style="margin-bottom: 1rem;">
                    <label class="form-label">Mobile Number</label>
                    <div class="input-wrapper">
                        <i class="fa-solid fa-phone input-icon"></i>
                        <input type="text" class="form-input" id="regMobile" placeholder="10 digit mobile" required>
                    </div>
                </div>

                <div class="form-group" style="margin-bottom: 1.5rem;">
                    <label class="form-label">Account Type</label>
                    <div class="input-wrapper">
                        <i class="fa-solid fa-briefcase input-icon"></i>
                        <select class="form-select" id="regAccountType">
                            <option value="customer">Personal Customer</option>
                            <option value="retailer">Retailer / Agent Kiosk</option>
                        </select>
                    </div>
                </div>

                <button type="submit" class="btn-glow-primary" style="width: 100%; justify-content: center;">
                    <i class="fa-solid fa-user-plus"></i> Create Account
                </button>
            </form>
        </div>
    </div>

    <!-- TOAST NOTIFICATION CONTAINER -->
    <div class="toast-container" id="toastContainer"></div>

    <!-- JAVASCRIPT APP LOGIC -->
    <script>
        // Global State Variables
        let currentWalletBalance = 1250.00;
        let activeAuthToken = localStorage.getItem('best_recharge_token') || null;

        // Auto Operator prefix mapping
        const operatorPrefixes = {
            '98': 'AT', '99': 'AT', '97': 'AT',
            '91': 'JIO', '93': 'JIO', '70': 'JIO',
            '982': 'VI', '989': 'VI', '88': 'VI',
            '94': 'BSNL', '95': 'BSNL'
        };

        function autoDetectOperator(number) {
            if (number.length >= 2) {
                const prefix2 = number.substring(0, 2);
                const prefix3 = number.substring(0, 3);
                const opSelect = document.getElementById('mobileOperator');
                if (operatorPrefixes[prefix3]) {
                    opSelect.value = operatorPrefixes[prefix3];
                } else if (operatorPrefixes[prefix2]) {
                    opSelect.value = operatorPrefixes[prefix2];
                }
            }
        }

        // Service Tab Switcher
        function switchServiceTab(tabName) {
            // Update Tab buttons
            document.querySelectorAll('.service-tab-btn').forEach(btn => btn.classList.remove('active'));
            event?.currentTarget?.classList.add('active');

            // Update Panel views
            document.querySelectorAll('.form-view-panel').forEach(panel => panel.classList.remove('active'));
            const targetPanel = document.getElementById(`panel-${tabName}`);
            if (targetPanel) {
                targetPanel.classList.add('active');
            }
        }

        function setMobileSubtype(type) {
            const btns = document.querySelectorAll('#panel-mobile .radio-switch-btn');
            btns.forEach(b => b.classList.remove('active'));
            event.target.classList.add('active');
            showToast(`Switched to Mobile ${type.toUpperCase()}`);
        }

        // Handle Recharge Submission (Mobile/DTH/FASTag)
        function handleRechargeSubmit(e, typeId) {
            e.preventDefault();

            let amount = 0;
            let number = '';
            let operator = '';

            if (typeId === 1) { // Mobile
                number = document.getElementById('mobileNumber').value;
                operator = document.getElementById('mobileOperator').value;
                amount = parseFloat(document.getElementById('mobileAmount').value);
            } else if (typeId === 2) { // DTH
                number = document.getElementById('dthCustomerId').value;
                operator = document.getElementById('dthOperator').value;
                amount = parseFloat(document.getElementById('dthAmount').value);
            } else if (typeId === 3) { // FASTag
                number = document.getElementById('fastagVehicle').value;
                operator = document.getElementById('fastagBank').value;
                amount = parseFloat(document.getElementById('fastagAmount').value);
            }

            if (amount > currentWalletBalance) {
                showToast(`Insufficient Wallet Balance! Required ₹${amount}`, 'error');
                openWalletModal();
                return;
            }

            // Deduct Wallet Balance & Simulate Process
            currentWalletBalance -= amount;
            updateWalletDisplays();

            const txnId = 'REC' + Date.now();
            const cashback = (amount * 0.01).toFixed(2);
            currentWalletBalance += parseFloat(cashback);

            setTimeout(() => {
                updateWalletDisplays();
                showToast(`🎉 Recharge Successful! ₹${cashback} 1% Cashback added to Wallet. Txn ID: ${txnId}`, 'success');
            }, 1200);
        }

        // Handle Fetch Bill Submit
        function handleFetchBillSubmit(e, serviceCategory) {
            e.preventDefault();
            const resultBox = document.getElementById('fetchedBillElec');
            const actionBtn = document.getElementById('btnElecAction');

            if (!resultBox.classList.contains('active')) {
                // Step 1: Simulate Fetching Bill
                resultBox.classList.add('active');
                actionBtn.innerHTML = `<i class="fa-solid fa-credit-card"></i> Pay ₹1,840.00 Now`;
                showToast(`Bill details fetched successfully for ${serviceCategory}`, 'info');
            } else {
                // Step 2: Pay Bill
                if (1840 > currentWalletBalance) {
                    showToast('Insufficient balance for Electricity Bill!', 'error');
                    openWalletModal();
                    return;
                }
                currentWalletBalance -= 1840;
                updateWalletDisplays();
                resultBox.classList.remove('active');
                actionBtn.innerHTML = `<i class="fa-solid fa-file-invoice-dollar"></i> Fetch & Pay Electricity Bill`;
                showToast('🎉 Electricity Bill Paid Successfully! Receipt generated.', 'success');
            }
        }

        // B2B Earnings Calculator
        function updateEarningsCalc(val) {
            const daily = parseFloat(val);
            document.getElementById('sliderVal').innerText = `₹${daily.toLocaleString('en-IN')} / day`;
            // Profit calculated at 1.5% margin + bill payment incentives
            const monthlyProfit = (daily * 30 * 0.015).toFixed(0);
            document.getElementById('estMonthlyProfit').innerText = `₹${parseInt(monthlyProfit).toLocaleString('en-IN')}.00`;
        }

        // Wallet Balance Updates
        function updateWalletDisplays() {
            const formatted = `₹${currentWalletBalance.toLocaleString('en-IN', {minimumFractionDigits: 2})}`;
            document.getElementById('headerWalletBalance').innerText = formatted;
            document.getElementById('modalWalletBalance').innerText = formatted;
        }

        function setAddFundPreset(amt) {
            document.getElementById('addFundsAmount').value = amt;
        }

        function handleAddMoneySubmit() {
            const amt = parseFloat(document.getElementById('addFundsAmount').value);
            if (isNaN(amt) || amt <= 0) {
                showToast('Please enter a valid amount', 'error');
                return;
            }
            currentWalletBalance += amt;
            updateWalletDisplays();
            closeModal('walletModal');
            showToast(`₹${amt} added to your Best Recharge Wallet!`, 'success');
        }

        // Promo Code Copy
        function copyPromo(code) {
            navigator.clipboard.writeText(code);
            showToast(`Promo Code "${code}" copied! Paste at payment checkout.`, 'success');
        }

        // Modal Handlers
        function openPlansModal() { document.getElementById('plansModal').classList.add('active'); }
        function openWalletModal() { document.getElementById('walletModal').classList.add('active'); }
        function openStatusModal() { document.getElementById('statusModal').classList.add('active'); }
        function openAuthModal(mode) {
            switchAuthTab(mode);
            document.getElementById('authModal').classList.add('active');
        }

        function closeModal(id) {
            document.getElementById(id).classList.remove('active');
        }

        function selectPlan(amt) {
            document.getElementById('mobileAmount').value = amt;
            closeModal('plansModal');
            showToast(`Selected ₹${amt} Plan`, 'info');
        }

        function switchAuthTab(mode) {
            if (mode === 'login') {
                document.getElementById('tabAuthLogin').classList.add('active');
                document.getElementById('tabAuthRegister').classList.remove('active');
                document.getElementById('formLogin').style.display = 'block';
                document.getElementById('formRegister').style.display = 'none';
            } else {
                document.getElementById('tabAuthRegister').classList.add('active');
                document.getElementById('tabAuthLogin').classList.remove('active');
                document.getElementById('formRegister').style.display = 'block';
                document.getElementById('formLogin').style.display = 'none';
            }
        }

        function handleAuthSubmit(e, mode) {
            e.preventDefault();
            closeModal('authModal');
            showToast(mode === 'login' ? 'Successfully Logged In!' : 'Account Created Successfully!', 'success');
        }

        function queryTxnStatus() {
            const txId = document.getElementById('txnQueryId').value;
            const resBox = document.getElementById('statusQueryResult');
            if (!txId) {
                showToast('Please enter an Order ID', 'error');
                return;
            }
            resBox.style.display = 'block';
            resBox.innerHTML = `
                <div style="background: rgba(16, 185, 129, 0.1); border: 1px solid var(--success-green); padding: 1rem; border-radius: 12px;">
                    <div style="color: var(--success-green); font-weight: 800;"><i class="fa-solid fa-circle-check"></i> Status: SUCCESS</div>
                    <div style="font-size: 0.85rem; margin-top: 0.4rem; color: var(--text-muted);">
                        Order ID: <strong>${txId}</strong><br>
                        Operator Reference: <strong>OPR99182374</strong><br>
                        Status: Operator Acknowledged & Cashback Credited.
                    </div>
                </div>
            `;
        }

        // Toast Helper
        function showToast(msg, type = 'info') {
            const container = document.getElementById('toastContainer');
            const toast = document.createElement('div');
            toast.className = 'toast-msg';
            
            let icon = '<i class="fa-solid fa-circle-info" style="color: var(--accent-cyan);"></i>';
            if (type === 'success') icon = '<i class="fa-solid fa-circle-check" style="color: var(--success-green);"></i>';
            if (type === 'error') icon = '<i class="fa-solid fa-triangle-exclamation" style="color: var(--danger-red);"></i>';

            toast.innerHTML = `${icon} <span>${msg}</span>`;
            container.appendChild(toast);

            setTimeout(() => {
                toast.style.opacity = '0';
                toast.style.transform = 'translateX(100%)';
                toast.style.transition = 'all 0.3s';
                setTimeout(() => toast.remove(), 300);
            }, 3500);
        }
    </script>
</body>
</html>
