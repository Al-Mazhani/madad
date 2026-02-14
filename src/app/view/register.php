<?php $pageTitle =  " انشاء حساب   | مِداد";
include(__DIR__ . '/../includes/header.php'); ?>
<main>
    <?php if(!isset($_SESSION['confrim-code'])): ?>
    <section>
        <div class="container">
            <div class="register">
                <h1>انشاء حساب</h1>
                <?php if (isset($error['invalidRegister'])): ?>
                    <span> <?php echo $error['invalidRegister']; ?> </span>
                <?php endif; ?>
                <?php if (isset($error['hasErrorInput'])): ?>
                    <span> <?php echo $error['hasErrorInput']; ?> </span>
                <?php endif; ?>
                <form action="" method="POST">
                    <label for="username">اسم المستخدم</label>
                    <input type="text" name="username" id="username" value="username" minlength="3" maxlength="30" required>
                    <label for="email">البريد الالكتروني</label>
                    <input type="email" name="email" id="email" placeholder="you@email.com" required>
                    <label for="password">كلمة المرور</label>
                    <input type="password" name="password" id="password" placeholder="كلمة المرور" maxlength="15" minlength="10" required>
                    <button type="submit" name="submit_register" id="btn-register" class="btn-register"> انشاء حساب</button>
                </form>
            </div>
        </div>
    </section>
    <?php else: ?>
    <section class="container " id="verify-email" >
        <form action="" method="post" class="verify-email">
            <div class="box-codes">

            </div>
            <input type="text" name="code1" id="code1">
            <input type="text" name="code2" id="code2">
            <input type="text" name="code3" id="code3">
            <input type="text" name="code4" id="code4">
            <input type="text" name="code5" id="code5">
            <input type="text" name="code6" id="code6  ">
            <button type="submit" name="confirm-email" class="btn-verify-email">تحقق</button>
        </form>
    </section>
    <?php endif;?>

</main>
<?php include(__DIR__ . '/../includes/footer.php'); ?>