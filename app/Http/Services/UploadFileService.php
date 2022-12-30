<?php

namespace App\Http\Services;

use Illuminate\Http\UploadedFile;

class UploadFileService
{
    public function readFile(UploadedFile $file, $symbol): array
    {
        $content = explode($symbol, $file->getContent());
        $response = array();

        foreach ($content as $raw) {
            $numsCount = preg_match_all( "/[0-9]/", $raw);
            $response[] = [
                'text' => $raw,
                'numbers_count' => $numsCount,
            ];
        }

        return $response;
    }
}