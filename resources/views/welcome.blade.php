<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title id="headTitleTag">MeetingPulse - Enterprise Video & Work Collaboration Platform</title>
    <link id="appFavicon" rel="shortcut icon" href="">
    
    <!-- Google Fonts: Google Sans / Outfit & Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- FontAwesome Icons & Google Material Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined">
    
    <!-- LiveKit Client SDK -->
    <script src="https://unpkg.com/livekit-client/dist/livekit-client.umd.min.js"></script>

    <style>
        :root {
            --main-navy: #0B194C;
            --main-blue: #0E71EB;
            --main-blue-hover: #0056C6;
            --main-blue-light: #EBF4FF;
            --main-dark-card: #0A1338;
            --main-text-dark: #00052C;
            --main-text-muted: #525C76;
            --bg-main: #ffffff;
            --bg-secondary: #F8FAFC;
            --border-color: #E2E8F0;
            --shadow-sm: 0 2px 8px rgba(11, 25, 76, 0.06);
            --shadow-md: 0 10px 30px rgba(11, 25, 76, 0.12);
            --shadow-lg: 0 20px 40px rgba(11, 25, 76, 0.18);
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Outfit', 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            scroll-behavior: smooth;
        }

        body {
            background-color: var(--bg-main);
            color: var(--main-text-dark);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            overflow-x: hidden;
        }

        /* main-Style Header Navigation Bar */
        .main-header {
            background: var(--main-navy);
            border-bottom: 1px solid rgba(255, 255, 255, 0.12);
            position: sticky;
            top: 0;
            z-index: 1000;
            padding: 0.85rem 2.5rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 4px 20px rgba(0, 5, 44, 0.25);
        }

        .main-header-left {
            display: flex;
            align-items: center;
            gap: 2.2rem;
        }

        .main-brand {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            text-decoration: none;
            color: #ffffff;
            font-size: 1.5rem;
            font-weight: 800;
            letter-spacing: -0.03em;
        }

        .main-brand-icon {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, var(--main-blue), #2563eb);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.25rem;
            box-shadow: 0 4px 14px rgba(14, 113, 235, 0.4);
            overflow: hidden;
        }

        .main-brand-icon img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .main-nav-menu {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            list-style: none;
            margin: 0;
            padding: 0;
        }

        .main-nav-item {
            position: relative;
        }

        .main-nav-link {
            color: #ffffff !important;
            text-decoration: none;
            font-size: 0.92rem;
            font-weight: 700;
            padding: 0.55rem 1.1rem;
            border-radius: 9999px;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.2s ease;
            cursor: pointer;
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(8px);
        }

        .main-nav-link:hover, .main-nav-link.active {
            color: #0B194C !important;
            background: #ffffff;
            border-color: #ffffff;
            box-shadow: 0 4px 16px rgba(255, 255, 255, 0.35);
            transform: translateY(-1px);
        }

        .main-mobile-toggle {
            display: none;
            background: rgba(255, 255, 255, 0.12);
            border: 1px solid rgba(255, 255, 255, 0.25);
            color: #ffffff;
            font-size: 1.25rem;
            width: 42px;
            height: 42px;
            border-radius: 0.6rem;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.2s;
        }

        .main-mobile-toggle:hover {
            background: rgba(255, 255, 255, 0.25);
        }

        /* Mega Dropdown Menu */
        .main-dropdown {
            position: absolute;
            top: 100%;
            left: 0;
            width: 320px;
            background: #ffffff;
            border-radius: 1rem;
            box-shadow: var(--shadow-lg);
            border: 1px solid var(--border-color);
            padding: 1rem;
            opacity: 0;
            visibility: hidden;
            transform: translateY(10px);
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
            z-index: 1100;
        }

        .main-nav-item:hover .main-dropdown {
            opacity: 1;
            visibility: visible;
            transform: translateY(6px);
        }

        .main-dropdown-item {
            display: flex;
            align-items: flex-start;
            gap: 0.85rem;
            padding: 0.75rem;
            border-radius: 0.6rem;
            text-decoration: none;
            color: var(--main-text-dark);
            transition: background 0.15s;
        }

        .main-dropdown-item:hover {
            background: #F1F5F9;
        }

        .main-dropdown-icon {
            width: 36px;
            height: 36px;
            border-radius: 8px;
            background: var(--main-blue-light);
            color: var(--main-blue);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.1rem;
            flex-shrink: 0;
        }

        .main-dropdown-title {
            font-weight: 700;
            font-size: 0.9rem;
            color: var(--main-text-dark);
            margin-bottom: 0.15rem;
        }

        .main-dropdown-desc {
            font-size: 0.78rem;
            color: var(--main-text-muted);
            line-height: 1.35;
        }

        /* High-Visibility Dynamic Section Pills */
        .nav-pill-container {
            display: flex;
            align-items: center;
            gap: 0.25rem;
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.18);
            border-radius: 9999px;
            padding: 0.25rem 0.35rem;
            margin-left: 0.5rem;
        }

        .nav-pill-link {
            text-decoration: none;
            color: #ffffff;
            font-weight: 600;
            font-size: 0.88rem;
            padding: 0.4rem 0.95rem;
            border-radius: 9999px;
            display: inline-flex;
            align-items: center;
            gap: 0.45rem;
            transition: all 0.2s;
            cursor: pointer;
        }

        .nav-pill-link:hover, .nav-pill-link.active {
            background: #ffffff;
            color: var(--main-blue);
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.15);
        }

        .main-header-right {
            display: flex;
            align-items: center;
            gap: 0.85rem;
            position: relative;
        }

        .main-icon-btn {
            background: transparent;
            border: none;
            color: rgba(255, 255, 255, 0.85);
            font-size: 1.1rem;
            width: 36px;
            height: 36px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.2s;
        }

        .main-icon-btn:hover {
            background: rgba(255, 255, 255, 0.15);
            color: #ffffff;
        }

        .main-lang-selector {
            color: rgba(255, 255, 255, 0.85);
            font-size: 0.85rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 0.4rem;
            cursor: pointer;
            padding: 0.4rem 0.75rem;
            border-radius: 9999px;
        }

        .main-lang-selector:hover {
            background: rgba(255, 255, 255, 0.12);
            color: #ffffff;
        }

        .btn-main-outline {
            background: transparent;
            border: 1.5px solid rgba(255, 255, 255, 0.4);
            color: #ffffff;
            font-weight: 700;
            font-size: 0.9rem;
            padding: 0.55rem 1.25rem;
            border-radius: 9999px;
            cursor: pointer;
            transition: all 0.2s;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-main-outline:hover {
            border-color: #ffffff;
            background: rgba(255, 255, 255, 0.15);
        }

        .btn-main-primary {
            background: var(--main-blue);
            color: #ffffff;
            font-weight: 700;
            font-size: 0.9rem;
            padding: 0.6rem 1.4rem;
            border-radius: 9999px;
            border: none;
            cursor: pointer;
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 4px 16px rgba(14, 113, 235, 0.4);
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-main-primary:hover {
            background: var(--main-blue-hover);
            transform: translateY(-1px);
            box-shadow: 0 6px 20px rgba(14, 113, 235, 0.5);
        }

        /* main-Style Header Actions & Links */
        .header-link-text {
            color: rgba(255, 255, 255, 0.9);
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: 600;
            padding: 0.4rem 0.65rem;
            border-radius: 0.5rem;
            transition: all 0.2s;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
        }

        .header-link-text:hover {
            color: #ffffff;
            background: rgba(255, 255, 255, 0.12);
        }

        .btn-header-sales {
            background: #EBF4FF;
            color: #0B194C;
            font-weight: 700;
            font-size: 0.88rem;
            padding: 0.55rem 1.25rem;
            border-radius: 9999px;
            border: none;
            cursor: pointer;
            transition: all 0.2s;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
        }

        .btn-header-sales:hover {
            background: #ffffff;
            box-shadow: 0 4px 14px rgba(255, 255, 255, 0.3);
            transform: translateY(-1px);
        }

        .btn-header-signup {
            background: #0E71EB;
            color: #ffffff;
            font-weight: 700;
            font-size: 0.88rem;
            padding: 0.55rem 1.3rem;
            border-radius: 9999px;
            border: none;
            cursor: pointer;
            transition: all 0.2s;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            box-shadow: 0 4px 14px rgba(14, 113, 235, 0.4);
        }

        .btn-header-signup:hover {
            background: #0056C6;
            transform: translateY(-1px);
            box-shadow: 0 6px 18px rgba(14, 113, 235, 0.5);
        }

        .g-time-display {
            font-size: 0.85rem;
            color: rgba(255, 255, 255, 0.8);
            font-weight: 600;
            background: rgba(255, 255, 255, 0.1);
            padding: 0.35rem 0.85rem;
            border-radius: 9999px;
            border: 1px solid rgba(255, 255, 255, 0.15);
        }

        /* Profile Dropdown */
        .user-profile-btn {
            display: flex;
            align-items: center;
            gap: 0.6rem;
            padding: 0.35rem 0.85rem;
            border-radius: 9999px;
            background: rgba(255, 255, 255, 0.15);
            border: 1px solid rgba(255, 255, 255, 0.25);
            color: white;
            cursor: pointer;
            transition: all 0.2s;
        }

        .user-profile-btn:hover {
            background: rgba(255, 255, 255, 0.25);
        }

        .user-avatar-img {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            object-fit: cover;
            background: var(--main-blue);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 0.9rem;
        }

        .profile-dropdown-menu {
            display: none;
            position: absolute;
            top: 120%;
            right: 0;
            width: 320px;
            background: #ffffff;
            border-radius: 1rem;
            box-shadow: var(--shadow-lg);
            border: 1px solid var(--border-color);
            padding: 1rem;
            z-index: 100;
            color: var(--main-text-dark);
        }

        .profile-dropdown-menu.active {
            display: block;
            animation: fadeIn 0.2s ease-out;
        }

        /* main Hero Section Split Layout */
        .main-hero-section {
            background: radial-gradient(circle at 50% 10%, #152A72 0%, #0B194C 60%, #050B24 100%);
            color: #ffffff;
            padding: 8rem 2.5rem 5rem;
            position: relative;
            overflow: hidden;
        }

        .main-hero-bg-glow {
            position: absolute;
            top: 20%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 700px;
            height: 700px;
            background: radial-gradient(circle, rgba(14, 113, 235, 0.25) 0%, rgba(14, 113, 235, 0) 70%);
            pointer-events: none;
        }

        .main-hero-container {
            max-width: 90%;
            margin: 0 auto;
            position: relative;
            z-index: 2;
        }

        .main-hero-split-grid {
            display: grid;
            grid-template-columns: 1fr 1.15fr;
            gap: 3.5rem;
            align-items: center;
        }

        .main-hero-content-left {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            text-align: left;
        }

        .main-hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            background: rgba(255, 255, 255, 0.12);
            border: 1px solid rgba(255, 255, 255, 0.25);
            padding: 0.45rem 1.1rem;
            border-radius: 9999px;
            font-size: 0.85rem;
            font-weight: 700;
            letter-spacing: 0.03em;
            text-transform: uppercase;
            color: #ffffff;
            margin-bottom: 1.5rem;
            backdrop-filter: blur(8px);
        }

        .main-hero-title {
            font-size: 4.5rem;
            font-weight: 800;
            line-height: 1.15;
            letter-spacing: -0.03em;
            margin-bottom: 1.25rem;
            max-width: 100%;
            text-align: left;
            background: linear-gradient(180deg, #ffffff 0%, #E2E8F0 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .main-hero-subtitle {
            font-size: 1.5rem;
            color: rgba(255, 255, 255, 0.85);
            font-weight: 400;
            max-width: 700px;
            margin: 0 0 2.2rem 0;
            line-height: 1.55;
            text-align: left;
        }

        .main-hero-actions {
            display: flex;
            align-items: center;
            justify-content: flex-start;
            gap: 1.2rem;
            margin-bottom: 0;
            width: 100%;
            flex-wrap: wrap;
        }

        .btn-main-dark-pill {
            background: #00052C;
            color: #ffffff;
            font-size: 1.05rem;
            font-weight: 700;
            padding: 0.9rem 2.2rem;
            border-radius: 9999px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            cursor: pointer;
            transition: all 0.25s;
            box-shadow: 0 10px 25px rgba(0, 5, 44, 0.4);
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.6rem;
        }

        .btn-main-dark-pill:hover {
            background: var(--main-blue);
            border-color: var(--main-blue);
            transform: translateY(-2px);
            box-shadow: 0 12px 30px rgba(14, 113, 235, 0.45);
        }

        .btn-main-light-pill {
            background: #ffffff;
            color: var(--main-navy);
            font-size: 1.05rem;
            font-weight: 700;
            padding: 0.9rem 2.2rem;
            border-radius: 9999px;
            border: none;
            cursor: pointer;
            transition: all 0.25s;
            box-shadow: 0 10px 25px rgba(255, 255, 255, 0.15);
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.6rem;
        }

        .btn-main-light-pill:hover {
            background: #f1f5f9;
            transform: translateY(-2px);
            box-shadow: 0 12px 30px rgba(255, 255, 255, 0.25);
        }

        /* Carousel Product Strip */
        .main-product-strip {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.75rem;
            overflow-x: auto;
            padding: 0.5rem;
            margin-bottom: 3rem;
            scrollbar-width: none;
        }

        .main-product-strip::-webkit-scrollbar {
            display: none;
        }

        .main-product-pill {
            background: rgba(255, 255, 255, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.15);
            padding: 0.6rem 1.3rem;
            border-radius: 9999px;
            color: rgba(255, 255, 255, 0.9);
            font-size: 0.92rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 0.6rem;
            cursor: pointer;
            transition: all 0.2s;
            white-space: nowrap;
        }

        .main-product-pill:hover, .main-product-pill.active {
            background: rgba(255, 255, 255, 0.22);
            color: #ffffff;
            border-color: rgba(255, 255, 255, 0.4);
            transform: translateY(-1px);
        }

        /* Interactive Simulated main Meeting Showcase Frame */
        .main-preview-window {
            width: 100%;
            max-width: 100%;
            margin: 0 0 20px 0;
            background: #0d1527;
            border-radius: 1.25rem;
            border: 1px solid rgba(255, 255, 255, 0.18);
            box-shadow: 0 30px 60px rgba(0, 5, 44, 0.6);
            overflow: hidden;
            text-align: left;
            position: relative;
        }

        .main-window-header {
            background: #080d19;
            padding: 0.75rem 1.2rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
        }

        .main-window-dots {
            display: flex;
            align-items: center;
            gap: 0.45rem;
        }

        .main-dot {
            width: 11px;
            height: 11px;
            border-radius: 50%;
        }

        .main-dot-red { background: #ff5f56; }
        .main-dot-yellow { background: #ffbd2e; }
        .main-dot-green { background: #27c93f; }

        .main-window-title {
            color: rgba(255, 255, 255, 0.75);
            font-size: 0.85rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .main-video-grid-preview {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 0.75rem;
            padding: 0.75rem;
            background: #090e1c;
            min-height: 380px;
            height: 600px;
            position: relative;
        }

        .main-video-tile {
            background: #151d30;
            border-radius: 0.85rem;
            position: relative;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 2px solid transparent;
            transition: all 0.3s;
            height: 100%;
        }

        .main-video-tile.speaking {
            border-color: #10B981;
            box-shadow: 0 0 20px rgba(16, 185, 129, 0.3);
        }

        .main-tile-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center 20%;
        }

        .main-participant-badge {
            position: absolute;
            bottom: 0.75rem;
            left: 0.75rem;
            background: rgba(0, 5, 44, 0.75);
            backdrop-filter: blur(8px);
            color: #ffffff;
            font-size: 0.8rem;
            font-weight: 600;
            padding: 0.35rem 0.75rem;
            border-radius: 9999px;
            display: flex;
            align-items: center;
            gap: 0.4rem;
        }

        .main-live-transcript-badge {
            position: absolute;
            top: 1.5rem;
            left: 50%;
            transform: translateX(-50%);
            background: rgba(14, 113, 235, 0.95);
            color: #ffffff;
            font-size: 0.85rem;
            font-weight: 600;
            padding: 0.5rem 1.25rem;
            border-radius: 9999px;
            box-shadow: 0 8px 24px rgba(14, 113, 235, 0.5);
            display: flex;
            align-items: center;
            gap: 0.6rem;
            z-index: 10;
            animation: pulseGlow 2s infinite;
        }

        @keyframes pulseGlow {
            0%, 100% { opacity: 0.95; transform: translateX(-50%) scale(1); }
            50% { opacity: 1; transform: translateX(-50%) scale(1.02); }
        }

        .main-floating-reactions {
            position: absolute;
            right: 2rem;
            bottom: 4.5rem;
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
            z-index: 10;
        }

        .main-reaction-bubble {
            background: rgba(255, 255, 255, 0.95);
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            animation: bounceUp 1.5s ease-in-out infinite alternate;
        }

        @keyframes bounceUp {
            from { transform: translateY(0); }
            to { transform: translateY(-8px); }
        }

        .main-dock-controls {
            background: #080d19;
            padding: 0.85rem 1.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 1.2rem;
            border-top: 1px solid rgba(255, 255, 255, 0.08);
        }

        .main-dock-btn {
            background: rgba(255, 255, 255, 0.1);
            color: #ffffff;
            border: none;
            width: 42px;
            height: 42px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.1rem;
            cursor: pointer;
            transition: all 0.2s;
        }

        .main-dock-btn:hover {
            background: rgba(255, 255, 255, 0.25);
        }

        .main-dock-btn.end-call {
            background: #EF4444;
            color: #ffffff;
        }

        .main-dock-btn.end-call:hover {
            background: #DC2626;
        }

        /* AI Note Taker & Companion Spotlight Section */
        .main-ai-section {
            padding: 6rem 2rem;
            background: var(--bg-secondary);
        }

        .main-section-container {
            max-width: 1240px;
            margin: 0 auto;
        }

        .main-section-header {
            text-align: center;
            margin-bottom: 1.5rem;
        }

        .main-section-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            background: var(--main-blue-light);
            color: var(--main-blue);
            padding: 0.4rem 1rem;
            border-radius: 9999px;
            font-size: 0.85rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.04em;
        }

        .main-section-title {
            font-size: 2.75rem;
            font-weight: 800;
            color: var(--main-text-dark);
            letter-spacing: -0.02em;
            margin-bottom: 1rem;
        }

        .main-section-subtitle {
            font-size: 1.2rem;
            color: var(--main-text-muted);
            max-width: 680px;
            margin: 0 auto;
            line-height: 1.6;
        }

        .main-ai-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 3rem;
            align-items: center;
        }

        .main-ai-card {
            background: #ffffff;
            border-radius: 1.5rem;
            padding: 2.5rem;
            box-shadow: var(--shadow-md);
            border: 1px solid var(--border-color);
        }

        .main-ai-card-title {
            font-size: 1.8rem;
            font-weight: 800;
            color: var(--main-text-dark);
            margin-bottom: 1rem;
        }

        .main-ai-card-desc {
            color: var(--main-text-muted);
            font-size: 1.05rem;
            line-height: 1.65;
            margin-bottom: 1.8rem;
        }

        .main-ai-feature-list {
            list-style: none;
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .main-ai-feature-item {
            display: flex;
            align-items: flex-start;
            gap: 0.85rem;
            font-size: 1rem;
            font-weight: 600;
            color: var(--main-text-dark);
        }

        .main-ai-feature-icon {
            width: 28px;
            height: 28px;
            border-radius: 50%;
            background: #D1E7FF;
            color: var(--main-blue);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.85rem;
            flex-shrink: 0;
            margin-top: 0.1rem;
        }

        /* Gartner & Leader Cards Grid */
        .main-leader-section {
            padding: 2rem 2rem;
            background: #ffffff;
        }

        .main-leader-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 2rem;
        }

        .main-leader-card {
            background: linear-gradient(180deg, #0B194C 0%, #0E71EB 100%);
            border-radius: 1.5rem;
            padding: 2.5rem 2rem;
            color: #ffffff;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            min-height: 380px;
            box-shadow: var(--shadow-md);
            position: relative;
            overflow: hidden;
            transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .main-leader-card:hover {
            transform: translateY(-6px);
            box-shadow: var(--shadow-lg);
        }

        .main-leader-badge {
            font-size: 0.85rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: rgba(255, 255, 255, 0.8);
            margin-bottom: 1.5rem;
        }

        .main-leader-title {
            font-size: 1.6rem;
            font-weight: 800;
            line-height: 1.35;
            margin-bottom: 1rem;
        }

        .main-leader-desc {
            font-size: 0.95rem;
            color: rgba(255, 255, 255, 0.85);
            line-height: 1.5;
            margin-bottom: 2rem;
        }

        /* Dynamic CMS Sections Styling */
        .main-cms-section {
            padding: 5.5rem 2rem;
            border-bottom: 1px solid var(--border-color);
        }

        .main-cms-section:nth-child(even) {
            background: var(--bg-secondary);
        }

        /* Stats Bar */
        .main-stats-bar {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 2rem;
            background: #ffffff;
            border-radius: 1.25rem;
            padding: 2rem 3rem;
            box-shadow: var(--shadow-md);
            border: 1px solid var(--border-color);
            margin-top: 3rem;
            text-align: center;
        }

        .main-stat-number {
            font-size: 2.5rem;
            font-weight: 800;
            color: var(--main-blue);
            letter-spacing: -0.02em;
            margin-bottom: 0.3rem;
        }

        .main-stat-label {
            font-size: 0.95rem;
            font-weight: 600;
            color: var(--main-text-muted);
        }

        /* Grid Containers for Services & Media */
        .main-grid-3 {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 2rem;
            margin-top: 2.5rem;
        }

        .main-card-item {
            background: #ffffff;
            border-radius: 1.25rem;
            padding: 2.25rem 2rem;
            border: 1px solid var(--border-color);
            box-shadow: var(--shadow-sm);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            display: flex;
            flex-direction: column;
            align-items: flex-start;
        }

        .main-card-item:hover {
            transform: translateY(-6px);
            box-shadow: 0 20px 45px rgba(14, 113, 235, 0.12);
            border-color: rgba(14, 113, 235, 0.3);
        }

        .main-card-icon {
            width: 56px;
            height: 56px;
            border-radius: 1rem;
            background: #EBF4FF;
            color: #0E71EB;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            margin-bottom: 1.5rem;
        }

        .main-card-title {
            font-size: 1.3rem;
            font-weight: 800;
            color: #0B194C;
            margin-bottom: 0.75rem;
            line-height: 1.3;
        }

        .main-card-text {
            font-size: 0.98rem;
            color: #64748B;
            line-height: 1.6;
        }

        .main-media-card {
            background: #ffffff;
            border-radius: 1.25rem;
            overflow: hidden;
            border: 1px solid var(--border-color);
            box-shadow: var(--shadow-sm);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            display: flex;
            flex-direction: column;
        }

        .main-media-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 20px 45px rgba(14, 113, 235, 0.12);
            border-color: rgba(14, 113, 235, 0.3);
        }

        .main-media-img-wrapper {
            width: 100%;
            height: 200px;
            overflow: hidden;
            background: #0f172a;
        }

        .main-media-card-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.4s ease;
        }

        .main-media-card:hover .main-media-card-img {
            transform: scale(1.05);
        }

        .main-media-card-body {
            padding: 1.75rem;
            display: flex;
            flex-direction: column;
            flex: 1;
        }

        .main-media-tag {
            font-size: 0.8rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.04em;
            color: #0E71EB;
            margin-bottom: 0.6rem;
        }

        .main-media-card-title {
            font-size: 1.2rem;
            font-weight: 800;
            color: #0B194C;
            margin-bottom: 1rem;
            line-height: 1.35;
        }

        .main-media-link {
            color: #0E71EB;
            font-weight: 700;
            font-size: 0.9rem;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            margin-top: auto;
            transition: gap 0.2s;
        }

        .main-media-link:hover {
            gap: 0.7rem;
            color: #0056C6;
        }

        /* Contact Section Card */
        .main-contact-card {
            background: #ffffff;
            border-radius: 1.5rem;
            padding: 3rem;
            box-shadow: var(--shadow-md);
            border: 1px solid var(--border-color);
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 3rem;
        }

        /* Pre-Footer Banner */
        .main-prefooter-banner {
            background: linear-gradient(135deg, #0B194C 0%, #00052C 100%);
            color: #ffffff;
            padding: 5rem 2rem;
            text-align: center;
        }

        .main-prefooter-title {
            font-size: 3rem;
            font-weight: 800;
            letter-spacing: -0.02em;
            margin-bottom: 1.2rem;
        }

        /* Multi-Column main Footer */
        .main-footer {
            background: #080D19;
            color: rgba(255, 255, 255, 0.7);
            padding: 5rem 2.5rem 2rem;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }

        .main-footer-grid {
            max-width: 1240px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: 2fr repeat(4, 1fr);
            gap: 3rem;
            margin-bottom: 4rem;
        }

        .main-footer-col-title {
            color: #ffffff;
            font-size: 0.95rem;
            font-weight: 700;
            margin-bottom: 1.25rem;
            text-transform: uppercase;
            letter-spacing: 0.04em;
        }

        .main-footer-list {
            list-style: none;
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
        }

        .main-footer-link {
            color: rgba(255, 255, 255, 0.65);
            text-decoration: none;
            font-size: 0.9rem;
            transition: color 0.2s;
        }

        .main-footer-link:hover {
            color: #ffffff;
        }

        .main-footer-bottom {
            max-width: 1240px;
            margin: 0 auto;
            padding-top: 2rem;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            display: flex;
            align-items: center;
            justify-content: space-between;
            font-size: 0.85rem;
        }

        /* Quick Meeting Launch Box */
        .meeting-launch-box {
            background: #ffffff;
            border-radius: 1.25rem;
            padding: 2.5rem;
            box-shadow: var(--shadow-lg);
            border: 1px solid var(--border-color);
            max-width: 520px;
            margin: 0 auto;
        }

        .launch-tab-bar {
            display: flex;
            background: #F1F5F9;
            padding: 0.35rem;
            border-radius: 0.75rem;
            margin-bottom: 1.5rem;
        }

        .launch-tab {
            flex: 1;
            padding: 0.6rem;
            text-align: center;
            font-weight: 700;
            font-size: 0.9rem;
            color: var(--main-text-muted);
            border-radius: 0.5rem;
            cursor: pointer;
            transition: all 0.2s;
        }

        .launch-tab.active {
            background: #ffffff;
            color: var(--main-blue);
            box-shadow: var(--shadow-sm);
        }

        .g-input-group {
            position: relative;
            margin-bottom: 1.2rem;
        }

        .g-input {
            width: 100%;
            padding: 0.85rem 1.1rem;
            padding-left: 2.8rem;
            border-radius: 0.75rem;
            border: 1.5px solid var(--border-color);
            font-size: 0.95rem;
            outline: none;
            transition: all 0.2s;
        }

        .g-input:focus {
            border-color: var(--main-blue);
            box-shadow: 0 0 0 4px var(--main-blue-light);
        }

        .g-input-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--main-text-muted);
            font-size: 1rem;
        }

        /* Portal Navigation Tabs Bar */
        .portal-nav-bar {
            background: var(--main-navy);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            padding: 0.75rem 2.5rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .portal-user-info {
            color: white;
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        @media (max-width: 992px) {
            .main-header {
                padding: 0.85rem 1.25rem;
            }
            .main-mobile-toggle {
                display: flex;
            }
            .main-nav-menu {
                display: none;
                position: absolute;
                top: 100%;
                left: 0;
                right: 0;
                background: #0A1338;
                border-bottom: 2px solid var(--main-blue);
                flex-direction: column;
                padding: 1.25rem 1.5rem;
                gap: 0.85rem;
                box-shadow: 0 20px 40px rgba(0, 5, 44, 0.8);
                z-index: 1100;
                width: 100%;
            }
            .main-nav-menu.mobile-active {
                display: flex !important;
                animation: slideDownMobile 0.25s ease-out;
            }
            .main-nav-link {
                width: 100%;
                justify-content: flex-start;
                padding: 0.75rem 1.25rem;
                font-size: 1rem;
            }
            .g-time-display, .main-lang-selector {
                display: none;
            }
            .main-hero-split-grid {
                grid-template-columns: 1fr;
                gap: 2.5rem;
            }
            .main-hero-content-left {
                align-items: center;
                text-align: center;
            }
            .main-hero-title {
                font-size: 2.5rem;
                text-align: center;
            }
            .main-hero-subtitle {
                text-align: center;
            }
            .main-hero-actions {
                justify-content: center;
            }
        }

        @keyframes slideDownMobile {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @media (max-width: 768px) {
            .main-hero-section {
                padding: 3rem 1rem 3.5rem;
            }
            .main-hero-title {
                font-size: 2.1rem;
                line-height: 1.2;
            }
            .main-hero-subtitle {
                font-size: 1.05rem;
                margin-bottom: 1.8rem;
            }
            .main-hero-actions {
                flex-direction: column;
                width: 100%;
                gap: 0.75rem;
            }
            .btn-main-dark-pill, .btn-main-light-pill {
                width: 100%;
                justify-content: center;
            }
            .main-product-strip {
                justify-content: flex-start;
            }
            .main-video-grid-preview {
                grid-template-columns: 1fr;
                min-height: unset;
                height: auto;
            }
            .main-video-tile {
                height: 200px;
            }
            .main-dock-controls {
                flex-wrap: wrap;
                justify-content: center;
                gap: 0.5rem;
                padding: 0.6rem;
            }
            .main-stats-bar {
                flex-direction: column;
                gap: 1.5rem;
                padding: 1.5rem 1rem;
            }
            .main-grid-3, .main-ai-grid, .main-leader-grid, .main-contact-card {
                grid-template-columns: 1fr;
            }
            .main-footer-grid {
                grid-template-columns: 1fr;
            }
            .btn-main-outline, .btn-main-primary {
                padding: 0.5rem 0.9rem;
                font-size: 0.82rem;
            }
        }
    </style>
</head>
<body>

    <!-- main-Style Enterprise Header Navigation Bar -->
    <header class="main-header">
        <div class="main-header-left">
            <a href="#" class="main-brand" onclick="switchPortalView('landing')">
                <div class="main-brand-icon" id="brandLogoIcon">
                    <i class="fa-solid fa-video"></i>
                </div>
                <span id="brandAppNameText">MeetingPulse</span>
            </a>

            <!-- High-Visibility Bright White Navigation Menu Links -->
            
        </div>

        <!-- Utility Action Bar (Right) -->
        <div class="main-header-right" id="gHeaderActions">

        <ul class="main-nav-menu" id="mainHeaderNavLinks">
                <li class="main-nav-item">
                    <a href="#aboutSection" class="main-nav-link" onclick="closeMobileHeaderMenu()"><i class="fa-solid fa-circle-info"></i> About</a>
                </li>
                <li class="main-nav-item">
                    <a href="#servicesSection" class="main-nav-link" onclick="closeMobileHeaderMenu()"><i class="fa-solid fa-cubes-stacked"></i> Services</a>
                </li>
                <li class="main-nav-item">
                    <a href="#mediaSection" class="main-nav-link" onclick="closeMobileHeaderMenu()"><i class="fa-solid fa-newspaper"></i> Media</a>
                </li>
                <li class="main-nav-item">
                    <a href="#contactSection" class="main-nav-link" onclick="closeMobileHeaderMenu()"><i class="fa-solid fa-headset"></i> Contact</a>
                </li>
               
            </ul>
            <!-- Login / Account Action State -->
            <button class="btn-main-outline" id="authActionBtn" onclick="openAuthModal('signin')">Sign In</button>
            <button class="btn-main-primary" onclick="openAuthModal('signup')">Sign Up Free</button>

            <!-- Mobile Hamburger Toggle Button -->
            <button class="main-mobile-toggle" id="mainMobileToggleBtn" onclick="toggleMobileHeaderMenu()" aria-label="Toggle Navigation Menu">
                <i class="fa-solid fa-bars"></i>
            </button>
        </div>
    </header>

    <!-- MAIN APP WRAPPER -->
    <div id="appContainer">

        <!-- LANDING PAGE VIEW (main-Inspired Look & Feel) -->
        <div id="landingViewContainer" class="portal-view-section">

            <!-- Hero Section Split 2-Column Layout -->
            <section class="main-hero-section">
                <div class="main-hero-bg-glow"></div>
                <div class="main-hero-container">
                    <div class="main-hero-split-grid">
                        
                        <!-- Left Column: Hero Title, Tagline and Action Buttons -->
                        <div class="main-hero-content-left">
                            <div class="main-hero-badge">
                                <i class="fa-solid fa-sparkles" style="color: #60A5FA;"></i> AI-POWERED WORK PLATFORM
                            </div>

                            <h1 class="main-hero-title">Find out what's possible<br> when work connects</h1>
                            
                            <p class="main-hero-subtitle" id="landingHeroTagline">
                                Bridge the gap between talking and doing with our enterprise video conferencing and collaboration platform.
                            </p>

                            <div class="main-hero-actions">
                                <button class="btn-main-dark-pill" onclick="openInstantMeetingModal()">
                                    <i class="fa-solid fa-video"></i> Start Instant Meeting
                                </button>
                                <button class="btn-main-light-pill" onclick="openScheduleMeetingModal()">
                                    <i class="fa-solid fa-calendar-plus"></i> Schedule Meeting
                                </button>
                            </div>
                        </div>

                        <!-- Right Column: Interactive Simulated Video Showcase Frame -->
                        <div class="main-preview-window">
                            <div class="main-window-header">
                                <div class="main-window-dots">
                                    <span class="main-dot main-dot-red"></span>
                                    <span class="main-dot main-dot-yellow"></span>
                                    <span class="main-dot main-dot-green"></span>
                                </div>
                                <div class="main-window-title">
                                    <i class="fa-solid fa-lock" style="color: #10B981;"></i> MeetingPulse HD Room — Q3 Enterprise Product Sync
                                </div>
                                <div style="font-size: 0.8rem; color: rgba(255,255,255,0.6);"><i class="fa-solid fa-users"></i> 4 Participants</div>
                            </div>

                            <div class="main-video-grid-preview">
                                <div class="main-live-transcript-badge">
                                    <i class="fa-solid fa-sparkles"></i> AI Note Taker: "Action item assigned to engineering team for Q3 rollout"
                                </div>

                                <div class="main-video-tile speaking">
                                    <img src="https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?auto=format&fit=crop&w=600&q=80" class="main-tile-img" alt="Speaker 1">
                                    <div class="main-participant-badge"><i class="fa-solid fa-microphone" style="color: #10B981;"></i> Sydney Ren (Host)</div>
                                </div>

                                <div class="main-video-tile">
                                    <img src="https://images.unsplash.com/photo-1560250097-0b93528c311a?auto=format&fit=crop&w=600&q=80" class="main-tile-img" alt="Speaker 2">
                                    <div class="main-participant-badge"><i class="fa-solid fa-microphone" style="color: #10B981;"></i> Brian Ayers</div>
                                </div>

                                <div class="main-video-tile">
                                    <img src="https://images.unsplash.com/photo-1580489944761-15a19d654956?auto=format&fit=crop&w=600&q=80" class="main-tile-img" alt="Speaker 3">
                                    <div class="main-participant-badge"><i class="fa-solid fa-microphone" style="color: #10B981;"></i> Jane Harper</div>
                                </div>

                                <div class="main-video-tile">
                                    <img src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=600&q=80" class="main-tile-img" alt="Speaker 4">
                                    <div class="main-participant-badge"><i class="fa-solid fa-microphone-slash" style="color: #EF4444;"></i> Alex Vance</div>
                                </div>

                                <div class="main-floating-reactions">
                                    <div class="main-reaction-bubble">👍</div>
                                    <div class="main-reaction-bubble">❤️</div>
                                    <div class="main-reaction-bubble">👏</div>
                                </div>
                            </div>

                            <div class="main-dock-controls">
                                <button class="main-dock-btn" title="Microphone"><i class="fa-solid fa-microphone"></i></button>
                                <button class="main-dock-btn" title="Camera"><i class="fa-solid fa-video"></i></button>
                                <button class="main-dock-btn" title="Share Screen" style="color: #60A5FA;"><i class="fa-solid fa-desktop"></i></button>
                                <button class="main-dock-btn" title="Security"><i class="fa-solid fa-shield-halved"></i></button>
                                <button class="main-dock-btn" title="Reactions"><i class="fa-solid fa-face-smile"></i></button>
                                <button class="main-dock-btn end-call" title="End Call"><i class="fa-solid fa-phone-slash"></i></button>
                            </div>
                        </div>

                    </div>
                </div>
            </section>

            <!-- main Gartner Leadership Showcase Grid -->
            <section class="main-leader-section" id="leaderSection">
                <div class="main-section-container">
                    <div class="main-section-header">
                        <div class="main-section-badge"><i class="fa-solid fa-award"></i> Industry Recognition</div>
                        <h2 class="main-section-title">Recognized leader in enterprise video conferencing</h2>
                    </div>

                    <div class="main-leader-grid">
                        <div class="main-leader-card">
                            <div>
                                <div class="main-leader-badge">GARTNER® MAGIC QUADRANT™</div>
                                <h3 class="main-leader-title">Leader for 7th Consecutive Year</h3>
                                <p class="main-leader-desc">Recognized for completeness of vision and ability to execute enterprise video solutions.</p>
                            </div>
                            <button class="btn-main-light-pill" style="align-self: flex-start;" onclick="openAuthModal('signup')">Read Report <i class="fa-solid fa-arrow-up-right-from-square"></i></button>
                        </div>

                        <div class="main-leader-card" style="background: linear-gradient(180deg, #0A1338 0%, #152A72 100%);">
                            <div>
                                <div class="main-leader-badge">VOICE OF THE CUSTOMER</div>
                                <h3 class="main-leader-title">Top Rated Video Collaboration</h3>
                                <p class="main-leader-desc">Voted #1 for reliability, HD audio-video quality, and ease of deployment.</p>
                            </div>
                            <button class="btn-main-light-pill" style="align-self: flex-start;" onclick="openAuthModal('signup')">Explore Insights <i class="fa-solid fa-arrow-up-right-from-square"></i></button>
                        </div>

                        <div class="main-leader-card" style="background: linear-gradient(180deg, #152A72 0%, #0E71EB 100%);">
                            <div>
                                <div class="main-leader-badge">FROST RADAR™ 2026</div>
                                <h3 class="main-leader-title">Visionary Leader in AI Meetings</h3>
                                <p class="main-leader-desc">Awarded top honors for AI meeting assistant innovations and WebRTC security.</p>
                            </div>
                            <button class="btn-main-light-pill" style="align-self: flex-start;" onclick="openAuthModal('signup')">View Radar <i class="fa-solid fa-arrow-up-right-from-square"></i></button>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Dynamic About Us Section -->
            <section class="main-cms-section" id="aboutSection">
                <div class="main-section-container">
                    <div class="main-section-header">
                        <div class="main-section-badge"><i class="fa-solid fa-circle-info"></i> About Us</div>
                        <h2 class="main-section-title" id="aboutTitleText">Connecting teams everywhere seamlessly</h2>
                    </div>

                    <div style="max-width: 840px; margin: 0 auto; text-align: center;">
                        <p style="font-size: 1.25rem; color: var(--main-text-muted); line-height: 1.7; margin-bottom: 2rem;" id="aboutBodyText">
                            MeetingPulse provides enterprise-grade video conferencing, instant screen sharing, and AI companion note-taking designed for businesses, education, and modern hybrid teams worldwide.
                        </p>
                    </div>

                    <!-- Enterprise Stats Bar -->
                    <div class="main-stats-bar">
                        <div>
                            <div class="main-stat-number">99.99%</div>
                            <div class="main-stat-label">Global Service Uptime</div>
                        </div>
                        <div>
                            <div class="main-stat-number">10M+</div>
                            <div class="main-stat-label">Streamed Minutes Daily</div>
                        </div>
                        <div>
                            <div class="main-stat-number">256-Bit</div>
                            <div class="main-stat-label">AES Encryption & Security</div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Dynamic Services Grid Section -->
            <section class="main-cms-section" id="servicesSection">
                <div class="main-section-container">
                    <div class="main-section-header">
                        <div class="main-section-badge"><i class="fa-solid fa-cubes-stacked"></i> Services</div>
                        <h2 class="main-section-title">Comprehensive Work Collaboration Suite</h2>
                        <p class="main-section-subtitle">Tailored video conferencing solutions built to scale from individuals to multi-tenant enterprises.</p>
                    </div>

                    <div class="main-grid-3" id="servicesGridContainer">
                        <div class="main-card-item">
                            <div class="main-card-icon"><i class="fa-solid fa-video"></i></div>
                            <h3 class="main-card-title">Ultra HD Video Conferencing</h3>
                            <p class="main-card-text">1080p WebRTC streaming powered by low-latency Go SFU engine with 0 packet loss.</p>
                        </div>
                        <div class="main-card-item">
                            <div class="main-card-icon"><i class="fa-solid fa-shield-halved"></i></div>
                            <h3 class="main-card-title">12-Step Access Control</h3>
                            <p class="main-card-text">Strict private email invitations and real-time host waiting room approval controls.</p>
                        </div>
                        <div class="main-card-item">
                            <div class="main-card-icon"><i class="fa-solid fa-desktop"></i></div>
                            <h3 class="main-card-title">4K Screen Sharing & Recording</h3>
                            <p class="main-card-text">High frame-rate display sharing with multi-participant canvas rendering.</p>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Dynamic Media & Press Section -->
            <section class="main-cms-section" id="mediaSection">
                <div class="main-section-container">
                    <div class="main-section-header">
                        <div class="main-section-badge"><i class="fa-solid fa-newspaper"></i> Media & Press</div>
                        <h2 class="main-section-title">MeetingPulse in the News</h2>
                    </div>

                    <div class="main-grid-3" id="mediaGridContainer">
                        <div class="main-media-card">
                            <div class="main-media-img-wrapper">
                                <img src="https://images.unsplash.com/photo-1516321318423-f06f85e504b3?w=500&q=80" alt="Media 1" class="main-media-card-img">
                            </div>
                            <div class="main-media-card-body">
                                <span class="main-media-tag">Press • Sep 2026</span>
                                <h3 class="main-media-card-title">TechCrunch Coverage: Enterprise SFU Breakthrough</h3>
                                <a href="#" class="main-media-link">Read Full Story <i class="fa-solid fa-arrow-right"></i></a>
                            </div>
                        </div>
                        <div class="main-media-card">
                            <div class="main-media-img-wrapper">
                                <img src="https://images.unsplash.com/photo-1551836022-d5d88e9218df?w=500&q=80" alt="Media 2" class="main-media-card-img">
                            </div>
                            <div class="main-media-card-body">
                                <span class="main-media-tag">Whitepaper • Aug 2026</span>
                                <h3 class="main-media-card-title">Global WebRTC Security & Access Control Report</h3>
                                <a href="#" class="main-media-link">Read Full Story <i class="fa-solid fa-arrow-right"></i></a>
                            </div>
                        </div>
                        <div class="main-media-card">
                            <div class="main-media-img-wrapper">
                                <img src="https://images.unsplash.com/photo-1451187580459-43490279c0fa?w=500&q=80" alt="Media 3" class="main-media-card-img">
                            </div>
                            <div class="main-media-card-body">
                                <span class="main-media-tag">News • Jul 2026</span>
                                <h3 class="main-media-card-title">MeetingPulse Announces Multi-Region Infrastructure</h3>
                                <a href="#" class="main-media-link">Read Full Story <i class="fa-solid fa-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Dynamic Contact Section -->
            <section class="main-cms-section" id="contactSection">
                <div class="main-section-container">
                    <div class="main-section-header">
                        <div class="main-section-badge"><i class="fa-solid fa-headset"></i> Contact Us</div>
                        <h2 class="main-section-title">Get in touch with our enterprise team</h2>
                    </div>

                    <div class="main-contact-card">
                        <div>
                            <h3 style="font-size: 1.6rem; font-weight: 800; margin-bottom: 1.25rem;">Contact Information</h3>
                            <div style="display: flex; flex-direction: column; gap: 1.25rem; color: var(--main-text-muted); font-size: 1rem;">
                                <div style="display: flex; align-items: center; gap: 0.85rem;">
                                    <div class="main-card-icon" style="width: 40px; height: 40px; margin: 0;"><i class="fa-solid fa-location-dot"></i></div>
                                    <span id="contactAddressText">Global Headquarters, Innovation Parkway, Tech District</span>
                                </div>
                                <div style="display: flex; align-items: center; gap: 0.85rem;">
                                    <div class="main-card-icon" style="width: 40px; height: 40px; margin: 0;"><i class="fa-solid fa-phone"></i></div>
                                    <span id="contactPhoneText">+1 (800) 555-MEET</span>
                                </div>
                                <div style="display: flex; align-items: center; gap: 0.85rem;">
                                    <div class="main-card-icon" style="width: 40px; height: 40px; margin: 0;"><i class="fa-solid fa-envelope"></i></div>
                                    <span id="contactEmailText">support@meetingpulse.com</span>
                                </div>
                            </div>

                            <div style="margin-top: 2rem;">
                                <h4 style="font-weight: 700; margin-bottom: 0.75rem;">Follow Us</h4>
                                <div style="display: flex; gap: 0.75rem;" id="contactSocialIconsContainer">
                                    <!-- Social Icons Rendered via JS -->
                                </div>
                            </div>
                        </div>

                        <div>
                            <form onsubmit="handleContactSubmit(event)" style="display: flex; flex-direction: column; gap: 1rem;">
                                <input type="text" class="g-input" placeholder="Your Full Name" required>
                                <input type="email" class="g-input" placeholder="Your Work Email" required>
                                <textarea class="g-input" rows="4" placeholder="How can we help your team?" required></textarea>
                                <button type="submit" class="btn-main-primary" style="justify-content: center; padding: 0.85rem;">Send Inquiry <i class="fa-solid fa-paper-plane"></i></button>
                            </form>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Pre-Footer Banner -->
            <section class="main-prefooter-banner">
                <div class="main-section-container">
                    <h2 class="main-prefooter-title">See what MeetingPulse can do for your business</h2>
                    <p style="font-size: 1.25rem; color: rgba(255,255,255,0.85); max-width: 640px; margin: 0 auto 2.5rem;">
                        Join millions of professionals connecting seamlessly every day.
                    </p>
                    <div style="display: flex; align-items: center; justify-content: center; gap: 1.25rem;">
                        <button class="btn-main-primary" style="padding: 0.9rem 2.2rem; font-size: 1.05rem;" onclick="openAuthModal('signup')">Get Started Today</button>
                        <button class="btn-main-outline" style="padding: 0.9rem 2.2rem; font-size: 1.05rem;" onclick="openAuthModal('signin')">Explore Plans</button>
                    </div>
                </div>
            </section>

            <!-- main Multi-Column Directory Footer -->
            <footer class="main-footer">
                <div class="main-footer-grid">
                    <div>
                        <a href="#" class="main-brand" style="margin-bottom: 1rem; display: inline-flex;">
                            <div class="main-brand-icon"><i class="fa-solid fa-video"></i></div>
                            <span id="footerAppNameText">MeetingPulse Enterprise</span>
                        </a>
                        <p style="font-size: 0.9rem; line-height: 1.6; margin-bottom: 1.5rem; max-width: 280px;">
                            AI-first enterprise video conferencing platform built for hybrid work, events, and global team collaboration.
                        </p>
                    </div>

                    <div>
                        <div class="main-footer-col-title">Products</div>
                        <ul class="main-footer-list">
                            <li><a href="#aboutSection" class="main-footer-link">HD Video Meetings</a></li>
                            <li><a href="#aiSection" class="main-footer-link">AI Companion</a></li>
                            <li><a href="#servicesSection" class="main-footer-link">Team Chat</a></li>
                            <li><a href="#servicesSection" class="main-footer-link">Webinars & Events</a></li>
                            <li><a href="#servicesSection" class="main-footer-link">Phone System</a></li>
                        </ul>
                    </div>

                    <div>
                        <div class="main-footer-col-title">Solutions</div>
                        <ul class="main-footer-list">
                            <li><a href="#servicesSection" class="main-footer-link">Enterprise Business</a></li>
                            <li><a href="#servicesSection" class="main-footer-link">Education & Schools</a></li>
                            <li><a href="#servicesSection" class="main-footer-link">Healthcare (HIPAA)</a></li>
                            <li><a href="#servicesSection" class="main-footer-link">Financial Services</a></li>
                        </ul>
                    </div>

                    <div>
                        <div class="main-footer-col-title">Resources</div>
                        <ul class="main-footer-list">
                            <li><a href="#mediaSection" class="main-footer-link">Blog & News</a></li>
                            <li><a href="#mediaSection" class="main-footer-link">Customer Stories</a></li>
                            <li><a href="#contactSection" class="main-footer-link">Developer API & SDK</a></li>
                            <li><a href="#contactSection" class="main-footer-link">Security & Trust Center</a></li>
                        </ul>
                    </div>

                    <div>
                        <div class="main-footer-col-title">Company</div>
                        <ul class="main-footer-list">
                            <li><a href="#aboutSection" class="main-footer-link">About Us</a></li>
                            <li><a href="#contactSection" class="main-footer-link">Careers</a></li>
                            <li><a href="#mediaSection" class="main-footer-link">Press & Media</a></li>
                            <li><a href="#contactSection" class="main-footer-link">Contact Support</a></li>
                        </ul>
                    </div>
                </div>

                <div class="main-footer-bottom">
                    <div>
                        © 2026 MeetingPulse Communications, Inc. All rights reserved.
                    </div>
                    <div style="display: flex; gap: 1.5rem;">
                        <a href="#" class="main-footer-link">Privacy Policy</a>
                        <a href="#" class="main-footer-link">Terms of Service</a>
                        <a href="#" class="main-footer-link">Legal Policies</a>
                        <a href="#" class="main-footer-link">Cookie Preferences</a>
                    </div>
                </div>
            </footer>
        </div>

        <!-- PORTAL DASHBOARD VIEWS -->
        <div id="superAdminPanelView" style="display: none; padding: 2rem;">
            <!-- Super Admin Dashboard Container -->
        </div>

        <div id="adminPanelView" style="display: none; padding: 2rem;">
            <!-- System Admin Dashboard Container -->
        </div>

        <div id="corporatePanelView" style="display: none; padding: 2rem;">
            <!-- Corporate Dashboard Container -->
        </div>

        <div id="hostPanelView" style="display: none; padding: 2rem;">
            <!-- Free / Host Dashboard Container -->
        </div>
    </div>


    <style>
        :root {
            --google-blue: #1a73e8;
            --google-blue-hover: #1557b0;
            --google-blue-bg: #e8f0fe;
            --google-green: #188038;
            --google-red: #d93025;
            --bg-main: #ffffff;
            --bg-secondary: #f8fafc;
            --text-primary: #0f172a;
            --text-secondary: #475569;
            --border-color: #e2e8f0;
            --shadow-sm: 0 1px 3px 0 rgba(15, 23, 42, 0.08);
            --shadow-md: 0 4px 14px -2px rgba(15, 23, 42, 0.12);
            --shadow-lg: 0 20px 30px -10px rgba(15, 23, 42, 0.15);
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Outfit', 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            scroll-behavior: smooth;
        }

        body {
            background-color: var(--bg-main);
            color: var(--text-primary);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            overflow-x: hidden;
        }

        /* Standard High-Contrast Header Navigation */
        .g-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.85rem 3rem;
            background: #ffffff;
            border-bottom: 1px solid var(--border-color);
            box-shadow: 0 4px 20px rgba(15, 23, 42, 0.05);
            position: sticky;
            top: 0;
            z-index: 50;
        }

        .g-brand {
            display: flex;
            align-items: center;
            gap: 0.85rem;
            text-decoration: none;
            font-size: 1.4rem;
            font-weight: 800;
            color: var(--text-primary);
            letter-spacing: -0.02em;
        }

        .g-brand-icon {
            width: 44px;
            height: 44px;
            background: linear-gradient(135deg, var(--google-blue), #4f46e5);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.3rem;
            box-shadow: 0 4px 14px rgba(26, 115, 232, 0.35);
            overflow: hidden;
        }

        .g-brand-icon img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        /* High-Visibility Header Navigation Container */
        .nav-pill-container {
            display: flex;
            align-items: center;
            gap: 0.35rem;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 9999px;
            padding: 0.3rem 0.4rem;
            box-shadow: inset 0 1px 2px rgba(0,0,0,0.03);
        }

        .nav-pill-link {
            text-decoration: none;
            color: #334155;
            font-weight: 600;
            font-size: 0.95rem;
            padding: 0.5rem 1.1rem;
            border-radius: 9999px;
            display: inline-flex;
            align-items: center;
            gap: 0.55rem;
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
            cursor: pointer;
        }

        .nav-pill-link:hover, .nav-pill-link.active {
            background: #ffffff;
            color: var(--google-blue);
            box-shadow: 0 2px 8px rgba(15, 23, 42, 0.08);
            transform: translateY(-1px);
        }

        .g-header-actions {
            display: flex;
            align-items: center;
            gap: 1rem;
            position: relative;
        }

        .g-time-display {
            font-size: 0.9rem;
            color: var(--text-secondary);
            font-weight: 600;
            background: #f1f5f9;
            padding: 0.4rem 0.85rem;
            border-radius: 9999px;
            border: 1px solid #e2e8f0;
        }

        /* Profile Dropdown */
        .user-profile-btn {
            display: flex;
            align-items: center;
            gap: 0.6rem;
            padding: 0.4rem 0.9rem;
            border-radius: 9999px;
            background: #ffffff;
            border: 1px solid var(--border-color);
            box-shadow: var(--shadow-sm);
            cursor: pointer;
            transition: all 0.2s;
        }

        .user-profile-btn:hover {
            background: #f8fafc;
            border-color: var(--google-blue);
        }

        .user-avatar-img {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            object-fit: cover;
            background: var(--google-blue);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 0.9rem;
        }

        .profile-dropdown-menu {
            display: none;
            position: absolute;
            top: 120%;
            right: 0;
            width: 320px;
            background: #ffffff;
            border-radius: 1rem;
            box-shadow: var(--shadow-lg);
            border: 1px solid var(--border-color);
            padding: 1rem;
            z-index: 100;
        }

        .profile-dropdown-menu.active {
            display: block;
            animation: fadeIn 0.2s ease-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-8px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .dropdown-user-header {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding-bottom: 0.85rem;
            margin-bottom: 0.85rem;
            border-bottom: 1px solid #f1f3f4;
        }

        .dropdown-item-btn {
            width: 100%;
            padding: 0.65rem 0.85rem;
            border: none;
            background: transparent;
            text-align: left;
            border-radius: 0.5rem;
            font-size: 0.9rem;
            font-weight: 500;
            color: var(--text-primary);
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            transition: background 0.15s;
        }

        .dropdown-item-btn:hover {
            background: #f8fafc;
            color: var(--google-blue);
        }

        .dropdown-item-btn.danger:hover {
            background: #fce8e6;
            color: var(--google-red);
        }

        /* Buttons */
        .btn-google {
            background: linear-gradient(135deg, var(--google-blue), #2563eb);
            color: #ffffff;
            border: none;
            padding: 0.75rem 1.6rem;
            border-radius: 0.6rem;
            font-weight: 700;
            font-size: 0.95rem;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 0.65rem;
            transition: all 0.25s ease;
            text-decoration: none;
            box-shadow: 0 4px 14px rgba(26, 115, 232, 0.35);
        }

        .btn-google:hover {
            box-shadow: 0 8px 20px rgba(26, 115, 232, 0.45);
            transform: translateY(-2px);
        }

        .btn-google-outline {
            background: #ffffff;
            color: var(--google-blue);
            border: 1.5px solid var(--border-color);
            padding: 0.75rem 1.6rem;
            border-radius: 0.6rem;
            font-weight: 700;
            font-size: 0.95rem;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 0.65rem;
            transition: all 0.25s ease;
            box-shadow: var(--shadow-sm);
        }

        .btn-google-outline:hover {
            background-color: var(--google-blue-bg);
            border-color: var(--google-blue);
            transform: translateY(-2px);
        }

        .btn-google-secondary {
            background-color: #f1f5f9;
            color: var(--text-primary);
            border: 1px solid #e2e8f0;
            padding: 0.75rem 1.25rem;
            border-radius: 0.6rem;
            font-weight: 600;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-google-secondary:hover {
            background-color: #e2e8f0;
        }

        /* Hero Section Styling */
        .hero-section {
            max-width: 1280px;
            margin: 0 auto;
            padding: 4.5rem 2.5rem 4rem 2.5rem;
            display: grid;
            grid-template-columns: 1.15fr 0.85fr;
            gap: 4rem;
            align-items: center;
        }

        @media (max-width: 960px) {
            .hero-section {
                grid-template-columns: 1fr;
                padding: 3rem 1.5rem;
                gap: 2.5rem;
            }
        }

        .hero-top-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            background: var(--google-blue-bg);
            color: var(--google-blue);
            font-size: 0.8rem;
            font-weight: 800;
            padding: 0.4rem 0.95rem;
            border-radius: 9999px;
            border: 1px solid rgba(26, 115, 232, 0.25);
            letter-spacing: 0.05em;
            margin-bottom: 1.25rem;
            box-shadow: 0 2px 8px rgba(26, 115, 232, 0.12);
        }

        .hero-top-badge-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: #10b981;
            box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.2);
        }

        .hero-headline {
            font-size: 3.4rem;
            line-height: 1.12;
            font-weight: 800;
            letter-spacing: -0.03em;
            color: #0f172a;
            margin-bottom: 1.25rem;
        }

        .hero-subheadline {
            font-size: 1.2rem;
            line-height: 1.65;
            color: var(--text-secondary);
            margin-bottom: 2.5rem;
        }

        .action-box {
            display: flex;
            align-items: center;
            gap: 1rem;
            flex-wrap: wrap;
            margin-bottom: 2rem;
        }

        .input-code-wrapper {
            display: flex;
            align-items: center;
            background: #ffffff;
            border: 1.5px solid var(--border-color);
            border-radius: 0.6rem;
            padding: 0.35rem 0.6rem 0.35rem 1.1rem;
            flex: 1;
            min-width: 270px;
            box-shadow: var(--shadow-sm);
            transition: all 0.2s;
        }

        .input-code-wrapper:focus-within {
            border-color: var(--google-blue);
            box-shadow: 0 0 0 3px rgba(26, 115, 232, 0.2);
        }

        .input-code-wrapper i {
            color: var(--text-secondary);
            margin-right: 0.75rem;
            font-size: 1.15rem;
        }

        .input-code-wrapper input {
            border: none;
            outline: none;
            width: 100%;
            font-size: 1rem;
            font-weight: 500;
            color: var(--text-primary);
            background: transparent;
            padding: 0.5rem 0;
        }

        .input-code-wrapper .btn-join {
            background: transparent;
            border: none;
            color: var(--google-blue);
            font-weight: 700;
            font-size: 0.95rem;
            cursor: pointer;
            padding: 0.5rem 1.1rem;
            border-radius: 0.4rem;
            transition: background 0.2s;
        }

        .input-code-wrapper .btn-join:hover {
            background: var(--google-blue-bg);
        }

        /* Stats Bar */
        .international-stats-bar {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1.25rem;
            margin-top: 2rem;
            padding-top: 2rem;
            border-top: 1px solid var(--border-color);
        }

        .stat-card-item {
            background: #ffffff;
            border: 1px solid var(--border-color);
            border-radius: 0.85rem;
            padding: 1.1rem 1.25rem;
            box-shadow: var(--shadow-sm);
        }

        .stat-item-val {
            font-size: 1.8rem;
            font-weight: 800;
            color: var(--google-blue);
            letter-spacing: -0.02em;
        }

        .stat-item-lbl {
            font-size: 0.85rem;
            color: var(--text-secondary);
            font-weight: 600;
            margin-top: 0.2rem;
        }

        /* Showcase Mockup */
        .showcase-card {
            background: #ffffff;
            border-radius: 1.5rem;
            box-shadow: var(--shadow-lg);
            border: 1px solid var(--border-color);
            overflow: hidden;
            position: relative;
        }

        .showcase-header {
            background: #0f172a;
            color: white;
            padding: 1rem 1.5rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .showcase-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 0.75rem;
            padding: 1.25rem;
            background: #020617;
        }

        .showcase-tile {
            background: #1e293b;
            border-radius: 0.85rem;
            aspect-ratio: 16/9;
            position: relative;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 1px solid rgba(255,255,255,0.1);
        }

        .showcase-tile img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .showcase-tile-label {
            position: absolute;
            bottom: 0.5rem;
            left: 0.5rem;
            background: rgba(15, 23, 42, 0.75);
            color: white;
            font-size: 0.75rem;
            font-weight: 600;
            padding: 0.25rem 0.6rem;
            border-radius: 0.35rem;
            backdrop-filter: blur(6px);
        }

        .showcase-controls {
            background: #0f172a;
            padding: 1rem;
            display: flex;
            justify-content: center;
            gap: 1rem;
        }

        .showcase-btn {
            width: 42px;
            height: 42px;
            border-radius: 50%;
            background: #334155;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.05rem;
        }

        /* Generic Section Styling */
        .page-section {
            padding: 6rem 2.5rem;
            border-top: 1px solid var(--border-color);
        }

        .section-container {
            max-width: 1280px;
            margin: 0 auto;
        }

        .section-header-box {
            text-align: center;
            max-width: 760px;
            margin: 0 auto 4rem auto;
        }

        .section-pill {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            background: var(--google-blue-bg);
            color: var(--google-blue);
            font-size: 0.8rem;
            font-weight: 800;
            padding: 0.35rem 0.9rem;
            border-radius: 9999px;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            margin-bottom: 1.25rem;
            border: 1px solid rgba(26, 115, 232, 0.2);
        }

        .section-title {
            font-size: 2.65rem;
            font-weight: 800;
            color: #0f172a;
            line-height: 1.2;
            letter-spacing: -0.02em;
            margin-bottom: 1rem;
        }

        .section-desc {
            font-size: 1.15rem;
            color: var(--text-secondary);
            line-height: 1.65;
        }

        /* Services Grid */
        .services-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 2rem;
        }

        .service-card {
            background: #ffffff;
            border-radius: 1.25rem;
            padding: 2.5rem 2rem;
            border: 1px solid var(--border-color);
            border-top: 4px solid var(--google-blue);
            box-shadow: var(--shadow-sm);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
        }

        .service-card:hover {
            box-shadow: var(--shadow-lg);
            transform: translateY(-8px);
        }

        .service-icon-box {
            width: 60px;
            height: 60px;
            border-radius: 16px;
            background: var(--google-blue-bg);
            color: var(--google-blue);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.6rem;
            margin-bottom: 1.5rem;
            box-shadow: 0 4px 12px rgba(26, 115, 232, 0.15);
        }

        .service-card-title {
            font-size: 1.35rem;
            font-weight: 700;
            margin-bottom: 0.75rem;
            color: #0f172a;
        }

        .service-card-desc {
            font-size: 0.98rem;
            color: var(--text-secondary);
            line-height: 1.65;
        }

        /* Media / Press Showcase Grid */
        .media-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
            gap: 2rem;
        }

        .media-card {
            background: #ffffff;
            border-radius: 1.25rem;
            border: 1px solid var(--border-color);
            overflow: hidden;
            box-shadow: var(--shadow-sm);
            transition: all 0.3s ease;
        }

        .media-card:hover {
            transform: translateY(-6px);
            box-shadow: var(--shadow-lg);
        }

        .media-card-img {
            width: 100%;
            height: 210px;
            object-fit: cover;
        }

        .media-card-body {
            padding: 1.75rem;
        }

        .media-tag {
            display: inline-block;
            background: #f1f5f9;
            color: #475569;
            font-size: 0.78rem;
            font-weight: 700;
            padding: 0.25rem 0.7rem;
            border-radius: 0.35rem;
            margin-bottom: 0.85rem;
        }

        .media-card-title {
            font-size: 1.2rem;
            font-weight: 700;
            margin-bottom: 0.75rem;
            color: #0f172a;
            line-height: 1.4;
        }

        /* Contact Section */
        .contact-box-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 3rem;
            align-items: start;
        }

        @media (max-width: 860px) {
            .contact-box-grid { grid-template-columns: 1fr; }
        }

        .contact-info-card {
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
            color: white;
            border-radius: 1.5rem;
            padding: 3rem;
            box-shadow: var(--shadow-lg);
            border: 1px solid rgba(255,255,255,0.1);
        }

        .contact-item {
            display: flex;
            align-items: flex-start;
            gap: 1.25rem;
            margin-bottom: 2.25rem;
        }

        .contact-icon {
            width: 52px;
            height: 52px;
            border-radius: 14px;
            background: rgba(59, 130, 246, 0.15);
            color: #60a5fa;
            border: 1px solid rgba(96, 165, 250, 0.3);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.3rem;
            flex-shrink: 0;
        }

        .contact-social-icons {
            display: flex;
            gap: 1rem;
            margin-top: 2.5rem;
            padding-top: 2rem;
            border-top: 1px solid rgba(255,255,255,0.1);
        }

        .contact-social-btn {
            width: 46px;
            height: 46px;
            border-radius: 50%;
            background: rgba(255,255,255,0.1);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.15rem;
            text-decoration: none;
            transition: all 0.25s;
        }

        .contact-social-btn:hover {
            background: var(--google-blue);
            transform: translateY(-3px);
            box-shadow: 0 4px 12px rgba(26, 115, 232, 0.4);
        }

        .contact-form-card {
            background: #ffffff;
            border: 1px solid var(--border-color);
            border-radius: 1.5rem;
            padding: 2.5rem;
            box-shadow: var(--shadow-md);
        }

        /* Generic Dashboard View Layouts */
        .portal-dashboard-container {
            display: none;
            max-width: 1280px;
            margin: 2rem auto 4rem auto;
            padding: 0 2rem;
        }

        .portal-header-card {
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
            border-radius: 1.25rem;
            padding: 2rem 2.5rem;
            color: white;
            margin-bottom: 2rem;
            box-shadow: var(--shadow-lg);
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 1.5rem;
        }

        .portal-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            background: rgba(59, 130, 246, 0.2);
            color: #60a5fa;
            border: 1px solid rgba(96, 165, 250, 0.3);
            padding: 0.3rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.8rem;
            font-weight: 600;
            margin-bottom: 0.75rem;
        }

        .portal-stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2.5rem;
        }

        .portal-stat-card {
            background: #ffffff;
            border: 1px solid var(--border-color);
            border-radius: 1rem;
            padding: 1.5rem;
            box-shadow: var(--shadow-sm);
        }

        .portal-stat-val {
            font-size: 2.25rem;
            font-weight: 800;
            color: var(--text-primary);
            margin: 0.25rem 0;
        }

        .portal-stat-lbl {
            font-size: 0.85rem;
            font-weight: 600;
            color: var(--text-secondary);
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .portal-table-card {
            background: #ffffff;
            border: 1px solid var(--border-color);
            border-radius: 1rem;
            box-shadow: var(--shadow-md);
            overflow: hidden;
            margin-bottom: 2rem;
        }

        .portal-table-header {
            padding: 1.5rem;
            border-bottom: 1px solid #f1f3f4;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .portal-table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
        }

        .portal-table th {
            background: #f8fafc;
            padding: 1rem 1.5rem;
            font-size: 0.85rem;
            font-weight: 700;
            color: var(--text-secondary);
            border-bottom: 1px solid var(--border-color);
        }

        .portal-table td {
            padding: 1.25rem 1.5rem;
            border-bottom: 1px solid #f1f3f4;
            font-size: 0.95rem;
            vertical-align: middle;
        }

        .portal-table tr:hover {
            background: #f8fafc;
        }

        .status-pill {
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
            padding: 0.25rem 0.65rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 700;
        }

        .status-pill.active { background: #e6f4ea; color: var(--google-green); }
        .status-pill.scheduled { background: #e8f0fe; color: var(--google-blue); }
        .status-pill.private { background: #fef3c7; color: #d97706; }
        .status-pill.public { background: #e0e7ff; color: #4338ca; }
        .status-pill.admin-perm { background: #f3e8ff; color: #7e22ce; }

        /* Modal System */
        .g-modal {
            position: fixed;
            inset: 0;
            background: rgba(15, 23, 42, 0.65);
            backdrop-filter: blur(6px);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 100;
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.2s ease;
        }

        .g-modal.active {
            opacity: 1;
            pointer-events: auto;
        }

        .g-modal-card {
            background: #ffffff;
            border-radius: 1.25rem;
            width: 100%;
            max-width: 640px;
            padding: 2.25rem;
            box-shadow: var(--shadow-lg);
            position: relative;
            max-height: 90vh;
            overflow-y: auto;
        }

        .g-modal-close {
            position: absolute;
            top: 1.25rem;
            right: 1.25rem;
            background: transparent;
            border: none;
            font-size: 1.25rem;
            color: var(--text-secondary);
            cursor: pointer;
            border-radius: 50%;
            width: 36px;
            height: 36px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .g-modal-close:hover {
            background: #f1f5f9;
        }

        .modal-tabs {
            display: flex;
            gap: 0.5rem;
            background: #f1f5f9;
            padding: 0.3rem;
            border-radius: 0.6rem;
            margin-bottom: 1.5rem;
            flex-wrap: wrap;
        }

        .modal-tab-btn {
            flex: 1;
            min-width: 100px;
            padding: 0.6rem;
            border: none;
            background: transparent;
            border-radius: 0.4rem;
            font-size: 0.85rem;
            font-weight: 700;
            color: var(--text-secondary);
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.4rem;
            transition: all 0.2s;
        }

        .modal-tab-btn.active {
            background: #ffffff;
            color: var(--google-blue);
            box-shadow: 0 2px 6px rgba(0,0,0,0.08);
        }

        .form-group {
            margin-bottom: 1.25rem;
        }

        .form-label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 600;
            font-size: 0.9rem;
            color: #0f172a;
        }

        .form-control {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 1.5px solid var(--border-color);
            border-radius: 0.6rem;
            font-size: 0.95rem;
            outline: none;
            transition: border-color 0.2s, box-shadow 0.2s;
        }

        .form-control:focus {
            border-color: var(--google-blue);
            box-shadow: 0 0 0 3px rgba(26, 115, 232, 0.2);
        }

        /* Live Video Room Overlay */
        #liveMeetingRoom {
            display: none;
            position: fixed;
            inset: 0;
            width: 100vw;
            height: 100vh;
            background: #0f172a;
            z-index: 200;
            flex-direction: column;
            justify-content: space-between;
            overflow: hidden;
        }

        .meeting-top-bar {
            padding: 0.85rem 1.5rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            color: white;
            background: #020617;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            z-index: 10;
        }

        .video-container-grid {
            flex: 1;
            padding: 1.5rem;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(340px, 1fr));
            gap: 1.25rem;
            align-items: center;
            justify-content: center;
            overflow-y: auto;
            max-height: calc(100vh - 145px);
        }

        .live-video-tile {
            background: #1e293b;
            border-radius: 0.85rem;
            aspect-ratio: 16/9;
            position: relative;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            border: 1px solid rgba(255,255,255,0.1);
        }

        .live-video-tile video {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .meeting-bottom-bar {
            padding: 1.25rem;
            background: #020617;
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 1.25rem;
        }

        .bar-btn {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: #334155;
            border: none;
            color: white;
            font-size: 1.2rem;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background 0.2s;
        }

        .bar-btn:hover { background: #475569; }
        .bar-btn.btn-hangup { background: var(--google-red); }
        .bar-btn.btn-hangup:hover { background: #b3261e; }

        .pulse-loader-g {
            width: 64px;
            height: 64px;
            border-radius: 50%;
            background: var(--google-blue);
            box-shadow: 0 0 0 0 rgba(26, 115, 232, 0.7);
            animation: pulse-g 1.6s infinite cubic-bezier(0.66, 0, 0, 1);
            margin: 2rem auto;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.5rem;
        }

        @keyframes pulse-g {
            to { box-shadow: 0 0 0 24px rgba(26, 115, 232, 0); }
        }

        .footer-sec {
            background: #020617;
            color: #94a3b8;
            padding: 4rem 2.5rem 2.5rem 2.5rem;
            border-top: 1px solid rgba(255,255,255,0.08);
        }
    </style>
</head>
<body>



    <!-- 2. Super Admin Panel View Container -->
    <div id="superAdminPanelView" class="portal-dashboard-container portal-view-section">
        <div class="portal-header-card">
            <div>
                <div class="portal-badge" style="background: rgba(168, 85, 247, 0.2); color: #c084fc; border-color: rgba(192, 132, 252, 0.3);">
                    <i class="fa-solid fa-crown"></i> SUPER ADMIN CONTROL CENTER
                </div>
                <h1 style="font-size: 2rem; font-weight: 700; margin-bottom: 0.5rem;">System Master Console</h1>
                <p style="color: #94a3b8; font-size: 0.95rem;">Manage System Admins, inspect platform analytics, assign custom granular permissions, and oversee system corporatization.</p>
            </div>
            <div>
                <button class="btn-google" onclick="openCreateAdminModal()">
                    <i class="fa-solid fa-user-plus"></i> Create System Admin
                </button>
            </div>
        </div>

        <div class="portal-stats-grid">
            <div class="portal-stat-card">
                <div class="portal-stat-lbl">System Admins</div>
                <div class="portal-stat-val" id="saStatAdmins">0</div>
                <div style="font-size: 0.8rem; color: var(--google-blue);"><i class="fa-solid fa-user-gear"></i> Active System Managers</div>
            </div>

            <div class="portal-stat-card">
                <div class="portal-stat-lbl">Total Corporates</div>
                <div class="portal-stat-val" id="saStatCorporates">0</div>
                <div style="font-size: 0.8rem; color: var(--google-green);"><i class="fa-solid fa-building"></i> Verified Corporate Accounts</div>
            </div>

            <div class="portal-stat-card">
                <div class="portal-stat-lbl">Corporate Employees</div>
                <div class="portal-stat-val" id="saStatEmployees">0</div>
                <div style="font-size: 0.8rem; color: var(--text-secondary);"><i class="fa-solid fa-users"></i> Account Users</div>
            </div>

            <div class="portal-stat-card">
                <div class="portal-stat-lbl">Active Live Meetings</div>
                <div class="portal-stat-val" id="saStatMeetings">0</div>
                <div style="font-size: 0.8rem; color: var(--google-green);"><i class="fa-solid fa-signal"></i> WebRTC Rooms</div>
            </div>
        </div>

        <div class="portal-table-card">
            <div class="portal-table-header">
                <div>
                    <h3 style="font-weight: 700; font-size: 1.15rem;"><i class="fa-solid fa-users-gear" style="color: #9333ea;"></i> Managed System Admins</h3>
                    <p style="font-size: 0.85rem; color: var(--text-secondary);">System admins receive auto-created white-label branding and custom permissions.</p>
                </div>
                <button class="btn-google-secondary" onclick="loadSuperAdminDashboard()"><i class="fa-solid fa-rotate-right"></i> Refresh List</button>
            </div>

            <table class="portal-table">
                <thead>
                    <tr>
                        <th>Admin Name</th>
                        <th>Email Address</th>
                        <th>Domain / Website URL</th>
                        <th>Granted Permissions</th>
                        <th>Created At</th>
                        <th style="text-align: right;">Actions</th>
                    </tr>
                </thead>
                <tbody id="saAdminsTableBody">
                    <tr><td colspan="6" style="text-align: center; padding: 2rem; color: var(--text-secondary);"><i class="fa-solid fa-spinner fa-spin"></i> Loading admins...</td></tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- 3. System Admin Panel View Container -->
    <div id="adminPanelView" class="portal-dashboard-container portal-view-section">
        <div class="portal-header-card">
            <div>
                <div class="portal-badge"><i class="fa-solid fa-user-shield"></i> SYSTEM ADMIN DASHBOARD</div>
                <h1 style="font-size: 2rem; font-weight: 700; margin-bottom: 0.5rem;">Admin Operations Portal</h1>
                <p style="color: #94a3b8; font-size: 0.95rem;">Manage Corporate accounts, configure dynamic white-label branding, and control mail & SMS gateways.</p>
            </div>
            <div style="display: flex; gap: 1rem;">
                <button class="btn-google" onclick="openCreateCorporateModal()">
                    <i class="fa-solid fa-building-circle-check"></i> Create Corporate Account
                </button>
                <button class="btn-google-outline" style="color: white; border-color: rgba(255,255,255,0.3);" onclick="openAdminSettingsModal()">
                    <i class="fa-solid fa-sliders"></i> Brand & System Settings
                </button>
            </div>
        </div>

        <div class="portal-stats-grid">
            <div class="portal-stat-card">
                <div class="portal-stat-lbl">Managed Corporates</div>
                <div class="portal-stat-val" id="admStatCorporates">0</div>
                <div style="font-size: 0.8rem; color: var(--google-blue);"><i class="fa-solid fa-building"></i> Enterprise Clients</div>
            </div>

            <div class="portal-stat-card">
                <div class="portal-stat-lbl">Total Corporate Employees</div>
                <div class="portal-stat-val" id="admStatEmployees">0</div>
                <div style="font-size: 0.8rem; color: var(--google-green);"><i class="fa-solid fa-user-group"></i> Active Employees</div>
            </div>

            <div class="portal-stat-card">
                <div class="portal-stat-lbl">Custom Domain Match</div>
                <div class="portal-stat-val" id="admStatDomainText" style="font-size: 1.1rem; padding-top: 0.5rem; word-break: break-all;">-</div>
                <div style="font-size: 0.8rem; color: var(--text-secondary);"><i class="fa-solid fa-globe"></i> Active Brand Website URL</div>
            </div>
        </div>

        <div class="portal-table-card">
            <div class="portal-table-header">
                <div>
                    <h3 style="font-weight: 700; font-size: 1.15rem;"><i class="fa-solid fa-building" style="color: var(--google-blue);"></i> Corporate Client Accounts</h3>
                    <p style="font-size: 0.85rem; color: var(--text-secondary);">Each corporate receives a primary Corporate Admin account with employee management controls.</p>
                </div>
                <button class="btn-google-secondary" onclick="loadAdminDashboard()"><i class="fa-solid fa-rotate-right"></i> Refresh Table</button>
            </div>

            <table class="portal-table">
                <thead>
                    <tr>
                        <th>Company Name</th>
                        <th>Contact Email</th>
                        <th>Primary Corporate Admin</th>
                        <th>Status</th>
                        <th>Created Date</th>
                    </tr>
                </thead>
                <tbody id="admCorporatesTableBody">
                    <tr><td colspan="5" style="text-align: center; padding: 2rem; color: var(--text-secondary);"><i class="fa-solid fa-spinner fa-spin"></i> Loading corporate accounts...</td></tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- 4. Corporate Admin Portal Container -->
    <div id="corporateAdminPanelView" class="portal-dashboard-container portal-view-section">
        <div class="portal-header-card">
            <div>
                <div class="portal-badge" style="background: rgba(16, 185, 129, 0.2); color: #34d399; border-color: rgba(52, 211, 153, 0.3);">
                    <i class="fa-solid fa-building-user"></i> CORPORATE ADMIN PORTAL
                </div>
                <h1 style="font-size: 2rem; font-weight: 700; margin-bottom: 0.5rem;" id="corpAdminPortalTitle">Corporate Account Management</h1>
                <p style="color: #94a3b8; font-size: 0.95rem;">Manage company employees, assign meeting hosting privileges, and review team conferencing activity.</p>
            </div>
            <div>
                <button class="btn-google" onclick="openCreateEmployeeModal()">
                    <i class="fa-solid fa-user-plus"></i> Add New Employee
                </button>
            </div>
        </div>

        <div class="portal-stats-grid">
            <div class="portal-stat-card">
                <div class="portal-stat-lbl">Company Employees</div>
                <div class="portal-stat-val" id="caStatEmployees">0</div>
                <div style="font-size: 0.8rem; color: var(--google-blue);"><i class="fa-solid fa-id-badge"></i> Registered Staff</div>
            </div>

            <div class="portal-stat-card">
                <div class="portal-stat-lbl">Authorized Hosts</div>
                <div class="portal-stat-val" id="caStatHosts">0</div>
                <div style="font-size: 0.8rem; color: var(--google-green);"><i class="fa-solid fa-video"></i> Can Host Meetings</div>
            </div>
        </div>

        <div class="portal-table-card">
            <div class="portal-table-header">
                <div>
                    <h3 style="font-weight: 700; font-size: 1.15rem;"><i class="fa-solid fa-users" style="color: var(--google-green);"></i> Company Employee Roster</h3>
                    <p style="font-size: 0.85rem; color: var(--text-secondary);">Toggle meeting host permissions for individual employees in 1 click.</p>
                </div>
                <button class="btn-google-secondary" onclick="loadCorporateAdminDashboard()"><i class="fa-solid fa-rotate-right"></i> Refresh Table</button>
            </div>

            <table class="portal-table">
                <thead>
                    <tr>
                        <th>Employee Name</th>
                        <th>Email Address</th>
                        <th>Designation</th>
                        <th>Meeting Host Privilege</th>
                        <th style="text-align: right;">Privilege Actions</th>
                    </tr>
                </thead>
                <tbody id="caEmployeesTableBody">
                    <tr><td colspan="5" style="text-align: center; padding: 2rem; color: var(--text-secondary);"><i class="fa-solid fa-spinner fa-spin"></i> Loading employee roster...</td></tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- 5. Corporate Host Dashboard Container -->
    <div id="corporateDashboardView" class="portal-dashboard-container portal-view-section">
        <div class="portal-header-card">
            <div>
                <div class="portal-badge"><i class="fa-solid fa-building"></i> CORPORATE HOST DASHBOARD</div>
                <h1 style="font-size: 2rem; font-weight: 700; margin-bottom: 0.5rem;">Corporate Host Portal</h1>
                <p style="color: #94a3b8; font-size: 0.95rem;">Manage team meeting rooms, corporate webinars, participant invitations & access logs.</p>
            </div>
            <div style="display: flex; gap: 1rem;">
                <button class="btn-google" onclick="openMeetingModal('instant')">
                    <i class="fa-solid fa-bolt"></i> Start Instant Conference
                </button>
                <button class="btn-google-outline" style="color: white; border-color: rgba(255,255,255,0.3);" onclick="openMeetingModal('schedule')">
                    <i class="fa-regular fa-calendar-plus"></i> Schedule Meeting
                </button>
            </div>
        </div>

        <div class="portal-stats-grid">
            <div class="portal-stat-card">
                <div class="portal-stat-lbl">Hosted Meetings</div>
                <div class="portal-stat-val" id="statHostedCount">0</div>
                <div style="font-size: 0.8rem; color: var(--google-green);"><i class="fa-solid fa-circle"></i> Corporate Account Active</div>
            </div>

            <div class="portal-stat-card">
                <div class="portal-stat-lbl">Active Live Rooms</div>
                <div class="portal-stat-val" id="statActiveRooms">0</div>
                <div style="font-size: 0.8rem; color: var(--google-blue);"><i class="fa-solid fa-signal"></i> WebRTC Live SFU</div>
            </div>

            <div class="portal-stat-card">
                <div class="portal-stat-lbl">Scheduled Meetings</div>
                <div class="portal-stat-val" id="statScheduledCount">0</div>
                <div style="font-size: 0.8rem; color: var(--text-secondary);"><i class="fa-solid fa-clock"></i> Upcoming sessions</div>
            </div>

            <div class="portal-stat-card">
                <div class="portal-stat-lbl">Security Checks Passed</div>
                <div class="portal-stat-val">100%</div>
                <div style="font-size: 0.8rem; color: var(--google-green);"><i class="fa-solid fa-shield-check"></i> 12 Access Verification Rules</div>
            </div>
        </div>

        <div class="portal-table-card">
            <div class="portal-table-header">
                <div>
                    <h3 style="font-weight: 700; font-size: 1.15rem;"><i class="fa-solid fa-list-check" style="color: var(--google-blue);"></i> Corporate Hosted Meetings</h3>
                    <p style="font-size: 0.85rem; color: var(--text-secondary);">Real-time management of private and public conference rooms.</p>
                </div>
                <button class="btn-google-secondary" onclick="loadCorporateMeetings()"><i class="fa-solid fa-rotate-right"></i> Refresh Table</button>
            </div>

            <table class="portal-table">
                <thead>
                    <tr>
                        <th>Meeting Title</th>
                        <th>Meeting UUID / Code</th>
                        <th>Access Mode</th>
                        <th>Scheduled / Status</th>
                        <th>Participants</th>
                        <th style="text-align: right;">Host Actions</th>
                    </tr>
                </thead>
                <tbody id="corpMeetingsTableBody">
                    <tr>
                        <td colspan="6" style="text-align: center; color: var(--text-secondary); padding: 2rem;">
                            <i class="fa-solid fa-spinner fa-spin"></i> Loading corporate meetings...
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>


    <!-- MODALS SECTION -->

    <!-- Modal 1: Create System Admin -->
    <div class="g-modal" id="createAdminModal">
        <div class="g-modal-card">
            <button class="g-modal-close" onclick="closeModal('createAdminModal')"><i class="fa-solid fa-xmark"></i></button>
            <h2 style="font-weight: 700; margin-bottom: 0.5rem;"><i class="fa-solid fa-user-gear" style="color: #9333ea;"></i> Create System Admin</h2>
            <p style="color: var(--text-secondary); font-size: 0.9rem; margin-bottom: 1.5rem;">When created, Super Admin settings are automatically cloned to initialize this Admin's white-label defaults.</p>

            <form onsubmit="handleCreateAdminSubmit(event)">
                <div class="form-group">
                    <label class="form-label">Admin Full Name</label>
                    <input type="text" id="caAdminName" class="form-control" placeholder="System Admin" required>
                </div>

                <div class="form-group">
                    <label class="form-label">Email Address</label>
                    <input type="email" id="caAdminEmail" class="form-control" placeholder="admin@enterprise.com" required>
                </div>

                <div class="form-group">
                    <label class="form-label">Password</label>
                    <input type="password" id="caAdminPassword" class="form-control" placeholder="••••••••" minlength="6" required>
                </div>

                <div class="form-group">
                    <label class="form-label">Brand Website URL (Domain Match)</label>
                    <input type="url" id="caAdminWebsiteUrl" class="form-control" placeholder="http://127.0.0.1:8000">
                    <div style="font-size: 0.75rem; color: var(--text-secondary); margin-top: 0.25rem;">Used for matching HTTP Request Origin URL on public landing page.</div>
                </div>

                <div class="form-group">
                    <label class="form-label">Granted Permissions</label>
                    <div style="display: flex; flex-direction: column; gap: 0.5rem; background: #f8fafc; padding: 0.75rem; border-radius: 0.5rem;">
                        <label style="display: flex; align-items: center; gap: 0.5rem; font-size: 0.9rem; cursor: pointer;">
                            <input type="checkbox" class="ca-perm-chk" value="manage_admins" checked> Manage System Admins
                        </label>
                        <label style="display: flex; align-items: center; gap: 0.5rem; font-size: 0.9rem; cursor: pointer;">
                            <input type="checkbox" class="ca-perm-chk" value="manage_corporates" checked> Manage Corporate Accounts
                        </label>
                        <label style="display: flex; align-items: center; gap: 0.5rem; font-size: 0.9rem; cursor: pointer;">
                            <input type="checkbox" class="ca-perm-chk" value="manage_reports" checked> View System Reports
                        </label>
                        <label style="display: flex; align-items: center; gap: 0.5rem; font-size: 0.9rem; cursor: pointer;">
                            <input type="checkbox" class="ca-perm-chk" value="manage_settings" checked> Configure Brand & Gateways
                        </label>
                    </div>
                </div>

                <button type="submit" class="btn-google" style="width: 100%; justify-content: center; margin-top: 1rem;">
                    <i class="fa-solid fa-check"></i> Create Admin & Auto-Initialize Settings
                </button>
            </form>
            <div id="createAdminAlert" style="margin-top: 1rem;"></div>
        </div>
    </div>

    <!-- Modal 2: Edit Admin Permissions -->
    <div class="g-modal" id="editPermissionsModal">
        <div class="g-modal-card" style="max-width: 460px;">
            <button class="g-modal-close" onclick="closeModal('editPermissionsModal')"><i class="fa-solid fa-xmark"></i></button>
            <h2 style="font-weight: 700; margin-bottom: 0.5rem;">Update Admin Permissions</h2>
            <p style="color: var(--text-secondary); font-size: 0.9rem; margin-bottom: 1.5rem;" id="epModalSub">Select granted permission keys.</p>

            <form onsubmit="handleUpdatePermissionsSubmit(event)">
                <input type="hidden" id="epTargetAdminId">
                <div class="form-group">
                    <div style="display: flex; flex-direction: column; gap: 0.6rem; background: #f8fafc; padding: 1rem; border-radius: 0.5rem;">
                        <label style="display: flex; align-items: center; gap: 0.5rem; font-size: 0.9rem; cursor: pointer;">
                            <input type="checkbox" class="ep-perm-chk" value="manage_admins"> Manage System Admins
                        </label>
                        <label style="display: flex; align-items: center; gap: 0.5rem; font-size: 0.9rem; cursor: pointer;">
                            <input type="checkbox" class="ep-perm-chk" value="manage_corporates"> Manage Corporate Accounts
                        </label>
                        <label style="display: flex; align-items: center; gap: 0.5rem; font-size: 0.9rem; cursor: pointer;">
                            <input type="checkbox" class="ep-perm-chk" value="manage_reports"> View System Reports
                        </label>
                        <label style="display: flex; align-items: center; gap: 0.5rem; font-size: 0.9rem; cursor: pointer;">
                            <input type="checkbox" class="ep-perm-chk" value="manage_settings"> Configure Brand & Gateways
                        </label>
                    </div>
                </div>

                <button type="submit" class="btn-google" style="width: 100%; justify-content: center; margin-top: 1rem;">
                    Save Updated Permissions
                </button>
            </form>
            <div id="editPermissionsAlert" style="margin-top: 1rem;"></div>
        </div>
    </div>

    <!-- Modal 3: Create Corporate Account -->
    <div class="g-modal" id="createCorporateModal">
        <div class="g-modal-card">
            <button class="g-modal-close" onclick="closeModal('createCorporateModal')"><i class="fa-solid fa-xmark"></i></button>
            <h2 style="font-weight: 700; margin-bottom: 0.5rem;"><i class="fa-solid fa-building-circle-check" style="color: var(--google-blue);"></i> Create Corporate Account</h2>
            <p style="color: var(--text-secondary); font-size: 0.9rem; margin-bottom: 1.5rem;">Creates the Corporate company profile AND provisions the Primary Corporate Admin user credentials.</p>

            <form onsubmit="handleCreateCorporateSubmit(event)">
                <div class="form-group">
                    <label class="form-label">Corporate Company Name</label>
                    <input type="text" id="ccCompanyName" class="form-control" placeholder="Acme Technologies Inc" required>
                </div>

                <div class="form-group">
                    <label class="form-label">Corporate Contact Email</label>
                    <input type="email" id="ccCompanyEmail" class="form-control" placeholder="contact@acme.com" required>
                </div>

                <div style="border-top: 1px solid #f1f3f4; padding-top: 1rem; margin-top: 1rem;">
                    <div style="font-weight: 700; font-size: 0.95rem; margin-bottom: 0.75rem; color: var(--google-blue);">
                        <i class="fa-solid fa-user-shield"></i> Primary Corporate Admin Credentials
                    </div>

                    <div class="form-group">
                        <label class="form-label">Corporate Admin Full Name</label>
                        <input type="text" id="ccAdminName" class="form-control" placeholder="Corporate Admin" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Corporate Admin Login Email</label>
                        <input type="email" id="ccAdminEmail" class="form-control" placeholder="admin@acme.com" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Corporate Admin Password</label>
                        <input type="password" id="ccAdminPassword" class="form-control" placeholder="••••••••" minlength="6" required>
                    </div>
                </div>

                <button type="submit" class="btn-google" style="width: 100%; justify-content: center; margin-top: 1rem;">
                    <i class="fa-solid fa-check"></i> Provision Corporate Account
                </button>
            </form>
            <div id="createCorporateAlert" style="margin-top: 1rem;"></div>
        </div>
    </div>

    <!-- Modal 4: Add Employee -->
    <div class="g-modal" id="createEmployeeModal">
        <div class="g-modal-card" style="max-width: 480px;">
            <button class="g-modal-close" onclick="closeModal('createEmployeeModal')"><i class="fa-solid fa-xmark"></i></button>
            <h2 style="font-weight: 700; margin-bottom: 0.5rem;"><i class="fa-solid fa-user-plus" style="color: var(--google-green);"></i> Add Company Employee</h2>
            <p style="color: var(--text-secondary); font-size: 0.9rem; margin-bottom: 1.5rem;">Register a company team member under your corporate account.</p>

            <form onsubmit="handleCreateEmployeeSubmit(event)">
                <div class="form-group">
                    <label class="form-label">Employee Full Name</label>
                    <input type="text" id="ceName" class="form-control" placeholder="Vikram Malhotra" required>
                </div>

                <div class="form-group">
                    <label class="form-label">Work Email Address</label>
                    <input type="email" id="ceEmail" class="form-control" placeholder="vikram@company.com" required>
                </div>

                <div class="form-group">
                    <label class="form-label">Password</label>
                    <input type="password" id="cePassword" class="form-control" placeholder="••••••••" minlength="6" required>
                </div>

                <div class="form-group">
                    <label class="form-label">Designation / Role Title</label>
                    <input type="text" id="ceDesignation" class="form-control" placeholder="Senior Product Manager">
                </div>

                <div class="form-group">
                    <label style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer; font-size: 0.9rem;">
                        <input type="checkbox" id="ceCanHostToggle" checked style="width: 1.1rem; height: 1.1rem; accent-color: var(--google-green);">
                        <span>Grant Meeting Hosting Privilege (Default: ON)</span>
                    </label>
                </div>

                <button type="submit" class="btn-google" style="width: 100%; justify-content: center; margin-top: 1rem; background: var(--google-green);">
                    <i class="fa-solid fa-check"></i> Register Employee
                </button>
            </form>
            <div id="createEmployeeAlert" style="margin-top: 1rem;"></div>
        </div>
    </div>

    <!-- Modal 5: Admin Settings & White-Label Branding Modal -->
    <div class="g-modal" id="adminSettingsModal">
        <div class="g-modal-card" style="max-width: 720px;">
            <button class="g-modal-close" onclick="closeModal('adminSettingsModal')"><i class="fa-solid fa-xmark"></i></button>

            <div class="modal-tabs">
                <button class="modal-tab-btn active" id="tabSetBrandBtn" onclick="switchSettingsTab('brand')">
                    <i class="fa-solid fa-palette"></i> Brand & Design
                </button>
                <button class="modal-tab-btn" id="tabSetCmsBtn" onclick="switchSettingsTab('cms')">
                    <i class="fa-solid fa-layer-group"></i> Landing Page CMS
                </button>
                <button class="modal-tab-btn" id="tabSetSmtpBtn" onclick="switchSettingsTab('smtp')">
                    <i class="fa-solid fa-envelope"></i> SMTP Server
                </button>
                <button class="modal-tab-btn" id="tabSetSmsBtn" onclick="switchSettingsTab('sms')">
                    <i class="fa-solid fa-comment-sms"></i> SMS Gateway
                </button>
            </div>

            <h2 style="font-weight: 700; margin-bottom: 0.5rem;"><i class="fa-solid fa-sliders" style="color: var(--google-blue);"></i> Enterprise Branding & CMS Management</h2>
            <p style="color: var(--text-secondary); font-size: 0.9rem; margin-bottom: 1.5rem;">Changes saved here dynamically update your landing page design, About, Services, Media, and Contact content.</p>

            <form onsubmit="handleSaveAdminSettingsSubmit(event)">
                <!-- Tab 1: Brand & Design -->
                <div id="setTabBrandView">
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                        <div class="form-group">
                            <label class="form-label">Company Name</label>
                            <input type="text" id="stCompanyName" class="form-control" placeholder="Acme Enterprise">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Application Title / Name</label>
                            <input type="text" id="stAppName" class="form-control" placeholder="MeetingPulse Enterprise">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Website URL (Origin Matching)</label>
                        <input type="url" id="stWebsiteUrl" class="form-control" placeholder="http://127.0.0.1:8000">
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                        <div class="form-group">
                            <label class="form-label">Logo Image URL</label>
                            <input type="url" id="stLogoUrl" class="form-control" placeholder="https://example.com/logo.png">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Favicon URL</label>
                            <input type="url" id="stFaviconUrl" class="form-control" placeholder="https://example.com/favicon.ico">
                        </div>
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                        <div class="form-group">
                            <label class="form-label">Primary Theme Color</label>
                            <input type="color" id="stPrimaryColor" class="form-control" style="height: 44px; padding: 0.2rem;" value="#1a73e8">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Secondary Theme Color</label>
                            <input type="color" id="stSecondaryColor" class="form-control" style="height: 44px; padding: 0.2rem;" value="#0f172a">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Hero Tagline / Subtitle</label>
                        <input type="text" id="stTagline" class="form-control" placeholder="Secure Enterprise WebRTC Conferencing">
                    </div>
                </div>

                <!-- Tab 2: Landing Page CMS -->
                <div id="setTabCmsView" style="display: none;">
                    <div class="form-group">
                        <label class="form-label">About Section Headline Title</label>
                        <input type="text" id="stAboutTitle" class="form-control" placeholder="Empowering Global Collaboration & Enterprise Video Meetings">
                    </div>

                    <div class="form-group">
                        <label class="form-label">About Section Detailed Text</label>
                        <textarea id="stAboutText" class="form-control" rows="3" placeholder="MeetingPulse is engineered for global enterprises..."></textarea>
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                        <div class="form-group">
                            <label class="form-label">Contact Physical Address</label>
                            <input type="text" id="stContactAddress" class="form-control" placeholder="Enterprise World Tower, 8th Floor, Tech Hub Center">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Contact Support Phone</label>
                            <input type="text" id="stContactPhone" class="form-control" placeholder="+1 (800) 555-MEET / +91 98765 43210">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Services List (JSON Format)</label>
                        <textarea id="stServicesJson" class="form-control" rows="4" style="font-family: monospace; font-size: 0.85rem;"></textarea>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Media & Press Items (JSON Format)</label>
                        <textarea id="stMediaJson" class="form-control" rows="4" style="font-family: monospace; font-size: 0.85rem;"></textarea>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Social Media Links (JSON Format)</label>
                        <textarea id="stSocialLinksJson" class="form-control" rows="3" style="font-family: monospace; font-size: 0.85rem;"></textarea>
                    </div>
                </div>

                <!-- Tab 3: SMTP Mail Server -->
                <div id="setTabSmtpView" style="display: none;">
                    <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 1rem;">
                        <div class="form-group">
                            <label class="form-label">SMTP Host</label>
                            <input type="text" id="stSmtpHost" class="form-control" placeholder="smtp.mailtrap.io">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Port</label>
                            <input type="number" id="stSmtpPort" class="form-control" placeholder="587">
                        </div>
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                        <div class="form-group">
                            <label class="form-label">Username</label>
                            <input type="text" id="stSmtpUsername" class="form-control">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Password</label>
                            <input type="password" id="stSmtpPassword" class="form-control">
                        </div>
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 2fr; gap: 1rem;">
                        <div class="form-group">
                            <label class="form-label">Encryption</label>
                            <select id="stSmtpEncryption" class="form-control">
                                <option value="tls">TLS</option>
                                <option value="ssl">SSL</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label">From Email Address</label>
                            <input type="email" id="stSmtpFromEmail" class="form-control" placeholder="no-reply@enterprise.com">
                        </div>
                    </div>
                </div>

                <!-- Tab 4: SMS Gateway -->
                <div id="setTabSmsView" style="display: none;">
                    <div class="form-group">
                        <label class="form-label">SMS Provider</label>
                        <input type="text" id="stSmsProvider" class="form-control" placeholder="Twilio / Msg91 / Infobip">
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                        <div class="form-group">
                            <label class="form-label">API Key / Account SID</label>
                            <input type="text" id="stSmsApiKey" class="form-control">
                        </div>
                        <div class="form-group">
                            <label class="form-label">API Secret / Auth Token</label>
                            <input type="password" id="stSmsApiSecret" class="form-control">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">SMS Sender ID</label>
                        <input type="text" id="stSmsSenderId" class="form-control" placeholder="MTPULSE">
                    </div>
                </div>

                <button type="submit" class="btn-google" style="width: 100%; justify-content: center; margin-top: 1.5rem;">
                    <i class="fa-solid fa-floppy-disk"></i> Save Enterprise Brand & CMS Settings
                </button>
            </form>
            <div id="adminSettingsAlert" style="margin-top: 1rem;"></div>
        </div>
    </div>

    <!-- Create / Schedule Meeting Modal -->
    <div class="g-modal" id="createMeetingModal">
        <div class="g-modal-card">
            <button class="g-modal-close" onclick="closeModal('createMeetingModal')"><i class="fa-solid fa-xmark"></i></button>
            
            <div class="modal-tabs">
                <button class="modal-tab-btn active" id="tabInstantBtn" onclick="switchMeetingTab('instant')">
                    <i class="fa-solid fa-bolt"></i> Start Instant Meeting
                </button>
                <button class="modal-tab-btn" id="tabScheduleBtn" onclick="switchMeetingTab('schedule')">
                    <i class="fa-regular fa-calendar-plus"></i> Schedule for Later
                </button>
            </div>

            <h2 id="modalMeetingHeaderTitle" style="font-weight: 700; margin-bottom: 0.5rem;">Start an Instant Meeting</h2>
            <p id="modalMeetingHeaderSub" style="color: var(--text-secondary); font-size: 0.9rem; margin-bottom: 1.5rem;">Launch a WebRTC video meeting room immediately.</p>

            <form id="createMeetingForm" onsubmit="handleCreateMeetingSubmit(event)">
                <input type="hidden" id="mTabType" value="instant">

                <div class="form-group">
                    <label class="form-label">Meeting Title</label>
                    <input type="text" id="mTitle" class="form-control" placeholder="e.g. Executive Quarterly Review" required>
                </div>

                <div class="form-group" id="scheduledTimeGroup" style="display: none;">
                    <label class="form-label">Scheduled Date & Time</label>
                    <input type="datetime-local" id="mStartsAt" class="form-control">
                </div>

                <div class="form-group">
                    <label class="form-label"><i class="fa-solid fa-hourglass-half" style="color: var(--google-blue);"></i> Standard Meeting Duration (End Time)</label>
                    <select id="mDurationMinutes" class="form-control" style="font-weight: 600;">
                        <option value="15">15 Minutes</option>
                        <option value="30">30 Minutes</option>
                        <option value="60" selected>60 Minutes (Standard Default)</option>
                        <option value="90">90 Minutes (1.5 Hours)</option>
                        <option value="120">120 Minutes (2 Hours)</option>
                        <option value="240">240 Minutes (4 Hours)</option>
                    </select>
                    <small style="color: var(--text-secondary); font-size: 0.78rem; display: block; margin-top: 0.25rem;">Meeting will automatically close & clear localStorage when this time limit is reached.</small>
                </div>

                <div class="form-group">
                    <label class="form-label">Meeting Access Type</label>
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                        <label style="border: 2px solid var(--google-blue); background: var(--google-blue-bg); padding: 1rem; border-radius: 0.5rem; cursor: pointer; display: block;" id="labelPrivate" onclick="setAccessMode('private')">
                            <input type="radio" name="access_mode" value="private" checked style="display: none;">
                            <div style="font-weight: 700; color: var(--google-blue);"><i class="fa-solid fa-lock"></i> Private</div>
                            <div style="font-size: 0.75rem; color: var(--text-secondary); margin-top: 0.25rem;">Only invited emails can join</div>
                        </label>
                        <label style="border: 1px solid var(--border-color); padding: 1rem; border-radius: 0.5rem; cursor: pointer; display: block;" id="labelPublic" onclick="setAccessMode('public')">
                            <input type="radio" name="access_mode" value="public" style="display: none;">
                            <div style="font-weight: 700; color: var(--text-primary);"><i class="fa-solid fa-globe"></i> Public</div>
                            <div style="font-size: 0.75rem; color: var(--text-secondary); margin-top: 0.25rem;">Anyone can request entry</div>
                        </label>
                    </div>
                </div>

                <div class="form-group" id="privateEmailsContainer">
                    <label class="form-label">Invited Participant Emails</label>
                    <div style="display: flex; gap: 0.5rem;">
                        <input type="email" id="inviteEmailInput" class="form-control" placeholder="colleague@company.com">
                        <button type="button" class="btn-google-secondary" onclick="addEmailChip()"><i class="fa-solid fa-plus"></i></button>
                    </div>
                    <div id="emailChipsList" style="display: flex; flex-wrap: wrap; gap: 0.5rem; margin-top: 0.75rem;"></div>
                </div>

                <div class="form-group" id="publicApprovalContainer" style="display: none;">
                    <label style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer; font-size: 0.9rem;">
                        <input type="checkbox" id="mApprovalToggle" checked style="width: 1.1rem; height: 1.1rem; accent-color: var(--google-blue);">
                        <span>Require Host Approval before entry (Default: ON)</span>
                    </label>
                </div>

                <button type="submit" class="btn-google" id="mSubmitBtn" style="width: 100%; justify-content: center; margin-top: 1rem;">
                    Launch Meeting Room Now
                </button>
            </form>
        </div>
    </div>

    <!-- Auth Modal -->
    <div class="g-modal" id="authModal">
        <div class="g-modal-card" style="max-width: 440px;">
            <button class="g-modal-close" onclick="closeModal('authModal')"><i class="fa-solid fa-xmark"></i></button>

            <div class="modal-tabs" id="authTabsContainer">
                <button class="modal-tab-btn active" id="authTabSignInBtn" onclick="switchAuthTab('signin')">
                    <i class="fa-solid fa-right-to-bracket"></i> Sign In
                </button>
                <button class="modal-tab-btn" id="authTabSignUpBtn" onclick="switchAuthTab('signup')">
                    <i class="fa-solid fa-user-plus"></i> Sign Up
                </button>
            </div>

            <div id="authSignInView">
                <h2 style="font-weight: 700; margin-bottom: 0.5rem; text-align: center;">Welcome Back</h2>
                <p style="color: var(--text-secondary); font-size: 0.9rem; margin-bottom: 1.5rem; text-align: center;">Sign in with your Email ID and Password</p>

                <form onsubmit="handleSignIn(event)">
                    <div class="form-group">
                        <label class="form-label">Email Address</label>
                        <input type="email" id="signInEmail" class="form-control" placeholder="name@company.com" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Password</label>
                        <input type="password" id="signInPassword" class="form-control" placeholder="••••••••" required>
                    </div>

                    <button type="submit" class="btn-google" style="width: 100%; justify-content: center; margin-top: 1rem;">
                        <i class="fa-solid fa-right-to-bracket"></i> Sign In to Account
                    </button>
                </form>
            </div>

            <div id="authSignUpView" style="display: none;">
                <h2 style="font-weight: 700; margin-bottom: 0.5rem; text-align: center;">Create Account</h2>
                <p style="color: var(--text-secondary); font-size: 0.9rem; margin-bottom: 1.5rem; text-align: center;">Register with Email ID & Password to receive 6-digit OTP</p>

                <form onsubmit="handleSignUp(event)">
                    <div class="form-group">
                        <label class="form-label">Full Name</label>
                        <input type="text" id="signUpName" class="form-control" placeholder="Rahul Sharma" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Email Address</label>
                        <input type="email" id="signUpEmail" class="form-control" placeholder="name@company.com" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Password</label>
                        <input type="password" id="signUpPassword" class="form-control" placeholder="At least 6 characters" minlength="6" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Confirm Password</label>
                        <input type="password" id="signUpPasswordConfirm" class="form-control" placeholder="Repeat password" minlength="6" required>
                    </div>

                    <button type="submit" class="btn-google" style="width: 100%; justify-content: center; margin-top: 1rem;">
                        <i class="fa-solid fa-envelope"></i> Send 6-Digit OTP Code
                    </button>
                </form>
            </div>

            <div id="authOtpVerifyView" style="display: none; text-align: center;">
                <div class="pulse-loader-g" style="width: 56px; height: 56px; font-size: 1.25rem; margin: 0 auto 1rem auto;">
                    <i class="fa-solid fa-key"></i>
                </div>

                <h2 style="font-weight: 700; margin-bottom: 0.5rem;">Verify Your Email</h2>
                <p style="color: var(--text-secondary); font-size: 0.9rem; margin-bottom: 1rem;">
                    Enter the 6-digit OTP code sent to <strong id="otpTargetEmailText" style="color: var(--google-blue);">email@example.com</strong>
                </p>

                <div id="otpDemoBanner" style="background: #e8f0fe; border: 1px dashed var(--google-blue); border-radius: 0.5rem; padding: 0.75rem; color: var(--google-blue); font-weight: 700; font-size: 1.1rem; margin-bottom: 1.5rem; letter-spacing: 0.15em;">
                    OTP: ------
                </div>

                <form onsubmit="handleVerifyOtp(event)">
                    <div class="form-group">
                        <input type="text" id="otpInput" class="form-control" placeholder="123456" maxlength="6" style="text-align: center; font-size: 1.5rem; letter-spacing: 0.3em; font-weight: 700;" required>
                    </div>

                    <button type="submit" class="btn-google" style="width: 100%; justify-content: center; margin-top: 1rem;">
                        <i class="fa-solid fa-shield-check"></i> Verify OTP & Log In
                    </button>
                </form>

                <div style="margin-top: 1.25rem; font-size: 0.85rem; color: var(--text-secondary);">
                    Didn't receive the OTP code? <a href="#" style="color: var(--google-blue); font-weight: 600; text-decoration: none;" onclick="handleResendOtp(event)">Resend OTP</a>
                </div>
            </div>

            <div id="authAlert" style="margin-top: 1.25rem;"></div>
        </div>
    </div>

    <!-- User Profile Details Modal -->
    <div class="g-modal" id="userProfileModal">
        <div class="g-modal-card" style="max-width: 480px;">
            <button class="g-modal-close" onclick="closeModal('userProfileModal')"><i class="fa-solid fa-xmark"></i></button>
            <div style="text-align: center; padding: 1rem 0;">
                <div id="profileModalAvatarContainer" style="margin-bottom: 1rem;">
                    <div style="width: 80px; height: 80px; border-radius: 50%; background: var(--google-blue); color: white; display: flex; align-items: center; justify-content: center; font-size: 2.2rem; font-weight: 700; margin: 0 auto; box-shadow: 0 4px 12px rgba(26,115,232,0.3);">
                        U
                    </div>
                </div>
                <h2 id="profileModalName" style="font-weight: 700;">User Name</h2>
                <div id="profileModalEmail" style="color: var(--text-secondary); font-size: 0.95rem; margin-bottom: 1rem;">user@example.com</div>
                <div id="profileModalBadge" style="margin-bottom: 1.5rem;"></div>
            </div>

            <div style="background: #f8fafc; border-radius: 0.75rem; padding: 1.25rem; margin-bottom: 1.5rem;">
                <div style="display: flex; justify-content: space-between; padding-bottom: 0.75rem; border-bottom: 1px solid #e5e7eb; margin-bottom: 0.75rem;">
                    <span style="color: var(--text-secondary); font-size: 0.9rem;">System Role</span>
                    <span id="profileModalRole" style="font-weight: 600; text-transform: uppercase; font-size: 0.9rem;">User</span>
                </div>
                <div style="display: flex; justify-content: space-between; padding-bottom: 0.75rem; border-bottom: 1px solid #e5e7eb; margin-bottom: 0.75rem;">
                    <span style="color: var(--text-secondary); font-size: 0.9rem;">Account Type</span>
                    <span id="profileModalAccountType" style="font-weight: 600; text-transform: capitalize; font-size: 0.9rem;">Free</span>
                </div>
                <div style="display: flex; justify-content: space-between;">
                    <span style="color: var(--text-secondary); font-size: 0.9rem;">WebRTC Engine Access</span>
                    <span style="font-weight: 600; color: var(--google-green); font-size: 0.9rem;"><i class="fa-solid fa-check"></i> Enabled</span>
                </div>
            </div>

            <div style="display: flex; gap: 0.75rem;">
                <button class="btn-google-secondary" style="flex: 1; justify-content: center;" onclick="closeModal('userProfileModal')">Close</button>
            </div>
        </div>
    </div>

    <!-- Waiting Room Modal -->
    <div class="g-modal" id="waitingRoomModal">
        <div class="g-modal-card" style="text-align: center; max-width: 460px;">
            <div class="pulse-loader-g"><i class="fa-solid fa-clock"></i></div>
            <h2 style="font-weight: 700; margin-bottom: 0.5rem;">Asking to join...</h2>
            <p style="color: var(--text-secondary); font-size: 0.95rem; margin-bottom: 1.5rem; line-height: 1.5;">
                You'll join the call when host approves your request.
            </p>
            <button class="btn-google-outline" onclick="closeModal('waitingRoomModal')">Cancel Request</button>
        </div>
    </div>

    <!-- Live Meeting Video Room Screen -->
    <div id="liveMeetingRoom">
        <!-- Live Countdown Alert Warning Banner -->
        <div id="liveCountdownAlertBanner" style="display: none; background: #dc2626; color: white; text-align: center; padding: 0.6rem 1rem; font-weight: 700; font-size: 0.9rem; z-index: 10001; box-shadow: 0 4px 12px rgba(220, 38, 38, 0.4); border-bottom: 1px solid rgba(255,255,255,0.2);">
            <i class="fa-solid fa-triangle-exclamation"></i> <span id="liveCountdownAlertText">Meeting will close in 5 minutes!</span>
        </div>

        <div class="meeting-top-bar">
            <div>
                <div style="font-weight: 600; font-size: 1.1rem;" id="liveRoomTitle">Meeting Room</div>
                <div style="font-size: 0.8rem; color: #9ca3af;" id="liveRoomSub">LiveKit Token Verified</div>
            </div>
            <div style="display: flex; align-items: center; gap: 0.75rem;">
                <div class="g-time-display" id="liveCountdownDisplay" style="background: rgba(239, 68, 68, 0.2); border-color: rgba(239, 68, 68, 0.4); color: #f87171; font-weight: 700;">
                    <i class="fa-solid fa-clock"></i> <span id="liveCountdownTimerText">--:--:--</span>
                </div>
                <button class="btn-google-outline" style="color: white; border-color: rgba(255,255,255,0.2);" onclick="copyRoomLink()"><i class="fa-solid fa-copy"></i> Copy Link</button>
            </div>
        </div>

        <div class="video-container-grid" id="liveVideoGrid">
            <!-- Streams -->
        </div>

        <div class="meeting-bottom-bar">
            <button class="bar-btn" id="mMicBtn" onclick="toggleMic()" title="Toggle Microphone"><i class="fa-solid fa-microphone"></i></button>
            <button class="bar-btn" id="mCamBtn" onclick="toggleCam()" title="Toggle Camera"><i class="fa-solid fa-video"></i></button>
            <button class="bar-btn" id="mScreenBtn" onclick="toggleScreen()" title="Share Screen"><i class="fa-solid fa-desktop"></i></button>
            <button class="bar-btn" onclick="openInCallHostControls()" title="Host Controls & Requests"><i class="fa-solid fa-user-shield"></i></button>
            <button class="bar-btn btn-hangup" onclick="leaveLiveRoom()" title="Leave Meeting"><i class="fa-solid fa-phone-slash"></i></button>
        </div>
    </div>

    <!-- In-Call Host Drawer -->
    <div class="g-modal" id="inCallHostDrawer">
        <div class="g-modal-card" style="max-width: 540px;">
            <button class="g-modal-close" onclick="closeModal('inCallHostDrawer')"><i class="fa-solid fa-xmark"></i></button>
            <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 1rem; border-bottom: 1px solid #f1f3f4; padding-bottom: 0.85rem;">
                <div>
                    <h2 style="font-weight: 700; font-size: 1.25rem;"><i class="fa-solid fa-user-shield" style="color: var(--google-blue);"></i> Host Access Control Center</h2>
                    <p style="color: var(--text-secondary); font-size: 0.85rem;">Manage real-time pending join requests and participant access.</p>
                </div>
                <button class="btn-google-secondary" style="padding: 0.4rem 0.8rem; font-size: 0.8rem;" onclick="loadInCallPendingRequests()"><i class="fa-solid fa-rotate-right"></i> Refresh</button>
            </div>

            <div id="inCallPendingContainer">
                <div style="text-align: center; color: var(--text-secondary); padding: 2rem;">
                    <i class="fa-solid fa-spinner fa-spin"></i> Checking pending join requests...
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript Application Core -->
    <script>
        function toggleMobileHeaderMenu() {
            const nav = document.getElementById('mainHeaderNavLinks');
            const btn = document.getElementById('mainMobileToggleBtn');
            if (!nav) return;
            
            nav.classList.toggle('mobile-active');
            const isExpanded = nav.classList.contains('mobile-active');
            if (btn) {
                btn.innerHTML = isExpanded ? '<i class="fa-solid fa-xmark"></i>' : '<i class="fa-solid fa-bars"></i>';
            }
        }

        function closeMobileHeaderMenu() {
            const nav = document.getElementById('mainHeaderNavLinks');
            const btn = document.getElementById('mainMobileToggleBtn');
            if (nav) nav.classList.remove('mobile-active');
            if (btn) btn.innerHTML = '<i class="fa-solid fa-bars"></i>';
        }

        let authToken = localStorage.getItem('meeting_auth_token');
        let currentUser = null;
        let selectedAccessMode = 'private';
        let invitedEmailList = [];
        let waitingPollTimer = null;
        let activeLiveRoom = null;
        let currentPortalView = 'landing';
        let currentBranding = null;

        // Clock display
        function updateClock() {
            const now = new Date();
            const str = now.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' }) + ' • ' + now.toLocaleDateString([], { weekday: 'short', month: 'short', day: 'numeric' });
            const clockEl = document.getElementById('clockDisplay');
            if (clockEl) clockEl.innerText = str;
        }
        setInterval(updateClock, 1000);
        updateClock();

        // Load branding & authentication on DOM ready
        window.addEventListener('DOMContentLoaded', () => {
            fetchPublicBranding();

            const urlParams = new URLSearchParams(window.location.search);
            const socialToken = urlParams.get('social_token');

            if (socialToken) {
                authToken = socialToken;
                localStorage.setItem('meeting_auth_token', authToken);
                window.history.replaceState({}, document.title, window.location.pathname);
            }

            if (authToken) {
                fetchProfile();
            } else {
                renderHeaderAuth();
                switchPortalView('landing');
            }
        });

        // Dynamic Public White-Label & Dynamic Landing CMS Loader
        function fetchPublicBranding() {
            fetch('/api/v1/branding/public')
                .then(res => res.json())
                .then(data => {
                    if (data.status === 'success' && data.data?.branding) {
                        currentBranding = data.data.branding;
                        applyBranding(currentBranding);
                    }
                })
                .catch(err => console.log('Public branding fetch error:', err));
        }

        function applyBranding(b) {
            if (!b) return;

            // 1. Theme Colors
            if (b.primary_color) {
                document.documentElement.style.setProperty('--google-blue', b.primary_color);
                document.documentElement.style.setProperty('--google-blue-hover', b.primary_color);
                document.documentElement.style.setProperty('--main-blue', b.primary_color);
            }

            // 2. Branding App Name & Logo
            if (b.app_name) {
                const brandText = document.getElementById('brandAppNameText');
                if (brandText) brandText.innerText = b.app_name;
                const footerText = document.getElementById('footerAppNameText');
                if (footerText) footerText.innerText = `${b.app_name} Enterprise`;
                const headTitle = document.getElementById('headTitleTag');
                if (headTitle) headTitle.innerText = `${b.app_name} - Enterprise Conferencing`;
            }
            if (b.logo_url) {
                const logoIcon = document.getElementById('brandLogoIcon');
                if (logoIcon) logoIcon.innerHTML = `<img src="${b.logo_url}" alt="Logo">`;
            }
            if (b.favicon_url) {
                const fav = document.getElementById('appFavicon');
                if (fav) fav.href = b.favicon_url;
            }

            // 3. Hero Tagline
            if (b.tagline) {
                const tag = document.getElementById('landingHeroTagline');
                if (tag) tag.innerText = b.tagline;
            }

            // 4. Dynamic About Section Content
            if (b.about_title) {
                const abtT = document.getElementById('aboutTitleText');
                if (abtT) abtT.innerText = b.about_title;
            }
            if (b.about_text) {
                const abtB = document.getElementById('aboutBodyText');
                if (abtB) abtB.innerText = b.about_text;
            }

            // 5. Dynamic Services Section Grid Rendering
            let services = b.services_json;
            if (typeof services === 'string') {
                try { services = JSON.parse(services); } catch(e) { services = []; }
            }
            if (services && Array.isArray(services) && services.length > 0) {
                const servicesGrid = document.getElementById('servicesGridContainer');
                if (servicesGrid) {
                    servicesGrid.innerHTML = services.map(s => `
                        <div class="main-card-item">
                            <div class="main-card-icon"><i class="${s.icon || 'fa-solid fa-video'}"></i></div>
                            <h3 class="main-card-title">${s.title || 'Service'}</h3>
                            <p class="main-card-text">${s.desc || ''}</p>
                        </div>
                    `).join('');
                }
            }

            // 6. Dynamic Media Section Cards Rendering
            let media = b.media_json;
            if (typeof media === 'string') {
                try { media = JSON.parse(media); } catch(e) { media = []; }
            }
            if (media && Array.isArray(media) && media.length > 0) {
                const mediaGrid = document.getElementById('mediaGridContainer');
                if (mediaGrid) {
                    mediaGrid.innerHTML = media.map(m => `
                        <div class="main-media-card">
                            <div class="main-media-img-wrapper">
                                <img src="${m.image || 'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?w=500&q=80'}" alt="${m.title}" class="main-media-card-img">
                            </div>
                            <div class="main-media-card-body">
                                <span class="main-media-tag">${m.category || 'News'} • ${m.date || ''}</span>
                                <h3 class="main-media-card-title">${m.title}</h3>
                                <a href="${m.link || '#'}" class="main-media-link">Read Full Story <i class="fa-solid fa-arrow-right"></i></a>
                            </div>
                        </div>
                    `).join('');
                }
            }

            // 7. Dynamic Contact Section Render
            if (b.contact_address) {
                const addr = document.getElementById('contactAddressText');
                if (addr) addr.innerText = b.contact_address;
            }
            if (b.contact_phone) {
                const ph = document.getElementById('contactPhoneText');
                if (ph) ph.innerText = b.contact_phone;
            }
            if (b.contact_email) {
                const em = document.getElementById('contactEmailText');
                if (em) em.innerText = b.contact_email;
            }

            // 8. Dynamic Social Handles
            let social = b.social_links_json;
            if (typeof social === 'string') {
                try { social = JSON.parse(social); } catch(e) { social = null; }
            }
            if (social && typeof social === 'object') {
                const socContainer = document.getElementById('contactSocialIconsContainer');
                if (socContainer) {
                    let socHtml = '';
                    if (social.twitter) socHtml += `<a href="${social.twitter}" target="_blank" class="contact-social-btn" title="Twitter/X"><i class="fa-brands fa-x-twitter"></i></a>`;
                    if (social.linkedin) socHtml += `<a href="${social.linkedin}" target="_blank" class="contact-social-btn" title="LinkedIn"><i class="fa-brands fa-linkedin-in"></i></a>`;
                    if (social.youtube) socHtml += `<a href="${social.youtube}" target="_blank" class="contact-social-btn" title="YouTube"><i class="fa-brands fa-youtube"></i></a>`;
                    if (social.facebook) socHtml += `<a href="${social.facebook}" target="_blank" class="contact-social-btn" title="Facebook"><i class="fa-brands fa-facebook-f"></i></a>`;
                    socContainer.innerHTML = socHtml;
                }
            }
        }

        window.addEventListener('click', (e) => {
            const dropdown = document.getElementById('profileDropdown');
            const profileBtn = document.getElementById('userProfileBtn');
            if (dropdown && dropdown.classList.contains('active') && !dropdown.contains(e.target) && !profileBtn.contains(e.target)) {
                dropdown.classList.remove('active');
            }
        });

        function toggleProfileDropdown() {
            const dropdown = document.getElementById('profileDropdown');
            if (dropdown) dropdown.classList.toggle('active');
        }

        let pendingOtpEmail = null;

        function switchAuthTab(tab) {
            const signInView = document.getElementById('authSignInView');
            const signUpView = document.getElementById('authSignUpView');
            const otpView = document.getElementById('authOtpVerifyView');
            const tabsContainer = document.getElementById('authTabsContainer');

            const signInBtn = document.getElementById('authTabSignInBtn');
            const signUpBtn = document.getElementById('authTabSignUpBtn');
            const alertBox = document.getElementById('authAlert');
            if (alertBox) alertBox.innerHTML = '';

            tabsContainer.style.display = 'flex';
            otpView.style.display = 'none';

            if (tab === 'signin') {
                signInView.style.display = 'block';
                signUpView.style.display = 'none';
                signInBtn.classList.add('active');
                signUpBtn.classList.remove('active');
            } else {
                signUpView.style.display = 'block';
                signInView.style.display = 'none';
                signUpBtn.classList.add('active');
                signInBtn.classList.remove('active');
            }
        }

        function openAuthModal(mode = 'signin') {
            const modal = document.getElementById('authModal');
            if (modal) {
                switchAuthTab(mode);
                modal.classList.add('active');

                const pendingUuid = localStorage.getItem('pending_meeting_uuid');
                const alertBox = document.getElementById('authAlert');
                if (pendingUuid && alertBox) {
                    alertBox.innerHTML = `<div style="color: var(--google-blue); font-size: 0.85rem; padding: 0.65rem 0.85rem; background: #e8f0fe; border: 1px solid #bfdbfe; border-radius: 0.5rem; margin-bottom: 0.75rem; text-align: center; font-weight: 600;"><i class="fa-solid fa-lock" style="margin-right: 0.4rem;"></i> Please Sign In or Create an Account to join meeting: <span style="font-family: monospace; color: #1e40af;">${pendingUuid}</span></div>`;
                }
            }
        }

        function handleSignIn(e) {
            e.preventDefault();
            const email = document.getElementById('signInEmail').value;
            const password = document.getElementById('signInPassword').value;
            const alertBox = document.getElementById('authAlert');
            alertBox.innerHTML = `<div style="color: var(--google-blue); font-size: 0.85rem; padding: 0.5rem; background: #e8f0fe; border-radius: 0.25rem;"><i class="fa-solid fa-spinner fa-spin"></i> Signing in...</div>`;

            fetch('/api/v1/login', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ email, password })
            })
            .then(res => res.json().then(data => ({ status: res.status, body: data })))
            .then(res => {
                const data = res.body;
                if (res.status === 200 && data.status === 'success') {
                    alertBox.innerHTML = '';
                    authToken = data.data.token;
                    localStorage.setItem('meeting_auth_token', authToken);
                    currentUser = data.data.user;
                    closeModal('authModal');
                    fetchProfile();
                } else if (data.status === 'pending_otp') {
                    pendingOtpEmail = email;
                    showOtpVerificationView(email, data.data?.otp_demo);
                } else {
                    alertBox.innerHTML = `<div style="color: var(--google-red); font-size: 0.85rem; padding: 0.5rem; background: #fce8e6; border-radius: 0.25rem;"><i class="fa-solid fa-circle-exclamation"></i> ${data.message || 'Login failed.'}</div>`;
                }
            });
        }

        function handleSignUp(e) {
            e.preventDefault();
            const name = document.getElementById('signUpName').value;
            const email = document.getElementById('signUpEmail').value;
            const password = document.getElementById('signUpPassword').value;
            const passwordConfirm = document.getElementById('signUpPasswordConfirm').value;
            const alertBox = document.getElementById('authAlert');

            if (password !== passwordConfirm) {
                alertBox.innerHTML = `<div style="color: var(--google-red); font-size: 0.85rem; padding: 0.5rem; background: #fce8e6; border-radius: 0.25rem;"><i class="fa-solid fa-circle-exclamation"></i> Passwords do not match.</div>`;
                return;
            }

            alertBox.innerHTML = `<div style="color: var(--google-blue); font-size: 0.85rem; padding: 0.5rem; background: #e8f0fe; border-radius: 0.25rem;"><i class="fa-solid fa-spinner fa-spin"></i> Creating account & sending OTP...</div>`;

            fetch('/api/v1/register', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ name, email, password })
            })
            .then(res => res.json().then(data => ({ status: res.status, body: data })))
            .then(res => {
                const data = res.body;
                if ((res.status === 201 || res.status === 200) && data.status === 'pending_otp') {
                    pendingOtpEmail = email;
                    showOtpVerificationView(email, data.data?.otp_demo);
                } else {
                    alertBox.innerHTML = `<div style="color: var(--google-red); font-size: 0.85rem; padding: 0.5rem; background: #fce8e6; border-radius: 0.25rem;"><i class="fa-solid fa-circle-exclamation"></i> ${data.message || 'Registration failed.'}</div>`;
                }
            });
        }

        function showOtpVerificationView(email, otpDemo) {
            document.getElementById('authSignInView').style.display = 'none';
            document.getElementById('authSignUpView').style.display = 'none';
            document.getElementById('authTabsContainer').style.display = 'none';
            
            const otpView = document.getElementById('authOtpVerifyView');
            otpView.style.display = 'block';
            
            document.getElementById('otpTargetEmailText').innerText = email;
            document.getElementById('otpDemoBanner').innerText = `OTP: ${otpDemo || '123456'}`;
            document.getElementById('authAlert').innerHTML = '';
        }

        function handleVerifyOtp(e) {
            e.preventDefault();
            const otp_code = document.getElementById('otpInput').value.trim();
            const alertBox = document.getElementById('authAlert');

            if (!otp_code || otp_code.length !== 6) {
                alertBox.innerHTML = `<div style="color: var(--google-red); font-size: 0.85rem; padding: 0.5rem; background: #fce8e6; border-radius: 0.25rem;"><i class="fa-solid fa-circle-exclamation"></i> Please enter a valid 6-digit OTP code.</div>`;
                return;
            }

            alertBox.innerHTML = `<div style="color: var(--google-blue); font-size: 0.85rem; padding: 0.5rem; background: #e8f0fe; border-radius: 0.25rem;"><i class="fa-solid fa-spinner fa-spin"></i> Verifying OTP code...</div>`;

            fetch('/api/v1/auth/verify-otp', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ email: pendingOtpEmail, otp_code })
            })
            .then(res => res.json().then(data => ({ status: res.status, body: data })))
            .then(res => {
                const data = res.body;
                if (res.status === 200 && data.status === 'success') {
                    alertBox.innerHTML = '';
                    authToken = data.data.token;
                    localStorage.setItem('meeting_auth_token', authToken);
                    currentUser = data.data.user;
                    closeModal('authModal');
                    fetchProfile();
                } else {
                    alertBox.innerHTML = `<div style="color: var(--google-red); font-size: 0.85rem; padding: 0.5rem; background: #fce8e6; border-radius: 0.25rem;"><i class="fa-solid fa-circle-exclamation"></i> ${data.message || 'OTP verification failed.'}</div>`;
                }
            });
        }

        function handleResendOtp(e) {
            if (e) e.preventDefault();
            const alertBox = document.getElementById('authAlert');
            alertBox.innerHTML = `<div style="color: var(--google-blue); font-size: 0.85rem; padding: 0.5rem; background: #e8f0fe; border-radius: 0.25rem;"><i class="fa-solid fa-spinner fa-spin"></i> Resending OTP code...</div>`;

            fetch('/api/v1/auth/resend-otp', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ email: pendingOtpEmail })
            })
            .then(res => res.json())
            .then(data => {
                if (data.status === 'success') {
                    document.getElementById('otpDemoBanner').innerText = `OTP: ${data.data?.otp_demo || '123456'}`;
                    alertBox.innerHTML = `<div style="color: var(--google-green); font-size: 0.85rem; padding: 0.5rem; background: #e6f4ea; border-radius: 0.25rem;"><i class="fa-solid fa-check-circle"></i> New OTP sent!</div>`;
                } else {
                    alertBox.innerHTML = `<div style="color: var(--google-red); font-size: 0.85rem; padding: 0.5rem; background: #fce8e6; border-radius: 0.25rem;"><i class="fa-solid fa-circle-exclamation"></i> ${data.message || 'Resend failed.'}</div>`;
                }
            });
        }

        function fetchProfile() {
            fetch('/api/v1/user', {
                headers: { 'Authorization': `Bearer ${authToken}` }
            })
            .then(res => res.json())
            .then(data => {
                if (data.status === 'success' || data.data?.user) {
                    currentUser = data.data.user;
                    renderHeaderAuth();

                    if (data.data.setting) {
                        applyBranding(data.data.setting);
                    }

                    // Check if pending or active meeting exists in localStorage upon login
                    const pendingUuid = localStorage.getItem('pending_meeting_uuid') || localStorage.getItem('active_meeting_uuid');
                    if (pendingUuid) {
                        joinMeetingByUuid(pendingUuid);
                    } else if (!currentPortalView) {
                        switchPortalView('landing');
                    } else {
                        switchPortalView(currentPortalView);
                    }
                } else {
                    logout();
                }
            }).catch(() => logout());
        }

        function renderHeaderAuth() {
            const container = document.getElementById('gHeaderActions');

            if (!currentUser) {
                container.innerHTML = `
                    <div class="g-time-display">${document.getElementById('clockDisplay')?.innerText || ''}</div>
                    <button class="main-icon-btn" onclick="openSearchModal()" title="Search"><i class="fa-solid fa-magnifying-glass"></i></button>
                    <div class="main-lang-selector" title="Language"><i class="fa-solid fa-globe"></i> EN <i class="fa-solid fa-chevron-down" style="font-size: 0.65rem;"></i></div>
                    <button class="btn-main-outline" id="authActionBtn" onclick="openAuthModal('signin')">Sign In</button>
                    <button class="btn-main-primary" onclick="openAuthModal('signup')">Sign Up Free</button>
                    <button class="main-mobile-toggle" id="mainMobileToggleBtn" onclick="toggleMobileHeaderMenu()" aria-label="Toggle Navigation Menu">
                        <i class="fa-solid fa-bars"></i>
                    </button>
                `;
                return;
            }

            const initial = currentUser.name ? currentUser.name.charAt(0).toUpperCase() : 'U';
            const avatarHtml = currentUser.avatar 
                ? `<img src="${currentUser.avatar}" alt="${currentUser.name}" class="user-avatar-img">`
                : `<div class="user-avatar-img">${initial}</div>`;

            let roleBadge = 'USER';
            let badgeBg = '#e8f0fe';
            let badgeColor = 'var(--google-blue)';
            let portalViewName = 'corporate_host';
            let portalButtonText = 'Host Dashboard';

            if (currentUser.role === 'super_admin') {
                roleBadge = 'SUPER ADMIN';
                badgeBg = '#f3e8ff';
                badgeColor = '#7e22ce';
                portalViewName = 'super_admin';
                portalButtonText = 'Super Admin';
            } else if (currentUser.role === 'admin') {
                roleBadge = 'SYSTEM ADMIN';
                badgeBg = '#e8f0fe';
                badgeColor = 'var(--google-blue)';
                portalViewName = 'admin';
                portalButtonText = 'Admin Console';
            } else if (currentUser.role === 'corporate') {
                roleBadge = 'CORPORATE ADMIN';
                badgeBg = '#d1fae5';
                badgeColor = '#047857';
                portalViewName = 'corporate_admin';
                portalButtonText = 'Corporate Portal';
            } else if (currentUser.account_type === 'corporate') {
                roleBadge = 'CORPORATE HOST';
                badgeBg = '#0f172a';
                badgeColor = '#60a5fa';
                portalViewName = 'corporate_host';
                portalButtonText = 'Host Dashboard';
            }

            container.innerHTML = `
                <div class="g-time-display">${document.getElementById('clockDisplay')?.innerText || ''}</div>
                
                <button class="btn-main-primary" style="padding: 0.45rem 1.1rem; font-size: 0.85rem;" onclick="switchPortalView('${portalViewName}')">
                    <i class="fa-solid fa-gauge"></i> ${portalButtonText}
                </button>

                <div style="position: relative;">
                    <button class="user-profile-btn" id="userProfileBtn" onclick="toggleProfileDropdown()">
                        ${avatarHtml}
                        <span style="font-weight: 600; font-size: 0.9rem;">${currentUser.name}</span>
                        <i class="fa-solid fa-chevron-down" style="font-size: 0.75rem; color: rgba(255,255,255,0.8);"></i>
                    </button>

                    <div class="profile-dropdown-menu" id="profileDropdown">
                        <div class="dropdown-user-header" style="display: flex; gap: 0.75rem; align-items: center; margin-bottom: 0.75rem; padding-bottom: 0.75rem; border-bottom: 1px solid #f1f3f4;">
                            ${avatarHtml}
                            <div style="overflow: hidden;">
                                <div style="font-weight: 700; font-size: 0.95rem; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; color: #0f172a;">${currentUser.name}</div>
                                <div style="font-size: 0.8rem; color: #64748b; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">${currentUser.email}</div>
                                <div style="display: inline-block; margin-top: 0.3rem; background: ${badgeBg}; color: ${badgeColor}; font-size: 0.7rem; font-weight: 700; padding: 0.15rem 0.5rem; border-radius: 9999px;">${roleBadge}</div>
                            </div>
                        </div>

                        <button class="dropdown-item-btn" onclick="switchPortalView('landing')" style="width: 100%; text-align: left; padding: 0.6rem; border: none; background: transparent; cursor: pointer; font-size: 0.9rem; border-radius: 0.5rem; display: flex; align-items: center; gap: 0.5rem; color: #334155;">
                            <i class="fa-solid fa-house" style="color: var(--main-blue);"></i> Home Landing Page
                        </button>

                        <button class="dropdown-item-btn" onclick="switchPortalView('${portalViewName}')" style="width: 100%; text-align: left; padding: 0.6rem; border: none; background: transparent; cursor: pointer; font-size: 0.9rem; border-radius: 0.5rem; display: flex; align-items: center; gap: 0.5rem; color: #334155;">
                            <i class="fa-solid fa-gauge" style="color: #10B981;"></i> ${portalButtonText}
                        </button>

                        <button class="dropdown-item-btn" onclick="openProfileModal()" style="width: 100%; text-align: left; padding: 0.6rem; border: none; background: transparent; cursor: pointer; font-size: 0.9rem; border-radius: 0.5rem; display: flex; align-items: center; gap: 0.5rem; color: #334155;">
                            <i class="fa-regular fa-id-card" style="color: var(--main-blue);"></i> User Account Details
                        </button>

                        ${(currentUser.role === 'admin' || currentUser.role === 'super_admin') ? `
                            <button class="dropdown-item-btn" onclick="openAdminSettingsModal()" style="width: 100%; text-align: left; padding: 0.6rem; border: none; background: transparent; cursor: pointer; font-size: 0.9rem; border-radius: 0.5rem; display: flex; align-items: center; gap: 0.5rem; color: #334155;">
                                <i class="fa-solid fa-sliders" style="color: #10B981;"></i> Brand & CMS Settings
                            </button>
                        ` : ''}

                        <div style="height: 1px; background: #f1f3f4; margin: 0.5rem 0;"></div>

                        <button class="dropdown-item-btn danger" onclick="logout()" style="width: 100%; text-align: left; padding: 0.6rem; border: none; background: transparent; cursor: pointer; font-size: 0.9rem; border-radius: 0.5rem; display: flex; align-items: center; gap: 0.5rem; color: #EF4444;">
                            <i class="fa-solid fa-right-from-bracket"></i> Sign out
                        </button>
                    </div>
                </div>

                <button class="main-mobile-toggle" id="mainMobileToggleBtn" onclick="toggleMobileHeaderMenu()" aria-label="Toggle Navigation Menu">
                    <i class="fa-solid fa-bars"></i>
                </button>
            `;
        }
        }

        function switchPortalView(view) {
            currentPortalView = view;
            document.querySelectorAll('.portal-view-section').forEach(el => el.style.display = 'none');

            if (view === 'super_admin') {
                document.getElementById('superAdminPanelView').style.display = 'block';
                loadSuperAdminDashboard();
            } else if (view === 'admin') {
                document.getElementById('adminPanelView').style.display = 'block';
                loadAdminDashboard();
            } else if (view === 'corporate_admin') {
                document.getElementById('corporateAdminPanelView').style.display = 'block';
                loadCorporateAdminDashboard();
            } else if (view === 'corporate_host') {
                document.getElementById('corporateDashboardView').style.display = 'block';
                loadCorporateMeetings();
            } else {
                const landing = document.getElementById('landingViewContainer') || document.getElementById('freeUserLandingView');
                if (landing) landing.style.display = 'block';
            }

            renderHeaderAuth();
        }

        function openProfileModal() {
            if (!currentUser) return;
            document.getElementById('profileDropdown')?.classList.remove('active');

            const initial = currentUser.name ? currentUser.name.charAt(0).toUpperCase() : 'U';
            const avatarContainer = document.getElementById('profileModalAvatarContainer');
            avatarContainer.innerHTML = currentUser.avatar 
                ? `<img src="${currentUser.avatar}" alt="${currentUser.name}" style="width: 80px; height: 80px; border-radius: 50%; object-fit: cover; margin: 0 auto; box-shadow: 0 4px 12px rgba(0,0,0,0.15);">`
                : `<div style="width: 80px; height: 80px; border-radius: 50%; background: var(--google-blue); color: white; display: flex; align-items: center; justify-content: center; font-size: 2.2rem; font-weight: 700; margin: 0 auto; box-shadow: 0 4px 12px rgba(26,115,232,0.3);">${initial}</div>`;

            document.getElementById('profileModalName').innerText = currentUser.name;
            document.getElementById('profileModalEmail').innerText = currentUser.email;
            document.getElementById('profileModalRole').innerText = (currentUser.role || 'user').toUpperCase();
            document.getElementById('profileModalAccountType').innerText = (currentUser.account_type || 'free').toUpperCase();
            
            const badge = document.getElementById('profileModalBadge');
            badge.innerHTML = `<span style="background: #e8f0fe; color: var(--google-blue); font-size: 0.8rem; font-weight: 700; padding: 0.3rem 0.8rem; border-radius: 9999px;"><i class="fa-solid fa-shield"></i> ${(currentUser.role || 'user').toUpperCase()}</span>`;

            document.getElementById('userProfileModal').classList.add('active');
        }

        function logout() {
            localStorage.removeItem('meeting_auth_token');
            authToken = null;
            currentUser = null;
            location.reload();
        }

        // SUPER ADMIN
        function loadSuperAdminDashboard() {
            if (!authToken) return;

            fetch('/api/v1/super-admin/reports', {
                headers: { 'Authorization': `Bearer ${authToken}` }
            })
            .then(res => res.json())
            .then(data => {
                if (data.status === 'success' && data.data?.reports) {
                    const r = data.data.reports;
                    document.getElementById('saStatAdmins').innerText = r.total_admins || 0;
                    document.getElementById('saStatCorporates').innerText = r.total_corporates || 0;
                    document.getElementById('saStatEmployees').innerText = r.total_employees || 0;
                    document.getElementById('saStatMeetings').innerText = r.active_meetings || 0;
                }
            });

            const tbody = document.getElementById('saAdminsTableBody');
            tbody.innerHTML = `<tr><td colspan="6" style="text-align: center; padding: 2rem; color: var(--text-secondary);"><i class="fa-solid fa-spinner fa-spin"></i> Fetching system admins...</td></tr>`;

            fetch('/api/v1/super-admin/admins', {
                headers: { 'Authorization': `Bearer ${authToken}` }
            })
            .then(res => res.json())
            .then(data => {
                if (data.status === 'success' && data.data?.admins) {
                    const admins = data.data.admins;
                    if (admins.length === 0) {
                        tbody.innerHTML = `<tr><td colspan="6" style="text-align: center; padding: 2rem; color: var(--text-secondary);">No System Admins created yet. Click <strong>Create System Admin</strong>.</td></tr>`;
                        return;
                    }

                    tbody.innerHTML = admins.map(a => {
                        const perms = (a.permissions || []).map(p => `<span class="status-pill admin-perm">${p}</span>`).join(' ');
                        const url = a.setting?.website_url ? `<a href="${a.setting.website_url}" target="_blank" style="color: var(--google-blue); font-weight: 500;">${a.setting.website_url}</a>` : 'Default';
                        const created = new Date(a.created_at).toLocaleDateString([], { month: 'short', day: 'numeric', year: 'numeric' });

                        return `
                            <tr>
                                <td style="font-weight: 600;">${a.name}</td>
                                <td>${a.email}</td>
                                <td>${url}</td>
                                <td>${perms || '<span style="color:#94a3b8;">None</span>'}</td>
                                <td>${created}</td>
                                <td style="text-align: right;">
                                    <button class="btn-google-secondary" style="padding: 0.35rem 0.75rem; font-size: 0.8rem;" onclick="openEditPermissionsModal(${a.id}, '${(a.permissions || []).join(',')}')">
                                        <i class="fa-solid fa-key"></i> Edit Permissions
                                    </button>
                                </td>
                            </tr>
                        `;
                    }).join('');
                }
            });
        }

        function openCreateAdminModal() {
            document.getElementById('createAdminModal').classList.add('active');
        }

        function handleCreateAdminSubmit(e) {
            e.preventDefault();
            const name = document.getElementById('caAdminName').value;
            const email = document.getElementById('caAdminEmail').value;
            const password = document.getElementById('caAdminPassword').value;
            const website_url = document.getElementById('caAdminWebsiteUrl').value;
            
            const perms = [];
            document.querySelectorAll('.ca-perm-chk:checked').forEach(c => perms.push(c.value));

            const alertBox = document.getElementById('createAdminAlert');
            alertBox.innerHTML = `<div style="color: var(--google-blue); font-size: 0.85rem; padding: 0.5rem; background: #e8f0fe; border-radius: 0.25rem;"><i class="fa-solid fa-spinner fa-spin"></i> Creating Admin & Cloned Settings...</div>`;

            fetch('/api/v1/super-admin/admins', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Authorization': `Bearer ${authToken}`
                },
                body: JSON.stringify({ name, email, password, website_url, permissions: perms })
            })
            .then(res => res.json())
            .then(data => {
                if (data.status === 'success') {
                    alertBox.innerHTML = `<div style="color: var(--google-green); font-size: 0.85rem; padding: 0.5rem; background: #e6f4ea; border-radius: 0.25rem;"><i class="fa-solid fa-check"></i> System Admin created! Cloned settings initialized.</div>`;
                    setTimeout(() => {
                        closeModal('createAdminModal');
                        loadSuperAdminDashboard();
                    }, 1000);
                } else {
                    alertBox.innerHTML = `<div style="color: var(--google-red); font-size: 0.85rem; padding: 0.5rem; background: #fce8e6; border-radius: 0.25rem;"><i class="fa-solid fa-exclamation"></i> ${data.message}</div>`;
                }
            });
        }

        function openEditPermissionsModal(adminId, permsStr) {
            document.getElementById('epTargetAdminId').value = adminId;
            const perms = permsStr ? permsStr.split(',') : [];
            document.querySelectorAll('.ep-perm-chk').forEach(c => {
                c.checked = perms.includes(c.value);
            });
            document.getElementById('editPermissionsModal').classList.add('active');
        }

        function handleUpdatePermissionsSubmit(e) {
            e.preventDefault();
            const adminId = document.getElementById('epTargetAdminId').value;
            const perms = [];
            document.querySelectorAll('.ep-perm-chk:checked').forEach(c => perms.push(c.value));

            const alertBox = document.getElementById('editPermissionsAlert');
            alertBox.innerHTML = `<div style="color: var(--google-blue); font-size: 0.85rem; padding: 0.5rem; background: #e8f0fe; border-radius: 0.25rem;"><i class="fa-solid fa-spinner fa-spin"></i> Saving permissions...</div>`;

            fetch(`/api/v1/super-admin/admins/${adminId}/permissions`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Authorization': `Bearer ${authToken}`
                },
                body: JSON.stringify({ permissions: perms })
            })
            .then(res => res.json())
            .then(data => {
                if (data.status === 'success') {
                    alertBox.innerHTML = `<div style="color: var(--google-green); font-size: 0.85rem; padding: 0.5rem; background: #e6f4ea; border-radius: 0.25rem;"><i class="fa-solid fa-check"></i> Permissions updated!</div>`;
                    setTimeout(() => {
                        closeModal('editPermissionsModal');
                        loadSuperAdminDashboard();
                    }, 800);
                }
            });
        }

        // SYSTEM ADMIN
        function loadAdminDashboard() {
            if (!authToken) return;
            const tbody = document.getElementById('admCorporatesTableBody');
            tbody.innerHTML = `<tr><td colspan="5" style="text-align: center; padding: 2rem; color: var(--text-secondary);"><i class="fa-solid fa-spinner fa-spin"></i> Loading corporate client accounts...</td></tr>`;

            fetch('/api/v1/admin/corporates', {
                headers: { 'Authorization': `Bearer ${authToken}` }
            })
            .then(res => res.json())
            .then(data => {
                if (data.status === 'success' && data.data?.corporates) {
                    const corps = data.data.corporates;
                    document.getElementById('admStatCorporates').innerText = corps.length;

                    let totalEmps = 0;
                    corps.forEach(c => totalEmps += (c.users ? c.users.length : 0));
                    document.getElementById('admStatEmployees').innerText = totalEmps;

                    if (corps.length === 0) {
                        tbody.innerHTML = `<tr><td colspan="5" style="text-align: center; padding: 2rem; color: var(--text-secondary);">No corporate accounts created yet. Click <strong>Create Corporate Account</strong>.</td></tr>`;
                        return;
                    }

                    tbody.innerHTML = corps.map(c => {
                        const adminUser = c.users && c.users.length > 0 ? c.users.find(u => u.role === 'corporate') || c.users[0] : null;
                        const adminInfo = adminUser ? `${adminUser.name} (${adminUser.email})` : 'None';
                        const created = new Date(c.created_at).toLocaleDateString([], { month: 'short', day: 'numeric', year: 'numeric' });

                        return `
                            <tr>
                                <td style="font-weight: 600; color: var(--text-primary);"><i class="fa-solid fa-building" style="color: var(--google-blue); margin-right: 0.4rem;"></i> ${c.company_name}</td>
                                <td>${c.company_email}</td>
                                <td>${adminInfo}</td>
                                <td><span class="status-pill active"><i class="fa-solid fa-check-circle"></i> Verified</span></td>
                                <td>${created}</td>
                            </tr>
                        `;
                    }).join('');
                }
            });
        }

        function openCreateCorporateModal() {
            document.getElementById('createCorporateModal').classList.add('active');
        }

        function handleCreateCorporateSubmit(e) {
            e.preventDefault();
            const company_name = document.getElementById('ccCompanyName').value;
            const company_email = document.getElementById('ccCompanyEmail').value;
            const admin_name = document.getElementById('ccAdminName').value;
            const admin_email = document.getElementById('ccAdminEmail').value;
            const admin_password = document.getElementById('ccAdminPassword').value;

            const alertBox = document.getElementById('createCorporateAlert');
            alertBox.innerHTML = `<div style="color: var(--google-blue); font-size: 0.85rem; padding: 0.5rem; background: #e8f0fe; border-radius: 0.25rem;"><i class="fa-solid fa-spinner fa-spin"></i> Provisioning Corporate Account & Admin...</div>`;

            fetch('/api/v1/admin/corporates', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Authorization': `Bearer ${authToken}`
                },
                body: JSON.stringify({ company_name, company_email, admin_name, admin_email, admin_password })
            })
            .then(res => res.json())
            .then(data => {
                if (data.status === 'success') {
                    alertBox.innerHTML = `<div style="color: var(--google-green); font-size: 0.85rem; padding: 0.5rem; background: #e6f4ea; border-radius: 0.25rem;"><i class="fa-solid fa-check"></i> Corporate Account created successfully!</div>`;
                    setTimeout(() => {
                        closeModal('createCorporateModal');
                        loadAdminDashboard();
                    }, 1000);
                } else {
                    alertBox.innerHTML = `<div style="color: var(--google-red); font-size: 0.85rem; padding: 0.5rem; background: #fce8e6; border-radius: 0.25rem;"><i class="fa-solid fa-exclamation"></i> ${data.message}</div>`;
                }
            });
        }

        // CORPORATE ADMIN
        function loadCorporateAdminDashboard() {
            if (!authToken) return;
            const tbody = document.getElementById('caEmployeesTableBody');
            tbody.innerHTML = `<tr><td colspan="5" style="text-align: center; padding: 2rem; color: var(--text-secondary);"><i class="fa-solid fa-spinner fa-spin"></i> Fetching company employee roster...</td></tr>`;

            fetch('/api/v1/corporate/employees', {
                headers: { 'Authorization': `Bearer ${authToken}` }
            })
            .then(res => res.json())
            .then(data => {
                if (data.status === 'success' && data.data?.employees) {
                    const emps = data.data.employees;
                    document.getElementById('caStatEmployees').innerText = emps.length;

                    const hosts = emps.filter(e => e.can_host_meetings).length;
                    document.getElementById('caStatHosts').innerText = hosts;

                    if (emps.length === 0) {
                        tbody.innerHTML = `<tr><td colspan="5" style="text-align: center; padding: 2rem; color: var(--text-secondary);">No company employees registered yet. Click <strong>Add New Employee</strong>.</td></tr>`;
                        return;
                    }

                    tbody.innerHTML = emps.map(e => {
                        const canHostPill = e.can_host_meetings 
                            ? `<span class="status-pill active"><i class="fa-solid fa-video"></i> Authorized Host</span>`
                            : `<span class="status-pill private"><i class="fa-solid fa-user"></i> Attendee Only</span>`;

                        const toggleBtnText = e.can_host_meetings ? 'Revoke Host Privilege' : 'Grant Host Privilege';
                        const toggleBtnClass = e.can_host_meetings ? 'btn-google-outline' : 'btn-google';

                        return `
                            <tr>
                                <td style="font-weight: 600; color: var(--text-primary);">${e.name}</td>
                                <td>${e.email}</td>
                                <td>${e.designation || 'Staff Member'}</td>
                                <td>${canHostPill}</td>
                                <td style="text-align: right;">
                                    <button class="${toggleBtnClass}" style="padding: 0.35rem 0.75rem; font-size: 0.8rem;" onclick="toggleEmployeeHosting(${e.id})">
                                        ${toggleBtnText}
                                    </button>
                                </td>
                            </tr>
                        `;
                    }).join('');
                }
            });
        }

        function openCreateEmployeeModal() {
            document.getElementById('createEmployeeModal').classList.add('active');
        }

        function handleCreateEmployeeSubmit(e) {
            e.preventDefault();
            const name = document.getElementById('ceName').value;
            const email = document.getElementById('ceEmail').value;
            const password = document.getElementById('cePassword').value;
            const designation = document.getElementById('ceDesignation').value;
            const can_host = document.getElementById('ceCanHostToggle').checked;

            const alertBox = document.getElementById('createEmployeeAlert');
            alertBox.innerHTML = `<div style="color: var(--google-blue); font-size: 0.85rem; padding: 0.5rem; background: #e8f0fe; border-radius: 0.25rem;"><i class="fa-solid fa-spinner fa-spin"></i> Registering employee...</div>`;

            fetch('/api/v1/corporate/employees', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Authorization': `Bearer ${authToken}`
                },
                body: JSON.stringify({ name, email, password, designation, can_host })
            })
            .then(res => res.json())
            .then(data => {
                if (data.status === 'success') {
                    alertBox.innerHTML = `<div style="color: var(--google-green); font-size: 0.85rem; padding: 0.5rem; background: #e6f4ea; border-radius: 0.25rem;"><i class="fa-solid fa-check"></i> Employee registered!</div>`;
                    setTimeout(() => {
                        closeModal('createEmployeeModal');
                        loadCorporateAdminDashboard();
                    }, 800);
                } else {
                    alertBox.innerHTML = `<div style="color: var(--google-red); font-size: 0.85rem; padding: 0.5rem; background: #fce8e6; border-radius: 0.25rem;"><i class="fa-solid fa-exclamation"></i> ${data.message}</div>`;
                }
            });
        }

        function toggleEmployeeHosting(employeeId) {
            fetch(`/api/v1/corporate/employees/${employeeId}/toggle-hosting`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Authorization': `Bearer ${authToken}`
                }
            })
            .then(res => res.json())
            .then(data => {
                if (data.status === 'success') {
                    loadCorporateAdminDashboard();
                }
            });
        }

        // ADMIN SETTINGS & LANDING CMS MODAL
        function switchSettingsTab(tab) {
            document.getElementById('setTabBrandView').style.display = tab === 'brand' ? 'block' : 'none';
            document.getElementById('setTabCmsView').style.display = tab === 'cms' ? 'block' : 'none';
            document.getElementById('setTabSmtpView').style.display = tab === 'smtp' ? 'block' : 'none';
            document.getElementById('setTabSmsView').style.display = tab === 'sms' ? 'block' : 'none';

            document.getElementById('tabSetBrandBtn').classList.toggle('active', tab === 'brand');
            document.getElementById('tabSetCmsBtn').classList.toggle('active', tab === 'cms');
            document.getElementById('tabSetSmtpBtn').classList.toggle('active', tab === 'smtp');
            document.getElementById('tabSetSmsBtn').classList.toggle('active', tab === 'sms');
        }

        function openAdminSettingsModal() {
            if (!authToken) return;

            fetch('/api/v1/admin/settings', {
                headers: { 'Authorization': `Bearer ${authToken}` }
            })
            .then(res => res.json())
            .then(data => {
                if (data.status === 'success' && data.data?.setting) {
                    const s = data.data.setting;
                    document.getElementById('stCompanyName').value = s.company_name || '';
                    document.getElementById('stAppName').value = s.app_name || '';
                    document.getElementById('stWebsiteUrl').value = s.website_url || '';
                    document.getElementById('stLogoUrl').value = s.logo_url || '';
                    document.getElementById('stFaviconUrl').value = s.favicon_url || '';
                    document.getElementById('stPrimaryColor').value = s.primary_color || '#1a73e8';
                    document.getElementById('stSecondaryColor').value = s.secondary_color || '#0f172a';
                    document.getElementById('stTagline').value = s.tagline || '';

                    // CMS Fields
                    document.getElementById('stAboutTitle').value = s.about_title || '';
                    document.getElementById('stAboutText').value = s.about_text || '';
                    document.getElementById('stContactAddress').value = s.contact_address || '';
                    document.getElementById('stContactPhone').value = s.contact_phone || '';
                    document.getElementById('stServicesJson').value = JSON.stringify(s.services_json || [], null, 2);
                    document.getElementById('stMediaJson').value = JSON.stringify(s.media_json || [], null, 2);
                    document.getElementById('stSocialLinksJson').value = JSON.stringify(s.social_links_json || {}, null, 2);

                    document.getElementById('stSmtpHost').value = s.smtp_host || '';
                    document.getElementById('stSmtpPort').value = s.smtp_port || '';
                    document.getElementById('stSmtpUsername').value = s.smtp_username || '';
                    document.getElementById('stSmtpPassword').value = s.smtp_password || '';
                    document.getElementById('stSmtpEncryption').value = s.smtp_encryption || 'tls';
                    document.getElementById('stSmtpFromEmail').value = s.smtp_from_email || '';

                    document.getElementById('stSmsProvider').value = s.sms_provider || '';
                    document.getElementById('stSmsApiKey').value = s.sms_api_key || '';
                    document.getElementById('stSmsApiSecret').value = s.sms_api_secret || '';
                    document.getElementById('stSmsSenderId').value = s.sms_sender_id || '';

                    document.getElementById('admStatDomainText').innerText = s.website_url || 'Default';
                }
            });

            switchSettingsTab('brand');
            document.getElementById('adminSettingsModal').classList.add('active');
        }

        function handleSaveAdminSettingsSubmit(e) {
            e.preventDefault();

            let servicesJsonParsed = [];
            let mediaJsonParsed = [];
            let socialLinksParsed = {};

            try {
                const sStr = document.getElementById('stServicesJson').value.trim();
                if (sStr) servicesJsonParsed = JSON.parse(sStr);

                const mStr = document.getElementById('stMediaJson').value.trim();
                if (mStr) mediaJsonParsed = JSON.parse(mStr);

                const socStr = document.getElementById('stSocialLinksJson').value.trim();
                if (socStr) socialLinksParsed = JSON.parse(socStr);
            } catch (err) {
                alert('JSON Format Error in Services, Media, or Social Links. Please enter valid JSON.');
                return;
            }

            const payload = {
                company_name: document.getElementById('stCompanyName').value,
                app_name: document.getElementById('stAppName').value,
                website_url: document.getElementById('stWebsiteUrl').value,
                logo_url: document.getElementById('stLogoUrl').value,
                favicon_url: document.getElementById('stFaviconUrl').value,
                primary_color: document.getElementById('stPrimaryColor').value,
                secondary_color: document.getElementById('stSecondaryColor').value,
                tagline: document.getElementById('stTagline').value,

                about_title: document.getElementById('stAboutTitle').value,
                about_text: document.getElementById('stAboutText').value,
                contact_address: document.getElementById('stContactAddress').value,
                contact_phone: document.getElementById('stContactPhone').value,
                services_json: servicesJsonParsed,
                media_json: mediaJsonParsed,
                social_links_json: socialLinksParsed,

                smtp_host: document.getElementById('stSmtpHost').value,
                smtp_port: document.getElementById('stSmtpPort').value,
                smtp_username: document.getElementById('stSmtpUsername').value,
                smtp_password: document.getElementById('stSmtpPassword').value,
                smtp_encryption: document.getElementById('stSmtpEncryption').value,
                smtp_from_email: document.getElementById('stSmtpFromEmail').value,

                sms_provider: document.getElementById('stSmsProvider').value,
                sms_api_key: document.getElementById('stSmsApiKey').value,
                sms_api_secret: document.getElementById('stSmsApiSecret').value,
                sms_sender_id: document.getElementById('stSmsSenderId').value,
            };

            const alertBox = document.getElementById('adminSettingsAlert');
            alertBox.innerHTML = `<div style="color: var(--google-blue); font-size: 0.85rem; padding: 0.5rem; background: #e8f0fe; border-radius: 0.25rem;"><i class="fa-solid fa-spinner fa-spin"></i> Saving Settings & Dynamic CMS...</div>`;

            fetch('/api/v1/admin/settings', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Authorization': `Bearer ${authToken}`
                },
                body: JSON.stringify(payload)
            })
            .then(res => res.json())
            .then(data => {
                if (data.status === 'success') {
                    alertBox.innerHTML = `<div style="color: var(--google-green); font-size: 0.85rem; padding: 0.5rem; background: #e6f4ea; border-radius: 0.25rem;"><i class="fa-solid fa-check"></i> Enterprise brand & CMS settings updated!</div>`;
                    applyBranding(data.data.setting);
                    setTimeout(() => {
                        closeModal('adminSettingsModal');
                    }, 1000);
                } else {
                    alertBox.innerHTML = `<div style="color: var(--google-red); font-size: 0.85rem; padding: 0.5rem; background: #fce8e6; border-radius: 0.25rem;"><i class="fa-solid fa-exclamation"></i> ${data.message}</div>`;
                }
            });
        }

        // HOST / USER MEETINGS
        function loadCorporateMeetings() {
            if (!authToken) return;
            const tbody = document.getElementById('corpMeetingsTableBody');
            tbody.innerHTML = `<tr><td colspan="6" style="text-align: center; padding: 2rem; color: var(--text-secondary);"><i class="fa-solid fa-spinner fa-spin"></i> Fetching corporate records...</td></tr>`;

            fetch('/api/v1/meetings', {
                headers: { 'Authorization': `Bearer ${authToken}` }
            })
            .then(res => res.json())
            .then(data => {
                if (data.status === 'success' && data.data?.hosted) {
                    const hosted = data.data.hosted;
                    document.getElementById('statHostedCount').innerText = hosted.length;
                    
                    const activeRooms = hosted.filter(m => m.status === 'active').length;
                    document.getElementById('statActiveRooms').innerText = activeRooms;

                    const scheduledRooms = hosted.filter(m => m.starts_at && new Date(m.starts_at) > new Date()).length;
                    document.getElementById('statScheduledCount').innerText = scheduledRooms;

                    if (hosted.length === 0) {
                        tbody.innerHTML = `<tr><td colspan="6" style="text-align: center; padding: 3rem; color: var(--text-secondary);">No corporate meetings created yet. Click <strong>Start Instant Conference</strong> to begin.</td></tr>`;
                        return;
                    }

                    tbody.innerHTML = hosted.map(m => {
                        const startsText = m.starts_at ? new Date(m.starts_at).toLocaleString([], { month: 'short', day: 'numeric', hour: '2-digit', minute: '2-digit' }) : 'Instant Room';
                        const visibilityBadge = m.visibility === 'private' 
                            ? `<span class="status-pill private"><i class="fa-solid fa-lock"></i> Private</span>`
                            : `<span class="status-pill public"><i class="fa-solid fa-globe"></i> Public</span>`;
                        
                        return `
                            <tr>
                                <td style="font-weight: 600; color: var(--text-primary);">${m.title}</td>
                                <td><code style="background: #f1f3f4; padding: 0.2rem 0.5rem; border-radius: 0.25rem; font-size: 0.85rem; font-family: monospace;">${m.uuid.substring(0, 13)}...</code></td>
                                <td>${visibilityBadge}</td>
                                <td><i class="fa-regular fa-clock" style="color: var(--text-secondary);"></i> ${startsText}</td>
                                <td><span class="status-pill active"><i class="fa-solid fa-user-check"></i> ${m.participants ? m.participants.length : 1} User(s)</span></td>
                                <td style="text-align: right;">
                                    <button class="btn-google" style="padding: 0.4rem 0.8rem; font-size: 0.85rem;" onclick="joinMeetingByUuid('${m.uuid}')">
                                        <i class="fa-solid fa-video"></i> Launch
                                    </button>
                                    <button class="btn-google-outline" style="padding: 0.4rem 0.8rem; font-size: 0.85rem; margin-left: 0.3rem;" onclick="copyMeetingLink('${m.uuid}')">
                                        <i class="fa-regular fa-copy"></i> Link
                                    </button>
                                </td>
                            </tr>
                        `;
                    }).join('');
                }
            });
        }

        function copyMeetingLink(uuid) {
            const fullUrl = `${window.location.origin}/meeting/${uuid}`;
            navigator.clipboard.writeText(fullUrl);
            alert(`Meeting Link Copied:\n${fullUrl}`);
        }

        function switchMeetingTab(tab) {
            document.getElementById('mTabType').value = tab;
            const instantBtn = document.getElementById('tabInstantBtn');
            const scheduleBtn = document.getElementById('tabScheduleBtn');
            const titleInput = document.getElementById('mTitle');
            const startsGroup = document.getElementById('scheduledTimeGroup');
            const headerTitle = document.getElementById('modalMeetingHeaderTitle');
            const headerSub = document.getElementById('modalMeetingHeaderSub');
            const submitBtn = document.getElementById('mSubmitBtn');

            if (tab === 'instant') {
                instantBtn.classList.add('active');
                scheduleBtn.classList.remove('active');
                startsGroup.style.display = 'none';
                headerTitle.innerText = 'Start an Instant Meeting';
                headerSub.innerText = 'Launch a WebRTC video meeting room immediately.';
                submitBtn.innerHTML = '<i class="fa-solid fa-bolt"></i> Launch Meeting Room Now';
                if (!titleInput.value) titleInput.value = 'Instant Conference Room';
            } else {
                scheduleBtn.classList.add('active');
                instantBtn.classList.remove('active');
                startsGroup.style.display = 'block';
                headerTitle.innerText = 'Schedule Meeting for Later';
                headerSub.innerText = 'Set meeting date, time, access visibility & invitation list.';
                submitBtn.innerHTML = '<i class="fa-regular fa-calendar-check"></i> Save & Schedule Meeting';
                if (!titleInput.value) titleInput.value = 'Corporate Strategy Sync';
            }
        }

        function openMeetingModal(tabMode = 'instant') {
            if (!authToken) {
                openAuthModal('signin');
                return;
            }
            switchMeetingTab(tabMode);
            document.getElementById('createMeetingModal').classList.add('active');
        }

        function setAccessMode(mode) {
            selectedAccessMode = mode;
            document.getElementById('labelPrivate').style.borderColor = mode === 'private' ? 'var(--google-blue)' : 'var(--border-color)';
            document.getElementById('labelPrivate').style.background = mode === 'private' ? 'var(--google-blue-bg)' : '#ffffff';
            
            document.getElementById('labelPublic').style.borderColor = mode === 'public' ? 'var(--google-blue)' : 'var(--border-color)';
            document.getElementById('labelPublic').style.background = mode === 'public' ? 'var(--google-blue-bg)' : '#ffffff';

            document.getElementById('privateEmailsContainer').style.display = mode === 'private' ? 'block' : 'none';
            document.getElementById('publicApprovalContainer').style.display = mode === 'public' ? 'block' : 'none';
        }

        function addEmailChip() {
            const input = document.getElementById('inviteEmailInput');
            const email = input.value.trim().toLowerCase();
            if (email && !invitedEmailList.includes(email)) {
                invitedEmailList.push(email);
                renderChips();
                input.value = '';
            }
        }

        function removeChip(email) {
            invitedEmailList = invitedEmailList.filter(e => e !== email);
            renderChips();
        }

        function renderChips() {
            document.getElementById('emailChipsList').innerHTML = invitedEmailList.map(e => `
                <div class="email-chip">${e} <i class="fa-solid fa-xmark" onclick="removeChip('${e}')"></i></div>
            `).join('');
        }

        function closeModal(id) {
            document.getElementById(id)?.classList.remove('active');
        }

        function handleCreateMeetingSubmit(e) {
            e.preventDefault();
            const tab = document.getElementById('mTabType').value;
            const title = document.getElementById('mTitle').value;
            const startsAt = document.getElementById('mStartsAt').value;
            const durationMinutes = document.getElementById('mDurationMinutes').value;

            const payload = {
                title,
                visibility: selectedAccessMode,
                approval_required: document.getElementById('mApprovalToggle').checked,
                starts_at: tab === 'schedule' && startsAt ? startsAt : null,
                duration_minutes: durationMinutes,
                invited_emails: selectedAccessMode === 'private' ? invitedEmailList : [],
            };

            fetch('/api/v1/meetings', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Authorization': `Bearer ${authToken}`
                },
                body: JSON.stringify(payload)
            })
            .then(res => res.json())
            .then(data => {
                if (data.status === 'success') {
                    closeModal('createMeetingModal');
                    const meeting = data.data.meeting;

                    if (tab === 'instant') {
                        joinMeetingByUuid(meeting.uuid);
                    } else {
                        if (currentPortalView === 'corporate_host') {
                            loadCorporateMeetings();
                        } else {
                            alert(`Meeting Scheduled Successfully!\nTitle: ${meeting.title}\nCode: ${meeting.uuid}`);
                        }
                    }
                }
            });
        }

        function handleHeroJoin() {
            const code = document.getElementById('heroMeetingCodeInput').value.trim();
            if (!code) {
                alert('Please enter a meeting code or link.');
                return;
            }
            joinMeetingByUuid(code);
        }

        function joinMeetingByUuid(uuid) {
            if (!uuid) return;
            const linkMatch = String(uuid).match(/\/meeting\/([a-zA-Z0-9\-]+)/i);
            if (linkMatch) {
                uuid = linkMatch[1];
            }

            if (!authToken) {
                localStorage.setItem('pending_meeting_uuid', uuid);
                openAuthModal('signin');
                return;
            }

            const alertBox = document.getElementById('heroAlertContainer');
            if (alertBox) {
                alertBox.innerHTML = '<div style="color: var(--google-blue); font-size: 0.9rem; padding: 0.75rem; background: #e8f0fe; border-radius: 0.5rem; margin-top: 1rem;"><i class="fa-solid fa-spinner fa-spin"></i> Validating access rules...</div>';
            }

            fetch(`/api/v1/meetings/${uuid}/join`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Authorization': `Bearer ${authToken}`
                }
            })
            .then(res => res.json().then(data => ({ status: res.status, body: data })))
            .then(res => {
                const data = res.body;
                if (alertBox) alertBox.innerHTML = '';

                if (res.status === 200 && data.status === 'success') {
                    launchLiveRoom(data.data.room, data.data.token, data.data.livekit_host);
                } else if (res.status === 202 || data.code === 'WAITING_FOR_HOST_APPROVAL') {
                    startWaitingPoll(uuid);
                } else if (res.status === 403 || data.code === 'ACCESS_DENIED') {
                    const msg = `<div style="color: var(--google-red); font-size: 0.9rem; padding: 0.75rem; background: #fce8e6; border-radius: 0.5rem; margin-top: 1rem;"><i class="fa-solid fa-circle-xmark"></i> <strong>Access Denied:</strong> ${data.message}</div>`;
                    if (alertBox) alertBox.innerHTML = msg; else alert(data.message);
                } else {
                    if (data.code === 'MEETING_EXPIRED') {
                        localStorage.removeItem('pending_meeting_uuid');
                        localStorage.removeItem('active_meeting_uuid');
                    }
                    const msg = `<div style="color: var(--google-red); font-size: 0.9rem; padding: 0.75rem; background: #fce8e6; border-radius: 0.5rem; margin-top: 1rem;"><i class="fa-solid fa-triangle-exclamation"></i> ${data.message}</div>`;
                    if (alertBox) alertBox.innerHTML = msg; else alert(data.message);
                }
            });
        }

        function startWaitingPoll(uuid) {
            document.getElementById('waitingRoomModal').classList.add('active');
            if (waitingPollTimer) clearInterval(waitingPollTimer);

            waitingPollTimer = setInterval(() => {
                fetch(`/api/v1/meetings/${uuid}/join`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Authorization': `Bearer ${authToken}`
                    }
                })
                .then(res => res.json())
                .then(data => {
                    if (data.status === 'success' && data.data?.token) {
                        clearInterval(waitingPollTimer);
                        closeModal('waitingRoomModal');
                        launchLiveRoom(data.data.room, data.data.token, data.data.livekit_host);
                    }
                });
            }, 3000);
        }

        let localMediaStream = null;
        let screenMediaStream = null;
        let isMicMuted = false;
        let isCamOff = false;
        let isScreenSharing = false;
        let activeRoomUuid = null;
        let inCallPendingTimer = null;
        let liveInRoomTimerInterval = null;

        function startLiveInRoomCountdown(roomUuid) {
            if (liveInRoomTimerInterval) clearInterval(liveInRoomTimerInterval);

            fetch(`/api/v1/meetings/${roomUuid}`, {
                headers: { 'Authorization': `Bearer ${authToken}` }
            })
            .then(res => res.json())
            .then(data => {
                if (data.status === 'success' && data.data?.remaining_seconds !== undefined) {
                    let remainingSec = data.data.remaining_seconds;
                    const alertBanner = document.getElementById('liveCountdownAlertBanner');
                    const alertText = document.getElementById('liveCountdownAlertText');
                    const timerText = document.getElementById('liveCountdownTimerText');

                    if (data.data.is_expired) {
                        localStorage.removeItem('pending_meeting_uuid');
                        localStorage.removeItem('active_meeting_uuid');
                        alert('Meeting duration has ended! Clearing localStorage and closing room.');
                        leaveLiveRoom();
                        return;
                    }

                    liveInRoomTimerInterval = setInterval(() => {
                        if (remainingSec <= 0) {
                            clearInterval(liveInRoomTimerInterval);
                            liveInRoomTimerInterval = null;
                            alert('Meeting duration expired! LocalStorage cleared and room closing.');
                            localStorage.removeItem('pending_meeting_uuid');
                            localStorage.removeItem('active_meeting_uuid');
                            leaveLiveRoom();
                            return;
                        }

                        remainingSec--;
                        const hrs = String(Math.floor(remainingSec / 3600)).padStart(2, '0');
                        const mins = String(Math.floor((remainingSec % 3600) / 60)).padStart(2, '0');
                        const secs = String(remainingSec % 60).padStart(2, '0');
                        if (timerText) timerText.innerText = `${hrs}:${mins}:${secs}`;

                        // Countdown alert triggers
                        if (remainingSec <= 300 && remainingSec > 60) {
                            if (alertBanner) alertBanner.style.display = 'block';
                            if (alertText) alertText.innerText = `Meeting Countdown Alert: Room will close in ${Math.ceil(remainingSec / 60)} minutes!`;
                        } else if (remainingSec <= 60 && remainingSec > 0) {
                            if (alertBanner) alertBanner.style.display = 'block';
                            if (alertText) alertText.innerText = `Final Warning Alert: Meeting will close in ${remainingSec} seconds!`;
                        } else {
                            if (alertBanner) alertBanner.style.display = 'none';
                        }
                    }, 1000);
                }
            });
        }

        async function launchLiveRoom(roomUuid, token, hostUrl) {
            activeRoomUuid = roomUuid;
            localStorage.setItem('active_meeting_uuid', roomUuid);
            localStorage.removeItem('pending_meeting_uuid');
            startLiveInRoomCountdown(roomUuid);

            document.getElementById('liveMeetingRoom').style.display = 'flex';
            document.getElementById('liveRoomTitle').innerText = `Meeting Room`;
            document.getElementById('liveRoomSub').innerText = `UUID: ${roomUuid} • LiveKit Token Verified`;
            
            const grid = document.getElementById('liveVideoGrid');
            grid.innerHTML = '';

            let connectedLiveKit = false;
            try {
                if (window.LivekitClient) {
                    const { Room } = LivekitClient;
                    activeLiveRoom = new Room();
                    await activeLiveRoom.connect(hostUrl, token);
                    await activeLiveRoom.localParticipant.enableCameraAndMicrophone();

                    const camTrack = activeLiveRoom.localParticipant.getTrack('camera')?.videoTrack;
                    if (camTrack) {
                        createLiveKitTile(activeLiveRoom.localParticipant.identity + ' (You - Host)', camTrack);
                        connectedLiveKit = true;
                    }
                }
            } catch (err) {
                console.log('LiveKit connection note:', err.message);
            }

            if (!connectedLiveKit) {
                try {
                    localMediaStream = await navigator.mediaDevices.getUserMedia({ video: true, audio: true });
                    createCameraTile((currentUser?.name || 'Local User') + ' (Host Preview)', localMediaStream, 'localVideoTileContainer');
                } catch (e) {
                    createAvatarTile((currentUser?.name || 'Local User') + ' (Host Audio Active)', 'Camera permission active');
                }
            }
        }

        function createCameraTile(label, stream, tileId = 'localVideoTileContainer') {
            const grid = document.getElementById('liveVideoGrid');

            const existing = document.getElementById(tileId);
            if (existing) existing.remove();

            const tile = document.createElement('div');
            tile.className = 'live-video-tile';
            tile.id = tileId;

            const video = document.createElement('video');
            video.autoplay = true;
            video.playsInline = true;
            video.muted = true;
            video.style.width = '100%';
            video.style.height = '100%';
            video.style.objectFit = tileId.includes('screen') ? 'contain' : 'cover';
            video.style.background = '#0f172a';
            video.srcObject = stream;

            const overlay = document.createElement('div');
            overlay.style.cssText = "position: absolute; bottom: 0.75rem; left: 0.75rem; background: rgba(0,0,0,0.65); color: white; padding: 0.3rem 0.7rem; border-radius: 0.375rem; font-size: 0.85rem; font-weight: 500; backdrop-filter: blur(4px); display: flex; align-items: center; gap: 0.4rem; z-index: 10;";
            const iconClass = tileId.includes('screen') ? 'fa-solid fa-desktop' : 'fa-solid fa-microphone';
            overlay.innerHTML = `<i class="${iconClass}" style="color: #10b981;"></i> ${label}`;

            tile.appendChild(video);
            tile.appendChild(overlay);
            grid.appendChild(tile);

            video.play().catch(err => console.log('Video play error:', err));
        }

        function createLiveKitTile(label, track) {
            const grid = document.getElementById('liveVideoGrid');
            const tile = document.createElement('div');
            tile.className = 'live-video-tile';
            tile.id = 'livekitTileContainer';

            const video = track.attach();
            video.style.width = '100%';
            video.style.height = '100%';
            video.style.objectFit = 'cover';

            const overlay = document.createElement('div');
            overlay.style.cssText = "position: absolute; bottom: 0.75rem; left: 0.75rem; background: rgba(0,0,0,0.65); color: white; padding: 0.3rem 0.7rem; border-radius: 0.375rem; font-size: 0.85rem; font-weight: 500; backdrop-filter: blur(4px); display: flex; align-items: center; gap: 0.4rem; z-index: 10;";
            overlay.innerHTML = `<i class="fa-solid fa-microphone" style="color: #10b981;"></i> ${label}`;

            tile.appendChild(video);
            tile.appendChild(overlay);
            grid.appendChild(tile);
        }

        function createAvatarTile(label, subnote) {
            const grid = document.getElementById('liveVideoGrid');
            const tile = document.createElement('div');
            tile.className = 'live-video-tile';
            tile.innerHTML = `
                <div style="text-align: center;">
                    <div style="width: 90px; height: 90px; border-radius: 50%; background: linear-gradient(135deg, #1a73e8, #4285f4); color: white; display: flex; align-items: center; justify-content: center; font-size: 2.5rem; margin: 0 auto 1rem auto; box-shadow: 0 4px 15px rgba(26, 115, 232, 0.4);">
                        <i class="fa-solid fa-user"></i>
                    </div>
                    <div style="font-weight: 600; font-size: 1rem; color: white;">${label}</div>
                    <div style="font-size: 0.8rem; color: #9ca3af; margin-top: 0.25rem;">${subnote}</div>
                </div>
                <div style="position: absolute; bottom: 0.75rem; left: 0.75rem; background: rgba(0,0,0,0.65); color: white; padding: 0.3rem 0.7rem; border-radius: 0.375rem; font-size: 0.85rem; backdrop-filter: blur(4px);">
                    <i class="fa-solid fa-microphone" style="color: #10b981;"></i> ${label}
                </div>
            `;
            grid.appendChild(tile);
        }

        function toggleMic() {
            isMicMuted = !isMicMuted;
            const btn = document.getElementById('mMicBtn');
            btn.classList.toggle('btn-hangup', isMicMuted);
            btn.innerHTML = isMicMuted ? '<i class="fa-solid fa-microphone-slash"></i>' : '<i class="fa-solid fa-microphone"></i>';

            if (localMediaStream) {
                localMediaStream.getAudioTracks().forEach(t => t.enabled = !isMicMuted);
            }
        }

        function toggleCam() {
            isCamOff = !isCamOff;
            const btn = document.getElementById('mCamBtn');
            btn.classList.toggle('btn-hangup', isCamOff);
            btn.innerHTML = isCamOff ? '<i class="fa-solid fa-video-slash"></i>' : '<i class="fa-solid fa-video"></i>';

            if (localMediaStream) {
                localMediaStream.getVideoTracks().forEach(t => t.enabled = !isCamOff);
            }
        }

        async function toggleScreen() {
            if (!isScreenSharing) {
                try {
                    const screenStream = await navigator.mediaDevices.getDisplayMedia({ video: true });
                    screenMediaStream = screenStream;
                    isScreenSharing = true;
                    document.getElementById('mScreenBtn').style.background = 'var(--google-blue)';
                    
                    createCameraTile((currentUser?.name || 'Local User') + ' (Screen Share)', screenStream, 'screenShareTileContainer');

                    screenStream.getVideoTracks()[0].onended = () => {
                        stopScreenSharing();
                    };
                } catch (e) {
                    console.log('Screen share cancelled');
                }
            } else {
                stopScreenSharing();
            }
        }

        function stopScreenSharing() {
            if (screenMediaStream) {
                screenMediaStream.getTracks().forEach(t => t.stop());
                screenMediaStream = null;
            }
            isScreenSharing = false;
            const btn = document.getElementById('mScreenBtn');
            if (btn) btn.style.background = '#3c4043';

            const screenTile = document.getElementById('screenShareTileContainer');
            if (screenTile) screenTile.remove();
        }

        function copyRoomLink() {
            const uuid = activeRoomUuid || localStorage.getItem('active_meeting_uuid');
            const fullUrl = uuid ? `${window.location.origin}/meeting/${uuid}` : window.location.href;
            navigator.clipboard.writeText(fullUrl);
            alert(`Meeting link copied to clipboard:\n${fullUrl}`);
        }

        function openInCallHostControls() {
            if (!activeRoomUuid) {
                alert('No active meeting room identified.');
                return;
            }
            document.getElementById('inCallHostDrawer').classList.add('active');
            loadInCallPendingRequests();

            if (inCallPendingTimer) clearInterval(inCallPendingTimer);
            inCallPendingTimer = setInterval(loadInCallPendingRequests, 3000);
        }

        function loadInCallPendingRequests() {
            if (!activeRoomUuid || !authToken) return;
            const container = document.getElementById('inCallPendingContainer');

            fetch(`/api/v1/meetings/${activeRoomUuid}/pending`, {
                headers: { 'Authorization': `Bearer ${authToken}` }
            })
            .then(res => res.json())
            .then(data => {
                if (data.status === 'success' && data.data?.pending_requests) {
                    const list = data.data.pending_requests;
                    if (list.length === 0) {
                        container.innerHTML = `
                            <div style="text-align: center; color: var(--text-secondary); padding: 2.5rem 1rem;">
                                <i class="fa-solid fa-user-check" style="font-size: 2.5rem; color: var(--google-green); margin-bottom: 0.75rem;"></i>
                                <div style="font-weight: 600; color: var(--text-primary);">No pending join requests</div>
                                <div style="font-size: 0.85rem; margin-top: 0.25rem;">Pre-invited email users join directly. Uninvited users will appear here.</div>
                            </div>
                        `;
                        return;
                    }

                    container.innerHTML = list.map(p => `
                        <div style="display: flex; align-items: center; justify-content: space-between; padding: 0.85rem; border: 1px solid var(--border-color); border-radius: 0.75rem; margin-bottom: 0.75rem; background: #ffffff;">
                            <div>
                                <div style="font-weight: 600; font-size: 0.95rem;">${p.user ? p.user.name : p.email}</div>
                                <div style="font-size: 0.8rem; color: var(--text-secondary);">${p.email}</div>
                                <div style="font-size: 0.75rem; color: var(--google-blue); font-weight: 500; margin-top: 0.2rem;"><i class="fa-solid fa-clock"></i> Waiting in entry room</div>
                            </div>
                            <div style="display: flex; gap: 0.4rem;">
                                <button class="btn-google" style="padding: 0.4rem 0.75rem; font-size: 0.8rem;" onclick="approvePendingParticipant(${p.id})">
                                    <i class="fa-solid fa-check"></i> Approve
                                </button>
                                <button class="btn-google-secondary" style="padding: 0.4rem 0.65rem; font-size: 0.8rem;" onclick="rejectPendingParticipant(${p.id})">
                                    Reject
                                </button>
                                <button class="btn-google-outline" style="padding: 0.4rem 0.65rem; font-size: 0.8rem; color: var(--google-red); border-color: #fca5a5;" onclick="blockPendingParticipant(${p.id})">
                                    Block
                                </button>
                            </div>
                        </div>
                    `).join('');
                }
            });
        }

        function approvePendingParticipant(participantId) {
            fetch(`/api/v1/meetings/${activeRoomUuid}/approve/${participantId}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Authorization': `Bearer ${authToken}`
                }
            })
            .then(res => res.json())
            .then(data => {
                if (data.status === 'success') loadInCallPendingRequests();
            });
        }

        function rejectPendingParticipant(participantId) {
            fetch(`/api/v1/meetings/${activeRoomUuid}/reject/${participantId}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Authorization': `Bearer ${authToken}`
                }
            })
            .then(res => res.json())
            .then(data => {
                if (data.status === 'success') loadInCallPendingRequests();
            });
        }

        function blockPendingParticipant(participantId) {
            fetch(`/api/v1/meetings/${activeRoomUuid}/block/${participantId}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Authorization': `Bearer ${authToken}`
                }
            })
            .then(res => res.json())
            .then(data => {
                if (data.status === 'success') loadInCallPendingRequests();
            });
        }

        function leaveLiveRoom() {
            if (inCallPendingTimer) {
                clearInterval(inCallPendingTimer);
                inCallPendingTimer = null;
            }
            if (liveInRoomTimerInterval) {
                clearInterval(liveInRoomTimerInterval);
                liveInRoomTimerInterval = null;
            }
            localStorage.removeItem('pending_meeting_uuid');
            localStorage.removeItem('active_meeting_uuid');
            const alertBanner = document.getElementById('liveCountdownAlertBanner');
            if (alertBanner) alertBanner.style.display = 'none';

            stopScreenSharing();
            if (activeLiveRoom) {
                activeLiveRoom.disconnect();
                activeLiveRoom = null;
            }
            if (localMediaStream) {
                localMediaStream.getTracks().forEach(t => t.stop());
                localMediaStream = null;
            }
            document.getElementById('liveVideoGrid').innerHTML = '';
            document.getElementById('liveMeetingRoom').style.display = 'none';
        }

        // URL Path Deep-Link Routing & Expiry Management
        let meetingCountdownInterval = null;

        function checkPendingMeetingRedirect() {
            const path = window.location.pathname;
            const match = path.match(/\/meeting\/([a-zA-Z0-9\-]+)/i);
            const urlParams = new URLSearchParams(window.location.search);
            const codeParam = urlParams.get('code');
            let targetUuid = match ? match[1] : (codeParam || localStorage.getItem('pending_meeting_uuid'));

            if (targetUuid) {
                if (codeParam) {
                    window.history.replaceState({}, document.title, window.location.pathname);
                }
                localStorage.setItem('pending_meeting_uuid', targetUuid);
                if (!authToken) {
                    openAuthModal('signin');
                } else {
                    joinMeetingByUuid(targetUuid);
                }
            }
        }

        function showMeetingDetailsModal(uuid) {
            fetch(`/api/v1/meetings/${uuid}`, {
                headers: authToken ? { 'Authorization': `Bearer ${authToken}` } : {}
            })
            .then(res => res.json())
            .then(data => {
                if (data.status === 'success' && data.data?.meeting) {
                    const m = data.data.meeting;
                    const isExpired = data.data.is_expired;
                    let remainingSec = data.data.remaining_seconds || 0;

                    if (isExpired || m.status === 'ended') {
                        localStorage.removeItem('pending_meeting_uuid');
                        alert(`Meeting Expired: "${m.title}" has already ended.`);
                        return;
                    }

                    let container = document.getElementById('webMeetingDetailsOverlay');
                    if (!container) {
                        container = document.createElement('div');
                        container.id = 'webMeetingDetailsOverlay';
                        container.style.cssText = "position: fixed; inset: 0; background: rgba(11, 25, 76, 0.85); backdrop-filter: blur(8px); z-index: 2000; display: flex; align-items: center; justify-content: center; padding: 1.5rem;";
                        document.body.appendChild(container);
                    }

                    container.style.display = 'flex';
                    container.innerHTML = `
                        <div style="background: #ffffff; border-radius: 1.25rem; max-width: 480px; width: 100%; padding: 2rem; box-shadow: 0 20px 40px rgba(0,0,0,0.3); text-align: center; position: relative;">
                            <button onclick="closeMeetingDetailsOverlay()" style="position: absolute; top: 1rem; right: 1rem; background: none; border: none; font-size: 1.25rem; color: #64748b; cursor: pointer;">&times;</button>
                            
                            <div style="width: 64px; height: 64px; border-radius: 50%; background: #EBF4FF; color: #0E71EB; display: flex; align-items: center; justify-content: center; font-size: 1.8rem; margin: 0 auto 1rem;">
                                <i class="fa-solid fa-video"></i>
                            </div>

                            <h2 style="font-size: 1.5rem; font-weight: 800; color: #0B194C; margin-bottom: 0.5rem;">${m.title}</h2>
                            <p style="font-size: 0.88rem; color: #64748b; margin-bottom: 1.25rem;">Host: <strong>${m.host?.name || 'Meeting Host'}</strong></p>

                            <div style="background: #F8FAFC; border: 1px solid #E2E8F0; border-radius: 0.75rem; padding: 1rem; margin-bottom: 1.5rem;">
                                <div style="font-size: 0.8rem; text-transform: uppercase; letter-spacing: 0.05em; font-weight: 700; color: #94a3b8; margin-bottom: 0.3rem;">Meeting Countdown Alert</div>
                                <div id="mTimerDisplay" style="font-size: 1.8rem; font-weight: 800; color: #0E71EB; font-family: monospace;">--:--:--</div>
                                <div style="font-size: 0.8rem; color: #64748b; margin-top: 0.3rem;">Status: <span style="color: #10B981; font-weight: 700;">● Active</span> | Access: <strong>${m.visibility.toUpperCase()}</strong></div>
                            </div>

                            <button onclick="startJoinFromDetails('${m.uuid}')" class="btn-main-primary" style="width: 100%; justify-content: center; padding: 0.85rem; font-size: 1rem;">
                                <i class="fa-solid fa-headset"></i> Connect to Meeting Now
                            </button>
                        </div>
                    `;

                    if (meetingCountdownInterval) clearInterval(meetingCountdownInterval);
                    meetingCountdownInterval = setInterval(() => {
                        if (remainingSec <= 0) {
                            clearInterval(meetingCountdownInterval);
                            localStorage.removeItem('pending_meeting_uuid');
                            alert('Meeting time expired. Room is closing.');
                            closeMeetingDetailsOverlay();
                            return;
                        }
                        remainingSec--;
                        const hrs = String(Math.floor(remainingSec / 3600)).padStart(2, '0');
                        const mins = String(Math.floor((remainingSec % 3600) / 60)).padStart(2, '0');
                        const secs = String(remainingSec % 60).padStart(2, '0');
                        const timerEl = document.getElementById('mTimerDisplay');
                        if (timerEl) timerEl.innerText = `${hrs}:${mins}:${secs}`;
                    }, 1000);
                }
            });
        }

        function closeMeetingDetailsOverlay() {
            const el = document.getElementById('webMeetingDetailsOverlay');
            if (el) el.style.display = 'none';
            if (meetingCountdownInterval) clearInterval(meetingCountdownInterval);
        }

        function startJoinFromDetails(uuid) {
            closeMeetingDetailsOverlay();
            joinMeetingByUuid(uuid);
        }

        window.addEventListener('DOMContentLoaded', checkPendingMeetingRedirect);
    </script>
</body>
</html>
