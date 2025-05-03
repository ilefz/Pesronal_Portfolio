<?php include 'includes/header.php'; ?>

<section class="hero">
    <div class="container">
        <h1>Welcome to My Portfolio</h1>
        <p class="subtitle">Showcasing my journey in web development & design.</p>
        <a href="portfolio.php" class="btn btn-primary">View My Work</a>
        <a href="about.php" class="btn btn-secondary">Learn More About Me</a>
    </div>
</section>

<?php
if (!isset($conn) || !$conn) {
    include 'includes/db_connect.php';
} elseif ($conn->connect_errno) {
    $conn = null; 
    include 'includes/db_connect.php'; 
}


$featured_projects = [];
$featured_error = '';

if ($conn && !$conn->connect_error) {
    $sql_featured = "SELECT id, title, image_path FROM projects ORDER BY id DESC LIMIT 3";
    $result_featured = $conn->query($sql_featured);

    if ($result_featured) {
        if ($result_featured->num_rows > 0) {
            while ($row = $result_featured->fetch_assoc()) {
                $featured_projects[] = $row;
            }
        }
        $result_featured->free();
    } else {
        $featured_error = "Error fetching featured projects: " . $conn->error;
    }
} else {
     $featured_error = "Database connection not available.";
}

?>

<section class="featured-projects">
    <div class="container">
        <h2>Featured Projects</h2>

        <?php if (!empty($featured_error)): ?>
             <div class="form-error" style="text-align: center; margin-bottom: 2rem;">
                 <p><?php echo htmlspecialchars($featured_error); ?></p>
             </div>
        <?php endif; ?>

        <div class="project-grid">
            <?php
            if (!empty($featured_projects)) {
                foreach ($featured_projects as $project) {
                    echo '<div class="project-item">';
                    echo '<a href="project_detail.php?id=' . htmlspecialchars($project['id']) . '">';

                    echo '<h3>' . htmlspecialchars($project['title']) . '</h3>';
                    echo '</a>';
                    echo '</div>';
                }
            } elseif (empty($featured_error)) {
                 echo '<p>No featured projects to display yet.</p>';
            }
            ?>
        </div>
        <div class="text-center" style="margin-top: 2rem;">
             <a href="portfolio.php" class="btn btn-secondary">See All Projects</a>
        </div>
    </div>
</section>

<?php
if (isset($conn) && $conn && !$conn->connect_error && basename($_SERVER['PHP_SELF']) == 'index.php') {
}
?>


<section class="quick-intro">
     <div class="container">
          <h2>A Little About Me</h2>
          <p>I'm passionate about creating beautiful and functional digital experiences. I enjoy blending design aesthetics with clean code. Explore my portfolio to see what I've been working on!</p>
          <a href="about.php" class="btn btn-secondary">Read More</a>
     </div>
</section>

<?php include 'includes/footer.php'; ?>