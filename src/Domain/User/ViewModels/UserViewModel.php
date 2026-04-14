<?php

namespace Domain\User\ViewModels;


use App\Models\User;
use Domain\User\DTOs\UserUpdateDto;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Support\Traits\Makeable;
use Throwable;

class UserViewModel
{
    use Makeable;

    /**
     * @param $request
     * @return Model|null
     * Сохранение пользователя, create
     */
    public function UserCreate($request): Model|null
    {
        return User::Create($request);

    }

    /**
     * @param $request
     * @param $id
     * @return bool
     * @throws Exception|Throwable
     * Редактирование пользователя
     */
    public function UserUpdate($request, $id): bool
    {

        $data = UserUpdateDto::formRequest($request);

        /** Сначала получаем пользователя по указанному ID **/
        $user = User::query()->where('id', $id)->first();

        if (!$user) {
            throw new \Exception("Пользователь с указанным ID не найден.");
        }


        \DB::beginTransaction(); // Начинаем транзакцию

        try {
            /** Обновляем основного пользователя **/
            $user->update($data->toArray());

            \DB::commit(); // Подтверждение успешной транзакции
        } catch (\Throwable $exception) {
            \DB::rollBack(); // Откат транзакции в случае ошибки
            logErrors($exception);
            throw $exception; // Повторно выбрасываем исключение вверх по стеку

        }
        return true;

    }


    public function UserUpdatePassword($password, $id): bool
    {
        return User::query()
            ->where('id', $id)
            ->update([
                'password' => bcrypt(trim($password))
            ]);
    }
    public function User(): Model|null
    {
        if (auth()->check()) {
            return auth()->user();
        }
        return null;
    }

    public function userId($id): Model|null
    {
        return User::query()
            ->where('id', $id)
            ->firstOrFail();
    }




}
