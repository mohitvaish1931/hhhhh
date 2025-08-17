// Global variables
let currentPage = 1;
let currentCategory = 1;
let isLoading = false;
let hasMoreVideos = true;

// Initialize the application
document.addEventListener('DOMContentLoaded', function() {
    loadVideos('all');
    setupInfiniteScroll();
    setupMobileMenu();
    loadCategories();
});

// Load videos based on type
function loadVideos(type = 'all', page = 1, append = false) {
    if (isLoading) return;
    
    isLoading = true;
    showLoading();
    
    let url = 'api/videos.php';
    let params = new URLSearchParams({
        page: page,
        limit: 12
    });
    
    if (type === 'search') {
        const searchQuery = document.getElementById('searchInput').value;
        params.append('action', 'search');
        params.append('q', searchQuery);
    } else if (type === 'trending') {
        params.append('action', 'trending');
    } else if (type !== 'all') {
        params.append('action', 'category');
        params.append('category_id', type);
    }
    
    fetch(`${url}?${params}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                displayVideos(data.videos, append);
                hasMoreVideos = data.videos.length === 12;
            } else {
                console.error('Error loading videos:', data.error);
            }
        })
        .catch(error => {
            console.error('Error:', error);
        })
        .finally(() => {
            isLoading = false;
            hideLoading();
        });
}

// Display videos in the grid
function displayVideos(videos, append = false) {
    const videoGrid = document.getElementById('video-grid');
    
    if (!append) {
        videoGrid.innerHTML = '';
    }
    
    videos.forEach(video => {
        const videoCard = createVideoCard(video);
        videoGrid.appendChild(videoCard);
    });
}

// Create a video card element
function createVideoCard(video) {
    const card = document.createElement('div');
    card.className = 'video-card';
    card.onclick = () => playVideo(video.video_url, video.id);
    
    // Extract YouTube video ID for thumbnail
    const videoId = extractYouTubeId(video.video_url);
    const thumbnailUrl = video.thumbnail_url || `https://img.youtube.com/vi/${videoId}/maxresdefault.jpg`;
    
    card.innerHTML = `
        <div class="video-thumbnail">
            <img src="${thumbnailUrl}" alt="${escapeHtml(video.title)}" style="width: 100%; height: 100%; object-fit: cover;">
            <div class="video-options">
                <div class="dropdown">
                    <button class="options-btn" data-bs-toggle="dropdown">
                        <i class="fa-solid fa-ellipsis-vertical"></i>
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#" onclick="addToQueue(${video.id})">
                            <i class="fa-solid fa-bars"></i><span>Add to queue</span>
                        </a></li>
                        <li><a class="dropdown-item" href="#" onclick="saveToWatchLater(${video.id})">
                            <i class="fa-solid fa-clock-rotate-left"></i><span>Save to Watch Later</span>
                        </a></li>
                        <li><a class="dropdown-item" href="#" onclick="saveToPlaylist(${video.id})">
                            <i class="fa-solid fa-bookmark"></i><span>Save to playlist</span>
                        </a></li>
                        <li><a class="dropdown-item" href="#" onclick="shareVideo(${video.id})">
                            <i class="fa-solid fa-share-from-square"></i><span>Share</span>
                        </a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="video-info">
            <div class="video-meta">
                <img src="${video.profile_image}" alt="${escapeHtml(video.username)}" class="channel-avatar">
                <div class="video-details">
                    <h3 class="video-title">${escapeHtml(video.title)}</h3>
                    <p class="video-channel">${escapeHtml(video.username)}</p>
                    <p class="video-stats">${video.views_formatted} views • ${video.time_ago}</p>
                </div>
            </div>
        </div>
    `;
    
    return card;
}

// Load videos by category
function loadVideosByCategory(categoryId) {
    currentCategory = categoryId;
    currentPage = 1;
    hasMoreVideos = true;
    
    // Update active category button
    document.querySelectorAll('.category-btn').forEach(btn => {
        btn.classList.remove('active');
    });
    document.querySelector(`[data-category="${categoryId}"]`)?.classList.add('active');
    
    loadVideos(categoryId);
}

// Search functionality
function searchVideos() {
    const searchInput = document.getElementById('searchInput');
    const query = searchInput.value.trim();
    
    if (query) {
        currentPage = 1;
        hasMoreVideos = true;
        loadVideos('search');
    }
}

// Handle Enter key in search input
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchInput');
    if (searchInput) {
        searchInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                searchVideos();
            }
        });
    }
});

