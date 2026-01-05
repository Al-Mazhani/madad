<?php
include(__DIR__ . '/../includes/header.php');
if(!isset($_COOKIE['remember_token'])){
 header("Location:/Madad/");
}
?>
<div class="container">
    <div class="profile-box">
        <h1>الملف الشخصي</h1>
        <form action="">

            <!-- <div class="show-profile"> -->
            <label for="username">الاسم</label>

            <input type="text" name="username" id="username" value="<?php
                    if (isset($_SESSION['username'])):
                    echo $_SESSION['username'];
                     endif;  ?>"readonly>
            <label for="email">البريد الالكتروني</label>
            <input type="text" name="email" id="email" value="<?php 
            if(isset($_SESSION['email'])):
            echo $_SESSION['email'];
                                                                endif;
            ?>" readonly>
            <!-- </div> -->
        </form>
        <button class="update-profile">تعديل</button>
    </div>
</div>
</body>

</html>