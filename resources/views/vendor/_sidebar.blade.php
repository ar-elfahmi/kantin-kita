{{--
    Canonical vendor dashboard sidebar partial.

    Required vars:
      - $vendor  (App\Models\Vendor)

    Active state is derived from the current route via request()->routeIs(...).

    Automatically includes the scan barcode modal (vendor.customer._scan_barcode_modal)
    via @once, so safe to include from any vendor page.
--}}

<style>
    .sidebar {
        width: 288px;
        flex-shrink: 0;
        background: var(--white);
        border-right: 1px solid var(--brown-10);
        display: flex;
        flex-direction: column;
        padding: 24px;
        gap: 48px;
        position: sticky;
        top: 0;
        height: 100vh;
        overflow-y: auto;
        z-index: 100;
        box-shadow: 2px 0 20px rgba(116, 70, 34, .04);
    }

    .sidebar-logo {
        display: flex;
        align-items: center;
        gap: 12px;
        text-decoration: none;
    }

    .logo-icon {
        width: 48px;
        height: 48px;
        background: var(--green);
        border-radius: var(--radius-md);
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        box-shadow: 0 4px 12px rgba(66, 118, 106, .35);
        transition: transform var(--transition), box-shadow var(--transition);
    }

    .logo-icon:hover {
        transform: scale(1.07);
        box-shadow: 0 6px 20px rgba(66, 118, 106, .45);
    }

    .logo-text-primary {
        font-size: 24px;
        font-weight: 700;
        color: var(--brown);
        letter-spacing: -.5px;
        line-height: 1.33;
    }

    .logo-text-secondary {
        font-size: 12px;
        font-weight: 500;
        color: var(--brown-60);
        letter-spacing: -.5px;
        line-height: 1.33;
    }

    .sidebar-nav {
        display: flex;
        flex-direction: column;
        gap: 8px;
        flex: 1;
    }

    .nav-item {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 12px 16px;
        border-radius: var(--radius-md);
        text-decoration: none;
        font-size: 16px;
        font-weight: 500;
        color: var(--brown-70);
        transition: background var(--transition), color var(--transition), transform var(--transition);
        cursor: pointer;
        position: relative;
        overflow: hidden;
    }

    .nav-item::before {
        content: '';
        position: absolute;
        inset: 0;
        background: var(--green-10);
        opacity: 0;
        transition: opacity var(--transition);
        border-radius: inherit;
    }

    .nav-item:hover::before {
        opacity: 1;
    }

    .nav-item:hover {
        color: var(--green);
        transform: translateX(3px);
    }

    .nav-item.active {
        background: var(--green-10);
        color: var(--green);
        font-weight: 600;
    }

    .nav-item.active::after {
        content: '';
        position: absolute;
        right: 0;
        top: 20%;
        height: 60%;
        width: 3px;
        background: var(--green);
        border-radius: 2px 0 0 2px;
    }

    .nav-icon {
        width: 20px;
        height: 20px;
        flex-shrink: 0;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .sidebar-footer {
        border-top: 1px solid var(--brown-10);
        padding-top: 24px;
    }

    .sidebar-user {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 12px 16px;
        border-radius: var(--radius-md);
        transition: background var(--transition);
        cursor: pointer;
    }

    .sidebar-user:hover {
        background: var(--cream);
    }

    .user-avatar {
        width: 40px;
        height: 40px;
        border-radius: var(--radius-pill);
        object-fit: cover;
        border: 2px solid var(--brown-10);
        flex-shrink: 0;
    }

    .avatar-initial {
        display: flex;
        align-items: center;
        justify-content: center;
        background: var(--brown-10);
        color: var(--brown);
        font-weight: 700;
        font-size: 16px;
        text-transform: uppercase;
    }

    .user-name {
        font-size: 14px;
        font-weight: 600;
        color: var(--brown);
        letter-spacing: -.5px;
        line-height: 1.43;
    }

    .user-email {
        font-size: 12px;
        font-weight: 400;
        color: var(--brown-60);
        letter-spacing: -.5px;
        line-height: 1.33;
    }

    .sidebar-logout {
        margin-left: auto;
        width: 16px;
        height: 16px;
        flex-shrink: 0;
        opacity: .6;
        transition: opacity var(--transition);
    }

    .sidebar-logout-btn {
        margin-left: auto;
        border: none;
        background: transparent;
        padding: 0;
        display: inline-flex;
        align-items: center;
        cursor: pointer;
    }

    .sidebar-user:hover .sidebar-logout {
        opacity: 1;
    }

    @media (max-width: 900px) {
        .dashboard-shell { flex-direction: column; }

        .sidebar {
            width: 100%;
            height: auto;
            position: static;
            padding: 14px 16px 12px;
            gap: 14px;
            border-right: none;
            border-bottom: 1px solid var(--brown-10);
            box-shadow: 0 2px 10px rgba(116, 70, 34, .08);
        }

        .sidebar-logo { justify-content: flex-start; }

        .sidebar-nav {
            flex-direction: row;
            overflow-x: auto;
            flex-wrap: nowrap;
            gap: 8px;
            padding-bottom: 4px;
        }

        .sidebar-nav::-webkit-scrollbar { display: none; }

        .nav-item {
            justify-content: flex-start;
            padding: 8px 12px;
            min-height: 36px;
            min-width: max-content;
            transform: none;
        }

        .nav-item::before,
        .nav-item.active::after { display: none; }

        .nav-item:hover { transform: none; }

        .nav-icon {
            width: 20px;
            height: 20px;
            border-radius: 0;
            background: transparent;
            border: none;
        }

        .nav-icon svg { width: 16px; height: 16px; }

        .nav-item .nav-icon svg path { fill: var(--brown) !important; }

        .nav-item.active { background: rgba(66, 118, 106, .14); }

        .nav-item.active .nav-icon svg path { fill: var(--green) !important; }

        .sidebar-user { padding: 10px 12px; }
    }

    @media (max-width: 640px) {
        .sidebar { width: 100%; padding: 12px; }
        .sidebar-logo { gap: 8px; }
        .logo-text-primary { font-size: 18px; }
        .logo-text-secondary { display: none; }
    }
</style>

<aside class="sidebar">
    <a href="{{ route('dashboard') }}" class="sidebar-logo">
        <div class="logo-icon">
            <img src="https://api.builder.io/api/v1/image/assets/TEMP/10a82c5c6d87de97d3583b6c8564df77f595f954?width=1114" alt="Kantin Kita Logo" style="width:100%;height:100%;object-fit:cover;border-radius:inherit;" />
        </div>
        <div>
            <div class="logo-text-primary">Kantin Kita</div>
            <div class="logo-text-secondary">Vendor Dashboard</div>
        </div>
    </a>

    <nav class="sidebar-nav">
        <a href="{{ route('dashboard') }}" class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <span class="nav-icon">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/>
                    <polyline points="9 22 9 12 15 12 15 22"/>
                </svg>
            </span>
            <span>Dashboard</span>
        </a>
        <a href="{{ route('dashboard.orders') }}" class="nav-item {{ request()->routeIs('dashboard.orders*') ? 'active' : '' }}">
            <span class="nav-icon">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M9 11l3 3L22 4"/>
                    <path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/>
                </svg>
            </span>
            <span>Kelola Pesanan</span>
        </a>
        <a href="{{ route('dashboard.menu') }}" class="nav-item {{ request()->routeIs('dashboard.menu*') ? 'active' : '' }}">
            <span class="nav-icon">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M3 7V5a2 2 0 0 1 2-2h2"/>
                    <path d="M17 3h2a2 2 0 0 1 2 2v2"/>
                    <path d="M3 17v2a2 2 0 0 0 2 2h2"/>
                    <path d="M17 21h2a2 2 0 0 0 2-2v-2"/>
                    <line x1="7" y1="8" x2="7" y2="16"/>
                    <line x1="10" y1="8" x2="10" y2="16"/>
                    <line x1="13" y1="8" x2="13" y2="16"/>
                    <line x1="16" y1="8" x2="16" y2="16"/>
                </svg>
            </span>
            <span>Kelola Produk</span>
        </a>
        <a href="{{ route('dashboard.customer.index') }}" class="nav-item {{ request()->routeIs('dashboard.customer.*') ? 'active' : '' }}">
            <span class="nav-icon">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                    <circle cx="8.5" cy="7" r="4"/>
                    <path d="M20 8v6"/>
                    <path d="M23 11h-6"/>
                </svg>
            </span>
            <span>Customer</span>
        </a>
        <a href="{{ route('dashboard.kunjungan.index') }}" class="nav-item {{ request()->routeIs('dashboard.kunjungan.*') ? 'active' : '' }}">
            <span class="nav-icon">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/>
                    <circle cx="12" cy="10" r="3"/>
                </svg>
            </span>
            <span>Kunjungan Toko</span>
        </a>
        <button type="button" class="nav-item" id="scanBarcodeBtn" style="border:none;background:none;width:100%;cursor:pointer;text-align:left;font:inherit;">
            <span class="nav-icon">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M3 7V5a2 2 0 0 1 2-2h2"/>
                    <path d="M17 3h2a2 2 0 0 1 2 2v2"/>
                    <path d="M3 17v2a2 2 0 0 0 2 2h2"/>
                    <path d="M17 21h2a2 2 0 0 0 2-2v-2"/>
                    <line x1="7" y1="11" x2="7" y2="14"/>
                    <line x1="11" y1="9" x2="11" y2="14"/>
                    <line x1="15" y1="7" x2="15" y2="14"/>
                </svg>
            </span>
            <span>Scan Barcode</span>
        </button>
    </nav>

    <div class="sidebar-footer">
        <div class="sidebar-user">
            <div class="user-avatar avatar-initial">{{ strtoupper(substr($vendor->nama_vendor, 0, 1)) }}</div>
            <div style="flex:1;min-width:0;">
                <div class="user-name">{{ $vendor->nama_vendor }}</div>
                <div class="user-email">{{ auth()->user()?->email ?? 'vendor@kantinkita.id' }}</div>
            </div>
            <form method="POST" action="{{ route('logout') }}" style="margin:0;">
                @csrf
                <button type="submit" class="sidebar-logout-btn" aria-label="Logout">
                    <svg class="sidebar-logout" width="16" height="16" viewBox="0 0 16 16" fill="none">
                        <path d="M11.8094 3.30938L15.6469 7.14687C15.8719 7.37187 16 7.68125 16 8C16 8.31875 15.8719 8.62812 15.6469 8.85312L11.8094 12.6906C11.6094 12.8906 11.3406 13 11.0594 13C10.475 13 10 12.525 10 11.9406V10H6C5.44688 10 5 9.55313 5 9V7C5 6.44688 5.44688 6 6 6H10V4.05937C10 3.475 10.475 3 11.0594 3C11.3406 3 11.6094 3.1125 11.8094 3.30938ZM5 3H3C2.44688 3 2 3.44688 2 4V12C2 12.5531 2.44688 13 3 13H5C5.55312 13 6 13.4469 6 14C6 14.5531 5.55312 15 5 15H3C1.34375 15 0 13.6562 0 12V4C0 2.34375 1.34375 1 3 1H5C5.55312 1 6 1.44687 6 2C6 2.55313 5.55312 3 5 3Z" fill="rgba(116,70,34,0.6)"/>
                    </svg>
                </button>
            </form>
        </div>
    </div>
</aside>

@include('vendor.customer._scan_barcode_modal')
