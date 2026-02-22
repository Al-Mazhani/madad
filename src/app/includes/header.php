<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/public/css/style.css">
    <link rel="stylesheet" href="/public/fontawesome/css/fontawesome.min.css">
    <link rel="stylesheet" href="/public/fontawesome/css/brands.min.css">
    <link rel="stylesheet" href="/public/fontawesome/css/solid.min.css">
    <link rel="icon" href="/public/images/iconMidad.png" type="image/png">

    <title><?php echo isset($pageTitle) ? $pageTitle : "مِداد"; ?></title>
</head>

<body dir="rtl">
    <header>
        <div class="container">
            <div class="logo-image">
                <a href="/Madad/">
                    <h1>مِداد</h1>

                </a>
            </div>

            <nav>
                <ul>
                    <li><a href="/">الرئيسية</a></li>
                    <li><a href="/books">أقسام الكتب</a></li>
                    <li><a href="/authors">مؤلفو الكتب</a></li>
                </ul>
            </nav>

            <div class="register-box">
                <?php if (empty($_COOKIE['remember_token'])): ?>
                    <a href="/login" class="btn to-log-in">
                        <i class="fas fa-right-to-bracket"></i>
                        دخول

                    </a>
                    <a href="/register" class="btn ">
                        <i class="fas fa-user"></i>
                        انشاء حساب

                    </a>
                <?php else: ?>
                    <!-- <a href="/profile" class="btn">
                        حسابي
                    </a> -->

                    <p class="show-info-user" onclick="DisplayInfo()"> حسابي<i class="fas fa-user"></i></p>
                <?php endif; ?>
                <ul class="list-of-links-profile" id="info-user">
                    <li><a href="/profile">الملف الشخصي</a></li>
                    <li><a href="/change-password">تغير كلمة المرور</a></li>
                    <li><a href="/sign_out" >تسجيل خروج</a></li>
                    
                </ul>
            </div>
        </div>
    </header>