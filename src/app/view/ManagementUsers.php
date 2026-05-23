<?php include(__DIR__ . '/../includes/headerAdmin.php'); ?>
<?php require(__DIR__ . '/../includes/session.php'); ?>

<main>
    <section>
        <div class="container">

            <div class="main-content">
                <div class="box-admin add-new-book">
                    <a href="addBook">
                        <span> Add User</span><i class="fa-solid fa-book-medical"></i>


                    </a>
                    <div class="result-action">
                        <?php
                        if (isset($ResultDelete)) {
                            switch ($ResultDelete) {
                                case OperationResult::Deleted:
                                    echo '<span > تم الحذف </span>';
                                    break;
                                case OperationResult::Fail:
                                    echo '<span > فشل الحذف</span>';
                                    break;
                                case OperationResult::NoPermissions:
                                    echo '<span "> ليس لديك صلاحية لحذف هذه المستخدم</span>';
                                    break;
                            }
                        }
                        ?>
                    </div>

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
                        <th> الدور</th>
                        <th> حالة الحساب</th>
                        <th> الحدث</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($AllUsers as $user): ?>
                        <tr>
                            <td><?php echo $user->ID() ?></td>
                            <td><?php echo $user->Username() ?></td>
                            <td><?php echo $user->Email() ?></td>
                            <td><?php echo $user->Role() ?></td>
                            <td><?php if ($user->Status() == UserStatus::Active)
                                    echo   "نشط";
                                elseif ($user->Status() == UserStatus::InActive)
                                    echo "غير نشط";
                                elseif ($user->Status() == UserStatus::Banned)
                                    echo "محظور";
                                elseif ($user->Status() == UserStatus::Pending)
                                    echo "تحت الإجراء";
                                ?>
                            </td>
                            <td class="action-btn">
                                <button class="btn delete" onclick="window.location='/Madad/ManagementUsers?id=<?php echo $user->ID() ?>'"><i class="fa-solid fa-trash"></i></button>
                                <button class="btn update" onclick="window.location='/Madad/user/update/id/<?php echo $user->ID() ?>'"><i class="fa-solid fa-pen"></i></button>
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
<?php include(__DIR__ . '/../includes/footerAdmin.php'); ?>