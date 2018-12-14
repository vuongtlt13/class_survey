<?php

namespace App\Imports;

use App\Http\Controllers\UserController;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Database\QueryException;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class StudentImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return bool|\Cartalyst\Sentinel\Users\UserInteface
     */
    public function model(array $row)
    {
//        dd($row);
        $username = $row['ma_sinh_vienten_dang_nhap'];
        $password = $row['mat_khau'];
        $name = $row['ho_va_ten'];
        $email = $row['vnu_email'];
        $major = $row['khoa_dao_tao'];

        $credentials = [
            'username'    => $username,
            'password' => $password,
            'name' => $name,
            'type' => 0,
            'gender' => null,
            'email' => $email,
            'phone' => null,
            'address' => null,
        ];
        $other_infor = ['major' => $major];

        list($status, $error) = UserController::validateUser($credentials);
        if ($status == 1) {
            try {
                $user = Sentinel::registerAndActivate($credentials);
                $user->student()->update($other_infor);
                return $user;
            } catch (QueryException $e) {
                return response()
                    ->json(['status' => 0, 'msg' => 'Trùng tên tài khoản, số điện thoại hoặc email']);
            }
        }
        return response()
            ->json(['status' => $status, 'msg' => $error]);
    }
}
