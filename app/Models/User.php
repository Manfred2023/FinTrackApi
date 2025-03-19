<?php
/*
 *  BuildTrackApi
 *
 *  Created by Manfred MOUKATE on 1/7/25, 10:15 AM,
 *  Email moukatemanfred@gmail.com
 *  Copyright (c) 2025. All rights reserved.
 *  Last modified 1/7/25, 10:15 AM
 */


namespace App\Models;
class User
{
    private ?int $id;
    private ?int $token;
    private string $nickname;
    private string $mobile;
    private string $email;
    private int $pin;
    private ?bool $admin;
    private ?bool $blocked;

    /**
     * @param int|null $id
     * @param int|null $token
     * @param string $nickname
     * @param string $mobile
     * @param string $email
     * @param int $pin
     * @param bool|null $admin
     * @param bool|null $blocked
     */
    public function __construct(?int $id, ?int $token, string $nickname, string $mobile, string $email, int $pin, ?bool $admin, ?bool $blocked)
    {
        $this->id = $id;
        $this->token = $token;
        $this->nickname = $nickname;
        $this->mobile = $mobile;
        $this->email = $email;
        $this->pin = $pin;
        $this->admin = $admin;
        $this->blocked = $blocked;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function getToken(): ?int
    {
        return $this->token;
    }

    public function setToken(?int $token): void
    {
        $this->token = $token;
    }

    public function getNickname(): string
    {
        return $this->nickname;
    }

    public function setNickname(string $nickname): void
    {
        $this->nickname = $nickname;
    }

    public function getMobile(): string
    {
        return $this->mobile;
    }

    public function setMobile(string $mobile): void
    {
        $this->mobile = $mobile;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function getPin(): int
    {
        return $this->pin;
    }

    public function setPin(int $pin): void
    {
        $this->pin = $pin;
    }

    public function getAdmin(): ?bool
    {
        return $this->admin;
    }

    public function setAdmin(?bool $admin): void
    {
        $this->admin = $admin;
    }

    public function getBlocked(): ?bool
    {
        return $this->blocked;
    }

    public function setBlocked(?bool $blocked): void
    {
        $this->blocked = $blocked;
    }
    public function toArray(): array
    {
        return [
            'token' => $this->token ?? null,
            'nickname' => $this->nickname,
            'mobile' => $this->mobile ?? null,
            'email' => $this->email,
            'pin' => $this->pin,
            'admin' => $this->admin,
            'blocked' => $this->blocked,
        ];
    }


}
