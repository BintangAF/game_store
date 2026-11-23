<?php

namespace App\Console\Commands;

use App\Models\Category;
use App\Models\Game;
use App\Models\GameImage;
use App\Models\OperatingSystem;
use App\Models\Tag;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * Mengisi tabel games (+ kategori, tag, OS, gambar) dari CSV.
 * Format kolom: docs/template-data-game.csv
 *
 *   php artisan games:import docs/data-game.csv --images=docs/gambar
 */
class ImportGames extends Command
{
    protected $signature = 'games:import {file : Path file CSV} {--images= : Folder berisi file gambar (cover & galeri)}';

    protected $description = 'Impor data game dari CSV ke database';

    public function handle(): int
    {
        $path = $this->argument('file');
        if (! is_file($path)) {
            $this->error("File tidak ditemukan: {$path}");

            return self::FAILURE;
        }

        $imageDir = $this->option('images') ? rtrim($this->option('images'), '/\\') : null;
        $handle = fopen($path, 'r');
        $header = fgetcsv($handle);
        $header[0] = ltrim($header[0], "\xEF\xBB\xBF"); // buang BOM bila CSV dari Excel
        $count = 0;

        while (($row = fgetcsv($handle)) !== false) {
            if (count(array_filter($row, fn ($v) => $v !== null && $v !== '')) === 0) {
                continue; // baris kosong
            }
            $data = array_combine($header, array_pad($row, count($header), null));

            if (blank($data['game_title'] ?? null)) {
                $this->warn('Baris dilewati: game_title kosong.');
                continue;
            }

            $game = Game::updateOrCreate(
                ['game_title' => trim($data['game_title'])],
                [
                    'game_price' => (float) ($data['game_price'] ?? 0),
                    'game_desc' => $data['game_desc'] ?? '',
                    'release_date' => $data['release_date'] ?: now()->toDateString(),
                    'developer_name' => $data['developer_name'] ?: null,
                    'publisher_name' => $data['publisher_name'] ?: null,
                    'system_requirements' => $data['system_requirements'] ?: null,
                    'is_active' => true,
                ]
            );

            $game->categories()->sync($this->resolve(Category::class, 'category_name', 'category_id', $data['categories'] ?? '', true));
            $game->tags()->sync($this->resolve(Tag::class, 'tag_name', 'tag_id', $data['tags'] ?? '', true));
            $game->operatingSystems()->sync($this->resolve(OperatingSystem::class, 'os_name', 'os_id', $data['operating_systems'] ?? '', false));

            if ($imageDir) {
                if ($cover = $this->storeImage($imageDir, trim($data['cover_image'] ?? ''), 'covers')) {
                    $game->update(['cover_image_path' => $cover]);
                }

                $game->images()->delete();
                foreach ($this->split($data['gallery_images'] ?? '') as $i => $file) {
                    if ($stored = $this->storeImage($imageDir, $file, 'gallery')) {
                        GameImage::create(['game_id' => $game->game_id, 'image_path' => $stored, 'sort_order' => $i]);
                    }
                }
            }

            $count++;
            $this->line("OK  {$game->game_title}");
        }

        fclose($handle);
        $this->info("Selesai: {$count} game diimpor.");

        return self::SUCCESS;
    }

    private function split(?string $value): array
    {
        return array_values(array_filter(array_map('trim', explode(';', (string) $value))));
    }

    /** Cari id berdasarkan nama (tanpa peduli huruf besar/kecil); buat baru bila $create. */
    private function resolve(string $model, string $nameCol, string $keyCol, ?string $names, bool $create): array
    {
        $ids = [];
        foreach ($this->split($names) as $name) {
            $record = $model::whereRaw("lower({$nameCol}) = ?", [Str::lower($name)])->first();

            if (! $record && $create) {
                $record = $model::create([$nameCol => $name, 'slug' => Str::slug($name)]);
            }

            if ($record) {
                $ids[] = $record->{$keyCol};
            } else {
                $this->warn("  {$nameCol} \"{$name}\" tidak ada di database, dilewati.");
            }
        }

        return $ids;
    }

    private function storeImage(string $dir, string $file, string $folder): ?string
    {
        if ($file === '') {
            return null;
        }

        $source = "{$dir}/{$file}";
        if (! is_file($source)) {
            $this->warn("  Gambar tidak ditemukan: {$source}");

            return null;
        }

        // Disimpan di disk "public" (storage/app/public). Perlu: php artisan storage:link
        return Storage::disk('public')->putFileAs($folder, new \Illuminate\Http\File($source), $file);
    }
}
