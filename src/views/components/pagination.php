<?php

$currentPage = $data['currentPage'];
$buttonsToShow = 5;
$totalPages = ceil($data['count'] / 21);
$startPage = max(1, $currentPage - floor($buttonsToShow / 2));
$endPage = min($totalPages, $startPage + 5 - 1);

$str = '<div class="pagination-container">';

if ($currentPage > 1) {
    $prevPage = $currentPage - 1;
    $str .= '<button class="pagination-button" onclick="handlePageChange(' . $prevPage . ')"> &larr; </button>';
}

for ($i = $startPage; $i <= $endPage; $i++) {
    $buttonClass = $i == $currentPage ? 'pagination-button active' : 'pagination-button';
    $str .= '<button class="' . $buttonClass . '" onclick="handlePageChange(' . $i . ')">' . $i . '</button>';
}

if ($currentPage < $endPage) {
    $nextPage = $currentPage + 1;
    $str .= '<button class="pagination-button" onclick="handlePageChange(' . $nextPage . ')"> &rarr; </button>';
}

$str .= '</div>';

echo $str;
