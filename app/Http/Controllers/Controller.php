<?php

namespace App\Http\Controllers;
/**
 * @OA\Info(
 *     title="E-Commerce API Documentation",
 *     version="1.0.0",
 *     description="API documentation for E-Commerce Backend System",
 *     @OA\Contact(
 *         email="support@example.com",
 *         name="Support Team"
 *     ),
 *     @OA\License(
 *         name="MIT",
 *         url="https://opensource.org/licenses/MIT"
 *     )
 * )
 * 
 * @OA\Server(
 *     url=L5_SWAGGER_CONST_HOST,
 *     description="API Server"
 * )
 * 
 * @OA\SecurityScheme(
 *     securityScheme="bearerAuth",
 *     type="http",
 *     scheme="bearer",
 *     bearerFormat="JWT"
 * )
 */
abstract class Controller
{
    //
}
