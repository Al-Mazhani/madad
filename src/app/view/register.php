<?php $pageTitle =  " انشاء حساب   | مِداد";
include(__DIR__ . '/../includes/header.php'); ?>
<main>
    <section>
        <div class="container">
            <div class="register">
                <h1>انشاء حساب</h1>
                <?php if (isset($ResultValidateInput)): ?>
                    <?php

                    switch ($ResultValidateInput) {

                        case enUserInputErrors::InvalidUsername:
                            echo '<span>خطاء في اسم المستخدم</span>';
                            break;

                        case enUserInputErrors::LanthUserName:
                            echo '<span>يرجى إدخال اسم المستخدم</span>';
                            break;

                        case enUserInputErrors::MissinUsername:
                            echo '<span>يرجى إدخال اسم المستخدم</span>';
                            break;

                        case enUserInputErrors::InvalidEmail:
                            echo '<span>البريد الإلكتروني غير صحيح</span>';
                            break;

                        case enUserInputErrors::MissinPassword:
                            echo '<span>يرجى إدخال كلمة المرور</span>';
                            break;

                        case enUserInputErrors::LengthPassword:
                            echo '<span>يجب ان تكون كلمة المرور بين  (10 - 15)</span>';
                            break;
                    }
                    ?>
                <?php endif; ?>
                <?php if (isset($ResultSave)): ?>
                    <?php
                    switch ($ResultSave) {
                        case OperationResult::EmailExists:
                            echo '<span> "البريد الالكتروني موجود بالفعل" </span>';
                            break;
                        case OperationResult::Fail:
                            echo '<span> "خطاء في انشاء حساب! حاول مرة اخرى" </span>';
                            break;
                    }
                    ?>
                <?php endif; ?>

                <form action="" method="POST">
                    <label for="username">اسم المستخدم</label>
                    <input type="text" name="username" id="username" value="<?= $_POST['username'] ?? 'username' ?>" minlength="3" maxlength="30" required>
                    <label for="email">البريد الالكتروني</label>
                    <input type="email" name="email" id="email" value="<?= $_POST['email'] ?? '' ?>" placeholder="you@email.com" required>
                    <label for="password">كلمة المرور</label>
                    <input type="password" name="password" id="password" value="<?= $_POST['password'] ?? '' ?>" placeholder="كلمة المرور" maxlength="15" minlength="10" required>
                    <button type="submit" name="submit_register" id="btn-register" class="btn-register"> انشاء حساب</button>
                </form>
            </div>
        </div>
    </section>


</main>
<?php include(__DIR__ . '/../includes/footer.php'); ?>