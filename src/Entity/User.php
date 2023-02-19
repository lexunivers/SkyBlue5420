<?php 
namespace App\Entity;


use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Sonata\UserBundle\Entity\BaseUser;
use Sonata\UserBundle\Model\UserInterface;
use App\Repository\UserRepository;

use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;


/**
 * @ORM\Entity
 * @ORM\Table(name="user")
 * @Vich\Uploadable
 * @UniqueEntity(fields="firstname", fields="lastname", fields="email")
 */

class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    protected $id;


    public function getId(): ?int
    {
        return $this->id;
    }

    /**
    * @ORM\Column(type="string", length= 255, nullable=true)
    */ 
    private $resetToken = null;

    public function getResetToken(): ?string
    {
        return $this->resetToken;
    }

    public function setResetToken(string $resetToken): self
    {
        $this->resetToken = $resetToken;

        return $this;
    }

    /**
    * @ORM\Column(type="datetime", nullable=true)
    */
	private ?\DateTimeInterface $dateOfBirth = null;

    public function getDateOfBirth(): ?\DateTimeInterface
    {
        return $this->dateOfBirth;
    }

    public function setDateOfBirth(?\DateTimeInterface $dateOfBirth): self
    {
        $this->dateOfBirth = $dateOfBirth;

        return $this;
    }



    /**
    * @ORM\Column(type="datetime")
    */
    private $updatedAt2;
    
    
    public function getUpdatedAt2()
    {
        return $this->updatedAt2;
    }

    public function setUpdatedAt2(\DateTimeInterface $updatedAt2 = null)
    {
        $this->updatedAt2 = $updatedAt2;

        return $this;
    }

    public function __construct()
    {
        //parent::__construct();        
        $this->updatedAt2 = new \DateTime('now');
    }

    /**
     * @var File
     * @Assert\File(mimeTypes={ "image/png", "image/jpeg", "image/jpg" })
     * @Vich\UploadableField(mapping="uploads", fileNameProperty="imageName")
     */
    private $imageFile;

    /**
     * @var string |null
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $imageName;

    /**
     * Set imageFile
     *
     * @param File|UploadedFile $imageFile
     *
     * @return Post
     */
    public function setImageFile(File $imageFile = null)
    {
        $this->imageFile = $imageFile;
        if ($this->imageFile instanceof UploadedFile) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt2 = new \DateTime('now');
        }

        return $this;
    }

    /**
     * Get imageFile
     *
     * @return File|UploadedFile
     */
    public function getImageFile()
    {
        return $this->imageFile;
    }

    /**
     * Set imageName
     *
     * @param string $imageName
     *
     * @return Post
     */
    public function setImageName($imageName)
    {
        $this->imageName = $imageName;

        return $this;
    }

    /**
     * Get imageName
     *
     * @return string
     */
    public function getImageName()
    {
        return $this->imageName;
    }


    /**
    * @ORM\Column(type="string", length=64, nullable=true)
    */
    protected $residence;
    
    /**
    * @ORM\Column(type="string", length=64, nullable=true)
    */
    protected $rue;

    /**
     * Set rue.
     *
     * @param string|null $rue
     *
     * @return User
     */
    public function setRue($rue = null)
    {
        $this->rue = $rue;

        return $this;
    }

    /**
     * Get rue.
     *
     * @return string|null
     */
    public function getRue()
    {
        return $this->rue;
    }
    
    /**
    * @ORM\Column(type="string", length=64, nullable=true)
    */
    protected $codepostal;
    
    /**
    * @ORM\Column(type="string", length=64, nullable=true)
    */
    protected $ville;

    /**
    * @ORM\Column(type="string", length=64, nullable=true)
    */
    protected $pays;

    /**
    * @ORM\Column(type="string", length=64, nullable=true)
    */
    protected $job;
    
    /**
    * @ORM\Column(type="string", length=64, nullable=true)
    */
    protected $hobby;

    /**
    * @ORM\Column(type="string", length=64, nullable=true)
    */
    protected $numero;
	
    /**
    * @ORM\Column(type="string", length=64, nullable=true)
    */
    protected $phone;

    /**
     * @var string|null
     *
     * @ORM\Column(name="timezone", type="string", length=64, nullable=true)
     */
     protected $timezone;
     
    /**
     * @var string|null
     *
     * @ORM\Column(name="locale", type="string", length=8, nullable=true)
     */
    protected $locale;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isVerified = false;

    public function setIsVerified(bool $isVerified): self
    {
        $this->isVerified = $isVerified;

        return $this;
    }

    public function getIsVerified(): ?bool
    {
        return $this->isVerified;
    }



    public function getTimezone(){
        return $this->timezone;
    }
 
    public function setTimezone($timezone){
        $this->timezone=$timezone;
        return $this;
    }
     
    public function getLocale(){
        return $this->locale;
    }
     
    public function setLocale($locale){
        $this->locale=$locale;
        return $this;
    }	
	
	
    /**
     * Set phone.
     *
     * @param string|null $phone
     *
     * @return User
     */
    public function setPhone($phone = null)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get phone.
     *
     * @return string|null
     */
    public function getPhone()
    {
        return $this->phone;

    }	
	

    /**
     * Set residence.
     *
     * @param string|null $residence
     *
     * @return User
     */
    public function setResidence($residence = null)
    {
        $this->residence = $residence;

        return $this;
    }

    /**
     * Get residence.
     *
     * @return string|null
     */
    public function getResidence()
    {
        return $this->residence;
    }

    /**
    * @ORM\Column(type="string", length=64, nullable=true)
    */
    protected $firstname;

    /**
     * Set firstname.
     *
     * @param string|null $rue
     *
     * @return User
     */
    public function setFirstname($firstname = null)
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * Get firstname.
     *
     * @return string|null
     */
    public function getFirstname()
    {
        return $this->firstname;
    }
	
    /**
    * @ORM\Column(type="string", length=64, nullable=true)
    */
    protected $lastname;
    	   
    /**
     * Set lastname.
     *
     * @param string|null $rue
     *
     * @return User
     */
    public function setLastname($lastname = null)
    {
        $this->lastname = $lastname;

        return $this;
    }

    /**
     * Get lastname.
     *
     * @return string|null
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * Set codepostal.
     *
     * @param string|null $codepostal
     *
     * @return User
     */
    public function setCodepostal($codepostal = null)
    {
        $this->codepostal = $codepostal;

        return $this;
    }

    /**
     * Get codepostal.
     *
     * @return string|null
     */
    public function getCodepostal()
    {
        return $this->codepostal;
    }

    /**
     * Set ville.
     *
     * @param string|null $ville
     *
     * @return User
     */
    public function setVille($ville = null)
    {
        $this->ville = $ville;

        return $this;
    }

    /**
     * Get ville.
     *
     * @return string|null
     */
    public function getVille()
    {
        return $this->ville;
    }

    /**
     * Set pays.
     *
     * @param string|null $pays
     *
     * @return User
     */
    public function setPays($pays = null)
    {
        $this->pays = $pays;

        return $this;
    }

    /**
     * Get pays.
     *
     * @return string|null
     */
    public function getPays()
    {
        return $this->pays;
    }

    /**
     * Set job.
     *
     * @param string|null $job
     *
     * @return User
     */
    public function setJob($job = null)
    {
        $this->job = $job;

        return $this;
    }

    /**
     * Get job.
     *
     * @return string|null
     */
    public function getJob()
    {
        return $this->job;
    }

    /**
     * Set hobby.
     *
     * @param string|null $hobby
     *
     * @return User
     */
    public function setHobby($hobby = null)
    {
        $this->hobby = $hobby;

        return $this;
    }

    /**
     * Get hobby.
     *
     * @return string|null
     */
    public function getHobby()
    {
        return $this->hobby;
    }

    /**
     * Set numero.
     *
     * @param string|null $numero
     *
     * @return User
     */
    public function setNumero($numero = null)
    {
        $this->numero = $numero;

        return $this;
    }

    /**
     * Get numero.
     *
     * @return string|null
     */
    public function getNumero()
    {
        return $this->numero;
    }

    /**
     * @ORM\OneToOne(targetEntity=Comptepilote::class, mappedBy="pilote", cascade={"persist", "remove"})
    */
    private $comptepilote;

  
	public function getComptepilote(): ?Comptepilote
                         {
                             return $this->comptepilote;
                         }

    public function setComptepilote(?Comptepilote $comptepilote): self
    {
        // unset the owning side of the relation if necessary
        if ($comptepilote === null && $this->comptepilote !== null) {
            $this->comptepilote->setPilote(null);
        }

        // set the owning side of the relation if necessary
        if ($comptepilote !== null && $comptepilote->getPilote() !== $this) {
            $comptepilote->setPilote($this);
        }

        $this->comptepilote = $comptepilote;

        return $this;
    }

    public function isIsVerified(): ?bool
    {
        return $this->isVerified;
    }
}