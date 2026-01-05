<?php include(__DIR__ . '/../includes/header.php'); ?>
<main>
    <section class="container categories">
        <div class="header-books">
            <ul>
                <?php foreach ($allCategory as $rang): ?>
                    <li class="rang-author"><a href="category?id_category=<?= (int)$rang['id_category'] ?>"><?php echo htmlspecialchars($rang['title_category']) ?> </a></li>
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
                <div class="box_madad" title="<?= htmlspecialchars($book['title']) ?>">
                    <a href="book_ditles?bookID=<?= $book['book_public_id'] ?>" class="link-book">
                        <img src="<?= htmlspecialchars($book['image']) ?>" alt="<?= htmlspecialchars($book['title']) ?>" loading="lazy">
                    </a>
                    <a href="book_ditles?bookID=<?= (int)$book['book_public_id'] ?>" class="book_title" title="<?= htmlspecialchars($book['title']) ?>"> <?= htmlspecialchars($book['title']) ?></a>
                    <a href="info_author?authroID=<?= (int)$book['author_public_id'] ?>" class="author" title="<?= htmlspecialchars($book['name']) ?>"> <?= htmlspecialchars($book['name']) ?></a>
                </div>
            <?php endforeach; ?>
        </div>
    </section>
</main>
<?php include(__DIR__ . '/../includes/footer.php'); ?>