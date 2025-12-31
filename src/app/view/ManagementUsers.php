<?php require(__DIR__ . '/../includes/headerAdmin.php'); ?>
<main>
    <section>
        <div class="container">

            <div class="main-content">
                <div class="box-admin add-new-book">
                    <a href="addBook">
                        <span> إضافة كتاب</span><i class="fa-solid fa-book-medical"></i>

                    </a>
                </div>
                <div class="search-book">
                    <form action="">
                        <input type="text" name="search-for" id="search-for" placeholder="ابحث عن مستدم " required>
                        <button type="submit" name="submit" class="submit-search"> بحث </button>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <div class="container">
        <div class="table-books">
            <table>
                <thead>
                    <tr>
                        <th>رقم المستخدم </th>
                        <th> اسم المستخدم</th>
                        <th> البريد الالكتروني</th>
                        <th> كلمة المرور</th>
                        <th> تاريخ انشاء الحساب</th>
                        <th> الحدث</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($allUsers as $users): ?>
                        <tr>
                            <td><?php echo $users['user_id'] ?></td>
                            <td><?php echo $users['username'] ?></td>
                            <td><?php echo $users['email'] ?></td>
                            <td><?php echo $users['password'] ?></td>
                            <td><?php echo $users['created_at'] ?></td>
                            <td class="action-btn">
                                <button class="btn delete" onclick="window.location='?id=<?= $users['user_id'] ?>'"><i class="fa-solid fa-trash"></i></button>
                                <button class="btn update" onclick="window.location='update?='"><i class="fa-solid fa-pen"></i></button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</main>
</body>

</html>