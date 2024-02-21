# PHP-Web-Project
The application hosts a community of individuals looking to share online and, in the physical world, a collection of plants they own. Key words: PHP | Symfony | HTML | CSS | Bootstrap
Projet : HerboTrésors 

Auteur : Sabrine Azaiez

### Table des matières:
- Thématique
- Les différentes entités
- Nomenclature des entités
- Documentation
- Les différentes fonctionnalités
- Navigation sur le site

# Thématique:
- Projet : HerboTrésors
- Ce projet consiste en une mini plateforme de collecte de plantes, offrant un espace de collecte des plantes pour les passionnés de la nature.

# Les différentes entités:

Jusqu'à cette phase du projet, il y a 3 entités qui sont actuellement présentes, ces entités sont les suivantes :

1. Entité PlantCatalogue (c'est la classe inventaire selon le guide du projet) : elle contient les attributs suivants : Id et CategorieName.
   
2. Entité Plant (c'est la classe objet selon le guide du projet) : elle contient les attributs suivants : Id, PlantName, Description, Prix , Stock et img. 

3. Entité Member : cette classe contient les attributs suivants : Nom et Description.

4. Entité Galerie: elle contient les attribut suivante: Id, Description et Publiee.

5. Entité User et elle contient les attributs suivant: Id et email.


# Nomenclature des entités:

- Entité PlantCatalogue (inventaire), c'est la classe qui contient les différentes catégories de plantes présentes 
dans la plateforme. Elle divise les plantes selon différentes catégories telles que celles médicales, 
des plantes d'intérieur, de décoration, etc. 
Cette classe est en associations : OneToMany avec l'entité Plant (objet) (attribut:listeObjets)
                                   ManyToOne avec l'entité Member (attribut: membercatalogue)
                                   OneToMany avec Galerie (attribut: plantcatalogue)

- Entité Plant (objet), c'est la classe qui contient les plantes selon une catégorie bien déterminée, cette entité donne une variété de plantes.
Cette classe est en associations : ManyToOne avec l'entité PlantCatalogue (attribut:categorie)
                                   ManyToMany avec l'entité Galerie (attribut: galerie_objet)

- Entité Member, c'est la classe qui contient les différents membres qui vont utiliser le site. 
Ces membres peuvent accéder et avoir n'importe quelle catégorie de plantes et donc n'importe quelle plante qu'ils choisissent. 
Cette classe est en associations : OneToMany avec l'entité PlantCatalogue (attribut:member)
                                   OneToMany avec l'entité Galerie (attribut: createur)
                                   OneToOne avec l'entité User (attribut: usermember)

-Entité Galerie, c'est l'espace de l'affichage public aux autres membres
Cette classe est en associations : ManyToOne avec la classe Member (attribut: member)
                                   ManyToMany avec la classe Plant (objet) (attribut: galerie_objet)

-Entité User, c'est la classe des membres qui sont authentifiés
Cette classe est en associations : OneToOne avec la classe Member (attribut: memberuser)


# Documentation:
Pour L'authentification:
   
   On a principalement 2 users sofienne et salim: 

  ------------------------------------------------------------------------
     Email                 |     Password      |     Role
  -------------------------|-------------------|--------------------------
    sofienne@gmail.com     |    sofienne       |    ROLE_USER
                           |                   |
    salim@gmail.com        |    salim          |   ROLE_ADMIN
  -------------------------|-------------------|--------------------------


# Les différentes fonctionnalités:
- Pour une premiére navigation que le site une navigation sans authentification et possible mais elle est bien sur assez limités.
Un membre non authentifié peut seulement acceder à la galerie et voir seulement les galeries qui sont publiques.

-Affichage des seules galeries publiques

-Authentification à l'aide de la documentation en deux modes user et admin

-Consultation de la liste des PlantCatalogues [inventaires]

-Consultation d'un Plant[objet]

-Ajout d'un neauveau plant

-Modification des plantcatalogues (inventaires) seulement par leur propriétaires

-Protection de l'accès aux routes interdites réservées aux membres

-Protection de l'accès aux données à leurs seuls propriétaires

-Consultation d'une fiche du plantcatalogue (inventaire) à partir de la liste 

-Consultation de la liste des Plantes [objets] d'un plantcatalogue [inventaire]

-Ajout d'un nouveau plantcatalogue (inventaire)

-Consultation de la liste des seuls plantcatalogues (inventaires) d'un membre

-Création d'un plant [objet] en fonction du plantcatalogue [inventaire]

-Mise en ligne d'images pour des photos dans les   Plants[objet]

-Ajout de galerie/plantcatalogue/plant/member dans le back-office

-Protection de l'accès aux CRUD sur les données aux seuls propriétaires de ces données

# Navigation sur le site

FrontOffice:

- Première navigation sur le site pour la consultation des galeries (ne necessite pas d'authentification): /galerie

- Authentification: à travers le boutton login sinon route: /login

-Consultation d'un Plant (objet) : il suffit le consulter tous les objets avec le bouton Plant dans le navbar puis vous pouvez consulter les detailles
de n'importe quel objet souhaite à travers le boutton Show.
     Routes: /plant/list   (pour la consultations de tous les objets)
             /plant/{id}   (pour la consultation d'un objet particulier)

- Consultation de la liste de tous les plantes catalogues (inventaires) : /plant/catalogue/list  ceci est disponible par le boutton Plant Categories de la navbar

- Consultation d'une fiche des plantes (les objets) d'un plant catalogue (inventaire): /plant/catalogue/plant/catalogue/{id} , il suffit d'appuyer sur le bouton Show devant le catalogue des plantes souhaité

- Consultation de la liste des plantes [objets] d'un plant catalogue [inventaire]: /plant/catalogue/plant/catalogue/{id} id de chaque inventaire figure dans la liste des inventaires (boutton Plant Categories)

- Consultation de la liste des membres: boutton Members dans le navbar ou route: /member/

- Consultation de la liste des seuls inventaires d'un membre dans le front-office: Boutton Show devant chaque le membre ou route: /member//{id}

- Ajout d'un neauveau plantcatalogue (inventaire) pour un membre bien déterminé: bouton add new PlantCatalogue dans la fiche du membre ou route: /plant/catalogue/new/{id} c'est id correspondant au membre 

-Ajout d'un Plant (objet) en fonction du plantcatalogue (inventaire): aprés navigation d'un plantcatalogue bien particuler comme
suit (Plant Catégories -> Show -> add new Plant) ou bien route: /plant/catalogue/new/{id} c'est l'id correspondant à l'inventaire dont on souhaite l'ajouter un objet
 
