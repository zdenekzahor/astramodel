<?php
declare(strict_types=1);

namespace ZdenekZahor\Astramodel\Entity;

class ProductEntity {

	/** @var string */
	private string $code;

	/** @var string */
	private string $name;

	/** @var ProductEntity[] */
	private array $spareParts;

	/**
	 * @param string $code
	 * @param string $name
	 * @param ProductEntity[] $spareParts
	 */
	public function __construct(
		string $code,
		string $name,
		array $spareParts,
	) {
		$this->code = $code;
		$this->name = $name;
		$this->spareParts = $spareParts;
	}

	/**
	 * @return string
	 */
	public function getName(): string {
		return $this->name;
	}

	/**
	 * @return ProductEntity[]
	 */
	public function getSpareParts(): array {
		return $this->spareParts;
	}

	/**
	 * @param ProductEntity[] $spareParts
	 */
	public function setSpareParts(array $spareParts): void {
		$this->spareParts = $spareParts;
	}
}
