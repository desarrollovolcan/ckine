<?php
namespace App\Core;

class Validator
{
    private array $errors = [];

    public function required(string $field, ?string $value, string $message): void
    {
        if ($value === null || trim($value) === '') {
            $this->errors[$field][] = $message;
        }
    }

    public function email(string $field, ?string $value, string $message): void
    {
        if ($value && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
            $this->errors[$field][] = $message;
        }
    }

    public function rut(string $field, ?string $value, string $message): void
    {
        if (!$value) {
            return;
        }
        $clean = preg_replace('/[^0-9kK]/', '', $value);
        if (strlen($clean) < 2) {
            $this->errors[$field][] = $message;
            return;
        }
        $body = substr($clean, 0, -1);
        $dv = strtoupper(substr($clean, -1));
        $sum = 0;
        $multiplier = 2;
        for ($i = strlen($body) - 1; $i >= 0; $i--) {
            $sum += $multiplier * (int) $body[$i];
            $multiplier = $multiplier === 7 ? 2 : $multiplier + 1;
        }
        $rest = $sum % 11;
        $expected = 11 - $rest;
        if ($expected === 11) {
            $expectedDv = '0';
        } elseif ($expected === 10) {
            $expectedDv = 'K';
        } else {
            $expectedDv = (string) $expected;
        }
        if ($expectedDv !== $dv) {
            $this->errors[$field][] = $message;
        }
    }

    public function errors(): array
    {
        return $this->errors;
    }

    public function fails(): bool
    {
        return !empty($this->errors);
    }
}
