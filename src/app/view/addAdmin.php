<?php require(__DIR__ . '/../includes/headerAdmin.php');

$success = isset($_GET['success']) ? $_GET['success'] : "";
$notSuccess = isset($_GET['notSuccess']) ? $_GET['notSuccess'] : "";
?>
<main>
    <section>
        <div class="container">

            <div class="box-add-book">
                <?php if (!empty($success)): ?>
                    <p class="success"> <?php echo $success ?></p>
                <?php elseif (!empty($notSuccess)): ?>
                    <p class="notSuccess"> <?php echo $notSuccess ?></p>
                <?php endif; ?>

                <form action="/Madad/admin/addAdmin" method="POST" >
                    <div class="adminForm">

                        <label for="book_name">اسم المشرف</label>
                        <input type="text" name="adminName" id="book_name" placeholder="ادخل اسم المشرف" required>
                        
                        <label for="email"> البريد الالكتروني</label>
                        <input type="email" name="adminEmail" id="email" placeholder="ادخل البريد الالكتروني " required>
                        
                        <label for="category">كلمة المرور</label>
                        <input type="password" name="adminPassword" id="password" placeholder="ادخل كلمة المرور" required>
                        
                        <button type="submit" id="btnAddNewAdmin" name="btnAddNewAdmin"> إضافة</button>
                    </div>
                </form>
            </div>

        </div>
    </section>
</main>
<!-- <script src="../asstes/js/main.js"></script> -->