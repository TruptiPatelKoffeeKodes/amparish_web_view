<!-- Sidemenu -->
<div class="main-sidebar main-sidebar-sticky side-menu">
    <div class="sidemenu-logo">
        <a class="main-logo" href="<?= url('') ?>">
            <img src="<?= LOGO; ?>" class="header-brand-img desktop-logo" alt="logo">
            <img src="<?= LOGOICON; ?>" class="header-brand-img icon-logo" alt="logo">
            <img src="<?= LOGO; ?>" class="header-brand-img desktop-logo theme-logo" alt="logo">
            <img src="<?= LOGOICON; ?>" class="header-brand-img icon-logo theme-logo" alt="logo">
        </a>
    </div>
    <div class="main-sidebar-body">
        <ul class="nav">
            <li class="nav-label">Dashboard</li>
            <li class="nav-item ">
                <a class="nav-link" href="<?= url('') ?>"><i class="fe fe-airplay"></i><span
                        class="sidemenu-label">Dashboard</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link with-sub" href=""><i class="fe fe-box"></i><span
                        class="sidemenu-label">Master</span><i class="angle fe fe-chevron-right"></i></a>
                <ul class="nav-sub">
                    <li class="nav-sub-item ">
                        <a class="nav-sub-link" href="<?=url('master/account')?>">Account Opening</a>
                    </li>
                    <li class="nav-sub-item ">
                        <a class="nav-sub-link" href="<?=url('master/market')?>">Market</a>
                    </li>
                    <li class="nav-sub-item ">
                        <a class="nav-sub-link" href="<?=url('master/category')?>">Category</a>
                    </li>
                    <li class="nav-sub-item ">
                        <a class="nav-sub-link" href="<?=url('master/product')?>">Product</a>
                    </li>
                </ul>
            </li>

            <li class="nav-item ">
                <a class="nav-link" href="<?= url('sales') ?>"><i class="fe fe-box"></i><span
                        class="sidemenu-label">Sales</span></a>
            </li>
        </ul>

    </div>
</div>
<!-- End Sidemenu -->