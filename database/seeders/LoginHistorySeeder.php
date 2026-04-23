<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

class LoginHistorySeeder extends Seeder
{
    /**
     * Total records to seed.
     */
    private const TOTAL_RECORDS = 1_000;

    /**
     * How many rows per DB insert (sweet spot: 500–1000).
     * Higher = fewer round-trips. Lower = less memory per batch.
     */
    private const CHUNK_SIZE = 100;

    /**
     * User agents pool — realistic distribution.
     */
    private const USER_AGENTS = [
        // Desktop — Chrome / Windows
        'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36',
        // Desktop — Firefox / Linux
        'Mozilla/5.0 (X11; Linux x86_64; rv:125.0) Gecko/20100101 Firefox/125.0',
        // Desktop — Safari / macOS
        'Mozilla/5.0 (Macintosh; Intel Mac OS X 14_4) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/17.4 Safari/605.1.15',
        // Desktop — Edge / Windows
        'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36 Edg/124.0.0.0',
        // Mobile — iPhone Safari
        'Mozilla/5.0 (iPhone; CPU iPhone OS 17_4 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/17.4 Mobile/15E148 Safari/604.1',
        // Mobile — Android Chrome
        'Mozilla/5.0 (Linux; Android 14; Pixel 8) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.6367.82 Mobile Safari/537.36',
        // Mobile — Samsung Browser
        'Mozilla/5.0 (Linux; Android 14; SM-S928B) AppleWebKit/537.36 (KHTML, like Gecko) SamsungBrowser/25.0 Chrome/121.0.0.0 Mobile Safari/537.36',
        // Tablet — iPad Safari
        'Mozilla/5.0 (iPad; CPU OS 17_4 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/17.4 Mobile/15E148 Safari/604.1',
        // Tablet — Android Tablet
        'Mozilla/5.0 (Linux; Android 13; Tablet) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36',
    ];

    public function run(): void
    {
        $faker     = Faker::create();
        $userIds   = $this->getUserIds();
        $totalUsers = count($userIds);

        if ($totalUsers === 0) {
            $this->command->error('No users found. Run UserSeeder first.');
            return;
        }

        $this->command->info(sprintf(
            'Seeding %s login history records across %s users in chunks of %s...',
            number_format(self::TOTAL_RECORDS),
            number_format($totalUsers),
            number_format(self::CHUNK_SIZE)
        ));

        $bar        = $this->command->getOutput()->createProgressBar(self::TOTAL_RECORDS);
        $totalChunks = (int) ceil(self::TOTAL_RECORDS / self::CHUNK_SIZE);
        $inserted   = 0;

        // Disable query log to save memory during mass inserts
        DB::disableQueryLog();

        for ($chunk = 0; $chunk < $totalChunks; $chunk++) {
            $remaining  = self::TOTAL_RECORDS - $inserted;
            $batchSize  = min(self::CHUNK_SIZE, $remaining);
            $rows       = [];

            for ($i = 0; $i < $batchSize; $i++) {
                $rows[] = $this->makeRow($faker, $userIds, $totalUsers);
            }

            DB::table('login_histories')->insert($rows);

            $inserted += $batchSize;
            $bar->advance($batchSize);

            // Release memory every 10 chunks (~10k rows)
            if ($chunk % 10 === 0) {
                unset($rows);
                gc_collect_cycles();
            }
        }

        $bar->finish();
        $this->command->newLine(2);
        $this->command->info(sprintf('Done. %s records inserted.', number_format($inserted)));
    }

    /**
     * Build a single login_histories row as an array.
     * Using array (not Eloquent model) keeps memory flat — no model overhead.
     */
    private function makeRow(\Faker\Generator $faker, array $userIds, int $totalUsers): array
    {
        $loginTime  = $faker->dateTimeBetween('-2 years', 'now');
        $userAgent  = self::USER_AGENTS[array_rand(self::USER_AGENTS)];

        return [
            // Pick a random user_id from the pre-fetched pool (no extra queries)
            'user_id'    => $userIds[mt_rand(0, $totalUsers - 1)],
            'ip_address' => $faker->boolean(80)   // 80% IPv4, 20% IPv6
                ? $faker->ipv4()
                : $faker->ipv6(),
            'user_agent' => $userAgent,
            'login_time' => $loginTime->format('Y-m-d H:i:s'),
            'created_at' => $loginTime->format('Y-m-d H:i:s'),
            'updated_at' => $loginTime->format('Y-m-d H:i:s'),
        ];
    }

    /**
     * Fetch only the IDs — keeps the array tiny even with 100k users.
     */
    private function getUserIds(): array
    {
        return User::pluck('id')->toArray();
    }
}
