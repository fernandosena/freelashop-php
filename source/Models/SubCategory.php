<?php

namespace Source\Models;

use Source\Core\Model;
use Source\Models\Project\AppProject;

/**
 * Class SubCategory
 * @package Source\Models
 */
class SubCategory extends Model
{
    /**
     * Category constructor.
     */
    public function __construct()
    {
        parent::__construct("subcategories", ["id"], ["title", "description"]);
    }

    /**
     * @param string $uri
     * @param string $columns
     * @return null|SubCategory
     */
    public function findByUri(string $uri, string $columns = "*"): ?SubCategory
    {
        $find = $this->find("uri = :uri", "uri={$uri}", $columns);
        return $find->fetch();
    }

    /**
     * @return Post
     */
    public function posts(): Post
    {
        return (new Post())->find("subcategory = :id", "id={$this->id}");
    }

    /**
     * @return AppProject
     */
    public function project(): AppProject
    {
        return (new AppProject())->find("subcategory = :id", "id={$this->id}");
    }

    /**
     * @return bool
     */
    public function save(): bool
    {
        $checkUri = (new SubCategory())->find("uri = :uri AND id != :id", "uri={$this->uri}&id={$this->id}");

        if ($checkUri->count()) {
            $this->uri = "{$this->uri}-{$this->lastId()}";
        }

        return parent::save();
    }
}