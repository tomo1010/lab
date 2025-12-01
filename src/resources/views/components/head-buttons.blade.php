@props(['star_link' => '#', 'list_link' => '#', 'save_link' => '#', 'mail_link' => '#', 'manual_link' => '#'])
<div class="flex gap-3">
    <a href="{{ $star_link }}">
        <i class="fa-regular fa-star fa-lg"></i>
    </a>
    <a href="{{ $list_link }}">
        <i class="fa-solid fa-list fa-lg"></i>
    </a>
    <a href="{{ $save_link }}">
        <i class="fa-regular fa-floppy-disk fa-lg"></i>
    </a>
    <a href="{{ $mail_link }}">
        <i class="far fa-envelope fa-lg"></i>
    </a>
    <a href="{{ $manual_link }}">
        <i class="fa fa-book fa-lg"></i>
    </a>
</div>