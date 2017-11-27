<?php $permissions = $user->permissions; ?>

<nav id="sidebar">
  <div id="sidebar-scroll">
    <div class="sidebar-content">
      <div class="content-header content-header-fullrow px-15">
        <div class="content-header-section sidebar-mini-visible-b">
          <span class="content-header-item font-w700 font-size-xl float-left animated fadeIn">
            <span class="text-dual-primary-dark">i</span><span class="text-primary">s</span>
          </span>
        </div>
        <div class="content-header-section text-center align-parent sidebar-mini-hidden">
          <button type="button" class="btn btn-circle btn-dual-secondary d-lg-none align-v-r" data-toggle="layout" data-action="sidebar_close">
            <i class="fa fa-times text-danger"></i>
          </button>
          <div class="content-header-item">
            <a class="link-effect font-w700" href="{{ route('home') }}">
              <i class="si si-organization text-primary"></i>
              <span class="font-size-xl text-dual-primary-dark">INV</span><span class="font-size-xl text-primary">system</span>
            </a>
          </div>
        </div>
      </div>
      <div class="content-side content-side-full content-side-user px-10 align-parent">
        <div class="sidebar-mini-visible-b align-v animated fadeIn">
          <img class="img-avatar img-avatar32" src="{{ asset('assets/img/logo-black.png') }}" alt="">
        </div>
        <div class="sidebar-mini-hidden-b text-center">
          <a class="img-link" href="{{ route('home') }}">
            <img class="img-avatar" src="{{ asset('assets/img/logo-black.png') }}" alt="">
          </a>
          <ul class="list-inline mt-10">
            <li class="list-inline-item">
              <a class="link-effect text-dual-primary-dark font-size-xs font-w600 text-uppercase" href="{{ route('settings') }}">{{ $user->email }}</a>
            </li>
            <li class="list-inline-item">
              <a class="link-effect text-dual-primary-dark" data-toggle="layout" data-action="sidebar_style_inverse_toggle" href="javascript:void(0)">
                <i class="si si-drop"></i>
              </a>
            </li>
            <li class="list-inline-item">
              <a class="link-effect text-dual-primary-dark" href="{{ route('logout') }}">
                <i class="si si-logout"></i>
              </a>
            </li>
          </ul>
        </div>
      </div>
      <div class="content-side content-side-full">
        <ul class="nav-main">
          <li>
            <a href="{{ route('home') }}"><i class="si si-cup"></i><span class="sidebar-mini-hide">Beranda</span></a>
          </li>
          <li class="nav-main-heading"><span class="sidebar-mini-visible">SL</span><span class="sidebar-mini-hidden">Penjualan &amp; Pembelian</span></li>
          @if ($permissions['admin.sales'] == 1)
            <li>
              <a class="nav-submenu" data-toggle="nav-submenu" href="#"><i class="si si-basket"></i><span class="sidebar-mini-hide">Penjualan</span></a>
              <ul>
                <li>
                  <a href="{{ route('sales.new') }}">Buat Baru</a>
                </li>
                <li>
                  <a href="{{ route('sales.all') }}">Lihat Semua</a>
                </li>
              </ul>
            </li>
            <li>
              <a class="nav-submenu" data-toggle="nav-submenu" href="#"><i class="si si-action-undo"></i><span class="sidebar-mini-hide">Piutang</span></a>
              <ul>
                <li>
                  <a href="{{ route('receivable.new') }}">Buat Pelunasan</a>
                </li>
                <li>
                  <a href="{{ route('receivable.all') }}">Lihat Data Piutang</a>
                </li>
                <li>
                  <a href="{{ route('receivable.allInvoice') }}">Lihat Data Pelunasan</a>
                </li>
              </ul>
            </li>
          @endif

          @if ($permissions['admin.purchase'] == 1)
            <li>
              <a class="nav-submenu" data-toggle="nav-submenu" href="#"><i class="si si-basket-loaded"></i><span class="sidebar-mini-hide">Pembelian</span></a>
              <ul>
                <li>
                  <a href="{{ route('purchase.new') }}">Buat Baru</a>
                </li>
                <li>
                  <a href="{{ route('purchase.all') }}">Lihat Semua</a>
                </li>
              </ul>
            </li>
            <li>
              <a class="nav-submenu" data-toggle="nav-submenu" href="#"><i class="si si-action-redo"></i><span class="sidebar-mini-hide">Hutang</span></a>
              <ul>
                <li>
                  <a href="{{ route('debt.new') }}">Buat Pelunasan</a>
                </li>
                <li>
                  <a href="{{ route('debt.all') }}">Lihat Data Hutang</a>
                </li>
                <li>
                  <a href="{{ route('debt.allInvoice') }}">Lihat Data Pelunasan</a>
                </li>
              </ul>
            </li>
          @endif

          <li class="nav-main-heading"><span class="sidebar-mini-visible">ST</span><span class="sidebar-mini-hidden">Stok &amp; Supplier</span></li>

          @if ($permissions['admin.item'] == 1)
            <li>
              <a class="nav-submenu" data-toggle="nav-submenu" href="#"><i class="si si-bag"></i><span class="sidebar-mini-hide">Barang</span></a>
              <ul>
                <li>
                  <a href="{{ route('item.new') }}">Buat Baru</a>
                </li>
                <li>
                  <a href="{{ route('item.all') }}">Lihat Semua</a>
              </ul>
            </li>
          @endif

          @if ($permissions['admin.item'] == 1)
            <li>
              <a class="nav-submenu" data-toggle="nav-submenu" href="#"><i class="si si-people"></i><span class="sidebar-mini-hide">Supplier</span></a>
              <ul>
                <li>
                  <a href="{{ route('supplier.new') }}">Buat Baru</a>
                </li>
                <li>
                  <a href="{{ route('supplier.all') }}">Lihat Semua</a>
              </ul>
            </li>
          @endif

          @if ($permissions['admin.client'] == 1)
            <li>
              <a class="nav-submenu" data-toggle="nav-submenu" href="#"><i class="si si-emotsmile"></i><span class="sidebar-mini-hide">Klien</span></a>
              <ul>
                <li>
                  <a href="{{ route('client.new') }}">Buat Baru</a>
                </li>
                <li>
                  <a href="{{ route('client.all') }}">Lihat Semua</a>
                </li>
                <li>
                  <a href="{{ route('client.regional') }}">Regional Klien</a>
                </li>
              </ul>
            </li>
          @endif

          <li class="nav-main-heading"><span class="sidebar-mini-visible">OT</span><span class="sidebar-mini-hidden">Lain</span></li>

          @if ($permissions['admin.expense'] == 1)
            <li>
              <a class="nav-submenu" data-toggle="nav-submenu" href="#"><i class="si si-diamond"></i><span class="sidebar-mini-hide">Biaya</span></a>
              <ul>
                <li>
                  <a href="{{ route('expense.new') }}">Tambah</a>
                </li>
                <li>
                  <a href="{{ route('expense.all') }}">Lihat Semua</a>
                </li>
              </ul>
            </li>
          @endif

          @if ($permissions['admin.user'] == 1)
            <li>
              <a class="nav-submenu" data-toggle="nav-submenu" href="#"><i class="si si-user-follow"></i><span class="sidebar-mini-hide">Pengguna</span></a>
              <ul>
                <li>
                  <a href="{{ route('user.new') }}">Tambah</a>
                </li>
                <li>
                  <a href="{{ route('user.all') }}">Lihat Semua</a>
                </li>
              </ul>
            </li>
          @endif

          <li>
            <a class="nav-submenu" data-toggle="nav-submenu" href="#"><i class="si si-drawer"></i><span class="sidebar-mini-hide">Laporan</span></a>
            <ul>
              @if ($permissions['admin.sales'] == 1)
                <li>
                  <a href="{{ route('receivable.report') }}">Piutang Klien</a>
                </li>
                </li>
                  <a href="{{ route('sales.report') }}">Penjualan Per Klien</a>
                </li>
              @endif

              @if ($permissions['admin.purchase'] == 1)
                </li>
                  <a href="{{ route('purchase.report') }}">Pembelian Per Supplier</a>
                </li>
              @endif

              @if ($permissions['admin.expense'] == 1)
                <li>
                  <a href="{{ route('expense.report') }}">Biaya</a>
                </li>
              @endif

              @if ($permissions['admin.item'] == 1)
                <li>
                  <a href="{{ route('item.report') }}"">Histori Item</a>
                </li>
                <li>
                  <a href="{{ route('item.profit.report') }}"">Profit Item</a>
                </li>
              @endif
            </ul>
          </li>
        </ul>
      </div>
    </div>
  </div>
</nav>
