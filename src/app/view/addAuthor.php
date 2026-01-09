<?php require(__DIR__ . '/../includes/headerAdmin.php');

$Message;
?>
<main>
    <section>
        <div class="container">

            <div class="box-add-book">
                <?php if (!empty($Message)): ?>
                    <p class="success"> <?php echo $Message ?></p>
                <?php endif; ?>
                <form action="" method="POST" enctype="multipart/form-data">
                    <div class="content-the-four-input">

                        <div class="box-form">
                            <input type="hidden" name="id" value="<?php if(isset($updateAuthor['public_id']))?>">
                            <label for="author_name">اسم المؤلف</label>
                            <input type="text" name="authorName" id="author_name" placeholder="ادخل اسم الكتاب" required value="<?php
                                 if (isset($updateAuthor)) {
                                       echo $updateAuthor['name'];
                                  }
                               ?>">
                        </div>

                        <div class="box-form">
                            <label for="fileInput" class="upload-btn fileinputImageAuthor"> إضافة صورة</label>
                            <input type="file" id="fileInput" name="imageURLAuthro" accept="image/*" value="
                            <?php
                            if (isset($updateAuthor['image'])) {
                            }
                            ?>
                            ">
                        </div>
                    </div>

                    <div class="box-form">
                        <textarea name="bio" id="">
                       <?php
                        if (isset($updateAuthor['bio'])) {
                            echo $updateAuthor['bio'];
                        } else {
                            echo "  وصف المؤلف";
                        }
                        ?>     
                      </textarea>
                        <button type="submit" id="btnAddNewauthor" name="addauthor"> إضافة</button>
                </form>
            </div>
        </div>
        </div>
    </section>
</main>