<?php

namespace App\Http\Resources\Common;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use InvalidArgumentException;

class SuccessResource extends JsonResource
{
    /**
    * The "data" wrapper that should be applied.
    *
    * @var string|null
    */
    public static $wrap = null;

    /**
    * Create a new resource instance.
    *
    * @param  string  $resource レスポンスに含めるメッセージ
    * @return void
    */
    public function __construct($resource)
    {
        if (!is_string($resource)) {
            throw new InvalidArgumentException('The resource must be a string.');
        }
        parent::__construct($resource);
    }

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'code' => 200,
            'message' => $this->resource,
        ];
    }
}