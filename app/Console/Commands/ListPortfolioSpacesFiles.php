<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class ListPortfolioSpacesFiles extends Command
{
    protected $signature = 'portfolio:spaces-files
        {--prefix= : Limit the listing to a bucket folder}
        {--limit=100 : Maximum number of image objects to list (1-500)}
        {--json : Print object keys and sizes as JSON}';

    protected $description = 'List existing Spaces images for the portfolio seed manifest without modifying the bucket';

    public function handle(): int
    {
        $limit = filter_var($this->option('limit'), FILTER_VALIDATE_INT, [
            'options' => ['min_range' => 1, 'max_range' => 500],
        ]);

        if ($limit === false) {
            $this->error('The limit must be an integer from 1 to 500.');

            return self::FAILURE;
        }

        $images = [];

        foreach (Storage::disk('do')->listContents($this->option('prefix') ?? '', true) as $file) {
            if (! $file->isFile() || ! in_array(strtolower(pathinfo($file->path(), PATHINFO_EXTENSION)), ['jpg', 'jpeg', 'png', 'gif', 'webp', 'avif'])) {
                continue;
            }

            $images[] = ['key' => $file->path(), 'bytes' => $file->fileSize()];

            if (count($images) >= $limit) {
                break;
            }
        }

        if ($this->option('json')) {
            $this->line(json_encode($images, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_THROW_ON_ERROR));
        } else {
            $this->table(['Object key', 'Bytes'], $images);
        }

        return self::SUCCESS;
    }
}
