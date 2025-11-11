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
     */
    public static function encode(array|object $data, string $title = 'data'): string
    {
        $data = json_decode(json_encode($data), true);

        if (empty($data)) {
            return "{$title}[0]{}:";
        }

        $fields = array_keys($data[0]);
        $count = count($data);

        $output = "{$title}[{$count}]{" . implode(',', $fields) . "}:\n";

        foreach ($data as $row) {
            $values = array_map(function ($value) {
                return str_replace(["\n", "\r"], '', (string) $value); // remove quebras de linha
            }, array_values($row));
            $output .= "    " . implode(',', $values) . "\n";
        }

        return rtrim($output);
    }

    /**
     * Decodes a toon into an array or object.
     *
     * @param string $toon
     * @param bool   $assoc true = array, false = stdClass
     * @return array<mixed,mixed>
     */
    public static function decode(string $toon, bool $assoc = true): array
    {
        $lines = array_values(array_filter(array_map('trim', explode("\n", $toon))));

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
            $values     = array_map('trim', explode(',', $line));
            $item       = array_combine($fields, $values);
            $result[]   = $assoc ? (array) $item : (object) $item;
        }

        return $result;
    }
}
