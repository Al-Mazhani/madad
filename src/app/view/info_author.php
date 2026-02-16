<?php
$pageTitle = $infoAuthor['name'] . " | مِداد";
include(__DIR__ . '/../includes/header.php'); ?>

<main>
    <div class="container">
        <div class="authro-card">
            <div class="header-authro">
                <div class="img_author">
                    <img src="/Madad/<?= $infoAuthor['image'] ?>" alt="" loading="lazy">
                </div>
                <div class="authro-name">
                    <h1 title="name"> <?php echo $infoAuthor['name'] ?> </h1>
                    <p>التقيم (1.2) </p>
                </div>
            </div>
            <article class="author-bio">
                <p><?php echo $infoAuthor['bio'] ?></p>
            </article>
        </div>
    </div>
    <section>
        <div class="container">

            <div class="authro-stats">
                <ul>
                    <li>
                        <span>الكتب</span>
                        <span>(<?php echo $infoAuthor['allBooks'] ?>)</span>
                    </li>

                    <li>
                        <span> التحميل</span>
                        <span>(<?php echo $infoAuthor['downloads'] ?>)</span>
                    </li>
                    <li>
                        <span>القراءة </span>
                        <span>(<?php echo $infoAuthor['readers'] ?>)</span>
                    </li>
                </ul>
            </div>
        </div>
    </section>
    <section>
        <div class="container">
            <h2>كتب له</h2>
            <div class="books_madad">
                <!-- Start -->
                <?php if (is_array($allBooksAuthor)): ?>
                    <?php foreach ($allBooksAuthor as $book): ?>
                    <div class="box_madad" title="<?= htmlspecialchars($book['title']) ?>">
                        <a href="/book_ditles/id/<?= htmlspecialchars($book['book_public_id']) ?>" class="link-book">
                            <img src="<?= htmlspecialchars($book['image']) ?>" alt="<?= htmlspecialchars($book['title']) ?>" loading="lazy">
                        </a>
                        <a href="/book_ditles/id/<?= htmlspecialchars($book['book_public_id']) ?>" class="book_title" title="<?= htmlspecialchars($book['title']) ?>"> <?= htmlspecialchars($book['title']) ?></a>
                        <a href="/info_author/id/<?= htmlspecialchars($book['author_public_id']) ?>" class="author" title="<?= htmlspecialchars($book['name']) ?>"> <?= htmlspecialchars($book['name']) ?></a>
                    </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>ليس لديه كتب</p>
                <?php endif; ?>
                <!-- End -->
            </div>
        </div>
    </section>
</main>
<?php include(__DIR__ . '/../includes/footer.php'); ?>