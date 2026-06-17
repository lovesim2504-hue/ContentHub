<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog Details</title>
    <?php
    require_once("includes/headfiles.php");
    ?>
</head>

<body>
    <?php
    require_once("includes/header.php");
    ?>
<style>


/* ---------- BLOG DETAILS ---------- */
.blog-details {
    background-color: #fff;
    border-radius: 12px;
    padding: 30px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    margin-bottom: 40px;
    transition: all 0.3s ease;
}

.blog-details:hover {
    transform: translateY(-4px);
    box-shadow: 0 4px 14px rgba(0,0,0,0.15);
}

.blog-details h2 {
    font-size: 28px;
    color: #1e293b;
    margin-bottom: 15px;
}

.blog-details p {
    font-size: 16px;
    color: #444;
}

.blog-details img {
    margin: 20px 0;
    border-radius: 10px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.15);
}

/* ---------- COMMENT SECTION ---------- */
h3 {
    margin-top: 40px;
    margin-bottom: 15px;
    color: #1e293b;
    font-weight: 600;
}

.comment {
    background-color: #ffffff;
    border-left: 4px solid #3b82f6;
    padding: 15px 20px;
    margin-bottom: 15px;
    border-radius: 8px;
    box-shadow: 0 1px 4px rgba(0,0,0,0.1);
}

.comment strong {
    color: #1e3a8a;
    font-size: 16px;
}

.comment em {
    color: #6b7280;
    font-size: 13px;
    margin-left: 6px;
}

.comment p {
    margin-top: 8px;
    font-size: 15px;
}

/* ---------- COMMENT FORM ---------- */
.comment-form {
    background-color: #fff;
    padding: 25px 30px;
    border-radius: 10px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}

.comment-form h3 {
    margin-bottom: 20px;
    font-size: 22px;
    color: #1e293b;
}

.comment-form .form-group {
    margin-bottom: 15px;
}

.comment-form label {
    display: block;
    margin-bottom: 6px;
    font-weight: 500;
    color: #374151;
}

.comment-form input,
.comment-form textarea {
    width: 100%;
    padding: 10px 12px;
    border: 1px solid #ccc;
    border-radius: 6px;
    font-size: 15px;
    resize: none;
    transition: border-color 0.2s ease;
}

.comment-form input:focus,
.comment-form textarea:focus {
    border-color: #3b82f6;
    outline: none;
}

.comment-form button {
    background-color: #2563eb;
    color: #fff;
    border: none;
    padding: 10px 18px;
    border-radius: 6px;
    font-size: 16px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.comment-form button:hover {
    background-color: #1d4ed8;
}

/* ---------- RESPONSIVE ---------- */
@media (max-width: 768px) {
    .blog-details h2 {
        font-size: 22px;
    }
    .comment-form {
        padding: 20px;
    }
}
</style>

    <div class="container">
        <div class="account">
            
            <h1></h1>
            <?php
            require_once("includes/vars.php");
            ini_set('log_errors', 1);
            ini_set('error_log', __DIR__ . '/custom_php_error.log');
            mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
            $conn = null;

            try {
                if (!isset($_GET["pid"]) || empty($_GET["pid"])) {
                    throw new Exception("Invalid blog ID.");
                }

                $pid = $_GET["pid"];
                $conn = new mysqli(dbhost, dbuname, dbpass, dbname);
                $pid = $conn->real_escape_string($pid); // Prevent SQL injection

                // Fetch the blog details
                $q = "SELECT * FROM blogs WHERE blogid='$pid'";
                $result = $conn->query($q);

                if ($result->num_rows == 0) {
                    echo "<p>No blog found.</p>";
                } else {
                    $resarr = $result->fetch_assoc();

                    echo "
                    <div class='blog-details divd'>
                        <h2>{$resarr['headline']}</h2>
                        <p> {$resarr['description']}</p>
                        <img src='uploads/{$resarr['picture']}' class='img-responsive' style='max-width:100%; height:auto;'>
                        <div class='blog-content' style='margin-top:20px;'>
                            <p>{$resarr['fulldescription']}</p>
                        </div>
                    </div>";
                }

                // Comment form submission
                if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit_comment'])) {
                    $name = $conn->real_escape_string($_POST['name']);
                    $email = $conn->real_escape_string($_POST['email']);
                    $comment = $conn->real_escape_string($_POST['comment']);

                    if (!empty($name) && !empty($email) && !empty($comment)) {
                        $insert_query = "INSERT INTO comments (blog_id, name, email, comment) 
                                         VALUES ('$pid', '$name', '$email', '$comment')";
                        if ($conn->query($insert_query) === TRUE) {
                            echo "<p>Your comment has been posted!</p>";
                        } else {
                            echo "<p>Error posting comment. Please try again later.</p>";
                        }
                    } else {
                        echo "<p>Please fill in all fields.</p>";
                    }
                }

                // Display comments
                $comments_query = "SELECT * FROM comments WHERE blog_id='$pid' ORDER BY created_at DESC";
                $comments_result = $conn->query($comments_query);

                if ($comments_result->num_rows > 0) {
                    echo "<h3>Comments:</h3>";
                    while ($comment = $comments_result->fetch_assoc()) {
                        echo "
                        <div class='comment'>
                            <strong>{$comment['name']}</strong> <em>({$comment['created_at']})</em>
                            <p>{$comment['comment']}</p>
                        </div>";
                    }
                } else {
                    echo "<p>No comments yet. Be the first to comment!</p>";
                }

            } catch (Exception $e) {
                error_log("Database error: " . $e->getMessage());
                echo "<p>An error occurred while fetching the blog. Please try again later.</p>";
            } finally {
                if ($conn) {
                    $conn->close();
                }
            }
            ?>

            <!-- Comment Form -->
            <div class="comment-form">
                <h3>Leave a Comment:</h3>
                <form action="" method="POST">
                    <div class="form-group">
                        <label for="name">Name:</label>
                        <input type="text" id="name" name="name" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" id="email" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="comment">Comment:</label>
                        <textarea id="comment" name="comment" rows="4" required></textarea>
                    </div>
                    <button type="submit" name="submit_comment">Submit Comment</button>
                </form>
            </div>

        </div>
    </div>

    <?php
    require_once("includes/footer.php");
    ?>
</body>
</html>
