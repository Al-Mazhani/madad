<?php require(__DIR__ . '/../includes/header.php');; ?>
<main>
    <section>
        <div class="container">
            <div class="main-content">
                <div class="box-admin add-new-book">
                    <a href="addAdmin">
                        <span> إضافة ادمن</span><i class="fa-solid fa-book-medical"></i>

                    </a>
                </div>
                <div class="search-book">
                    <form action="">
                        <input type="text" name="search-for" id="search-for" placeholder="ابحث عن ادمن" required>
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
                        <th>رقم الادمن </th>
                        <th>اسم الادمن</th>
                        <th>البريد الالكتروني </tdh>
                        <th> الحدث</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($allAdmins as $Admin):?>
                    <tr>
                        <td><?php echo $Admin['admin_id'] ?></td>
                        <td><?php echo $Admin['name'] ?></td>
                        <td><?php echo $Admin['email'] ?></td>
                        <td class="action-btn">
                            <button class="btn delete" onclick="window.location='page2.php?id=5'"><i class="fa-solid fa-trash"></i></button>
                            <button class="btn update" onclick="window.location='updateBook.php?updateID=5'"><i class="fa-solid fa-pen"></i></button>
                        </td>
                    </tr>
                    <?php endforeach;?>
                </tbody>
            </table>
        </div>
    </div>
</main>
</body>

</html>