<header class="main-header">
    <nav class="navbar">
        <div class="nav-left">
            <div class="dropdown">
                <button class="menu-btn" data-bs-toggle="dropdown">
                    <i class="fa-solid fa-bars"></i>
                </button>
                <ul class="dropdown-menu sidebar-menu">
                    <li class="dropdown-item">
                        <a href="#" class="nav-link"><i class="fa-solid fa-house"></i><span>Home</span></a>
                    </li>
                    <li class="dropdown-item">
                        <a href="#" class="nav-link"><i class="fa-solid fa-circle-play"></i><span>Shorts</span></a>
                    </li>
                    <li class="dropdown-item">
                        <a href="#" class="nav-link"><i class="fa-solid fa-bell"></i><span>Subscriptions</span></a>
                    </li>
                    <hr>
                    <li class="dropdown-item">
                        <a href="#" class="nav-link"><span class="section-title">You ></span></a>
                    </li>
                    <li class="dropdown-item">
                        <a href="#" class="nav-link"><i class="fa-solid fa-clock-rotate-left"></i><span>History</span></a>
                    </li>
                    <li class="dropdown-item">
                        <a href="#" class="nav-link"><i class="fa-solid fa-bars"></i><span>Playlists</span></a>
                    </li>
                </ul>
            </div>
            
            <div class="logo">
                <img src="https://uxwing.com/wp-content/themes/uxwing/download/brands-and-social-media/youtube-logo-icon.png" alt="YouTube">
            </div>
        </div>

        <div class="nav-center">
            <div class="search-container">
                <input type="text" id="searchInput" placeholder="Search" class="search-input">
                <button onclick="searchVideos()" class="search-btn">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </button>
            </div>
            <button class="mic-btn">
                <i class="fa-solid fa-microphone"></i>
            </button>
        </div>

        <div class="nav-right">
            <div class="dropdown">
                <button class="create-btn" data-bs-toggle="dropdown">
                    <i class="fa-solid fa-plus"></i>
                    <span>Create</span>
                </button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#uploadModal">
                        <i class="fa-solid fa-video"></i><span>Upload Video</span>
                    </a></li>
                    <li><a class="dropdown-item" href="#">
                        <i class="fa-solid fa-wave-square"></i><span>Go Live</span>
                    </a></li>
                </ul>
            </div>

            <button class="notification-btn">
                <i class="fa-regular fa-bell"></i>
            </button>

            <div class="dropdown">
                <button class="profile-btn" data-bs-toggle="dropdown">
                    <img src="https://media.istockphoto.com/id/1300845620/vector/user-icon-flat-isolated-on-white-background-user-symbol-vector-illustration.jpg" alt="Profile">
                </button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="#"><i class="fa-brands fa-google"></i><span>Google Account</span></a></li>
                    <li><a class="dropdown-item" href="#"><i class="fa-solid fa-user"></i><span>Switch Account</span></a></li>
                    <li><a class="dropdown-item" href="#"><i class="fa-solid fa-right-from-bracket"></i><span>Sign Out</span></a></li>
                    <hr>
                    <li><a class="dropdown-item" href="#"><i class="fa-solid fa-gear"></i><span>Settings</span></a></li>
                </ul>
            </div>
        </div>
    </nav>
</header>