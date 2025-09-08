<?php
session_start();

/* ========= DB CONNECT ========= */
$host = "sql113.infinityfree.com";   
$user = "if0_39830222";              
$pass = "0eS90Hj92bLnI";             
$dbname = "if0_39830222_bettle_booyah_db"; 

$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) {
    die("DB Connection Failed: " . $conn->connect_error);
}

/* ========= LOGIN SYSTEM ========= */
if (isset($_POST['login'])) {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if ($username === "Sarkar" && $password === "Dead") {
        $_SESSION['admin'] = $username;
        header("Location: admin.php");
        exit;
    } else {
        $error = "❌ Wrong Username or Password!";
    }
}

/* ========= LOGOUT ========= */
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: admin.php");
    exit;
}

/* ========= CRUD HANDLERS ========= */
// Add User
if (isset($_POST['add_user'])) {
    $u = $conn->real_escape_string($_POST['username']);
    $e = $conn->real_escape_string($_POST['email']);
    $p = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $r = $conn->real_escape_string($_POST['role']);
    $conn->query("INSERT INTO users (username,email,pass,role,created_at) 
                  VALUES ('$u','$e','$p','$r',NOW())");
}
// Delete User
if (isset($_GET['del_user'])) {
    $id = intval($_GET['del_user']);
    $conn->query("DELETE FROM users WHERE id=$id");
}

// Add Player
if (isset($_POST['add_player'])) {
    $h = $conn->real_escape_string($_POST['handle']);
    $s = intval($_POST['score']);
    $r = intval($_POST['rank']);
    $conn->query("INSERT INTO players (handle,score,rank,created_at) 
                  VALUES ('$h','$s','$r',NOW())");
}
// Delete Player
if (isset($_GET['del_player'])) {
    $id = intval($_GET['del_player']);
    $conn->query("DELETE FROM players WHERE id=$id");
}

// Add Tournament
if (isset($_POST['add_tour'])) {
    $n = $conn->real_escape_string($_POST['name']);
    $p = intval($_POST['prize']);
    $st = $conn->real_escape_string($_POST['status']);
    $conn->query("INSERT INTO tournaments (name,prize,status,created_at) 
                  VALUES ('$n','$p','$st',NOW())");
}
// Delete Tournament
if (isset($_GET['del_tour'])) {
    $id = intval($_GET['del_tour']);
    $conn->query("DELETE FROM tournaments WHERE id=$id");
}

/* ========= IF NOT LOGGED IN ========= */
if (!isset($_SESSION['admin'])) {
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin Login</title>
    <style>
        body {font-family:Arial;background:#111;color:#fff;display:flex;justify-content:center;align-items:center;height:100vh;}
        .login {background:#222;padding:40px;border-radius:10px;box-shadow:0 0 20px #000;}
        input {padding:10px;margin:10px 0;width:100%;border:none;border-radius:5px;}
        button {padding:10px;width:100%;background:#e60000;color:#fff;border:none;border-radius:5px;cursor:pointer;}
    </style>
</head>
<body>
    <div class="login">
        <h2>Admin Panel Login</h2>
        <?php if (!empty($error)) echo "<p style='color:red'>$error</p>"; ?>
        <form method="post">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit" name="login">Login</button>
        </form>
    </div>
</body>
</html>
<?php
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <style>
        body {font-family:Arial;background:#f5f5f5;margin:0;}
        .sidebar {width:220px;height:100vh;background:#111;color:#fff;position:fixed;top:0;left:0;padding:20px;}
        .sidebar a {color:#fff;text-decoration:none;display:block;padding:10px;margin:5px 0;background:#333;border-radius:5px;}
        .sidebar a:hover {background:#e60000;}
        .content {margin-left:240px;padding:20px;}
        table {width:100%;border-collapse:collapse;margin-top:20px;}
        th, td {border:1px solid #ccc;padding:10px;text-align:left;}
        th {background:#333;color:#fff;}
        .logout {background:#e60000;color:#fff;padding:10px;text-decoration:none;border-radius:5px;}
        form {margin:15px 0;background:#eee;padding:10px;border-radius:5px;}
        form input, form select {padding:5px;margin:5px;}
        form button {padding:5px 10px;background:#111;color:#fff;border:none;border-radius:5px;}
    </style>
</head>
<body>

<div class="sidebar">
    <h2>⚡ BATTLE OP ADMIN</h2>
    <a href="admin.php?page=dashboard">📊 Dashboard</a>
    <a href="admin.php?page=users">👤 Users</a>
    <a href="admin.php?page=players">🎮 Players</a>
    <a href="admin.php?page=tournaments">🏆 Tournaments</a>
    <a href="admin.php?page=payments">💰 Payments</a>
    <a href="admin.php?page=settings">⚙️ Settings</a>
    <a href="admin.php?logout=1" class="logout">🚪 Logout</a>
</div>

<div class="content">
<?php
$page = $_GET['page'] ?? 'dashboard';

/* DASHBOARD */
if ($page == "dashboard") {
    echo "<h1>Welcome, ".$_SESSION['admin']."</h1>";
    $userCount = $conn->query("SELECT COUNT(*) as c FROM users")->fetch_assoc()['c'];
    $playerCount = $conn->query("SELECT COUNT(*) as c FROM players")->fetch_assoc()['c'];
    $tourCount = $conn->query("SELECT COUNT(*) as c FROM tournaments")->fetch_assoc()['c'];
    echo "<p>Total Users: <b>$userCount</b></p>";
    echo "<p>Total Players: <b>$playerCount</b></p>";
    echo "<p>Total Tournaments: <b>$tourCount</b></p>";
}

/* USERS */
if ($page == "users") {
    echo "<h1>All Users</h1>";
    echo '<form method="post">
            <input type="text" name="username" placeholder="Username" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <select name="role"><option value="admin">Admin</option><option value="player">Player</option></select>
            <button type="submit" name="add_user">Add User</button>
          </form>';
    $res = $conn->query("SELECT * FROM users ORDER BY id DESC");
    echo "<table><tr><th>ID</th><th>Username</th><th>Email</th><th>Role</th><th>Action</th></tr>";
    while ($r = $res->fetch_assoc()) {
        echo "<tr>
                <td>{$r['id']}</td>
                <td>{$r['username']}</td>
                <td>{$r['email']}</td>
                <td>{$r['role']}</td>
                <td><a href='admin.php?page=users&del_user={$r['id']}'>❌ Delete</a></td>
              </tr>";
    }
    echo "</table>";
}

/* PLAYERS */
if ($page == "players") {
    echo "<h1>All Players</h1>";
    echo '<form method="post">
            <input type="text" name="handle" placeholder="Handle" required>
            <input type="number" name="score" placeholder="Score" required>
            <input type="number" name="rank" placeholder="Rank" required>
            <button type="submit" name="add_player">Add Player</button>
          </form>';
    $res = $conn->query("SELECT * FROM players ORDER BY id DESC");
    echo "<table><tr><th>ID</th><th>Handle</th><th>Score</th><th>Rank</th><th>Action</th></tr>";
    while ($r = $res->fetch_assoc()) {
        echo "<tr>
                <td>{$r['id']}</td>
                <td>{$r['handle']}</td>
                <td>{$r['score']}</td>
                <td>{$r['rank']}</td>
                <td><a href='admin.php?page=players&del_player={$r['id']}'>❌ Delete</a></td>
              </tr>";
    }
    echo "</table>";
}

/* TOURNAMENTS */
if ($page == "tournaments") {
    echo "<h1>All Tournaments</h1>";
    echo '<form method="post">
            <input type="text" name="name" placeholder="Tournament Name" required>
            <input type="number" name="prize" placeholder="Prize" required>
            <select name="status">
                <option value="upcoming">Upcoming</option>
                <option value="live">Live</option>
                <option value="finished">Finished</option>
            </select>
            <button type="submit" name="add_tour">Add Tournament</button>
          </form>';
    $res = $conn->query("SELECT * FROM tournaments ORDER BY id DESC");
    echo "<table><tr><th>ID</th><th>Name</th><th>Prize</th><th>Status</th><th>Action</th></tr>";
    while ($r = $res->fetch_assoc()) {
        echo "<tr>
                <td>{$r['id']}</td>
                <td>{$r['name']}</td>
                <td>{$r['prize']}</td>
                <td>{$r['status']}</td>
                <td><a href='admin.php?page=tournaments&del_tour={$r['id']}'>❌ Delete</a></td>
              </tr>";
    }
    echo "</table>";
}

/* PAYMENTS */
if ($page == "payments") {
    echo "<h1>All Payments</h1>";
    $res = $conn->query("SELECT * FROM payments ORDER BY id DESC");
    echo "<table><tr><th>ID</th><th>User</th><th>Amount</th><th>Status</th></tr>";
    while ($r = $res->fetch_assoc()) {
        echo "<tr><td>{$r['id']}</td><td>{$r['user_id']}</td><td>{$r['amount']}</td><td>{$r['status']}</td></tr>";
    }
    echo "</table>";
}

/* SETTINGS */
if ($page == "settings") {
    echo "<h1>Website Settings</h1>";
    echo "<p>⚙️ Coming Soon: Control site title, logo, banners from here.</p>";
}
?>
</div>
</body>
</html>