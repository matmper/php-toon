<?php

declare(strict_types=1);

namespace Matmper;

class PhpToon
{
    public function __construct()
    {
        //
    }

    /**
     * Encode an array or object into a Toon.
     *
     * @param array<mixed,mixed>|object $data
     * @param string $title
     * @return string
     *
     * @throws \Exception
     * @throws \Matmper\Exceptions\InvalidArgumentException
     */
    public static function encode(array|object $data, string $title = 'data'): string
    {
        if (empty($data)) {
            return "{$title}[0]{}:";
        }

        $data = is_array($data) ? $data : (array) $data;

        try {
            $fields = array_keys((array) $data[0]);
            $count = count($data);

            $output = "{$title}[{$count}]{" . implode(',', $fields) . "}:\n";

            foreach ($data as $row) {
                if (is_object($row)) {
                    $row = get_object_vars($row);
                }

                if (!is_array($row)) {
                    throw new \InvalidArgumentException('Each row must be an array or object.');
                }

                $values = array_map(function ($value) {
                    return str_replace(["\n", "\r"], '', (string) $value); // remove quebras de linha
                }, array_values($row));

                $output .= "    " . implode(',', $values) . "\n";
            }
        } catch (\Exception $e) {
            throw $e;
        }

        return rtrim($output);
    }

    /**
     * Decodes a toon into an array or object.
     *
     * @param string $toon
     * @param bool   $assoc true = array, false = stdClass
     * @return array<mixed,mixed>
     *
     * @throws \Exception
     * @throws \Matmper\Exceptions\InvalidArgumentException
     * @throws \Matmper\Exceptions\ValueException
     */
    public static function decode(string $toon, bool $assoc = true): array
    {
        try {
            $lines = array_values(array_filter(array_map('trim', explode("\n", $toon))));
        } catch (\Throwable $th) {
            throw new \Matmper\Exceptions\InvalidArgumentException('Data is not a valid toon format.', 422, $th);
        }

        if (empty($lines)) {
            return [];
        }

        preg_match('/\w+\[(\d+)\]\{([^}]+)\}:/', $lines[0], $matches);

        if (empty($matches)) {
            return [];
        }

        $fields = array_map('trim', explode(',', $matches[2]));
        $rows = array_slice($lines, 1);

        $result = [];

        foreach ($rows as $line) {
            $values = array_map('trim', explode(',', $line));

            try {
                $item = array_combine($fields, $values);
            } catch (\ValueError $e) {
                $message = sprintf(
                    'Value count mismatch on line "%s" (expected %d fields, got %d).',
                    $line,
                    count($fields),
                    count($values)
                );
                throw new \Matmper\Exceptions\ValueException($message, 422, $e);
            } catch (\Exception $e) {
                throw $e;
            }

            $result[] = $assoc ? (array) $item : (object) $item;
        }

        return $result;
    }
}
