<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\User\Pages;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use MoonShine\Laravel\Fields\Slug;
use MoonShine\Laravel\Pages\Crud\FormPage;
use MoonShine\Contracts\UI\ComponentContract;
use MoonShine\Contracts\UI\FormBuilderContract;
use MoonShine\UI\Components\Collapse;
use MoonShine\UI\Components\FormBuilder;
use MoonShine\Contracts\UI\FieldContract;
use MoonShine\Contracts\Core\TypeCasts\DataWrapperContract;
use App\MoonShine\Resources\User\UserResource;
use MoonShine\Support\ListOf;
use MoonShine\UI\Components\Layout\Column;
use MoonShine\UI\Components\Layout\Divider;
use MoonShine\UI\Components\Layout\Grid;
use MoonShine\UI\Components\Tabs;
use MoonShine\UI\Components\Tabs\Tab;
use MoonShine\UI\Fields\Date;
use MoonShine\UI\Fields\ID;
use MoonShine\UI\Components\Layout\Box;
use MoonShine\UI\Fields\Image;
use MoonShine\UI\Fields\Number;
use MoonShine\UI\Fields\Password;
use MoonShine\UI\Fields\PasswordRepeat;
use MoonShine\UI\Fields\Switcher;
use MoonShine\UI\Fields\Text;
use MoonShine\UI\Fields\Textarea;
use Throwable;


/**
 * @extends FormPage<UserResource>
 */
class UserFormPage extends FormPage
{
    /**
     * @return list<ComponentContract|FieldContract>
     */
    protected function fields(): iterable
    {
        return [

            Box::make([
                ID::make(),
                Divider::make('Покупатели/Пользователи'),
                Tabs::make([

                    Tab::make(__('Настройки'), [
                        Grid::make([
                            Column::make([

                                Box::make([
                                    Text::make('Имя', 'username')->required(),

                                    Image::make(__('Аватар'), 'avatar')
                                        ->disk('public')
                                        ->onAfterApply(function (Model $data, $file, Image $field) {
                                            if ($file !== false) {
                                                $destinationPath = 'users/' . $data->id . '/avatar';
                                                $file->storeAs($destinationPath, $data->avatar);
                                                Storage::disk('public')->delete($data->avatar);
                                                User::query()
                                                    ->where('id', $data->id)
                                                    ->update(['avatar' => $destinationPath . '/' . $data->avatar]);

                                            }

                                        })
                                        ->allowedExtensions(['jpg', 'png', 'jpeg', 'gif', 'svg', 'webp', 'gif'])
                                        ->removable(),

                                    Text::make(__('Email'), 'email'),
                                    Number::make('Телефон', 'phone')->min(1000)->max(1000000000000)->nullable()->hint('ТОЛЬКО цифры'),
                                ]),



                            ])->columnSpan(6),
                            Column::make([
                                Divider::make('Служебные'),

                                Box::make([

                                    Switcher::make('Публикация', 'published')->default(1),

                                    Date::make(__('Дата создания'), 'created_at')
                                        ->format("d.m.Y")
                                        ->default(now()->toDateTimeString())
                                        ->sortable(),
                                ]),

                            ])->columnSpan(6),
                        ]),

                    ]),
                    Tab::make(__('Пароль'), [
                        Grid::make([
                            Column::make([
                                Divider::make('Введите пароль'),

                                Box::make([

                                    Password::make(__('moonshine::ui.resource.password'), 'password')
                                        ->customAttributes(['autocomplete' => 'new-password'])
                                        ->eye(),

                                    PasswordRepeat::make(__('moonshine::ui.resource.repeat_password'), 'password_repeat')
                                        ->customAttributes(['autocomplete' => 'confirm-password'])
                                        ->eye(),
                                ]),
                            ])->columnSpan(12),
                        ]),

                    ]),

                ]),
            ]),
        ];
    }

    protected function buttons(): ListOf
    {
        return parent::buttons();
    }

    protected function formButtons(): ListOf
    {
        return parent::formButtons();
    }

    protected function rules(DataWrapperContract $item): array
    {


        return [
            'username' => 'max:90',
            'email' => [
                'sometimes',
                'bail',
                'required',
                'email',
                Rule::unique('users')->ignore($item->email, 'email'),
            ],
            'password' => $item->exists
                ? 'sometimes|nullable|min:5|required_with:password_repeat|same:password_repeat'
                : 'required|min:5|required_with:password_repeat|same:password_repeat',
        ];


    }

    /**
     * @param  FormBuilder  $component
     *
     * @return FormBuilder
     */
    protected function modifyFormComponent(FormBuilderContract $component): FormBuilderContract
    {
        return $component;
    }

    /**
     * @return list<ComponentContract>
     * @throws Throwable
     */
    protected function topLayer(): array
    {
        return [
            ...parent::topLayer()
        ];
    }

    /**
     * @return list<ComponentContract>
     * @throws Throwable
     */
    protected function mainLayer(): array
    {
        return [
            ...parent::mainLayer()
        ];
    }

    /**
     * @return list<ComponentContract>
     * @throws Throwable
     */
    protected function bottomLayer(): array
    {
        return [
            ...parent::bottomLayer()
        ];
    }
}
