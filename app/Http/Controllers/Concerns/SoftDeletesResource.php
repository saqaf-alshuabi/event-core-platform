<?php

namespace App\Http\Controllers\Concerns;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

trait SoftDeletesResource
{
    abstract protected function softDeleteQuery(): Builder;

    abstract protected function trashedInertiaPage(): string;

    abstract protected function trashedPropName(): string;

    abstract protected function trashedRouteName(): string;

    protected function renderTrashed(): Response
    {
        return Inertia::render($this->trashedInertiaPage(), [
            $this->trashedPropName() => $this->softDeleteQuery()
                ->onlyTrashed()
                ->latest('updated_at')
                ->get(),
        ]);
    }

    protected function restoreModel(Model $model): RedirectResponse
    {
        $model->restore();

        return redirect()
            ->route($this->trashedRouteName())
            ->with('success', class_basename($model).' restored successfully.');
    }

    protected function forceDeleteModel(Model $model): RedirectResponse
    {
        $model->forceDelete();

        return redirect()
            ->route($this->trashedRouteName())
            ->with('success', class_basename($model).' deleted permanently.');
    }
}
