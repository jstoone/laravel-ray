<?php

namespace Spatie\LaravelRay\Payloads;

use Illuminate\Database\Eloquent\Model;
use Spatie\Ray\ArgumentConverter;
use Spatie\Ray\Payloads\Payload;

class ModelPayload extends Payload
{
    protected ?Model $model;

    public function __construct(?Model $model)
    {
        $this->model = $model;
    }

    public function getType(): string
    {
        return 'eloquent_model';
    }

    public function getContent(): array
    {
        if (! $this->model) {
            return [];
        }

        $content = [
            'class_name' => $this->model ?? 'Model not found',
            'attributes' => ArgumentConverter::convertToPrimitive($this->model->attributesToArray()),
        ];

        $relations = $this->model->relationsToArray();

        if (count($relations)) {
            $content['relations'] = ArgumentConverter::convertToPrimitive($relations);
        }

        return $content;
    }
}
