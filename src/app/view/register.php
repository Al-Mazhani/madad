<?php $pageTitle =  " انشاء حساب   | مِداد";
include(__DIR__ . '/../includes/header.php'); ?>
<main>
    <section>
        <div class="container">
            <div class="register">
                <h1>انشاء حساب</h1>
                <?php if (isset($error['invalidRegister'])): ?>
                    <span> <?php echo $error['invalidRegister']; ?> </span>
                <?php endif; ?>
                <form action="" method="POST">
                    <label for="username">اسم المستخدم</label>
                    <input type="text" name="username" id="username" value="username" minlength="3" maxlength="30" required>
                    <?php if (isset($error['emptyName'])): ?>
                        <span> <?php echo $error['emptyName']; ?> </span>
                    <?php endif; ?>
                    <?php if (isset($error['lenghtUsername'])): ?>
                        <span> <?php echo $error['lenghtUsername']; ?> </span>
                    <?php endif; ?>
                    <label for="email">البريد الالكتروني</label>
                    <input type="email" name="email" id="email" placeholder="you@email.com" required>
                    <?php if (isset($error['emptyEmail'])): ?>
                        <span> <?php echo $error['emptyEmail']; ?> </span>
                    <?php endif; ?>
                    <?php if (isset($error['invalidEmail'])): ?>
                        <span> <?php echo $error['invalidEmail']; ?> </span>
                    <?php endif; ?>
                    <label for="password">كلمة المرور</label>
                    <input type="password" name="password" id="password" placeholder="كلمة المرور" maxlength="15" minlength="10" required>
                    <?php if (isset($error['emptyPassword'])): ?>
                        <span> <?php echo $error['emptyPassword']; ?> </span>
                    <?php endif; ?>
                    <?php if (isset($error['lenghtPassword'])): ?>
                        <span> <?php echo $error['lenghtPassword']; ?> </span>
                    <?php endif; ?>
                    <button type="submit" name="submit_register" class="btn-register"> انشاء حساب</button>
                </form>
            </div>
        </div>
    </section>
</main>