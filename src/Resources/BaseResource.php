<?php

namespace Devslane\Generator\Resources;

use Devslane\Generator\Utils\Helpers;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\Resource;
use Illuminate\Support\Collection;

/**
 * Class BaseResource
 * @package Devslane\Generator\Resources
 *
 * @property  mixed $resource
 * @property Collection $relationships
 * @property Collection $attributes
 * @property Collection $includes
 * @property array $allowedIncludes
 * @property array $allowedAttrs
 */
class BaseResource extends Resource
{
    const INCLUDES_KEY = 'includes';

    private $relationships;
    private $attributes;

    protected $allowedIncludes = [];
    protected $allowedAttrs = [];
    protected $includes = [];


    /**
     * @param $attribute
     * @return bool
     */
    protected function hasAttribute($attribute)
    {
        return $this->attributes && $this->attributes->contains($attribute);
    }

    /**
     * @param Request $request
     * @return array
     */
    public function toArray($request)
    {
        $this->setIncludes(Helpers::parseCommaSaperatedStringToArray($request->query(self::INCLUDES_KEY)));
        $this->parseIncludes();
        $this->loadRelationships();
        return parent::toArray($request);
    }

    /**
     * @param Collection $includes
     */
    protected function setIncludes(Collection $includes)
    {
        $this->includes = $includes;
    }


    private function parseIncludes()
    {
        $allowedIncludes = collect($this->allowedIncludes);
        $this->relationships = $this->includes->filter(function ($include) use ($allowedIncludes) {
            return $allowedIncludes->has($include) && $allowedIncludes[$include];
        });

        $allowedAttrs = collect($this->allowedAttrs);
        $this->attributes = $this->includes->filter(function ($attr) use ($allowedAttrs) {
            return $allowedAttrs->has($attr) && $allowedAttrs[$attr];
        });
    }

    protected function loadRelationships()
    {
        if (!$this->relationships || count($this->relationships) === 0) {
            return;
        }
        $this->resource->load(...$this->relationships);
    }
}
