@php
    use App\Models\NavigationMenu;
    $navMenus = NavigationMenu::with('activeChildren')
        ->parents()
        ->active()
        ->ordered()
        ->get();
@endphp

<nav class="navbar navbar-expand-lg">
    <div class="container-fluid">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" 
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                @foreach($navMenus as $menu)
                    @if($menu->is_dropdown && $menu->activeChildren->count() > 0)
                        {{-- Dropdown menu --}}
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="{{ $menu->url ?? '#' }}" 
                               id="navbarDropdown{{ $menu->id }}" role="button" 
                               data-bs-toggle="dropdown" aria-expanded="false">
                                @if($menu->icon)
                                    {!! getIcon($menu->icon, 'fs-3 me-1') !!}
                                @endif
                                {{ $menu->title }}
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown{{ $menu->id }}">
                                @foreach($menu->activeChildren as $child)
                                    <li>
                                        <a class="dropdown-item" href="{{ $child->url }}" 
                                           target="{{ $child->target }}">
                                            @if($child->icon)
                                                {!! getIcon($child->icon, 'fs-4 me-2') !!}
                                            @endif
                                            {{ $child->title }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </li>
                    @else
                        {{-- Simple menu item --}}
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is(trim($menu->url, '/')) ? 'active' : '' }}" 
                               href="{{ $menu->url }}" target="{{ $menu->target }}">
                                @if($menu->icon)
                                    {!! getIcon($menu->icon, 'fs-3 me-1') !!}
                                @endif
                                {{ $menu->title }}
                            </a>
                        </li>
                    @endif
                @endforeach
            </ul>
        </div>
    </div>
</nav>
