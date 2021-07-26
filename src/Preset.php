<?php

namespace Nubix\Preset;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Artisan;
use Laravel\Ui\Presets\Preset as BasePreset;

class Preset extends BasePreset
{
    const NPM_DEV_PACKAGES_TO_ADD = [
        '@headlessui/vue' => '^1.3.0',
        '@heroicons/vue' => '^1.0.1',
        'eslint' => '^7.29.0',
        'eslint-config-prettier' => '^8.3.0',
        'eslint-plugin-vue' => '^7.12.1',
        'prettier' => '^2.3.2'
    ];

    const NPM_PACKAGES_TO_REMOVE = [
        'lodash',
        'axios',
    ];

    const NPM_SCRIPT_TO_ADD = [
        'prettier' => 'node_modules/.bin/prettier --config .prettierrc -w \'resources/**/*.{css,js,vue}\'',
        'eslint' => 'node_modules/.bin/eslint -c .eslintrc.js --fix \'resources/**/*.{js,vue}\'',
        'php-fixer' => 'vendor/bin/php-cs-fixer fix',
        'format' => 'npm run prettier && npm run eslint && npm run php-fixer'
    ];

    const COMPOSER_DEV_PACKAGES_TO_ADD = [
        'barryvdh/laravel-debugbar' => '^3.5',
        'beyondcode/laravel-dump-server' => '^1.7',
        'itsnubix/laravel-nuke' => '^1.0',
    ];

    const GITIGNORES = [
        '.DS_Store',
        '.php-cs-fixer.cache'
    ];

    public static function install()
    {
        static::updatePackages(true);
        static::updateComposer(true);
        static::updatePackageScripts();

        static::updateDirectories();

        // install breeze with vue
        Artisan::call('breeze:install vue');

        Artisan::call('sail:install --with mysql');

        // should perform after breeze install since it has to change some breeze generated files.
        static::updateFiles();
    }

    private static function updateFiles()
    {
        $filesystem = new Filesystem();

        // Append the default .gitignore
        $filesystem->append(base_path('.gitignore'), "\n".implode("\n", static::GITIGNORES)."\n");

        // Code style configuration
        $filesystem->copy(__DIR__.'/../stubs/.editorconfig', base_path('.editorconfig'));
        $filesystem->copy(__DIR__.'/../stubs/.prettierrc', base_path('.prettierrc'));
        $filesystem->copy(__DIR__.'/../stubs/.eslintrc.js', base_path('.eslintrc.js'));
        $filesystem->copy(__DIR__.'/../stubs/.php-cs-fixer.php', base_path('.php-cs-fixer.php'));

        // remove bootstrap.js
        $filesystem->delete(base_path('resources/js/bootstrap.js'));

        // remove requiring bootstrap.js
        static::updateFile(base_path('resources/js/app.js'), function ($file) {
            return str_replace(
                "require('./bootstrap');",
                '',
                $file
            );
        });

        // Add Inter var font source to head
        static::updateFile(base_path('resources/views/app.blade.php'), function ($file) {
            return str_replace(
                '<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">',
                '<link rel="stylesheet" href="https://rsms.me/inter/inter.css">',
                $file
            );
        });
        static::updateFile(base_path('resources/views/welcome.blade.php'), function ($file) {
            return str_replace(
                '<link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">',
                '<link rel="stylesheet" href="https://rsms.me/inter/inter.css">',
                $file
            );
        });

        // update tailwindcss config to use JIT mode
        static::updateFile(base_path('tailwind.config.js'), function ($file) {
            return str_replace(
                'purge',
                "mode: 'jit',\n\tpurge",
                $file
            );
        });

        // update tailwindcss to use Inter var font as first option.
        static::updateFile(base_path('tailwind.config.js'), function ($file) {
            return str_replace(
                'Nunito',
                'Inter var',
                $file
            );
        });
    }

    private static function updateDirectories()
    {
        $filesystem = new Filesystem();

        // copy github actions configurations
        $filesystem->copyDirectory(__DIR__.'/../stubs/.github', base_path('.github'));
    }

    protected static function updatePackageArray(array $packages)
    {
        return array_merge(
            static::NPM_DEV_PACKAGES_TO_ADD,
            Arr::except($packages, static::NPM_PACKAGES_TO_REMOVE)
        );
    }

    /**
     * Update the contents of a file with the logic of a given callback.
     */
    protected static function updateFile(string $path, callable $callback)
    {
        $originalFileContents = file_get_contents($path);
        $newFileContents = $callback($originalFileContents);
        file_put_contents($path, $newFileContents);
    }

    protected static function updatePackageScripts()
    {
        if (! file_exists(base_path('package.json'))) {
            return;
        }

        $configurationKey = 'scripts';

        $packages = json_decode(file_get_contents(base_path('package.json')), true);

        $packages[$configurationKey] = array_merge(
            static::NPM_SCRIPT_TO_ADD,
            $packages[$configurationKey]
        );

        ksort($packages[$configurationKey]);

        file_put_contents(
            base_path('package.json'),
            json_encode($packages, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT).PHP_EOL
        );
    }

    protected static function updateComposer($dev = true)
    {
        if (! file_exists(base_path('composer.json'))) {
            return;
        }

        $configurationKey = $dev ? 'require-dev' : 'require';

        $composer = json_decode(file_get_contents(base_path('composer.json')), true);

        $composer[$configurationKey] = static::updateComposerArray(
            array_key_exists($configurationKey, $composer) ? $composer[$configurationKey] : [],
            $configurationKey
        );

        ksort($composer[$configurationKey]);

        file_put_contents(
            base_path('composer.json'),
            json_encode($composer, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT).PHP_EOL
        );
    }

    // update the composer JSON array
    protected static function updateComposerArray(array $packages)
    {
        return array_merge($packages, static::COMPOSER_DEV_PACKAGES_TO_ADD);
    }
}
