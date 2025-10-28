<?php

namespace App\Filament\Resources\Comments\Actions;

use Filament\Actions\Action;
use Filament\Support\Enums\Width;
use Illuminate\Database\Eloquent\Model;
use Illuminate\View\View;

class CommentsAction extends Action
{
    public static function getDefaultName(): ?string
    {
        return 'comments';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->slideOver();
        $this->modalWidth(Width::Large);
        $this->modalCancelAction(false);
        $this->modalSubmitAction(false);

        $this->modalContent(fn(Model $record, Action $action): View => view('components.actions.comments_list', [
            'record' => $record,
        ]));

        $this->modalContentFooter(fn(Model $record, Action $action): View => view('components.actions.comments', [
            'record' => $record,
        ]));
    }
}
