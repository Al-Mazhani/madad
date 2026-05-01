<?php
$pageTitle = $infoAuthor['name'] . " | مِداد";
include(__DIR__ . '/../includes/header.php'); ?>

<main>
    <div class="container">
        <div class="authro-card">
            <div class="header-authro">
                <div class="img_author">
                    <img src="<?= $infoAuthor['image'] ?>" alt="<?= $infoAuthor['name'] ?>" loading="lazy">
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
    <?php include('src/app/includes/BoxBook.php') ?>
     
    </section>
</main>
<?php include(__DIR__ . '/../includes/footer.php'); ?>