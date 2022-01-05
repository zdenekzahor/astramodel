<?php
declare(strict_types=1);

namespace ZdenekZahor\Astramodel\Service;

use PHPUnit\Framework\TestCase;
use ZdenekZahor\Astramodel\Entity\ProductEntity;

final class ExportParserTest extends TestCase {

	public function testParseCount(): void {
		$parser = new ExportParser();
		$this->assertSame(7, $parser->parseProductCount(__DIR__ . '/export_full.xml'));
	}

	public function testParseProducts(): void {
		$parser = new ExportParser();
		$products = $parser->parseProducts(__DIR__ . '/export_full.xml', false);

		$this->assertCount(7, $products);
		$this->assertContainsOnlyInstancesOf(ProductEntity::class, $products);
		$this->assertSame('Item 4', $products['TEST-4']->getName());
		$this->assertSame([], $products['TEST-4']->getSpareParts());
	}

	public function testParseProductsWithSpareParts(): void {
		$parser = new ExportParser();
		$products = $parser->parseProducts(__DIR__ . '/export_full.xml', true);

		$sparePartsOfProduct1 = $products['TEST-1']->getSpareParts();
		$this->assertCount(2, $sparePartsOfProduct1);
		$this->assertContainsOnlyInstancesOf(ProductEntity::class, $sparePartsOfProduct1);
		$this->assertSame('Item 2', $sparePartsOfProduct1[0]->getName());
		$this->assertSame('Item 5', $sparePartsOfProduct1[1]->getName());

		$sparePartsOfProduct4 = $products['TEST-4']->getSpareParts();
		$this->assertCount(1, $sparePartsOfProduct4);
		$this->assertContainsOnlyInstancesOf(ProductEntity::class, $sparePartsOfProduct4);
		$this->assertSame('Item 5', $sparePartsOfProduct4[0]->getName());
	}
}
