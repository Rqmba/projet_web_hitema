<?php

namespace App\DataFixtures;

use App\Entity\User;
use DateTime;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    private array $users = [
        [
            'lastname' => 'TestUserLastname',
            'firstname' => 'TestUserFirstname',
            'birthday' => '2001-02-01',
            'email' => 'admin@admin.fr',
            'createdAt' => '2000-01-01',
            'adresse' => '3 rue de luser',
            'zipCode' => 45000,
            'city' => 'Orléans',
            'country' => 'France',
            'roles' => [ 'ROLE_ADMIN', ],
        ],

        [
            'lastname' => 'TestAdminLastname',
            'firstname' => 'TestAdminFirstname',
            'birthday' => '2001-01-03',
            'email' => 'user@user.fr',
            'createdAt' => '2000-01-02',
            'adresse' => '3 rue de ladmin',
            'zipCode' => 45000,
            'city' => 'Orléans',
            'country' => 'France',
            'roles' => [ 'ROLE_USER', ],
        ],
    ];

    public function __construct(readonly private UserPasswordHasherInterface $userPasswordHasher) {
        
    }

    public function load(ObjectManager $manager): void
    {
        foreach ($this->users as $user) {
            $entity = new User();

            $entity
            ->setLastname($user['lastname'])
            ->setFirstname($user['firstname'])
            ->setBirthday(new DateTime($user['birthday']))
            ->setEmail($user['email'])
            ->setCreatedAt(new DateTimeImmutable($user['createdAt']))
            ->setAdresse($user['adresse'])
            ->setZipCode($user['zipCode'])
            ->setCity($user['city'])
            ->setCountry($user['country'])
            ->setPassword($this->userPasswordHasher->hashPassword($entity, $user['email']))
            ->setRoles($user['roles'])
            ;

            $manager->persist($entity);
        }
        // $product = new Product();
        // $manager->persist($product);

        $manager->flush();
    }
}
