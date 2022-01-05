<?php
declare(strict_types=1);

namespace ZdenekZahor\Astramodel\Service;

use GuzzleHttp\Client;
use ZipArchive;
use function unlink;

class ExportDownloader {

	public function getFile(string $url): string {
		$zipFile = __DIR__ . '/export.zip';
		$client = new Client();
		$client->request('GET', $url, ['sink' => $zipFile]);

		$zip = new ZipArchive();
		$zip->open($zipFile);
		$zip->extractTo(__DIR__);
		$zip->close();

		@unlink($zipFile);
		return __DIR__ . '/export_full.xml';
	}

	public function clear(): void {
		@unlink(__DIR__ . '/export.zip');
		@unlink(__DIR__ . '/export_full.xml');
	}
}
