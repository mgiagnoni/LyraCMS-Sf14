<?php

/*
 * This file is part of Lyra CMS. Lyra CMS is free software; you can redistribute
 * it and/or modify it under the terms of the GNU General Public License as
 * published by the Free Software Foundation; either version 2 of the License,
 * or (at your option) any later version.
 * You should have received a copy of the GNU General Public License along with
 * this program; if not, see <http://www.gnu.org/licenses>.
*/

/**
 * LyraRouting
 *
 * @package lyra
 * @subpackage routing
 * @copyright Copyright (C) 2009-2010 Massimo Giagnoni. All rights reserved.
 * @license GNU General Public License version 2 or later (see LICENSE.txt)
 */
class LyraRouting extends sfPatternRouting
{
  public function generate($name, $params = array(), $absolute = false)
  {
    $path = null;
    if(isset($params['sf_subject']) && $params['sf_subject']->offsetExists('path') && $params['sf_subject']->path)
    {
      $path = $params['sf_subject']->path;
      $ctype = $params['sf_subject']->getContentType()->toArray();
    }
    else if(isset($params['path']))
    {
      $path = $params['path'];
      $ctype = $params['ctype'];
    }

    unset($params['path'], $params['ctype']);

    if($path)
    {
      $route = new sfDoctrineRoute($path . '/' . $ctype['item_slug'] . ($ctype['format'] ? '.' . $ctype['format'] : ''),
        array(
          'module' => $ctype['module'],
          'action' => 'show'
        ),
        array(),
        array(
          'type' => 'object',
          'model' => $ctype['model']
        )
      );
      $url = $route->generate($params, $this->options['context'], $absolute);
      return $this->fixGeneratedUrl($url, $absolute);
    }
    else
    {
      return parent::generate($name, $params, $absolute);
    }
  }

  public function findRoute($url)
  {
    $url = $this->normalizeUrl($url);

    // fetch from cache
    if (null !== $this->cache)
    {
      $cacheKey = 'parse_'.$url.'_'.md5(serialize($this->options['context']));
      if ($this->options['lookup_cache_dedicated_keys'] && $info = $this->cache->get('symfony.routing.data.'.$cacheKey))
      {
        return unserialize($info);
      }
      elseif (isset($this->cacheData[$cacheKey]))
      {
        return $this->cacheData[$cacheKey];
      }
    }

    $info = $this->getRouteThatMatchesUrl($url);

    // store in cache
    // Routes generated on the fly for objects with custom paths cannot be cached.
    if (null !== $this->cache && !isset($info['lyra_custom']))
    {
      if ($this->options['lookup_cache_dedicated_keys'])
      {
        $this->cache->set('symfony.routing.data.'.$cacheKey, serialize($info));
      }
      else
      {
        $this->cacheChanged = true;
        $this->cacheData[$cacheKey] = $info;
      }
    }

    return $info;
  }

  protected function getRouteThatMatchesUrl($url)
  {
    if('/' != $url && $path = Doctrine_Query::create()
        ->from('LyraPath p')
        ->where('p.path = ?')
        ->fetchOne(array(ltrim($url,'/')))
      )
    {
      $ctype = Doctrine::getTable('LyraContentType')
        ->find($path->ctype_id);

      if($ctype)
      {
        $this->ensureDefaultParametersAreSet();
        $name = 'lyra_custom_' . $ctype->type . '_show';
        $route = new sfDoctrineRoute('/' . $path->pattern,
          array(
            'module' => $ctype->getModule(),
            'action' => 'show'
          ),
          array(),
          array(
            'type' => 'object',
            'model' => $ctype->getModel()
          )
        );
        $this->prependRoute($name, $route);
        $parameters = $route->matchesUrl($url, $this->options['context']);
        $info = array('name' => $name, 'pattern' => $route->getPattern(), 'parameters' => $parameters, 'lyra_custom' => true);
        return $info;
      }
    } 
    else
    {
      return parent::getRouteThatMatchesUrl($url);
    }
  }
}