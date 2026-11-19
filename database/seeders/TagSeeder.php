<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TagSeeder extends Seeder
{
    public function run(): void
    {
        $tags = [
            // Classification Tags
            [
                'name' => 'Historical Mystery',
                'slug' => 'historical-mystery',
                'tag_kind' => 'CLASSIFICATION',
            ],
            [
                'name' => 'Unexplained Phenomena',
                'slug' => 'unexplained-phenomena',
                'tag_kind' => 'CLASSIFICATION',
            ],
            [
                'name' => 'Archaeology',
                'slug' => 'archaeology',
                'tag_kind' => 'CLASSIFICATION',
            ],
            [
                'name' => 'Science and Technology',
                'slug' => 'science-and-technology',
                'tag_kind' => 'CLASSIFICATION',
            ],
            [
                'name' => 'Disappearance',
                'slug' => 'disappearance',
                'tag_kind' => 'CLASSIFICATION',
            ],
            [
                'name' => 'Folklore and Mythology',
                'slug' => 'folklore-and-mythology',
                'tag_kind' => 'CLASSIFICATION',
            ],

            // Verification Status Tags
            [
                'name' => 'Confirmed',
                'slug' => 'confirmed',
                'tag_kind' => 'VERIFICATION_STATUS',
            ],
            [
                'name' => 'Unconfirmed',
                'slug' => 'unconfirmed',
                'tag_kind' => 'VERIFICATION_STATUS',
            ],

            // Explanation Status Tags
            [
                'name' => 'Unsolved',
                'slug' => 'unsolved',
                'tag_kind' => 'EXPLANATION_STATUS',
            ],
            [
                'name' => 'Partially Explained',
                'slug' => 'partially-explained',
                'tag_kind' => 'EXPLANATION_STATUS',
            ],
            [
                'name' => 'Explained',
                'slug' => 'explained',
                'tag_kind' => 'EXPLANATION_STATUS',
            ],
        ];

        foreach ($tags as $tag) {
            DB::table('tags')->updateOrInsert(
                ['slug' => $tag['slug']],
                [
                    'name' => $tag['name'],
                    'tag_kind' => $tag['tag_kind'],
                    'created_at' => now(),
                ]
            );
        }
    }
}
