<?php

namespace OneGiba\DataLayer\Contracts;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use OneGiba\Datalayer\Support\ReservedWords;

interface RepositoryInterface
{
    /**
     * Find an entity by its primary key.
     *
     * @param int   $resourceId
     * @param array $columns
     * @param array $with
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function findById(int $resourceId, array $columns = ['*'], array $with = []): ?Model;

    /**
     * Find the first entity by the given attribute.
     *
     * @param string $attribute
     * @param string $value
     * @param array  $columns
     * @param array  $with
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function findFirst(string $attribute, string $value, array $columns = ['*'], array $with = []): ?Model;

    /**
     * Find the entity by the given attribute.
     *
     * @param string $attribute
     * @param string $value
     * @param array  $columns
     * @param array  $with
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function findBy(string $attribute, string $value, array $columns = ['*'], array $with = []): Collection;

    /**
     * Find all entities.
     *
     * @param array $columns
     * @param array $with
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function findAll(array $columns = ['*'], array $with = []): Collection;

    /**
     * Find all entities matching where conditions.
     *
     * @param array $where
     * @param array $columns
     * @param array $with
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function findWhere(array $where, array $columns = ['*'], array $with = []): Collection;

    /**
     * Find all entities matching whereBetween conditions.
     *
     * @param  string  $attribute
     * @param  array  $values
     * @param  array  $columns
     * @param  array  $with
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function findWhereBetween(string $attribute, array $values, array $columns = ['*'], array $with = []): Collection;

    /**
     * Find all entities matching whereIn conditions.
     *
     * @param string $attribute
     * @param array  $values
     * @param array  $columns
     * @param array  $with
     * @return \Illuminate\Database\Eloquent\Collection|null
     */
    public function findWhereIn(string $attribute, array $values, array $columns = ['*'], array $with = []): Collection;

    /**
     * Find all entities matching whereNotIn conditions.
     *
     * @param string $attribute
     * @param array  $values
     * @param array  $columns
     * @param array  $with
     * @return \Illuminate\Database\Eloquent\Collection|null
     */
    public function findWhereNotIn(string $attribute, array $values, array $columns = ['*'], array $with = []): Collection;

    /**
     * Create a new entity with the given attributes.
     *
     * @param array $attributes
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function create(array $attributes): ?Model;

    /**
     * Update an entity with the given attributes.
     *
     * @param array $attributes
     * @param int $resourceId
     * @return bool
     */
    public function update(array $attributes, int $resourceId): bool;

    /**
     * Delete an entity with the given ID.
     *
     * @param mixed $resourceId
     * @return int
     */
    public function delete(mixed $resourceId): int;

    /**
     * Set the relationships that should be eager loaded.
     *
     * @param mixed $relationships
     * @return $this
     */
    public function with(mixed $relationships): self;

    /**
     * Add an "order by" clause to the repository instance.
     *
     * @param string $column
     * @param string $direction
     * @return $this
     */
    public function orderBy(string $column, string $direction = ReservedWords::QUERY_ASC_DIRECTION): self;

    /**
     * Paginate the given query for retrieving entities.
     *
     * @param int|null $perPage
     * @param array    $columns
     * @param string   $pageName
     * @param int|null $page
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function paginate(int $perPage = null, array $columns = ['*'], string $pageName = ReservedWords::PAGE_NAME, ?int $page = null): LengthAwarePaginator;
}