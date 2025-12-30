<?php include(__DIR__ . '/../includes/header.php'); ?>
<main>


    <div class="content">
        <h1>مكتبة مِداد</h1>
        <h2>مكتبة مِداد تجمع الكتب في مكان واحد</h2>
        <div class="search-box">
            <form action="/Madad/search">
                <input type="text" name="name" id="search-for" placeholder="ابحث عن كتاب او مؤلف" required>
                <button type="submit" name="search" class="submit-search"> بحث</button>
            </form>
        </div>
    </div>
    <section class="container">
        <section class="about-us">
            <div class="box-about">
                <img src="public/images/online-education.svg" alt="" loading="eager">
                <h3>80,000,00 زائر شهرياً</h3>
                <p>يزور موقع مكتبة مِداد اكثر من 8 مليون زائر مهتم بالكتب العربية شهرياً حول العالم</p>
            </div>
            <div class="box-about">
                <img src="public/images/home_search.svg" alt="">
                <h3>1000 عملية بحث يومياً </h3>
                <p>أكثر من 1000 ألف عملية بحث عن كتاب عربي تحدث يومياً على مكتبة مِداد</p>
            </div>
            <div class="box-about">
                <img src="public/images/digital-library.svg" alt="">
                <h3>1000 كتاب </h3>
                <p> آلاف الكتب المنشورة على مكتبة مِداد منها ما نشره المؤلف بنفسه أو فريق المكتبة</p>
            </div>
            <div class="box-about">
                <img src="public/images/digital-library (1).svg" alt="">
                <h3>309,032 مؤلف </h3>
                <p> تهدف مكتبة مِداد إلى إنشاء أكبر قاعدة بيانات لمؤلفين الكتب العربية عبر التاريخ </p>
            </div>
        </section>
        <div class="book_results">
            <div class="result-books" title="الأشهر اليوم">
                <a href="">
                    <img src="public/images/trend_books2.svg" alt="الأشهر اليوم">
                    <p> الأشهر اليوم</p>
                </a>
            </div>
            <div class="result-books" title="أشهر الكتب">
                <a href="">
                    <img src="public/images/best_books_all_days1.svg" alt="أشهر اليوم">
                    <p>أشهر الكتب</p>
                </a>
            </div>
            <div class="result-books" title="أحدث الكتب">
                <a href="">
                    <img src="public/images/new_books1.svg" alt=" أحدث الكتب">
                    <p> أحدث الكتب</p>
                </a>
            </div>
        </div>
    </section>
    <section class="container">
        <div class="books_madad">
            <?php foreach ($allBooks as $book): ?>
                <div class="box_madad" title="<?= $book['title'] ?>">
                    <a href="book_ditles?bookID=<?= $book['id_book'] ?>" class="link-book">
                        <img src="<?= $book['image'] ?>" alt="<?= $book['title'] ?>" loading="lazy">
                    </a>
                    <a href="book_ditles?bookID=<?= $book['id_book'] ?>" class="book_title" title="<?= $book['title'] ?>"> <?= htmlspecialchars($book['title']) ?></a>
                    <a href="info_author?authroID=<?= $book['id_author'] ?>" class="author" title="<?= $book['name'] ?>"> <?= htmlspecialchars($book['name']) ?></a>
                </div>
            <?php endforeach; ?>
        </div>
    </section>
</main>
<?php include(__DIR__ . '/../includes/footer.php'); ?>