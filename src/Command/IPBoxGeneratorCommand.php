<?php

namespace App\Command;

use App\Report\Factory\ReportYear;
use App\Tools\TaskConverter;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Filesystem\Filesystem;

#[AsCommand(name: 'app:IPBoxGenerator', description: 'IP box report generator.')]
class IPBoxGeneratorCommand extends Command
{
    public function __construct(private readonly ReportYear $abstractReportFactory, private readonly Filesystem $filesystem)
    {
        parent::__construct();
    }

    #[\Override]
    protected function configure(): void
    {
        $this->addArgument('year', InputArgument::REQUIRED, 'Generate reports for year.');
    }

    #[\Override]
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        try {
            /** @var string $year */
            $year = $input->getArgument('year');

            $io->note('Generating reports for year '.$year);

            foreach ($this->abstractReportFactory->createFactoryForYear((int) $year)->createCompanyReports() as $companyReports) {
                $io->note('Generating reports for company: '.$companyReports->getName());

                foreach ($companyReports->getTaskServices((int) $year) as $service) {
                    $io->note('Generating report for service: '.$service->getName());

                    $path = sprintf('reports/report_%s_%s_%s.csv', $year, $companyReports->getName(), $service->getName());
                    $converter = new TaskConverter($service->getTasks());

                    $this->filesystem->dumpFile($path, $converter->toCsv());
                }
            }

            $io->success('Your reports is generated.');

            return Command::SUCCESS;
        } catch (\Throwable $exception) {
            $io->error(sprintf('%s: %s', $exception::class, $exception->getMessage()));

            return Command::FAILURE;
        }
    }
}
