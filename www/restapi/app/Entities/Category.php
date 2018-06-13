<?php
namespace App\Entities;

use Webpatser\Uuid\Uuid;

class Category
{
    /**
     * @var string
     */
    private $uuid;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $parentCategory;

    /**
     * @var bool
     */
    private $isVisible;

    /**
     * @var string
     */
    private $slug;

    public function __construct(string $name, bool $isVisible, string $parentCategory = null, string $uuid = null, string $slug = null)
    {
        $this->uuid = $uuid;
        $this->name = $name;
        $this->parentCategory = $parentCategory;
        $this->isVisible = $isVisible;
        $this->slug = !empty($slug) ? $slug : str_slug($name);
    }

    /**
     * @return string
     */
    public function getUuid()
    {
        return $this->uuid;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getParentCategory()
    {
        return $this->parentCategory;
    }

    /**
     * @return bool
     */
    public function isVisible()
    {
        return $this->isVisible;
    }

    /**
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }
}
