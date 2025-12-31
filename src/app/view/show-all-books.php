<?php require(__DIR__ . '/../includes/headerAdmin.php'); ?>
<main>
    <div class="container">
        <div class="table-books">
            <table>
                <thead>
                    <tr>
                        <th>رقم الكتاب </th>
                        <th>اسم الكتاب</th>
                        <th>المؤلف </tdh>
                        <th>تاريخ النشر</th>
                        <th>دار النشر</th>
                        <th> الحدث</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>حسين</td>
                        <td>علي</td>
                        <td>2020</td>
                        <td>نور</td>
                        <td class="action-btn">
                            <button class="btn delete">حذف</button>
                            <button class="btn update">تعديل</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</main>
</body>

</html>