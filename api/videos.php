<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Access-Control-Allow-Headers: Content-Type');

require_once '../config/database.php';

$database = new Database();
$db = $database->getConnection();

$method = $_SERVER['REQUEST_METHOD'];
$action = $_GET['action'] ?? '';

switch($method) {
    case 'GET':
        if($action === 'search') {
            searchVideos($db);
        } elseif($action === 'category') {
            getVideosByCategory($db);
        } elseif($action === 'trending') {
            getTrendingVideos($db);
        } else {
            getAllVideos($db);
        }
        break;
        
    case 'POST':
        if($action === 'upload') {
            uploadVideo($db);
        } elseif($action === 'view') {
            incrementViews($db);
        }
        break;
        
    default:
        http_response_code(405);
        echo json_encode(['error' => 'Method not allowed']);
        break;
}

function getAllVideos($db) {
    $page = $_GET['page'] ?? 1;
    $limit = $_GET['limit'] ?? 12;
    $offset = ($page - 1) * $limit;
    
    $query = "SELECT v.*, u.username, u.profile_image, c.name as category_name 
              FROM videos v 
              JOIN users u ON v.user_id = u.id 
              JOIN categories c ON v.category_id = c.id 
              ORDER BY v.created_at DESC 
              LIMIT :limit OFFSET :offset";
              
    $stmt = $db->prepare($query);
    $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
    $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();
    
    $videos = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Format the response
    foreach($videos as &$video) {
        $video['views_formatted'] = formatViews($video['views']);
        $video['time_ago'] = timeAgo($video['created_at']);
    }
    
    echo json_encode(['success' => true, 'videos' => $videos]);
}

function searchVideos($db) {
    $query_param = $_GET['q'] ?? '';
    $page = $_GET['page'] ?? 1;
    $limit = $_GET['limit'] ?? 12;
    $offset = ($page - 1) * $limit;
    
    $query = "SELECT v.*, u.username, u.profile_image, c.name as category_name 
              FROM videos v 
              JOIN users u ON v.user_id = u.id 
              JOIN categories c ON v.category_id = c.id 
              WHERE v.title LIKE :search OR v.description LIKE :search 
              ORDER BY v.views DESC 
              LIMIT :limit OFFSET :offset";
              
    $stmt = $db->prepare($query);
    $search_term = '%' . $query_param . '%';
    $stmt->bindParam(':search', $search_term);
    $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
    $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();
    
    $videos = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    foreach($videos as &$video) {
        $video['views_formatted'] = formatViews($video['views']);
        $video['time_ago'] = timeAgo($video['created_at']);
    }
    
    echo json_encode(['success' => true, 'videos' => $videos]);
}

function getVideosByCategory($db) {
    $category_id = $_GET['category_id'] ?? 1;
    $page = $_GET['page'] ?? 1;
    $limit = $_GET['limit'] ?? 12;
    $offset = ($page - 1) * $limit;
    
    if($category_id == 1) {
        getAllVideos($db);
        return;
    }
    
    $query = "SELECT v.*, u.username, u.profile_image, c.name as category_name 
              FROM videos v 
              JOIN users u ON v.user_id = u.id 
              JOIN categories c ON v.category_id = c.id 
              WHERE v.category_id = :category_id 
              ORDER BY v.created_at DESC 
              LIMIT :limit OFFSET :offset";
              
    $stmt = $db->prepare($query);
    $stmt->bindParam(':category_id', $category_id, PDO::PARAM_INT);
    $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
    $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();
    
    $videos = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    foreach($videos as &$video) {
        $video['views_formatted'] = formatViews($video['views']);
        $video['time_ago'] = timeAgo($video['created_at']);
    }
    
    echo json_encode(['success' => true, 'videos' => $videos]);
}

function getTrendingVideos($db) {
    $query = "SELECT v.*, u.username, u.profile_image, c.name as category_name 
              FROM videos v 
              JOIN users u ON v.user_id = u.id 
              JOIN categories c ON v.category_id = c.id 
              ORDER BY v.views DESC, v.created_at DESC 
              LIMIT 20";
              
    $stmt = $db->prepare($query);
    $stmt->execute();
    
    $videos = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    foreach($videos as &$video) {
        $video['views_formatted'] = formatViews($video['views']);
        $video['time_ago'] = timeAgo($video['created_at']);
    }
    
    echo json_encode(['success' => true, 'videos' => $videos]);
}

function uploadVideo($db) {
    $data = json_decode(file_get_contents('php://input'), true);
    
    $title = $data['title'] ?? '';
    $description = $data['description'] ?? '';
    $video_url = $data['video_url'] ?? '';
    $thumbnail_url = $data['thumbnail_url'] ?? '';
    $category_id = $data['category_id'] ?? 1;
    $user_id = 1; // Default user for now
    
    if(empty($title) || empty($video_url)) {
        echo json_encode(['success' => false, 'error' => 'Title and video URL are required']);
        return;
    }
    
    $query = "INSERT INTO videos (title, description, video_url, thumbnail_url, user_id, category_id) 
              VALUES (:title, :description, :video_url, :thumbnail_url, :user_id, :category_id)";
              
    $stmt = $db->prepare($query);
    $stmt->bindParam(':title', $title);
    $stmt->bindParam(':description', $description);
    $stmt->bindParam(':video_url', $video_url);
    $stmt->bindParam(':thumbnail_url', $thumbnail_url);
    $stmt->bindParam(':user_id', $user_id);
    $stmt->bindParam(':category_id', $category_id);
    
    if($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Video uploaded successfully']);
    } else {
        echo json_encode(['success' => false, 'error' => 'Failed to upload video']);
    }
}

function incrementViews($db) {
    $data = json_decode(file_get_contents('php://input'), true);
    $video_id = $data['video_id'] ?? 0;
    
    $query = "UPDATE videos SET views = views + 1 WHERE id = :video_id";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':video_id', $video_id);
    
    if($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false]);
    }
}

function formatViews($views) {
    if($views >= 1000000) {
        return round($views / 1000000, 1) . 'M';
    } elseif($views >= 1000) {
        return round($views / 1000, 1) . 'K';
    }
    return $views;
}

function timeAgo($datetime) {
    $time = time() - strtotime($datetime);
    
    if($time < 60) return 'just now';
    if($time < 3600) return floor($time/60) . ' minutes ago';
    if($time < 86400) return floor($time/3600) . ' hours ago';
    if($time < 2592000) return floor($time/86400) . ' days ago';
    if($time < 31536000) return floor($time/2592000) . ' months ago';
    return floor($time/31536000) . ' years ago';
}
?>