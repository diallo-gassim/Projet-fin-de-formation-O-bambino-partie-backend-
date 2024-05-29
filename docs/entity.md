# Entité dans Symfony - Exemple Projet

Dans Symfony, une **entité** est une classe PHP qui représente un objet métier lié à une table de base de données. Les entités facilitent l'interaction entre votre application et la base de données, permettant de stocker et de récupérer des données de manière orientée objet.

## Caractéristiques d'une Entité

- **Annotations Doctrine :** Les entités sont souvent annotées avec des balises spécifiques de Doctrine. Ces annotations décrivent la manière dont l'entité est mappée sur la base de données.

- **Propriétés :** Chaque propriété de l'entité représente une colonne dans la table de la base de données. Ces propriétés peuvent avoir des types différents comme des chaînes de caractères, des entiers, des dates, etc.

- **Méthodes :** Les méthodes de l'entité peuvent être utilisées pour définir des comportements spécifiques liés à l'objet.

- **Relations :** Les entités peuvent être liées les unes aux autres, créant des relations entre les tables de la base de données. Par exemple, une entité `User` peut être liée à une entité `Role`.

## Exemple d'Entité dans Projet Symfony

Supposons que vous ayez une entité `User` dans votre projet. Voici à quoi cela pourrait ressembler :

```php
<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="users")
 */
class User
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    // ... d'autres propriétés et méthodes

    // Getter et Setter pour chaque propriété
}

Dans cet exemple, l'entité User est annotée avec des balises Doctrine, possède des propriétés telles que username et email, et peut être utilisée pour interagir avec la table des utilisateurs dans la base de données.

Les entités sont un élément clé de Symfony, facilitant la gestion des données de la base de données de manière orientée objet dans votre application.