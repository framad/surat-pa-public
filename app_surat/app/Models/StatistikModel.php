<?php 
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StatistikModel extends Model
{
    use HasFactory;

    public function get_month_year() {
        $months = [
            (object) ['m' => 1, 'month'  => 'Januari'],
            (object) ['m' => 2, 'month'  => 'Februari'],
            (object) ['m' => 3, 'month'  => 'Maret'],
            (object) ['m' => 4, 'month'  => 'April'],
            (object) ['m' => 5, 'month'  => 'Mei'],
            (object) ['m' => 6, 'month'  => 'Juni'],
            (object) ['m' => 7, 'month'  => 'Juli'],
            (object) ['m' => 8, 'month'  => 'Agustus'],
            (object) ['m' => 9, 'month'  => 'September'],
            (object) ['m' => 10, 'month' => 'Oktober'],
            (object) ['m' => 11, 'month' => 'November'],
            (object) ['m' => 12, 'month' => 'Desember'],
        ];

        $years = range((date('Y')-4), date('Y'));

        return ['months' => $months, 'years' => $years];
    }
}