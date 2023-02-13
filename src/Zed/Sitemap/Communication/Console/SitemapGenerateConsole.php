<?php

namespace Zed\Sitemap\Communication\Console;

use Generated\Shared\Transfer\SitemapTransfer;
use Spryker\Zed\Kernel\Communication\Console\Console;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * @method \Zed\Sitemap\Persistence\SitemapQueryContainerInterface getQueryContainer()
 * @method \Zed\Sitemap\Business\SitemapFacadeInterface getFacade()
 * @method \Zed\Sitemap\Business\SitemapBusinessFactory getFactory()
 */
class SitemapGenerateConsole extends Console
{
    public const COMMAND_NAME = 'sitemap:generate';
    public const DESCRIPTION = 'Trigger sitemap generation. Locale argument is mandatory!';
    public const ARGUMENT_LOCALE = 'locale';

    /**
     * @return void
     */
    protected function configure(): void
    {
        $this->addArgument(static::ARGUMENT_LOCALE, InputArgument::OPTIONAL, 'Defines for which locale this should be executed. e.g. en de');

        $this->setName(static::COMMAND_NAME)
            ->setDescription(static::DESCRIPTION);
    }

    /**
     * @param \Symfony\Component\Console\Input\InputInterface $input
     * @param \Symfony\Component\Console\Output\OutputInterface $output
     *
     * @return int|null
     */
    protected function execute(InputInterface $input, OutputInterface $output): ?int
    {
        $locale = $this->getLocaleArgument($input);
        $messenger = $this->getMessenger();

        $messenger->info(sprintf(
            'Started %s %s!',
            static::COMMAND_NAME,
            $locale,
        ));

        $sitemapTransfer = (new SitemapTransfer())->setLocale($locale);
        $this->getFacade()->createSitemapXml($sitemapTransfer);

        return static::CODE_SUCCESS;
    }

    /**
     * @param \Symfony\Component\Console\Input\InputInterface|null $input
     *
     * @return string
     */
    protected function getLocaleArgument(?InputInterface $input = null): string
    {
        if ($input && $input->getArgument(static::ARGUMENT_LOCALE)) {
            return $input->getArgument(static::ARGUMENT_LOCALE);
        }

        $commandNameParts = explode(':', $this->getName());

        return array_pop($commandNameParts);
    }
}
