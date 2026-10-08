<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Master Admin Control Center - Best Recharge</title>
    <meta name="description" content="Best Recharge Master Administrator Dashboard & Meeting Analytics System.">
    <link rel="shortcut icon" href="/best_recharge.PNG" type="image/png">
    
    <!-- Google Fonts: Outfit & Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- FontAwesome 6 Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Chart.js for Dashboard Graphical Analytics -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        :root {
            --bg-dark: #070D1E;
            --bg-card: #0F172A;
            --bg-card-hover: #1E293B;
            --bg-sidebar: #091026;
            --accent-cyan: #00F2FE;
            --accent-cyan-glow: rgba(0, 242, 254, 0.35);
            --accent-blue: #4FACFE;
            --accent-purple: #7C3AED;
            --text-main: #F8FAFC;
            --text-muted: #94A3B8;
            --text-dim: #64748B;
            --border-glow: rgba(0, 242, 254, 0.2);
            --border-light: rgba(255, 255, 255, 0.08);
            --success-green: #10B981;
            --danger-red: #EF4444;
            --warning-amber: #F59E0B;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Outfit', 'Inter', -apple-system, sans-serif;
        }

        body {
            background-color: var(--bg-dark);
            color: var(--text-main);
            min-height: 100vh;
            overflow-x: hidden;
            line-height: 1.6;
        }

        /* Ambient Cyber Grid Background */
        .bg-cyber-grid {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            background-image: 
                radial-gradient(circle at 15% 15%, rgba(0, 242, 254, 0.06) 0%, transparent 40%),
                radial-gradient(circle at 85% 65%, rgba(124, 58, 237, 0.06) 0%, transparent 40%),
                linear-gradient(rgba(15, 23, 42, 0.5) 1px, transparent 1px),
                linear-gradient(90deg, rgba(15, 23, 42, 0.5) 1px, transparent 1px);
            background-size: 100% 100%, 100% 100%, 40px 40px, 40px 40px;
            z-index: -1;
            pointer-events: none;
        }

        /* LOGIN SCREEN VIEW */
        .login-wrapper {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
        }

        .login-card {
            background: rgba(15, 23, 42, 0.85);
            backdrop-filter: blur(20px);
            border: 1px solid var(--border-glow);
            border-radius: 24px;
            width: 100%;
            max-width: 460px;
            padding: 3rem 2.5rem;
            box-shadow: 0 25px 60px rgba(0, 0, 0, 0.8), 0 0 35px var(--accent-cyan-glow);
            text-align: center;
        }

        .brand-logo-img {
            height: 52px;
            width: auto;
            margin-bottom: 1.25rem;
            filter: drop-shadow(0 0 12px rgba(0, 242, 254, 0.4));
        }

        .login-title {
            font-size: 1.75rem;
            font-weight: 900;
            color: var(--text-main);
            margin-bottom: 0.35rem;
        }

        .login-subtitle {
            font-size: 0.88rem;
            color: var(--text-muted);
            margin-bottom: 2rem;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 0.45rem;
            text-align: left;
            margin-bottom: 1.15rem;
        }

        .form-label {
            font-size: 0.85rem;
            font-weight: 700;
            color: var(--text-muted);
        }

        .input-wrapper {
            position: relative;
            display: flex;
            align-items: center;
        }

        .input-icon {
            position: absolute;
            left: 1.1rem;
            color: var(--text-dim);
            font-size: 1rem;
            pointer-events: none;
        }

        .form-input, .form-select {
            width: 100%;
            background: rgba(7, 13, 30, 0.85);
            border: 1px solid var(--border-light);
            color: var(--text-main);
            padding: 0.85rem 1rem 0.85rem 2.85rem;
            border-radius: 12px;
            font-size: 0.95rem;
            font-weight: 600;
            outline: none;
            transition: all 0.2s;
        }

        .form-select {
            appearance: none;
            cursor: pointer;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%20%2394A3B8'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M19 9l-7 7-7-7'%3E%3C/path%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 1rem center;
            background-size: 1.2rem;
        }

        .form-input:focus, .form-select:focus {
            border-color: var(--accent-cyan);
            box-shadow: 0 0 15px var(--accent-cyan-glow);
        }

        .btn-login-submit {
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
            margin-top: 1.5rem;
        }

        .btn-login-submit:hover {
            transform: translateY(-2px);
            filter: brightness(1.08);
        }

        /* MASTER DASHBOARD WORKSPACE */
        .admin-dashboard-container {
            display: none;
            min-height: 100vh;
        }

        .admin-dashboard-container.active {
            display: flex;
        }

        /* Sidebar Navigation */
        .sidebar {
            width: 275px;
            background: var(--bg-sidebar);
            border-right: 1px solid var(--border-light);
            padding: 1.5rem 1.25rem;
            display: flex;
            flex-direction: column;
            flex-shrink: 0;
        }

        .sidebar-brand {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            margin-bottom: 2rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid var(--border-light);
        }

        .sidebar-brand-img {
            height: 38px;
            width: auto;
        }

        .sidebar-menu {
            list-style: none;
            display: flex;
            flex-direction: column;
            gap: 0.4rem;
            flex-grow: 1;
        }

        .sidebar-menu-btn {
            background: transparent;
            border: none;
            color: var(--text-muted);
            width: 100%;
            padding: 0.85rem 1rem;
            border-radius: 12px;
            font-size: 0.95rem;
            font-weight: 700;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 0.85rem;
            transition: all 0.2s;
            text-align: left;
        }

        .sidebar-menu-btn:hover {
            color: var(--text-main);
            background: rgba(255, 255, 255, 0.05);
        }

        .sidebar-menu-btn.active {
            background: linear-gradient(135deg, rgba(0, 242, 254, 0.15), rgba(79, 172, 254, 0.2));
            color: var(--accent-cyan);
            border: 1px solid var(--border-glow);
        }

        .sidebar-user-card {
            background: rgba(15, 23, 42, 0.8);
            border: 1px solid var(--border-light);
            border-radius: 14px;
            padding: 1rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .user-avatar-badge {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--accent-cyan), var(--accent-blue));
            color: var(--bg-dark);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 900;
            font-size: 0.9rem;
        }

        /* Main Workspace Content Layout */
        .main-content {
            flex-grow: 1;
            padding: 2rem 2.5rem;
            overflow-y: auto;
            max-height: 100vh;
        }

        .top-navbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 2rem;
            padding-bottom: 1.25rem;
            border-bottom: 1px solid var(--border-light);
        }

        .page-title {
            font-size: 1.85rem;
            font-weight: 900;
            color: var(--text-main);
            letter-spacing: -0.02em;
        }

        /* QUICK ACTION BUTTONS BAR */
        .quick-actions-bar {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 2rem;
            flex-wrap: wrap;
        }

        .btn-action-pill {
            background: rgba(15, 23, 42, 0.8);
            border: 1px solid var(--border-glow);
            color: var(--text-main);
            font-weight: 800;
            font-size: 0.9rem;
            padding: 0.65rem 1.25rem;
            border-radius: 99px;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.25s;
        }

        .btn-action-pill:hover {
            background: var(--accent-cyan);
            color: var(--bg-dark);
            box-shadow: 0 4px 20px var(--accent-cyan-glow);
            transform: translateY(-2px);
        }

        .btn-action-pill.primary-glow {
            background: linear-gradient(135deg, var(--accent-cyan), var(--accent-blue));
            color: var(--bg-dark);
            box-shadow: 0 4px 15px var(--accent-cyan-glow);
        }

        /* DASHBOARD INTERACTIVE GRID CARDS */
        .interactive-grid-6 {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1.5rem;
            margin-bottom: 2.25rem;
        }

        .grid-card-clickable {
            background: rgba(15, 23, 42, 0.7);
            border: 1px solid var(--border-light);
            border-radius: 18px;
            padding: 1.5rem;
            cursor: pointer;
            transition: all 0.25s;
            position: relative;
            overflow: hidden;
        }

        .grid-card-clickable:hover {
            border-color: var(--accent-cyan);
            transform: translateY(-4px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.5), 0 0 20px var(--accent-cyan-glow);
        }

        .grid-card-clickable::after {
            content: 'Click for details \u2192';
            position: absolute;
            bottom: 0.75rem;
            right: 1rem;
            font-size: 0.72rem;
            font-weight: 800;
            color: var(--accent-cyan);
            opacity: 0;
            transition: opacity 0.2s;
        }

        .grid-card-clickable:hover::after {
            opacity: 1;
        }

        .card-header-flex {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 0.75rem;
        }

        .card-lbl {
            font-size: 0.82rem;
            font-weight: 800;
            color: var(--text-muted);
            text-transform: uppercase;
        }

        .card-icon-box {
            width: 42px;
            height: 42px;
            border-radius: 12px;
            background: rgba(0, 242, 254, 0.12);
            color: var(--accent-cyan);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
        }

        .card-val-big {
            font-size: 2.1rem;
            font-weight: 900;
            color: var(--text-main);
            letter-spacing: -0.02em;
        }

        .card-sub-tag {
            font-size: 0.78rem;
            font-weight: 700;
            color: var(--success-green);
            margin-top: 0.25rem;
        }

        /* GRAPHICAL CHARTS SECTION */
        .charts-row-2 {
            display: grid;
            grid-template-columns: 1.6fr 1fr;
            gap: 1.5rem;
            margin-bottom: 2.25rem;
        }

        .chart-box-card {
            background: rgba(15, 23, 42, 0.75);
            border: 1px solid var(--border-light);
            border-radius: 20px;
            padding: 1.75rem;
        }

        .chart-card-title {
            font-size: 1.1rem;
            font-weight: 800;
            color: var(--text-main);
            margin-bottom: 1.25rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        /* REPORT DATE FILTER BAR */
        .report-filter-bar {
            background: rgba(7, 13, 30, 0.8);
            border: 1px solid var(--border-glow);
            border-radius: 16px;
            padding: 1.25rem 1.5rem;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: flex-end;
            gap: 1.25rem;
            flex-wrap: wrap;
        }

        .filter-field {
            display: flex;
            flex-direction: column;
            gap: 0.35rem;
            flex: 1;
            min-width: 160px;
        }

        .filter-label {
            font-size: 0.78rem;
            font-weight: 800;
            color: var(--text-muted);
            text-transform: uppercase;
        }

        .filter-input {
            width: 100%;
            background: rgba(15, 23, 42, 0.9);
            border: 1px solid var(--border-light);
            color: var(--text-main);
            padding: 0.65rem 0.85rem;
            border-radius: 10px;
            font-size: 0.9rem;
            font-weight: 600;
            outline: none;
        }

        /* DATA TABLES */
        .data-table-card {
            background: rgba(15, 23, 42, 0.75);
            border: 1px solid var(--border-light);
            border-radius: 20px;
            padding: 1.75rem;
            margin-bottom: 2.25rem;
            overflow-x: auto;
        }

        .table-header-flex {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1.25rem;
        }

        .table-title {
            font-size: 1.2rem;
            font-weight: 800;
            color: var(--text-main);
            display: flex;
            align-items: center;
            gap: 0.6rem;
        }

        .table-title i { color: var(--accent-cyan); }

        .custom-table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
        }

        .custom-table th {
            background: rgba(7, 13, 30, 0.85);
            color: var(--text-muted);
            font-size: 0.8rem;
            font-weight: 800;
            text-transform: uppercase;
            padding: 0.85rem 1rem;
            border-bottom: 1px solid var(--border-light);
        }

        .custom-table td {
            padding: 1rem;
            border-bottom: 1px solid var(--border-light);
            font-size: 0.9rem;
            font-weight: 600;
            color: var(--text-main);
        }

        .custom-table tr:hover {
            background: rgba(255, 255, 255, 0.03);
        }

        .status-pill {
            font-size: 0.75rem;
            font-weight: 800;
            padding: 0.25rem 0.65rem;
            border-radius: 99px;
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
        }

        .status-success { background: rgba(16, 185, 129, 0.15); color: var(--success-green); }
        .status-pending { background: rgba(245, 158, 11, 0.15); color: var(--warning-amber); }
        .status-failed { background: rgba(239, 68, 68, 0.15); color: var(--danger-red); }

        .action-btn-sm {
            background: rgba(0, 242, 254, 0.1);
            border: 1px solid var(--border-glow);
            color: var(--accent-cyan);
            font-size: 0.78rem;
            font-weight: 800;
            padding: 0.35rem 0.75rem;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.2s;
            margin-right: 0.3rem;
        }

        .action-btn-sm:hover {
            background: var(--accent-cyan);
            color: var(--bg-dark);
        }

        /* MODALS */
        .modal-backdrop {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            background: rgba(0, 0, 0, 0.8);
            backdrop-filter: blur(8px);
            z-index: 2000;
            display: none;
            align-items: center;
            justify-content: center;
            padding: 1.5rem;
        }

        .modal-backdrop.active {
            display: flex;
        }

        .modal-box {
            background: #0F172A;
            border: 1px solid var(--border-glow);
            border-radius: 24px;
            width: 100%;
            max-width: 580px;
            padding: 2.25rem;
            box-shadow: 0 25px 60px rgba(0, 0, 0, 0.8);
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
        }

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

        .tab-panel-section {
            display: none;
        }

        .tab-panel-section.active {
            display: block;
        }
    </style>
