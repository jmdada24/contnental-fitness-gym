<?php

namespace App\Application\Membership\DTO;

class CreateMemberDto{

    public function __construct(
        public readonly ?int $userId,
        public readonly string $firstName,
        public readonly string $lastName,
        public readonly ?string $email,
        public readonly ?string $phone,
        public readonly ?string $birthDate,
        public readonly ?string $gender,
        public readonly ?string $address,
        public readonly ?string $emergencyContactName,
        public readonly ?string $emergencyContactPhone,
        public readonly ?string $notes,
        public readonly ?string $profilePhotoData,
        public readonly bool $createPortalAccount,
        public readonly ?string $temporaryPassword,

    )
    {
    }


    public function fromArray(array $payload): self{

        return new self(
            userId: isset($payload['user_id']) ? (int) $payload('user_id') : null,
            firstName: (string) ($payload['first_name'] ?? ''),
            lastName: (string) ($payload['last_name'] ?? ''),
            email: isset($payload['email']) ? (string) $payload['email'] : null,
            phone: isset($payload['phone']) ? (string) $payload['phone'] : null,
            birthDate: isset($payload['birth_date']) ? (string) $payload['birth_date'] : null,
            gender: isset($payload['gender']) ? (string) $payload['gender'] : null,
            address: isset($payload['address']) ? (string) $payload['address'] : null,
            emergencyContactName: isset($payload['emergency_contact_name']) ? (string) $payload['emergency_contact_name']: null,
            emergencyContactPhone: isset($payload['emergency_contact_phone']) ? (string) $payload['emergency_contact_phone'] : null,
            notes: isset($payload['notes']) ? (string) $payload['notes'] : null,
            profilePhotoData: isset($payload['profile_photo_data']) ? (string) $payload['profile_photo_data'] : null,
            createPortalAccount: isset($payload['create_portal_account']) ? (bool) $payload['create_portal_account'] : null,
            temporaryPassword: isset($payload['temporary_password']) ? (string) $payload['temporary_password'] : null,


        );

    }
}