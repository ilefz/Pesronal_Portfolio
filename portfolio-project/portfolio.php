<?php
include 'includes/header.php';
include 'includes/db_connect.php'; 

$projects = [];
$error_message = ''; 

$sql = "SELECT id, title, image_path, short_description FROM projects ORDER BY id DESC";
$result = $conn->query($sql);
if ($result) {
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $projects[] = $row;
        }
    }
    $result->free(); 
} else {
    $error_message = "Error fetching projects: " . $conn->error;
}

$conn->close();
?>

<div class="container page-container">
    <h1>My Portfolio</h1>
    <p class="page-description">Here's a selection of projects I've worked on. Click on any project to learn more about the process and technologies involved.</p>

    <?php if (!empty($error_message)): ?>
        <div class="form-error" style="text-align: center; margin-bottom: 2rem;">
            <p><?php echo htmlspecialchars($error_message); ?></p>
        </div>
    <?php endif; ?>

    <div class="portfolio-grid">
        <?php
        if (!empty($projects)) {
            foreach ($projects as $project) {
                echo '<div class="portfolio-item">';
                echo '<a href="project_detail.php?id=' . htmlspecialchars($project['id']) . '">';
                echo '<div class="portfolio-image">';
                // Use image_path from the database
                echo '<img src="' . htmlspecialchars($project['image_path']) . '" alt="Preview of ' . htmlspecialchars($project['title']) . '">';
                echo '<div class="portfolio-overlay">';
                echo '<span>View Details</span>';
                echo '</div>'; // .portfolio-overlay
                echo '</div>'; // .portfolio-image
                // Use title from the database
                echo '<h3>' . htmlspecialchars($project['title']) . '</h3>';
                echo '</a>';
                // Use short_description from the database
                echo '<p class="portfolio-short-desc">' . htmlspecialchars($project['short_description']) . '</p>';
                echo '</div>'; // .portfolio-item
            }
        } elseif (empty($error_message)) { // Only show "No projects" if there wasn't a DB error
            echo '<p>No projects to display yet. Check back soon!</p>';
        }
        ?>
    </div>
</div>

<?php include 'includes/footer.php'; ?>