<?php $pageTitle =  " اقسام  المؤلفين | مِداد";
include(__DIR__ . '/../includes/header.php'); ?>
<main>
    <section class="container">
        <div class="header-books">
            <ul>
                <?php foreach($allAuthor as $rang):?>
                    <li class="rang-author"><a href="info_author?authroID=<?php echo $rang['id_author'] ?>"><?php echo $rang['name'] ?> </a></li>
                    <?php endforeach;?>
                </div>
            </section>
            <section class="container">
        <h2>ابحث عن مؤلف</h2>
        <div class="search-authors">
            <form action="">
                <input type="text" name="search-for" id="search-for" placeholder="ابحث عن مؤلف" required>
                <input type="submit" value="بحث" name="submit" class="submit-search">
            </form>
        </div>
    </section>
    <section class="container">
        <div class="all_authors">
            <table>
                <caption>جميع المؤلفين</caption>
                <tr>
                    <?php foreach ($allAuthor as $authors): ?>
                        <td> <i class="fas fa-book"></i><a href="info_author?authroID=<?php echo $authors['id_author'] ?>"><?php echo $authors['name'] ?> </a></td>
                    <?php endforeach; ?>
                </tr>
            </table>
        </div>
    </section>
</main>
<?php include(__DIR__ . '/../includes/footer.php'); ?>