<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>YouTube Clone</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
</head>
<body>
    <?php include 'includes/header.php'; ?>
    
    <main class="main-content">
        <?php include 'includes/sidebar.php'; ?>
        
        <div class="video-content">
            <?php include 'includes/category-filter.php'; ?>
            
            <div id="video-grid" class="video-grid">
                <!-- Videos will be loaded here via AJAX -->
            </div>
            
            <div id="loading" class="text-center mt-4" style="display: none;">
                <div class="spinner-border" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>
        </div>
    </main>

    <!-- Video Upload Modal -->
    <div class="modal fade" id="uploadModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Upload Video</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="uploadForm" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="videoTitle" class="form-label">Title</label>
                            <input type="text" class="form-control" id="videoTitle" name="title" required>
                        </div>
                        <div class="mb-3">
                            <label for="videoDescription" class="form-label">Description</label>
                            <textarea class="form-control" id="videoDescription" name="description" rows="3"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="videoUrl" class="form-label">YouTube Video URL</label>
                            <input type="url" class="form-control" id="videoUrl" name="video_url" required>
                        </div>
                        <div class="mb-3">
                            <label for="videoThumbnail" class="form-label">Thumbnail URL</label>
                            <input type="url" class="form-control" id="videoThumbnail" name="thumbnail_url">
                        </div>
                        <div class="mb-3">
                            <label for="videoCategory" class="form-label">Category</label>
                            <select class="form-control" id="videoCategory" name="category_id" required>
                                <option value="">Select Category</option>
                                <!-- Categories will be loaded via PHP -->
                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" onclick="uploadVideo()">Upload</button>
                </div>
            </div>
        </div>
    </div>

    <script src="assets/js/main.js"></script>
</body>
</html>