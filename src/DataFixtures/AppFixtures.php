<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\meal;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use App\DataFixtures\Provider\ObambinoProvider;
use App\Entity\Child;
use App\Entity\EventCalendar;
use App\Entity\User;
use DateTime;

class AppFixtures extends Fixture
 {
    // On utilise la méthode load() pour charger les fixtures
     public function load(ObjectManager $manager): void
     {
        // On instancie Faker
        $faker = Factory::create('fr_FR');

        // On ajoute le provider ObambinoProvider à Faker
        $eventCalendar = [];
        
        // On crée un tableau vide pour stocker les événements du calendrier
        for ($i = 0; $i < 5; $i++) {
            $calendar = new EventCalendar();
            $calendar->setStart($faker->dateTimeBetween('now', '+8 days'));
            $calendar->setTitle($faker->randomElement(['anniversaire', 'noël', 'Halloween', 'rendez-vous']));
            $calendar->setEnd($faker->dateTimeBetween('now', '+8 days'));
            $eventCalendar[] = $calendar; 
            $manager->persist($calendar);
        }

        // On crée un tableau vide pour stocker les enfants
        $children = [];
        
        // On crée 8 enfants
        for ($i = 0; $i < 8; $i++) {
            $child = new Child();
            $child->setFirstname($faker->randomElement(['Jean', 'Paul', 'Marie', 'Lucie']));
            $child->setLastname($faker->randomElement(['Dupont', 'Durand', 'Martin', 'Lefebvre']));
            $child->setGender($faker->randomElement(['fille', 'garçon']));
            $child->setBirthday($faker->dateTimeBetween('-2 years', 'now'));
            $child->setDiet($faker->randomElement(['sans gluten', 'sans lactose','sans porc', 'végétarien', 'végétalien']));
            $children[] = $child; 
            $manager->persist($child);
        }

        // On crée un tableau vide pour stocker les repas
        $mealfake = [];
        $weekDays = ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi'];

        // On crée 5 repas
        for ($i = 0; $i < 5; $i++) {
            $meal = new Meal();
            $meal->setStarter($faker->randomElement(['Purée de carottes', 'Purée de poireaux', 'Purée de butternut', 'purée de haricot vert', 'tomate à huile olive féta']));
            $meal->setMainMeal($faker->randomElement(['Cabillaud purée de pommes de terre', 'jambon/colin purée de pommes de terre', 'Saumon et salade de riz', 'dinde/caviar purée de pomme de terre', 'salade pates jambon/sardines']));
            $meal->setDessert($faker->randomElement(['cerises et fromage', 'abricot', 'Melon', 'gouda compotes', 'gouda compotes']));
            $meal->setSnack($faker->randomElement(['tarte aux fraises', 'petit suisse biscuits', 'gateau au chocolat', 'fromage blanc coulis de fraise', 'fromage blanc coulis de fraise']));
            $meal->setDate($faker->dateTimeBetween('now', '+5 days'));
            $meal->setWeekDay($weekDays[$i]);
            $mealfake[] = $meal; 
            $manager->persist($meal);
        }

        // On crée un tableau vide pour stocker les utilisateurs
        $user = new User(); // On créer l'user
        $user->setEmail("admin@admin.fr"); // On lui donne un email
        $user->setRoles(['ROLE_ADMIN']); // On donne le role admin a cet user
        $user->setPassword(password_hash("okokok",PASSWORD_BCRYPT));
        $user->setFirstname("admin");
        $user->setLastname("admin");

        // On persiste les utilisateurs
        $manager->persist($user); // On persist

        // 2eme : utilisateur manager
        $user = new User(); // On créer l'user
        $user->setEmail("user@user.fr"); // On lui donne un email
        $user->setRoles([]); // On donne le role manager a cet user
        $user->setPassword(password_hash("okokok",PASSWORD_BCRYPT));
        $user->setFirstname("user");
        $user->setLastname("user");
        $manager->persist($user); // On persist

        // 3eme : utilisateur user
        $manager->flush();




    }

}