<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use MoonShine\Components\MoonShineComponent;
use MoonShine\Decorations\Block;
use MoonShine\Fields\Date;
use MoonShine\Fields\Email;
use MoonShine\Fields\Field;
use MoonShine\Fields\ID;
use MoonShine\Fields\Password;
use MoonShine\Resources\ModelResource;

/**
 * @extends ModelResource<User>
 */
class UserResource extends ModelResource {
    protected string $model = User::class;

    protected string $title = 'Users';

    /**
     * @return list<MoonShineComponent|Field>
     */
    public function fields() : array {
        return [
            Block::make([
                ID::make()->sortable(),
                Email::make('Email'),
                Date::make('Email Verified At'),
                Password::make('Password'),
                Date::make('Created At'),
                Date::make('Updated At'),            ]),
        ];
    }

    /**
     * @param  User  $item
     * @return array<string, string[]|string>
     *
     * @see https://laravel.com/docs/validation#available-validation-rules
     */
    public function rules(Model $item) : array {
        return [];
    }
}
