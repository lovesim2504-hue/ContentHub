<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Blog - Home</title>

    <?php require_once("includes/headfiles.php"); ?>

    <style>

        /* ---------- HERO / BANNER ---------- */
        .hero {
            background: linear-gradient(to right, #007bff, #00b4db);
            color: white;
            padding: 80px 20px;
            text-align: center;
            border-radius: 8px;
            margin-bottom: 40px;
            margin-top: 50px;
        }

        .hero h1 {
            font-size: 48px;
            margin-bottom: 15px;
        }

        .hero p {
            font-size: 18px;
            opacity: 0.9;
        }

        /* ---------- BLOG GRID ---------- */
        .blog-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
            margin-bottom: 60px;
            margin-top: 20px;
        }

        .blog-card {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            overflow: hidden;
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .blog-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 16px rgba(0,0,0,0.15);
        }

        .blog-card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }

        .blog-card-content {
            padding: 20px;
        }

        .blog-card-content h3 {
            color: #007bff;
            margin-bottom: 10px;
        }

        .blog-card-content p {
            color: #555;
            font-size: 15px;
        }

        .read-more {
            display: inline-block;
            margin-top: 10px;
            color: #007bff;
            font-weight: 500;
            transition: color 0.3s;
        }

        .read-more:hover {
            color: #0056b3;
        }

        /* ---------- FOOTER ---------- */
        footer {
            background: #007bff;
            color: white;
            padding: 25px 0;
            text-align: center;
            border-radius: 8px 8px 0 0;
            font-size: 14px;
        }

        /* ---------- RESPONSIVE ---------- */
        @media (max-width: 768px) {
            .hero h1 {
                font-size: 32px;
            }
            .hero p {
                font-size: 16px;
            }
        }
    </style>
</head>

<body>
    <?php require_once("includes/header.php"); ?>

    <div class="container">

        <!-- HERO SECTION -->
        <section class="hero">
            <h1>Welcome to My Blog</h1>
            <p>Read stories, tips, and insights on technology, lifestyle, and more.</p>
        </section>

        <!-- BLOG POSTS SECTION -->
        <section>
            <h2>Latest Posts</h2>
            <div class="blog-grid">

                <?php
                require_once("includes/vars.php");
                ini_set('log_errors', 1);
                ini_set('error_log', __DIR__ . '/custom_php_error.log');
                mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

                try {
                    $conn = new mysqli(dbhost, dbuname, dbpass, dbname);

                    $query = "SELECT blogid, headline, description, picture FROM blogs ORDER BY blogid DESC LIMIT 6";
                    $result = $conn->query($query);

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "
                            <div class='blog-card'>
                                <a href='details.php?pid={$row['blogid']}'>
                                    <img src='uploads/{$row['picture']}' alt='{$row['headline']}'>
                                    <div class='blog-card-content'>
                                        <h3>{$row['headline']}</h3>
                                        <p>" . substr($row['description'], 0, 100) . "...</p>
                                        <span class='read-more'>Read More →</span>
                                    </div>
                                </a>
                            </div>";
                        }
                    } else {
                        echo "<p>No blog posts available yet.</p>";
                    }
                } catch (Exception $e) {
                    error_log("Error fetching blogs: " . $e->getMessage());
                    echo "<p>Unable to load blog posts at this time. Please try again later.</p>";
                } finally {
                    if ($conn) {
                        $conn->close();
                    }
                }
                ?>
            </div>
        </section>
    </div>

    <footer>
        <p>&copy; <?php echo date('Y'); ?> My Blog. All rights reserved.</p>
    </footer>
</body>
</html>
