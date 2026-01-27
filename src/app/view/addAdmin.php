<?php require(__DIR__ . '/../includes/headerAdmin.php');
require(__DIR__ . '/../includes/session.php');

?>
<main>
    <section>
        <div class="container">

            <div class="box-add-book">
                <?php if (isset($message['invalidRegister']) ): ?>
                    <p class="notSuccess"> <?php echo $success ?></p>
                <?php if (empty($message['invalidRegister']) ) ?>
                    <p class="success"> تم إضافة مشرف جديد</p>
                <?php endif; ?>

                <form action="" method="POST" >
                    <div class="adminForm">

                        <label for="book_name">اسم المشرف</label>
                        <input type="text" name="adminName" id="book_name" placeholder="ادخل اسم المشرف" required>
                        
                        <label for="email"> البريد الالكتروني</label>
                        <input type="email" name="adminEmail" id="email" placeholder="ادخل البريد الالكتروني " required>
                        
                        <label for="category">كلمة المرور</label>
                        <input type="password" name="adminPassword" id="password" placeholder="ادخل كلمة المرور" required>
                        <label for="role">س</label>
                        <select name="role" id="role">
                            <option value="admin">admin</option>
                        </select>
                        <button type="submit" id="btnAddNewAdmin" name="btnAddNewAdmin"> إضافة</button>
                    </div>
                </form>
            </div>

        </div>
    </section>
</main>
<!-- <script src="../asstes/js/main.js"></script> -->