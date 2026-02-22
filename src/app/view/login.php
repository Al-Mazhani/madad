<?php $pageTitle =  "   تسجيل دخول  | مِداد";
include(__DIR__ . '/../includes/header.php');?>
<main>
    <section>
        <div class="container">
            <div class="register">
                <h1> تسجيل دخول </h1>
                <form action="/login" method="post">
                      <?php if (isset($errorLogin['filedLogin'])): ?>
                        <span class="Message-error"><?php echo $errorLogin['filedLogin'] ?></span>
                    <?php endif; ?>
                    <?php if (isset($errorLogin['hasErrorInput'])): ?>
                        <span class="Message-error"><?php echo $errorLogin['hasErrorInput'] ?></span>
                    <?php endif; ?>
                    <label for="email">البريد الالكتروني</label>
                    <input type="email" name="email" id="email" placeholder="you@email.com" required>
                    <label for="password">كلمة المرور</label>
                    <input type="password" name="password" id="password" placeholder="كلمة المرور" maxlength="15" minlength="10" required>
                    <button type="submit" name="login" class="btn-register"> تسجيل دخول</button>
                </form>
            </div>
        </div>
    </section>
</main>
<?php include(__DIR__ . '/../includes/footer.php'); ?>
