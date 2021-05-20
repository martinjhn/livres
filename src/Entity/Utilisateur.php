<?php

namespace App\Entity;

use App\Repository\UtilisateurRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass=UtilisateurRepository::class)
 * @UniqueEntity(fields={"email"}, message="There is already an account with this email")
 */
class Utilisateur implements UserInterface
{
	/**
	 * @ORM\Id
	 * @ORM\GeneratedValue
	 * @ORM\Column(type="integer")
	 */
	private $id;

	/**
	 * @ORM\Column(type="string", length=180, unique=true)
	 */
	private $email;

	/**
	 * @ORM\Column(type="json")
	 */
	private $roles = [];

	/**
	 * @var string The hashed password
	 * @ORM\Column(type="string")
	 */
	private $password;
	/**
	 * @ORM\Column(type="string", length=255)
	 */
	private $nom;

	/**
	 * @ORM\Column(type="string", length=255)
	 */
	private $prenom;

	/**
	 * @ORM\Column(type="string", length=255)
	 */
	private $adresse;

	/**
	 * @ORM\Column(type="string", length=255)
	 */
	private $tel;
	private $confirm;
	/**
	 * @ORM\OneToMany(targetEntity=Emprunt::class, mappedBy="emprunteur")
	 */
	private $emprunts;

	public function __construct()
      	{
      		$this->emprunts = new ArrayCollection();
      	}

	public function getId(): ?int
      	{
      		return $this->id;
      	}

	public function getEmail(): ?string
      	{
      		return $this->email;
      	}

	public function setEmail(string $email): self
      	{
      		$this->email = $email;
      
      		return $this;
      	}

	/**
	 * A visual identifier that represents this user.
	 *
	 * @see UserInterface
	 */
	public function getUsername(): string
      	{
      		return (string) $this->email;
      	}

	/**
	 * @see UserInterface
	 */
	public function getRoles(): array
      	{
      		$roles = $this->roles;
      		// guarantee every user at least has ROLE_USER
      		$roles[] = 'ROLE_USER';
      
      		return array_unique($roles);
      	}

	public function setRoles(array $roles): self
      	{
      		$this->roles = $roles;
      
      		return $this;
      	}

	/**
	 * @see UserInterface
	 */
	public function getPassword(): string
      	{
      		return $this->password;
      	}

	public function setPassword(string $password): self
      	{
      		$this->password = $password;
      
      		return $this;
      	}

	/**
	 * Returning a salt is only needed, if you are not using a modern
	 * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
	 *
	 * @see UserInterface
	 */
	public function getSalt(): ?string
      	{
      		return null;
      	}

	/**
	 * @see UserInterface
	 */
	public function eraseCredentials()
      	{
      		// If you store any temporary, sensitive data on the user, clear it here
      		// $this->plainPassword = null;
      	}
	public function getConfirm(): ?string
      	{
      		return $this->confirm;
      	}

	public function setConfirm(string $confirm): self
      	{
      		$this->confirm = $confirm;
      
      		return $this;
      	}

	/**
	 * @return Collection|Emprunt[]
	 */
	public function getEmprunts(): Collection
      	{
      		return $this->emprunts;
      	}

	public function addEmprunt(Emprunt $emprunt): self
      	{
      		if (!$this->emprunts->contains($emprunt)) {
      			$this->emprunts[] = $emprunt;
      			$emprunt->setEmprunteur($this);
      		}
      
      		return $this;
      	}

	public function removeEmprunt(Emprunt $emprunt): self
      	{
      		if ($this->emprunts->removeElement($emprunt)) {
      			// set the owning side to null (unless already changed)
      			if ($emprunt->getEmprunteur() === $this) {
      				$emprunt->setEmprunteur(null);
      			}
      		}
      
      		return $this;
      	}

	public function getNom(): ?string
      	{
      		return $this->nom;
      	}

	public function setNom(string $nom): self
      	{
      		$this->nom = $nom;
      
      		return $this;
      	}

	public function getPrenom(): ?string
      	{
      		return $this->prenom;
      	}

	public function setPrenom(string $prenom): self
      	{
      		$this->prenom = $prenom;
      
      		return $this;
      	}

	public function getAdresse(): ?string
      	{
      		return $this->adresse;
      	}

	public function setAdresse(string $adresse): self
      	{
      		$this->adresse = $adresse;
      
      		return $this;
      	}

	public function getTel(): ?string
      	{
      		return $this->tel;
      	}

	public function setTel(string $tel): self
      	{
      		$this->tel = $tel;
      
      		return $this;
      	}
}