// Play video function
function playVideo(videoUrl, videoId) {
    // Increment view count
    fetch('api/videos.php?action=view', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ video_id: videoId })
    });
    
    // Open video in new tab
    window.open(videoUrl, '_blank');
}

// Upload video function
function uploadVideo() {
    const form = document.getElementById('uploadForm');
    const formData = new FormData(form);
    
    const videoData = {
        title: formData.get('title'),
        description: formData.get('description'),
        video_url: formData.get('video_url'),
        thumbnail_url: formData.get('thumbnail_url'),
        category_id: formData.get('category_id')
    };
    
    fetch('api/videos.php?action=upload', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify(videoData)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Video uploaded successfully!');
            document.getElementById('uploadForm').reset();
            bootstrap.Modal.getInstance(document.getElementById('uploadModal')).hide();
            loadVideos('all'); // Refresh video list
        } else {
            alert('Error uploading video: ' + data.error);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error uploading video');
    });
}

// Load categories for upload form
function loadCategories() {
    fetch('api/videos.php')
        .then(response => response.json())
        .then(data => {
            // This would typically load categories from a separate endpoint
            // For now, we'll populate with default categories
            const categorySelect = document.getElementById('videoCategory');
            if (categorySelect) {
                const categories = [
                    {id: 1, name: 'All'},
                    {id: 2, name: 'Music'},
                    {id: 3, name: 'JavaScript'},
                    {id: 4, name: 'Gaming'},
                    {id: 5, name: 'Stories'},
                    {id: 6, name: 'Blogs'},
                    {id: 7, name: 'Podcast'},
                    {id: 8, name: 'English Learning'},
                    {id: 9, name: 'Web Series'},
                    {id: 10, name: 'Live'},
                    {id: 11, name: 'Recently Uploaded'},
                    {id: 12, name: 'New To You'}
                ];
                
                categories.forEach(category => {
                    if (category.id !== 1) { // Skip 'All' category for upload
                        const option = document.createElement('option');
                        option.value = category.id;
                        option.textContent = category.name;
                        categorySelect.appendChild(option);
                    }
                });
            }
        });
}

// Infinite scroll setup
function setupInfiniteScroll() {
    window.addEventListener('scroll', () => {
        if ((window.innerHeight + window.scrollY) >= document.body.offsetHeight - 1000) {
            if (!isLoading && hasMoreVideos) {
                currentPage++;
                loadVideos(currentCategory, currentPage, true);
            }
        }
    });
}

// Mobile menu setup
function setupMobileMenu() {
    const menuBtn = document.querySelector('.menu-btn');
    const sidebar = document.querySelector('.sidebar');
    
    if (menuBtn && sidebar) {
        menuBtn.addEventListener('click', () => {
            sidebar.classList.toggle('open');
        });
        
        // Close sidebar when clicking outside
        document.addEventListener('click', (e) => {
            if (!sidebar.contains(e.target) && !menuBtn.contains(e.target)) {
                sidebar.classList.remove('open');
            }
        });
    }
}

// Utility functions
function showLoading() {
    const loading = document.getElementById('loading');
    if (loading) loading.style.display = 'block';
}

function hideLoading() {
    const loading = document.getElementById('loading');
    if (loading) loading.style.display = 'none';
}

function extractYouTubeId(url) {
    const regExp = /^.*(youtu.be\/|v\/|u\/\w\/|embed\/|watch\?v=|&v=)([^#&?]*).*/;
    const match = url.match(regExp);
    return (match && match[2].length === 11) ? match[2] : null;
}

function escapeHtml(text) {
    const map = {
        '&': '&amp;',
        '<': '&lt;',
        '>': '&gt;',
        '"': '&quot;',
        "'": '&#039;'
    };
    return text.replace(/[&<>"']/g, function(m) { return map[m]; });
}

// Sidebar navigation functions
function loadShorts() {
    window.open('https://www.youtube.com/shorts', '_blank');
}

function loadSubscriptions() {
    window.open('https://www.youtube.com/feed/subscriptions', '_blank');
}

function loadHistory() {
    // This would typically load user's watch history
    alert('History feature coming soon!');
}

// Video action functions
function addToQueue(videoId) {
    alert('Added to queue!');
}

function saveToWatchLater(videoId) {
    alert('Saved to Watch Later!');
}

function saveToPlaylist(videoId) {
    alert('Save to playlist feature coming soon!');
}

function shareVideo(videoId) {
    if (navigator.share) {
        navigator.share({
            title: 'Check out this video',
            url: window.location.href
        });
    } else {
        // Fallback for browsers that don't support Web Share API
        navigator.clipboard.writeText(window.location.href);
        alert('Link copied to clipboard!');
    }
}