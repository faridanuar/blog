<?php

namespace App\Utilities\posts;

use App\Models\Post;

class OptionList extends \App\Utilities\OptionList
{
    public static function list()
    {
        $list = parent::list();

        $list['post-status'] = [
            Post::STATUS_PENDING => 'Draft',
            Post::STATUS_PUBLISHED => 'Published',
        ];

        return $list;
    }
}
