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

