<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public $status;
    public $message;
    public $store;

    public function __construct($status, $message, $resource, $store)
    {
        parent::__construct($resource);
        $this->status = $status;
        $this->message = $message;
        $this->store = $store;
    }
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'success' => $this->status,
            'message' => $this->message,
            'data' => $this->resource,
            'store' => $this->store
        ];
    }
}
