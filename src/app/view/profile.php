<?php
include(__DIR__ . '/../includes/header.php');
if (!isset($_COOKIE['remember_token'])) {
    header("Location:/Madad/");
}
?>
<div class="container">
    <div class="profile-box " id="main-profile">
        <img class="background-image-profile" src="uploads/image_user/default_image.jpg" loading="lazy" alt="default image">
        <div class="profile-image">
            <img src="<?php echo ($_SESSION['Image'])?>" loading="lazy" alt="default image">
        </div>
    </div>
</div>
</body>

</html>

<?php include(__DIR__ . '/../includes/footer.php'); ?>