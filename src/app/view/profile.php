<?php
include(__DIR__ . '/../includes/header.php');
if(!isset($_COOKIE['remember_token'])){
    header("Location:/Madad/");
    }
    ?>
<div class="container">
    <div class="profile-box">
        <h1>الملف الشخصي</h1>
        <P>
            <?php
        if(isset($resultUpdateProfile['updateProfileSuccess'])){
            echo $resultUpdateProfile['updateProfileSuccess'];
            }
            ?></P>
            <p>
            <?php
        if(isset($resultUpdateProfile['updatedProfileFields'])){
            echo $resultUpdateProfile['updatedProfileFields'];
            }
            ?></p>
            <?php if(isset($resultUpdateProfile['hasErrorInput'])):?>
                <span> <?php echo $resultUpdateProfile['hasErrorInput'] ?></span>
                <?php endif?>
        <form action="" method="post">
            <div class="show-profile">
                <label for="username">الاسم</label>
                
                <input type="text" name="username" id="username" value="<?php
                    if (isset($_SESSION['username'])):
                        echo $_SESSION['username'];
                    endif;  ?>">
            <label for="email">البريد الالكتروني</label>
            <input type="text" name="email" id="email" value="<?php 
            if(isset($_SESSION['email'])):
                echo $_SESSION['email'];
            endif;
            ?>" readonly>
            </div>
            <a href="/Madad/sign_out" class="logOut">تسجيل خروج</a>
            <button type="submit" class="update-profile" name="updateProfile" >تعديل</button>
        </form>
    </div>
</div>
</body>

</html>

<?php include(__DIR__ . '/../includes/footer.php');?>