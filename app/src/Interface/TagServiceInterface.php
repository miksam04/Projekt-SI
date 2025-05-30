<?php

/**
 * Tag interface.
 */

namespace App\Interface;

use App\Entity\Tag;

/**
 * Interface TagServiceInterface.
 */
interface TagServiceInterface
{
    /**
     * Find by title.
     *
     * @param string $title the tag title
     *
     * @return Tag|null the tag object or null if not found
     */
    public function findOneByTitle(string $title): ?Tag;

    /**
     * Get tag by ID.
     *
     * @param int $id the tag ID
     *
     * @return Tag|null the tag object or null if not found
     */
    public function getTagById(int $id): ?Tag;
}
