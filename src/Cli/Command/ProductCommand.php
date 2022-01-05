<?php
declare(strict_types=1);

namespace ZdenekZahor\Astramodel\Cli\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Throwable;
use ZdenekZahor\Astramodel\Service\ExportDownloader;
use ZdenekZahor\Astramodel\Service\ExportParser;

final class ProductCommand extends Command {

	/** @var string */
	private const NAME = 'product';

	/** @var string */
	private const ARG__URl = 'url';

	/** @var string */
	private const OPT__ONLY_COUNT = 'only-count';

	/** @var string */
	private const OPT__ONLY_NAME = 'only-name';

	private ExportDownloader $exportDownloader;

	private ExportParser $exportParser;

	/**
	 * @param ExportDownloader $exportDownloader
	 * @param ExportParser $exportParser
	 */
	public function __construct(
		ExportDownloader $exportDownloader,
		ExportParser $exportParser,
	) {
		parent::__construct();

		$this->exportDownloader = $exportDownloader;
		$this->exportParser = $exportParser;
	}

	protected function configure(): void {
		$this->setName(self::NAME);

		$this->setDescription('Load and show products from zipped XML file');

		$this->addArgument(self::ARG__URl, InputArgument::REQUIRED, 'URL of zipped XML file');

		$this->addOption(self::OPT__ONLY_COUNT, null, InputOption::VALUE_OPTIONAL, 'Show only product count', false);
		$this->addOption(self::OPT__ONLY_NAME, null, InputOption::VALUE_OPTIONAL, 'Show only product names', false);
	}

	protected function execute(InputInterface $input, OutputInterface $output): int {
		$url = (string)$input->getArgument(self::ARG__URl);

		$onlyProductCountOptionValue = $input->getOption(self::OPT__ONLY_COUNT);
		if (false === $onlyProductCountOptionValue) {
			$onlyProductCount = false;
		} elseif (null === $onlyProductCountOptionValue) {
			$onlyProductCount = true;
		} else {
			$output->writeln('Wrong usage of "--' . self::OPT__ONLY_COUNT . '" option');
			return 1;
		}

		$onlyProductNameOptionValue = $input->getOption(self::OPT__ONLY_NAME);
		if (false === $onlyProductNameOptionValue) {
			$onlyProductName = false;
		} elseif (null === $onlyProductNameOptionValue) {
			$onlyProductName = true;
		} else {
			$output->writeln('Wrong usage of "--' . self::OPT__ONLY_NAME . '" option');
			return 1;
		}

		try {
			$fullExportXmlFile = $this->exportDownloader->getFile($url);
			if ($onlyProductCount) {
				$output->writeln((string)$this->exportParser->parseProductCount($fullExportXmlFile));
			} else {
				foreach ($this->exportParser->parseProducts($fullExportXmlFile, !$onlyProductName) as $product) {
					$output->writeln($product->getName());
					foreach ($product->getSpareParts() as $sparePartProduct) {
						$output->writeln('├── ' . $sparePartProduct->getName());
					}
				}
			}
			$returnCode = 0;
		} catch (Throwable $exception) {
			$output->writeln($exception->getMessage());
			$returnCode = 1;
		} finally {
			$this->exportDownloader->clear();
		}


		return $returnCode;
	}
}
