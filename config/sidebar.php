<?php

return [
    // Sidebar items: title, icon (FontAwesome), route or url, optional children
    'items' => [
        [
            'title' => 'Dashboard',
            'icon' => 'fas fa-tachometer-alt',
            'route' => 'dashboard',
            'active' => ['dashboard']
        ],
        [
            'title' => 'Customers',
            'icon' => 'fas fa-users',
            'route' => 'customers.index',
            'active' => ['customers*'],
        ],
        [
            'title' => 'Products',
            'icon' => 'fas fa-boxes',
            'route' => 'products.index',
            'active' => ['products*'],
        ],
        [
            'title' => 'Sales & CRM',
            'icon' => 'fas fa-handshake',
            'children' => [
                ['title' => 'Quotations', 'route' => 'quotations.index', 'icon' => 'fas fa-file-invoice-dollar', 'active' => ['quotations*']],
                ['title' => 'Sales Orders', 'route' => 'orders.index', 'icon' => 'fas fa-shopping-basket', 'active' => ['orders*']], // Re-purposed existing orders
                ['title' => 'Delivery Orders', 'route' => 'delivery-orders.index', 'icon' => 'fas fa-truck', 'active' => ['delivery-orders*']],
                ['title' => 'Invoices', 'route' => 'invoices.index', 'icon' => 'fas fa-file-invoice', 'active' => ['invoices*']],
                ['title' => 'Leads', 'route' => 'leads.index', 'icon' => 'fas fa-user-plus', 'active' => ['leads*']],
                ['title' => 'Opportunities', 'route' => 'opportunities.index', 'icon' => 'fas fa-funnel-dollar', 'active' => ['opportunities*']],
                ['title' => 'Follow-ups', 'route' => 'follow-ups.index', 'icon' => 'fas fa-calendar-check', 'active' => ['follow-ups*']],
            ],
        ],
        [
            'title' => 'Purchases',
            'icon' => 'fas fa-receipt',
            'route' => 'purchases.index',
            'active' => ['purchases*','suppliers*'],
        ],
        [
            'title' => 'Finance & Accounting',
            'icon' => 'fas fa-calculator',
            'children' => [
                ['title' => 'General Ledger', 'route' => 'finance.gl.index', 'icon' => 'fas fa-book', 'active' => ['finance.gl*', 'finance.gl.accounts*', 'finance.gl.transactions*']],
                ['title' => 'Accounts Payable', 'route' => 'finance.ap.index', 'icon' => 'fas fa-file-invoice-dollar', 'active' => ['finance.ap*', 'finance.ap.bills*']],
                ['title' => 'Accounts Receivable', 'route' => 'finance.ar.index', 'icon' => 'fas fa-hand-holding-usd', 'active' => ['finance.ar*', 'finance.ar.payments*']],
                ['title' => 'Fixed Assets', 'route' => 'finance.fixed-assets.index', 'icon' => 'fas fa-building', 'active' => ['finance.fixed-assets*']],
                ['title' => 'Bank Reconciliation', 'route' => 'finance.bank.reconciliation.index', 'icon' => 'fas fa-university', 'active' => ['finance.bank.reconciliation*', 'finance.bank-accounts*', 'finance.bank-transactions*']],
            ],
        ],
        [
            'title' => 'Reports',
            'icon' => 'fas fa-chart-line',
            'children' => [
                ['title' => 'Sales Report', 'route' => 'reports.sales', 'icon' => 'fas fa-chart-bar', 'active' => ['reports.sales']],
                ['title' => 'Inventory Report', 'route' => 'reports.inventory', 'icon' => 'fas fa-boxes', 'active' => ['reports.inventory']],
                ['title' => 'GL Account Statement', 'route' => 'reports.general-ledger-account-statement', 'icon' => 'fas fa-book-open', 'active' => ['reports.general-ledger-account-statement']],
            ],
            'active' => ['reports*'],
        ],
        [
            'title' => 'Settings',
            'icon' => 'fas fa-cog',
            'route' => 'settings.index',
            'active' => ['settings*'],
        ],
    ],
];
