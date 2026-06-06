{{--
    Vendor dashboard sidebar partial.
    Required vars:
      - $vendor  (App\Models\Vendor)

    Active state is derived from the current route via request()->routeIs(...).
    Used by:
      - vendor/customer/index.blade.php
      - vendor/customer/create-blob.blade.php
      - vendor/customer/create-path.blade.php
    NOT yet used by dashboard-vendor.blade.php or vendor/manage-menu.blade.php
    (those still inline the sidebar; deferred refactor).
--}}

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
                <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                    <path d="M2 2C2 1.44687 1.55313 1 1 1C0.446875 1 0 1.44687 0 2V12.5C0 13.8813 1.11875 15 2.5 15H15C15.5531 15 16 14.5531 16 14C16 13.4469 15.5531 13 15 13H2.5C2.225 13 2 12.775 2 12.5V2ZM14.7063 4.70625C15.0969 4.31563 15.0969 3.68125 14.7063 3.29063C14.3156 2.9 13.6812 2.9 13.2906 3.29063L10 6.58437L8.20625 4.79063C7.81563 4.4 7.18125 4.4 6.79063 4.79063L3.29063 8.29062C2.9 8.68125 2.9 9.31563 3.29063 9.70625C3.68125 10.0969 4.31563 10.0969 4.70625 9.70625L7.5 6.91563L9.29375 8.70938C9.68437 9.1 10.3188 9.1 10.7094 8.70938L14.7094 4.70937L14.7063 4.70625Z" fill="currentColor"/>
                </svg>
            </span>
            <span>Dashboard</span>
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
            <span>Tag Harga</span>
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
            <img class="user-avatar" src="https://api.builder.io/api/v1/image/assets/TEMP/087ab2dd772577a5a55f3825b36f4260590b6776?width=80" alt="{{ $vendor->nama_vendor }}">
            <div style="flex:1;min-width:0;">
                <div class="user-name">{{ $vendor->nama_vendor }}</div>
                <div class="user-email">{{ auth()->user()?->email ?? 'vendor@kantinkita.id' }}</div>
            </div>
            <form method="POST" action="{{ route('logout') }}" style="margin:0;">
                @csrf
                <button type="submit" class="sidebar-logout-btn" aria-label="Logout">
                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                        <path d="M11.8094 3.30938L15.6469 7.14687C15.8719 7.37187 16 7.68125 16 8C16 8.31875 15.8719 8.62812 15.6469 8.85312L11.8094 12.6906C11.6094 12.8906 11.3406 13 11.0594 13C10.475 13 10 12.525 10 11.9406V10H6C5.44688 10 5 9.55313 5 9V7C5 6.44688 5.44688 6 6 6H10V4.05937C10 3.475 10.475 3 11.0594 3C11.3406 3 11.6094 3.1125 11.8094 3.30938ZM5 3H3C2.44688 3 2 3.44688 2 4V12C2 12.5531 2.44688 13 3 13H5C5.55312 13 6 13.4469 6 14C6 14.5531 5.55312 15 5 15H3C1.34375 15 0 13.6562 0 12V4C0 2.34375 1.34375 1 3 1H5C5.55312 1 6 1.44687 6 2C6 2.55313 5.55312 3 5 3Z" fill="rgba(116,70,34,0.6)"/>
                    </svg>
                </button>
            </form>
        </div>
    </div>
</aside>

@include('vendor.customer._scan_barcode_modal')
