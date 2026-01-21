<div id="scrollbar">
    <div class="container-fluid">
        <ul class="navbar-nav" id="navbar-nav">
            @foreach($menus as $menu)
                @if($menu->is_title)
                    <li class="menu-title"><span data-key="{{ $menu->key }}">{{ $menu->title }}</span></li>
                @else
                    <li class="nav-item">
                        @if($menu->children->count() > 0)
                            {{-- Menu dengan Dropdown --}}
                            <a class="nav-link menu-link {{ request()->is($menu->slug.'*') ? 'active' : '' }}" 
                               href="#{{ $menu->target_id }}" 
                               data-bs-toggle="collapse" 
                               role="button" 
                               aria-expanded="{{ request()->is($menu->slug.'*') ? 'true' : 'false' }}" 
                               aria-controls="{{ $menu->target_id }}">
                                <i class="{{ $menu->icon }}"></i> <span>{{ $menu->title }}</span>
                            </a>
                            <div class="collapse menu-dropdown {{ request()->is($menu->slug.'*') ? 'show' : '' }}" id="{{ $menu->target_id }}">
                                <ul class="nav nav-sm flex-column">
                                    @foreach($menu->children as $child)
                                        <li class="nav-item">
                                            @if($child->children->count() > 0)
                                                {{-- Sub-dropdown (seperti menu Dokumen) --}}
                                                <a href="#{{ $child->target_id }}" 
                                                   class="nav-link {{ request()->is($child->slug.'*') ? 'active' : '' }}" 
                                                   data-bs-toggle="collapse" role="button" 
                                                   aria-expanded="{{ request()->is($child->slug.'*') ? 'true' : 'false' }}">
                                                   {{ $child->title }}
                                                </a>
                                                <div class="collapse menu-dropdown {{ request()->is($child->slug.'*') ? 'show' : '' }}" id="{{ $child->target_id }}">
                                                    <ul class="nav nav-sm flex-column">
                                                        @foreach($child->children as $grandChild)
                                                            <li class="nav-item">
                                                                <a href="{{ $grandChild->url }}" class="nav-link {{ request()->is(trim($grandChild->url, '/').'*') ? 'active' : '' }}">
                                                                    {{ $grandChild->title }}
                                                                </a>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            @else
                                                <a href="{{ $child->url }}" class="nav-link {{ request()->is(trim($child->slug, '/').'*') ? 'active' : '' }}">
                                                    {{ $child->title }}
                                                </a>
                                            @endif
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @else
                            {{-- Menu Single (seperti Dashboard) --}}
                            <a href="{{ $menu->url }}" class="nav-link {{ request()->is($menu->slug) ? 'active' : '' }}">
                                <i class="{{ $menu->icon }}"></i> <span>{{ $menu->title }}</span>
                            </a>
                        @endif
                    </li>
                @endif
            @endforeach
        </ul>
    </div>
</div>