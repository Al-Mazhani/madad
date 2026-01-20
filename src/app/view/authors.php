<?php $pageTitle =  " اقسام  المؤلفين | مِداد";
include(__DIR__ . '/../includes/header.php'); ?>
<main>
    <section class="container">
        <div class="header-books">
            <ul>
                <?php foreach ($allAuthor as $rang): ?>
                    <li class="rang-author"><a href="info_author?authroID=<?php echo $rang['public_id'] ?>"><?php echo $rang['name'] ?> </a></li>
                <?php endforeach; ?>
        </div>
    </section>
    <section class="container">
        <h2>ابحث عن مؤلف</h2>
        <div class="search-authors">
            <form action="">
                <input type="text" name="name" id="search-for" placeholder="ابحث عن مؤلف" required>
                <input type="submit" value="بحث" class="submit-search">
            </form>
        </div>
    </section>
    <section class="container">
        <?php if (isset($SearchAuthor)): ?>
        <?php if (!empty($SearchAuthor)): ?>
            <div class="all_authors">
                <table>
                    <caption>عملية البحث عن مؤلف </caption>
                    <tr>
                        <td> <i class="fas fa-book"></i><a href="info_author?authroID=<?php echo $SearchAuthor['public_id'] ?>"><?php echo $SearchAuthor['name'] ?> </a></td>
                    </tr>
                </table>
            </div>
            <?php else: ?>
                <p>لم نجد المؤلف الذي تبحث عنه</p>
                <?php endif; ?>
    </section>
    <?php endif; ?>
    <section class="container">
        <?php if (isset($allAuthor)): ?>
        <div class="all_authors">
            <table>
                <caption>جميع المؤلفين</caption>
                <tr>
                    <?php foreach ($allAuthor as $authors): ?>
                        <td> <i class="fas fa-book"></i><a href="info_author?authroID=<?php echo $authors['public_id'] ?>"><?php echo $authors['name'] ?> </a></td>
                        <?php endforeach; ?>
                    </tr>
                </table>
            </div>
            <?php endif; ?>
        </section>
</main>
<?php include(__DIR__ . '/../includes/footer.php'); ?>