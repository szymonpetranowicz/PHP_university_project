<?php

namespace App\Tests;

use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Doctrine\Bundle\DoctrineBundle\Registry;
use Doctrine\Common\DataFixtures\Executor\ORMExecutor;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\SchemaTool;
use Symfony\Bridge\Doctrine\DataFixtures\ContainerAwareLoader as DataFixturesLoader;
use Symfony\Component\EventDispatcher\Debug\TraceableEventDispatcher;

abstract class IntegrationTestCase extends WebTestCase
{
    private $refs;
    protected $client;

    public function loginAndPasswordDataProvider(): array
    {
        return [
            [
                'admin1@example.com',
                'admin1234'
            ],
            [
                'user1@example.com',
                'user1234'
            ]
        ];
    }

    protected function getReference($name)
    {
        if (!$this->refs) {
            throw new \RuntimeException('Load fixtures first using the "loadFixtures()" method.');
        }

        return $this->refs->getReference($name);
    }

    protected function prepareFormData($formName, $data, $appendToken = true)
    {
        if ($appendToken) {
            $token = $this->getKernel()->getContainer()->get('security.csrf.token_manager')->getToken($formName);
            $data['_token'] = $token;
        }
        return [ $formName => $data ];
    }

    /**
     * @param $entityName
     * @return EntityRepository
     */
    protected function getRepository($entityName)
    {
        return $this->getKernel()->getContainer()->get('doctrine.orm.entity_manager')->getRepository($entityName);
    }


    /**
     * @param array $classNames The list of fixture classes to load
     *
     * @return ORMExecutor
     */
    protected function loadFixtures(array $classNames)
    {
        $container = $this->getKernel()->getContainer();
        if (!$container) {
            throw new \RuntimeException('Kernel is NOT ready, create a test Client first using static::createClient()');
        }
        /** @var Registry $doctrine */
        $doctrine = $container->get('doctrine');
        /** @var EntityManager $em */
        $em = $doctrine->getManager();
        $metadatas = $em->getMetadataFactory()->getAllMetadata();
        $tool = new SchemaTool($em);
        $tool->createSchema($metadatas);
        $loader = new DataFixturesLoader($container);
        foreach ($classNames as $fixture) {
            $loader->addFixture($fixture);
        }
        $fixtures = $loader->getFixtures();
        if (empty($fixtures)) {
            throw new \RuntimeException('No fixtures to load!');
        }
        $purger = new ORMPurger($em);
        $purger->setPurgeMode(ORMPurger::PURGE_MODE_TRUNCATE);
        $purger->purge();
        $executor = new ORMExecutor($em, $purger);
        $executor->execute($fixtures);

        $this->refs = $executor->getReferenceRepository();

        return $executor;
    }

    private function getKernel()
    {
        if (!static::$kernel) {
            throw new \RuntimeException('Kernel is NOT ready, create a test Client first using static::createClient()');
        }
        return static::$kernel;
    }
}