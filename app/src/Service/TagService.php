<?php

/**
 * Tag service.
 */

namespace App\Service;

use App\Interface\TagServiceInterface;
use App\Repository\TagRepository;
use App\Entity\Tag;

/**
 * Service responsible for managing tags.
 *
 * This service provides methods to find tags by title and ID.
 */
class TagService implements TagServiceInterface
{
    public $tagRepository;

    /**
     * Constructor.
     *
     * @param TagRepository $tagRepository The tag repository
     */
    public function __construct(TagRepository $tagRepository)
    {
        $this->tagRepository = $tagRepository;
    }

    /**
     * Find a tag by its title.
     *
     * @param string $title The tag title
     *
     * @return Tag|null The tag object or null if not found
     */
    public function findOneByTitle(string $title): ?Tag
    {
        return $this->tagRepository->findOneByTitle($title);
    }

    /**
     * Get tag by ID.
     *
     * @param int $id The tag ID
     *
     * @return Tag|null The tag object or null if not found
     */
    public function getTagById(int $id): ?Tag
    {
        return $this->tagRepository->find($id);
    }
}
