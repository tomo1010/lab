<?php

use Diglactic\Breadcrumbs\Breadcrumbs;
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;

// TOP 第1階層
Breadcrumbs::for('site.top', function (BreadcrumbTrail $trail) {
    $trail->push('TOPページ', route('car.index'));
});

// カテゴリTOP 第2階層
Breadcrumbs::for('site.category', function (BreadcrumbTrail $trail, Category $category) {
    $trail->parent('site.top');
    $trail->push($year, route('car.minivan'));
});

// カテゴリ別記事一覧 第3階層
Breadcrumbs::for('site.category.article', function (BreadcrumbTrail $trail, Category $category) {
    $trail->parent('site.category');
}
$trail->push("{$category->name}新着記事一覧", route('site.category.article', $category->id));
});
