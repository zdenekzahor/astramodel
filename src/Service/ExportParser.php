<?php
declare(strict_types=1);

namespace ZdenekZahor\Astramodel\Service;

use SimpleXMLElement;
use ZdenekZahor\Astramodel\Entity\ProductEntity;
use function array_map;
use function count;
use function file_get_contents;

class ExportParser {

	/**
	 * @param string $fullExportXmlFile
	 * @return int
	 */
	public function parseProductCount(string $fullExportXmlFile): int {
		$xml = new SimpleXMLElement(file_get_contents($fullExportXmlFile));
		return count($xml->xpath('/export_full/items/item'));
	}

	/**
	 * @param string $fullExportXmlFile
	 * @param bool $includeSpareParts
	 * @return ProductEntity[]
	 */
	public function parseProducts(string $fullExportXmlFile, bool $includeSpareParts): array {
		$products = [];
		$xml = new SimpleXMLElement(file_get_contents($fullExportXmlFile));

		$productToSparePartsMap = [];
		foreach ($xml->xpath('/export_full/items/item') as $xmlItem) {
			$code = (string)$xmlItem->attributes()['code'];
			$name = (string)$xmlItem->attributes()['name'];

			if ($includeSpareParts) {
				// [future] Remove hardcoded category ID 1
				foreach ($xmlItem->xpath('parts/part[@categoryId=1]/item') as $xmlSparePartItem) {
					$productToSparePartsMap[$code][] = (string)$xmlSparePartItem->attributes()['code'];
				}
			}
			$products[$code] = new ProductEntity(
				$code,
				$name,
				[],
			);
		}

		foreach ($productToSparePartsMap as $code => $sparePartsCodes) {
			$products[$code]->setSpareParts(array_map(static function (string $code) use ($products): ProductEntity {
				return $products[$code];
			}, $sparePartsCodes));
		}
		return $products;
	}
}
