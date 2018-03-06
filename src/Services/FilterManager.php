<?php

namespace Geekco\CmsBundle\Services;

/**
 * FilterManager
 */
class FilterManager
{
    public function validate(string $namespace, string $orderby = null, string $direction = null)
    {

        $array = [];

        $array['success'] = true;

        if ($direction === null || $orderby === null)
        {
            $array['success'] = false;
        }

        if (!property_exists($namespace, $orderby))
        {
            $array['success'] = false;
        }

        $direction = strtoupper($direction);

        if ($direction !== 'ASC' && $direction !== 'DESC')
        {
            $array['success'] = false;
        }

        if ($array['success'] === false)
        {
            $array['direction'] = null;
            $array['reverse_direction'] = null;
            $array['orderby'] = null;
            return $array;
        }

        $direction === 'ASC' ? $array['reverse_direction'] = 'desc' : $array['reverse_direction'] = 'asc';

        $array['direction'] = $direction;

        $array['orderby'] = $orderby;

        return $array;

    }

}
