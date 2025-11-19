<?php
namespace App\Entity;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\ORM\Mapping\Table;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\OneToOne;
use Doctrine\ORM\Mapping\JoinColumn;

#[Entity]
#[Table(name: 'utilisateur')]
class Utilisateur
{
    #[Id, Column(type: 'integer'), GeneratedValue]//id : nom en bdd de la propriété, type : type de données
    private int|null $id = null;

    #[Column(type: 'string', length: 255)]
    private string $nomUtilisateur;

    #[Column(type: 'string', length: 255)]
    private string $motDePasseHash;

    #[ManyToOne(targetEntity: CategorieUtilisateur::class, inversedBy: 'utilisateurs')]
    private CategorieUtilisateur $categorieUtilisateur;

    public function __construct(string $nomUtilisateur, string $motDePasseHash)
    {
        $this->nomUtilisateur = $nomUtilisateur;
        $this->motDePasseHash = $motDePasseHash;
    }
    public function getId(): int|null
    {
        return $this->id;
    }
    public function getNomUtilisateur(): string
    {
        return $this->nomUtilisateur;
    }
    public function setNomUtilisateur(string $nomUtilisateur): void
    {
        $this->nomUtilisateur = $nomUtilisateur;
    }
    public function getMotDePasseHash(): string
    {
        return $this->motDePasseHash;
    }
    public function setMotDePasseHash(string $motDePasseHash): void
    {
        $this->motDePasseHash = $motDePasseHash;
    }

    public function getCategorieUtilisateur(): CategorieUtilisateur
    {
        return $this->categorieUtilisateur;
    }
    public function setCategorieUtilisateur(CategorieUtilisateur $categorieUtilisateur): void
    {
        $this->categorieUtilisateur = $categorieUtilisateur;
    }
}
