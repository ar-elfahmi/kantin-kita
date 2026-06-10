<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class CheckBrokenImages extends Command
{
    protected $signature = 'images:check-broken
                            {--dry-run : Only report, dont update}
                            {--timeout=5 : HTTP timeout in seconds}';

    protected $description = 'Check and nullify broken (404) image URLs across all tables';

    private array $tables = [
        'menus'     => ['col' => 'path_gambar', 'label' => 'nama_menu'],
        'vendors'   => ['col' => 'path_logo', 'label' => 'nama_vendor'],
        'customers' => ['col' => 'foto_path', 'label' => 'nama'],
        'artikels'  => ['col' => 'gambar_sampul', 'label' => 'judul'],
    ];

    public function handle(): int
    {
        $allRows = $this->gatherRows();
        $total = count($allRows);

        if ($total === 0) {
            $this->info('No image URLs found in database.');
            return Command::SUCCESS;
        }

        $this->info("Found {$total} image URL(s) to check.");
        $broken = [];
        $errors = [];
        $bar = $this->output->createProgressBar($total);
        $bar->start();

        foreach ($allRows as $row) {
            $url = $row->url;
            $table = $row->table;
            $col = $row->column;
            $label = $row->label;
            $id = $row->id;

            $isBroken = false;
            $errorMsg = null;

            if (str_starts_with($url, '/') || !preg_match('#^https?://#', $url)) {
                $isBroken = false;
            } else {
                try {
                    $response = Http::timeout((int) $this->option('timeout'))
                        ->withOptions(['verify' => false])
                        ->head($url);

                    if ($response->status() >= 400) {
                        $isBroken = true;
                        $errorMsg = "HTTP {$response->status()}";
                    }
                } catch (\Exception $e) {
                    $isBroken = true;
                    $errorMsg = $e->getMessage();
                }
            }

            if ($isBroken) {
                $broken[] = compact('table', 'id', 'col', 'label', 'url', 'errorMsg');
                if (!$this->option('dry-run')) {
                    DB::table($table)->where('id', $id)->update([$col => null]);
                }
            } elseif ($errorMsg) {
                $errors[] = compact('table', 'id', 'label', 'url', 'errorMsg');
            }

            $bar->advance();
        }

        $bar->finish();
        $this->newLine(2);

        $this->line("--- Report ---");
        $this->line("Total checked: {$total}");

        if (count($broken) > 0) {
            $this->warn("Broken (set to null): " . count($broken));
            $this->table(
                ['Table', 'ID', 'Name', 'URL', 'Error'],
                array_map(fn($b) => [$b['table'], $b['id'], $b['label'], $b['url'], $b['errorMsg']], $broken)
            );
        } else {
            $this->info("Broken: 0 — all URLs respond OK.");
        }

        if ($this->option('dry-run')) {
            $this->line('(dry-run mode — no changes written)');
        }

        return Command::SUCCESS;
    }

    private function gatherRows(): array
    {
        $rows = [];
        foreach ($this->tables as $table => $cfg) {
            $records = DB::table($table)
                ->whereNotNull($cfg['col'])
                ->where($cfg['col'], '!=', '')
                ->get(['id', $cfg['col'], $cfg['label']]);

            foreach ($records as $r) {
                $rows[] = (object) [
                    'table'  => $table,
                    'id'     => $r->id,
                    'url'    => $r->{$cfg['col']},
                    'label'  => $r->{$cfg['label']},
                    'column' => $cfg['col'],
                ];
            }
        }
        return $rows;
    }
}
