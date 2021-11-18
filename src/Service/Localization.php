<?php

namespace App\Service;

use App\Repository\LocalizationRepository;
use Negotiation\LanguageNegotiator;

class Localization
{
    const DEFAULT_LOCALE = 'de-de';
    const FIELD_LOCALE = 'locale';

    /**
     * @var array
     */
    protected $localizationMap;

    /**
     * @var LocalizationRepository
     */
    private $localization;

    /**
     * Localization constructor.
     * @param LocalizationRepository $localization
     */
    public function __construct(LocalizationRepository $localization)
    {
        $this->localization = $localization;
    }

    /**
     * @return array
     */
    public function getSupportedLocales(): array
    {
        $locales = array_keys($this->getLocalizationsMap());
        sort($locales);

        return $locales;
    }

    /**
     * @param $accepted
     * @param array $supported
     * @return string
     */
    public function getBestLocale($accepted, array $supported): string
    {
        if (!$accepted) {
            return static::DEFAULT_LOCALE;
        }
        $negotiator = new LanguageNegotiator();
        $bestLocale = $negotiator->getBest($accepted, $supported);

        return $bestLocale !== null ? $bestLocale->getType() : static::DEFAULT_LOCALE;
    }

    /**
     * @param $locale
     * @param string $key
     * @return string
     */
    public function get($locale, string $key): string
    {
        $text = $key;
        $localizationMap = $this->getLocalizationsMap();
        $localeToUse = static::DEFAULT_LOCALE;
        if (
            array_key_exists($locale, $localizationMap)
            && array_key_exists($key, $localizationMap[$locale])
        ) {
            $localeToUse = $locale;
        }

        if (
            array_key_exists($localeToUse, $localizationMap)
            && array_key_exists($key, $localizationMap[$localeToUse])
        ) {
            $text = $localizationMap[$localeToUse][$key];
        }

        return $text;
    }

    /**
     * @return array
     */
    protected function getLocalizationsMap(): array
    {
        if (!$this->localizationMap) {
            $rows = $this->localization->get();
            $this->localizationMap = [];
            foreach ($rows as $row) {
                $locale = $row[static::FIELD_LOCALE];
                if (!array_key_exists($locale, $this->localizationMap)) {
                    $this->localizationMap[$locale] = [];
                }
                $this->localizationMap[$locale][$row['key']] = $row['text'];
            }
        }

        return $this->localizationMap;
    }
}

