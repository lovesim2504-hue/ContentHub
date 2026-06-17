<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome</title>
    <?php
    require_once("includes/headfiles.php");
    ?>
</head>
<style>
    /* Dashboard Overview */
        .dashboard {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 30px;
            margin-bottom: 40px;
        }

        .dashboard-card {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .dashboard-card h3 {
            font-size: 24px;
            color: #007bff;
            margin-bottom: 10px;
        }

        .dashboard-card p {
            font-size: 18px;
            color: #555;
        }

        /* Stats Boxes */
        .stats-box {
            font-size: 18px;
            margin: 10px 0;
        }

        .btn-action {
            background-color: #007bff;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
            display: inline-block;
            margin-top: 15px;
            transition: background-color 0.3s;
        }

        .btn-action:hover {
            background-color: #0056b3;
        }

</style>
<body>
    <?php
    require_once("includes/adminheader.php");
    ?>

    <div class="container">
        <div class="account">
            <h1>Welcome Admin</h1>
            
        </div>


<!-- DASHBOARD OVERVIEW -->
        <section>
            <h2>Admin Dashboard</h2>
            <div class="dashboard">
                <!-- Total Blogs Card -->
                <div class="dashboard-card">
                    <h3>Total Blogs</h3>
                    <p class="stats-box">
                        <?php
                        // Fetch total blogs count
                        require_once("includes/vars.php");
                        $conn = new mysqli(dbhost, dbuname, dbpass, dbname);
                        $result = $conn->query("SELECT COUNT(*) AS total_blogs FROM blogs");
                        $total_blogs = $result->fetch_assoc()['total_blogs'];
                        echo $total_blogs;
                        ?>
                    </p>
                    <a href="category.php" class="btn-action">Manage Blogs</a>
                </div>

                <!-- Total Users Card -->
                <div class="dashboard-card">
                    <h3>Total Users</h3>
                    <p class="stats-box">
                        <?php
                        // Fetch total users count
                        $result = $conn->query("SELECT COUNT(*) AS total_users FROM register");
                        $total_users = $result->fetch_assoc()['total_users'];
                        echo $total_users;
                        ?>
                    </p>
                    <a href="listofmembers.php" class="btn-action">Manage Users</a>
                </div>
        </section>
    </div>
    <?php
    require_once("includes/footer.php");
    ?>
</body>

</html>