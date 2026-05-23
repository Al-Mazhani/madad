<div class="container">
    <div class="books_madad">
        <!-- Start -->
        <?php if (!empty($ListBook)): ?>
            <?php foreach ($ListBook as $book): ?>
                <div class="box_madad" title="<?= htmlspecialchars($book->Title()) ?>">
                    <a href="/Madad/book_ditles/id/<?= htmlspecialchars($book->PublicID()) ?>" class="link-book">
                        <img src="<?= htmlspecialchars($book->Image()) ?>" alt="<?= htmlspecialchars($book->Title()) ?>" loading="lazy">
                    </a>
                    <a href="/Madad/book_ditles/id/<?= htmlspecialchars($book->PublicID()) ?>" class="book_title" title="<?= htmlspecialchars($book->Title()) ?>"> <?= htmlspecialchars($book->Title()) ?></a>
                    <a href="/Madad/info_author/id/<?= htmlspecialchars($book->PublicID()) ?>" class="author" title="<?= htmlspecialchars($book->Title()) ?>"> <?= htmlspecialchars($book->title(  )) ?></a>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>ليس لديه كتب</p>
        <?php endif; ?>
        <!-- End -->
    </div>
</div>