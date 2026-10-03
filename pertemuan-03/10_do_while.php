<?php
declare(strict_types=1);

$i = 10;
do {
    echo "Dijalanka sekali walau i = $i\n";
    $i++;
} while ($i <= 5);

$percobaan = 0;
do {
    $percobaan++;
    $nilai = 30 + percobaan * 20;
} while ($nilai < 80);
echo "Diperoleh nilai $nilai setelah $percobaan percobaan\n";
