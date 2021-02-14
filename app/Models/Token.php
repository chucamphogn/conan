<?php

namespace App\Models;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Database\Eloquent\JsonEncodingException;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;
use JetBrains\PhpStorm\ArrayShape;
use JsonSerializable;

/**
 * Lớp này không dùng để thao tác với cơ sở dữ liệu, chỉ đơn thuần để lưu thông tin token được lấy từ Models\Account.
 *
 * @see Account::token()
 */
class Token implements Jsonable, JsonSerializable, Arrayable
{
    /**
     * Lưu access token.
     *
     * @var string
     */
    private string $accessToken;

    /**
     * Lưu refresh token.
     *
     * @var string
     */
    private string $refreshToken;

    /**
     * Lưu thời gian hết hạn của access token.
     *
     * @var int
     */
    private int $expiresIn;

    /**
     * Lưu thời gian tạo access token.
     *
     * @var Carbon
     */
    private Carbon $createdAt;

    /**
     * Trả về access token.
     *
     * @return string
     */
    public function getAccessToken(): string
    {
        return $this->accessToken;
    }

    /**
     * Trả về refresh token.
     *
     * @return string
     */
    public function getRefreshToken(): string
    {
        return $this->refreshToken;
    }

    /**
     * Trả về thời gian hết hạn của access token.
     *
     * @return int
     */
    public function getExpiresIn(): int
    {
        return $this->expiresIn;
    }

    /**
     * Trả về ngày tạo token.
     *
     * @return Carbon
     */
    public function getCreatedAt(): Carbon
    {
        return $this->createdAt;
    }

    /**
     * @param string $accessToken
     *
     * @return $this
     */
    public function setAccessToken(string $accessToken): self
    {
        $this->accessToken = $accessToken;

        return $this;
    }

    /**
     * @param string $refreshToken
     *
     * @return $this
     */
    public function setRefreshToken(string $refreshToken): self
    {
        $this->refreshToken = $refreshToken;

        return $this;
    }

    /**
     * @param int $expiresIn
     *
     * @return $this
     */
    public function setExpiresIn(int $expiresIn): self
    {
        $this->expiresIn = $expiresIn;

        return $this;
    }

    /**
     * @param Carbon $createdAt
     *
     * @return $this
     */
    public function setCreatedAt(Carbon $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * @return array
     */
    #[ArrayShape([
        'access_token' => 'string',
        'refresh_token' => 'string',
        'expires_in' => 'int',
        'created_at' => '\Illuminate\Support\Carbon',
    ])]
    public function jsonSerialize(): array
    {
        return $this->toArray();
    }

    /**
     * Chuyển đối tượng sang json.
     *
     * @param int $options
     *
     * @return string
     */
    public function toJson($options = 0): string
    {
        $json = json_encode($this->jsonSerialize(), $options);

        if (JSON_ERROR_NONE !== json_last_error()) {
            throw JsonEncodingException::forModel($this, json_last_error_msg());
        }

        return $json;
    }

    /**
     * Chuyển đối tượng sang json với cấu trúc của Google Drive API.
     *
     * @param int $options
     *
     * @return string
     */
    public function toGoogleJsonStructure($options = 0): string
    {
        $jsonSerialize = collect($this->jsonSerialize())->mapWithKeys(function ($value, string $key) {
            return ('created_at' === $key)
                ? ['created' => Carbon::parse($value)->timestamp]
                : [$key => $value];
        });

        return json_encode($jsonSerialize, $options);
    }

    /**
     * Cập nhật thông tin token.
     *
     * @param array $attributes
     * @param array $options
     *
     * @return bool
     */
    public function update(array $attributes = [], array $options = []): bool
    {
        $attributes = Arr::only($attributes, ['access_token', 'refresh_token', 'expires_in']);

        return Account::whereAccessToken($this->getAccessToken())->update($attributes, $options);
    }

    /**
     * @return array
     */
    #[ArrayShape([
        'access_token' => 'string',
        'refresh_token' => 'string',
        'expires_in' => 'int',
        'created_at' => '\Illuminate\Support\Carbon',
    ])]
    public function toArray(): array
    {
        return [
            'access_token' => $this->getAccessToken(),
            'refresh_token' => $this->getRefreshToken(),
            'expires_in' => $this->getExpiresIn(),
            'created_at' => $this->getCreatedAt(),
        ];
    }
}
