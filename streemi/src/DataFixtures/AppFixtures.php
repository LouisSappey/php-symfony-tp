<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Categorie;
use App\Entity\Language;
use Symfony\Component\Yaml\Yaml;
use App\Entity\Media;
use App\Enum\MediaTypeEnum;
use App\Enum\UserAccountStatusEnum;
use App\Entity\Serie;
use App\Entity\Season;
use App\Entity\User;
use App\Entity\Subscription;
use App\Entity\WatchHistory;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function loadCategories(ObjectManager $manager)
    {

        $fixturesPath = Yaml::parseFile(__DIR__ .'/../../fixtures/categories.yaml');

        foreach ($fixturesPath['categories'] as $data) {
            $entity = new Categorie();
            $entity->setName($data['name']);
            $entity->setLabel($data['description']);
        
            $manager->persist($entity);
        }
        
        $manager->flush();
    }
    public function loadLanguage(ObjectManager $manager)
    {
        $filePath = realpath(__DIR__ . '/../../fixtures/language.yaml');


        $fixturesPath = Yaml::parseFile($filePath);
        
        foreach ($fixturesPath['language'] as $data) {
            $entity = new Language();
            $entity->setName($data['name']);
            $entity->setCode($data['code']);
        
            $manager->persist($entity);
        }
        
        $manager->flush();
    }

    public function loadMedia(ObjectManager $manager)
    {
        $filePath = realpath(__DIR__ . '/../../fixtures/media.yaml');
        if (!$filePath) {
            throw new \Exception('Fixture file not found: ' . __DIR__ . '/../../fixtures/media.yaml');
        }

        $fixturesData = Yaml::parseFile($filePath);

        foreach ($fixturesData['media'] as $data) {
            $media = new Media();
            $media->setTitle($data['title']);
            $media->setMediaType(MediaTypeEnum::from($data['mediaType']));
            $media->setShortDescription($data['shortDescription']);
            $media->setLongDescription($data['longDescription']);
            $media->setReleaseDate(new \DateTime($data['releaseDate']));
            $media->setCoverImage($data['coverImage']);
            $media->setStaff($data['staff']);
            $media->setCasting($data['casting']);

            $manager->persist($media);
        }

        $manager->flush();
    }

    public function loadSeries(ObjectManager $manager)
    {
        $filePath = realpath(__DIR__ . '/../../fixtures/series.yaml');
        if (!$filePath) {
            throw new \Exception('Fixture file not found: ' . __DIR__ . '/../../fixtures/serie.yaml');
        }

        $fixturesData = Yaml::parseFile($filePath);
        
        foreach ($fixturesData['series'] as $data) {
            $media = $manager->getRepository(Media::class)->find($data['media_id']);
            if (!$media) {
                throw new \Exception("Media with ID {$data['media_id']} not found");
            }

            $serie = new Serie();
            $serie->setMedia($media);

            $manager->persist($serie);
        }

        $manager->flush();
    }

    public function loadSeason(ObjectManager $manager)
    {
        $filePath = realpath(__DIR__ . '/../../fixtures/season.yaml');
        if (!$filePath) {
            throw new \Exception('Fixture file not found: ' . __DIR__ . '/../../fixtures/season.yaml');
        }

        $fixturesData = Yaml::parseFile($filePath);

        foreach ($fixturesData['seasons'] as $data) {
            $serie = $manager->getRepository(Serie::class)->find($data['serie_id']);
            if (!$serie) {
                throw new \Exception("Serie with ID {$data['serie_id']} not found");
            }

            $season = new Season();
            $season->setSeasonNumber($data['season_number']);
            $season->setSerie($serie);

            $manager->persist($season);
        }

        $manager->flush();
    }

    public function loadWatchHistory(ObjectManager $manager): void
    {
        // Load the YAML file
        $filePath = realpath(__DIR__ . '/../../fixtures/watch_history.yaml');
        if (!$filePath) {
            throw new \Exception('Fixture file not found: ' . __DIR__ . '/../../fixtures/watch_history.yaml');
        }

        $fixturesData = Yaml::parseFile($filePath);

        // Create and persist WatchHistory entities
        foreach ($fixturesData['watch_histories'] as $data) {
            $watchHistory = new WatchHistory();

            // Set userId and mediaId based on the existing entities
            $user = $manager->getRepository(User::class)->find($data['user_id']);
            if (!$user) {
                throw new \Exception("User with ID {$data['user_id']} not found.");
            }
            $watchHistory->setUserId($user->getId());

            $media = $manager->getRepository(Media::class)->find($data['media_id']);
            if (!$media) {
                throw new \Exception("Media with ID {$data['media_id']} not found.");
            }
            $watchHistory->setMediaId($media->getId());

            $watchHistory->setLastWatched(new \DateTime($data['last_watched']));
            $watchHistory->setNumberOfViews($data['number_of_views']);

            $manager->persist($watchHistory);
        }

        // Flush all persisted entities
        $manager->flush();
    }

    public function loadSubscription(ObjectManager $manager): void
    {
        // Load the YAML file
        $filePath = realpath(__DIR__ . '/../../fixtures/subscriptions.yaml');
        if (!$filePath) {
            throw new \Exception('Fixture file not found: ' . __DIR__ . '/../../fixtures/subscriptions.yaml');
        }

        $fixturesData = Yaml::parseFile($filePath);

        // Create and persist Subscription entities
        foreach ($fixturesData['subscriptions'] as $data) {
            $subscription = new Subscription();
            $subscription->setName($data['name']);
            $subscription->setPrice($data['price']);
            $subscription->setDuration($data['duration']);

            $manager->persist($subscription);
        }

        // Flush all persisted entities
        $manager->flush();
    }

    public function loadUsers(ObjectManager $manager)
    {
        $filePath = realpath(__DIR__ . '/../../fixtures/users.yaml');
        if (!$filePath) {
            throw new \Exception('Fixture file not found: ' . __DIR__ . '/../../fixtures/user.yaml');
        }

        $fixturesData = Yaml::parseFile($filePath);

        foreach ($fixturesData['users'] as $data) {
            $user = new User();
            $user->setUsername($data['username']);
            $user->setEmail($data['email']);
            $hashedPassword = $this->passwordHasher->hashPassword($user, $data['password']);
            $user->setPassword($hashedPassword);
            $user->setAccountStatus(UserAccountStatusEnum::from($data['account_status']));
            $user->setRoles(['ROLE_USER']);

            if (isset($data['current_subscription_id'])) {
                $user->setCurrentSubscription($manager->getRepository(Subscription::class)->find($data['current_subscription_id']));
            }

            if (isset($data['watch_history_id'])) {
                $user->setWatchHistory($manager->getRepository(WatchHistory::class)->find($data['watch_history_id']));
            }

            $manager->persist($user);
        }

        $manager->flush();
    }

    public function load(ObjectManager $manager)
    {
        $this->loadSubscription($manager);
        $this->loadUsers($manager);
        $this->loadCategories($manager);
        $this->loadLanguage($manager);
        $this->loadMedia($manager);
        $this->loadSeries($manager);
        $this->loadSeason($manager);
        $this->loadWatchHistory($manager);
    }
}