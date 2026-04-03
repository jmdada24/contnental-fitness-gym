<?php 


namespace App\Application\Membership\UseCases;

use App\Application\Membership\DTO\CreateMemberDto;
use App\Core\Membership\Repositories\MemberRepositoryInterface;
use App\Core\User\Enums\UserRole;
use App\Core\User\Enums\UserStatus;
use App\Core\User\Repositories\UserRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CreateMemberUseCase{
    public function __construct(
        private readonly MemberRepositoryInterface $memberRepository,
        private readonly UserRepositoryInterface $userRepository,

    )
    {
    }

    public function execute(CreateMemberDto $dto){
        do{
            $memberCode = 'MEM-'.strtoupper(Str::random(8));

        }while($this->memberRepository->existByMemberCode($memberCode));

        return DB::transaction(function () use ($dto, $memberCode): object { 
            $userId = $dto->userId;

        if($dto->createPortalAccount){
            $email = $dto->email;
                $temporaryPassword = $dto->temporaryPassword;

                if(! $email || ! $temporaryPassword){
                    throw new \InvalidArgumentException('Email and temporary password are required for portal account creation.');

                }
                $user = $this->userRepository->create([
                    'name' => trim($dto->firstName . ' ' . $dto->lastName),
                    'email' => $email,
                    'password' => $temporaryPassword,
                    'status' => UserStatus::Active->value,
                    'must_change_password' => true,
                    'created_by_admin' => true,

                ]);

                if(!method_exists($user , 'assignRole')){
                    throw new \RuntimeException('User model does not support role assignment');

                }

                $user->assignRole(UserRole::Member->value);
                $userId = $user->id;


        }
            
            return $this->memberRepository->create([
                'user_id',
                'first_name' => $dto->firstName,
                'last_name' => $dto->lastName,
                'email' => $dto->email,
                'phone' => $dto->phone,
                'birthdate' => $dto->birthDate,
                'gender' => $dto->gender,
                'address' => $dto->address,
                'emergency_contact_name' => $dto->emergencyContactName,
                'emergency_contact_phone' => $dto->emergencyContactPhone,
                'notes' => $dto->notes,
                'profile_photo_data' => $dto->profilePhotoData,
                'member_code' => $memberCode,
                'is_archived' => false,

            ]);

        });
    }

}