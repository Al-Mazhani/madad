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
                <button type="submit" class="submit-search"> بحث</button>
            </form>
        </div>
    </section>
    <?php include('src/app/includes/BoxBook.php') ?>

</main>
<?php include(__DIR__ . '/../includes/footer.php'); ?>