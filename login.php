<?php
session_start();
require 'db.php';
if (isset($_SESSION['isLoggedIn']) && ($_SESSION['isLoggedIn'])) {
    header('Location: index.php');
}
$errorMessage = "";
if (isset($_POST['email']) && isset($_POST['password'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $sqlQuery = "SELECT * FROM users WHERE email = ?";
    $stmt = $pdo->prepare($sqlQuery);
    $stmt->execute([$email]);
    $users = $stmt->fetchAll(PDO::FETCH_OBJ);
    if (isset($users[0])) {
        if (password_verify($password, $users[0]->password)) {
            $_SESSION['isLoggedIn'] = true;
            $_SESSION['name'] = $users[0]->name;
            $_SESSION['email'] = $users[0]->email;
            header('Location: index.php');
        } else {
            $errorMessage = "Invalid Password";
        }
    } else {
        $errorMessage = "Invalid User";
    }
}
include 'header.php';
?>
<div class="col-12">
    <!-- Main Content -->
    <div class="row">
        <div class="col-12 mt-3 text-center text-uppercase">
            <h2>Login</h2>
        </div>
    </div>

    <main class="row">
        <div class="col-lg-4 col-md-6 col-sm-8 mx-auto bg-white py-3 mb-4">
            <div class="row">
                <div class="col-12">
                    <form method="POST">
                        <?php if ($errorMessage != "") {?>
                            <p class="text-danger text-center"><?=$errorMessage?></p>
                        <?php }?>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>
                        <!-- <div class="mb-3">
                            <div class="form-check">
                                <input type="checkbox" id="remember" class="form-check-input">
                                <label for="remember" class="form-check-label ml-2">Remember Me</label>
                            </div>
                        </div> -->
                        <div class="mb-3">
                            <button type="submit" class="btn btn-outline-dark">Login</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>
                <!-- Main Content -->
</div>

<?php include 'footer.php';?>