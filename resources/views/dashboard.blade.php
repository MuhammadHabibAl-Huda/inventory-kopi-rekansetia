<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory - Kedai Kopi Rekan Setia</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        /* ===== RESET & BASE ===== */
        *, *::before, *::after {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --sidebar-width: 272px;
            --sidebar-bg: #0f172a;
            --sidebar-hover: #1e293b;
            --sidebar-active: linear-gradient(135deg, #b45309, #d97706);
            --accent: #d97706;
            --accent-light: #fbbf24;
            --bg-main: #f1f5f9;
            --card-bg: #ffffff;
            --text-primary: #0f172a;
            --text-secondary: #475569;
            --text-muted: #94a3b8;
            --border: #e2e8f0;
            --success: #10b981;
            --success-bg: #d1fae5;
            --danger: #ef4444;
            --danger-bg: #fee2e2;
            --warning: #f59e0b;
            --warning-bg: #fef3c7;
            --shadow-sm: 0 1px 2px rgba(0,0,0,0.05);
            --shadow-md: 0 4px 6px -1px rgba(0,0,0,0.07), 0 2px 4px -2px rgba(0,0,0,0.05);
            --shadow-lg: 0 10px 15px -3px rgba(0,0,0,0.08), 0 4px 6px -4px rgba(0,0,0,0.05);
            --shadow-xl: 0 20px 25px -5px rgba(0,0,0,0.08), 0 8px 10px -6px rgba(0,0,0,0.04);
            --radius: 12px;
            --radius-sm: 8px;
            --transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background: var(--bg-main);
            color: var(--text-primary);
            min-height: 100vh;
            overflow-x: hidden;
        }

        /* ===== LAYOUT ===== */
        .app-layout {
            display: flex;
            min-height: 100vh;
        }

        /* ===== SIDEBAR ===== */
        .sidebar {
            width: var(--sidebar-width);
            background: var(--sidebar-bg);
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            z-index: 100;
            display: flex;
            flex-direction: column;
            transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            overflow-y: auto;
        }

        .sidebar-brand {
            padding: 28px 24px 20px;
            border-bottom: 1px solid rgba(255,255,255,0.06);
        }

        .sidebar-brand-icon {
            width: 44px;
            height: 44px;
            background: linear-gradient(135deg, #b45309, #d97706);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
            margin-bottom: 14px;
            box-shadow: 0 4px 12px rgba(217, 119, 6, 0.3);
        }

        .sidebar-brand h1 {
            color: #ffffff;
            font-size: 17px;
            font-weight: 700;
            letter-spacing: -0.3px;
            line-height: 1.3;
        }

        .sidebar-brand p {
            color: #64748b;
            font-size: 12px;
            font-weight: 400;
            margin-top: 4px;
        }

        .sidebar-nav {
            padding: 16px 12px;
            flex: 1;
        }

        .sidebar-nav-label {
            color: #475569;
            font-size: 10px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1.2px;
            padding: 8px 14px 10px;
        }

        .nav-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 11px 14px;
            border-radius: 10px;
            color: #94a3b8;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            transition: var(--transition);
            margin-bottom: 2px;
            text-decoration: none;
            border: none;
            background: none;
            width: 100%;
            text-align: left;
        }

        .nav-item:hover {
            background: var(--sidebar-hover);
            color: #e2e8f0;
        }

        .nav-item.active {
            background: var(--sidebar-active);
            color: #ffffff;
            font-weight: 600;
            box-shadow: 0 4px 12px rgba(180, 83, 9, 0.25);
        }

        .nav-icon {
            width: 36px;
            height: 36px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            background: rgba(255,255,255,0.05);
            flex-shrink: 0;
            transition: var(--transition);
        }

        .nav-item.active .nav-icon {
            background: rgba(255,255,255,0.2);
        }

        .nav-item-text {
            display: flex;
            flex-direction: column;
        }

        .nav-item-text span:last-child {
            font-size: 11px;
            color: #64748b;
            font-weight: 400;
            margin-top: 1px;
        }

        .nav-item.active .nav-item-text span:last-child {
            color: rgba(255,255,255,0.7);
        }

        .sidebar-footer {
            padding: 16px 14px;
            border-top: 1px solid rgba(255,255,255,0.06);
        }

        .user-card {
            background: rgba(255,255,255,0.05);
            border: 1px solid rgba(255,255,255,0.08);
            border-radius: 10px;
            padding: 12px 14px;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .user-avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: linear-gradient(135deg, #b45309, #d97706);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            font-weight: 700;
            color: #ffffff;
            flex-shrink: 0;
        }

        .user-info {
            flex: 1;
            min-width: 0;
        }

        .user-name {
            font-size: 13px;
            font-weight: 600;
            color: #e2e8f0;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .user-role-badge {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            font-size: 10px;
            font-weight: 600;
            padding: 2px 8px;
            border-radius: 20px;
            margin-top: 3px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .role-admin {
            background: rgba(251, 191, 36, 0.15);
            color: #fbbf24;
        }

        .role-barista {
            background: rgba(96, 165, 250, 0.15);
            color: #60a5fa;
        }

        .btn-logout {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            width: 100%;
            padding: 10px 14px;
            background: rgba(239, 68, 68, 0.08);
            border: 1px solid rgba(239, 68, 68, 0.2);
            border-radius: 8px;
            color: #fca5a5;
            font-size: 13px;
            font-weight: 600;
            font-family: 'Inter', sans-serif;
            cursor: pointer;
            transition: var(--transition);
            text-align: center;
        }

        .btn-logout:hover {
            background: rgba(239, 68, 68, 0.15);
            color: #f87171;
            border-color: rgba(239, 68, 68, 0.35);
        }

        .sidebar-copyright {
            color: #334155;
            font-size: 10px;
            text-align: center;
            margin-top: 10px;
        }

        /* ===== MAIN CONTENT ===== */
        .main-content {
            flex: 1;
            margin-left: var(--sidebar-width);
            min-height: 100vh;
        }

        /* ===== TOP BAR ===== */
        .topbar {
            background: var(--card-bg);
            border-bottom: 1px solid var(--border);
            padding: 16px 32px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 50;
            backdrop-filter: blur(8px);
            background: rgba(255,255,255,0.92);
        }

        .topbar-title h2 {
            font-size: 20px;
            font-weight: 700;
            color: var(--text-primary);
            letter-spacing: -0.3px;
        }

        .topbar-title p {
            font-size: 13px;
            color: var(--text-secondary);
            margin-top: 2px;
        }

        .topbar-date {
            display: flex;
            align-items: center;
            gap: 8px;
            background: var(--bg-main);
            padding: 8px 16px;
            border-radius: 10px;
            font-size: 13px;
            color: var(--text-secondary);
            font-weight: 500;
        }

        /* ===== PAGE CONTENT ===== */
        .page-content {
            padding: 28px 32px 40px;
        }

        /* ===== SECTION (page) ===== */
        .section-page {
            display: none;
            animation: fadeInUp 0.35s ease;
        }

        .section-page.active {
            display: block;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(12px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* ===== TOAST NOTIFICATION ===== */
        .toast {
            padding: 14px 20px;
            border-radius: var(--radius-sm);
            margin-bottom: 24px;
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 14px;
            font-weight: 500;
            animation: slideDown 0.4s ease;
            box-shadow: var(--shadow-md);
        }

        .toast-success {
            background: var(--success-bg);
            color: #065f46;
            border: 1px solid #a7f3d0;
        }

        .toast-error {
            background: var(--danger-bg);
            color: #991b1b;
            border: 1px solid #fca5a5;
        }

        @keyframes slideDown {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* ===== STATS CARDS ===== */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 20px;
            margin-bottom: 28px;
        }

        .stat-card {
            background: var(--card-bg);
            border-radius: var(--radius);
            padding: 22px 24px;
            box-shadow: var(--shadow-sm);
            border: 1px solid var(--border);
            transition: var(--transition);
            position: relative;
            overflow: hidden;
        }

        .stat-card::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
        }

        .stat-card:nth-child(1)::after { background: linear-gradient(90deg, #d97706, #fbbf24); }
        .stat-card:nth-child(2)::after { background: linear-gradient(90deg, #10b981, #34d399); }
        .stat-card:nth-child(3)::after { background: linear-gradient(90deg, #ef4444, #f87171); }

        .stat-card:hover {
            box-shadow: var(--shadow-lg);
            transform: translateY(-2px);
        }

        .stat-card-label {
            font-size: 12px;
            color: var(--text-muted);
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 8px;
        }

        .stat-card-value {
            font-size: 28px;
            font-weight: 800;
            color: var(--text-primary);
            letter-spacing: -1px;
        }

        .stat-card-sub {
            font-size: 12px;
            color: var(--text-secondary);
            margin-top: 4px;
        }

        /* ===== DATA TABLE ===== */
        .data-card {
            background: var(--card-bg);
            border-radius: var(--radius);
            box-shadow: var(--shadow-sm);
            border: 1px solid var(--border);
            overflow: hidden;
        }

        .data-card-header {
            padding: 20px 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 1px solid var(--border);
        }

        .data-card-header h3 {
            font-size: 16px;
            font-weight: 700;
            color: var(--text-primary);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .header-icon {
            width: 34px;
            height: 34px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
        }

        .header-icon.amber { background: #fef3c7; }
        .header-icon.blue { background: #dbeafe; }
        .header-icon.green { background: #d1fae5; }
        .header-icon.red { background: #fee2e2; }
        .header-icon.orange { background: #ffedd5; }

        .data-card-header .badge {
            font-size: 12px;
            font-weight: 600;
            padding: 4px 12px;
            border-radius: 20px;
            background: var(--bg-main);
            color: var(--text-secondary);
        }

        .data-table {
            width: 100%;
            border-collapse: collapse;
        }

        .data-table thead th {
            padding: 12px 20px;
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            color: var(--text-muted);
            text-align: left;
            background: #f8fafc;
            border-bottom: 1px solid var(--border);
        }

        .data-table tbody td {
            padding: 14px 20px;
            font-size: 14px;
            color: var(--text-secondary);
            border-bottom: 1px solid #f1f5f9;
            vertical-align: middle;
        }

        .data-table tbody tr {
            transition: var(--transition);
        }

        .data-table tbody tr:hover {
            background: #f8fafc;
        }

        .data-table tbody tr:last-child td {
            border-bottom: none;
        }

        .cell-bold {
            font-weight: 600;
            color: var(--text-primary);
        }

        /* ===== STATUS BADGES ===== */
        .badge-status {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }

        .badge-safe {
            background: var(--success-bg);
            color: #065f46;
        }

        .badge-warning {
            background: var(--danger-bg);
            color: #991b1b;
            animation: gentlePulse 2s ease-in-out infinite;
        }

        .badge-masuk {
            background: var(--success-bg);
            color: #065f46;
        }

        .badge-keluar {
            background: var(--danger-bg);
            color: #991b1b;
        }

        @keyframes gentlePulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.7; }
        }

        /* ===== STOCK BAR ===== */
        .stock-bar-wrap {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .stock-bar {
            flex: 1;
            height: 6px;
            background: #e2e8f0;
            border-radius: 3px;
            overflow: hidden;
            max-width: 100px;
        }

        .stock-bar-fill {
            height: 100%;
            border-radius: 3px;
            transition: width 0.6s ease;
        }

        .stock-bar-fill.high { background: linear-gradient(90deg, #10b981, #34d399); }
        .stock-bar-fill.medium { background: linear-gradient(90deg, #f59e0b, #fbbf24); }
        .stock-bar-fill.low { background: linear-gradient(90deg, #ef4444, #f87171); }

        /* ===== FORM CARD ===== */
        .form-card {
            background: var(--card-bg);
            border-radius: var(--radius);
            box-shadow: var(--shadow-sm);
            border: 1px solid var(--border);
            overflow: hidden;
            max-width: 560px;
        }

        .form-card-header {
            padding: 20px 24px;
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .form-card-header h3 {
            font-size: 16px;
            font-weight: 700;
            color: var(--text-primary);
        }

        .form-body {
            padding: 24px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            display: block;
            font-size: 13px;
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 6px;
        }

        .form-label-sub {
            font-weight: 400;
            color: var(--text-muted);
            font-size: 12px;
        }

        .form-select,
        .form-input,
        .form-textarea {
            width: 100%;
            padding: 10px 14px;
            border: 1.5px solid var(--border);
            border-radius: var(--radius-sm);
            font-size: 14px;
            font-family: 'Inter', sans-serif;
            color: var(--text-primary);
            background: var(--card-bg);
            transition: var(--transition);
            outline: none;
        }

        .form-textarea {
            resize: vertical;
            min-height: 80px;
        }

        .form-select:focus,
        .form-input:focus,
        .form-textarea:focus {
            border-color: var(--accent);
            box-shadow: 0 0 0 3px rgba(217, 119, 6, 0.12);
        }

        .form-error {
            color: #dc2626;
            font-size: 12px;
            margin-top: 5px;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .btn-primary {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            width: 100%;
            padding: 12px 20px;
            background: linear-gradient(135deg, #b45309, #d97706);
            color: #ffffff;
            font-size: 14px;
            font-weight: 600;
            font-family: 'Inter', sans-serif;
            border: none;
            border-radius: var(--radius-sm);
            cursor: pointer;
            transition: var(--transition);
            box-shadow: 0 4px 12px rgba(180, 83, 9, 0.25);
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #92400e, #b45309);
            box-shadow: 0 6px 16px rgba(180, 83, 9, 0.35);
            transform: translateY(-1px);
        }

        .btn-primary:active {
            transform: translateY(0);
        }

        /* ===== DANGER BUTTON (Penyusutan) ===== */
        .btn-danger-submit {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            width: 100%;
            padding: 12px 20px;
            background: linear-gradient(135deg, #b91c1c, #ef4444);
            color: #ffffff;
            font-size: 14px;
            font-weight: 600;
            font-family: 'Inter', sans-serif;
            border: none;
            border-radius: var(--radius-sm);
            cursor: pointer;
            transition: var(--transition);
            box-shadow: 0 4px 12px rgba(185, 28, 28, 0.25);
        }

        .btn-danger-submit:hover {
            background: linear-gradient(135deg, #991b1b, #b91c1c);
            box-shadow: 0 6px 16px rgba(185, 28, 28, 0.35);
            transform: translateY(-1px);
        }

        /* ===== PENYUSUTAN WARNING BOX ===== */
        .penyusutan-notice {
            background: #fffbeb;
            border: 1px solid #fde68a;
            border-radius: var(--radius-sm);
            padding: 14px 16px;
            margin-bottom: 20px;
            display: flex;
            align-items: flex-start;
            gap: 10px;
        }

        .penyusutan-notice-icon {
            flex-shrink: 0;
            color: #d97706;
            margin-top: 1px;
        }

        .penyusutan-notice p {
            font-size: 13px;
            color: #78350f;
            line-height: 1.5;
        }

        .penyusutan-notice strong {
            font-weight: 700;
        }

        /* ===== CETAK LAPORAN SECTION ===== */
        .report-card {
            background: var(--card-bg);
            border-radius: var(--radius);
            box-shadow: var(--shadow-sm);
            border: 1px solid var(--border);
            overflow: hidden;
            max-width: 600px;
        }

        .report-card-header {
            padding: 20px 24px;
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .report-card-header h3 {
            font-size: 16px;
            font-weight: 700;
        }

        .report-body {
            padding: 28px 24px;
        }

        .report-icon {
            width: 72px;
            height: 72px;
            margin: 0 auto 20px;
            background: #f1f5f9;
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 12px rgba(0,0,0,0.06);
        }

        .report-body h4 {
            font-size: 18px;
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 6px;
            text-align: center;
        }

        .report-body > p {
            font-size: 13px;
            color: var(--text-secondary);
            margin-bottom: 24px;
            line-height: 1.6;
            text-align: center;
        }

        /* Filter tanggal laporan */
        .filter-section {
            background: #f8fafc;
            border: 1px solid var(--border);
            border-radius: var(--radius-sm);
            padding: 20px;
            margin-bottom: 24px;
        }

        .filter-section-title {
            font-size: 13px;
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 14px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .filter-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 14px;
        }

        .filter-group label {
            display: block;
            font-size: 12px;
            font-weight: 600;
            color: var(--text-secondary);
            margin-bottom: 6px;
        }

        .btn-report {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            width: 100%;
            padding: 14px 32px;
            background: linear-gradient(135deg, #b45309, #d97706);
            color: #ffffff;
            font-size: 14px;
            font-weight: 600;
            font-family: 'Inter', sans-serif;
            border: none;
            border-radius: var(--radius-sm);
            cursor: pointer;
            text-decoration: none;
            transition: var(--transition);
            box-shadow: 0 4px 12px rgba(180, 83, 9, 0.25);
        }

        .btn-report:hover {
            background: linear-gradient(135deg, #92400e, #b45309);
            box-shadow: 0 6px 16px rgba(180, 83, 9, 0.35);
            transform: translateY(-2px);
        }

        .btn-report-all {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            width: 100%;
            padding: 11px 24px;
            background: transparent;
            color: var(--text-secondary);
            font-size: 13px;
            font-weight: 600;
            font-family: 'Inter', sans-serif;
            border: 1.5px solid var(--border);
            border-radius: var(--radius-sm);
            cursor: pointer;
            text-decoration: none;
            transition: var(--transition);
            margin-top: 10px;
        }

        .btn-report-all:hover {
            border-color: var(--accent);
            color: var(--accent);
            background: rgba(217, 119, 6, 0.04);
        }

        /* ===== HAPUS RIWAYAT BUTTON ===== */
        .btn-hapus {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 5px 10px;
            background: transparent;
            color: #ef4444;
            font-size: 12px;
            font-weight: 600;
            font-family: 'Inter', sans-serif;
            border: 1.5px solid #fca5a5;
            border-radius: 6px;
            cursor: pointer;
            transition: var(--transition);
        }

        .btn-hapus:hover {
            background: var(--danger-bg);
            border-color: #ef4444;
        }

        /* ===== RIWAYAT HEADER WITH FILTER ===== */
        .riwayat-header-actions {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .riwayat-search {
            padding: 7px 12px;
            border: 1.5px solid var(--border);
            border-radius: var(--radius-sm);
            font-size: 13px;
            font-family: 'Inter', sans-serif;
            color: var(--text-primary);
            background: var(--bg-main);
            outline: none;
            transition: var(--transition);
            width: 200px;
        }

        .riwayat-search:focus {
            border-color: var(--accent);
            box-shadow: 0 0 0 3px rgba(217, 119, 6, 0.1);
        }

        /* ===== EMPTY STATE ===== */
        .empty-state {
            text-align: center;
            padding: 48px 20px;
            color: var(--text-muted);
        }

        .empty-state-icon {
            margin-bottom: 12px;
            display: flex;
            justify-content: center;
        }

        .empty-state p {
            font-size: 14px;
            font-style: italic;
        }

        /* ===== ROLE ACCESS NOTICE ===== */
        .access-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 11px;
            font-weight: 600;
            padding: 4px 10px;
            border-radius: 20px;
            margin-left: 8px;
        }

        .access-admin {
            background: rgba(251, 191, 36, 0.15);
            color: #b45309;
            border: 1px solid rgba(251, 191, 36, 0.3);
        }

        /* ===== DIVIDER ===== */
        .section-divider {
            height: 1px;
            background: var(--border);
            margin: 28px 0;
        }

        /* ===== MOBILE TOGGLE ===== */
        .mobile-toggle {
            display: none;
            position: fixed;
            top: 16px;
            left: 16px;
            z-index: 200;
            width: 42px;
            height: 42px;
            border-radius: 10px;
            background: var(--sidebar-bg);
            color: #ffffff;
            border: none;
            font-size: 20px;
            cursor: pointer;
            align-items: center;
            justify-content: center;
            box-shadow: var(--shadow-lg);
        }

        .overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.4);
            z-index: 90;
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.open {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
            }

            .mobile-toggle {
                display: flex;
            }

            .overlay.active {
                display: block;
            }

            .topbar {
                padding: 16px 20px;
                padding-left: 64px;
            }

            .page-content {
                padding: 20px 16px 32px;
            }

            .stats-grid {
                grid-template-columns: 1fr;
            }

            .data-table thead th,
            .data-table tbody td {
                padding: 10px 12px;
                font-size: 12px;
            }

            .filter-row {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <!-- Mobile Toggle -->
    <button class="mobile-toggle" onclick="toggleSidebar()" id="menuToggle">☰</button>
    <div class="overlay" id="overlay" onclick="toggleSidebar()"></div>

    <div class="app-layout">
        <!-- ===== SIDEBAR ===== -->
        <aside class="sidebar" id="sidebar">
            <div class="sidebar-brand">
                <div class="sidebar-brand-icon">
                    <img src="{{ asset('images/logo.jpeg') }}" alt="Logo Rekan Setia" style="width: 100%; height: 100%; object-fit: cover; border-radius: 12px;">
                </div>
                <h1>Kedai Kopi<br>Rekan Setia</h1>
                <p>Inventory Management System</p>
            </div>

            <nav class="sidebar-nav">
                <div class="sidebar-nav-label">Menu Utama</div>

                {{-- Live Monitoring — tersedia untuk SEMUA ROLE --}}
                <button class="nav-item active" onclick="showSection('monitoring', this)" id="nav-monitoring">
                    <div class="nav-icon">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/><line x1="6" y1="20" x2="6" y2="14"/>
                        </svg>
                    </div>
                    <div class="nav-item-text">
                        <span>Live Monitoring</span>
                        <span>Pantau stok real-time</span>
                    </div>
                </button>

                {{-- Kelola Bahan Baku — tersedia untuk SEMUA ROLE --}}
                {{-- Admin: melihat form restock + penyusutan --}}
                {{-- Barista: hanya melihat form penyusutan --}}
                <button class="nav-item" onclick="showSection('kelola-bahan-baku', this)" id="nav-kelola">
                    <div class="nav-icon">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/>
                            <polyline points="3.27 6.96 12 12.01 20.73 6.96"/><line x1="12" y1="22.08" x2="12" y2="12"/>
                        </svg>
                    </div>
                    <div class="nav-item-text">
                        <span>Kelola Bahan Baku</span>
                        <span>Restock &amp; penyusutan</span>
                    </div>
                </button>

                {{-- Riwayat Aktivitas — tersedia untuk SEMUA ROLE --}}
                <button class="nav-item" onclick="showSection('riwayat', this)" id="nav-riwayat">
                    <div class="nav-icon">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>
                        </svg>
                    </div>
                    <div class="nav-item-text">
                        <span>Riwayat Aktivitas</span>
                        <span>Log mutasi gudang</span>
                    </div>
                </button>

                @if(Auth::user()->isAdmin())
                <div class="sidebar-nav-label" style="margin-top: 12px;">Admin Only</div>

                <button class="nav-item" onclick="showSection('cetak-laporan', this)" id="nav-laporan">
                    <div class="nav-icon">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="6 9 6 2 18 2 18 9"/>
                            <path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/>
                            <rect x="6" y="14" width="12" height="8"/>
                        </svg>
                    </div>
                    <div class="nav-item-text">
                        <span>Cetak Laporan</span>
                        <span>Unduh laporan PDF</span>
                    </div>
                </button>
                @endif
            </nav>

            <div class="sidebar-footer">
                {{-- User Info Card --}}
                @auth
                <div class="user-card">
                    <div class="user-avatar">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>
                    <div class="user-info">
                        <div class="user-name">{{ Auth::user()->name }}</div>
                        <span class="user-role-badge {{ Auth::user()->role === 'admin' ? 'role-admin' : 'role-barista' }}">
                            @if(Auth::user()->role === 'admin')
                                <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="display:inline;vertical-align:middle;margin-right:3px">
                                    <circle cx="12" cy="12" r="3"/><path d="M19.07 4.93a10 10 0 0 1 0 14.14M4.93 4.93a10 10 0 0 0 0 14.14"/>
                                </svg>Admin
                            @else
                                <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="display:inline;vertical-align:middle;margin-right:3px">
                                    <circle cx="12" cy="12" r="3"/><path d="M19.07 4.93a10 10 0 0 1 0 14.14M4.93 4.93a10 10 0 0 0 0 14.14"/>
                                </svg>Barista
                            @endif
                        </span>
                    </div>
                </div>

                {{-- Logout Form --}}
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn-logout">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="flex-shrink:0">
                            <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/>
                            <polyline points="16 17 21 12 16 7"/>
                            <line x1="21" y1="12" x2="9" y2="12"/>
                        </svg>
                        Keluar
                    </button>
                </form>
                @endauth

                <p class="sidebar-copyright">© {{ date('Y') }} Kedai Kopi Rekan Setia</p>
            </div>
        </aside>

        <!-- ===== MAIN CONTENT ===== -->
        <main class="main-content">
            <!-- Top Bar -->
            <header class="topbar">
                <div class="topbar-title">
                    <h2 id="page-title">Live Monitoring Stok</h2>
                    <p id="page-subtitle">Pantau kondisi stok bahan baku gudang secara real-time</p>
                </div>
                <div class="topbar-date">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/>
                        <line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/>
                    </svg>
                    {{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}
                </div>
            </header>

            <div class="page-content">
                {{-- Toast Notification --}}
                @if(session('success'))
                <div class="toast toast-success" id="toast-notif">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="flex-shrink:0;color:#10b981">
                        <polyline points="20 6 9 17 4 12"/>
                    </svg>
                    <span>{{ session('success') }}</span>
                </div>
                @endif

                @if($errors->any())
                <div class="toast toast-error" id="toast-error">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="flex-shrink:0;color:#ef4444">
                        <circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/>
                    </svg>
                    <span>{{ $errors->first() }}</span>
                </div>
                @endif

                {{-- ============================================= --}}
                {{-- SECTION 1: LIVE MONITORING (Semua Role)       --}}
                {{-- ============================================= --}}
                <div class="section-page active" id="section-monitoring">
                    <!-- Summary Stats -->
                    <div class="stats-grid">
                        <div class="stat-card">
                            <div class="stat-card-label">Total Jenis Bahan</div>
                            <div class="stat-card-value">{{ $semuaBahan->count() }}</div>
                            <div class="stat-card-sub">Bahan baku terdaftar</div>
                        </div>
                        <div class="stat-card">
                            <div class="stat-card-label">Stok Aman</div>
                            <div class="stat-card-value" style="color: #10b981;">
                                {{ $semuaBahan->filter(fn($b) => $b->stok_sisa > $b->stok_minimum)->count() }}
                            </div>
                            <div class="stat-card-sub">Bahan di atas batas minimum</div>
                        </div>
                        <div class="stat-card">
                            <div class="stat-card-label">Stok Menipis</div>
                            <div class="stat-card-value" style="color: #ef4444;">
                                {{ $semuaBahan->filter(fn($b) => $b->stok_sisa <= $b->stok_minimum)->count() }}
                            </div>
                            <div class="stat-card-sub">Perlu segera restock</div>
                        </div>
                    </div>

                    <!-- Stock Table -->
                    <div class="data-card">
                        <div class="data-card-header">
                            <h3>
                                <span class="header-icon amber">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <line x1="8" y1="6" x2="21" y2="6"/><line x1="8" y1="12" x2="21" y2="12"/><line x1="8" y1="18" x2="21" y2="18"/>
                                        <line x1="3" y1="6" x2="3.01" y2="6"/><line x1="3" y1="12" x2="3.01" y2="12"/><line x1="3" y1="18" x2="3.01" y2="18"/>
                                    </svg>
                                </span>
                                Daftar Stok Bahan Baku
                            </h3>
                            <span class="badge">{{ $semuaBahan->count() }} item</span>
                        </div>
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Bahan Baku</th>
                                    <th>Sisa Stok</th>
                                    <th>Satuan</th>
                                    <th>Batas Min.</th>
                                    <th>Level</th>
                                    <th style="text-align:center">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($semuaBahan as $index => $bahan)
                                @php
                                    $pct = $bahan->stok_minimum > 0 ? min(($bahan->stok_sisa / ($bahan->stok_minimum * 5)) * 100, 100) : 100;
                                    $level = $pct > 50 ? 'high' : ($pct > 25 ? 'medium' : 'low');
                                @endphp
                                <tr>
                                    <td class="cell-bold">{{ $index + 1 }}</td>
                                    <td class="cell-bold">{{ $bahan->nama_bahan }}</td>
                                    <td class="cell-bold">{{ number_format($bahan->stok_sisa, 0, ',', '.') }}</td>
                                    <td>{{ $bahan->satuan }}</td>
                                    <td>{{ number_format($bahan->stok_minimum, 0, ',', '.') }}</td>
                                    <td>
                                        <div class="stock-bar-wrap">
                                            <div class="stock-bar">
                                                <div class="stock-bar-fill {{ $level }}" style="width: {{ $pct }}%"></div>
                                            </div>
                                        </div>
                                    </td>
                                    <td style="text-align:center">
                                        @if($bahan->stok_sisa <= $bahan->stok_minimum)
                                            <span class="badge-status badge-warning">
                                                <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                                    <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/>
                                                    <line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/>
                                                </svg>
                                                Menipis
                                            </span>
                                        @else
                                            <span class="badge-status badge-safe">
                                                <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                                    <polyline points="20 6 9 17 4 12"/>
                                                </svg>
                                                Aman
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- ============================================= --}}
                {{-- SECTION 2: RIWAYAT AKTIVITAS (Semua Role)     --}}
                {{-- ============================================= --}}
                <div class="section-page" id="section-riwayat">
                    <div class="data-card">
                        <div class="data-card-header">
                            <h3>
                                <span class="header-icon blue">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>
                                    </svg>
                                </span>
                                Riwayat Aktivitas
                            </h3>
                            <div class="riwayat-header-actions">
                                <span class="badge" id="badge-riwayat-count">{{ $riwayat->count() }} log</span>
                                <div style="position:relative;display:inline-block">
                                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="position:absolute;left:10px;top:50%;transform:translateY(-50%);color:#94a3b8;pointer-events:none">
                                        <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
                                    </svg>
                                    <input type="text" class="riwayat-search" id="searchRiwayat" placeholder="Cari riwayat..." oninput="filterRiwayat(this.value)" style="padding-left:30px">
                                </div>
                            </div>
                        </div>
                        <table class="data-table" id="tabel-riwayat">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Tanggal & Waktu</th>
                                    <th>Bahan Baku</th>
                                    <th>Status</th>
                                    <th>Jumlah</th>
                                    <th>Keterangan</th>
                                    @if(Auth::user()->isAdmin())
                                    <th style="text-align:center">Aksi</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody id="tbody-riwayat">
                                @forelse($riwayat as $key => $row)
                                <tr class="riwayat-row" data-search="{{ strtolower($row->bahanBaku->nama_bahan ?? '') }} {{ strtolower($row->keterangan ?? '') }} {{ strtolower($row->jenis) }}">
                                    <td class="cell-bold">{{ $key + 1 }}</td>
                                    <td>{{ $row->created_at->format('d-m-Y H:i') }}</td>
                                    <td class="cell-bold">{{ $row->bahanBaku->nama_bahan ?? 'Bahan Terhapus' }}</td>
                                    <td>
                                        <span class="badge-status {{ $row->status == 'MASUK' ? 'badge-masuk' : 'badge-keluar' }}">
                                            @if($row->status == 'MASUK')
                                            <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                                                <line x1="12" y1="19" x2="12" y2="5"/><polyline points="5 12 12 5 19 12"/>
                                            </svg>
                                            @else
                                            <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                                                <line x1="12" y1="5" x2="12" y2="19"/><polyline points="19 12 12 19 5 12"/>
                                            </svg>
                                            @endif
                                            {{ $row->status }}
                                        </span>
                                    </td>
                                    <td class="cell-bold">{{ number_format($row->jumlah, 0, ',', '.') }}</td>
                                    <td>{{ $row->keterangan ?? '-' }}</td>
                                    @if(Auth::user()->isAdmin())
                                    <td style="text-align:center">
                                        <form action="{{ route('riwayat.destroy', $row->id) }}" method="POST"
                                              onsubmit="return konfirmasiHapus(event, '{{ $row->bahanBaku->nama_bahan ?? 'Bahan Terhapus' }}', '{{ $row->created_at->format('d-m-Y H:i') }}')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-hapus" title="Hapus record ini">
                                                <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                                    <polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><path d="M10 11v6"/><path d="M14 11v6"/><path d="M9 6V4h6v2"/>
                                                </svg>
                                                Hapus
                                            </button>
                                        </form>
                                    </td>
                                    @endif
                                </tr>
                                @empty
                                <tr id="empty-riwayat">
                                    <td colspan="{{ Auth::user()->isAdmin() ? 7 : 6 }}">
                                        <div class="empty-state">
                                            <div class="empty-state-icon">
                                                <svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" style="color:#94a3b8">
                                                    <path d="M22 12h-4l-3 9L9 3l-3 9H2"/>
                                                </svg>
                                            </div>
                                            <p>Belum ada aktivitas mutasi stok gudang.</p>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- ============================================= --}}
                {{-- SECTION 3: KELOLA BAHAN BAKU (Semua Role)     --}}
                {{-- Admin: restock + penyusutan                    --}}
                {{-- Barista: hanya penyusutan                      --}}
                {{-- ============================================= --}}
                <div class="section-page" id="section-kelola-bahan-baku">

                    @if(Auth::user()->isAdmin())
                    {{-- === SUB-BAGIAN A: INPUT BAHAN BAKU MASUK (Admin Only) === --}}
                    <div class="form-card" style="margin-bottom: 24px;">
                        <div class="form-card-header">
                            <span class="header-icon green">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/>
                                    <polyline points="3.27 6.96 12 12.01 20.73 6.96"/><line x1="12" y1="22.08" x2="12" y2="12"/>
                                </svg>
                            </span>
                            <h3>Form Input Bahan Baku Masuk</h3>
                        </div>
                        <form action="/dashboard/restock" method="POST" class="form-body">
                            @csrf
                            <div class="form-group">
                                <label class="form-label">
                                    Pilih Bahan Baku
                                    <span class="form-label-sub">— pilih barang yang akan di-restock</span>
                                </label>
                                <select name="bahan_id" required class="form-select" id="restock-bahan">
                                    <option value="">-- Pilih Barang --</option>
                                    @foreach($semuaBahan as $bahan)
                                        <option value="{{ $bahan->id }}">{{ $bahan->nama_bahan }} ({{ $bahan->satuan }})</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label class="form-label">
                                    Jumlah Stok Tambahan
                                    <span class="form-label-sub">— masukkan jumlah stok yang masuk dari supplier</span>
                                </label>
                                <input type="number" name="jumlah_masuk" min="1" required placeholder="Contoh: 5000" class="form-input" id="restock-jumlah">
                            </div>

                            <div class="form-group">
                                <label class="form-label">
                                    Nama Supplier
                                    <span class="form-label-sub">— nama pihak penyuplai / tempat belanja</span>
                                </label>
                                <input type="text" name="supplier" required placeholder="Contoh: Toko Kopi Sumber Jaya" class="form-input" id="restock-supplier">
                            </div>

                            <button type="submit" class="btn-primary" id="btn-restock">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="flex-shrink:0">
                                    <line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>
                                </svg>
                                Tambah ke Gudang
                            </button>
                        </form>
                    </div>
                    @endif

                    {{-- === SUB-BAGIAN B: PENYUSUTAN BAHAN BAKU (Semua Role) === --}}
                    <div class="form-card">
                        <div class="form-card-header">
                            <span class="header-icon orange">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="color:#ea580c">
                                    <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/>
                                    <line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/>
                                </svg>
                            </span>
                            <h3>Pencatatan Penyusutan Bahan Baku</h3>
                        </div>
                        <div class="form-body">
                            <div class="penyusutan-notice">
                                <div class="penyusutan-notice-icon">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/>
                                    </svg>
                                </div>
                                <p>
                                    <strong>Penyusutan Bahan Baku</strong> digunakan untuk mencatat pengurangan bahan baku yang disebabkan oleh kejadian di luar proses penjualan normal, seperti bahan yang rusak, tumpah, kadaluarsa, atau terbuang dalam proses produksi. Bahan baku akan berkurang sesuai jumlah yang dicatat.
                                </p>
                            </div>

                            <form action="{{ route('dashboard.penyusutan') }}" method="POST" id="form-penyusutan">
                                @csrf
                                <div class="form-group">
                                    <label class="form-label" for="susut-bahan">
                                        Pilih Bahan Baku
                                        <span class="form-label-sub">— bahan yang mengalami penyusutan</span>
                                    </label>
                                    <select name="bahan_id" required class="form-select" id="susut-bahan" onchange="updateStokInfo(this)">
                                        <option value="">-- Pilih Barang --</option>
                                        @foreach($semuaBahan as $bahan)
                                            <option value="{{ $bahan->id }}"
                                                    data-stok="{{ $bahan->stok_sisa }}"
                                                    data-satuan="{{ $bahan->satuan }}">
                                                {{ $bahan->nama_bahan }} — stok: {{ number_format($bahan->stok_sisa, 0, ',', '.') }} {{ $bahan->satuan }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div id="stok-info" style="display:none; margin-top:8px; padding:8px 12px; background:#f0fdf4; border:1px solid #bbf7d0; border-radius:6px; font-size:13px; color:#166534;">
                                        <strong>Stok saat ini:</strong> <span id="stok-info-value">-</span>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="form-label" for="susut-jumlah">
                                        Jumlah Penyusutan
                                        <span class="form-label-sub">— jumlah yang rusak/tumpah/terbuang</span>
                                    </label>
                                    <input type="number" name="jumlah_susut" min="1" required placeholder="Contoh: 500" class="form-input" id="susut-jumlah">
                                    @error('jumlah_susut')
                                        <div class="form-error">
                                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label class="form-label" for="susut-jenis">
                                        Jenis Penyusutan
                                        <span class="form-label-sub">— pilih penyebab penyusutan stok</span>
                                    </label>
                                    <select name="jenis_penyusutan" required class="form-select" id="susut-jenis">
                                        <option value="">-- Pilih Jenis Penyusutan --</option>
                                        <option value="Kerusakan">Kerusakan — bahan cacat atau tidak layak pakai</option>
                                        <option value="Tumpah">Tumpah — bahan tumpah atau tercecer saat penanganan</option>
                                        <option value="Kadaluarsa">Kadaluarsa — bahan melewati tanggal kedaluarsa</option>
                                        <option value="Terbuang Proses Produksi">Terbuang Proses Produksi — sisa tidak terpakai dari proses pembuatan</option>
                                        <option value="Lainnya">Lainnya — penyebab lain (jelaskan di keterangan)</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label class="form-label" for="susut-keterangan">
                                        Keterangan Tambahan
                                        <span class="form-label-sub">— opsional, tambahkan detail kejadian</span>
                                    </label>
                                    <textarea name="keterangan" id="susut-keterangan" class="form-textarea"
                                              placeholder="Contoh: Susu tumpah saat proses steaming pada shift pagi tanggal 23 Juli 2026"></textarea>
                                </div>

                                <button type="submit" class="btn-danger-submit" id="btn-penyusutan">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="flex-shrink:0">
                                        <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/>
                                        <line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/>
                                    </svg>
                                    Catat Penyusutan Bahan Baku
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                @if(Auth::user()->isAdmin())
                {{-- ============================================= --}}
                {{-- SECTION 4: CETAK LAPORAN PDF (Admin Only)     --}}
                {{-- ============================================= --}}
                <div class="section-page" id="section-cetak-laporan">
                    <div class="report-card">
                        <div class="report-card-header">
                            <span class="header-icon blue">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <polyline points="6 9 6 2 18 2 18 9"/>
                                    <path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/>
                                    <rect x="6" y="14" width="12" height="8"/>
                                </svg>
                            </span>
                            <h3>Cetak Laporan PDF</h3>
                        </div>
                        <div class="report-body">
                            <div class="report-icon">
                                <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" style="color:#94a3b8">
                                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                                    <polyline points="14 2 14 8 20 8"/>
                                    <line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/>
                                </svg>
                            </div>
                            <h4>Laporan Aktivitas Log Gudang</h4>
                            <p>
                                Unduh riwayat mutasi stok gudang dalam format PDF.<br>
                                Gunakan filter di bawah untuk mencetak laporan pada periode tertentu.
                            </p>

                            {{-- Filter Tanggal --}}
                            <div class="filter-section">
                                <div class="filter-section-title">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="color:#6b7280">
                                        <polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"/>
                                    </svg>
                                    Filter Periode Laporan
                                </div>
                                <div class="filter-row">
                                    <div class="filter-group">
                                        <label for="tanggal-mulai">Tanggal Mulai</label>
                                        <input type="date" id="tanggal-mulai" class="form-input" style="font-size:13px;">
                                    </div>
                                    <div class="filter-group">
                                        <label for="tanggal-selesai">Tanggal Selesai</label>
                                        <input type="date" id="tanggal-selesai" class="form-input" style="font-size:13px;">
                                    </div>
                                </div>
                                <p style="font-size:12px;color:#94a3b8;margin-top:10px;text-align:left;">
                                    Biarkan kosong untuk mencetak semua riwayat tanpa filter tanggal.
                                </p>
                            </div>

                            <button onclick="cetakLaporanPdf()" class="btn-report" id="btn-cetak-pdf">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="flex-shrink:0">
                                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                                    <polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/>
                                </svg>
                                Unduh Laporan PDF
                            </button>
                        </div>
                    </div>
                </div>
                @endif

            </div>
        </main>
    </div>

    <script>
        // Page title mapping — disesuaikan berdasarkan role
        const isAdmin = {{ Auth::user()->isAdmin() ? 'true' : 'false' }};

        const pageTitles = {
            'monitoring':           { title: 'Live Monitoring Stok',       subtitle: 'Pantau kondisi stok bahan baku gudang secara real-time' },
            'riwayat':              { title: 'Riwayat Aktivitas',          subtitle: 'Catatan log mutasi stok gudang' },
            'kelola-bahan-baku':    { title: 'Kelola Bahan Baku',          subtitle: 'Input restock supplier & catat penyusutan bahan baku' },
            'cetak-laporan':        { title: 'Cetak Laporan PDF',          subtitle: 'Unduh laporan mutasi stok dalam format PDF dengan filter periode' },
        };

        function showSection(sectionId, navBtn) {
            document.querySelectorAll('.section-page').forEach(el => el.classList.remove('active'));
            document.querySelectorAll('.nav-item').forEach(el => el.classList.remove('active'));

            const target = document.getElementById('section-' + sectionId);
            if (target) target.classList.add('active');

            if (navBtn) navBtn.classList.add('active');

            const info = pageTitles[sectionId];
            if (info) {
                document.getElementById('page-title').textContent = info.title;
                document.getElementById('page-subtitle').textContent = info.subtitle;
            }

            if (window.innerWidth <= 768) {
                toggleSidebar();
            }
        }

        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('open');
            document.getElementById('overlay').classList.toggle('active');
        }

        // ===== HAPUS RIWAYAT: Konfirmasi sebelum hapus =====
        function konfirmasiHapus(event, namaBahan, tanggal) {
            const konfirmasi = confirm(
                `⚠️ Hapus Record Riwayat?\n\n` +
                `Bahan: ${namaBahan}\n` +
                `Tanggal: ${tanggal}\n\n` +
                `Tindakan ini tidak dapat dibatalkan.`
            );
            if (!konfirmasi) {
                event.preventDefault();
                return false;
            }
            return true;
        }

        // ===== FILTER / CARI RIWAYAT =====
        function filterRiwayat(keyword) {
            const rows = document.querySelectorAll('.riwayat-row');
            const q = keyword.toLowerCase().trim();
            let visibleCount = 0;

            rows.forEach(row => {
                const searchData = row.getAttribute('data-search') || '';
                if (searchData.includes(q)) {
                    row.style.display = '';
                    visibleCount++;
                } else {
                    row.style.display = 'none';
                }
            });

            const badgeEl = document.getElementById('badge-riwayat-count');
            if (badgeEl) {
                badgeEl.textContent = visibleCount + ' log' + (q ? ' ditemukan' : '');
            }
        }

        // ===== INFO STOK SAAT INI (di form penyusutan) =====
        function updateStokInfo(selectEl) {
            const option = selectEl.options[selectEl.selectedIndex];
            const infoEl = document.getElementById('stok-info');
            const valueEl = document.getElementById('stok-info-value');

            if (selectEl.value && option) {
                const stok = parseInt(option.getAttribute('data-stok')).toLocaleString('id-ID');
                const satuan = option.getAttribute('data-satuan');
                valueEl.textContent = `${stok} ${satuan}`;
                infoEl.style.display = 'block';
            } else {
                infoEl.style.display = 'none';
            }
        }

        // ===== CETAK LAPORAN PDF DENGAN FILTER TANGGAL =====
        function cetakLaporanPdf() {
            const mulai = document.getElementById('tanggal-mulai').value;
            const selesai = document.getElementById('tanggal-selesai').value;

            // Validasi: jika salah satu diisi, keduanya harus diisi
            if ((mulai && !selesai) || (!mulai && selesai)) {
                alert('⚠️ Harap isi kedua tanggal (mulai dan selesai) untuk menggunakan filter, atau kosongkan keduanya untuk cetak semua data.');
                return;
            }

            // Validasi: tanggal mulai tidak boleh setelah tanggal selesai
            if (mulai && selesai && mulai > selesai) {
                alert('⚠️ Tanggal mulai tidak boleh lebih besar dari tanggal selesai.');
                return;
            }

            let url = '{{ route("laporan.riwayat.pdf") }}';
            if (mulai && selesai) {
                url += '?tanggal_mulai=' + mulai + '&tanggal_selesai=' + selesai;
            }

            window.open(url, '_blank');
        }

        // ===== AUTO REDIRECT SETELAH OPERASI =====
        @if(session('success'))
            // Setelah restock → ke monitoring
            @if(str_contains(session('success'), 'berhasil ditambah'))
                showSection('monitoring', document.getElementById('nav-monitoring'));
            @elseif(str_contains(session('success'), 'Penyusutan'))
                // Setelah penyusutan → ke monitoring untuk melihat stok terbaru
                showSection('monitoring', document.getElementById('nav-monitoring'));
            @elseif(str_contains(session('success'), 'dihapus'))
                // Setelah hapus riwayat → tetap di riwayat
                showSection('riwayat', document.getElementById('nav-riwayat'));
            @else
                showSection('monitoring', document.getElementById('nav-monitoring'));
            @endif
        @endif

        @if($errors->any())
            // Jika ada error validasi penyusutan, kembali ke halaman kelola bahan baku
            showSection('kelola-bahan-baku', document.getElementById('nav-kelola'));
        @endif

        // Toast auto-dismiss setelah 5 detik
        setTimeout(() => {
            const toast = document.getElementById('toast-notif');
            if (toast) toast.style.opacity = '0', toast.style.transition = 'opacity 0.5s', setTimeout(() => toast.remove(), 500);
            const toastErr = document.getElementById('toast-error');
            if (toastErr) toastErr.style.opacity = '0', toastErr.style.transition = 'opacity 0.5s', setTimeout(() => toastErr.remove(), 500);
        }, 5000);
    </script>
</body>
</html>