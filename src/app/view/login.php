<?php $pageTitle =  "   تسجيل دخول  | مِداد";
include(__DIR__ . '/../includes/header.php');?>
<main>
    <section>
        <div class="container">
            <div class="register">
                <h1> تسجيل دخول </h1>
                <form action="/Madad/login" method="post">
                      <?php if (isset($errorLogin['filedLogin'])): ?>
                        <span><?php echo $errorLogin['filedLogin'] ?></span>
                    <?php endif; ?>
                    <label for="email">البريد الالكتروني</label>
                    <?php if (isset($errorLogin['emptyEmail'])): ?>
                        <span><?php echo $errorLogin['emptyEmail'] ?></span>
                    <?php endif; ?>
                    <?php if (isset($errorLogin['invalidEmail'])): ?>
                        <span><?php echo $errorLogin['invalidEmail'] ?></span>
                    <?php endif; ?>
                    <input type="email" name="email" id="email" placeholder="you@email.com" required>
                    <label for="password">كلمة المرور</label>
                    <input type="password" name="password" id="password" placeholder="كلمة المرور" maxlength="15" minlength="10" required>
                       <?php if (isset($errorLogin['emptyPass'])): ?>
                        <span><?php echo $errorLogin['emptyPass'] ?></span>
                    <?php endif; ?>
                      <?php if (isset($errorLogin['lenghtPass'])): ?>
                        <span><?php echo $errorLogin['lenghtPass'] ?></span>
                    <?php endif; ?>
                    <label for="login-as">تسجيل دخول ك</label>
                    <select name="login-as" id="login-as" required>
                        <option value="user">مستخدم</option>
                        <option value="admin">مشرف الموقع</option>
                    </select>
                    <button type="submit" name="login" class="btn-register"> تسجيل دخول</button>
                </form>
            </div>
        </div>
    </section>
</main>