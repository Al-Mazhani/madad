<div class="container">
    <div class="books_madad">
        <!-- Start -->
        <?php if (!empty($allBooks)): ?>
            <?php foreach ($allBooks as $book): ?>
                <div class="box_madad" title="<?= htmlspecialchars($book['title']) ?>">
                    <a href="/Madad/book_ditles/id/<?= htmlspecialchars($book['book_public_id']) ?>" class="link-book">
                        <img src="<?= htmlspecialchars($book['image']) ?>" alt="<?= htmlspecialchars($book['title']) ?>" loading="lazy">
                    </a>
                    <a href="/Madad/book_ditles/id/<?= htmlspecialchars($book['book_public_id']) ?>" class="book_title" title="<?= htmlspecialchars($book['title']) ?>"> <?= htmlspecialchars($book['title']) ?></a>
                    <a href="/Madad/info_author/id/<?= htmlspecialchars($book['author_public_id']) ?>" class="author" title="<?= htmlspecialchars($book['name']) ?>"> <?= htmlspecialchars($book['name']) ?></a>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>ليس لديه كتب</p>
        <?php endif; ?>
        <!-- End -->
    </div>
</div>