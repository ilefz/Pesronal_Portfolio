<?php
// Simple way to determine the current page for active nav link
$currentPage = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ilef Akremi - Portfolio</title> <?php // You might want to make the title dynamic later ?>
    <link rel="stylesheet" href="css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Lato:wght@300;400;700&display=swap" rel="stylesheet">
</head>
<body>
    <header class="site-header">
        <div class="container header-flex">
            <div class="logo">
                <a href="index.php">Ilef Akremi</a>
            
            </div>
            <nav class="main-navigation">
                <button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false">☰</button> <?php // Hamburger icon ?>
                <ul id="primary-menu">
                    <li><a href="index.php" class="<?= ($currentPage == 'index.php') ? 'active' : ''; ?>">Home</a></li>
                    <li><a href="about.php" class="<?= ($currentPage == 'about.php') ? 'active' : ''; ?>">About Me</a></li>
                    <li><a href="portfolio.php" class="<?= ($currentPage == 'portfolio.php' || $currentPage == 'project_detail.php') ? 'active' : ''; ?>">Portfolio</a></li>
                    <li><a href="resume.php" class="<?= ($currentPage == 'resume.php') ? 'active' : ''; ?>">Resume</a></li>
                    <li><a href="contact.php" class="<?= ($currentPage == 'contact.php') ? 'active' : ''; ?>">Contact</a></li>
                </ul>
            </nav>
        </div>
        
    </header>
    <main>