<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class GenerateJsEnums extends Command
{
    protected $signature = 'generate:js-enums {--path=resources/js/Constants/Enums.js}';

    protected $description = 'Automatically convert all PHP enums in App\Enums to a single JavaScript file.';

    public function handle()
    {
        $enumsPath = app_path('Enums');
        $enumFiles = File::allFiles($enumsPath);

        $jsContent = "// Auto-generated Enums\n";
        foreach ($enumFiles as $file) {
            $enumClass = 'App\\Enums\\' . $file->getFilenameWithoutExtension();

            if (!class_exists($enumClass)) {
                continue;
            }

            $reflectionEnum = new \ReflectionEnum($enumClass);
            $jsContent .= $this->generateJsEnum($reflectionEnum);
        }

        $path = base_path($this->option('path'));
        File::put($path, $jsContent);
        $this->info("Enums have been converted and saved to {$path}");

        return 0;
    }

    protected function generateJsEnum(\ReflectionEnum $reflectionEnum): string
    {
        $jsEnum = "export const {$reflectionEnum->getShortName()} = {\n";
        foreach ($reflectionEnum->getCases() as $case) {
            $jsEnum .= "    {$case->getName()}: " . json_encode($case->getValue()) . ",\n";
        }
        $jsEnum .= "};\n\n";
        return $jsEnum;
    }
}
