<nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom shadow-sm">
    <div class="container">
        <a class="navbar-brand fw-bold" href="{{ route('home') }}">
            TechNewsPortal-TNP
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="mainNavbar">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('home') ? 'active fw-semibold' : '' }}" href="{{ route('home') }}">Home</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('blog.*') ? 'active fw-semibold' : '' }}" href="{{ route('blog.index') }}">Blog</a>
                </li>

                @auth
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('dashboard') ? 'active fw-semibold' : '' }}" href="{{ route('dashboard') }}">Dashboard</a>
                    </li>

                    {{-- Posts Dropdown --}}
                    @if(auth()->user()->hasAnyRole(['Super Admin', 'Editor', 'Author']))
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                                Posts
                            </a>

                            <ul class="dropdown-menu border-0 shadow">
                                {{-- Author --}}
                                @if(auth()->user()->hasRole('Author'))
                                    <li>
                                        <a class="dropdown-item" href="{{ route('author.posts.index') }}">
                                            My Posts
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="{{ route('author.posts.create') }}">
                                            Create Post
                                        </a>
                                    </li>
                                @endif

                                {{-- Editor / Super Admin --}}
                                @if(auth()->user()->hasAnyRole(['Editor', 'Super Admin']))
                                    <li>
                                        <a class="dropdown-item" href="{{ route('editor.reviews.index') }}">
                                            Review Posts
                                        </a>
                                    </li>

                                    {{-- ✅ NEW: Comment Moderation --}}
                                    <li>
                                        <a class="dropdown-item" href="{{ route('editor.comments.index') }}">
                                            Moderate Comments
                                        </a>
                                    </li>
                                @endif
                            </ul>
                        </li>
                    @endif

                    {{-- Author Panel --}}
                    @role('Author')
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('author.posts.index') }}">Author Panel</a>
                        </li>
                    @endrole

                    {{-- Editor Panel --}}
                    @role('Editor|Super Admin')
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('editor.reviews.index') }}">Editor Panel</a>
                        </li>
                    @endrole

                    {{-- Admin Panel --}}
                    @role('Super Admin')
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                                Admin Panel
                            </a>

                            <ul class="dropdown-menu border-0 shadow">
                                <li><a class="dropdown-item" href="{{ route('admin.users.index') }}">Users</a></li>
                                <li><a class="dropdown-item" href="{{ route('admin.roles.index') }}">Roles</a></li>
                                <li><a class="dropdown-item" href="{{ route('admin.permissions.index') }}">Permissions</a></li>
                                <li><a class="dropdown-item" href="{{ route('admin.categories.index') }}">Categories</a></li>
                                <li><a class="dropdown-item" href="{{ route('admin.tags.index') }}">Tags</a></li>
                                <li><a class="dropdown-item" href="{{ route('admin.settings.index') }}">Settings</a></li>
                            </ul>
                        </li>
                    @endrole
                @endauth
            </ul>

            {{-- Right side --}}
            <ul class="navbar-nav ms-auto">
                @guest
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="btn btn-primary btn-sm ms-lg-2" href="{{ route('register') }}">Register</a>
                    </li>
                @else
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle fw-semibold" href="#" data-bs-toggle="dropdown">
                            {{ auth()->user()->name }}
                        </a>

                        <ul class="dropdown-menu dropdown-menu-end shadow border-0">
                            <li>
                                <a class="dropdown-item" href="{{ route('profile.edit') }}">Profile</a>
                            </li>

                            <li><hr class="dropdown-divider"></li>

                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button class="dropdown-item text-danger" type="submit">Logout</button>
                                </form>
                            </li>
                        </ul>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>