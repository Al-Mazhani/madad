<?php

    enum Route: string
    {
        case home = '/Madad';
        case books = '/Madad/books';
        case category = '/Madad/category';
        case search = '/Madad/search';
        case authors = '/Madad/authors';
        case register = '/Madad/register';
        case login = '/Madad/login';
        case book_ditles = "/Madad/book_ditles/id";
        case info_author = '/Madad/info_author';
        case profile = '/Madad/profile';
        case sign_out = '/Madad/sign_out';
        case homePageAdmin = '/Madad/homeAdmin';
        case managemtAuthor = '/Madad/magagement-atuhor';
        case ManagementUsers = '/Madad/ManagementUsers';
        case addAuthor = '/Madad/addAuthor';
        case pageAdmin = '/Madad/admin';
        case pageAdminAddBook = '/Madad/addBook';
        case pageAdminAddAdmin = '/Madad/addAdmin';
        case errorURL = '/Madad/errorURL';
        case updateBook = '/Madad/update';
        case verifyEmail = '/Madad/verify-email';
    }
    $route = [
        Route::home->value => 'home.php',
        Route::books->value => 'books.php',
        Route::category->value => 'category.php',
        Route::search->value => 'search.php',
        Route::authors->value => 'authors.php',
        Route::register->value => 'register.php',
        Route::login->value => 'login.php',
        Route::errorURL->value => 'errorURL.php',
        Route::book_ditles->value => 'book_ditles.php',
        Route::info_author->value => 'info_author.php',
        Route::profile->value => 'profile.php',
        Route::sign_out->value => 'sign_out.php',
        Route::homePageAdmin->value => 'page-admin.php',
        Route::addAuthor->value => 'addAuthor.php',
        Route::managemtAuthor->value => 'manageAuthor.php',
        Route::ManagementUsers->value => 'ManagementUsers.php',
        Route::pageAdmin->value => 'admin.php',
        Route::pageAdminAddBook->value => 'addBook.php',
        Route::updateBook->value => 'updateBook.php',
        Route::verifyEmail->value => 'verify-email.php',
        '/Madad/addAdmin' => 'addAdmin.php',
    ];