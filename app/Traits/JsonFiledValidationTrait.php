<?php

namespace App\Traits;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Symfony\Component\HttpFoundation\Response;

trait JsonFiledValidationTrait
{
    /**
     * Handle a failed validation attempt.
     *
     * Throws an HTTP response exception with validation errors in JSON format
     * when form request validation fails.
     *
     * @param Validator $validator The validator instance containing validation errors
     *
     * @return void
     *
     * @throws HttpResponseException
     */
    protected function failedValidation(Validator $validator): void
    {
        throw new HttpResponseException(
            response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
            ], Response::HTTP_UNPROCESSABLE_ENTITY)
        );
    }
}
