# M3U Playlist downloader & extractor
M3u playlist downloader and parser and extractor by playlist group

# Instalation:
1. Run `composer install` in project dir
2. Create own plugin for M3U file in `/src/Services/M3u/Plugins` use a `App\Interfaces\M3u\PluginInterface` (check example file)
3. Create own config file if need in `config` dir (check example file)

# Example:
```php
use App\Services\M3u\DownloaderService;
use App\Services\M3u\ParseService;

require __DIR__ . '/../vendor/autoload.php';

// load plugin
$downloaderService= new DownloaderService(new \App\Services\M3u\Plugins\ExamplePlugin());

// download playlist via plugin (path: storage/playlist/raw/in)
$pathToM3uFile = $downloaderService->download();

// if parse to extract in new playlist (path: storage/playlist/raw/out)
$parserService = new ParseService();
// extract optional groups
$parserService->parse($pathToM3uFile, ['group1', 'group2']);
```

# Libraries:
- guzzlehttp/guzzle
- gemorroj/m3u-parser
- monolog/monolog
- symfony/yaml


