<?php
declare(strict_types=1);
namespace App;

$conn = mysqli_connect('localhost', 'Sash', 'strength123', 'teb notes');
if (!$conn) return echo 'Connection failed: ' . mysqli_connect_error();

