<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use App\Models\Note;
use Illuminate\Database\Eloquent\Model;
use MoonShine\Components\MoonShineComponent;
use MoonShine\Decorations\Block;
use MoonShine\Fields\Field;
use MoonShine\Fields\ID;
use MoonShine\Fields\Number;
use MoonShine\Fields\Text;
use MoonShine\Resources\ModelResource;

/**
 * @extends ModelResource<Note>
 */
class NoteResource extends ModelResource {
    protected string $model = Note::class;

    protected string $title = 'Notes';

    // my formatter helpers
    protected function trunc(string $data, int $len) : string {
        return substr($data, 0, $len - 3) . '...';
    }

    protected function formatDate($date) : string {
        return $date->format('d-M-y H:i');
    }

    protected function boolToString(bool $bool) : string {
        return $bool ? 'Yes' : 'No';
    }

    /**
     * @return list<MoonShineComponent|Field>
     */
    public function fields() : array {
        return [
            Block::make([
                ID::make()->sortable(),
                // tried out the new annonymous arrow function syntax :)
                Text::make('Created At', 'note.created_at', fn ($item) => $this->formatDate($item->created_at)),
                Text::make('Updated At', 'note.updated_at', fn ($item) => $this->formatDate($item->updated_at)),
                Text::make('Img Url', 'note.img_url', fn ($item) => basename($item->img_url)),
                Text::make('Extracted Data', 'note.extracted_data', fn ($item) => $this->trunc($item->extracted_data, 15)),
                Text::make('Is Favourite', 'note.is_favourite', fn ($item) => $this->boolToString($item->is_favourite)),
                Text::make('Is Archived', 'note.is_archived', fn ($item) => $this->boolToString($item->is_archived)),
                Text::make('Is Edited', 'note.is_edited', fn ($item) => $this->boolToString($item->is_edited)),
                Text::make('Is Deleted', 'note.is_deleted', fn ($item) => $this->boolToString($item->is_deleted)),
                Text::make('Markdown', 'note.markdown', fn ($item) => $this->trunc($item->markdown, 15)),
                Text::make('Title', 'note.title', fn ($item) => $this->trunc($item->title, 10)),
                Number::make('User Id'),
            ]),
        ];
    }

    /**
     * @param  Note  $item
     * @return array<string, string[]|string>
     *
     * @see https://laravel.com/docs/validation#available-validation-rules
     */
    public function rules(Model $item) : array {
        return [];
    }
}
