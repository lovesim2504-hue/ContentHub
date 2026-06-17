<?php
session_start(); // This needs to be at the very top of the page
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>

    <?php require_once("includes/headfiles.php"); ?>
    <style>
      
        /* ---------- Contact Section Styles ---------- */
        .contact-info {
            margin-top: 50px;
            background-color: #ffffff;
            padding: 30px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            margin-bottom: 30px;
            border-radius: 8px;
        }

        .contact-info h2 {
            color: #007bff;
            margin-bottom: 20px;
            font-size: 26px;
        }

        .contact-info p {
            font-size: 16px;
            line-height: 1.6;
            color: #555;
        }

        .contact-info .info-item {
            margin-bottom: 15px;
        }

        .contact-info .info-item i {
            color: #007bff;
            margin-right: 10px;
            font-size: 18px;
        }

        /* ---------- Contact Form Styles ---------- */
        .contact-form {
            background-color: #fff;
            padding: 30px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        .contact-form h3 {
            font-size: 24px;
            color: #007bff;
            margin-bottom: 20px;
        }

        .contact-form .form-group {
            margin-bottom: 20px;
        }

        .contact-form label {
            font-size: 14px;
            color: #555;
            display: block;
            margin-bottom: 5px;
        }

        .contact-form input,
        .contact-form textarea {
            width: 100%;
            padding: 12px;
            font-size: 14px;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-sizing: border-box;
        }

        .contact-form textarea {
            resize: vertical;
            height: 150px;
        }

        .contact-form button {
            background-color: #007bff;
            color: white;
            padding: 12px 20px;
            font-size: 16px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .contact-form button:hover {
            background-color: #0056b3;
        }

        .contact-form .error {
            color: red;
            font-size: 14px;
            margin-top: 10px;
        }

        /* ---------- Google Map Section Styles ---------- */
        .map-container {
            margin-top: 40px;
            position: relative;
            padding-top: 56.25%; /* 16:9 aspect ratio */
            height: 0;
            overflow: hidden; margin-bottom: 50px;
        }

        .map-container iframe {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
           
        }

        /* ---------- Responsive Design ---------- */
        @media (max-width: 768px) {
            .contact-info {
                padding: 20px;
            }

            .contact-form {
                padding: 20px;
            }
        }
    </style>
</head>

<body>
    <?php require_once("includes/header.php"); ?>

    <div class="container">

        <!-- Contact Information Section -->
        <section class="contact-info">
            <h2>Contact Information</h2>
            <div class="info-item">
                <i class="fas fa-map-marker-alt"></i>
                <strong>Address:</strong>
                <p>1234 Blog Street, Suite 567, Cityville, Country</p>
            </div>
            <div class="info-item">
                <i class="fas fa-phone"></i>
                <strong>Phone:</strong>
                <p>+1 (234) 567-890</p>
            </div>
            <div class="info-item">
                <i class="fas fa-envelope"></i>
                <strong>Email:</strong>
                <p><a href="mailto:contact@myblog.com">contact@myblog.com</a></p>
            </div>
        </section>

        <!-- Contact Form Section -->
        <section class="contact-form">
            <h3>Get in Touch</h3>
            <form action="submit_contact.php" method="POST" id="contact-form">
                <div class="form-group">
                    <label for="name">Full Name:</label>
                    <input type="text" id="name" name="name" required>
                </div>
                <div class="form-group">
                    <label for="email">Email Address:</label>
                    <input type="email" id="email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="message">Your Message:</label>
                    <textarea id="message" name="message" required></textarea>
                </div>
                <button type="submit" name="submit_contact">Send Message</button>
            </form>
        </section>

        <!-- Google Map Section -->
        <section class="map-container">
            <h3>Our Location</h3>
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d109066.25917729584!2d75.49084436774623!3d31.322517977929994!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x391a5a5747a9eb91%3A0xc74b34c05aa5b4b8!2sJalandhar%2C%20Punjab!5e0!3m2!1sen!2sin!4v1762094202421!5m2!1sen!2sin" width="600" height="250" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>"
        
        </section>
        
    </div>

    <?php require_once("includes/footer.php"); ?>
</body>

</html>
