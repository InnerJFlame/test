<?php

declare(strict_types=1);

namespace App\Command;

use App\Entity\City;
use App\Entity\Country;
use Doctrine\ORM\EntityManagerInterface;
use League\Csv\Reader;
use League\Csv\Statement;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Intl\Countries;

class LoadCitiesCommand extends Command
{
    private const FILE_PATH = './data/worldcities.csv';

    protected static $defaultName = 'cities:load';

    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        parent::__construct();
        $this->em = $em;
    }

    protected function configure()
    {
        $this->addArgument('countryIso2', InputArgument::REQUIRED, 'Country code');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $countryIso2 = strtoupper($input->getArgument('countryIso2'));

        if (!Countries::exists($countryIso2)) {
            return Command::FAILURE;
        }

        $records = (new Statement())
            ->process(Reader::createFromPath(self::FILE_PATH));

        $country = (new Country())
            ->setName(Countries::getName($countryIso2))
            ->setSlug(strtolower($countryIso2))
            ->setLanguage('ro_RO')
            ->setEnabled(true);
        $this->em->persist($country);

        foreach ($records as $record) {
            if ($record[5] == $countryIso2) {
                $city = (new City())
                    ->setName($record[0])
                    ->setSlug(strtolower($record[0]))
                    ->setEnglishName($record[0])
                    ->setEnabled(false)
                    ->setCountry($country);
                $this->em->persist($city);
            }
        }

        $this->em->flush();

        return Command::SUCCESS;
    }
}
