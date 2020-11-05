<?php

namespace App\Repositories;

use App\Models\Company;
use Carbon\Carbon;
use Exception;
use Scheb\YahooFinanceApi\ApiClient;
use Scheb\YahooFinanceApi\ApiClientFactory;
use GuzzleHttp\Client;

class CompanyRepository
{
    public function getBySymbol(string $symbol): Company
    {
        $query = query()->select('*')
            ->from('companies')
            ->where('symbol = :symbol')
            ->setParameter('symbol', $symbol)
            ->andWhere('created_at > "' . Carbon::now()->subMinutes(10)->format('Y-m-d H:i:s') . '"')
            ->execute()
            ->fetchAssociative();

        if (!$query) {
            $company = $this->getFromAPI($symbol);
            $query = query()->select('*')
                ->from('companies')
                ->where('symbol = :symbol')
                ->setParameter('symbol', $symbol)
                ->execute()
                ->fetchAssociative();
            if (!$query) {
                $this->pushIntoDatabase($company);
            } else {
                $this->updateCompanyInDatabase($company);
            }

            return $company;

        }
        return $this->getFromDatabase($symbol);
    }

    private function getFromDatabase(string $symbol): Company
    {
        $query = query()->select('*')
            ->from('companies')
            ->where('symbol = :symbol')
            ->setParameter('symbol', $symbol)
            ->execute()
            ->fetchAssociative();

        $params = array_values($query);
        return new Company(...$params);
    }

    private function getFromAPI(string $symbol): Company
    {
        $client = ApiClientFactory::createApiClient();
        $quote = $client->getQuote($symbol);
        if ($quote == null) {
            throw new Exception('Company not found');
        }
        $company = new Company(
            $quote->getLongName(),
            $quote->getSymbol(),
            $quote->getRegularMarketPrice(),
            $quote->getCurrency(),
            $quote->getRegularMarketPreviousClose(),
            $quote->getRegularMarketOpen(),
            $quote->getBidSize(),
            $quote->getAskSize(),
            $quote->getRegularMarketDayLow() . ' - ' . $quote->getRegularMarketDayHigh(),
            $quote->getFiftyTwoWeekLow() . ' - ' . $quote->getFiftyTwoWeekHigh(),
            $quote->getRegularMarketVolume(),
            $quote->getAverageDailyVolume3Month(),
            $quote->getMarketCap(),
            Carbon::now()->format('Y-m-d H:i:s')
        );
        return $company;
    }

    private function pushIntoDatabase(Company $company)
    {
        query()->insert('companies')
            ->values([
                'symbol' => ':symbol',
                'name' => ':name',
                'price' => ':price',
                'currency' => ':currency',
                'previous_close' => ':previous_close',
                'open' => ':open',
                'bid' => ':bid',
                'ask' => ':ask',
                'days_range' => ':days_range',
                'year_range' => ':year_range',
                'volume' => ':volume',
                'average_volume' => ':average_volume',
                'market_cap' => ':market_cap',
            ])
            ->setParameters([
                'symbol' => $company->getSymbol(),
                'name' => $company->getName(),
                'price' => $company->getPrice(),
                'currency' => $company->getCurrency(),
                'previous_close' => $company->getPreviousClose(),
                'open' => $company->getOpen(),
                'bid' => $company->getBid(),
                'ask' => $company->getAsk(),
                'days_range' => $company->getDaysRange(),
                'year_range' => $company->getYearRange(),
                'volume' => $company->getVolume(),
                'average_volume' => $company->getAverageVolume(),
                'market_cap' => $company->getMarketCap()
            ])
            ->execute();
    }

    private function updateCompanyInDatabase(Company $company)
    {
        query()->update('companies', 'c')
            ->set('c.price', $company->getPrice())
            ->set('c.previous_close', $company->getPreviousClose())
            ->set('c.open', $company->getOpen())
            ->set('c.bid', $company->getBid())
            ->set('c.ask', $company->getAsk())
            ->set('c.days_range', '"' . $company->getDaysRange() . '"')
            ->set('c.year_range', '"' . $company->getYearRange() . '"')
            ->set('c.volume', $company->getVolume())
            ->set('c.average_volume', $company->getAverageVolume())
            ->set('c.market_cap', $company->getMarketCap())
            ->set('c.created_at', 'NOW()')
            ->where('symbol = :symbol')
            ->setParameter('symbol', $company->getSymbol())
            ->execute();
    }
}