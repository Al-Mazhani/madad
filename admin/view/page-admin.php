<?php require(__DIR__ . '/../includes/header.php');; ?>
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
                        <input type="text" name="search-for" id="search-for" placeholder="ابحث عن كتاب" required>
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
                        <th>رقم الكتاب </th>
                        <th> اسم الكتاب </th>
                        <th> اسم المؤلف </th>
                        <th> التصنيف </th>
                        <th> الصفحات </th>
                        <th> حجم الملف </th>
                        <th>نوع الملف </th>
                        <th>التحميلات </th>
                        <th>عدد القراءة </th>
                        <th>اللغة </th>
                        <th>السنة </th>
                        <th>الحدث </th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($allBooks as $books): ?>
                        <tr>
                            <td><?php echo $books['id'] ?></td>
                            <td><?php echo $books['title'] ?></td>
                            <td><?php echo $books['NameAuthor'] ?></td>
                            <td><?php echo $books['titleCateogry'] ?></td>
                            <td><?php echo $books['pages'] ?></td>
                            <td><?php echo $books['file_size'] ?></td>
                            <td><?php echo $books['file_type'] ?></td>
                            <td><?php echo $books['downloads'] ?></td>
                            <td><?php echo $books['readBook'] ?></td>
                            <td><?php echo $books['language'] ?></td>
                            <td><?php echo $books['year'] ?></td>
                            <td class="action-btn">
                                <button class="btn update" onclick="deleteBook(<?= $books['id'] ?>)"><i class="fa-solid fa-trash"></i></button>
                                <a href="update?ID=<?= $books['id'] ?>"><i class="fa-solid fa-pen"></i></a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</main>
<script src="asstes/js/main.js"></script>
</body>

</html>