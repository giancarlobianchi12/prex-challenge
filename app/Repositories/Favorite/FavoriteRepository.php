<?php

namespace App\Repositories\Favorite;

use App\Models\Favorite;
use App\Repositories\BaseRepository;

class FavoriteRepository extends BaseRepository implements FavoriteRepositoryInterface
{
    /**
     * User constructor.
     *
     * @param  User  $user
     */
    public function __construct(Favorite $favorite)
    {
        parent::__construct($favorite);
    }
}
