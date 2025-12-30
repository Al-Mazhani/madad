<?php include(__DIR__ . '/../includes/header.php'); ?>
<main>
    <section class="container categories">
        <div class="header-books">
            <ul>
                <?php foreach ($allCategory as $rang): ?>
                    <li class="rang-author"><a href="category?id_category=<?php echo $rang['id_category'] ?>"><?php echo $rang['title_category'] ?> </a></li>
                <?php endforeach; ?>
            </ul>
        </div>

    </section>
    <section class="container">
        <h2>ابحث عن كتاب</h2>
        <div class="search-book">
            <form action="/Madad/search" method="GET">
                <input type="text" name="name" id="search-for" placeholder="ابحث عن كتاب" required>
                <button type="submit" name="search" class="submit-search"> بحث</button>
            </form>
        </div>
    </section>
    <section class="container">
        <div class="books_madad">
            <?php foreach ($allBooks as $book): ?>
                <div class="box_madad" title="<?= $book['title'] ?>">
                    <a href="book_ditles?bookID=<?= $book['id_book'] ?>" class="link-book">
                        <img src="<?= $book['image'] ?>" alt="<?= $book['title'] ?>" loading="lazy">
                    </a>
                    <a href="book_ditles?bookID=<?= $book['id_book'] ?>" class="book_title" title="<?= $book['title'] ?>"> <?= $book['title'] ?></a>
                    <a href="info_author?authroID=<?= $book['id_author'] ?>" class="author" title="<?= $book['name'] ?>"> <?= $book['name'] ?></a>
                </div>
            <?php endforeach; ?>
        </div>
    </section>
</main>
<?php include(__DIR__ . '/../includes/footer.php'); ?>