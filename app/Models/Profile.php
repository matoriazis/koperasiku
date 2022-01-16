<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use \Carbon\Carbon;

class Profile extends Model
{
    use HasFactory;

    public const PROFILE_SUBMITTED = 'PROFILE SUMBITTED';

    protected $guarded = [];

    protected $tables = 'profiles';

    public static function generateMemberCode() {
        $string = 'KSP';
        $now = Carbon::now();
        $month = $now->format('m');
        $year = $now->format('y');
        $monthYear = $now->format('Y-m') . '%';

        if((int) $month < 10) { $month = '0' . $month;}

        $tempCode = $string .'.'. $month .'.'. $year;

        $lastRecord = self::where('created_at', 'like', $monthYear)->orderBy('created_at', 'desc')->first();

        if($lastRecord){
            if($lastRecord->code == null){
                return $tempCode .'.'. sprintf("%'.04d", 1);
            }else{
                $explodeLastCode = explode('.', $lastRecord->code);
                $newIteration = (int) $explodeLastCode[count($explodeLastCode) - 1];
                do {
                    $newIteration++;
                    $newTempCode = $tempCode .'.'. sprintf("%'.04d", $newIteration);
                } while (self::checkCodeIsExist($newTempCode));

                return $newTempCode;
            }
        }
    }

    private function checkCodeIsExist($code) {
        return self::where('code', $code)->first() ? true : false;
    }

    public function user() {
        return $this->hasOne(User::class, 'user_id');
    }
}
