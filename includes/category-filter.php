<div class="category-filter">
    <?php
    require_once 'config/database.php';
    
    $database = new Database();
    $db = $database->getConnection();
    
    $query = "SELECT * FROM categories ORDER BY id";
    $stmt = $db->prepare($query);
    $stmt->execute();
    $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    foreach($categories as $category):
    ?>
        <button class="category-btn <?php echo $category['id'] == 1 ? 'active' : ''; ?>" 
                onclick="loadVideosByCategory(<?php echo $category['id']; ?>)" 
                data-category="<?php echo $category['id']; ?>">
            <?php echo htmlspecialchars($category['name']); ?>
        </button>
    <?php endforeach; ?>
</div>