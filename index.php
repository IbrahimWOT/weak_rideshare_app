<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CityRide - Smart Ridesharing Platform</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>

    <nav class="navbar">
        <div class="nav-container">
            <a href="index.php" class="logo"><i class="fa-solid fa-car-side"></i> CityRide</a>
            <ul class="nav-links">
                <li><a href="index.php?page=home">Home</a></li>
                <li><a href="index.php?page=rider_auth" class="btn-rider-nav"><i class="fa-solid fa-user"></i> Rider Portal</a></li>
                <li><a href="index.php?page=driver_auth" class="btn-driver-nav"><i class="fa-solid fa-id-card"></i> Driver Portal</a></li>
            </ul>
        </div>
    </nav>

    <?php
    $page = isset($_GET['page']) ? $_GET['page'] : 'home';

    // ------------------ DYNAMIC HOME PAGE ------------------
    if ($page == 'home') {
    ?>
        <header class="hero-section">
            <div class="hero-content">
                <h1>Your Ride, Your Way.<br>Everyday.</h1>
                <p>Request a ride, hop in, and go. Choose your portal below to get started with the ultimate ridesharing experience.</p>
                <div class="hero-buttons">
                    <a href="index.php?page=rider_auth" class="btn-primary"><i class="fa-solid fa-user"></i> Enter Rider Portal</a>
                    <a href="index.php?page=driver_auth" class="btn-secondary"><i class="fa-solid fa-id-card"></i> Enter Driver Portal</a>
                </div>
            </div>
            <div class="hero-image">
                <img src="https://images.unsplash.com/photo-1549317661-bd32c8ce0db2?auto=format&fit=crop&q=80&w=600" alt="Taxi">
            </div>
        </header>

        <section class="features-section">
            <h2>Why Choose CityRide?</h2>
            <div class="features-grid">
                <div class="feature-card">
                    <i class="fa-solid fa-bolt feature-icon"></i>
                    <h3>Lightning Fast</h3>
                    <p>Get matched with top-rated drivers nearby in just seconds.</p>
                </div>
                <div class="feature-card">
                    <i class="fa-solid fa-shield-halved feature-icon"></i>
                    <h3>Safe & Secure</h3>
                    <p>Real-time GPS tracking and instant trip sharing features.</p>
                </div>
                <div class="feature-card">
                    <i class="fa-solid fa-wallet feature-icon"></i>
                    <h3>Affordable Pricing</h3>
                    <p>No hidden surges. Upfront pricing before you hit request.</p>
                </div>
            </div>
        </section>
    <?php 
    } 
    
    // ------------------ RIDER PORTAL (ROLE: RIDER) ------------------
    elseif ($page == 'rider_auth') {
    ?>
        <section class="auth-section">
            <div class="auth-container">
                <div class="auth-tabs">
                    <h2><i class="fa-solid fa-user"></i> Rider Account Portal</h2>
                </div>
                
                <div class="auth-grid">
                    <div class="form-box">
                        <h3>Rider Sign In</h3>
                        <form action="index.php?page=rider_auth" method="POST">
                            <div class="input-group">
                                <label>Rider Username</label>
                                <input type="text" name="rider_user" placeholder="e.g. ibrahim99" required>
                            </div>
                            <div class="input-group">
                                <label>Password</label>
                                <input type="password" name="rider_pass" placeholder="••••••••" required>
                            </div>
                            <button type="submit" name="rider_login" class="btn-submit">Login as Rider</button>
                        </form>
                    </div>

                    <div class="form-box">
                        <h3>Create Rider Account</h3>
                        <form action="index.php?page=rider_auth" method="POST">
                            <div class="input-group">
                                <label>Full Name</label>
                                <input type="text" name="user_name" placeholder="e.g. MD. Ibrahim" required>
                            </div>
                            <div class="input-group">
                                <label>Username</label>
                                <input type="text" name="reg_user" placeholder="e.g. ibrahim99" required>
                            </div>
                            <div class="input-group">
                                <label>Password</label>
                                <input type="password" name="reg_pass" placeholder="Create Password" required>
                            </div>
                            <button type="submit" name="rider_register" class="btn-submit btn-reg">Register</button>
                        </form>
                    </div>
                </div>

                <div class="backend-output">
                    <?php
                    include('config.php');

                    if (isset($_POST['rider_login'])) {
                        $user = $_POST['rider_user'];
                        $pass = $_POST['rider_pass'];
                        
                        // SQL Injection এর জন্য উন্মুক্ত কুয়েরি (role='rider' ফিল্টারসহ)
                        $query = "SELECT * FROM users WHERE username = '$user' AND password = '$pass' AND role = 'rider'";
                        
                        echo "<div class='info-box'><strong>Executed MySQL Query (Rider):</strong><br><code>$query</code></div>";
                        
                        $result = mysqli_query($conn, $query);

                        if ($result && mysqli_num_rows($result) > 0) {
                            $row = mysqli_fetch_assoc($result);
                            echo "<div class='alert success'><strong>🔥 Access Granted!</strong> Welcome Rider: " . $row['name'] . " (Phone: " . $row['phone'] . ").</div>";
                        } else {
                            echo "<div class='alert error'>Invalid Rider Credentials!</div>";
                        }
                    }

                    if (isset($_POST['rider_register'])) {
                        $name = $_POST['user_name'];
                        $reg_user = $_POST['reg_user'];
                        $reg_pass = $_POST['reg_pass'];

                        $query = "INSERT INTO users (name, username, password, phone, role) VALUES ('$name', '$reg_user', '$reg_pass', '01700000000', 'rider')";
                        if (mysqli_query($conn, $query)) {
                            echo "<div class='alert success'>Rider account created successfully for " . $name . "!</div>";
                        }
                    }
                    ?>
                </div>
            </div>
        </section>
    <?php 
    } 

    // ------------------ DRIVER PORTAL (ROLE: DRIVER) ------------------
    elseif ($page == 'driver_auth') {
    ?>
        <section class="auth-section">
            <div class="auth-container driver-theme">
                <div class="auth-tabs">
                    <h2><i class="fa-solid fa-id-card"></i> Driver Partner Portal</h2>
                </div>
                
                <div class="auth-grid">
                    <div class="form-box">
                        <h3>Driver Sign In</h3>
                        <form action="index.php?page=driver_auth" method="POST">
                            <div class="input-group">
                                <label>Driver Username</label>
                                <input type="text" name="driver_user" placeholder="e.g. rahman_drive" required>
                            </div>
                            <div class="input-group">
                                <label>Password</label>
                                <input type="password" name="driver_pass" placeholder="••••••••" required>
                            </div>
                            <button type="submit" name="driver_login" class="btn-submit">Login as Partner</button>
                        </form>
                    </div>

                    <div class="form-box">
                        <h3>Join as Driver Partner</h3>
                        <form action="index.php?page=driver_auth" method="POST">
                            <div class="input-group">
                                <label>Driver Full Name</label>
                                <input type="text" name="driver_name" placeholder="John Doe" required>
                            </div>
                            <div class="input-group">
                                <label>Username</label>
                                <input type="text" name="driver_reg_user" placeholder="driver_handle" required>
                            </div>
                            <div class="input-group">
                                <label>Password</label>
                                <input type="password" name="driver_reg_pass" placeholder="Password" required>
                            </div>
                            <button type="submit" name="driver_register" class="btn-submit btn-reg">Apply Now</button>
                        </form>
                    </div>
                </div>

                <div class="backend-output">
                    <?php
                    include('config.php');

                    if (isset($_POST['driver_login'])) {
                        $user = $_POST['driver_user'];
                        $pass = $_POST['driver_pass'];
                        
                        // ড্রাইভার লগইন কুয়েরি (role='driver' ফিল্টারসহ)
                        $query = "SELECT * FROM users WHERE username = '$user' AND password = '$pass' AND role = 'driver'";
                        
                        echo "<div class='info-box'><strong>Executed MySQL Query (Driver):</strong><br><code>$query</code></div>";
                        
                        $result = mysqli_query($conn, $query);

                        if ($result && mysqli_num_rows($result) > 0) {
                            $row = mysqli_fetch_assoc($result);
                            echo "<div class='alert success'><strong>🔥 Access Granted!</strong> Welcome Driver Partner: " . $row['name'] . ".</div>";
                        } else {
                            echo "<div class='alert error'>Invalid Driver Credentials!</div>";
                        }
                    }

                    if (isset($_POST['driver_register'])) {
                        $name = $_POST['driver_name'];
                        $reg_user = $_POST['driver_reg_user'];
                        $reg_pass = $_POST['driver_reg_pass'];

                        $query = "INSERT INTO users (name, username, password, phone, role) VALUES ('$name', '$reg_user', '$reg_pass', '01800000000', 'driver')";
                        if (mysqli_query($conn, $query)) {
                            echo "<div class='alert success'>Driver application submitted successfully!</div>";
                        }
                    }
                    ?>
                </div>
            </div>
        </section>
    <?php 
    } 
    ?>

    <footer>
        <p>&copy; 2026 CityRide Cyber Security Lab Environment. Authorized Testing Only.</p>
    </footer>

</body>
</html>