</head>
<body>

    <!-- Cyber Background Grid -->
    <div class="bg-cyber-grid"></div>

    <!-- 1. LOGIN SCREEN VIEW -->
    <div class="login-wrapper" id="masterLoginWrapper">
        <div class="login-card">
            <img src="/best_recharge.PNG" alt="Best Recharge Master Admin" class="brand-logo-img">
            <h1 class="login-title">Master Admin Portal</h1>
            <p class="login-subtitle">System Administrator & Control Center</p>

            <form onsubmit="handleMasterLogin(event)">
                <div class="form-group">
                    <label class="form-label">Master Admin Email</label>
                    <div class="input-wrapper">
                        <i class="fa-solid fa-user-shield input-icon"></i>
                        <input type="email" class="form-input" id="adminEmail" value="superadmin@meetingpulse.com" required>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Master Password</label>
                    <div class="input-wrapper">
                        <i class="fa-solid fa-lock input-icon"></i>
                        <input type="password" class="form-input" id="adminPassword" value="adminpassword123" required>
                    </div>
                </div>

                <button type="submit" class="btn-login-submit">
                    <i class="fa-solid fa-key"></i> Authenticate & Enter Portal
                </button>
            </form>
        </div>
    </div>

    <!-- 2. MASTER DASHBOARD WORKSPACE -->
    <div class="admin-dashboard-container" id="masterDashboardWrapper">
        
        <!-- Sidebar Navigation -->
        <aside class="sidebar">
            <div class="sidebar-brand">
                <img src="/best_recharge.PNG" alt="Best Recharge" class="sidebar-brand-img">
            </div>

            <ul class="sidebar-menu">
                <li>
                    <button class="sidebar-menu-btn active" id="btnSideDashboard" onclick="switchAdminTab('dashboard')">
                        <i class="fa-solid fa-chart-line"></i> Dashboard
                    </button>
                </li>
                <li>
                    <button class="sidebar-menu-btn" id="btnSideUsers" onclick="switchAdminTab('users')">
                        <i class="fa-solid fa-users"></i> User Manager
                    </button>
                </li>
                <li>
                    <button class="sidebar-menu-btn" id="btnSideMeetings" onclick="switchAdminTab('meetings')">
                        <i class="fa-solid fa-video"></i> Meetings & Attendance
                    </button>
                </li>
                <li>
                    <button class="sidebar-menu-btn" id="btnSideRecharges" onclick="switchAdminTab('recharges')">
                        <i class="fa-solid fa-receipt"></i> Recharge & Bill History
                    </button>
                </li>
                <li>
                    <button class="sidebar-menu-btn" id="btnSidePassbook" onclick="switchAdminTab('passbook')">
                        <i class="fa-solid fa-wallet"></i> Wallet & Add Fund History
                    </button>
                </li>
                <li>
                    <button class="sidebar-menu-btn" id="btnSideReports" onclick="switchAdminTab('reports')">
                        <i class="fa-solid fa-file-invoice"></i> Reports & Export
                    </button>
                </li>
            </ul>

            <div class="sidebar-user-card">
                <div style="display: flex; align-items: center; gap: 0.75rem;">
                    <div class="user-avatar-badge">M</div>
                    <div>
                        <div style="font-weight: 800; font-size: 0.88rem; color: var(--text-main);">Master Admin</div>
                        <div style="font-size: 0.75rem; color: var(--accent-cyan);">Super Administrator</div>
                    </div>
                </div>
                <button onclick="handleAdminLogout()" style="background: transparent; border: none; color: var(--danger-red); cursor: pointer; font-size: 1.1rem;" title="Logout">
                    <i class="fa-solid fa-right-from-bracket"></i>
                </button>
            </div>
        </aside>

        <!-- Main Workspace -->
        <main class="main-content">
            <div class="top-navbar">
                <div>
                    <h2 class="page-title" id="adminTabTitle">Master Dashboard Overview</h2>
                    <p style="font-size: 0.88rem; color: var(--text-muted);">Real-time metrics, meeting participant reports, and financial controls</p>
                </div>

                <div style="display: flex; align-items: center; gap: 1rem;">
                    <div class="badge-system-ok">
                        <i class="fa-solid fa-circle"></i> API Engine: 99.99% Active
                    </div>
                </div>
            </div>

            <!-- QUICK ACTION BUTTONS BAR -->
            <div class="quick-actions-bar">
                <button class="btn-action-pill primary-glow" onclick="openAdminModal('modalAddFund')">
                    <i class="fa-solid fa-plus-circle"></i> Add Fund to User
                </button>
                <button class="btn-action-pill" onclick="openAdminModal('modalMobileRecharge')">
                    <i class="fa-solid fa-mobile-screen"></i> Mobile Recharge
                </button>
                <button class="btn-action-pill" onclick="openAdminModal('modalDthRecharge')">
                    <i class="fa-solid fa-tv"></i> DTH Recharge
                </button>
                <button class="btn-action-pill" onclick="openAdminModal('modalBillPay')">
                    <i class="fa-solid fa-file-invoice-dollar"></i> Bill Payment
                </button>
                <button class="btn-action-pill" onclick="openAdminModal('modalCreateUser')">
                    <i class="fa-solid fa-user-plus"></i> Create User
                </button>
            </div>

            <!-- TAB PANEL 1: MAIN DASHBOARD -->
            <div class="tab-panel-section active" id="tab-dashboard">
                
                <!-- INTERACTIVE GRID CARDS (CLICKING OPENS RELATED PAGES) -->
                <div class="interactive-grid-6">
                    <!-- Total Users Card -->
                    <div class="grid-card-clickable" onclick="switchAdminTab('users')">
                        <div class="card-header-flex">
                            <span class="card-lbl">Total Users</span>
                            <div class="card-icon-box"><i class="fa-solid fa-users"></i></div>
                        </div>
                        <div class="card-val-big" id="cntTotalUsers">1,248</div>
                        <div class="card-sub-tag"><i class="fa-solid fa-user-check"></i> Free & Corporate Accounts</div>
                    </div>

                    <!-- Total User Balance Card -->
                    <div class="grid-card-clickable" onclick="switchAdminTab('passbook')">
                        <div class="card-header-flex">
                            <span class="card-lbl">Total User Balance</span>
                            <div class="card-icon-box"><i class="fa-solid fa-wallet"></i></div>
                        </div>
                        <div class="card-val-big" id="cntTotalUserBalance">₹4,85,920.00</div>
                        <div class="card-sub-tag"><i class="fa-solid fa-vault"></i> Aggregate Passbook Ledger</div>
                    </div>

                    <!-- Total Meetings Card -->
                    <div class="grid-card-clickable" onclick="switchAdminTab('meetings')">
                        <div class="card-header-flex">
                            <span class="card-lbl">Total Meetings</span>
                            <div class="card-icon-box"><i class="fa-solid fa-video"></i></div>
                        </div>
                        <div class="card-val-big" id="cntTotalMeetings">412</div>
                        <div class="card-sub-tag"><i class="fa-solid fa-calendar-days"></i> Overall Session Count</div>
                    </div>

                    <!-- Completed Meetings Card -->
                    <div class="grid-card-clickable" onclick="filterMeetings('completed')">
                        <div class="card-header-flex">
                            <span class="card-lbl">Completed Meetings</span>
                            <div class="card-icon-box" style="background: rgba(16, 185, 129, 0.15); color: var(--success-green);"><i class="fa-solid fa-circle-check"></i></div>
                        </div>
                        <div class="card-val-big" style="color: var(--success-green);" id="cntCompletedMeetings">284</div>
                        <div class="card-sub-tag" style="color: var(--success-green);">Successfully Finished</div>
                    </div>

                    <!-- Scheduled Meetings Card -->
                    <div class="grid-card-clickable" onclick="filterMeetings('scheduled')">
                        <div class="card-header-flex">
                            <span class="card-lbl">Scheduled Meetings</span>
                            <div class="card-icon-box" style="background: rgba(245, 158, 11, 0.15); color: var(--warning-amber);"><i class="fa-solid fa-clock"></i></div>
                        </div>
                        <div class="card-val-big" style="color: var(--warning-amber);" id="cntScheduledMeetings">96</div>
                        <div class="card-sub-tag" style="color: var(--warning-amber);">Upcoming Active Sessions</div>
                    </div>

                    <!-- Expired Meetings Card -->
                    <div class="grid-card-clickable" onclick="filterMeetings('expired')">
                        <div class="card-header-flex">
                            <span class="card-lbl">Expired Meetings</span>
                            <div class="card-icon-box" style="background: rgba(239, 68, 68, 0.15); color: var(--danger-red);"><i class="fa-solid fa-calendar-xmark"></i></div>
                        </div>
                        <div class="card-val-big" style="color: var(--danger-red);" id="cntExpiredMeetings">32</div>
                        <div class="card-sub-tag" style="color: var(--danger-red);">Passed Schedule Window</div>
                    </div>
                </div>

                <!-- CHARTS ROW -->
                <div class="charts-row-2">
                    <div class="chart-box-card">
                        <div class="chart-card-title">
                            <span><i class="fa-solid fa-chart-area" style="color: var(--accent-cyan);"></i> Transaction Volume & Revenue</span>
                            <span style="font-size: 0.8rem; color: var(--text-muted);">Last 7 Days</span>
                        </div>
                        <canvas id="chartRevenue" height="110"></canvas>
                    </div>

                    <div class="chart-box-card">
                        <div class="chart-card-title">
                            <span><i class="fa-solid fa-chart-pie" style="color: var(--accent-cyan);"></i> Meetings Status Overview</span>
                        </div>
                        <canvas id="chartMeetings" height="170"></canvas>
                    </div>
                </div>

                <!-- RECENT RECHARGES LOG SUMMARY -->
                <div class="data-table-card">
                    <div class="table-header-flex">
                        <h3 class="table-title"><i class="fa-solid fa-receipt"></i> Recent Utility Recharges & Payments</h3>
                        <button class="action-btn-sm" onclick="switchAdminTab('recharges')">View Full Log &rarr;</button>
                    </div>

                    <table class="custom-table">
                        <thead>
                            <tr>
                                <th>Txn ID</th>
                                <th>User</th>
                                <th>Service</th>
                                <th>Target Number</th>
                                <th>Amount</th>
                                <th>Status</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody id="recentTxnTableBody">
                            <tr>
                                <td>REC998120</td>
                                <td>Rahul Sharma</td>
                                <td>Mobile Prepaid</td>
                                <td>9876543210 (Airtel)</td>
                                <td>₹299.00</td>
                                <td><span class="status-pill status-success"><i class="fa-solid fa-circle-check"></i> Success</span></td>
                                <td>Today, 02:45 PM</td>
                            </tr>
                            <tr>
                                <td>REC998121</td>
                                <td>Amit Verma</td>
                                <td>DTH Connection</td>
                                <td>1029837482 (Tata Play)</td>
                                <td>₹499.00</td>
                                <td><span class="status-pill status-success"><i class="fa-solid fa-circle-check"></i> Success</span></td>
                                <td>Today, 01:15 PM</td>
                            </tr>
                            <tr>
                                <td>REC998122</td>
                                <td>Neha Singh</td>
                                <td>Electricity Bill</td>
                                <td>CA-8839201 (BESCOM)</td>
                                <td>₹1,840.00</td>
                                <td><span class="status-pill status-success"><i class="fa-solid fa-circle-check"></i> Success</span></td>
                                <td>Today, 11:30 AM</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

            </div>

            <!-- TAB PANEL 2: USER MANAGER -->
            <div class="tab-panel-section" id="tab-users">
                <div class="table-header-flex">
                    <h3 class="table-title"><i class="fa-solid fa-users-gear"></i> User Manager</h3>
                    <div>
                        <button class="btn-action-pill primary-glow" onclick="openAdminModal('modalCreateUser')">
                            <i class="fa-solid fa-user-plus"></i> Add Free / Corporate User
                        </button>
                    </div>
                </div>

                <div class="data-table-card">
                    <table class="custom-table">
                        <thead>
                            <tr>
                                <th>User ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Account Type</th>
                                <th>Role</th>
                                <th>Wallet Balance</th>
                                <th>Login Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="userTableBody">
                            <tr>
                                <td>#USR-101</td>
                                <td>Rahul Sharma</td>
                                <td>rahul@gmail.com</td>
                                <td><span class="status-pill status-success">Free User</span></td>
                                <td>free_user</td>
                                <td style="color: var(--accent-cyan); font-weight: 800;">₹1,250.00</td>
                                <td><span class="status-pill status-success">Active</span></td>
                                <td>
                                    <button class="action-btn-sm" onclick="quickAddFundModal('rahul@gmail.com')">+ Fund</button>
                                    <button class="action-btn-sm" onclick="editUserModal('#USR-101')">Edit</button>
                                    <button class="action-btn-sm" style="color: var(--danger-red);" onclick="toggleUserLoginStatus('#USR-101')">Block</button>
                                </td>
                            </tr>
                            <tr>
                                <td>#USR-102</td>
                                <td>Priya Patel (TechCorp)</td>
                                <td>priya@techcorp.com</td>
                                <td><span class="status-pill status-pending">Corporate</span></td>
                                <td>corporate_employee</td>
                                <td style="color: var(--accent-cyan); font-weight: 800;">₹14,500.00</td>
                                <td><span class="status-pill status-success">Active</span></td>
                                <td>
                                    <button class="action-btn-sm" onclick="quickAddFundModal('priya@techcorp.com')">+ Fund</button>
                                    <button class="action-btn-sm" onclick="editUserModal('#USR-102')">Edit</button>
                                    <button class="action-btn-sm" style="color: var(--danger-red);" onclick="toggleUserLoginStatus('#USR-102')">Block</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- TAB PANEL 3: MEETINGS MANAGER & JOINED PARTICIPANTS REPORT -->
            <div class="tab-panel-section" id="tab-meetings">
                <div class="table-header-flex">
                    <h3 class="table-title"><i class="fa-solid fa-video"></i> Meetings & Joined User Report</h3>
                    <div style="display: flex; gap: 0.5rem;">
                        <button class="action-btn-sm" onclick="filterMeetings('all')">All Meetings</button>
                        <button class="action-btn-sm" onclick="filterMeetings('completed')">Completed</button>
                        <button class="action-btn-sm" onclick="filterMeetings('scheduled')">Scheduled</button>
                        <button class="action-btn-sm" onclick="filterMeetings('expired')">Expired</button>
                    </div>
                </div>

                <div class="data-table-card">
                    <table class="custom-table">
                        <thead>
                            <tr>
                                <th>Meeting Title & UUID</th>
                                <th>Host Name</th>
                                <th>Status</th>
                                <th>Price (₹)</th>
                                <th>Joined Users</th>
                                <th>Total Revenue</th>
                                <th>Date & Time</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="meetingsTableBody">
                            <tr>
                                <td>
                                    <div style="font-weight: 800; color: var(--text-main);">Quarterly Product & Tech Sync</div>
                                    <div style="font-size: 0.78rem; color: var(--text-muted);">MTG-882910 • Public</div>
                                </td>
                                <td>Executive Corporate Host</td>
                                <td><span class="status-pill status-success"><i class="fa-solid fa-circle-check"></i> Completed</span></td>
                                <td style="font-weight: 800;">₹500.00</td>
                                <td style="color: var(--accent-cyan); font-weight: 800;">14 Joined Users</td>
                                <td style="color: var(--success-green); font-weight: 900;">₹7,000.00</td>
                                <td>Today, 10:00 AM</td>
                                <td>
                                    <button class="action-btn-sm" onclick="viewMeetingParticipants('Quarterly Product & Tech Sync', 'MTG-882910', 14, 7000)"><i class="fa-solid fa-users-between-lines"></i> View Joined Users</button>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div style="font-weight: 800; color: var(--text-main);">B2B Distributor Onboarding Webinar</div>
                                    <div style="font-size: 0.78rem; color: var(--text-muted);">MTG-993812 • Private</div>
                                </td>
                                <td>System Super Admin</td>
                                <td><span class="status-pill status-pending"><i class="fa-solid fa-clock"></i> Scheduled</span></td>
                                <td style="font-weight: 800;">Free</td>
                                <td style="color: var(--accent-cyan); font-weight: 800;">45 Registered</td>
                                <td style="color: var(--success-green); font-weight: 900;">₹0.00</td>
                                <td>Tomorrow, 04:00 PM</td>
                                <td>
                                    <button class="action-btn-sm" onclick="viewMeetingParticipants('B2B Distributor Onboarding Webinar', 'MTG-993812', 45, 0)"><i class="fa-solid fa-users-between-lines"></i> View Joined Users</button>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div style="font-weight: 800; color: var(--text-main);">API Integration Technical Workshop</div>
                                    <div style="font-size: 0.78rem; color: var(--text-muted);">MTG-771239 • Public</div>
                                </td>
                                <td>Rahul Sharma</td>
                                <td><span class="status-pill status-failed"><i class="fa-solid fa-circle-xmark"></i> Expired</span></td>
                                <td style="font-weight: 800;">₹250.00</td>
                                <td style="color: var(--accent-cyan); font-weight: 800;">8 Joined Users</td>
                                <td style="color: var(--success-green); font-weight: 900;">₹2,000.00</td>
                                <td>05 Oct 2026</td>
                                <td>
                                    <button class="action-btn-sm" onclick="viewMeetingParticipants('API Integration Technical Workshop', 'MTG-771239', 8, 2000)"><i class="fa-solid fa-users-between-lines"></i> View Joined Users</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- TAB PANEL 4: RECHARGE & BILL HISTORY -->
            <div class="tab-panel-section" id="tab-recharges">
                <div class="table-header-flex">
                    <h3 class="table-title"><i class="fa-solid fa-receipt"></i> Recharge & Bill Payment History</h3>
                </div>

                <div class="data-table-card">
                    <table class="custom-table">
                        <thead>
                            <tr>
                                <th>Order ID</th>
                                <th>User Email</th>
                                <th>Service Type</th>
                                <th>Number / Account ID</th>
                                <th>Amount</th>
                                <th>Status</th>
                                <th>Date & Time</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>REC998120</td>
                                <td>rahul@gmail.com</td>
                                <td>Mobile Recharge</td>
                                <td>9876543210</td>
                                <td>₹299.00</td>
                                <td><span class="status-pill status-success">Success</span></td>
                                <td>08 Oct 2026, 02:45 PM</td>
                            </tr>
                            <tr>
                                <td>REC998121</td>
                                <td>priya@techcorp.com</td>
                                <td>DTH Recharge</td>
                                <td>1029837482</td>
                                <td>₹499.00</td>
                                <td><span class="status-pill status-success">Success</span></td>
                                <td>08 Oct 2026, 01:15 PM</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- TAB PANEL 5: WALLET & ADD FUND HISTORY -->
            <div class="tab-panel-section" id="tab-passbook">
                <div class="table-header-flex">
                    <h3 class="table-title"><i class="fa-solid fa-wallet"></i> Wallet & Add Fund History (Passbook)</h3>
                </div>

                <div class="data-table-card">
                    <table class="custom-table">
                        <thead>
                            <tr>
                                <th>Txn ID</th>
                                <th>User Name</th>
                                <th>Type</th>
                                <th>Pre-Balance</th>
                                <th>Amount</th>
                                <th>Post-Balance</th>
                                <th>Details</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>PB-100293</td>
                                <td>Rahul Sharma</td>
                                <td><span class="status-pill status-success">CR (Credit)</span></td>
                                <td>₹750.00</td>
                                <td>₹500.00</td>
                                <td>₹1,250.00</td>
                                <td>Admin Fund Credit via Master Panel</td>
                                <td>08 Oct 2026, 12:30 PM</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- TAB PANEL 6: REPORTS & EXPORT -->
            <div class="tab-panel-section" id="tab-reports">
                <div class="table-header-flex">
                    <h3 class="table-title"><i class="fa-solid fa-file-invoice"></i> Custom Reports Generator & Export</h3>
                </div>

                <!-- REPORT DATE FILTER BAR -->
                <div class="report-filter-bar">
                    <div class="filter-field">
                        <span class="filter-label">From Date</span>
                        <input type="date" class="filter-input" id="reportFromDate" value="2026-10-01">
                    </div>

                    <div class="filter-field">
                        <span class="filter-label">To Date</span>
                        <input type="date" class="filter-input" id="reportToDate" value="2026-10-08">
                    </div>

                    <div class="filter-field">
                        <span class="filter-label">Report Type</span>
                        <select class="filter-input" id="reportCategory">
                            <option value="all">All Transactions & Meetings</option>
                            <option value="meetings">Meeting Participants & Revenue</option>
                            <option value="recharge">Recharge & Bill Payments</option>
                            <option value="add_fund">Add Fund & Passbook</option>
                            <option value="users">User Balances Ledger</option>
                        </select>
                    </div>

                    <button class="btn-action-pill primary-glow" onclick="generateReportData()">
                        <i class="fa-solid fa-filter"></i> Apply Filter
                    </button>
                    <button class="btn-action-pill" onclick="exportReportToCSV()">
                        <i class="fa-solid fa-file-csv"></i> Export CSV
                    </button>
                    <button class="btn-action-pill" onclick="window.print()">
                        <i class="fa-solid fa-print"></i> Print PDF
                    </button>
                </div>

                <div class="data-table-card">
                    <table class="custom-table" id="reportResultsTable">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Reference / Meeting ID</th>
                                <th>User Account / Host</th>
                                <th>Category / Meeting Title</th>
                                <th>Amount / Revenue</th>
                                <th>Status / Joined Users</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>2026-10-08</td>
                                <td>MTG-882910</td>
                                <td>Executive Host</td>
                                <td>Quarterly Product Sync</td>
                                <td>₹7,000.00</td>
                                <td><span class="status-pill status-success">14 Joined Users</span></td>
                            </tr>
                            <tr>
                                <td>2026-10-08</td>
                                <td>REC998120</td>
                                <td>rahul@gmail.com</td>
                                <td>Mobile Recharge</td>
                                <td>₹299.00</td>
                                <td><span class="status-pill status-success">Success</span></td>
                            </tr>
                            <tr>
                                <td>2026-10-08</td>
                                <td>PB-100293</td>
                                <td>rahul@gmail.com</td>
                                <td>Add Fund (Credit)</td>
                                <td>₹500.00</td>
                                <td><span class="status-pill status-success">Completed</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

        </main>
    </div>

    <!-- MODAL: VIEW MEETING JOINED PARTICIPANTS -->
    <div class="modal-backdrop" id="modalViewParticipants">
        <div class="modal-box" style="max-width: 720px;">
            <button class="modal-close-btn" onclick="closeAdminModal('modalViewParticipants')"><i class="fa-solid fa-xmark"></i></button>
            <h3 class="table-title" style="margin-bottom: 0.25rem;" id="partModalTitle"><i class="fa-solid fa-users-rectangle"></i> Meeting Joined Users</h3>
            <p style="font-size: 0.85rem; color: var(--text-muted); margin-bottom: 1.25rem;" id="partModalSub">Detailed attendance ledger & ticket payments</p>

            <div style="background: rgba(7, 13, 30, 0.8); border: 1px solid var(--border-glow); padding: 1rem; border-radius: 14px; display: flex; justify-content: space-around; margin-bottom: 1.25rem; text-align: center;">
                <div>
                    <span style="font-size: 0.75rem; color: var(--text-muted); font-weight: 700;">TOTAL JOINED</span>
                    <div style="font-size: 1.5rem; font-weight: 900; color: var(--accent-cyan);" id="partModalCount">14 Users</div>
                </div>
                <div>
                    <span style="font-size: 0.75rem; color: var(--text-muted); font-weight: 700;">TOTAL REVENUE</span>
                    <div style="font-size: 1.5rem; font-weight: 900; color: var(--success-green);" id="partModalRev">₹7,000.00</div>
                </div>
            </div>

            <table class="custom-table">
                <thead>
                    <tr>
                        <th>Participant Name</th>
                        <th>Email</th>
                        <th>Joined At</th>
                        <th>Ticket Paid</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody id="participantListBody">
                    <!-- Populated dynamically -->
                </tbody>
            </table>
        </div>
    </div>

    <!-- MODAL: ADD FUND TO USER -->
    <div class="modal-backdrop" id="modalAddFund">
        <div class="modal-box">
            <button class="modal-close-btn" onclick="closeAdminModal('modalAddFund')"><i class="fa-solid fa-xmark"></i></button>
            <h3 class="table-title" style="margin-bottom: 1.25rem;"><i class="fa-solid fa-plus-circle"></i> Add Fund to User Wallet</h3>
            
            <form onsubmit="handleAddFundSubmit(event)">
                <div class="form-group">
                    <label class="form-label">User Email / Phone</label>
                    <input type="email" class="form-input" id="fundUserEmail" placeholder="e.g. rahul@gmail.com" required style="padding-left: 1rem;">
                </div>

                <div class="form-group">
                    <label class="form-label">Amount (₹)</label>
                    <input type="number" class="form-input" id="fundAmount" placeholder="Enter Amount" min="1" required style="padding-left: 1rem;">
                </div>

                <div class="form-group">
                    <label class="form-label">Transaction Details / Note</label>
                    <input type="text" class="form-input" id="fundDetails" value="Admin Manual Wallet Credit" required style="padding-left: 1rem;">
                </div>

                <button type="submit" class="btn-login-submit"><i class="fa-solid fa-wallet"></i> Credit Wallet Now</button>
            </form>
        </div>
    </div>

    <!-- MODAL: MOBILE RECHARGE -->
    <div class="modal-backdrop" id="modalMobileRecharge">
        <div class="modal-box">
            <button class="modal-close-btn" onclick="closeAdminModal('modalMobileRecharge')"><i class="fa-solid fa-xmark"></i></button>
            <h3 class="table-title" style="margin-bottom: 1.25rem;"><i class="fa-solid fa-mobile-screen"></i> Admin Mobile Recharge</h3>
            
            <form onsubmit="handleAdminRechargeSubmit(event, 'Mobile')">
                <div class="form-group">
                    <label class="form-label">Mobile Number</label>
                    <input type="text" class="form-input" placeholder="10 Digit Number" required style="padding-left: 1rem;">
                </div>

                <div class="form-group">
                    <label class="form-label">Operator</label>
                    <select class="form-select" required style="padding-left: 1rem;">
                        <option value="AT">Airtel</option>
                        <option value="JIO">Jio Reliance</option>
                        <option value="VI">Vodafone Idea</option>
                        <option value="BSNL">BSNL</option>
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label">Recharge Amount (₹)</label>
                    <input type="number" class="form-input" placeholder="Enter Amount" required style="padding-left: 1rem;">
                </div>

                <button type="submit" class="btn-login-submit"><i class="fa-solid fa-bolt"></i> Execute Recharge</button>
            </form>
        </div>
    </div>

    <!-- MODAL: DTH RECHARGE -->
    <div class="modal-backdrop" id="modalDthRecharge">
        <div class="modal-box">
            <button class="modal-close-btn" onclick="closeAdminModal('modalDthRecharge')"><i class="fa-solid fa-xmark"></i></button>
            <h3 class="table-title" style="margin-bottom: 1.25rem;"><i class="fa-solid fa-tv"></i> Admin DTH Recharge</h3>
            
            <form onsubmit="handleAdminRechargeSubmit(event, 'DTH')">
                <div class="form-group">
                    <label class="form-label">Smart Card / Customer ID</label>
                    <input type="text" class="form-input" placeholder="Smart Card Number" required style="padding-left: 1rem;">
                </div>

                <div class="form-group">
                    <label class="form-label">DTH Operator</label>
                    <select class="form-select" required style="padding-left: 1rem;">
                        <option value="TATAPLAY">Tata Play</option>
                        <option value="AIRTELDTH">Airtel Digital TV</option>
                        <option value="DISHTV">Dish TV</option>
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label">Amount (₹)</label>
                    <input type="number" class="form-input" placeholder="Enter Amount" required style="padding-left: 1rem;">
                </div>

                <button type="submit" class="btn-login-submit"><i class="fa-solid fa-satellite-dish"></i> Execute DTH Recharge</button>
            </form>
        </div>
    </div>

    <!-- MODAL: BILL PAYMENT -->
    <div class="modal-backdrop" id="modalBillPay">
        <div class="modal-box">
            <button class="modal-close-btn" onclick="closeAdminModal('modalBillPay')"><i class="fa-solid fa-xmark"></i></button>
            <h3 class="table-title" style="margin-bottom: 1.25rem;"><i class="fa-solid fa-file-invoice-dollar"></i> Admin Bill Payment</h3>
            
            <form onsubmit="handleAdminRechargeSubmit(event, 'Bill')">
                <div class="form-group">
                    <label class="form-label">Utility Category</label>
                    <select class="form-select" required style="padding-left: 1rem;">
                        <option value="electricity">Electricity Bill</option>
                        <option value="gas">Piped Gas & Cylinder</option>
                        <option value="water">Water Bill</option>
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label">Consumer / CA Number</label>
                    <input type="text" class="form-input" placeholder="Consumer ID" required style="padding-left: 1rem;">
                </div>

                <div class="form-group">
                    <label class="form-label">Amount (₹)</label>
                    <input type="number" class="form-input" placeholder="Bill Amount" required style="padding-left: 1rem;">
                </div>

                <button type="submit" class="btn-login-submit"><i class="fa-solid fa-credit-card"></i> Pay Utility Bill</button>
            </form>
        </div>
    </div>

    <!-- MODAL: CREATE USER -->
    <div class="modal-backdrop" id="modalCreateUser">
        <div class="modal-box">
            <button class="modal-close-btn" onclick="closeAdminModal('modalCreateUser')"><i class="fa-solid fa-xmark"></i></button>
            <h3 class="table-title" style="margin-bottom: 1.25rem;"><i class="fa-solid fa-user-plus"></i> Create Free / Corporate User</h3>
            
            <form onsubmit="handleCreateUserSubmit(event)">
                <div class="form-group">
                    <label class="form-label">Full Name</label>
                    <input type="text" class="form-input" id="newUserName" placeholder="Full Name" required style="padding-left: 1rem;">
                </div>

                <div class="form-group">
                    <label class="form-label">Email Address</label>
                    <input type="email" class="form-input" id="newUserEmail" placeholder="Email" required style="padding-left: 1rem;">
                </div>

                <div class="form-group">
                    <label class="form-label">Phone Number</label>
                    <input type="text" class="form-input" id="newUserPhone" placeholder="Mobile Number" required style="padding-left: 1rem;">
                </div>

                <div class="form-group">
                    <label class="form-label">Account Type</label>
                    <select class="form-select" id="newUserAccountType" style="padding-left: 1rem;">
                        <option value="free">Free User</option>
                        <option value="corporate">Corporate User</option>
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label">Password</label>
                    <input type="password" class="form-input" id="newUserPassword" placeholder="Initial Password" required style="padding-left: 1rem;">
                </div>

                <button type="submit" class="btn-login-submit"><i class="fa-solid fa-user-check"></i> Create User Account</button>
            </form>
        </div>
    </div>

    <!-- Toast Container -->
    <div class="toast-container" id="toastContainer"></div>

    <!-- JavaScript App Controller & Charts -->
    <script>
        let revChartInstance = null;
        let mtgChartInstance = null;

        function handleMasterLogin(e) {
            e.preventDefault();
            document.getElementById('masterLoginWrapper').style.display = 'none';
            document.getElementById('masterDashboardWrapper').classList.add('active');
            initDashboardCharts();
            showToast('Authenticated as Master Administrator!', 'success');
        }

        function handleAdminLogout() {
            document.getElementById('masterDashboardWrapper').classList.remove('active');
            document.getElementById('masterLoginWrapper').style.display = 'flex';
            showToast('Logged out of Master Admin Portal', 'info');
        }

        function switchAdminTab(tabName) {
            document.querySelectorAll('.sidebar-menu-btn').forEach(b => b.classList.remove('active'));
            const sideBtn = document.getElementById(`btnSide${tabName.charAt(0).toUpperCase() + tabName.slice(1)}`);
            if (sideBtn) sideBtn.classList.add('active');

            document.querySelectorAll('.tab-panel-section').forEach(p => p.classList.remove('active'));
            const panel = document.getElementById(`tab-${tabName}`);
            if (panel) panel.classList.add('active');

            const titles = {
                'dashboard': 'Master Dashboard Overview',
                'users': 'User Manager & Accounts',
                'meetings': 'Meetings Manager & Joined User Reports',
                'recharges': 'Recharge & Bill Payment History',
                'passbook': 'Wallet & Add Fund History',
                'reports': 'Custom Reports & CSV Export'
            };
            document.getElementById('adminTabTitle').innerText = titles[tabName] || 'Master Control';
        }

        function filterMeetings(status) {
            switchAdminTab('meetings');
            showToast(`Filtered Meetings by status: ${status.toUpperCase()}`, 'info');
        }

        function viewMeetingParticipants(title, uuid, count, rev) {
            document.getElementById('partModalTitle').innerHTML = `<i class="fa-solid fa-users-rectangle"></i> ${title}`;
            document.getElementById('partModalSub').innerText = `UUID: ${uuid} • Detailed Attendance & Revenue Report`;
            document.getElementById('partModalCount').innerText = `${count} Users`;
            document.getElementById('partModalRev').innerText = `₹${rev.toLocaleString('en-IN')}.00`;

            const tbody = document.getElementById('participantListBody');
            tbody.innerHTML = '';

            const sampleParticipants = [
                { name: 'Rahul Sharma', email: 'rahul@gmail.com', time: '10:02 AM', ticket: '₹500.00', status: 'Approved & Active' },
                { name: 'Amit Verma', email: 'amit@yahoo.com', time: '10:05 AM', ticket: '₹500.00', status: 'Approved & Active' },
                { name: 'Priya Patel', email: 'priya@techcorp.com', time: '10:08 AM', ticket: '₹500.00', status: 'Approved & Active' },
                { name: 'Karan Malhotra', email: 'karan@design.io', time: '10:12 AM', ticket: '₹500.00', status: 'Approved' },
                { name: 'Sneha Reddy', email: 'sneha@fintech.in', time: '10:15 AM', ticket: '₹500.00', status: 'Approved' }
            ];

            sampleParticipants.forEach(p => {
                const tr = document.createElement('tr');
                tr.innerHTML = `
                    <td><strong style="color: var(--text-main);">${p.name}</strong></td>
                    <td>${p.email}</td>
                    <td>${p.time}</td>
                    <td style="color: var(--success-green); font-weight: 800;">${p.ticket}</td>
                    <td><span class="status-pill status-success">${p.status}</span></td>
                `;
                tbody.appendChild(tr);
            });

            openAdminModal('modalViewParticipants');
        }

        function initDashboardCharts() {
            if (revChartInstance) revChartInstance.destroy();
            if (mtgChartInstance) mtgChartInstance.destroy();

            const ctxRev = document.getElementById('chartRevenue')?.getContext('2d');
            if (ctxRev) {
                revChartInstance = new Chart(ctxRev, {
                    type: 'line',
                    data: {
                        labels: ['02 Oct', '03 Oct', '04 Oct', '05 Oct', '06 Oct', '07 Oct', '08 Oct'],
                        datasets: [{
                            label: 'Revenue (₹)',
                            data: [95000, 112000, 88000, 134000, 120000, 138000, 145820],
                            borderColor: '#00F2FE',
                            backgroundColor: 'rgba(0, 242, 254, 0.12)',
                            fill: true,
                            tension: 0.35,
                            borderWidth: 3
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: { legend: { display: false } },
                        scales: {
                            x: { grid: { color: 'rgba(255,255,255,0.05)' }, ticks: { color: '#94A3B8' } },
                            y: { grid: { color: 'rgba(255,255,255,0.05)' }, ticks: { color: '#94A3B8' } }
                        }
                    }
                });
            }

            const ctxMtg = document.getElementById('chartMeetings')?.getContext('2d');
            if (ctxMtg) {
                mtgChartInstance = new Chart(ctxMtg, {
                    type: 'doughnut',
                    data: {
                        labels: ['Completed (284)', 'Scheduled (96)', 'Expired (32)'],
                        datasets: [{
                            data: [284, 96, 32],
                            backgroundColor: ['#10B981', '#F59E0B', '#EF4444']
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: { legend: { position: 'bottom', labels: { color: '#94A3B8' } } }
                    }
                });
            }
        }

        function openAdminModal(modalId) {
            document.getElementById(modalId).classList.add('active');
        }

        function closeAdminModal(modalId) {
            document.getElementById(modalId).classList.remove('active');
        }

        function quickAddFundModal(email) {
            document.getElementById('fundUserEmail').value = email;
            openAdminModal('modalAddFund');
        }

        function handleAddFundSubmit(e) {
            e.preventDefault();
            const email = document.getElementById('fundUserEmail').value;
            const amt = document.getElementById('fundAmount').value;
            closeAdminModal('modalAddFund');
            showToast(`🎉 Credited ₹${amt} to ${email} wallet!`, 'success');
        }

        function handleAdminRechargeSubmit(e, service) {
            e.preventDefault();
            closeAdminModal('modalMobileRecharge');
            closeAdminModal('modalDthRecharge');
            closeAdminModal('modalBillPay');
            showToast(`🎉 Admin ${service} Transaction Completed!`, 'success');
        }

        function handleCreateUserSubmit(e) {
            e.preventDefault();
            const name = document.getElementById('newUserName').value;
            const email = document.getElementById('newUserEmail').value;
            const type = document.getElementById('newUserAccountType').value;
            closeAdminModal('modalCreateUser');
            
            const tbody = document.getElementById('userTableBody');
            const newRow = document.createElement('tr');
            newRow.innerHTML = `
                <td>#USR-${Math.floor(100 + Math.random() * 900)}</td>
                <td>${name}</td>
                <td>${email}</td>
                <td><span class="status-pill status-${type === 'free' ? 'success' : 'pending'}">${type === 'free' ? 'Free User' : 'Corporate'}</span></td>
                <td>${type === 'free' ? 'free_user' : 'corporate_employee'}</td>
                <td style="color: var(--accent-cyan); font-weight: 800;">₹0.00</td>
                <td><span class="status-pill status-success">Active</span></td>
                <td>
                    <button class="action-btn-sm" onclick="quickAddFundModal('${email}')">+ Fund</button>
                    <button class="action-btn-sm" onclick="showToast('Edit user')">Edit</button>
                    <button class="action-btn-sm" style="color: var(--danger-red);" onclick="showToast('Blocked User')">Block</button>
                </td>
            `;
            tbody.prepend(newRow);

            showToast(`User ${name} created successfully as ${type}!`, 'success');
        }

        function editUserModal(usrId) {
            showToast(`Editing user ${usrId}`, 'info');
        }

        function toggleUserLoginStatus(usrId) {
            showToast(`Login status toggled for user ${usrId}`, 'warning');
        }

        function exportReportToCSV() {
            let csv = "Date,Reference/Meeting ID,User Account/Host,Category/Meeting Title,Amount/Revenue,Status/Joined Users\n";
            csv += "2026-10-08,MTG-882910,Executive Host,Quarterly Product Sync,7000.00,14 Joined Users\n";
            csv += "2026-10-08,REC998120,rahul@gmail.com,Mobile Recharge,299.00,Success\n";
            csv += "2026-10-08,PB-100293,rahul@gmail.com,Add Fund (Credit),500.00,Completed\n";

            const blob = new Blob([csv], { type: 'text/csv' });
            const url = window.URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.setAttribute('href', url);
            a.setAttribute('download', `BestRecharge_Full_Report_${Date.now()}.csv`);
            a.click();
            showToast('CSV Report Downloaded!', 'success');
        }

        function generateReportData() {
            showToast('Report filtered by date range and type!', 'info');
        }

        function showToast(msg, type = 'info') {
            const container = document.getElementById('toastContainer');
            const toast = document.createElement('div');
            toast.className = 'toast-msg';
            
            let icon = '<i class="fa-solid fa-circle-info" style="color: var(--accent-cyan);"></i>';
            if (type === 'success') icon = '<i class="fa-solid fa-circle-check" style="color: var(--success-green);"></i>';
            if (type === 'warning') icon = '<i class="fa-solid fa-triangle-exclamation" style="color: var(--warning-amber);"></i>';

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
