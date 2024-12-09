<?php

namespace App\Core\Shared\Infrastructure\Http\Response;

use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

readonly class ApiSuccessResponse implements Responsable
{
    public function __construct(
        private mixed $data,
        private array $metadata = [],
        private int $code = ResponseAlias::HTTP_OK,
        private array $headers = [],
    ) {}

    public function toResponse($request): JsonResponse|ResponseAlias
    {
        return response()->json([
            'data' => $this->data,
            'metadata' => $this->metadata,
        ], $this->code,
            $this->headers
        );
    }
}
