```blade
<style>
    .school-footer {
        background: #ffffff;
        border-top: 1px solid #e5e7eb;
        color: #6b7280;
        padding: 14px 20px;
        font-size: 13px;
        line-height: 1.5;
    }

    .school-footer strong {
        color: #374151;
        font-weight: 600;
    }

    .school-footer a {
        color: #047857;
        font-weight: 600;
        text-decoration: none;
        transition: color 0.15s ease;
    }

    .school-footer a:hover {
        color: #059669;
        text-decoration: none;
    }

    .school-footer .footer-version {
        color: #6b7280;
        font-size: 12.5px;
    }

    .school-footer .footer-version b {
        color: #374151;
        font-weight: 600;
    }

    /* Mobile */
    @media (max-width: 575.98px) {
        .school-footer {
            text-align: center;
            padding: 12px 15px;
            font-size: 12.5px;
        }

        .school-footer .float-right {
            float: none !important;
            display: block !important;
            margin-top: 4px;
        }
    }
</style>

<footer class="main-footer school-footer">

    <div>
        <strong>
            Copyright &copy; 2026
            <a href="{{ route('dashboard') }}">
                LMS Dashboard
            </a>.
        </strong>

        <span class="ml-1">
            All rights reserved.
        </span>
    </div>

    <div class="float-right d-none d-sm-inline-block footer-version">
        <b>Version</b> 1.0.0
    </div>

</footer>
```
