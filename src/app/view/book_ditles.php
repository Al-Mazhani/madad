<?php
$pageTitle =   ' تحميل كتاب  ' . $infoBook->Title();
include('src/app/includes/header.php'); ?>

<main>
  <section class="container">
    <h1 class="title_book_info"> تحميل كتاب <?php echo htmlspecialchars($infoBook->Title()) ?> PDF </h1>
    <div class="book-main">
      <div class="book_info">
        <div class="img_book">
          <img src="<?= htmlspecialchars($infoBook->Image()) ?>" alt="<?= htmlspecialchars($infoBook->Title()) ?>" title="<?php echo htmlspecialchars($infoBook->Title()) ?> " loading="lazy">

        </div>
        <div class="ditles">
          <h2><?php echo htmlspecialchars($infoBook->Title()) ?> </h2>
          <table>
            <tbody>
              <tr>
                <td>مؤلف</td>
                <td title="<?php echo htmlspecialchars($infoBook->Title()) ?>"> <?php echo htmlspecialchars($infoBook->Title()) ?> </td>
              </tr>
              <tr>
                <td>القسم</td>
                <td><?php echo htmlspecialchars($infoBook->Title()) ?></td>
              </tr>
              <tr>
                <td>اللغة</td>
                <td><?php echo htmlspecialchars($infoBook->Language()) ?></td>
              </tr>
              <tr>
                <td>الناشر</td>
                <td>دار ابن الجوزي</td>
              </tr>
              <tr>
                <td>الصفحات</td>
                <td><?php echo htmlspecialchars($infoBook->Pages()) ?></td>
              </tr>
              <tr>
                <td>حجم الملف </td>
                <td><?php echo htmlspecialchars($infoBook->FileSize()) ?> KB</td>
              </tr>
              <tr>
                <td>نوع الملف</td>
                <td><?php echo htmlspecialchars($infoBook->FileType()) ?></td>
              </tr>
              <tr>
                <td> تاريخ الانشاء</td>
                <td><?php echo htmlspecialchars($infoBook->CreatedAt()->format('Y-m-d')) ?></td>
              </tr>
            </tbody>
          </table>
        </div>

      </div>
      <div class="last-book">
        <h3>كتب أخرى</h3>
        <ul>
          <?php if (!empty($OtherBooks)): ?>
            <?php foreach ($OtherBooks as $books): ?>
              <li> <a href="/Madad/book_ditles/id/<?= $books['book_public_id'] ?>" title="<?= htmlspecialchars($books['title']) ?>"> <?= htmlspecialchars($books['title']) ?></a> <i class="fas fa-book"></i></li>
            <?php endforeach; ?>
          <?php endif; ?>
        </ul>
      </div>
    </div>
    <section class="info_book">
      <div class="action_book">
        <a href="/Madad/<?php echo htmlspecialchars($infoBook->Book()); ?> " title="عدد التحميلات" download data-id="<?php echo $infoBook->PublicID() ?> " onclick="incrementDownload(this)"><i class="fas fa-download"></i> <?php echo htmlspecialchars($infoBook->CountDownload()) ?></a>
        <a href="/Madad/<?php echo htmlspecialchars($infoBook->Book()); ?>" title="عدد القراءة" target="_blank" data-id="<?php echo $infoBook->PublicID ?>" onclick="incrementReadBook(this)"> <i class="fa-solid fa-book-open"></i> <?php echo htmlspecialchars($infoBook->ReadCount()) ?></a>
        <button class="sharing" title="مشاركة"><i class="fas fa-share-alt"></i></button>
        <button class="btn-like-book" title="اعجبني"><i class="fas fa-thumbs-up"></i></button>
      </div>
    </section>
    <div class="book_descrption">
      <h3>وصف الكتب</h3>
      <p><?php echo htmlspecialchars($infoBook->Description()) ?></p>
    </div>
  </section>
  <h4 class="title-like-you-book">كتب قد تعجبك</h4>
      <?php include('src/app/includes/BoxBook.php') ?>

</main>
<?php include(__DIR__ . '/../includes/footer.php'); ?>