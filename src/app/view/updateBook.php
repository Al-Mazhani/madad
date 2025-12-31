<?php require(__DIR__ . '/../includes/headerAdmin.php');

?>
<main>
    <section>
        <div class="container">

            <div class="box-add-book">
                <?php if ($_SERVER['REQUEST_METHOD'] === 'POST'): ?>
                <?php if (!empty($Message['successUpdate'])): ?>
                    <p class="success"> <?php echo $Message['successUpdate'] ?></p>
                <?php endif; ?>
                <?php if (!empty($Message['hasInputEmpty'])): ?>
                    <p class="Notsuccess"> <?php echo $Message['hasInputEmpty'] ?></p>
                <?php endif; ?>
                <?php endif; ?>
                <form action="" method="POST" enctype="multipart/form-data">
                    <div class="content-the-four-input">
                        <div class="fisrt-section">
                            <div class="box-form">
                                <label for="book_name">اسم الكتاب</label>
                                <input type="text" name="bookName" id="book_name" placeholder="ادخل اسم الكتاب" required value="<?php echo $updateBook['title'] ?>">
                            </div>
                            <div class="box-form">
                                <label for="author">المؤلف</label>
                                <select name="id_author" id="author">
                                    <?php foreach ($authors as $author): ?>
                                        <option value="<?php echo $author['id_author'] ?>">
                                            <?php echo $author['name'] ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="fisrt-section">
                            <div class="box-form">
                                <label for="date">سنة النشر</label>
                                <input type="date" name="publish_year" id="date" placeholder="ادخل سنة النشر" required value="<?php echo $updateBook['year']  . '-01-01'; ?>">
                            </div>
                            <div class="box-form">
                                <label for="category">النصنيف</label>
                                <select name="id_category" id="category">
                                    <?php foreach ($allCategory as $category): ?>
                                        <option value="<?php echo $category['id_category'] ?>">
                                            <?php echo $category['title_category'] ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="fisrt-section">
                            <div class="box-form">
                                <label for="pages">عدد الصفحات </label>
                                <input type="number" name="pages" id="pages" placeholder="ادخل عدد الصفحات" required value="<?php echo $updateBook['pages'] ?>">
                            </div>
                            <div class="box-form">
                                <label for="file_type"> نوع الملف </label>
                                <select name="file_type" id="file_type">
                                    <option value="PDF"><?PHP echo $updateBook['file_type'] ?></option>
                                    <option value="ZIP">ZIP</option>
                                </select>
                            </div>
                        </div>
                        <div class="fisrt-section">
                            <div class="box-form">
                                <label for="language">اللغة</label>
                                <select name="language" id="language">
                                    <option value="العربية">العربية</option>
                                    <option value="الانجليزية">الانجليزية</option>
                                </select>
                            </div>
                            <div class="box-form">
                                <label for="fileInputBook" class="upload-btn">إضافة كتاب</label>
                                <input type="file" name="book_url" id="fileInputBook" placeholder="ادخل  الكتاب" >
                                <input type="hidden" name="oldFileBook" value="<?php echo $updateBook['book_url']?>">
                                <input type="hidden" name="oldFileSize" value="<?php echo $updateBook['file_size']?>">
                            </div>
                        </div>
                    </div>
                    <div class="box-form">
                        <label for="fileInput" class="upload-btn "> إضافة صورة</label>
                        <input type="file" id="fileInput" name="image_url" accept="image/*">
                        <input type="hidden" name="oldPathImage" value="<?php echo $updateBook['image']?>">
                    </div>
                    <div class="box-form">
                        <textarea name="description" id="">
                             <?php echo $updateBook['description']; ?>
                        </textarea>
                    </div>
                    <button type="submit" id="btnAddNewBook" name="updateBook"> تعديل</button>
                </form>
            </div>
        </div>
    </section>
</main>