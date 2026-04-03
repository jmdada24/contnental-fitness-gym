<?php 

namespace App\Application\Auth\UseCases;

use App\Application\Auth\DTO\LoginRequestDto;
use App\Core\User\Repositories\UserRepositoryInterface;
use App\Interfaces\Http\Resources\Auth\AuthenticatedUserResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;

class PortalLoginUseCase{

    public function __construct(private readonly UserRepositoryInterface $userRepository)
    {
    
    }

    public function execute(LoginRequestDto $dto): JsonResponse{

        $email = strtolower(trim($dto->email));
        $user = $this->userRepository->findByEmail($email);

        if(!$user){
            Hash::check($dto->password, '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/pz4R6Qf8tM9fW');

            return response()->json([
                'message' => 'The provided credentials are invalid'

            ], 422);
        }

        if(! Hash::check($dto->password, $user->password)){
            
            return response()->json([
                'message' => 'The provided credentials are invalid',

            ], 422);
        }
        
        if(! $user->isActive){
            return response()->json([
                'message' => 'Your account is not active',

            ], 403);

        }


        if(! $user->hasAnyRole($dto->allowedRoles)){
            return response()->json([
                'message' => sprintf('This account cannot access the %s portal', $dto->portal),


            ], 403);

        }

        $token = $user->createToken(sprintf('%s-portal', $dto->portal))->plaintTextToken;


        return response()->json([
            'data' => [
                'token_type' => 'Bearer',
                'access_token' => $token,
                'user' => new AuthenticatedUserResource($user),

            ]
        
        ]);

    }
}