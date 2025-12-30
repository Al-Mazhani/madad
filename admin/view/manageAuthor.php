<?php require(__DIR__ . '/../includes/header.php');; ?>
<main>
    <section>
        <div class="container">
            <div class="main-content">
                <div class="box-author add-new-book">
                    <a href="addBook">
                        <span> إضافة مؤلف</span><i class="fa-solid fa-book-medical"></i>

                    </a>
                </div>
                <div class="search-book">
                    <form action="">
                        <input type="text" name="search-for" id="search-for" placeholder="ابحث عن مؤلف" required>
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
                        <th>رقم المؤلف </th>
                        <th>اسم المؤلف</th>
                        <th> الحدث</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($allAuthors as $author): ?>
                        <tr class="row">
                            <td><?php echo $author['id_author'] ?></td>
                            <td><?php echo $author['name'] ?></td>
                            <td class="action-btn">
                                <button class="btn delete" onclick="window.location='page2.php?id=5'"> <i class="fa-solid fa-trash"></i></button>
                                <button class="btn update" onclick="window.location='updateBook.php?updateID=5'"> <i class="fa-solid fa-pen"></i></button>
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