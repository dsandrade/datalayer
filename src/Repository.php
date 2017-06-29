<?php

namespace OneGiba\DataLayer;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use OneGiba\DataLayer\Contracts\RepositoryInterface;

abstract class Repository implements RepositoryInterface
{
    /**
     * @var \Illuminate\Database\Eloquent\Model|null
     */
    protected $model = null;

    /**
     * @param \Illuminate\Database\Eloquent\Model|null $model
     * @return void
     */
    public function __construct(?Model $model = null)
    {
        $this->model = $model ?? app()->make($this->model);
    }

    /**
     * { @inheritdoc }
     */
    public function findById(int $resourceId, array $columns = ['*'], array $with = []): ?Model
    {
        return $this->model
            ->with($with)
            ->find($resourceId, $columns);
    }

    /**
     * { @inheritdoc }
     */
    public function findFirst(string $attribute, string $value, array $columns = ['*'], array $with = []): ?Model
    {
        return $this->model
            ->with($with)
            ->where($attribute, '=', $value)
            ->first($columns);
    }

    /**
     * { @inheritdoc }
     */
    public function findBy(string $attribute, string $value, array $columns = ['*'], array $with = []): Collection
    {
        return $this->model
            ->with($with)
            ->where($attribute, '=', $value)
            ->get($columns);
    }

    /**
     * { @inheritdoc }
     */
    public function findAll(array $columns = ['*'], array $with = []): Collection
    {
        return $this->model
            ->with($with)
            ->get($columns);
    }

    /**
     * { @inheritdoc }
     */
    public function findWhere(array $where, array $columns = ['*'], array $with = []): Collection
    {
        $model = $this->model instanceof Model ? $this->model->query() : $this->model;

        foreach ($where as $attribute => $value) {
            if (is_array($value)) {
                list($attribute, $condition, $value) = $value;
                $model->where($attribute, $condition, $value);
            } else {
                $model->where($attribute, '=', $value);
            }
        }
        return $model
            ->with($with)
            ->get($columns);
    }

    /**
     * { @inheritdoc }
     */
    public function findWhereBetween(string $attribute, array $values, array $columns = ['*'], array $with = []): Collection
    {
        return $this->model
            ->with($with)
            ->whereBetween($attribute, $values)
            ->get($columns);
    }

    /**
     * { @inheritdoc }
     */
    public function findWhereIn(string $attribute, array $values, array $columns = ['*'], array $with = []): Collection
    {
        return $this->model
            ->with($with)
            ->whereIn($attribute, $values)
            ->get($columns);
    }

    /**
     * { @inheritdoc }
     */
    public function findWhereNotIn(string $attribute, array $values, array $columns = ['*'], array $with = []): Collection
    {
        return $this->model
            ->with($with)
            ->whereNotIn($attribute, $values)
            ->get($columns);
    }

    /**
     * { @inheritdoc }
     */
    public function create(array $attributes): ?Model
    {
        return $this->model->create($attributes);
    }

    /**
     * { @inheritdoc }
     */
    public function update(array $attributes, int $resourceId): bool
    {
        if (is_null($this->model = $this->findById($resourceId))) {
            return false;
        }

        return $this->model
            ->fill($attributes)
            ->save();
    }

    /**
     * { @inheritdoc }
     */
    public function delete(mixed $resourceId): int
    {
        return $this->model->destroy($resourceId);
    }

    /**
     * { @inheritdoc }
     */
    public function with(mixed $relationships): self
    {
        $this->model = $this->model->with($relationships);
        return $this;
    }

    /**
     * { @inheritdoc }
     */
    public function orderBy(string $column, string $direction = ReservedWords::QUERY_ASC_DIRECTION): self
    {
        $this->model = $this->model->orderBy($column, $direction);
        return $this;
    }

    /**
     * { @inheritdoc }
     */
    public function paginate(int $perPage = null, array $columns = ['*'], string $pageName = ReservedWords::PAGE_NAME, ?int $page = null): LengthAwarePaginator
    {
        return $this->model->paginate($perPage, $columns, $pageName, $page);
    }
}
