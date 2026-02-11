<?php include(__DIR__ . '/../includes/header.php'); ?>

<main>
    <section class="container categories">
        <div class="header-books">
            <ul>
                <?php foreach ($allCategory as $rang): ?>
                    <li class="rang-author"><a href="/Madad/category/<?= htmlspecialchars($rang['category_public_id']) ?>"><?php echo htmlspecialchars($rang['title_category']) ?> </a></li>
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
            <?php if ($search): ?>
                <?php foreach ($search as &$book): ?>
                    <div class="box_madad" title="<?= htmlspecialchars($book['title']) ?>">
                        <a href="/Madad/book_ditles/id/<?= htmlspecialchars($book['book_public_id']) ?>" class="link-book">
                            <img src="/Madad/<?= htmlspecialchars($book['image']) ?>" alt="<?= htmlspecialchars($book['title']) ?>" loading="lazy">
                        </a>
                        <a href="/Madad/book_ditles/id/<?= htmlspecialchars($book['book_public_id']) ?>" class="book_title" title="<?= htmlspecialchars($book['title']) ?>"> <?= htmlspecialchars($book['title']) ?></a>
                        <a href="/Madad/info_author/id/<?= htmlspecialchars($book['author_public_id']) ?>" class="author" title="<?= htmlspecialchars($book['name']) ?>"> <?= htmlspecialchars($book['name']) ?></a>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>لم نجد الكتاب</p>
            <?php endif; ?>
        </div>
    </section>
</main>
<?php include(__DIR__ . '/../includes/footer.php'); ?>