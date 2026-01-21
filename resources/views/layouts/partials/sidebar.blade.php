<div id="scrollbar">
    <div class="container-fluid">
        <ul class="navbar-nav" id="navbar-nav">
            <li class="menu-title"><span data-key="t-menu">Menu</span></li>
            <li class="nav-item">
                <a href="{{ route('hris.index') }}" class="nav-link {{ request()->is('hris') ? 'active' : '' }}"><i class="ri-dashboard-2-line"></i> <span data-key="t-dashboards">Dashboards</span></a>
            </li>
            

            <li class="nav-item">
                <a class="nav-link menu-link {{ request()->is('master*') ? 'active' : '' }}" 
                   href="#sidebarMasterData" 
                   data-bs-toggle="collapse" 
                   role="button" 
                   aria-expanded="{{ request()->is('master*') ? 'true' : 'false' }}" 
                   aria-controls="sidebarMasterData">
                    <i class="ri-stack-line"></i> <span data-key="t-master-data">Master Data</span>
                </a>
                <div class="collapse menu-dropdown {{ request()->is('master*') ? 'show' : '' }}" id="sidebarMasterData">
                    <ul class="nav nav-sm flex-column">
                        <li class="nav-item">
                            <a href="#" class="nav-link {{ request()->is('master/rektorat*') ? 'active' : '' }}">Master Rektorat</a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link {{ request()->is('master/direktorat*') ? 'active' : '' }}">Master Direktorat</a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link {{ request()->is('master/bagian*') ? 'active' : '' }}">Master Bagian</a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link {{ request()->is('master/jabatan-struktural*') ? 'active' : '' }}">Master Jabatan Struktural</a>
                        </li>
                    </ul>
                </div>
            </li>

            <li class="nav-item">
                <a class="nav-link menu-link {{ request()->is('pegawai*') ? 'active' : '' }}" 
                   href="#sidebarManajemenKepegawaians" 
                   data-bs-toggle="collapse" 
                   role="button" 
                   aria-expanded="{{ request()->is('pegawai*') ? 'true' : 'false' }}" 
                   aria-controls="sidebarManajemenKepegawaians">
                    <i class="ri-pages-line"></i> <span data-key="t-pages">Manajemen Pegawai</span>
                </a>
                <div class="collapse menu-dropdown {{ request()->is('pegawai*') ? 'show' : '' }}" id="sidebarManajemenKepegawaians">
                    <ul class="nav nav-sm flex-column">
                        <li class="nav-item">
                            <a href="#" class="nav-link {{ request()->is('pegawai/daftar*') ? 'active' : '' }}"> Daftar Pegawai </a>
                        </li>
                        <li class="nav-item">
                            <a href="#sidebarDokumen" 
                               class="nav-link {{ request()->is('pegawai/dokumen*') ? 'active' : '' }}" 
                               data-bs-toggle="collapse" 
                               role="button" 
                               aria-expanded="{{ request()->is('pegawai/dokumen*') ? 'true' : 'false' }}"> 
                               Dokumen 
                            </a>
                            <div class="collapse menu-dropdown {{ request()->is('pegawai/dokumen*') ? 'show' : '' }}" id="sidebarDokumen">
                                <ul class="nav nav-sm flex-column">
                                    <li class="nav-item">
                                        <a href="#" class="nav-link {{ request()->is('pegawai/dokumen/surat-tugas') ? 'active' : '' }}"> Surat Tugas </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#" class="nav-link {{ request()->is('pegawai/dokumen/kontrak*') ? 'active' : '' }}"> Kontrak Pengajar </a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                    </ul>
                </div>
            </li>

            <li class="nav-item">
                <a class="nav-link menu-link {{ request()->is('presensi*') ? 'active' : '' }}" 
                   href="#sidebarManajemenPresensi" 
                   data-bs-toggle="collapse" 
                   role="button" 
                   aria-expanded="{{ request()->is('presensi*') ? 'true' : 'false' }}">
                    <i class="ri-timer-line"></i> <span>Manajemen Presensi</span>
                </a>
                <div class="collapse menu-dropdown {{ request()->is('presensi*') ? 'show' : '' }}" id="sidebarManajemenPresensi">
                    <ul class="nav nav-sm flex-column">
                        <li class="nav-item">
                            <a href="#" class="nav-link {{ request()->is('presensi/shift*') ? 'active' : '' }}"> Master Shift </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link {{ request()->is('presensi/laporan*') ? 'active' : '' }}"> Laporan Presensi </a>
                        </li>
                    </ul>
                </div>
            </li>

            <li class="nav-item">
                <a class="nav-link menu-link {{ request()->is('hris/modul*') ? 'active' : '' }}" 
                   href="#sidebarManajemenAplikasi" 
                   data-bs-toggle="collapse" 
                   role="button" 
                   aria-expanded="{{ request()->is('hris/modul*') ? 'true' : 'false' }}">
                    <i class="ri-settings-line"></i> <span>Manajemen Aplikasi</span>
                </a>
                <div class="collapse menu-dropdown {{ request()->is('hris/modul*') ? 'show' : '' }}" id="sidebarManajemenAplikasi">
                    <ul class="nav nav-sm flex-column">
                        <li class="nav-item">
                            <a href="{{ route('hris.daftar-module.index') }}" 
                               class="nav-link {{ request()->routeIs('hris.daftar-module.*') ? 'active' : '' }}">
                                Daftar Module
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('hris.daftar-role.index') }}" 
                               class="nav-link {{ request()->routeIs('hris.daftar-role.*') ? 'active' : '' }}">
                                Daftar Role
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('hris.daftar-permission.index') }}" 
                               class="nav-link {{ request()->routeIs('hris.daftar-permission.*') ? 'active' : '' }}">
                                Daftar Permission
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('hris.daftar-user.index') }}" 
                               class="nav-link {{ request()->routeIs('hris.daftar-user.*') ? 'active' : '' }}">
                                Daftar User
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
        </ul>
    </div>
</div>