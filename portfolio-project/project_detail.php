<?php
include 'includes/header.php';
include 'includes/db_connect.php'; 

$project = null; 
$error_message = ''; 

$projectId = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($projectId > 0) {
    $sql = "SELECT id, title, image_path, long_description, technologies, live_link, repo_link
            FROM projects
            WHERE id = ?"; 

    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("i", $projectId);

        $stmt->execute();

        $result = $stmt->get_result();

        if ($result && $result->num_rows === 1) {
            $project = $result->fetch_assoc();
        } else {
        }
        // Close the statement
        $stmt->close();
    } else {
        $error_message = "Error preparing database query: " . $conn->error;
        // error_log("SQL Prepare Error in project_detail.php: " . $conn->error);
        // $error_message = "An error occurred while fetching project details.";
    }
} else {
    // Invalid or missing project ID
    // $error_message = "Invalid project requested."; // Set later if needed
}

// Close the database connection
$conn->close();

$technologies_array = [];
if ($project && !empty($project['technologies'])) {
    $technologies_array = array_map('trim', explode(',', $project['technologies']));
    $technologies_array = array_filter($technologies_array);
}

?>

<div class="container page-container project-detail-container">
    <?php if ($project): // Check if project data was successfully fetched ?>
        <h1><?php echo htmlspecialchars($project['title']); ?></h1>

        <div class="project-detail-layout">
            <div class="project-main-content">
                <img src="<?php echo htmlspecialchars($project['image_path']); ?>" alt="Main image for <?php echo htmlspecialchars($project['title']); ?>" class="project-detail-image">
                <h2>Project Overview</h2>
                <p><?php echo nl2br(htmlspecialchars($project['long_description'])); // nl2br converts newlines to <br> ?></p>
            </div>

            <aside class="project-sidebar">
                <?php if (!empty($technologies_array)): ?>
                    <h3>Technologies Used</h3>
                    <ul class="tech-list">
                        <?php foreach ($technologies_array as $tech): ?>
                            <li><?php echo htmlspecialchars($tech); ?></li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>

                <?php if (!empty($project['live_link'])): ?>
                    <a href="<?php echo htmlspecialchars($project['live_link']); ?>" class="btn btn-primary project-link" target="_blank">View Live Project</a>
                <?php endif; ?>

                <?php if (!empty($project['repo_link'])): ?>
                     <a href="<?php echo htmlspecialchars($project['repo_link']); ?>" class="btn btn-secondary project-link" target="_blank">View Code Repository</a>
                <?php endif; ?>
            </aside>
        </div>

        <div class="navigation-links">
            <a href="portfolio.php">← Back to Portfolio</a>
            <?php
            // Optional: Add Next/Previous Project Links (More advanced SQL/PHP needed)
            ?>
        </div>

    <?php else: // Project ID not found, invalid, or DB error occurred ?>
        <h1>Project Not Found</h1>
        <?php if (!empty($error_message)): ?>
             <p class="form-error" style="text-align: center;"><?php echo htmlspecialchars($error_message); ?></p>
        <?php endif; ?>
        <p>Sorry, the project you are looking for could not be found or an error occurred.</p>
        <p><a href="portfolio.php">Return to Portfolio</a></p>
    <?php endif; ?>
</div>

<?php include 'includes/footer.php'; ?>