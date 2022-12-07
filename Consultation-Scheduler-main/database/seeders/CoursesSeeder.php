<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Course;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\File\File;
use League\Flysystem\MountManager;

class CoursesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function createFileObject($url)
    {
        $path_parts = pathinfo($url);
        $newPath = $path_parts['dirname'] . '/';
        if(!is_dir ($newPath)){
            mkdir($newPath, 0777);
        }
        $newUrl = $newPath . $path_parts['basename'];
        copy($url, $newUrl);
        $imgInfo = getimagesize($newUrl);
        $file = new UploadedFile(
            $newUrl,
            $path_parts['basename'],
            $imgInfo['mime'] ?? null,
            filesize($url),
            TRUE,
        );
        return $file;
    }

    public function run()
    {
        $data = [
          [
            'name' => 'BSCS',
            'long_name' => 'Bachelor of Science in Computer Science',
            'description' => '',
            'icon' => 'data-science.png',
          ],
          [
            'name' => 'BSIT',
            'long_name' => 'Bachelor of Science in Information Technology',
            'description' => '',
            'icon' => 'data-science.png',
          ],
          [
            'name' => 'BSCE',
            'long_name' => 'Bachelor of Science in Computer Engineering',
            'description' => '',
            'icon' => 'data-science.png',
          ],
          [
            'name' => 'BSIS',
            'long_name' => 'Bachelor of Science in Information Science',
            'description' => '',
            'icon' => 'data-science.png',
          ],
          [
            'name' => 'BSDS',
            'long_name' => 'Bachelor of Science in Data Science',
            'description' => '',
            'icon' => 'data-science.png',
          ],
          [
            'name' => 'BSEMC',
            'long_name' => 'Bachelor of Science in Entertainment and Media Computing',
            'description' => '',
            'icon' => 'data-science.png',
          ],
          [
            'name' => 'BSE',
            'long_name' => 'Bachelor of Science in ESports',
            'description' => '',
            'icon' => 'data-science.png',
          ],
        ];

        $s3 = Storage::disk('s3');

        for ($i = 0; $i < count($data); $i++) {
            $course = Course::create([
              'name' => $data[$i]['name'],
              'long_name' => $data[$i]['long_name'],
              'description' => $data[$i]['description'],
            ]);

            $s3->put('files/courses/'.$data[$i]['icon'], fopen(storage_path('app/public/'.$data[$i]['icon']), 'r+'), 'public');

            $course->update(['icon' => $s3->url('files/courses/'.$data[$i]['icon'])]);
        }
    }
}
