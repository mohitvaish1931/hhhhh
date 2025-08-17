<aside class="sidebar">
    <div class="sidebar-item active">
        <a href="#" onclick="loadVideos('all')" class="sidebar-link">
            <i class="fa-solid fa-house"></i>
            <span>Home</span>
        </a>
    </div>
    
    <div class="sidebar-item">
        <a href="#" onclick="loadShorts()" class="sidebar-link">
            <i class="fa-solid fa-circle-play"></i>
            <span>Shorts</span>
        </a>
    </div>
    
    <div class="sidebar-item">
        <a href="#" onclick="loadSubscriptions()" class="sidebar-link">
            <i class="fa-solid fa-bell"></i>
            <span>Subscriptions</span>
        </a>
    </div>
    
    <div class="sidebar-divider"></div>
    
    <div class="sidebar-section">
        <h3>You</h3>
        <div class="sidebar-item">
            <a href="#" onclick="loadHistory()" class="sidebar-link">
                <i class="fa-solid fa-clock-rotate-left"></i>
                <span>History</span>
            </a>
        </div>
        
        <div class="sidebar-item">
            <a href="#" class="sidebar-link">
                <i class="fa-solid fa-bars"></i>
                <span>Playlists</span>
            </a>
        </div>
        
        <div class="sidebar-item">
            <a href="#" class="sidebar-link">
                <i class="fa-solid fa-thumbs-up"></i>
                <span>Liked Videos</span>
            </a>
        </div>
    </div>
    
    <div class="sidebar-divider"></div>
    
    <div class="sidebar-section">
        <h3>Explore</h3>
        <div class="sidebar-item">
            <a href="#" onclick="loadVideosByCategory('trending')" class="sidebar-link">
                <i class="fa-solid fa-fire"></i>
                <span>Trending</span>
            </a>
        </div>
        
        <div class="sidebar-item">
            <a href="#" onclick="loadVideosByCategory('music')" class="sidebar-link">
                <i class="fa-solid fa-music"></i>
                <span>Music</span>
            </a>
        </div>
        
        <div class="sidebar-item">
            <a href="#" onclick="loadVideosByCategory('gaming')" class="sidebar-link">
                <i class="fa-solid fa-gamepad"></i>
                <span>Gaming</span>
            </a>
        </div>
        
        <div class="sidebar-item">
            <a href="#" onclick="loadVideosByCategory('news')" class="sidebar-link">
                <i class="fa-solid fa-newspaper"></i>
                <span>News</span>
            </a>
        </div>
    </div>
</aside>