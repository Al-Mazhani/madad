<?php include(__DIR__ . '/../includes/header.php'); ?>
<div class="container">
    <div class="box-chnage-password">
        <h1>تغير كلمة المرور </h1>
        <div class="form-passwords">
            <?php if(isset($Message['hasErrorInput'])):  ?>
             <p class="Message-error"><?= $Message['hasErrorInput'] ?></p>
             <?php endif?>
            <?php if(isset($Message['NOTSamePassword'])):  ?>
             <p class="Message-error"><?= $Message['NOTSamePassword'] ?></p>
             <?php endif?>
            <?php if(isset($Message['SescesChangePassword'])):  ?>
             <p class="Message-error"><?= $Message['SescesChangePassword'] ?></p>
             <?php endif?>
            <?php if(isset($Message['InvaludChangePassword'])):  ?>
             <p class="Message-error"><?= $Message['InvaludChangePassword'] ?></p>
             <?php endif?>

            <form action="" method="post">
                <div class="old-password">
                    <label for="oldPassword"> كلمة المرور القديمة</label>
                    <input type="text" name="oldPassword" id="oldPassword" placeholder="كلمة المرور القديمة" tabindex="1" maxlength="15" minlength="10" required>
                </div>
                <div class="new-password">
                    <label for="newPassword">كلمة المرور الجديدة</label>
                    <input type="password" name="newPassword" id="newPassword" placeholder="كلمة المرور الجديدة" tabindex="2" maxlength="15" minlength="10" required>
                </div>
                <div class="config-password">
                    <label for="configPassword">تأكيد كلمة المرور </label>
                    <input type="password" name="configPassword" id="configPassword" placeholder="تأكيد كلمة المرور"  maxlength="15" minlength="10" required>
                </div>
                <button type="submit" class="btn-change-password">تغير</button>
            </form>
        </div>

    </div>
</div>
<?php include(__DIR__ . '/../includes/footer.php'); ?>